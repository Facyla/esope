��    �      4      L      L  �   M     �     	  �   !	     
     /
  3   L
     �
  �   �
     }     �  *   �     �     �  �        �  `   �  '   #  .   K  �   z  %   1  ]   W  h   �  ?     0   ^     �     �     �     �  �   �  �  �  �   �  Q   \  �   �  x   �  �     �   �  F   o     �  �   �  J   �  I   �     *  �   6  �   �  ]   �  I  	  n   S  �   �  �   N     	  <   !     ^  @   }  8   �  L   �  �   D  �  "  }   �      [!  �   n!    �!  k   �"  �  f#  6   %  �  N%     �&     
'  �   '  4   �'  �   %(     �(     )     )  U   1)     �)  Y  �)  &   �*  k   +  D   �+  �   �+  -   �,     �,  @  �,  �   .     �.     �.  �   �.  �   �/  �   h0  h   1  �   �1  E   2  Y   Y2  �   �2     B3  `   R3     �3    �3  �   �4     �5  �   �5  D   @6  �   �6  �   	7  r   �7  }   8  H   �8  r   �8  g   A9  �   �9     f:  i   t:  +   �:  H   
;  �   S;  �   <  W   �<  Z   =  :   `=  �   �=  g  I>  -   �?     �?     �?     @     @     +@  	   ;@     E@  �  _@  �   �A     �B     �B  _  C  .   gD  1   �D  <   �D     E     !E  )   BF     lF  }   �F  ,    G     -G  �   JG     H  ~   H  3   �H  9   �H  �   I  3   �I  �   )J  v   �J  A   gK  I   �K  (   �K  (   L     EL  +   \L  D  �L  �  �M  (  cP  v   �Q    R  �   S    �S    �T  H   �U  /   V  �   EV  z   #W  Z   �W  
   �W    X  �   Y  �   Z  .  �Z  �   �\  �   Z]  �   ^     _  /   0_  !   `_  \   �_  Q   �_  Y   1`  %  �`  �  �a  �   �c     Xd  �   ed  +  "e  �   Nf  �  �f  �   di  s   j     tl     �l  .  �l  `   �m    -n      Lo     mo     �o  w   �o     p  �  .p  1   �q  �   r  B   �r  9  �r  B   2t     ut  �  �t  �   v     w     w    w  �   /x  n  �x  �   dz  +  �z  S   "|  �   v|  �   }     �}  y   �}     b~  c  �~  �   �     ��    ��  T   ��  �   ��  �   �  
  ƃ  �   ф  }   X�  �   օ  ~   w�  _  ��     V�  �   i�  ;   �  �   D�  �   ؉  �   ъ  x   y�  i   �  �   \�  �   �  �  ƍ  3   ��     �     �     �     '�     4�  	   D�  )   N�   (If you're wondering about the '``default``\ ' in ``/views/default/``, you can create alternative views. RSS, OpenDD, FOAF, mobile and others are all valid view types.) :doc:`/admin/plugins` :doc:`/guides/views` A few fields are built into Elgg objects. Title and description are two of these. It makes sense to use description to contain the my\_blog text. Every entity can have a subtype and in this we are using ``"my_blog"``. The tags are stored as metadata. A user's blog page Add the WYSIWYG library code Add your name to the ``<author></author>`` element. Adding the widget view code All forms in Elgg should try to use the provided input views located in ``views/default/input``. If these views are used, then it is simple for plugin authors to replace a view, in this case longtext.php, with their wysiwyg. Allow user customization Basic Widget Build a simple blogging plugin using Elgg. Build your own wysiwyg plugin. Building a Blog Plugin Click on the edit link on the toolbar of the widget that you've created. You will notice that the only control it gives you by default is over access (over who can see the widget). Contents Copy the ``manifest.xml`` file from one of the plugins in your elgg install into ``/mod/hello``. Copy this to the ``manifest.xml`` file: Create ``/mod/my_blog/pages/my_blog/all.php``. Create a file at ``/mod/my_blog/views/default/forms/my_blog/save.php`` that contains the form body. This corresponds to view that is called above: ``elgg_view_form("my_blog/save")``. Create a page for composing the blogs Create a widget that will display “Hello, World!” and optionally any text the user wants. Create the file ``/mod/my_blog/actions/my_blog/save.php``. This will save the blog post to the database. Create the file ``add.php`` in ``/mod/my_blog/pages/my_blog/``. Create the form for creating a new my\_blog post Create the plugin skeleton Create your plugin skeleton Customizing the Home Page Displaying list of my\_blogs Each my\_blog post will be passed to this PHP file as ``$vars['entity']``. (``$vars`` is an array used in the views system to pass variables to a view.) The content of ``object/my_blog.php`` can just be something like: Elgg automatically scans particular directories under plugins looking for particular files. :doc:`/guides/views` make it easy to add your display code or do other things like override default Elgg behavior. For now, we will just be adding the view code for your widget. Create a file at ``/mod/hello/views/default/widgets/helloworld/content.php``. “helloworld” will be the name of your widget within the hello plugin. In this file add the code: Elgg is bundled with a plugin for CKEditor_, and previously shipped with TinyMCE_ support. However, if you have a wysiwyg that you prefer, you could use this tutorial to help you build your own. Elgg is now routing the URL http://www.mysite.com/hello/ to the page you created. Elgg needs to be told explicitly that the plugin contains a widget so that it will scan the widget views directory. This is done by calling the elgg\_register\_widget\_type() function. Edit ``/mod/hello/start.php``. In it add these lines: Elgg will automatically call the ``object/my_blog`` view to view the my\_blog post so we need to create the object view. Every object in Elgg has a built-in URL automatically, although you can override this if you wish. The ``getURL()`` method is called to get that unique URL. Every plugin has a ``start.php`` that initializes it. For this example, we just need to register the action file we created earlier: Also see a related guide about :doc:`/guides/actions`. Filter which is left empty because there's currently nothing to filter Finally, we'll draw the page: First of all you need a directory that will hold all the files required by the plugin. Go to the ``mod`` directory of your Elgg site and create there a directory with the name ``hello_world``. For real widgets, it is always a good idea to support :doc:`/guides/i18n`. Go to the ``hello_world`` directory and create these two files inside it: Hello world If we grab the Global Unique IDentifier (GUID) of the logged in user, we can limit the my\_blog posts to those posted by specifying the owner\_guid argument in the list function above. If you have not enabled the plugin yet, you will need to go to Administration => Configure => Plugins => Advanced. Scroll to the bottom until you see your plugin. Click the Enable button. In Elgg, widgets are those components that you can drag onto your profile or admin dashboard. In ``/mod/hello``, create an empty file called ``start.php``. If this file exists, Elgg will load your plugin. Otherwise, you will see a misconfigured plugin error. Go to the admin section of your Elgg install and enable your plugin. Click on the “more info” link under your plugin name. You will notice that nothing happens. In ``/mod/my_blog/views/default/``, create a folder ``/object/`` and then create a file ``my_blog.php`` in it. In order to be able to serve the page that generates the form, you'll need to register a page handler. Add the following to your start.php: In this tutorial we will use the address ``http://www.mysite.com/`` as an example. While developing the plugin you should use the address of your own site instead of the example address. Initializing the plugin Inside start.php you will need something like the following: Integrating a Rich Text Editor It is time to tell Elgg how to apply TinyMCE to longtext fields. It will now display the information that you've entered. Let's also create a page that lists my\_blog entries that have been created. Notice how the form is calling input views like ``input/longtext``. These are built into Elgg and make it easy to add form components. You can see a complete list of input views in the ``/views/default/input/`` directory. Notice the relationship between the values passed to the 'name' and the 'value' fields of input/text. The name of the input text box is ``params[message]`` because Elgg will automatically handle widget variables put in the array ``params``. The actual php variable name will be ``message``. If we wanted to use the field ``greeting`` instead of ``message`` we would pass the values ``params[greeting]`` and ``$widget->greeting`` respectively. Now go to your profile page using a web browser and add the “hello, world” widget. It should display “Hello, world!”. Now that you have: Now to display the user's message we need to modify content.php to use this *message* variable. Edit content.php and change it to: Now you need to upload TinyMCE into a directory in your plugin. We strongly encourage you to put third party libraries in a “vendors” directory, as that is standard practice in Elgg plugins and will make your plugin much more approachable by other developers:: Now, if the URL contains just ``/my_blog`` or ``/my_blog/all``, the user will see an "All Site Blogs" page. Objects in Elgg are a subclass of something called an “entity”. Users, sites, and groups are also subclasses of entity. All entities can (and should) have a subtype, which allows granular control for listing and displaying. Here, we have used the subtype "``my_blog``\ " to identify a my\_blog post, but any alphanumeric string can be a valid subtype. When picking subtypes, be sure to pick ones that make sense for your plugin. Overwrite the default index page on your Elgg install. Page handling functions need to return ``true`` or ``false``. ``true`` means the page exists and has been handled by the page handler. ``false`` means that the page does not exist and the user will be forwarded to the site's 404 page (requested page does not exist or not found). In this particular example, the URL must contain ``/my_blog/add`` for the user to view a page with a form, otherwise the user will see a 404 page. Plugin Tutorials Plugin start.php Plugins are always placed in the ``/mod`` directory. Create a subdirectory there called ``hello``. This will be the name of your plugin and will show up in the Plugins Administration section of Elgg by this name. Read more in the guide about :doc:`/guides/plugins`. Register a function for the plugin hook called ``index, system`` that returns ``true``. This tells Elgg to assume that another front page has been drawn so it doesn't display the default page. Registering a page handler Registering your plugin Registering your widget Reload the Tools Administration page in your browser and check “more info” again. Required files Suppose you want to allow the user to control what greeting is displayed in the widget. Just as Elgg automatically loads ``content.php`` when viewing a widget, it loads ``edit.php`` when a user attempts to edit a widget. In ``/mod/hello/views/default/widgets/helloworld/``, create a file named ``edit.php``. In this file, add the following code: Tell Elgg when and how to load TinyMCE That's it! Now every time someone uses input/longtext, TinyMCE will be loaded and applied to that textarea. The Hello world plugin has appeared to the bottom of the plugin list The ``hello_world_page_handler()`` makes it possible for the users to access the actual page. Inside the function we first give an array of parameters to the ``elgg_view_layout()`` function. The above code is not accessibility-friendly. The action file The action will now be available as ``/action/my_blog/save``. By default, all actions are available only to logged in users. If you want to make an action available to only admins or open it up to unauthenticated users, you can pass 'admin' or 'public' as the third parameter of ``elgg_register_action()``, respectively. The call to ``elgg_register_page_handler()`` tells Elgg that it should call the function ``hello_world_page_handler()`` when user goes to your site and has "hello" at the end of the URL. The contents of the page The end The form should have input fields for the title, body and tags. Because you used ``elgg_view_form()``, you do not need to include form tag markup. The view will be automatically wrapped with: The form's action will be ``"<?php echo elgg_get_site_url() ?>action/my_blog/save"``, which we will create in a moment. Here is the content of ``/mod/my_blog/views/default/forms/my_blog/save.php``: The function \`elgg\_list\_entities\` (and its cousins) also transparently handle pagination, and even create an RSS feeds for your my\_blogs if you have defined these views. The instructions are detailed enough that you don't need much previous experience on plugin development. The last line takes the tags on the my\_blog post and automatically displays them as a series of clickable links. Search is handled automatically. The name of the directory under "mod" becomes the id of your plugin:: The next step is to add some actual features. Open the ``start.php`` and copy this to it: The next step is to register a page handler which has the purpose of handling request that users make to the URL http://www.mysite.com/hello/. The object view The page to create a new my\_blog post is accessible at http://yoursite/my_blog/add. Try it out. The parameters include: The plugin has now the minimum requirements for your site to recognize it. Log in to your site as an administrator and access the plugins page at the administration panel. By default the plugin is at the bottom of the plugins list. Click the "Activate" button to start it. The reason we set the 'value' option of the array is so that the edit view remembers what the user typed in the previous time he changed the value of his message text. The title of the page Then implement the page handler script (/pluginname/pages/index.php) to generate the desired output. Anything output from this script will become your new home page. Then, in your plugin's init function, extend the input/longtext view There's much more that could be done for this plugin, but hopefully this gives you a good idea of how to get started with your own. This creates the basic layout for the page. The layout is then run through ``elgg_view_page()`` which assembles and outputs the full page. This duplicates features in the bundled blog plugin, so be sure to disable that while working on your own version. This piece of code tells Elgg that it should call the function ``hello_world_init()`` when the Elgg core system is initiated. This tutorial assumes you are familiar with basic Elgg concepts such as: This tutorial shows you how to build a simple plugin that adds a new page and prints the text "Hello world" on it. This will add these words to the widget canvas when it is drawn. Elgg takes care of loading the widget. To grab the latest my\_blog posts, we'll use ``elgg_list_entities``. Note that this function returns only the posts that the user can see, so access restrictions are handled transparently: Trying it out Update its values so you are listed as the author and change the description to describe this new plugin. Update the ``start.php`` to look like this: Walk through all the required steps in order to create your own plugins. We will then need to modify our my\_blog page handler to grab the new page when the URL is set to ``/my_blog/all``. So, your new ``my_blog_page_handler()`` function in start.php should look like: We're going to do that by extending the input/longtext view and including some javascript. Create a view tinymce/longtext and add the following code: You can now go to the address http://www.mysite.com/hello/ and you should see the page. You should now be able to enter a message in the text box and see it appear in the widget. You should review those if you get confused along the way. You will need to create your plugin and give it a start.php file where the plugin gets initialized, as well as a manifest.xml file to tell the Elgg engine about your plugin. You'll need to add a manifest file in ``/mod/my_blog/manifest.xml``. This file stores basic information about the plugin. See :doc:`/guides/plugins` for the template. You can also just copy the manifest file from another plugin and then change the values to fit your new plugin. Be sure to change the author and website, and remove the “bundled” category! a ``<form>`` tag and the necessary attributes anti-csrf tokens created your start file intialized the plugin manifest.xml pages/index.php start.php uploaded the wysiwyg code Project-Id-Version: Elgg Core
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2015-02-21 18:48-0500
PO-Revision-Date: 2015-04-06 17:23+0000
Last-Translator: iionly_de <iionly@gmx.de>
Language-Team: German (http://www.transifex.com/projects/p/elgg-core/language/de/)
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Language: de
Plural-Forms: nplurals=2; plural=(n != 1);
 (Falls Du Dich über den Sinn des '``default``\ ' im Pfad von ``/views/default/`` wunderst: Du kannst auch noch andere alternative View-Typen bereitstellen. RSS, OpenDD, FOAF, mobile und weitere sind alles zulässige View-Typen.) :doc:`/admin/plugins` :doc:`/guides/views` Einige Felder sind bei Elgg-Objekten standardmäßig verfügbar. Titel und Beschreibung sind zwei davon. Es macht Sinn, die Beschreibung zum Speichern des my\_blog-Textes zu verwenden. Jeder Entität kann ein Subtyp zugewiesen werden und in diesem Fall verwenden wir als Subtyp ``"my_blog"``. Die Tags werden als Metadata in der Datenbank gespeichert. Eine Seite mit Blogs eines einzelnen Benutzers Hinzufügen der Laufzeit-Bibliotheken des Editors Füge Deinen Namen in das ``<author></author>``-Element ein. Hinzufügen der Widget-View Alle Formulare von Elgg sollten wenn möglich die Input-Views in ``views/default/input`` verwenden. Wenn diese Views verwendet werden, ist es für die Entwickler von Plugins einfach, eine View wie in diesem Fall longtext.php, die bei WYSIWYG-Eingabefeldern zum Einsatz kommt, zu ersetzen. Benutzer-spezifische Anpassungen erlauben Ausgabe eines Widgets Im Folgenden wird gezeigt, wie mit dem Elgg-Framework ein Plugin mit einfacher Blogging-Funktionalität erstellt werden kann. Erstelle Dein eigenes WYSIWYG-Editor-Plugin. Erstellen eines Blog-Plugins Klicke auf den Bearbeiten-Link in der Titelzeile Deines Widgets. Wie Du siehst, ist die einzige standardmäßig angebotene Option die Anpassung des Zugangslevels (wer das Widget angezeigt bekommt). Arbeitschritte Kopiere die Datei ``manifest.xml``von einem der auf Deiner Elgg-Seite installierten Plugins in das ``/mod/hello``-Verzeichnis. Kopiere das folgende in die ``manifest.xml``-Datei: Erzeuge die Datei ``/mod/my_blog/pages/my_blog/all.php``. Erzeuge die Datei ``/mod/my_blog/views/default/forms/my_blog/save.php``, die den Inhalt des Formulars enthält. Dieses Formular deckt sich mit der View, die durch den obigen Aufruf ``elgg_view_form("my_blog/save")`` ausgegeben wird. Erstellung einer Seite für das Verfassen der Blogs In dieser Anleitung wird erläutert, wie ein einfaches Widget erzeugt werden kann, in dem der Text “Hello, World!” und optional noch weiterer von einem Benutzer eingegebener Text angezeigt wird. Erzeuge die Datei ``/mod/my_blog/actions/my_blog/save.php``. Diese Action speichert den Blog-Eintrag in der Datenbank. Erzeuge die Datei ``add.php`` in ``/mod/my_blog/pages/my_blog/``. Erstellung des Formulars für das Verfassen eines neuen my\_blog-Eintrags Erstellung der Grundstruktur des Plugins Erstellung der Grundstruktur des Plugins Anpassung der Homepage Anzeige einer Liste von my\_blog-Einträgen Der jeweilige my\_blog-Eintrag wird dieser PHP-Datei in der Variable ``$vars['entity']`` übergeben (``$vars`` ist eine Feldvariable, die in der Views-Implementierung von Elgg verwendet wird, um einer View beim Aufruf Variablen zu übergeben). Der Inhalt von ``object/my_blog.php`` könnte beispielsweise wie folgt aussehen: Elgg durchsucht automatisch bestimmte Verzeichnisse innerhalb der Ordnerstruktur eines Plugins, um festzustellen, ob darin bestimmte Dateien vorhanden sind. Durch diese :doc:`/guides/views` ist es sehr einfach, den Code zu implementieren, mit dessen Hilfe Inhalte ausgegeben werden oder auch beispielsweise bestimmte standardmäßige Elgg-Funktionalität zu verändern. Für den Moment werden wir allerdings nur den Code für die View Deines Widgets hinzufügen. Erzeuge die Datei ``/mod/hello/views/default/widgets/helloworld/content.php``. Der Name des Widgets im hello-Plugin wird damit “helloworld” sein. Der Inhalt der View-Datei sollte wie folgt sein: Elgg enthält standardmäßig ein Plugin, das CKEditor_- als Rich Text-Editor verwendet (frühere Versionen verwendeten den TinyMCE_-Editor). Wenn Du allerdings einen anderen WYSIWYG-Editor bevorzugst, kannst Du anhand dieser Anleitung ein Plugin entwickeln, das den Editor Deiner Wahl verwendet. Elgg leitet nun den Aufruf der URL http://www.mysite.com/hello/ zu der Seite weiter, die Du soeben implementiert hast. Elgg muss explizit mitgeteilt werden, dass das Plugin ein Widget enthält. Dann wird Elgg das Widget-Views-Verzeichnis danach durchsuchen. Die Registrierung des Widgets erfolgt mit Hilfe der elgg\_register\_widget\_type()-Funktion. Modifiziere ``/mod/hello/start.php`` wie folgt: Elgg wird automatisch die ``object/my_blog``-View aufrufen, wenn ein my\_blog-Eintrag angezeigt werden soll. Daher müssen wir diese View bereit stellen. Jedem Elgg-Objekt ist automatisch eine eindeutige URL zugeordnet. Wenn gewünscht, kannst Du dem Objekt aber auch eine andere URL als die standardmäßig verfügbare URL zuordnen. Die ``getURL()``-Methode wird verwendet, um die einem Objekt zugeordnete URL zu bekommen. Zum Umfang jedes Plugins gehört in jedem Fall eine Datei namens ``start.php``, mit deren Hilfe das Plugin initialisiert wird. In diesen Beispiel hier müssen wir nur die Action-Datei registrieren, die wir bereits erzeugt haben (siehe auch :doc:`/guides/actions`): Einen Filter, der allerdings leer ist, da momentan nichts zu filtern ist Die Ausgabe der Seite erfolgt schließlich mit: Zuallererst ist ein Verzeichnis notwendig, in dem die Dateien des Plugins agespeichert werden können. Gehe in das `mod``-Verzeichnis Deiner Elgg-Installation und erzeuge dort ein neues Verzeichnis namens ``hello_world``. Bei einem produktiv eingesetzten Widget ist es immer empfehlenswert, :doc:`/guides/i18n`-Unterstützung zu implementieren. Gehe dann in das ``hello_world``-Verzeichnis und erzeuge darin die folgenden zwei Dateien: Hallo Welt Unter Verwendung des Global Unique IDentifier (GUID) des angemeldeten Benutzers können wir die Anzeige der my\_blog-Einträge auf die Einträge dieses Benutzers beschränken, wenn wir beim Aufruf der obigen List-Funktion den owner\_guid-Parameter entsprechend setzen.  Falls Du das Plugin noch nicht aktiviert hast, musst Du dies nun nachholen. Gehe zu Konfigurieren => Plugins im Admin-Bereich Deiner Elgg-Installation. Am Ende der Liste siehst Du Dein Plugin. Aktieviere es durch einen Klick auf den Aktivieren-Knopf. Mit Widgets werden in Elgg die Komponenten der Oberfläche bezeichnet, die Du zu Deinem Profil oder dem Admin-Dashboard hinzufügen kannst. Erzeuge eine leere Datei namens ``start.php`` im Verzeichnis ``/mod/hello``. Wenn eine Datei dieses Namens vorhanden ist, lädt Elgg Dein Plugin. Anderenfalls wirst Du eine Fehlermeldung über ein falsch konfiguriertes Plugin erhalten, wenn Du versuchen solltest, das Plugin zu aktivieren. Nach Erzeugen von ``start.php`` kannst Du die Plugin-Liste im Admin-Bereich Deiner Elgg-Seite aufrufen und Dein Plugin aktivieren. Klicke dann auf den “Weitere Informationen”-Link unterhalb dem Namen Deines Plugins - und Du wirst feststellen, dass nichts passiert. Erzeuge das Unterverzeichnis ``/object/`` im Ordner ``/mod/my_blog/views/default/``und in diesem Unterverzeichnis dann die Datei ``my_blog.php``. Damit Elgg die Seite, die das Formular erzeugt, auf Anforderung bereitstellen kann, ist es notwendig, dafür einen Pagehandler zu registrieren. Füge das Folgende zu Deiner start.php hinzu: Im Rahmen dieser Anleitung verwenden wir die Adresse ``http://www.mysite.com/`` als Beispiel. Wenn Du das in dieser Anleitung vorgestellte Plugin selbst umsetzten willst, verwende statt dieser Beispiel-Adresse die Adresse Deiner eigenen Elgg-Webseite. Initialisierung des Plugins Deine start.php sollte etwa wie folgt aussehen: Einbinden eines Rich Text-Editors Es ist nun Zeit, Elgg mitzuteilen, wie TinyMCE bei longtext-Eingabefeldern zu verwenden ist. Du wirst nun die Informationen angezeigt bekommen, die Du soeben eingegeben hast. Nun wollen wir eine Seite hinzufügen, die die verfügbaren my\_blog-Einträge auflistet. Siehst Du, wie das Formular Input-Views wie ``input/longtext`` aufruft? Diese Views sind in Elgg bereits implementiert und daher ist es einfach, solche Formular-Komponenten hinzuzufügen. Eine komplette Liste der verfügbaren Input-Views ist im ``/views/default/input/``-Verzeichnis zu finden. Beachte den Zusammenhang zwischen den Werten, die den 'name'- und 'value'-Feldern von input/text übergeben werden. Der Name des Texteingabefeldes ist ``params[message]``, weil Elgg automatisch Widget-Variablen verarbeitet, die der Feldvariablen ``params`` übergeben werden. Der eigentliche Name der PHP-Variablen ist allerdings ``message``. Wenn wir dem Feld stattdessen den Namen ``greeting`` anstatt ``message`` geben wollten, würden wir die Werte ``params[greeting]`` und ``$widget->greeting`` übergeben. Gehe jetzt zu Deiner Profilseite innerhalb Deiner Elgg-Seite und füge das “hello, world”-Widget hinzu. Im Widget sollte nun “Hello, world!” angezeigt werden. Du hast nun: Um nun die Nachricht anzuzeigen, die der Benutzer eingegeben hat, müssen wir den Inhalt von content.php unter Verwendung dieser *message*-Variable anpassen. Ändere content.php wie folgt: Nun musst Du die Dateien des TinyMCE-Editors zu Deinem Plugin-Verzeichnis hinzufügen. Wir empfehlen, 3rd Party-Bibliotheken in ein Verzeichnis namens “vendors” abzulegen. Dies ist die standardmäßige Vorgehensweise und erleichtert anderen Entwicklern, die Struktur Deines Plugins zu verstehen: Wenn die URL nun entweder nur ``/my_blog`` oder aber ``/my_blog/all`` enthält, wird der Benutzer eine "All Site Blogs"-Seite angezeigt bekommen. Objekte sind in Elgg eine Unterklasse von sogenannten “Entitäten”. Benutzer, Gruppen und sogar eine Elgg-Seite selbst sind auch Unterklassen von Entitäten. Allen Entitäten kann (und sollte) ein Subtyp zugeordnet sein, mit dessen Hilfe ein flexibler und zielgenauer Zugriff beispielsweise bei der Auflistung und Anzeige der Entitäten möglich wird. In diesem Fall verwenden wir den Subtyp "``my_blog``\ ", um einen my\_blog-Eintrag zu identifizieren, aber jeder beliebige alphanumerische String ist ein zulässiger Subtyp. Der Bezeichner für den Subtyp sollte so gewählt werden, dass er im jeweiligen Kontext des Plugins sinnvoll ist. Im folgenden wird beschrieben, wie Du die standardmäßig angezeigte Indexseite Deiner Elgg-Seite mit einer eigenen Version der Indexseite ersetzen kannst. Die Funktionen, die als Pagehandler registriert werden, müssen als Rückgabewert entweder ``true`` oder ``false`` haben. ``true`` bedeutet, dass die Seite existiert und die Darstellung der Seite durch die Pagehandler-Funktion vorgenommen wurde. ``false`` bedeutet, dass die Seite nicht vorhanden ist und der Benutzer zur 404-Fehlerseite (angeforderte Seite existiert nicht oder konnte nicht gefunden werden) der Webseite weitergeleitet wird. Im Beispiel hier muss die URL ``/my_blog/add`` enthalten, damit der Benutzer die Seite mit dem Formular zu sehen bekommt. Andernfalls wird der Benutzer die 404-Seite zu sehen bekommen. Plugin-Anleitungen start.php des Plugins Plugins werden immer im ``/mod``-Verzeichnis einer Elgg-Installation abgelegt. Erstelle in diesem Verzeichnis ein Unterverzeichnis namens ``hello``. Dies wird zugleich der Name Deines Plugins sein und es wird auch unter diesem Namen in der Plugin-Liste im Admin-Bereich Deiner Seite aufgeführt werden. Mehr Informationen dazu sind in der Dokumentation im Abschnitt :doc:`/guides/plugins` zu finden. Registriere eine Funktion als Callback-Funktion für den ``index, system``-Plugin-Hook, die als Rückgabewert ``true`` zurückgibt. Die Rückgabe von ``true`` signalisiert Elgg, dass eine eigenständige Indexseite erzeugt wurde und die standardmäßige Indexseite wird nicht ausgegeben. Registrierung eines Pagehandlers Registrierung Deines Plugins Registrieren des Widgets Lade die Seite mit der Plugin-Liste im Admin-Bereich erneut und klicke wieder auf den “Weitere Informationen”-Link. Notwendige Dateien Nehmen wir an, Du möchtest es dem Benutzer überlassen, wie der im Widget dargestellte Text lauten soll. In gleicher Weise, wie Elgg automatisch ``content.php`` lädt, wenn ein Widget angezeigt wird, lädt Elgg auch automatisch ``edit.php``, wenn ein Benutzer die Einstellungen eines Widgets bearbeiten will. Erzeuge in ``/mod/hello/views/default/widgets/helloworld/`` die Datei ``edit.php`` und gebe in ihr folgenden Code ein: Elgg mitteilen, wann und wie TinyMCE zu laden ist Das ist alles! Von nun an wird in allen Fällen, in denen ein input/longtext-Eingabefeld verwendet wird, TinyMCE geladen und an Stelle des Texteingabefeldes angezeigt. Das Hallo Welt-Plugin ist nun am Ende der Plugin-Liste aufgeführt Die Pagehandler-Funktion ``hello_world_page_handler()`` kümmert sich dann darum, dass dem Benutzer die angeforderte Seite auch tatsächlich angezeigt wird. Innerhalb der Pagehandler-Funktion übergeben wir zuerst der ``elgg_view_layout()``-Funktion einen gewissen Satz an Parametern mit Hilfe einer Feldvariable. Bei obigem Code ist keine barrierefreie Zugänglichkeit umgesetzt. Die Action-Datei Auf die Action kann nun unter ``/action/my_blog/save`` zugegriffen werden. Standardmäßig sind alle Actions nur für angemeldete Benutzer verfügbar. Wenn Du eine Action stattdessen nur für Admins oder darüber hinaus auch für nicht angemeldete Besucher zugänglich machen willst, kannst Du dem Aufruf von ``elgg_register_action()`` als dritten Parameter 'admin' bzw. 'public' hinzufügen. Die Aufruf von ``elgg_register_page_handler()`` weist Elgg an, dass es die Funktion ``hello_world_page_handler()`` ausführen soll, wenn ein Benutzer Deine Seite besucht und in der URL nach der Adresse Deiner Seite ein "hello" enthalten ist. Den Inhalt der Seite Fazit Das Formular sollte Eingabefelder für den Titel, den Text des Blogs und Tags enthalten. Wenn Du ``elgg_view_form()`` verwendest, musst Du das Form-Tag nicht selbst zum Inhalt der Formular-Datei hinzufügen. Beim Aufruf der View findet eine automatische Kapselung statt mit: Die Action des Formulars wird ``"<?php echo elgg_get_site_url() ?>action/my_blog/save"`` sein und wir kommen gleich zu ihr. Der Inhalt von ``/mod/my_blog/views/default/forms/my_blog/save.php`` ist: Die Funktion \`elgg\_list\_entities\` (und verwandte Funktionen der Elgg-API) kümmert sich auch um einen korrekten automatischen Seitenumbruch (falls die Anzahl der Einträge in der Liste einen solchen notwendig machen sollte) und erzeugt darüber hinaus automatisch einen RSS-Feed für die my\_blog-Einträge, falls Du dafür eine passende View implementiert hast. Die Anleitungen sind hoffentlich detailliert genug, damit Du sie auch ohne Erfahrung auf dem Gebiet der Plugin-Entwicklung nachvollziehen kannst. Der Code in der letzten Zeile erzeugt aus den Tags eines my\_blog-Eintrags eine Reihe von anklickbaren Links und stellt diese dar. Die Möglichkeit einer Suche nach anderen Einträgen mit denselben Tags bei einem Klick auf einen solchen Link ist in Elgg selbst bereits standardmäßig implementiert. Der Name des Verzeichnisses im "mod"-Ordner ist die zugleich die ID Deines Plugins: Als nächsten Schritt fügen wir zum Code des Plugin dann eine tatsächliche Funktionalität hinzu. Öffne die Datei ``start.php`` und übernehme folgenden Code: Der nächste Schritt ist die Registrierung eines sogenannten Pagehandlers, dessen Aufgabe es ist, eine Anfrage von Benutzern zu verarbeiten, die die URL http://www.mysite.com/hello/ aufrufen. Die Objekt-View Die Seite, um einen neuen my\_blog-Eintrag zu erzeugen, ist unter http://yoursite/my_blog/add verfügbar. Probier es aus! Die Parameter enthalten dabei: Das Plugin hat nun den minimal notwendigen Umfang, um von Elgg als zulässiges Plugin erkannt zu werden. Melde Dich auf Deiner Seite als Administrator an und gehe zur Plugin-Seite im Admin-Bereich Deiner Seite. Standardmäßig ist das neue Plugin am Ende der Liste der Plugins zu finden. Klicke nun auf den "Aktivieren"-Knopf, um das Plugin zu aktivieren. Das 'value'-Attribut in der Feldvariable setzen wir, damit die Edit-View anzeigen kann, was der Benutzer beim letzten Mal eingegeben hatte als der Text editiert wurde. Den Titel der Seite Als nächstes musst Du die Pagehandler-Datei (/pluginname/pages/index.php) erstellen, die die von Dir gewünschte Ausgabe für die Indexseite generiert. Alles, was von dieser Datei als Ausgabe erzeugt wird, wird auf Deiner neuen Homepage dargestellt werden. Erweitere anschließend die input/longtext-View in der Init-Funktion Deines Plugins: Dieses Plugin könnte noch in vielerlei Hinsicht erweitert werden aber dies würde den Rahmen dieser Anleitung sprengen. Hoffentlich hast Du trotzdem eine Vorstellung davon bekommen, wie Du selbst bei der Erstellung eines Plugins vorgehen kannst. Dadurch wird das grundlegende Layout der Seite definiert. Diese Layout-Definition wird dann von der ``elgg_view_page()``-Funktion verarbeitet, die den Inhalt der Seite zusammenstellt und sie schließlich darstellt. Bei der Umsetzung dieser Anleitung sind teilweise Funktionen zu implementieren, die bereits das mit Elgg mitgelieferte Blog-Plugin zur Verfügung stellt. Stell daher sicher, dass dieses Plugin deaktiviert ist, während Du an Deiner eigenen Implementierung arbeitest. Dieses Code weist Elgg an, dass die Funktion ``hello_world_init()`` ausgeführt werden soll, wenn das Elgg-Basissystem gestartet wird. Diese Anleitung setzt voraus, dass Du mit einigen grundlegenden Konzepten von Elgg bereits vertraut bist, wie beispielsweise: Diese Anleitung zeigt Dir, wie Du ein einfaches Elgg-Plugin erstellen kannst, das eine neue Seite hinzufügt und auf dieser Seite den Text "Hallo Welt" ausgibt. Im Widget werden dann diese Worte ausgegeben werden. Das Laden des Widgets selbst wird dabei automatisch von Elgg übernommen. Um die neuesten my\_blog-Einträge aus der Datenbank abzurufen, verwenden wir die Funktion ``elgg_list_entities``. Hierbei ist zu beachten, dass diese Funktion nur die Einträge zurückgibt, für die der jeweilige Benutzer auch eine ausreichende Berechtigung hat, um auf sie zuzugreifen, d.h. Zugangsbeschränkungen werden automatisch berücksichtigt. Testen des Plugins Passe den Inhalt entsprechend an, damit Du als Autor des neuen Plugins aufgeführt wirst und ändere die Beschreibung, damit sie zu Deinem neuen Plugin passt. Ergänze Deine ``start.php``, damit sie wie folgt aussieht: Setze die in den Anleitungen beschriebenen Schritte um, um eine Vorstellung davon zu bekommen, wie Du Deine eigenen Elgg-Plugins entwickeln kannst. Wir müssen dann noch den my\_blog-Pagehandler anpassen, damit die neu erstellte Seite ausgegeben wird, wenn die URL ``/my_blog/all`` aufgerufen wird. Nach der Anpassung sollte die `my_blog_page_handler()``-Funktion in start.php wie folgt aussehen: Dazu erweitern wir die input/longtext-View und fügen ein wenig Javascript-Code hinzu. Erzeuge eine View namens tinymce/longtext und füge folgenden Code in ihr hinzu: Du kannst nun die Adresse http://www.mysite.com/hello/ aufrufen und solltest dann die folgende Seite angezeigt bekommen. Es sollte nun möglich sein, eine Nachricht in die Textbox einzugeben, die dann im Widget angezeigt wird. Du solltest Dir diese Abschnitte der Elgg-Dokumentation nochmals durchlesen, falls Du beim Durcharbeiten der folgenden Schritte dieser Anleitung Verständnisschwierigkeiten hast. Dein Plugin benötigt die Datei start.php, in der das Plugin initialisiert wird, und die Datei manifest.xml, mit der dem Elgg-System das Vorhandensein Deines Plugins mitgeteilt wird. Du musst die Manifest-Datei ``/mod/my_blog/manifest.xml`` erstellen. Diese Datei enthält grundlegende Informationen über das Plugin. Eine Vorlage ist unter :doc:`/guides/plugins` verfügbar. Du kannst auch die Manifest-Datei eines anderen Plugins als Vorlage nehmen und die Einträge in der Datei entsprechend anpassen. Stelle auf jeden Fall sicher, dass Du den Namen des Plugin-Autors und den Eintrag für die Webseite anpasst und den EIntrag für die “bundled”-Kategorie entfernst! einem ``<form>``-Tag und den notwendigen Attributen Anti-CSRF-Token Deine start-Datei erzeugt das Plugin initialisiert manifest.xml pages/index.php start.php den Code des WYSIWYG-Editors hinzugefügt 