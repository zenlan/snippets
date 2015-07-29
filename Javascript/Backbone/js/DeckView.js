App.DeckView = Backbone.View.extend({
  tagName: "div",
  events: {
    "click": "doClick"
  },
  name: '',
  initialize: function(attributes, options) {
    this.name = attributes.name;
    App.log('DeckView initialize ' + this.name);    
    this.template = _.template($('#item-template').html());
    this.listenTo(this.model, 'change', this.render);
    this.listenTo(this.model, 'destroy', this.remove);
  },  
  doClick: function(event) {    
    App.log(this.name + ' clicked');
    this.model.destroy();        
  },
  render: function() {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  },
});