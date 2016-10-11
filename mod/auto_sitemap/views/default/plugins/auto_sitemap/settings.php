<?php
/* ######################################################
 *  Ramón Iglesias / ura soul
 *  www.ureka.org
 * ###################################################### */

$toggle_icon = ' <img src="' . elgg_get_site_url() . 'mod/auto_sitemap/graphics/toggle.png" width=15 style="vertical-align: bottom;"/>';

$optionsYesNo = array( 
        elgg_echo('option:yes') => 1,
        elgg_echo('option:no') => 0
);

$optionsSchemas = array(
        'sitemaps_org_0_9' => 'Sitemaps Protocol 0.9'		
);

$optionsChangefreq = array(
        'disabled' => elgg_echo('auto_sitemap:updatefreq:disabled'),
        'always' => elgg_echo('auto_sitemap:updatefreq:always'),
        'hourly' => elgg_echo('auto_sitemap:updatefreq:hourly'),
        'daily' => elgg_echo('auto_sitemap:updatefreq:daily'),
        'weekly' => elgg_echo('auto_sitemap:updatefreq:weekly'),
        'monthly' => elgg_echo('auto_sitemap:updatefreq:monthly'),
        'yearly' => elgg_echo('auto_sitemap:updatefreq:yearly'),
        'never' => elgg_echo('auto_sitemap:updatefreq:never')		
);
					
$optionsPriority = array(
        'none' => elgg_echo('auto_sitemap:priority:none'),
        '0.0' => '0.0',
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0'
);					

$body = '<h4>' . elgg_echo('auto_sitemap:sitemap-learn-more'). '<a href="http://www.sitemaps.org/protocol.html">www.sitemaps.org</a></h4>';					

// schema
$content = '<h4>' . elgg_echo('auto_sitemap:schema:title') . '</h4>';
$content .= elgg_echo('auto_sitemap:schema:description') . '<br>'; 
$content .= elgg_view('input/dropdown', array(
        'id' => 'slScheme',
        'name' => 'params[schema]',
        'options_values' => $optionsSchemas,
        'value' => $vars['entity']->schema
));
$content .= '<br><br>';										
										
// max amount of urls to display in sitemap
$content .= '<h4>' . elgg_echo('auto_sitemap:max_urls:title') . '</h4>';
$content .= elgg_echo('auto_sitemap:max_urls:description') . '<br>';

$max_urls = $vars["entity"]->max_urls ;
if ( ! is_numeric($max_urls) || ($max_urls < 1) ){
	$max_urls = 5000;
}

$content .= elgg_view('input/text',array(
        'id'=>'inMaxUrls',
        'name'=>'params[max_urls]',
        'value'=> $max_urls
));		
$content .= '<br><br>';		

// use custom CSS?
									
$activo = ($vars['entity']->use_xsl ? 1 : 0);

$content .= '<h4>' . elgg_echo('auto_sitemap:use_xsl:title') . '</h4>';
$content .= elgg_echo('auto_sitemap:use_xsl:description') . '<br>'; 
$content .= elgg_view('input/radio',array(
        'name'=>'params[use_xsl]',
        'value'=> $activo,
        'options'=>$optionsYesNo
));
									
$body .= elgg_view_module(
        'inline', 
        elgg_echo('auto_sitemap:basic-config:title'), 
        $content
);

// main url
$content .= elgg_echo('auto_sitemap:main_url:description') . '<br>';
$content = elgg_view('input/text',array(
        'id'=>'inMainUrl',
        'name'=>'params[main_url]',
        'value'=>( $vars["entity"]->main_url ? $vars["entity"]->main_url : elgg_get_site_url()
)));

$content .='<div style="width:50%;float:left">';
$content .= elgg_echo('auto_sitemap:changefreq:description').'<br>';
$content .= elgg_view('input/dropdown', array(
        'name' => 'params[main_url_changefreq]',
        'options_values' => $optionsChangefreq,
        'value' => $vars['entity']->main_url_changefreq
));

