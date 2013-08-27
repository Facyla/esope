//<script>
    
    elgg.provide('elgg.backuptool');

    elgg.backuptool.init = function() {
    
        //select all backups checkmarks on backup list page
	$('#backups-checkall').click(function() {
            var checked = $(this).attr('checked') == 'checked';
            $('#backups-form').find('input[type=checkbox]').attr('checked', checked);
	});
        
        
        //handle event for submit Create a new backup Form
        $("#createBackupForm").live("submit",function(){
            var formData = $(this).serialize() ;
            var formAction = $(this).attr('action');
            
            $(this).html('<div class="elgg-ajax-loader" style="padding-top:70px;margin-bottom: 10px;text-align:center;">'+elgg.echo('backup-tool:create:inprogress')+'</div>');
            
            $.ajax({
                url: formAction,
                data: formData
            }).done(function(){
                window.location.reload();
            });
            return false;
        });
        
        
        //test ftp connection
        $("#testFtpConnection").click(function(){
            //display load icon
            $(".elgg-form-backup-tool-schedule-settings").append("<div class='elgg-ajax-loader' style='position: absolute; top:50%; left:50%;'></div>");
            
            var formData = $(".elgg-form-backup-tool-schedule-settings").serialize() ;
            
            var url = $(this).attr('href');
            
            //send data to action via ajax request
            $.ajax({
                url: url,
                data: formData,
                type: 'POST',
                //dataType: 'json',
                success: function(data){
                    $('.elgg-ajax-loader').remove();
                    alert(data);
                    
                }
            });
            return false;
        })


    };

    elgg.register_hook_handler('init', 'system', elgg.backuptool.init);
