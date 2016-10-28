import _ from 'underscore'
import Backbone from 'backbone'
import RowModel from './row'

export default Backbone.Model.extend({
  defaults: {
    name: 'repeater',
    min: 1,
    max: 100,
    container: null,
    title: 'My Repeater',
    btnAdd: 'Add',
    btnDelete: 'Delete'
  },
  initialize(props) {
    // Set default placeholder if available
    if ( props.rowPlaceholder ) {
      RowModel.prototype.defaults.placeholder = props.rowPlaceholder;
    }

    if ( props.btnDelete ) {
      RowModel.prototype.defaults.deleteLabel = props.btnDelete;
    }

    // Convert array to collection
    const collection = new Backbone.Collection();
    collection.model = RowModel;
    if ( props.rows && _.isArray( props.rows ) ) {
      _.each(props.rows, (row, i) => collection.add({
        index: (i + 1),
        value: row
      }));
    }

    this.set('rows', collection);
  }
})