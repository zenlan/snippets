var uniqueID = (function () {
  var id = 100;
  return function () {
    return id++;
  };
})();

var getItemObj = (function (idx, params) {
  console.log(idx);
  var items = [];
  if (!idx) {
    idx = uniqueID();
  }
  return function (idx, params) {
    if (items[idx] == undefined) {
      console.log('NEW ' + idx);
      item = new ItemChild();
      console.log('getItemObj: Is item an instance of ItemChild?', item instanceof ItemChild);
      item.init(params);
      items[idx] = item;
    } else {
      console.log('FOUND ' + idx);
    }
    return items[idx];
  };
})();

function getItem(e) {
  e.preventDefault();
  var idx = Math.round(Math.random(1, 9) * 10);
  var params = {
    id: idx,
    label: 'label' + idx,
    foo: 'bar ' + idx,
  };
  var item = getItemObj(idx, params);
  console.log('Returned item id: ' + item.getId());
  console.log('Returned item label: ' + item.getLabel());
  console.log('Returned item foo: ' + item.getId());
}
