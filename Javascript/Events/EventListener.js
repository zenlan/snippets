var EventListener = function () {
  this.events = []; 
};

EventListener.prototype.get = function (prop) {
  return 'EventListener';
};

EventListener.prototype.on = function (event, fn) {
  this.events[event] = this.events[event] || [];
  this.events[event].push(fn);
};

EventListener.prototype.fire = function (event, obj) {
  if (this.events[event]) {
    this.events[event].forEach(function (fn) {
      fn(obj);
    })
  }
};
var ccListener = new EventListener();
