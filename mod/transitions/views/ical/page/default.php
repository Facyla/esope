<?php
/**
 * Elgg ICAL output pageshell
 *
 * @package Elgg
 * @subpackage Transitions
 *
 * @uses $vars['body']
 */

$filename = 'transitions_' . date('Ymd') . '.ics';

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename='.$filename);

echo $vars['body'];

