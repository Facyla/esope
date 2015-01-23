<?php
/* Loading indicator - blocks the interface
 * Usage :
 * Insert view : echo elgg_view('adf_platform/loader', array('enabled' => true))
 * Show : $('#loader').fadeIn('slow');
 * Hide : $('#loader').hide();
 * Important : remember to hide loader after any action, even failing, because it is blocking !
*/

// Load only once
global $esope_loader;
if ($esope_loader) { return; }
$esope_loader = true;

$enabled = $vars['enabled'];
$showhide = 'display:none;';
if ($enabled === true) { $showhide = ''; }
?>

<div id="loader" style="<?php echo $showhide; ?>"><i class="fa fa-spin fa-spinner"></i></div>