$content .='</div>';
$content .='<div style="width:50%;float:left">';

$content .= elgg_echo('auto_sitemap:priority:description').'<br>';
$content .= elgg_view('input/dropdown', array(
        'name' => 'params[main_url_priority]',
        'options_values' => $optionsPriority,
        'value' => $vars['entity']->main_url_priority
));
$content .='</div>';

$moduleHeader = elgg_view('output/url', array(
	'href' => '#toggle-main-url',
	'rel' => 'toggle',
	'text' => elgg_echo('auto_sitemap:main_url:title') . $toggle_icon
));

$body .= elgg_view_module(
        'inline', 
        $moduleHeader , 
        '<div id="toggle-main-url" style="display:block">' . $content . '</div>'
);

$body .= '<h2>' . elgg_echo('auto_sitemap:entity-urls:title') . '</h2>';					
$body .= '<p>' . elgg_echo('auto_sitemap:entity-urls:description') . '</p>';					

// Entity URLs

global $relevantEntities;

foreach ($relevantEntities as $relevantEntity) {
	
	// name attributes
	$entityUrl = $relevantEntity . '_url';
	$entityChangefreq = $relevantEntity . '_url_changefreq';
	$entityPriority = $relevantEntity . '_url_priority';

	$activo = ($vars['entity']->$entityUrl ? 1 : 0);
	
	$content = elgg_echo('auto_sitemap:module:active:entity', array(elgg_echo('auto_sitemap:entity:' . $relevantEntity . ':title'))); 
	$content .= elgg_view('input/radio',array(
                'name'=>'params[' . $relevantEntity . '_url]',
                'value'=> $activo,
                'options'=>$optionsYesNo
        ));
	
	$content .='<div style="width:50%;float:left">';
		$content .= elgg_echo('auto_sitemap:changefreq:description').'<br>';
		$content .= elgg_view('input/dropdown', array(
                                        'name' => 'params[' . $relevantEntity . '_url_changefreq]',
                                        'options_values' => $optionsChangefreq,
                                        'value' => $vars['entity']->$entityChangefreq
                ));
	$content .='</div>';
	$content .='<div style="width:50%;float:left">';
	$content .= elgg_echo('auto_sitemap:priority:description').'<br>';
	$content .= elgg_view('input/dropdown', array(
                                'name' => 'params[' . $relevantEntity . '_url_priority]',
                                'options_values' => $optionsPriority,
                                'value' => $vars['entity']->$entityPriority
        ));
	$content .='</div>';

	$moduleHeader = elgg_view('output/url', array(
		'href' => '#toggle-' . $relevantEntity,
		'rel' => 'toggle',
		'text' => 	elgg_echo('auto_sitemap:entity:' . $relevantEntity . ':title') . $toggle_icon
	));

	$body .= elgg_view_module(
                'inline', 
                $moduleHeader, 
                '<div id="toggle-' . $relevantEntity . '" style="display:' . ( $activo ? 'block' : 'none' ) . '">' . $content . '</div>'
        );
}
								
// entity URLs

$typeList = Array();
$typeList = xml_plugin_get_otherEntityTypes();

// explode and remove empty
$activeEntities = array_filter(explode(',', $vars["entity"]->other_urls_types ));

$activo = !empty($activeEntities);

$content = elgg_echo('auto_sitemap:other_entities:description').'<br>';
$content .= '<div class="dvOtherEntities">';
$content .= elgg_view('input/checkboxes',array(
        'name'=>'rbOtherEntities',
        'value'=>$activeEntities,
        'options'=>$typeList,
        'default' => false));
$content .= '</div>';

$content .= elgg_view('input/hidden',array(	
        'id'=>'inOtherEntities',
        'class'=>'inOtherEntities',
        'name'=>'params[other_urls_types]',
        'value'=>$vars["entity"]->other_urls_types)
);

