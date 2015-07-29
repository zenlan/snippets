function addModel() {
  var i = 0, name = '', zm = {}, exists = true;
  while (exists && i++ <= zCollection.max - 1) {
    var name = 'model-' + i;
    var zm = zCollection.findWhere({
      name: name
    });
    if (typeof zm === 'undefined') {
      console.log('Adding Model ' + name);
      zCollection.add({
        name: name,
      });
      zTmp = new zdView;

      return;
    }
  }
  alert('Maximum models added');
}

jQuery(document).ready(function($) {
  
//  zCollection.max = document.getElementById('max-models').value;
//  $('#btn-add').on('click', addModel);
});
