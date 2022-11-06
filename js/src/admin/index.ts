import app from 'flarum/admin/app';
import {extend} from 'flarum/common/extend';
import SessionDropdown from 'flarum/admin/components/SessionDropdown';
import LinkButton from 'flarum/common/components/LinkButton';
import Separator from 'flarum/common/components/Separator';

app.initializers.add('clarkwinkelmann-meilisearch-dashboard', () => {
    app.extensionData.for('clarkwinkelmann-meilisearch-dashboard')
        .registerPermission({
            permission: 'meilisearch-dashboard.access',
            label: app.translator.trans('clarkwinkelmann-meilisearch-dashboard.admin.permission.access'),
            icon: 'fas fa-search',
        }, 'moderate');


    extend(SessionDropdown.prototype, 'items', function (items) {
        items.add('meilisearch-dashboard', LinkButton.component({
            icon: 'fas fa-search',
            href: app.forum.attribute('baseUrl') + '/meilisearch/',
            external: true,
        }, app.translator.trans('clarkwinkelmann-meilisearch-dashboard.admin.header.link')));

        // Add a separator between links and logout button, just like in the forum frontend
        // Flamarkt Backoffice does the same thing
        if (!items.has('separator')) {
            items.add('separator', Separator.component(), -90);
        }
    });
});
