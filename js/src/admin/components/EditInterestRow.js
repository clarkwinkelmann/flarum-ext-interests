import app from 'flarum/app';
import Button from 'flarum/components/Button';
import extractText from 'flarum/utils/extractText';

/* global m */

export default class EditInterestRow {
    oninit(vnode) {
        const {interest} = vnode.attrs;

        this.name = interest ? interest.name() : '';
        this.color = interest ? interest.color() : '';
        this.icon = interest ? interest.icon() : '';
        this.dirty = false;
        this.loadingSave = false;
        this.loadingDelete = false;
    }

    view(vnode) {
        const {interest} = vnode.attrs;

        return m('tr', [
            m('td', m('input.FormControl', {
                type: 'text',
                value: this.name,
                onchange: event => {
                    this.name = event.target.value;
                    this.dirty = true;
                },
                placeholder: app.translator.trans('clarkwinkelmann-interests.admin.settings.fields.name'),
            })),
            m('td', m('input.FormControl', {
                type: 'color',
                value: this.color,
                onchange: event => {
                    this.color = event.target.value;
                    this.dirty = true;
                },
                placeholder: app.translator.trans('clarkwinkelmann-interests.admin.settings.fields.color'),
            })),
            m('td', m('input.FormControl', {
                type: 'text',
                value: this.icon,
                onchange: event => {
                    this.icon = event.target.value;
                    this.dirty = true;
                },
                placeholder: app.translator.trans('clarkwinkelmann-interests.admin.settings.fields.icon'),
            })),
            m('td', Button.component({
                className: 'Button Button--icon Button--primary',
                title: app.translator.trans('clarkwinkelmann-interests.admin.settings.save'),
                icon: this.loadingSave ? 'fas fa-spinner fa-pulse' : 'fas fa-save',
                disabled: !this.dirty || this.loadingSave || this.loadingDelete,
                onclick: () => {
                    this.loadingSave = true;

                    const saveInterest = interest || app.store.createRecord('interests');

                    saveInterest.save({
                        name: this.name,
                        color: this.color,
                        icon: this.icon,
                    }).then(response => {
                        this.loadingSave = false;
                        this.dirty = false;

                        if (!interest) {
                            vnode.attrs.onsave(response);
                            this.name = '';
                            this.color = '';
                            this.icon = '';
                        }

                        m.redraw();
                    }).catch(error => {
                        this.loadingSave = false;
                        m.redraw();

                        throw error;
                    });
                },
            })),
            m('td', interest ? Button.component({
                className: 'Button Button--icon Button--danger',
                title: app.translator.trans('clarkwinkelmann-interests.admin.settings.delete'),
                icon: this.loadingDelete ? 'fas fa-spinner fa-pulse' : 'fas fa-times',
                disabled: this.loadingSave || this.loadingDelete,
                onclick: () => {
                    if (!confirm(extractText(app.translator.trans('clarkwinkelmann-interests.admin.settings.confirmDelete', {
                        name: interest.name(),
                    })))) {
                        return;
                    }

                    this.loadingDelete = true;

                    interest.delete().then(() => {
                        this.loadingDelete = false;

                        vnode.attrs.ondelete();

                        m.redraw();
                    }).catch(error => {
                        this.loadingDelete = false;
                        m.redraw();

                        throw error;
                    });
                },
            }) : null),
        ]);
    }
}
