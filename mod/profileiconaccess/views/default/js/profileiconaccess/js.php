
$(document).ready( function() {
  
  $('#profileiconaccess-select').change( function() {
    $('.profileiconaccess-throbber .elgg-ajax-loader').removeClass('hidden');
    
    elgg.action("profileiconaccess", {
        data: {
          guid: elgg.get_page_owner_guid(),
          access: $('#profileiconaccess-select').val()
        },
        success: function(response) {
          $('.profileiconaccess-throbber .elgg-ajax-loader').addClass('hidden');
        },
        fail: function() {
          elgg.register_error(elgg.echo('profileiconaccess:error'));
        }
    });
  });
});