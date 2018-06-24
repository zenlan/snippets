var ItemParent = function () {
};

ItemParent.prototype.listener = ccListener;

ItemParent.prototype.collection = ccCollection;

ItemParent.prototype.init = function (settings) {
  this.settings = settings;
  return this;
};

ItemParent.prototype.get = function (prop) {
  if (this.settings === undefined) {
    this.settings = {};
  }
  return this.settings[prop];
};

ItemParent.prototype.getCollection = function () {
  return this.collection;
};

ItemParent.prototype.getId = function () {
  return this.settings['id'];
};

ItemParent.prototype.getLabel = function () {
  return this.settings['label'];
};

ItemParent.prototype.setLabel = function (value) {
  this.settings['label'] = value;
};

ItemParent.prototype.collectResults = function (max) {
  var i = 0;
  var max = 3;
  var item = this;
  (function loop() {
    var rand = Math.round(Math.random() * (3000 - 500)) + 500;    
    if (i === max) {
      return;
    }
    i++;
    setTimeout(function () {
      ccResultBag.add(item.get('label') + ' result ' + i + '/' + max + ' : ' + new Date().toString());
      loop();
    }, rand);
  }());
};

function Item() {
  ItemParent.call(this);
}
Item.prototype = Object.create(ItemParent.prototype);
Item.prototype.constructor = Item;
