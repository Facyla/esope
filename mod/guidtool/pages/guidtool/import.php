<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

admin_gatekeeper();
elgg_set_context('admin');

$format = get_input('format', 'opendd');

// Render the file upload page
$title = elgg_echo("guidtool:import");
$body = elgg_view("forms/guidtool/import", array('format' => $format, 'forward_url'));

$body = elgg_view_layout('content', array('title' => $title, 'content' => $body, 'sidebar' => '', 'filter' => false));

echo elgg_view_page($title, $body);
