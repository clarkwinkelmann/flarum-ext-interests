import Model from 'flarum/Model';

export default class Interest extends Model {
    name = Model.attribute('name');
    color = Model.attribute('color');
    icon = Model.attribute('icon');
}
