define(['require', 'jquery', 'elgg'], function(require, $, elgg) {
    
    if ($('input[name="rssmanualimport"]').length) {
        $('#rssimport_control_box').show();
    }
    else {
        $('#rssimport_nothing_to_import').show();
    }

    $('.rssimport-formtoggle').click(function(event) {
        event.preventDefault();
        $('#createrssimportform').slideToggle();
    });

    $('.rssimport_toggleupdate').click(function(event) {
        event.preventDefault();
        $('#rssimport_updateform').slideToggle();
    });

    $('#rssimport-checkalltoggle').click(function(event) {
        if ($(this).is(':checked')) {
            $('input[name="rssmanualimport"]').each(function(index, item) {
                var val = $(item).val();

                $(item).attr('checked', 'checked');
                if (!$('.rssimport-feeditems input[value="' + val + '"]').length) {
                    var input = '<input type="hidden" name="feeditems[]" value="' + val + '">';
                    $('.rssimport-feeditems').append(input);
                }
            });
        }
        else {
            $('input[name="rssmanualimport"]').removeAttr('checked');
            // remove all ids
            $('.rssimport-feeditems').html('');
        }

    });

    $('input[name="rssmanualimport"]').click(function(event) {
        var val = $(this).val();
        if ($(this).is(':checked')) {
            if (!$('.rssimport-feeditems input[value="' + val + '"]').length) {
                var input = '<input type="hidden" name="feeditems[]" value="' + val + '">';
                $('.rssimport-feeditems').append(input);
            }
        }
        else {
            $('.rssimport-feeditems input[value="' + val + '"]').remove();
        }

    });

    $('.rssimport-excerpt-toggle').click(function(event) {
        var id = $(this).attr('data-id');

        $('#rssimport_content' + id).toggle();
        $('#rssimport_excerpt' + id).toggle();
    });


    // toggle 'never import'
    $('.rssimport-disable').click(function(event) {
        event.preventDefault();

        var id = $(this).attr('data-item');
        var feedid = $(this).attr('data-guid');
        var method = 'delete';

        if ($('#rssimport-item-' + id).hasClass('rssimport_blacklisted')) {
            method = 'undelete';
        }


        $('#rssimport-item-' + id + ' .elgg-ajax-loader').removeClass('hidden');

        elgg.action("rssimport/blacklist", {
            data: {
                id: id,
                feedid: feedid,
                method: method
            },
            success: function(response) {
                if (method == 'delete') {
                    $('#rssimport-item-' + id).addClass('rssimport_blacklisted');
                    $('#checkbox-' + id).attr('checked', false);
                    $('#checkbox-' + id).attr('class', 'rssimport-checkbox-disabled');
                    $('#checkbox-' + id).attr('name', 'rssmanualimportblacklisted');
                    $('#checkbox-' + id).attr('disabled', 'disabled');
                    $('#rssimport-disable-' + id).text(elgg.echo('rssimport:undelete'));
                }
                else {
                    $('#rssimport-item-' + id).removeClass('rssimport_blacklisted');
                    $('#checkbox-' + id).attr('checked', false);
                    $('#checkbox-' + id).attr('class', 'rssimport-checkbox-active');
                    $('#checkbox-' + id).attr('name', 'rssmanualimport');
                    $('#checkbox-' + id).attr('disabled', false);
                    $('#rssimport-disable-' + id).text(elgg.echo('rssimport:delete'));
                }

                $('#rssimport-item-' + id + ' .elgg-ajax-loader').addClass('hidden');
            },
            fail: function() {
                elgg.register_error(elgg.echo('rssimport:error:ajax'));
            }
        });
    });
});

