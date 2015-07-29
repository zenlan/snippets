App.PageHeader = Backbone.View.extend({
  el: '',
  events: {
    "click #btn-add": "doAdd"
  },
  initialize: function(attributes, options) {
    App.log('PageHeader initialize');
    App.deckCollection = new App.DeckCollection({ 
      max: this.$('#max-models').text() 
    });        
    this.updateCounter();
    this.listenTo(App.deckCollection, 'updateCounter', this.updateCounter);
  },
  doAdd: function(event) {
    var i = 0, name = '', deckModel = {}, deckView = {}, exists = true;
    while (exists && i++ <= App.deckCollection.max - 1) {
      name = 'model-' + i;
      deckModel = App.deckCollection.findWhere({
        name: name
      });
      if (typeof deckModel === 'undefined') {
        App.log('Adding Model ' + name);
        App.deckCollection.add({
          name: name,
        });
        deckModel = App.deckCollection.findWhere({
          name: name
        });
        deckView = new App.DeckView({
          model: deckModel,
          name: 'view-' + i
        });
        this.$('#content').append(deckView.render().el);
        this.updateCounter();
        return;
      }
    }
    App.log('Maximum models added');
  },
  updateCounter: function() {
    this.$('#count-models').text(App.deckCollection.numModels());
  }
});