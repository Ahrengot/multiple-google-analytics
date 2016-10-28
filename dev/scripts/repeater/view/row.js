import _ from 'underscore'
import Backbone from 'backbone'
import Template from '../template/repeater-row'

export default Backbone.View.extend({
  tagName: 'tr',
  className: 'ahr-repeater-row',
  events: {
    // "click .row-value": 'setEditState',
    // "blur input": 'setReadState',
    "click .btn-delete": 'delete',
    "keyup input": 'updateValue'
  },
  initialize() {
    this.template = _.template(Template);
    this.render();
    this.listenTo(this.model, 'change', this.render);
    this.listenTo(this.model, 'destroy', this.destroy);
  },
  setEditState() {
    this.model.set('state', 'edit');
  },
  setReadState() {
    this.model.set('state', 'read');
  },
  delete(e) {
    e.preventDefault();
    this.model.destroy();
  },
  updateValue(e) {
    switch (e.keyCode) {
      case 27: // esc
      case 13: // enter
        e.preventDefault(); // Prevent form submission
        // this.model.set('state', 'read');
        break;
      default:
        this.model.set({value: e.target.value}, {silent: true});
    }
  },
  render() {
    const html = this.template(this.model.toJSON());
    this.el.innerHTML = html;
    // Maybe focus input
    if (this.model.get('focused')) {
      // Defer to next frame to ensure this view is rendered in parent view
      _.defer(() => {
        this.el.querySelector('input').focus();
      })
    }
  },
  destroy() {
    this.stopListening();
  }
})