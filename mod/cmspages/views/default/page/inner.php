<?php
/**
 * Elgg inner pageshell
 * Returns embed content for use in Elgg inner-page container (lightbox, AJAX-fetched, etc.)
 * Used for content retrieval, internal use
 *
 * @uses $vars['content']       The content to be rendered
 */

// CMSPage raw content
$body = elgg_extract('body', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

echo $body;

