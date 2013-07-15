<?php
/**
 * Slider plugin settings
 * Params :
 * - contenu du slider par défaut
 * - styles du slider par défaut
 *
*/

$url = $vars['url'];
$vendor_url = $url . 'mod/slider/vendors/anythingslider/';

// Valeurs (et de réinitialisation) des paramètres
if (empty($vars['entity']->css_main)) {
	$vars['entity']->css_main = 'width:554px; height:310px;';
}
if (empty($vars['entity']->css_textslide)) {
	$vars['entity']->css_textslide = 'padding: 6px 12px;';
}
if (empty($vars['entity']->css)) {
	$vars['entity']->css = '';
}

if (empty($vars['entity']->jsparams)) {
	$vars['entity']->jsparams = "theme : 'metallic', autoPlay : true, mode : 'f',
			//easing : 'linear',
			//navigationSize : 3,     // Set this to the maximum number of visible navigation tabs; false to disable
			/* Noms des slides (hover sur les points pour naviguer)
			navigationFormatter : function(index, panel){
				return ['Slab', 'Parking Lot', 'Drive', 'Glorius Dawn', 'Bjork?', 'Traffic Circle'][index - 1];
			},
			*/
			/*
			onSlideBegin: function(e,slider) {
				// keep the current navigation tab in view
				slider.navWindow( slider.targetPage );
			},
			*/
			/*
			onSlideComplete : function(slider){
				// alert('Welcome to Slide #' + slider.currentPage);
			},
			*/
		";
}

if (empty($vars['entity']->content)) {
	$vars['entity']->content = '<ul>
	<li>
		<div class="textSlide">
			<h3>Prototype de la plateforme Compétences Numériques</h3>
			<div>
				<p>
				Ce projet est à l\'initiave des membres de la <a href="http://b2i.formavia.fr/">communauté de pratiques et de projet B2i Adultes de FormaVia</a>.</p>
				<p>Cette Communauté de Pratique lancée en mars 2012 s\'est donné pour objet de travailler et d\'échanger autour du B2i Adultes.</p>
				<p>Le Brevet informatique et internet certifie des compétences numériques acquises professionnellement ou personnellement. Réservé initialement aux collégiens, il se généralise aux adultes.</p>
				<p>Les Organismes de Formation et les Espaces Publics Numériques peuvent dispenser ce brevet auprès de leurs publics, en faisant une demande d\'agrément à la DAFCO dont ils relèvent.</p>
			</div>
		</div>
	</li>
	
	<li><iframe frameborder="0" width="300" height="160" src="http://www.dailymotion.com/embed/video/xrz93q"></iframe></li>
	
	<li>
		<div class="textSlide">
			<h3>Une co-construction en cours</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-civil-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>
					La plateforme est actuellement en construction. Vous pouvez la tester avec un compte apprenant :<ul>
						<li>identifiant : proto</li>
						<li>mot de passe : prototype</li>
					</ul>
				</p>
				<p>
					Les formateurs et animateurs engagés dans le projet sont invités à demander leurs accès personnels à l\'équipe d\'animation de FormaVia via l\'adresse de contact <a href="mailto:contact@formavia.fr&subject=Demande%20de%20compte%20sur%20la%20Plateforme%20Compétences%20Numériques">contact@formavia.fr</a>.
				</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Charte de la plateforme Compétences Numériques</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Cette plateforme est un projet collectif, et s\'appuie sur une <a href="' . $url . 'cmspages/read/charte">Charte de la plateforme Compétences Numériques</a> rédigées par les initiateurs de ce projet.</p>
				<p>Consultez-la pour connaître les quelques règles et principes de bonne utilisation de la Plateforme, et en savoir plus sur ce projet et ses valeurs.</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Rendez-vous ici-même très bientôt !</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Le chantier avance à grands pas, à travers des réunions de conception et d\'ajustement hebdomadaires.</p>
				<p>Renseignez-vous dans l\'espace <a href="http://b2i.formavia.fr/">B2i Adultes de FormaVia</a> pour y participer.</p>
				<p>Vous pouvez revenir ici régulièrement pour suivre l\'avancement de la plateforme, et contribuer à son amélioration.</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Autotest B2i Adultes</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Un <a href="' . $url . 'dossierdepreuve/autopositionnement">Test d\'autopositionnement</a> permettra de se positionner vis-à-vis du B2i Adultes.</p>
				<p>Il pourra être utilisé par les apprenants en début de parcours, ou pour faire un point sur leur avancement.</p>
				<p>Ce test sera aussi disponible en libre accès par toute personne qui souhaite savoir où elle en est par rapport au B2i Adultes.</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Rechercher un lieu de formation</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Une <a href="' . $url . 'cmspages/read/rechercher-un-lieu-pour-votre-formation">page de recherche de votre lieu de formation</a> sera bientôt disponible.</p>
				<p>Composée d\'une liste d \'Organismes de Formation (OF) et d \'Espaces Publics Numériques (EPN), et d\'une carte, elle vous permettra d \'identifier rapidement quel est le lieu le plus pratique pour votre formation&nbsp;: proche de chez vous, de votre lieu de travail, d\'un itinéraire que vous prenez souvent...</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Des ressources en libre accès pour tous !</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Diverses ressources de formation peuvent être consultées sur le site du réseau FormaVia.</p>
				<p>N\'hésitez pas à visionner les <a href="http://id.formavia.fr/pg/event_calendar/type/conference?mode=all">Microconférences</a> déjà disponibles et, pourquoi pas, à proposer les vôtres !</p>
				<p>Toutes les contributions sont bienvenues&nbsp;: si cela vous intéresse d\'y contribuer, contactez l\'équipe d\'animation de FormaVia via <a href="mailto:contact@formavia.fr&subject=Proposition%20de%20ressources%20pour%20les%20Microconférences">contact@formavia.fr</a>.</p>
			</div>
		</div>
	</li>
	
	<li>
		<div class="textSlide">
			<h3>Consultez les Blogs de la plateforme !</h3>
			<div>
				<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
				<p>Plusieurs participants, apprenants ou formateurs, ont souhaité rendre publics les articles de blog écrits dans le cadre de leur formation, ou comme ressources pédagogiques.</p>
				<p>Retrouvez-les via <a href="' . $url . 'blog">les Blogs des Compétences Numériques</a>&nbsp;: vous y trouverez de nombreuses informations intéressantes, et cela vous donnera peut-être envie de créer le vôtre ?</p>
			</div>
		</div>
	</li>
	</ul>';
}

