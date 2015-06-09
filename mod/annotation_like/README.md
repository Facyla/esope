Elgg Annotation Like plugin
===========================

This plugin provides the function to 'like' annotation to annotation

support version:  Elgg 1.7


Installation
----------------

1. Copy annotation_like to mod 
2. Enable annotation_like plugin
3. Render annotation/like view


Example Usage
----------------

Edit groups/views/default/forum/topicpost.php

And add follow line

    <?php echo elgg_view('annotation/like', array('entity' => $vars['entity'])) ?>


