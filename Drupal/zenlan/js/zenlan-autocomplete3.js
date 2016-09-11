(function ($) {

  $(document).ready(function () {

    var api_url = Drupal.settings.zenlan.api_url;

    var getMatches = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: api_url + "%QRY",
        dataType: 'json',
        wildcard: "%QRY"
      },
    });

    $('#edit-name.typeahead')
            .typeahead({
              hint: true,
              highlight: true,
              minLength: 2
            }
            , {
              name: 'tags',
              source: getMatches,
              templates: {
                empty: ['<div class="empty-message">&nbsp;No matches</div>']
              }
            });
  });
})(jQuery);