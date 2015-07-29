App.DeckCollection = Backbone.Collection.extend({
  model: App.DeckModel,
  max: 0,
  initialize: function(attributes, options) {
    App.log('DeckCollection initialize');
    this.max = attributes.max;
    this.on('add', function(model) {
      App.log('DeckCollection add');
    });
    this.on('remove', function(model) {
      App.log('DeckCollection remove');
      this.trigger('updateCounter');
    });
  },
  numModels: function() {
    return this.models.length - 1;
  }
});
