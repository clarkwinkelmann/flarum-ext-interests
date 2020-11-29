import app from 'flarum/app';
import Modal from 'flarum/components/Modal';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import EditInterestRow from './EditInterestRow';

/* global m */

export default class SettingsModal extends Modal {
    oninit(vnode) {
        super.oninit(vnode);

        this.interests = null;

        app.request({
            method: 'GET',
            url: app.forum.attribute('apiUrl') + '/interests',
        }).then(response => {
            this.interests = app.store.pushPayload(response);
            m.redraw();
        });
    }

    className() {
        return 'InterestSettingsModal';
    }

    title() {
        return app.translator.trans('clarkwinkelmann-interests.admin.settings.title');
    }

    content() {
        if (this.interests === null) {
            return m('.Modal-body', LoadingIndicator.component());
        }

        return m('.Modal-body', m('table', m('tbody', [
            ...this.interests.map((interest, index) => m(EditInterestRow, {
                key: interest.id(),
                interest,
                ondelete: () => {
                    this.interests.splice(index, 1);
                },
            })),
            m(EditInterestRow, {
                key: 'new',
                onsave: interest => {
                    this.interests.push(interest);
                },
            }),
        ])));
    }
}
