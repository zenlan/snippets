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

function addBatch(e) {
  e.preventDefault();
  for (var idx = 0; idx < 10; idx++) {
    var params = {
      id: idx,
      label: 'item #' + idx,
      foo: 'bar ' + idx
    };
    ccCollection.addItem(idx, params);
  }
}

function pingItem(e) {
  e.preventDefault();
  showWaiting();
  ccListener.fire('item:foo', ccListener);
  setTimeout(function () {
    showResult(ccResultBag.toString('<br />'));
  }, 1000);
}

function doWork(e) {
  e.preventDefault();
  showWaiting();
  ccListener.fire('collectResults', ccListener);
  setTimeout(function () {
    showResult(ccResultBag.toString('<br />'));
  }, 10000);
}
