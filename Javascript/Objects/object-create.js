var ItemParent = function () {
  var settings = {};
};

ItemParent.prototype.get = function (prop) {
  return this.settings[prop];
};

ItemParent.prototype.getLabel = function () {
  return this.settings['label'];
};

ItemParent.prototype.getId = function () {
  return this.settings['id'];
};

ItemParent.prototype.setLabel = function (value) {
  this.settings['label'] = value;
};

ItemParent.prototype.init = function (settings) {
  this.settings = settings;
};

function ItemChild() {
  ItemParent.call(this);
}

ItemChild.prototype = Object.create(ItemParent.prototype);
ItemChild.prototype.constructor = ItemChild;

function doObjectCreate(e) {
  e.preventDefault();

  var item = new ItemChild();
  console.log('doObjectCreate: Is item an instance of ItemChild?', item instanceof ItemChild);
  console.log('doObjectCreate: Is item an instance of ItemParent?', item instanceof ItemParent);
  item.init({
    id: 1,
    label: 'Item new',
    foo: 'bar',
  });  
  console.log('doObjectCreate: label = ' + item.getLabel());
  console.log('doObjectCreate: foo = ' + item.get('foo'));  
  item.setLabel('Item changed');
  console.log('doObjectCreate: label = ' + item.getLabel());
}