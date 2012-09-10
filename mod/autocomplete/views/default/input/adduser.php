<p><?php echo elgg_view('input/autocomplete',array('mustMatch'=>'true','minChars'=>$vars['minChars'],'internalname'=>$vars['internalname'].'[]','internalid'=>$vars['internalid'],'value'=>$vars['value'],'title'=>$vars['title'],'class'=>$vars['class'],'width'=>$vars['width'],'lookup_url'=>$vars['url'].'mod/autocomplete/members_complete.php')); ?></p>
<a href="#" class="autocomplete_adduser_link" title="<?php echo elgg_echo('autocomplete:adduser'); ?>" alt="<?php echo elgg_echo('autocomplete:adduser'); ?>" onclick="javascript:autocomplete_adduser(); return false;">+</a>
<?php echo elgg_echo('autocomplete:adduser'); ?>
<span id="adduser_span"></span>
<script type="text/javascript">
var user_count = 0;
function autocomplete_adduser() {
	var user = $('#<?php echo $vars['internalid'] ?>').val();
	if (user != '') {
		var user_div_id = 'adduser_div_'+ user_count;
		var extra = '<span id="'+user_div_id+'" ><br />';
		extra += '<input type="hidden" name="<?php echo $vars['internalname'] ?>[]" value="'+user+'">';
		extra += ' <a class="autocomplete_removeuser_link" title="<?php echo elgg_echo('autocomplete:removeuser'); ?>" alt="<?php echo elgg_echo('autocomplete:removeuser'); ?>" href="#" onclick="javascript:autocomplete_remove_user(\''+user_div_id+'\'); return false;" >';
		extra += '-</a> ';
		extra += user;
		extra += '</span>';	
		$('#adduser_span').append(extra);
		user_count += 1;
		$('#<?php echo $vars['internalid'] ?>').val('');
	}
}

function autocomplete_remove_user(id) {
	$("#"+id).remove();
}
</script>