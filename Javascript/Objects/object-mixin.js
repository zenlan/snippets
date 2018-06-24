var ItemParent1 = function () {};

ItemParent1.prototype.getFoo = function () {
  return 'foo';
};

var ItemParent2 = function () {};

ItemParent2.prototype.getBar = function () {
  return 'bar';
};

function ItemChildMixin() {
  ItemParent1.call(this);
  ItemParent2.call(this);
}

function doObjectMixin(e) {
  e.preventDefault();

  ItemChildMixin.prototype = Object.create(ItemParent1.prototype);

  Object.assign(ItemChildMixin.prototype, ItemParent2.prototype);

  ItemChildMixin.prototype.constructor = ItemChildMixin;

  var item = new ItemChildMixin();
  console.log('doObjectMixin: Is item an instance of ItemChild?', item instanceof ItemChildMixin);
  console.log('doObjectMixin: Is item an instance of ItemParent1?', item instanceof ItemParent1);
  console.log('doObjectMixin: Is item an instance of ItemParent2?', item instanceof ItemParent2);
  console.log('doObjectMixin: ' + item.getFoo());
  console.log('doObjectMixin: ' + item.getBar());
}