$content .='<div style="width:50%;float:left">';
$content .= elgg_echo('auto_sitemap:changefreq:description').'<br>';
$content .= elgg_view('input/dropdown', array(
        'name' => 'params[other_url_changefreq]',
        'options_values' => $optionsChangefreq,
        'value' => $vars['entity']->other_url_changefreq
));
$content .='</div>';
$content .='<div style="width:50%;float:left">';
	
$content .= elgg_echo('auto_sitemap:priority:description').'<br>';
$content .= elgg_view('input/dropdown', array(
        'name' => 'params[other_url_priority]',
        'options_values' => $optionsPriority,
        'value' => $vars['entity']->other_url_priority
));
$content .='</div>';
					
$moduleHeader = elgg_view('output/url', array(
	'href' => '#toggle-other-entity' ,
	'rel' => 'toggle',
	'text' => elgg_echo('auto_sitemap:entity:otros:title') . $toggle_icon
));

$body .= elgg_view_module(
        'inline', 
        $moduleHeader, 
        '<div id="toggle-other-entity" style="display:' . ( $activo ? 'block' : 'none' ) . '">' . $content . '</div>'
);  
					
// custom URLs	

$body .= '<h2>' . elgg_echo('auto_sitemap:custom-urls:title') . '</h2>';					
$body .= '<p>' . elgg_echo('auto_sitemap:custom-urls:description') . '</p>';
					
$frequencies = Array('always' , 'hourly' , 'daily' ,'weekly' , 'monthly', 'yearly', 'never');					
foreach ($frequencies as $frequency) {

	// name attributes
	$entityUrl = $frequency . '_url';
	$entityPriority = $frequency . '_url_priority';
	$activo = ( !empty($vars['entity']->$entityUrl) || $vars['entity']->$entityUrl != "");
	$content = elgg_echo('auto_sitemap:changefreq_url:description');
	$content .= elgg_view('input/plaintext',array(
                'id'=>'inAlwaysUrl',
                'name'=>'params[' . $frequency . '_url]',
                'value'=>$vars["entity"]->$entityUrl)
        );
	
	$content .= elgg_echo('auto_sitemap:priority:description').'<br>';
	$content .= elgg_view('input/dropdown', array(
                'name' => 'params[' . $frequency . '_url_priority]',
                'options_values' => $optionsPriority,
                'value' => $vars['entity']->$entityPriority
        ));
	
	$moduleHeader = elgg_view('output/url', array(
		'href' => '#toggle-' . $frequency,
		'rel' => 'toggle',
		'text' => elgg_echo('auto_sitemap:module:header:changefreq') . ' ' . elgg_echo('auto_sitemap:updatefreq:' . $frequency) . $toggle_icon
	));

	$body .= elgg_view_module(
                'inline', 
                $moduleHeader, 
                '<div id="toggle-' . $frequency . '" style="display:' . ( $activo ? 'block' : 'none' ) . '">' . $content . '</div>'
        );
}

$body .= elgg_echo('auto_sitemap:recordatorio:htaccess');
?>
<script type="text/javascript">
	$(document).ready(function(){
		
		// cada vez que se pincha un checkbox se recorren todos para actualizar el hidden
		$('.dvOtherEntities input[type=checkbox]').click(function(){
			$('#inOtherEntities').val("");
			$('.dvOtherEntities input[type=checkbox]').each(function(){
				if ( $(this).is(':checked') ){
					// ugly hack para que no pinte la primera coma
					if ( $('#inOtherEntities').val() == ""){
						$('#inOtherEntities').val( $(this).val() );
					}else{
						$('#inOtherEntities').val( $('#inOtherEntities').val() + ',' + $(this).val() );
					}
				}
			});
		});	
	});
</script>

<style>
	form{
		margin: 0 auto;
	}

	#auto_sitemap_settings_form .elgg-head{
		margin-bottom:0px;
	}
	#auto_sitemap_settings_form .elgg-body{
		background: #f7f7f7;
		padding: 5px 5px 5px 20px;
	}
</style>

<?php 					
echo '<div id="auto_sitemap_settings_form">' . $body . '</div>';