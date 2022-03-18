��    x      �              �  5   �  4   �  !     +   *    V     ^	     w	  Q  �	     �
  4   �
  �   1     !     �  �   �     ;     K  K   [     �     �  d   �     !  	   2  @   <     }  B   �  &   �  R   �     F  `   Y  n   �  .  )     X  U  h     �  D   �       #     �   6  K   �  B   8  �   {  6   .     e     }     �     �     �  $   �     �     �  8       G     g     t     �  b  �     �  
   �  A       I     Q  &   a     �     �  �   �  Q  X    �  N   �  ^      e      y#  �  �#  �  4%  J   �&  k  *'  ;   �(  �  �(  �  o*  \   >,     �,  +   �,     �,     �,     �,     �,     -  N   '-  3  v-  �   �.  �   +/  <   �/     �/     �/  	   �/     	0     0     0  
   10     <0     H0     N0     \0     p0     �0     �0     �0     �0  	   �0     �0     �0     �0     �0     �0     �0     1  
   1     $1     -1     31  �  @1  F   3  A   O3  /   �3  6   �3  F  �3     ?5     _5  �  {5  )   7  7   ,7  _  d7  �   �8     W9  �   e9     !:     0:  P   C:     �:     �:  �   �:     3;     O;  X   _;     �;  p   �;  8   5<  r   n<     �<  u   �<  �   n=  �  
>     �?  �  �?     @A  T   IA     �A  '   �A  �   �A  [   �B  I   �B  �   <C  F    D     gD  (   �D     �D     �D     �D  +   �D     E     "E  �  ?E  (   
G     3G     CG     UG  �  [G     ?I     PI  g  YI     �J     �J  7   �J     K     +K  �   2K  "  �K  _  O  ]   }P  �  �P    �R     �V  �  �V  �  �X  S   �Z  |  [  I   �\     �\  	  �^  e    a     fa  -   xa     �a     �a     �a  .   �a  )   b  o   1b  �  �b  �   $d  �   �d  =   oe     �e     �e     �e     �e  "   �e  "   �e     !f     <f     Hf     Nf     \f     pf     �f     �f     �f     �f     �f     �f     �f     �f     �f     	g     g     $g  
   7g     Bg     Kg     Pg   **admin** for links accessible by administrators only **default** for non-active links (eg to read a blog) A file in an Elgg file repository A sample messageboard placed on the profile A site administrator can take some actions on unvalidated accounts. Under Administration -> Users -> Unvalidated is a list of unvalidated users. The administrator can manualy validate or delete the user. Also the option to resend the validation e-mail is present. A typical Elgg dashboard A typical group profile A weblog, or blog, is arguably one of the fundamental DNA pieces of most types of social networking site. The simplest form of personal publishing, it allows for text-based notes to be published in reverse-chronological order. Commenting is also an important part of blogging, turning an individual act of publishing into a conversation. Adding to the context menu After clicking on the link, the account is validated After enabling friendship requests as a feature of the Friends plugin, when user A wants to be friends with user B, user B has to approve the request. Upon approval user A will be friends with user B and user B will be friends with user A. After the account is created the user lands on a page with instructions to check their e-mail account for the validation e-mail An Elgg Page An Elgg file repository RSS feed automatically doubles as an RSS feed, so you can subscribe to new audio content using programs like iTunes. An Elgg profile Apache settings Being a social network framework Elgg supports relationships between users. Blog Bundled plugins By default any user can befriend any other user, it's like following the activity of the other user. Click 'Download' Dashboard Developers should note that there are actually 2 types of pages: Diagnostics Each group comes with a :doc:`file`, forum, pages and messageboard Each group has its own URL and profile Each group produces granular RSS feeds, so it is easy to follow group developments Elgg CONFIG values Elgg comes with a set of plugins. These provide the basic functionality for your social network. Elgg wire plugin "The Wire" is Twitter-style microblogging plugin that allows users to post notes to the wire. Elgg's blog expands this model by providing per-entry access controls and cross-blog tagging. You can control exactly who can see each individual entry, as well as find other entries that people have written on similar topics. You can also see entries written by your friends (that you have access to). File repository For the technically savvy user, system diagnostics enables you to quickly evaluate the server environment, Elgg code, and plugins of an Elgg install. Diagnostics is a core system plugin that comes turned on by default with Elgg. To download the diagnostics file, follow the steps below. The file is a dump of all sorts of useful information. Friends Go to Administration -> Administer -> Utilities ->System Diagnostics Groups If possible the user gets logged in If the user tries to login before validating their account an error is shown to indicate that the user needs to check their e-mail account. Also the validation e-mail is sent again. In each case, the user in question will be passed as ``$params['entity']``. In the validation e-mail is a link to confirm their e-mail address It is possible for other plugins to add to the players available for different content types. It's possible for a plugin author to embed a viewer for Word documents, for example. List of all Elgg files along with a hash for each file List of all the plugins Log in as Administrator Message notification Messageboard Messages Normal pages (with subtype ``page``) Note for developers Notes for developers Once you have found others with similar interests - or perhaps you are part of a research groups or a course/class - you may want to have a more structured setting to share content and discuss ideas. This is where Elgg's powerful group building can be used. You can create and moderate as many groups as you like Options for site administrators PHP settings PHP superglobals Pages Pages really come into their own in two areas, firstly as a way for users to build up things such as a resume, reflective documentation and so on. The second thing is in the area of collaboration, especially when in the context of groups. With the powerful access controls on both read and write, this plugin is ideal for collaborative document creation. Photo gallery Podcasting Private messaging can be sent to users by clicking on their avatar or profile link, providing you have permission. Then, using the built in :doc:`WYSIWYG editor </tutorials/wysiwyg>`, it is possible to format the message. Each user has their own inbox and sentbox. It is possible to be notified via email of new messages. Profile Special content System diagnostics dump file contents: The Elgg context menu The Wire The context menu can be expanded by registering a :ref:`plugin hook <design/events#plugin-hooks>` for 'register' 'menu:user_hover', the following sections have special meaning: The dashboard is bundled with both the full and core-only Elgg packages. This is a users portal to activity that is important to them both from within the site and from external sources. Using Elgg's powerful widget API, it is possible to build widgets that pull out relevant content from within an Elgg powered site as well as grab information from third party sources such as Twitter or Flickr (providing those widgets exist). A users dashboard is not the same as their profile, whereas the profile is for consumption by others, the dashboard is a space for users to use for their own needs. The file repository allows users to upload any kind of file. As with everything in an Elgg system, you can filter uploaded files by tag and restrict access so that they're only visible by the people you want them to be. Each file may also have comments attached to it. The following plugins are also bundled with Elgg, but are not (yet) documented The messageboard - similar to 'The Wall' in Facebook or a comment wall in other networks is a plugin that lets users put a messageboard widget on their profile. Other users can then post messages that will appear on the messageboard. You can then reply directly to any message and view the history between yourself and the person posting the message. The pages plugin allows you to save and store hierarchically-organized pages of text, and restrict both reading and writing privileges to them. This means that you can collaboratively create a set of documents with a loose collection of people, participate in a writing process with a formal group, or simply use the functionality to write a document that only you can see, and only choose to share it once it's done. The easy navigation menu allows you to see the whole document structure from any page. You can create as many of these structures as you like; each individual page has its own access controls, so you can reveal portions of the structure while keeping others hidden. In keeping with all other elements in Elgg, you can add comments on a page, or search for pages by tag. The process for the user The profile plugin is bundled with both the full and core-only Elgg packages. The intention is that it can be disabled and replaced with another profile plugin if you wish. It provides a number of pieces of functionality which many consider fundamental to the concept of a social networking site, and is unique within the plugins because the profile icon it defines is referenced as standard from all over the system. The user avatar represents a user (or a group) throughout the site. By default, this includes a context-sensitive menu that allows you to perform actions on the user it belongs to wherever you see their avatar. For example, you can add them as a friend, send an internal message, and more. Each plugin can add to this context menu, so its full contents will vary depending on the functionality active in the current Elgg site. The user creates an account by going to the registration page of your site The uservalidationbyemail plugin adds a step to the user registration process. After the user registered on the site, an e-mail is sent to their e-mail address in order to validate that the e-mail address belongs to the user. In the e-mail is an verification link, only after the user clicked on the link will the account of the user be able to login to the site. There are a number of different uses for this functionality This provides information about a user, which is configurable from within the plugin's start.php file. You can change the available profile fields form the admin panel. Each profile field has its own access restriction, so users can choose exactly who can see each individual element. Some of the fields contain tags (for example *skills*) limiting access to a field will also limit who can find you by that tag. To add a special content type player, create a plugin with views of the form ``file/specialcontent/mime/type``. For example, to create a special viewer for Word documents, you would create a view called ``file/specialcontent/application/msword``, because ``application/msword`` is the MIME-type for Word documents. Within this view, the ``ElggEntity`` version of the file will be referenced as ``$vars['entity']``. Therefore, the URL of the downloadable file is: To replace the profile icon, or provide more content, extend the ``icon/user/default`` view. To use: Top-level pages (with subtype ``page_top``) Usage User avatar User details User validation by e-mail Using a different profile icon Using this, it should be possible to develop most types of embeddable viewers. When a user uploads photographs or other pictures, they are automatically collated into an Elgg photo gallery that can be browsed through. Users can also see pictures that their friends have uploaded, or see pictures attached to a group. Clicking into an individual file shows a larger version of the photo. When users first login, they will be notified about any new message by the messages notification mechanism in their top toolbar. You can keep all group activity private to the group or you can use the 'make public' option to disseminate work to the wider public. `Blogging on Wikipedia <http://en.wikipedia.org/wiki/Blog>`_ actions activity bookmarks ckeditor custom_index database settings developers discussions embed externalpages friends_collections garbagecollector invitefriends language strings likes members much more notifications page handlers plugin hooks reportedcontent search site settings site_notifications system_log tagcloud views web_services Project-Id-Version: Elgg master
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2021-08-03 11:15+0200
PO-Revision-Date: 2018-01-19 10:19+0000
Last-Translator: Florian DANIEL aka Facyla <i.daniel.florian@gmail.com>, 2020
Language: fr
Language-Team: French (https://www.transifex.com/elgg/teams/11337/fr/)
Plural-Forms: nplurals=2; plural=(n > 1)
MIME-Version: 1.0
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit
Generated-By: Babel 2.9.1
 **admin** pour les liens accessibles seulement par les administrateurs **default** pour les liens non actifs (par ex. pour lire un blog) Un fichier dans un répertoire de fichiers Elgg Un exemple de panneau d'affichage placé sur le profil Un administrateur du site peut effectuer certaines actions sur les comptes non validés. Une liste des membres non validés se trouve dans Administration -> Utilisateurs -> Non validés. L'administrateur peut manuellement valider ou supprimer l'utilisateur. Il existe également une option pour renvoyer l'email de validation. Un tableau de bord Elgg typique Un profil de groupe typique Un weblog, ou blog, est sans conteste l'un des éléments fondamental d'ADN de tous les types de sites de réseautage social. La forme la plus simple de publication personnelle, qui permet de publier des notes textuelles dans un ordre antéchronologique. Les commentaires sont également une part importante du blogging, en transformant un acte de publication personnel en une conversation. Ajouter des éléments au menu contextuel Après avoir cliqué sur le lien, le compte est validé Après avoir activé les demandes de contact en tant que fonctionnalité du plugin Friends, lorsque l’utilisateur A veut être en contact avec l’utilisateur B, l’utilisateur B doit approuver la demande. Lors de l’approbation, l’utilisateur A sera en contact avec l’utilisateur B et l’utilisateur B sera en contact avec l’utilisateur A. Une fois le compte créé l'utilisateur arrive sur une page qui indique de vérifier la présence de l'email de validation sa boîte de messagerie Une page Elgg Un répertoire de fichiers Elgg est doublé automatiquement par un flux RSS, de sorte que vous pouvez vous abonner à du nouveau contenu audio en utilisant des programmes tels que iTunes. Un profil Elgg Paramètres Apache En tant que framework de réseau social, Elgg gère les relations entre membres. Blog Plugins joints Par défaut tout membre peut se mettre en contact avec n'importe quel autre membre : cela revient à suivre l'activité de l'autre membre. Cliquez sur 'Télécharger' Tableau de bord Les développeurs devraient tenir compte du fait qu'il existe en fait 2 types de pages : Diagnostics Chaque groupe dispose d'un répertoire de fichiers :doc:`file`, d'un forum, de pages et d'un panneau d'affichage Chaque groupe dispose de sa propre URL et page de profil Chaque groupe produit des flux RSS granulaires, de sorte qu'il est aisé de suivre les développements des groupes Valeurs de Elgg CONFIG Elgg est livré avec un jeu de plugins. Ils fournissent les fonctionnalités fondamentales pour votre réseau social. Le plugin de câble d'Elgg "The Wire" (Le Fil) est un plugin de micro-blogging à la Twitter, qui permet aux utilisateurs de publier des notes vers le fil. Le blog d'Elgg étend ce modèle en fournissant des contrôles d'accès pour chaque entrée et un système de tags transverse aux blogs. Vous pouvez contrôler précisément qui peut voir quel article de blog, et identifier des articles écrits par d'autres personnes sur des sujets similaires. Vous pouvez également voir les entrées écrites par vos contacts (auxquels vous avec accès). Répertoire de fichiers Pour l'utilisateur techniquement averti, les diagnostics système permettent d'évaluer rapidement l'environnement serveur, le code d'Elgg, et les plugins d'une installation Elgg. Les diagnostics sont un plugin système du noyau qui est activé par défaut avec Elgg. Pour télécharger le fichier de diagnostics, suivez les étapes ci-dessous. Le fichier est un vidage de tous types d'informations utiles. Contacts Rendez-vous dans Administration -> Administrer -> Utilitaires ->Diagnostics Système Groupes Si possible l'utilisateur est connecté Si l'utilisateur tente de s'identifier avant d'avoir validé son compte, une erreur indique que l'utilisateur doit d'abord vérifier sa boite mail. De plus, un nouveau mail de validation est envoyé. Dans tous les cas, l'utilisateur en question sera passé en tant que ``$params['entity']``. Dans l'email de validation, un lien permet de confirmer son adresse email Il est possible pour d'autres plugins d'ajouter de nouveaux lecteurs et visionneuses pour différents types de contenus. L'auteur d'un plugin peut par exemple intégrer de cette manière une visionneuse pour des documents Word. Liste de tous les fichiers d'Elgg ainsi qu'un hash pour chaque fichier Liste de tous les plugins Connectez-vous en tant qu'administrateur Notification des messages Messageboard Messages Pages normales (avec le sous-type ``page``) Note pour les développeurs Notes pour les développeurs Une fois que vous avez trouvé d'autres personnes avec des centres d'intérêt similaires - ou peut-être que vous faites partie d'un groupe de recherche ou d'un cours - vous pourriez souhaiter disposer d'un environnement plus structuré pour partager du contenu et discuter d'idées. C'est là qu'interviennent les puissantes fonctionnalités d'Elgg en terme de construction de groupes. Vous pouvez créer et modérer autant de groupes que vous le désirez. Options pour les administrateurs du site Paramètres PHP Superglobales PHP Pages Les pages expriment vraiment leur potentiel dans deux domaines, d'abord comme moyen pour les utilisateurs de construire des choses telles qu'un CV, un portfolio, une documentation réflexive, et autres constructions de ce type. La seconde est dans le domaine de la collaboration, tout particulièrement dans le cadre d'un groupe. Avec les puissants outils de contrôle d'accès à la fois en lecture et en écriture, ce plugin est idéal pour la création collaborative de documents. Galerie de photo Podcasts Des messages privés peuvent être envoyés aux memrbes en cliquant sur leur avatar ou le lien vers leur profil. Puis, en utilisant l':doc:`éditeur WYSIWYG </tutorials/wysiwyg>` natif, il est possible de formater le message. Chaque membre dispose de sa propre boîte de réception et d'envoi. Il est possible d'être notifié par email des nouveaux messages. Profil Contenus spéciaux Contenu du fichier de vidage des diagnostics système : Le menu contextuel Elgg Le Fil Le menu contextuel peut être étendu en enregistrant un :ref:`hook de plugin <design/events#plugin-hooks>` pour 'register' 'menu:user_hover', les sections suivantes ont une signification spéciale : Le tableau de bord est livré à la fois avec la version complète et noyau seulement d'Elgg. C'est le portail des utilisateurs vers des activités qui leur sont importantes à la fois à l'intérieur du site et depuis des sources externes. En utilisant la puissante API widgets d'Elgg, il est possible de construire des widgets qui retirent du contenu pertinent depuis l'intérieur d'un site Elgg, ainsi que de récupérer des informations depuis des sources tierce-partie telles que Twitter ou Flickr (dès lors que ces widgets existent). Le tableau de bord des utilisateurs n'est pas la même chose que leur profil : tandis que le profil est destiné à être consulté par les autres, le tableau de bord est un espace strictement personnel que les utilisateurs utilisent pour leurs propres besoins. Le répertoire de fichiers permet à des membres de charger n'importe quel type de fichier. Comme avec tout dans un système Elgg, vous pouvez aisément filtrer les fichiers par tags et restreindre l'accès de sorte qu'ils soient visibles seulement par les personnes que vous souhaitez. Chaque fichier peut également avoir des commentaires associés. Les plugins suivants sont également livrés avec Elgg, mais ne sont pas (encore) documentés Le panneau d'affichage - similaire au 'Mur' de Facebook ou à un mur de commentaires dans d'autres réseaux - est un plugin qui permet aux membres de placer un widget panneau d'affichage sur leur profil. Les autres membres peuvent alors publier des messages qui vont apparaître sur ce panneau d'affichage. Vous pouvez ensuite répondre directement à n'importe quel message et voir l'historique entre vous et la personne qui a publié le message. Le plugin pages permet d'enregistrer et de conserver d'une manière organisée et hiérarchisée des pages de texte, et d'en restreindre à la fois les accès en lecture et en écriture. Ceci signifie que vous pouvez créer collaborativement un ensemble de documents avec une liste de personnes choisies, participer à un processus d'écriture au sein d'un groupe formalisé, ou simplement utiliser cette fonctionnalité pour créer un document que vous seul pouvez voir, jusqu'à ce que vous choisissiez de le partager une fois terminé. Le menu de navigation simple vous permet de voir la structure de l'ensemble de documents depuis n'importe quelle page. Vous pouvez créer autant de ces structures que vous le souhaitez ; chaque page individuelle dispose de ses propres contrôles d'accès, de sorte que vous pouvez révéler des portions de la structure tout en conservant les autres invisibles. Dans la ligne des autres éléments dans Elgg, vous pouvez aisément ajouter des commentaires sur une page, ou rechercher des pages par tag. Déroulement pour l'utilisateur Le plugin profile est livré à la fois avec la version complète et noyau seulement d'Elgg. L'objectif est qu'il puisse être désactivé et remplacé par un autre plugin de profil si vous le souhaitez. Il fournit un certain nombre d'éléments de fonctionnalités que beaucoup considèrent comme fondamentales pour le concept d'un site de réseautage social, et est unique parmi les plugins parce que l'icône de profil qu'il définit est référencée comme un standard à travers l'ensemble du système. L'avatar utilisateur représente un utilisateur (ou un groupe) à travers le site. Par défaut, l'avatar intègre un menu contextuel sensitif qui vous permet d'effectuer des actions sur l'utilisateur dès lors que vous voyez son avatar. Par exemple vous pouvez l'ajouter comme contact, lui envoyer un message privé, et plus. Chaque plugin peut ajouter des entrées à ce menu contextuel, de sorte que son contenu final va beaucoup dépendre des fonctionnalités actives dans le site Elgg actuel. L'utilisateur crée un compte en se rendant sur la page d'inscription de votre site Le plugin uservalidationbyemail ajoute une étape au processus d'inscription des utilisateurs. Après que l'utilisateur se soit enregistré sur le site, un email est envoyé à son adresse email afin de valider que cette adresse email appartient bien à l'utilisateur. L'utilisateur ne pourra se connecter qu'après avoir cliqué sur le lien de vérification contenu dans l'email. Il existe plusieurs types d'usages différents pour cette fonctionnalité Ceci fournit des informations à propos d'un utilisateur, qui est configurable à partir du fichier start.php du plugin. Vous pouvez changer les champs de profil disponibles depuis le panneau d'administration. Chaque champ de profil dispose de son propre niveau d'accès, de sorte que les membres puissent choisir exactement qui peut voir quel élément précis. Certains des champs contiennent des tags (par exemple *compétences*) : restreindre l'accès à ce champ va également restreindre les personnes qui peuvent vous trouver via ce tag. Pour ajouter un lecteur pour un nouveau type de contenu, créez un plugin avec des vues de la forme ``file/specialcontent/mime/type``. Par exemple, pour créer une visionneuse pour des documents Word, vous pouvez créer une vue nommée ``file/specialcontent/application/msword``, puisque ``application/msword`` est le type MIME pour les documents Word. A l'intérieur de cette vue, la version ``ElggEntity`` du fichier sera référencée en tant que ``$vars['entity']``. Dès lors, l'URL du fichier téléchargeable est : Pour remplacer l'icône de profil, ou fournir plus de contenu, étendre la vue ``icon/user/default``. Pour l'utiliser : Pages racine (avec le sous-type ``page_top``) Usage Avatar utilisateur Informations utilisateur Validation des comptes utilisateur via l'email Utiliser une icône de profil différente En utilisant cela, il devrait être possible de développer la plupart des types de visionnneuses embarquables. Quand un utilisateur charge des photographies ou d'autres images, elles sont automatiquement rassemblées dans une galerie de photos Elgg dans laquelle il est possible de naviguer. Les utilisateurs peuvent aussi voir les photos que leurs contacts ont chargées, ou voir des images attachées à un groupe. Une version plus grande de la photo apparaît en cliquant sur l'un des fichiers. Quand les membres s'identifient, il sont notifiés de tout nouveau message par le mécanisme de notification des messages dans leur barre d'outil supérieure. Vous pouvez conserver toute l'activité du groupe privée pour le groupe, ou utiliser l'option 'rendre public' pour disséminer ses travaux auprès d'un public plus large. `Blogging sur Wikipedia <http://fr.wikipedia.org/wiki/Blog>`_ actions activity (activité) signets ckeditor custom_index (index personnalisé) paramètres de la base de données developers (développeurs) discussions embed externalpages friends_collections garbagecollector invitefriends chaînes de traduction likes members beaucoup plus notifications gestionnaires de pages hooks des plugins reportedcontent search paramètres du site site_notifications system_log tagcloud vues web_services 