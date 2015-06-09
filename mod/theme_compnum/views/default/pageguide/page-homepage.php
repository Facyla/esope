<?php
elgg_load_js('pageguide');
?>

<script type="text/javascript">$(document).ready(function() { tl.pg.init(); })</script>

<ul id="tlyPageGuide" data-tourtitle="Visite guidée de la plateforme Compétences Numériques">
		<li class="tlypageguide_left" data-tourtarget="header h1">
			<div>
				Le bandeau supérieur et le titre du site : toujours présent, le titre vous permet de revenir sur votre page d'accueil.<br />
				Vous trouverez juste au-dessus les liens vers votre profil, vos messages, vos contacts, les paramètres de votre compte, et un lien pour vous déconnecter.
			</div>
		</li>
		<li class="tlypageguide_top" data-tourtarget="#transverse #adf-search-input">
			<div>
				Le menu de navigation du site : il vous permet d'accéder à la recherche, et aux principales rubriques du site. Ce menu peut varier selon les profils des membres.<br />
				Certains menus disposent d'un deuxième niveau : placez votre curseur sur les "Groupes" par exemple pour afficher le sous-menu. Celui-ci vous permet d'accéder plus rapidement à vos groupes.
			</div>
		</li>
		<!--
		<li class="tlypageguide_right" data-tourtarget=".elgg-layout">
			<div>
				Le contenu de votre page personnelle.<br />
				Vous êtes actuellement sur votre page d'accueil personnelle et personnalisable : celle-ci comporte différentes zones d'information que nous allons regarder plus en détail.
			</div>
		</li>
		//-->
		<li class="tlypageguide_left" data-tourtarget=".elgg-breadcrumbs li">
			<div>
				Le Fil d'Ariane vous permet de toujours savoir où vous êtes, à partir de la page d'accueil. Il est cliquable, sauf la toute dernière partie qui indique votre page actuelle.
			</div>
		</li>
		<li class="tlypageguide_bottom" data-tourtarget="#home_static .home_static_widget">
		
			<div>
				Ces blocs vous permettent d'accéder aux informations les plus utiles en un clic. Ces informations peuvent varier selon votre profil sur la platefortme. En tant que candidat, vous y retrouvez en particulier des informations de votre dossier de preuve.
			</div>
		</li>
		<li class="tlypageguide_left" data-tourtarget=".profile">
			<div>
				Ce bloc correspond à votre profil personnel. Pour ajouter une photo ou modifier votre profil, cliquez sur les liens situés juste sous l'image.<br />
				Notez que votre profil n'est visible que de vous-même ou des membres de ce site, tant que vous n'avez pas choisi de le rendre public.<br />
				Chacun des informaitons que vous ajoutez à votre profil dispose d'un réglage qui vous permet de choisir qui peut y avoir accès.<br />
				Pour rendre votre profil public, vous modifier vos paramètres en cliquant sur "Mes paramètres" dans le menu supérieur.
			</div>
		</li>
		<li class="tlypageguide_bottom" data-tourtarget="#elgg-widget-col-1">
			<div>
				Votre page de profil se compose également d'une série de blocs que vous pouvez choisir et personnaliser.<br />
				Chacun de ces blocs dispose de réglages qui vous permettent de choisir qui peut les voir, et de régler certains détails, come le nombre d'informations affichées par exemple.<br />
				Cliquez sur le titre d'un bloc en maintenant le bouton appuyé, et faites-le glisser pour le déplacer dans votre page. Relachez le clic quand vous avez fini de le déplacer.<br />
				Vous pouvez organiser vos blocs sur 3 colonnes, situées à droite de votre profil, et 2 colonnes en-dessous.
			</div>
		</li>
		<li class="tlypageguide_top" data-tourtarget=".elgg-widget-add-control .elgg-button">
			<div>
				Ce bouton vous permet d'ajouter de nouveaux blocs à votre page. Ces blocs sont appelés "widgets" (prononcer "oui-djète").<br />
				Cliquez dessus puis cliquez sur les widgets de votre choix. Certains peuvent être ajoutés une seule fois, d'autres plusieurs fois. Si un widget est grisé, vous l'avez déjà ajouté et il n'est pas utile de le rajouter une dexuième fois dans votre page.<br />
				Le nouveaux widgets s'empilent en haut de la colonne de droite. Vous pourrez ensuite les déplacer.<br />
				Lorsque vous avez terminé, cliquez à nouveau sur le bouton pour terminer l'édition de votre page.
			</div>
		</li>
		<li class="tlypageguide_left" data-tourtarget=".elgg-widget-edit-button">
			<div>
				Ce bouton vous permet de configurer votre widget : cliquez pour ouvrir le menu de configuraiton du widget.<br />
				Chaque widget dispose de réglages particuliers : essayez de changer un réglage puis cliquez sur "Enregistrer les réglages" lorsque vous avez terminé. Le widget va se recharger et prendre en compte vos modifications.<br />
				Vous pouvez en particulier choisir qui peut voir ce widget lorsque quelq'un consulte votre page de profil.
			</div>
		</li>
		<li class="tlypageguide_right" data-tourtarget=".elgg-menu-item-delete">
			<div>
				Ce bouton vous permet de supprimer ce widget de votre page de profil.<br />
				Pas de panique ! si vous cliquez dessus le widget n'est pas perdu : il vous suffira pour le retrouver de l'ajouter à nouveau en personnalisant votre page.<br />
				La suppression d'un widget entraine le rechargement de votre page.
			</div>
		</li>
		<li class="tlypageguide_bottom" data-tourtarget=".elgg-menu-item-collapse">
			<div>
				Ce bouton vous permet simplement réduire ou de déployer le contenu de chacun de vos widgets : pratique si vous avez besoin de place, mais rien ne vaut un bon agencement des widgets dans votre page !
			</div>
		</li>
		<li class="tlypageguide_left" data-tourtarget=".tlypageguide_toggle">
			<div>
				Le guide que vous venez de suivre est accessible à tout moment ! Pour recommencer la visite, cliquez sur ce lien.
			</div>
		</li>
	</ul>
	
	<div id="tlyPageGuideWelcome">
			<p>Bienvenue sur la plateforme des Coméptences Numériques ! Ce guide interactif est là pour vous aider à découvrir la plateforme.</p>
			<p><button class="tlypageguide_start">Suivre la visite</button></p>
			<p><button class="tlypageguide_ignore">Pas maintenant</button></p>
			<p><button class="tlypageguide_dismiss">Je connais, merci</button></p>
	</div>

