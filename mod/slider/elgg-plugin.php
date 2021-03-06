<?php
/**
 * Slider
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013-2020
 * @link https://facyla.fr/
 */

//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/slider/functions.php');

// @TODO Use AMD for JS scripts

$url = elgg_get_site_url();
$vendor_url = $url . 'mod/slider/vendors/anythingslider/';
$vendors_path = 'mod/slider/vendors/';

use Facyla\Slider\Bootstrap;

return [
	'bootstrap' => Bootstrap::class,
	
	// Plugin settings
	'settings' => [
		'css_main' => 'width:100%; height:300px;',
		'css_textslide' => 'padding: 6px 12px;',
		'css' => '',
		'enable_cloning' => 'no',
		'jsparams' => "
theme : 'cs-portfolio',
autoPlay : true,
mode : 'f',
resizeContents : true,
expand : true,
buildNavigation : true,
buildStartStop : false,
toggleControls : true,
toggleArrows : true,
hashTags : false,
delay : 5000,
//easing : 'linear',
//navigationSize : 3, // Set this to the maximum number of visible navigation tabs; false to disable
/* 
// Noms des slides (hover sur les points pour naviguer)
navigationFormatter : function(index, panel){
	return ['Introduction', 'Services', 'Testimonial'][index - 1];
},
onSlideBegin: function(e,slider) {
	// keep the current navigation tab in view
	slider.navWindow( slider.targetPage );
},
onSlideComplete : function(slider){
	// alert('Welcome to Slide #' + slider.currentPage);
},
*/
",
	'content' => '<ul>
		<li>
		<div class="textSlide">
			<h3>Fusce dictum nisi eu convallis luctus.</h3>
			<div>
				<p>
				Integer scelerisque augue id libero scelerisque imperdiet. Nam in tempor metus, ut bibendum nisi.</p>
				<p>Cras suscipit dui et erat placerat, a laoreet turpis egestas. Fusce hendrerit posuere elit vitae tempor. Ut convallis tellus eget libero rhoncus, ut iaculis ante mattis. Suspendisse potenti.</p>
				<p>Nulla luctus dignissim leo sed iaculis. Cras quis orci vulputate, egestas lacus dictum, luctus elit. Etiam maximus sit amet justo a suscipit. Fusce eleifend magna quam, non vehicula ex sodales a. In vitae tempor massa, eu maximus ex.</p>
				<p>Sed sed commodo dolor. Ut aliquet fermentum dictum. Nullam eu faucibus nisi. Vestibulum eu convallis dolor. Praesent ornare nulla non orci facilisis placerat.</p>
			</div>
		</div>
		</li>

		<li><iframe frameborder="0" width="300" height="160" src="http://www.dailymotion.com/embed/video/xrz93q"></iframe></li>

		<li>
		<div class="textSlide">
			<h3>Nulla feugiat nunc eget interdum venenatis</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-civil-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Suspendisse in erat hendrerit, auctor nibh id, facilisis ipsum. Maecenas dictum mi lorem, quis fermentum dolor dictum sed. Pellentesque condimentum erat sit amet pellentesque condimentum. Fusce malesuada viverra magna, aliquet elementum tellus facilisis in. Suspendisse potenti. Cras varius semper mi. Vivamus eu erat non risus mollis maximus vel et arcu. Sed tincidunt neque sed turpis suscipit ornare.</p>
				<p>Suspendisse malesuada velit quis mauris ultricies, a congue nibh vehicula. Donec eu felis lacus. Praesent non venenatis libero. Fusce mattis nibh auctor, malesuada odio fermentum, blandit turpis. Pellentesque accumsan vehicula tellus nec ornare. Maecenas feugiat viverra risus sit amet tempor. Fusce congue, risus vitae euismod ullamcorper, ante lectus porta urna, eu ornare odio dui non turpis. Donec ac urna in mauris tempor eleifend.</p>
			</div>
		</div>
		</li>

		<li>
		<div class="textSlide">
			<h3>Donec eu eleifend tellus !</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Donec vitae cursus massa, vitae venenatis ligula. Quisque gravida diam eget volutpat tempor. Proin felis nisi, finibus sed feugiat id, auctor sit amet urna.</p>
				<p>Praesent nibh libero, molestie et sollicitudin ut, tincidunt ac dolor. Etiam eu ipsum non lacus interdum pharetra ac in massa.</p>
				<p>Praesent condimentum tortor pellentesque, lobortis nisi ut, luctus libero. Suspendisse sed ante vel orci accumsan dapibus. Sed mattis porta elementum.</p>
			</div>
		</div>
		</li>
</ul>',
	],
	
	// Entities
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'slider',
			'class' => 'ElggSlider',
			'searchable' => true,
		],
	],
	
	// Actions
	'actions' => [
		'slider/edit' => [],
		'slider/clone' => [],
		'slider/delete' => [],
	],
	
	// Routes
	'routes' => [
		'slider:index' => [
			'path' => '/slider',
			'resource' => 'slider/index',
		],
		'view:object:slider' => [
			'path' => '/slider/view/{guid?}/{title?}',
			'resource' => 'slider/view',
		],
		'add:object:slider' => [
			'path' => '/slider/add/{container_guid?}',
			'resource' => 'slider/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'edit:object:slider' => [
			'path' => '/slider/edit/{guid?}/{title?}',
			'resource' => 'slider/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		/* forward('admin/plugin_settings/slider');
		'slider:admin' => [
			'path' => '/slider',
			'resource' => 'slider/admin',
		],
		*/
	],
	
	
	// Views: register any custom view that is not in views/ - eg. JS and CSS
	// name => path
	'views' => [
		'default' => [
			//'underscore.js' => __DIR__ . '/bower_components/underscore/underscore.min.js',
			//'js/jqplot/' => __DIR__ . '/vendors/jqplot',
			
			// Dossier complet : utile pour charger toutes les dépendances
			/*
			'/' => [
				$vendors_path . 'anythingslider/',
				$vendors_path . 'coinslider/',
				$vendors_path . 'flexslider/',
				$vendors_path . 'nivoslider/',
				$vendors_path . 'responsiveslides/',
				$vendors_path . 'glide-3.4.1/',
				$vendors_path . 'swiper-5.2.0/package/',
			],
			*/
			
			// AnythingSlider
			'slider.anythingslider.js' => $vendors_path . 'anythingslider/js/jquery.anythingslider.min.js', 
			'slider.anythingslider.easing.js' => $vendors_path . 'anythingslider/js/jquery.easing.1.2.js', 
			'slider.anythingslider.swf.js' => $vendors_path . 'anythingslider/js/swfobject.js', 
			'slider.anythingslider.video.js' => $vendors_path . 'anythingslider/js/jquery.anythingslider.video.js', 
			// CSS
			'slider.anythingslider.css' => $vendors_path . 'anythingslider/css/anythingslider.css', 
			'slider.anythingslider.css' => $vendors_path . 'anythingslider/css/animate.css', 
			// Themes
			'slider.anythingslider.theme-construction.css' => $vendors_path . 'anythingslider/css/theme-construction.css', 
			'slider.anythingslider.theme-cs-portfolio.css' => $vendors_path . 'anythingslider/css/theme-cs-portfolio.css', 
			'slider.anythingslider.theme-metallic.css' => $vendors_path . 'anythingslider/css/theme-metallic.css', 
			'slider.anythingslider.theme-minimalist-round.css' => $vendors_path . 'anythingslider/css/theme-minimalist-round.css', 
			'slider.anythingslider.theme-minimalist-square.css' => $vendors_path . 'anythingslider/css/theme-minimalist-square.css', 
			
			// Coinslider
			'slider.coinslider.js' => $vendors_path . 'coinslider/coin-slider.min.js', 
			'slider.coinslider.css' => $vendors_path . 'coinslider/coin-slider-styles.css', 
			
			// FlexSlider
			'slider.flexslider.js' => $vendors_path . 'flexslider/jquery.flexslider-min.js', 
			'slider.flexslider.css' => $vendors_path . 'flexslider/flexslider.css', 
			
			// NivoSlider
			'slider.nivoslider.js' => $vendors_path . 'nivoslider/jquery.nivo.slider.pack.js', 
			'slider.nivoslider.css' => $vendors_path . 'nivoslider/nivo-slider.css', 
			
			// ResponsiveSlides
			'slider.responsiveslides.js' => $vendors_path . 'responsiveslides/responsiveslides.min.js', 
			'slider.responsiveslides.css' => $vendors_path . 'responsiveslides/responsiveslides.css', 
			
			// Glide
			'slider.glide.js' => $vendors_path . 'glide-3.4.1/glide.min.js',
			'slider.glide.css' => $vendors_path . 'glide-3.4.1/glide.core.min.css',
			'slider.glide.theme.css' => $vendors_path . 'glide-3.4.1/glide.theme.min.css',
			
			// Swiper
			'slider.swiper.js' => $vendors_path . 'swiper-5.2.0/package/js/swiper.min.js',
			'slider.swiper.css' => $vendors_path . 'swiper-5.2.0/package/css/swiper.min.css',
			
		],
	],
	
	'hooks' => [
		'entity:url' => [
			'object' => [
				'slider_url' => [],
			],
		],
		
		'register' => [
			'menu:site' => [
				'Facyla\Slider\Menus::siteMenu' => [],
			],
		],
	],
	
	// Widgets
	/*
	'widgets' => [
		// Module générique (affichage de tous types de vues via divers éléments de configuration)
		'naturalconnect_generic' => [
			'context' => ['profile', 'dashboard', 'naturalconnnect', 'naturalconnect', 'ni_dashboard'],
			'multiple' => true,
		],
	],
	*/
	
];

