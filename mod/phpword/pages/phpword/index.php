<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('phpword:title');

elgg_push_breadcrumb(elgg_echo('phpword'), 'phpword');
elgg_push_breadcrumb($title);


$sidebar = "";
$content = '';

$content .= '';

$samples = array('Sample_01_SimpleText.php', 'Sample_02_TabStops.php', 'Sample_03_Sections.php', 'Sample_04_Textrun.php', 'Sample_05_Multicolumn.php', 'Sample_06_Footnote.php', 'Sample_07_TemplateCloneRow.php', 'Sample_08_ParagraphPagination.php', 'Sample_09_Tables.php', 'Sample_10_EastAsianFontStyle.php', 'Sample_11_ReadWord2007.php', 'Sample_11_ReadWord97.php', 'Sample_12_HeaderFooter.php', 'Sample_13_Images.php', 'Sample_14_ListItem.php', 'Sample_15_Link.php', 'Sample_16_Object.php', 'Sample_17_TitleTOC.php', 'Sample_18_Watermark.php', 'Sample_19_TextBreak.php', 'Sample_20_BGColor.php', 'Sample_21_TableRowRules.php', 'Sample_22_CheckBox.php', 'Sample_23_TemplateBlock.php', 'Sample_24_ReadODText.php', 'Sample_25_TextBox.php', 'Sample_26_Html.php', 'Sample_27_Field.php', 'Sample_28_ReadRTF.php', 'Sample_29_Line.php', 'Sample_30_ReadHTML.php', 'Sample_31_Shape.php', 'Sample_32_Chart.php', 'Sample_33_FormField.php', 'Sample_34_SDT.php', 'Sample_35_InternalLink.php', 'Sample_36_RTL.php', 'Sample_Footer.php', 'Sample_Header.php');

$content .= '<ul>';
foreach($samples as $sample) {
	$content .= '<li><a href="' . elgg_get_site_url() . 'phpword/samples/' . $sample . '">' . $sample . '</a></li>';
}
$content .= '</ul>';


// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

