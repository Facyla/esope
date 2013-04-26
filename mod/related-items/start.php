<?php

/* ***********************************************************************
 * related-items
 * 
*******************************************/

function in_arrayi($needle, $haystack)
{
    for($h = 0 ; $h < count($haystack) ; $h++)
    {
        $haystack[$h] = strtolower($haystack[$h]);
    }
    return in_array(strtolower($needle),$haystack);
}

function trim_array(array $array,$int){
    $newArray = array();
    for($i=0; $i<$int; $i++){
	array_push($newArray,$array[$i]);
    }
    return (array)$newArray;
}

function subval_sort($a,$subkey,$sort) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	$sort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function get_valid_types() {
	$registered_entities = elgg_get_config('registered_entities');
	$subtypes = array();
	$invalid_types = array('thewire','album');
	foreach ($registered_entities['object'] as $subtype) {
		if (!in_array($subtype,$invalid_types))
     		$subtypes[] = $subtype;
	}
	return $subtypes;
}

function related_items($thisitem)
{
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');	
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$show_names = elgg_get_plugin_setting('show_names','related-items');
	$show_dates = elgg_get_plugin_setting('show_dates','related-items');
	$show_tags = elgg_get_plugin_setting('show_tags','related-items');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner','related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('selectfrom_thissubtype','related-items');
	if ($selectfrom_thissubtype == 'no')
	{
	$selectfrom_subtypes = array_filter(explode(',', elgg_get_plugin_setting('selectfrom_subtypes','related-items')));
	}
	else
	{
		$selectfrom_subtypes = $thisitem->getSubtype();	
	}
	$match_tags = elgg_get_plugin_setting('match_tags','related-items');	
	$match_tags_int = elgg_get_plugin_setting('match_tags_int','related-items');
	$max_related_items = elgg_get_plugin_setting('max_items','related-items');	
	$column_count = elgg_get_plugin_setting('column_count','related-items');
	$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
	$this_items_tags = $thisitem->tags;
	$this_items_tags_count = count($this_items_tags);
  	if ($this_items_tags_count > 0) //if the current item has tags
  	{
  		if ($this_items_tags_count > 1) //if the current item has more than 1 tag
		{	
			$this_items_tags = array_unique($this_items_tags); // create unique list
		}
		else {
			$this_items_tags = array($this_items_tags);
		}
//		elgg_dump('this items tags = ');
//		elgg_dump($this_items_tags);
			//	elggbatch('elgg_get_entities',$options,'related_items_batch()',50,)
	$options = array(
	    'type' => 'object', 
	    'subtypes' => $selectfrom_subtypes,
	    'limit' => 0,
	  //  'metadata_name' => 'tags',
		'wheres' => array('guid <> ' . $thisitem->getGUID()) // exclude this item from list.
	);
	if ($limit_by_date == 'yes')
		$options['created_time_lower'] = $created_time_lower;
	if ($selectfrom_owner != 'all')
		$options['owner_guids'] = $thisitem->getOwner();		
    $items = elgg_get_entities($options); 
//	elgg_dump('items found: ' . count($items));
    $related_items = array();
    foreach($items as $item) // loop all returned items
    {
    	if($item->tags){
    	$itemtags = $item->tags;
		$itemtags_count = count($itemtags);
//		elgg_dump($item->getURL());
//		elgg_dump($itemtags_count);
    	if ($itemtags_count > 1)
		{
			$itemtags =  array_unique($item->tags); // ensure unique tags
		}
		else {
			$itemtags = array($itemtags);
//			elgg_dump('itemtags: ');
//			elgg_dump($itemtags);
		}

		$matched_tags = array();
	    $hitcount = 1;
		if ($match_tags == 'yes')
		{
		    foreach($itemtags as $itemtag)
		    {
		    	if ($hitcount <= $match_tags_int)
				{
		    		if ((in_arrayi($itemtag, $this_items_tags)) || ($itemtag == $this_items_tags))
		    		{
						$hitcount++;
						$matched_tags[] = $itemtag;
		      		}
				}
				else
					break;
		    }
		}
		else 
		{
			 foreach($itemtags as $itemtag)
			 {
				//elgg_dump('item tag2 = ');
				//elgg_dump($itemtag);
		   		if ((in_arrayi($itemtag, $this_items_tags)) || ($itemtag == $this_items_tags))
		   		{
					$hitcount++;
					$matched_tags[] = $itemtag;
					//elgg_dump('matched tags:');
					//elgg_dump($matched_tags);
		   		}
			 }
		}
	  	if ($hitcount > 1)
	    {
		   	$related_items[] = array('similarity' => $hitcount, 'item' => $item, 'matched_tags' => $matched_tags);
	    }
	    }
    } // end loop of examining items
	$item_count = count($related_items,0);

    if($item_count > 0)
    {
      $related_items = subval_sort($related_items,'similarity',arsort);
      $related_items = trim_array($related_items, $max_related_items);
	  switch($column_count)
	  {
	  	case 1: {$box_width = 97;break;}
		case 2: {$box_width = 47;break;}
		case 3: {$box_width = 30;break;}
		default: {$box_width = 22;break;}
	  }
	  if ($jquery_height == 'yes')
      	echo "<script type=\"text/javascript\" >$(document).ready(function(){setHeight('.elgg-related-items-col');});var maxHeight = 0;function setHeight(column){column = $(column);column.each(function(){if($(this).height() > maxHeight){maxHeight = $(this).height();}});column.height(maxHeight);}</script>";
	  echo '<div class="elgg-related-items">';
      echo "<h3>" . elgg_echo('related-items:title') . "</h3><br/>";
      echo '<ul class="elgg-related-items-list">';
      foreach ($related_items as $related_item)
      {
		$thisitem = $related_item['item'];
		if ($thisitem instanceof ElggObject)
		{
			$owner = $thisitem->getOwnerEntity();
			$this_subtype = $thisitem->getsubtype();
			echo '<li class="elgg-related-item elgg-related-' . $this_subtype . '"style="width:' . $box_width . '%;" onclick="window.location.href=\''. $thisitem->getURL() . '\';">';
			echo "<div class='elgg-related-items-col'>";

			switch($this_subtype)
			{
				case 'image':
					$item_guid = $thisitem->getGUID();
					$title = $thisitem->getTitle();
					$icon = "<img src='" . elgg_get_site_url() . "photos/thumbnail/" . $item_guid . "/thumb/' alt='" . $title . "'/>";	
					break;
				case 'videolist_item':
				case 'izap_videos':
				case 'file':
					$icon = elgg_view_entity_icon($thisitem, 'small'); break;
				default: 			break;
			}
			$css_tag = $this_subtype;
			if (!empty($icon))
				$css_tag .= '-gfx';
			else
				{
				$icon ="&nbsp;" ;	
				}

			$div = "<div class='elgg-related-item-icon elgg-related-" . $css_tag . "-icon'>";
			$div .= $icon;
			$div .= "</div>";
			echo $div;
			$icon = null;
			echo "<a href='{$thisitem->getURL()}'>" . $thisitem->title . "</a>";
			if($show_dates =='yes'){
				$friendlytime = elgg_view_friendly_time($thisitem->time_created);
				echo "<br/><small>" . $friendlytime . "</small>";
			}
			if($show_names =='yes')
				echo "<br/><small>" . $owner->name . "</small>";
			if($show_tags =='yes')
				$related_item_tags = elgg_view('output/tags',array('value'=>$related_item['matched_tags']));
			echo "<br/><small>" . $related_item_tags . "</small>";
			echo "</div></li>";
	  	}
	  }
      echo '</ul></div>';
    }
	}  
}
 
function related_items_init()
{
   	elgg_extend_view('page/elements/comments', 'related-items/related-items', 0);
	elgg_extend_view('discussion/replies', 'related-items/related-items', 0);
	elgg_extend_view('css/admin', 'related-items/admin', 1);	
	elgg_extend_view('css/elgg', 'related-items/css');
}

elgg_register_event_handler('init', 'system', 'related_items_init');
?>