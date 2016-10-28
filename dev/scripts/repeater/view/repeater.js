import _ from 'underscore'
import Backbone from 'backbone'
import Template from '../template/repeater'
import RowView from './row'

export default Backbone.View.extend({
  className: 'ahr-repeater',
  events: {
    'click .btn-add': 'addRow'
  },
  initialize() {
    this.template = _.template(Template);
    this.render();

    this.listenTo(this.model.get('rows'), 'update', this.onUpdateRows);
  },
  addRow(e) {
    e.preventDefault();
    this.model.get('rows').add({
      index: this.model.get('rows').length,
      state: 'edit',
      focused: true
    })
  },
  render() {
    const html = this.template(this.model.toJSON());
    this.el.innerHTML = html;
    this.onUpdateRows();
  },
  onUpdateRows() {
    const rows = this.model.get('rows');

    // Ensure we never have less than *min* rows
    if ( rows.length < this.model.get('min') ) {
      const diff = this.model.get('min') - rows.length;
      _.times( diff, () => rows.add({}) )
    }

    // Ensure we never have more than *max* rows
    if ( rows.length > this.model.get('max') ) {
      const newRows = rows.slice(0, this.model.get('max'));
      rows.set(newRows);
    }

    this.renderRows();
  },
  renderRows() {
    const tbody = this.el.querySelector('tbody');
    if ( !tbody ) {
      return;
    }

    tbody.innerHTML = '';

    if ( !this.model.get('rows') ) {
      return;
    }

    this.model.get('rows').each((row, i) => {
      row.set({
        index:  i + 1,
        name: `${this.model.get('name')}-${(i + 1)}`
      });

      let view = new RowView({ model: row })
      tbody.appendChild(view.el);
    })
  }
})