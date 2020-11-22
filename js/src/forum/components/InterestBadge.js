import Badge from 'flarum/components/Badge';

export default class InterestBadge extends Badge {
    static initAttrs(attrs) {
        super.initAttrs(attrs);

        if (attrs.interest) {
            attrs.icon = attrs.interest.icon();
            attrs.style = {backgroundColor: attrs.interest.color()};
            attrs.label = attrs.interest.name();
            attrs.type = 'interest--' + attrs.interest.id();

            delete attrs.interest;
        }
    }
}
