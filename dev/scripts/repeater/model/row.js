import Backbone from 'backbone'

export default Backbone.Model.extend({
  defaults: {
    index: 0,
    name: '',
    state: 'edit',
    value: '',
    focused: false,
    placeholder: '',
    deleteLabel: '',
  },
  initialize() {
    this.listenTo(this, 'change:state', (model, newState) => {
      this.set({
        focused: newState === 'edit'
      });
    })
  }
})