import app from 'flarum/app';
import Modal from 'flarum/components/Modal';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import Button from 'flarum/components/Button';
import InterestBadge from './InterestBadge';

/* global m */

export default class UserInterestsModal extends Modal {
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

        const userInterests = this.attrs.user.interests();

        this.selectedInterests = userInterests ? userInterests.map(interest => interest.id()) : [];
    }

    title() {
        return app.translator.trans('clarkwinkelmann-interests.forum.modal.title');
    }

    className() {
        return 'UserInterestsModal Modal--small';
    }

    content() {
        return m('.Modal-body', this.form());
    }

    form() {
        if (this.interests === null) {
            return LoadingIndicator.component();
        }

        return [
            m('.Form-group', this.interests.map(interest => {
                const checked = this.selectedInterests.indexOf(interest.id()) !== -1;

                return m('label.checkbox', [
                    m('input', {
                        type: 'checkbox',
                        checked,
                        onchange: () => {
                            if (checked) {
                                this.selectedInterests = this.selectedInterests.filter(id => id !== interest.id());
                            } else {
                                this.selectedInterests.push(interest.id());
                            }
                        },
                    }),
                    InterestBadge.component({
                        interest,
                    }),
                    ' ',
                    interest.name(),
                ]);
            })),
            m('.Form-group', Button.component({
                className: 'Button Button--primary',
                type: 'submit',
                loading: this.loading,
            }, app.translator.trans('clarkwinkelmann-interests.forum.modal.submit'))),
        ];
    }

    onsubmit(e) {
        e.preventDefault();

        this.loading = true;

        this.attrs.user
            .save({
                relationships: {
                    interests: this.selectedInterests.map(id => app.store.getById('clarkwinkelmann-interests', id)),
                },
            }, {
                errorHandler: this.onerror.bind(this),
            })
            .then(this.hide.bind(this))
            .catch(() => {
                this.loading = false;
                m.redraw();
            });
    }
}
