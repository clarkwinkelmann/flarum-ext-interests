import {extend} from 'flarum/extend';
import app from 'flarum/app';
import Model from 'flarum/Model';
import User from 'flarum/models/User';
import UserControls from 'flarum/utils/UserControls';
import Button from 'flarum/components/Button';
import Interest from './models/Interest';
import InterestBadge from './components/InterestBadge';
import UserInterestsModal from './components/UserInterestsModal';

app.initializers.add('clarkwinkelmann-interests', () => {
    app.store.models['clarkwinkelmann-interests'] = Interest;

    User.prototype.interests = Model.hasMany('interests');

    extend(User.prototype, 'badges', function (items) {
        const interests = this.interests();

        if (interests) {
            interests.forEach(interest => {
                items.add('interest' + interest.id(), InterestBadge.component({interest}));
            });
        }
    });

    extend(UserControls, 'userControls', (items, user) => {
        if (!user.attribute('canEditInterests')) {
            return;
        }

        items.add('clarkwinkelmann-interests', Button.component({
            icon: 'fas fa-network-wired',
            onclick() {
                app.modal.show(UserInterestsModal, {user});
            },
        }, app.translator.trans('clarkwinkelmann-interests.forum.user_controls.edit')));
    });
});
