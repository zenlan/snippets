(function ($) {
  $(document).ready(function () {

    $('#edit-id').hide();
    var api_url = Drupal.settings.zenlan.api_url;
    var selected = '';
    $("#edit-name").autocomplete({
      source: function (request, response) {
        var selected = '';
        var url = api_url + $.base64.encode(request.term).replace(/=/g, '_');
        $base = $(this.element);
        $base.addClass('throbbing');
        $.ajax({
          url: url,
          dataType: "json",
          success: function (data) {
            $base.removeClass('throbbing');
            response($.map(data, function (item) {
              return {
                label: item.label,
                value: item.value
              }
            }));
          },
          error: function (jqXHR, textStatus, errorThrown) {
            $base.removeClass('throbbing');
            console.log('autocomplete error ' + errorThrown);
          }
        });
      },
      minlength: 2,
      select: function (event, ui) {
        console.log(ui.item ?
                "Selected: " + ui.item.label :
                "Nothing selected, input was " + this.value);
        ui.item ? selected = ui.item : selected = false;
      },
      close: function () {
        if (selected) {
          $('#edit-id').val(selected.value);
          $('#edit-name').val(selected.label);
          $('#edit-id').show();
        }
      }
    });

  });
})(jQuery);