<?php
if (!isset($vars['id'])) {
  global $unique_id; if ($unique_id > 0) $unique_id++; else $unique_id = 1;
  $vars['id'] = 'showhide_' . $unique_id;
}
if (!isset($vars['linktext'])) $vars['linktext'] = 'Cliquer pour afficher…';
if (!isset($vars['content'])) $vars['content'] = '';

if (isset($vars['title'])) $vars['title'] = '<strong>' . $vars['title'] . '</strong> ';

$content = '<a rel="toggle" href="#' . $vars['id'] . '">' . $vars['title'] . '&raquo;&nbsp;' . $vars['linktext'] . '</a><div id="' . $vars['id'] . '">' . $vars['content'] . '</div>';
$content .= '';

echo $content;
?>
<script type="text/javascript">
$(document).ready(function() {
  $("div#<?php echo $vars['id']; ?>").toggle();
});
</script>

