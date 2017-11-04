function getItem(e) {
  e.preventDefault();
  var idx = Math.round((Math.random() + 1) * 10);
  var params = {
    id: idx,
    label: 'item #' + idx,
    foo: 'bar ' + idx
  };
  ccCollection.addItem(idx, params);
}

function pingItem(e) {
  e.preventDefault();
  ccListener.fire('item:foo', ccListener);
  setTimeout(function () {
    showPingResult(ccResultBag.toString('<br />'));
  }, 1000);
}
