<?php
/**
 * Edit transitions add relation to an other transitions
 *
 * @package Transitions
 */


//echo '<h3>' . elgg_echo('transitions:form:addtransition') . '</h3>';
echo '<p><em>' . elgg_echo('transitions:addtransition:details') . '<br />' . elgg_view('transitions/input/addtransition', array('name' => 'entity_guid', 'relation' => 'related_content', 'guid' => $vars['guid'])) . '</em></p>';

/*
// Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
$value = $vars['value'];
$relation = $vars['relation'];

// Lightbox with search
echo '<a href="' . elgg_get_site_url() . 'transitions/embed/entity/entity-' . $vars['guid'] . '" class="elgg-lightbox">' . elgg_echo('transitions:addrelation:select') . '</a>';
// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entity_guid', 'id' => 'transitions-embed-entity-' . $vars['guid']));
echo '<blockquote id="transitions-embed-details-entity-' . $vars['guid'] . '">' . elgg_echo('transitions:addactor:noneselected') . '</blockquote>';

//echo elgg_view('input/text', array('name' => 'entity_guid', 'style' => "max-width:10em;"));
echo elgg_view('input/hidden', array('name' => 'relation', 'value' => $relation));

*/

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo('transitions:addtransition:submit'))) . '</p>';

