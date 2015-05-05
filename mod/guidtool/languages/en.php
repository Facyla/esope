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

$english = array(
	/**
	 * Menu items and titles
	 */
	'guidtool' => 'GUID Tool',
	'guidtool:browse' => 'Browse GUIDs',
	'guidtool:import' => 'Import GUID data',
	'guidtool:import:desc' => 'Paste the data you want to import in following window, this must be in "%s" format.',

	'guidtool:pickformat' => 'Please select the format that you wish to import or export.',

	'guidbrowser:export' => 'Export',

	'guidtool:editguid' => 'Edit GUID: %s',
	'guidtool:viewguid' => 'View GUID: %s',
	
	'guidtool:regularview' => "View entity (regular view)",
	'guidtool:regularedit' => "Edit entity (regular view)",
	
	'guidtool:editguid:warning' => "<strong>WARNING : though it includes somes preliminary checks and protections against common errors while directly editing GUIDs, this tool should be considered as dangerous if not used with deep comprehension of Elgg data model.</strong><br />It provides an high-level facility to change some properties that are usually accessible only by direct database editing, and are usually not accessible even to admin users. From a usage point of view, this tool facilitates ownership and container changes, entity enabling/disabling, timestamp manipulation, etc.<br /><blockquote><strong>It can be very useful sometimes, but remember with great powers comes great responsability : handle with care !!</strong></blockquote><br />",
	
	'guidtool:edit:fields' => "Edit fields",
	'guidtool:edit:fields:details' => "By default, no field value will be changed : you need to manually set here which fields will be updated once you save the form. Please separate fields by commas. Extra space are allowed.",
	
	'guidtool:deleted' => 'GUID %d deleted',
	'guidtool:notdeleted' => 'GUID %d not deleted',
	
	'guidtool:entity:invalid' => "Invalid entity",
	
	'guidtool:entity:enabled' => "Entity enabled (visible)",
	'guidtool:entity:disabled' => "Entity disabled (hidden)",
	'guidtool:entity:enable' => "Enable entity",
	'guidtool:entity:disable' => "Disable entity",
	
);

add_translation("en",$english);

