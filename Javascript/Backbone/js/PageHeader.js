App.PageHeader = Backbone.View.extend({
  el: '',
  events: {
    "click #btn-add": "doAdd"
  },
  initialize: function(attributes, options) {
    App.log('PageHeader initialize');
  },
  doAdd: function(event) {
    var i = 1, name = '', deckModel = {}, deckView = {}, added = false;
    if (typeof App.deckCollection == 'undefined') {
      name = 'model-' + i;
      App.deckCollection = new App.DeckCollection({
        max: this.$('#max-models').text(),
        name: name
      });
      this.listenTo(App.deckCollection, 'updateCounter', this.updateCounter);
      added = true;
    } else {

      while (!added && i++ <= App.deckCollection.max - 1) {
        name = 'model-' + i;
        deckModel = App.deckCollection.findWhere({
          name: name
        });
        if (typeof deckModel === 'undefined') {
          App.log('Adding Model ' + name);
          App.deckCollection.add({
            name: name,
          });
          added = true;
        }
      }
    }
    if (added) {
      deckModel = App.deckCollection.findWhere({
        name: name
      });
      deckView = new App.DeckView({
        model: deckModel,
        name: 'view-' + i
      });
      this.$('#content').append(deckView.render().el);
      this.updateCounter();
    } else {
      App.log('Maximum models added');
    }
  },
  updateCounter: function() {
    this.$('#count-models').text(App.deckCollection.numModels());
  }
});