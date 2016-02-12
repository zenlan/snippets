(function($) {

  $(document).ready(function() {

    var value = Drupal.settings.zenlan.value;
    
    $('#field1').val(value);
    alert($('#field1').val());

  });
})(jQuery);