?>
<p>
	<em>
		<h3><?php echo elgg_echo('slider:settings:defaultslider'); ?></h3>
		<?php echo elgg_echo('slider:settings:defaultslider:help'); ?>
	</em>
</p>
<br />

<p><label><?php echo elgg_echo('slider:settings:content'); ?></label><br />
  <?php echo elgg_echo('slider:settings:content:help'); ?><br />
  <?php echo elgg_view('input/longtext', array( 'name' => 'params[content]', 'value' => $vars['entity']->content, 'class' => 'elgg-input-rawtext' )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:jsparams'); ?></label><br />
  <?php echo elgg_echo('slider:settings:jsparams:help'); ?><br />
  <?php echo elgg_view('input/plaintext', array( 'name' => 'params[jsparams]', 'value' => $vars['entity']->jsparams )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_main'); ?></label><br />
  <?php echo elgg_echo('slider:settings:css_main:help'); ?><br />
  <?php echo $url . elgg_view('input/text', array( 'name' => 'params[css_main]', 'value' => $vars['entity']->css_main )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_textslide'); ?></label><br />
  <?php echo elgg_echo('slider:settings:css_textslide:help'); ?><br />
  <?php echo $url . elgg_view('input/text', array( 'name' => 'params[css_textslide]', 'value' => $vars['entity']->css_textslide )); ?>
</p><br />

<!--
<p><label><?php echo elgg_echo('slider:settings:css'); ?></label><br />
  <?php echo elgg_echo('slider:css:help'); ?>
  <?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css )); ?>
</p>
//-->

<br />


