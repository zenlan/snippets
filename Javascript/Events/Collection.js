var CollectionParent = function () {
};

CollectionParent.prototype.listener = ccListener;

CollectionParent.prototype.init = function (settings) {
  this.settings = settings;
  this.items = [];
  return this;
};

CollectionParent.prototype.get = function (prop) {
  if (this.settings === undefined) {
    this.settings = {};
  }
  return this.settings[prop];
};

CollectionParent.prototype.getItems = function () {
  return this.items;
};

CollectionParent.prototype.putItem = function (item) {
  this.items.push(item);
};

CollectionParent.prototype.getItemById = function (id) {
  var result;
  this.items.forEach(function(item) {
    if (item.getId() === id) {
      result = item;      
    }
  });
  return result;
};

CollectionParent.prototype.addItem = function (id, params) {
  var items = this.getItems();
  var item = this.getItemById(id);
  if (item === undefined) {
    console.log('NEW ' + id);
    item = new Item().init(params);
    item.listener.on('collection:bar', function (e) {
      console.log(item.get('label') + ' received collection:bar event from ' + e.get('label'));
      ccResultBag.add('collection:bar__' + item.get('label'));
    });
    item.listener.on('collectResults', function (e) {
      console.log(item.get('label') + ' received collectResults event from ' + e.get('label'));
      item.collectResults(3);
    });
    this.putItem(item);    
  } else {
    console.log('FOUND ' + id);
  }
  return item;
};

function Collection() {
  CollectionParent.call(this);
}
Collection.prototype = Object.create(CollectionParent.prototype);
Collection.prototype.constructor = Collection;

ccCollection = new Collection().init({label: 'Collection'});
ccCollection.listener.on('item:foo', function (e) {
  console.log('Collection received item:foo event from ' + e.get('label'));
  ccCollection.listener.fire('collection:bar', ccCollection); 
});
