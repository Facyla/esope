<?php
/**
 * Elgg Market Plugin
 * @package market
 */

return array(
	
	// Menu items and titles	
	'market' => "Annoncer",
	'market:posts' => "Annonce",
	'market:title' => "Markedet",
	'market:user:title' => "%s's annoncer",
	'market:user' => "%s's annoncer",
	'market:user:friends' => "%s's venners annoncer",
	'market:user:friends:title' => "%s's venners annoncer",
	'market:mine' => "Mine annoncer",
	'market:mine:title' => "Mine annoncer p&aring; Markedet",
	'market:posttitle' => "%s's annonce: %s",
	'market:friends' => "Venners annoncer",
	'market:friends:title' => "Mine venners annoncer p&aring; Markedet",
	'market:everyone:title' => "Alt på Markedet",
	'market:everyone' => "Hele Markedet",
	'market:read' => "Vis annonce",
	'market:add' => "Opret ny annonce",
	'market:add:title' => "Opret en ny annonce p&aring; Markedet",
	'market:edit' => "Ret annonce",
	'market:imagelimitation' => "(Skal være JPG, GIF eller PNG)",
	'market:text' => "Giv en kort beskrivelse af tingen",
	'market:uploadimages' => "Tilføj billeder til din annonce.",
	'market:uploadimage1' => "Billede 1 (forside billede)",
	'market:uploadimage2' => "Billede 2",
	'market:uploadimage3' => "Billede 3",
	'market:uploadimage4' => "Billede 4",
	'market:image' => "Annonce billede",
	'market:delete:image' => "Slet dette billede",
	'market:imagelater' => "",
	'market:strapline' => "Oprettet",
	'item:object:market' => 'Markeds annoncer',
	'market:none:found' => 'Ingen annoncer fundet',
	'market:pmbuttontext' => "Send privat besked",
	'market:price' => "Pris",
	'market:price:help' => "(i %s)",
	'market:text:help' => "(Ingen HTML og maks. %s tegn)",
	'market:title:help' => "(1-3 ord)",
	'market:location' => "Lokation",
	'market:location:help' => "(hvor er denne vare placeret)",
	'market:tags' => "Nøgleord",
	'market:tags:help' => "(Adskil med kommaer)",
	'market:access:help' => "(Hvem kan se denne annonce)",
	'market:replies' => "Svar",
	'market:created:gallery' => "Oprettet af %s <br>D. %s",
	'market:created:listing' => "Oprettet af %s D. %s",
	'market:showbig' => "Vis større billedee",
	'market:type' => "Type",
	'market:type:choose' => 'Vælg annoncetype',
	'market:choose' => "Vælg en...",
	'market:charleft' => "tegn tilbage",
	'market:accept:terms' => "Jeg har læst og forstået %s",
	'market:terms' => "betingelser",
	'market:terms:title' => "Betingelser for brug",
	'market:terms' => "<li class='elgg-divide-bottom'>Annoncerne er et brugtmarked for medlemmerne.</li>
			<li class='elgg-divide-bottom'>Vi tillader kun en annonce pr. ting.</li>
			<li class='elgg-divide-bottom'>En annonce må kun indeholde een ting, medmindre de hører sammen som et sæt.</li>
			<li class='elgg-divide-bottom'>Der må kun annonceres for brugte/hjemmelavede ting.</li>
			<li class='elgg-divide-bottom'>Når du har opnået det ønskede med annoncen skal den slettes.</li>
			<li class='elgg-divide-bottom'>Annoncer slettes automatisk efter %s måned(er).</li>
			<li class='elgg-divide-bottom'>Erhvervsmæssig annoncering er kun for dem der har tegnet en reklameaftale med os.</li>
			<li class='elgg-divide-bottom'>Vi forbeholder os retten til at slette annoncer vi mener overtræder, eller forsøger at omgå, betingelserne for brug.</li>
			<li class='elgg-divide-bottom'>Betingelserne kan til enhver tid ændres.</li>
			",
	'market:new:post' => "Ny annonce i Markedet",
	'market:notification' =>
'%s tilføjede en ny annonce i Markedet:

%s - %s
%s

Se annoncen her:
%s
',
	
	// market widget
	'market:widget' => "Mit Marked",
	'market:widget:description' => "Fremvis dit Marked",
	'market:widget:viewall' => "Vis alt på mit Marked",
	'market:num_display' => "Antal der skal vises",
	'market:icon_size' => "Ikon størrelse",
	'market:small' => "lille",
	'market:tiny' => "mikro",
		
	// market river
	'river:create:object:market' => '%s oprettede en annonce på Markedet med titlen %s',
	'river:update:object:market' => '%s opdaterede annoncen %s på Markedet',
	'river:comment:object:market' => '%s skrev et svar til annoncen %s',

	// Status messages
	'market:posted' => "Din annonce blev oprettet.",
	'market:deleted' => "Din annonce er blevet slettet.",
	'market:uploaded' => "Dit billede blev tilføjet.",
	'market:image:deleted' => "Dit billede blev slettet.",

	// Error messages	
	'market:save:failure' => "Din annonce kunne ikke oprettes. Pr&oslash;v igen.",
	'market:error:missing:title' => "Fejl: Du skal angive en titel!",
	'market:error:missing:description' => "Fejl: Du skal skrive en beskrivelse!",
	'market:error:missing:marketcategory' => "Fejl: Du skal angive en kategori!",
	'market:error:missing:price' => "Fejl: Du skal angive en pris!",
	'market:error:missing:market_type' => "Fejl: Du skal angive en annoncetype!",
	'market:tobig' => "Fejl: Dit billede er for stort.",
	'market:notjpg' => "Du kan kun uploade jpg, png eller gif billeder.",
	'market:notuploaded' => "Fejl: Dit billede blev ikke tilføjet.",
	'market:image:notdeleted' => "Fejl: Dit billede blev ikke slettet!",
	'market:notfound' => "Fejl: Den valgte annonce kunne ikke findes.",
	'market:notdeleted' => "Fejl: Kunne ikke slette denne annonce.",
	'market:tomany' => "Fejl: For mange annoncer",
	'market:tomany:text' => "Du kan ikke oprette flere annoncer, slet nogen for at oprette nye!",
	'market:accept:terms:error' => "Du skal acceptere vores betingelser for brug!",
	'market:error' => "Fejl: Kan ikke gemme annonce!",
	'market:error:cannot_write_to_container' => "Fejl: Kan ikke skrive til container!",

	// Settings
	'market:settings:status' => "Status",
	'market:settings:desc' => "Beskrivelse",
	'market:max:posts' => "Maks. antal annoncer pr. bruger",
	'market:unlimited' => "Ubegrænset",
	'market:currency' => "Valuta ($, €, DKK eller noget)",
	'market:allowhtml' => "Tillad HTML i annoncer",
	'market:numchars' => "Maks antal tegn i annonce (kun tekst)",
	'market:pmbutton' => "Aktiver privat besked-knap",
	'market:location:field' => "Aktiver et lokationsfelt",
	'market:adminonly' => "Kun admin kan oprette annoncer",
	'market:comments' => "Tillad kommentarer",
	'market:custom' => "Tilpasset felt",
	'market:settings:type' => 'Aktiver annoncetyper (køb/salg/bytte/bortgives)',	
	'market:type:all' => "Alle",
	'market:type:buy' => "Købes",
	'market:type:sell' => "Sælges",
	'market:type:swap' => "Byttes",
	'market:type:free' => "Bortgives",
	'market:expire' => "Auto slet annoncer ældre end",
	'market:expire:month' => "måned",
	'market:expire:months' => "måneder",
	'market:expire:subject' => "Din annonce er udløbet",
	'market:expire:body' => "Hej %s

Din annonce '%s', du oprettede %s, er blevet slettet.

Dette sker automatisk når annoncer er ældre end %s måned(er).",

	// market categories
	'market:categories' => 'Markeds Kategorier',
	'market:categories:choose' => 'Vælg kategori',
	'market:categories:settings' => 'Markeds Kategorier:',	
	'market:categories:explanation' => 'Opret nogen emnekategorier.<br>Skriv dem i formen ""clothes, footwear, furniture osv...", adskil med kommaer - husk at tilføje oversættelser i sprog-filerne som market:category:<i>categoryname</i>',	
	'market:categories:save:success' => 'Annonce kategorier blev gemt.',
	'market:categories:settings:categories' => 'Markeds Kategorier',
	'market:category:all' => "Alle",
	'market:category' => "Kategori",
	'market:category:title' => "Kategori: %s",

	// Categories
	'market:category:clothes' => "Tøj/sko",
	'market:category:furniture' => "Møbler og indretning",
	'market:category:other' => "Andet",
	
	// Custom select
	'market:custom:select' => "Angiv tingens tilstand",
	'market:custom:text' => "Stand",
	'market:custom:activate' => "Aktiver tilpasset vælger:",
	'market:custom:settings' => "Valgmuligheder for tilpasset vælger",
	'market:custom:choices' => "Opret nogen valg til den tilpassede dropdown boks.<br>Valgmulighederne kunne fx. v&aelig;re \"market:custom:new,market:custom:used...osv\", adskil med kommaer - husk at tilf&oslash;je overs&aelig;ttelser i sprog-filerne.",

	// Custom choises
	 'market:custom:na' => "Ikke angivet",
	 'market:custom:new' => "Ny",
	 'market:custom:unused' => "Ubrugt",
	 'market:custom:used' => "Brugt",
	 'market:custom:good' => "God",
	 'market:custom:fair' => "Rimelig",
	 'market:custom:poor' => "Dårlig",
);

