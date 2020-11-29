import {extend} from 'flarum/extend';
import app from 'flarum/app';
import PermissionGrid from 'flarum/components/PermissionGrid';
import ItemList from 'flarum/utils/ItemList';

app.initializers.add('clarkwinkelmann-interests', () => {
    extend(PermissionGrid.prototype, 'permissionItems', sections => {
        const items = new ItemList();

        items.add('editOwn', {
            icon: 'fas fa-network-wired',
            label: app.translator.trans('clarkwinkelmann-interests.admin.permissions.editOwn'),
            permission: 'clarkwinkelmann-interests.editOwn',
        });

        items.add('editAny', {
            icon: 'fas fa-network-wired',
            label: app.translator.trans('clarkwinkelmann-interests.admin.permissions.editAny'),
            permission: 'clarkwinkelmann-interests.editAny',
        });

        sections.add('clarkwinkelmann-interests', {
            label: app.translator.trans('clarkwinkelmann-interests.admin.permissions.heading'),
            children: items.toArray(),
        });
    });
});
