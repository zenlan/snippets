var Parent = function () {
};

Parent.prototype.init = function (settings) {
  this.settings = settings;
  return this;
};

Parent.prototype.get = function (prop) {
  if (this.settings === undefined) {
    this.settings = {};
  }
  return this.settings[prop];
};

Parent.prototype.set = function (key, value) {
  this.settings[key] = value;
  return this;
};

Parent.prototype.getFoo = function () {
  return 'NO';
};

Parent.prototype.getBar = function () {
  return 'NO';  
};

function Foo() {
  Parent.call(this);
}
Foo.prototype = Object.create(Parent.prototype);
Foo.prototype.constructor = Foo;
Foo.prototype.getFoo = function () {
  return 'FOO';  
};

function Bar() {
  Parent.call(this);
}
Bar.prototype = Object.create(Parent.prototype);
Bar.prototype.constructor = Bar;
Bar.prototype.getBar = function () {
  return 'BAR';  
};

function doOverload(e) {  
  e.preventDefault();
  var obj = new Foo().init({
    name: "Foo",
  });
  console.log('Foo.getFoo=' + obj.getFoo());
  console.log('Foo.getBar=' + obj.getBar());  
  var obj = new Bar().init({
    name: "Bar",
  });
  console.log('Bar.getFoo=' + obj.getFoo());
  console.log('Bar.getBar=' + obj.getBar());
}