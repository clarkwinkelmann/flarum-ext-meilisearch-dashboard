<?php

namespace ClarkWinkelmann\MeilisearchDashboard;

use Flarum\Http\RequestUtil;
use Flarum\Settings\SettingsRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MeilisearchDashboardMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if (substr($path, 0, 13) !== '/meilisearch/') {
            return $handler->handle($request);
        }

        $actor = RequestUtil::getActor($request);
        $actor->assertCan('meilisearch-dashboard.access');

        $settings = resolve(SettingsRepositoryInterface::class);
        $key = $settings->get('clarkwinkelmann-scout.meilisearchKey');

        $headers = [];

        if ($key) {
            $headers['Authorization'] = "Bearer $key";
        }

        $contentType = $request->getHeaderLine('Content-Type');

        if ($contentType) {
            $headers['Content-Type'] = $contentType;
        }

        $host = explode(':', $settings->get('clarkwinkelmann-scout.meilisearchHost') ?: '127.0.0.1');

        $uri = (new Uri())
            ->withScheme('http')
            ->withHost($host[0])
            ->withPort(count($host) > 1 ? $host[1] : 7700)
            ->withPath(substr($path, 12))
            ->withQuery($request->getUri()->getQuery())
            ->withFragment($request->getUri()->getFragment());

        $response = (new Client())->request($request->getMethod(), $uri, [
            'headers' => $headers,
            'body' => $request->getBody(),
            'http_errors' => false,
        ]);

        $content = $response->getBody()->getContents();
        // Replace links to resources which don't include the subfolder
        $content = preg_replace('~(src|href)="/([^"]+\.(?:png|svg|js|json))"~', '$1="/meilisearch/$2"', $content);
        // Inject base path for use later
        $content = str_replace('</head><body>', '</head><body><script>window.FLARUM_ORIGIN=' . json_encode($request->getUri()->getScheme() . '://' . $request->getUri()->getHost() . '/meilisearch') . '</script>', $content);
        // Change the base URL in the compiled javascript otherwise API requests to go the root
        $content = str_replace('window.location.origin', 'window.FLARUM_ORIGIN  ' /* spaces to be same length for sourcemap */, $content);

        // Must convert string back to stream to attach to response
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        rewind($stream);

        return $response->withoutHeader('Content-Length')->withBody(new Stream($stream));
    }
}
