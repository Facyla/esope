<?php
/**
 * Elgg pages widget
 *
 * @package ElggPages
 */

//$num = (int) $vars['entity']->pages_num;

//$viewer_url = 'https://partage.inria.fr/share/components/preview/WebPreviewer.swf';
$viewer_url = 'http://localhost/public/departements-en-reseaux.fr/mod/theme_inria/views/default/widgets/inria_partage/WebPreviewer.swf';
//$file_url = 'https://qlf-devnet.inria.fr/mod/file/thumbnail.php?file_guid=5634&amp;size=large';
//$file_url = 'https%3A%2F%2Fqlf-devnet.inria.fr%2Fmod%2Ffile%2Fthumbnail.php?file_guid=5634&amp;size=large';
$file_url = 'test.txt';
?>
Widget Partage<br />
<iframe src="<?php echo $viewer_url; ?>?filename=<?php echo $file_url; ?>&url=<?php echo $file_url; ?>" style="height:300px; width:200px;"></iframe>

<embed type="application/x-shockwave-flash"
	src="<?php echo $viewer_url; ?>"
	width="300px"
	height="400px"
	id="WebPreviewer"
	name="WebPreviewer"
	quality="high"
	allowscriptaccess="always"
	allowfullscreen="true"
	wmode="transparent"
	flashvars="fileName=<?php echo $file_url; ?>&amp;size=large&amp;paging=false&amp;url=<?php echo $file_url; ?>&amp;show_fullscreen_button=true&amp;i18n_actualSize=Actual%20Size&amp;i18n_fitPage=Fit%20Page&amp;i18n_fitWidth=Fit%20Width&amp;i18n_fitHeight=Fit%20Height&amp;i18n_fullscreen=Fullscreen&amp;i18n_fullwindow=Maximize&amp;i18n_fullwindow_escape=Press%20Esc%20to%20exit%20full%20window%20mode&amp;i18n_page=Page&amp;i18n_pageOf=of" />



