App.DeckModel = Backbone.Model.extend({
  name: '',
  initialize: function(attributes, options) {    
    this.name = attributes.name;
    App.log('DeckModel initialize ' + this.name);
  },
});