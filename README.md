# Meilisearch Dashboard

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/clarkwinkelmann/flarum-ext-meilisearch-dashboard/blob/master/LICENSE.md) [![Latest Stable Version](https://img.shields.io/packagist/v/clarkwinkelmann/flarum-ext-meilisearch-dashboard.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-meilisearch-dashboard) [![Total Downloads](https://img.shields.io/packagist/dt/clarkwinkelmann/flarum-ext-meilisearch-dashboard.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-meilisearch-dashboard) [![Donate](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.me/clarkwinkelmann)

This is a companion extension for [Scout](https://github.com/clarkwinkelmann/flarum-ext-scout).
It provides a proxied access to the Meilisearch HTTP dashboard through Flarum at `/meilisearch/`.
The Meilisearch credentials are read from Scout settings.

Access control is done through Flarum permissions.

Meilisearch only offers the dashboard when running in development mode.
In production mode, this extension will just proxy the error page.

## Installation

    composer require clarkwinkelmann/flarum-ext-meilisearch-dashboard

## Support

This extension is under **minimal maintenance**.

It was developed for a client and released as open-source for the benefit of the community.
I might publish simple bugfixes or compatibility updates for free.

You can [contact me](https://clarkwinkelmann.com/flarum) to sponsor additional features or updates.

Support is offered on a "best effort" basis through the Flarum community thread.

## Links

- [GitHub](https://github.com/clarkwinkelmann/flarum-ext-meilisearch-dashboard)
- [Packagist](https://packagist.org/packages/clarkwinkelmann/flarum-ext-meilisearch-dashboard)
- [Discuss](https://discuss.flarum.org/d/32151)
