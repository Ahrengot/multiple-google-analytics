import RepeaterView from './view/repeater';
import RepeaterModel from './model/repeater';

require('../../styles/table.css');
require('../../styles/repeater.css');

export default class Repeater {
  constructor(props) {
    this.view = new RepeaterView({ model: new RepeaterModel(props) });
    document.querySelector(props.container).appendChild( this.view.el );
  }
}