/** RESULTS **/
var ResultBag = function () {
  this.results = []; 
};

ResultBag.prototype.add = function (result) {
  this.results.push(result);
};

ResultBag.prototype.get = function () {
  return this.results;
};

ResultBag.prototype.toString = function (glue) {
  return this.results.join(glue);
};

var ccResultBag = new ResultBag();
