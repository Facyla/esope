<?php

return array(

	/**
	 * Menu items and titles
	 */
	'poll' => "Kyselyt",
	'survey:add' => "Uusi kysely",
	'survey:group_poll' => "Ryhmän kyselyt",
	'survey:group_poll:listing:title' => "Käyttäjän %s kyselyt",
	'survey:your' => "Omat kyselysi",
	'survey:not_me' => "Käyttäjän %s kyselyt",
	'survey:friends' => "Ystäviesi kyselyt",
	'survey:addpost' => "Luo uusi kysely",
	'survey:editpost' => "Muokkaa kyselyä: %s",
	'survey:edit' => "Muokkaa kyselyä",
	'item:object:poll' => 'Kyselyt',
	'item:object:poll_choice' => "Vaihtoehdot",
	'survey:question' => "Kyselyn nimi",
	'survey:description' => "Kuvaus",
	'survey:responses' => "Vastausvaihtoehdot",
	'survey:result:label' => "%s (%s)",
	'survey:show_results' => "Näytä tulokset",
	'survey:show_poll' => "Näytä kysely",
	'survey:add_choice' => "Lisää uusi vaihtoehto",
	'survey:delete_choice' => "Poista tämä vaihtoehto",
	'survey:close_date' => "Kyselyn päättymispäivä",
	'survey:voting_ended' => "Äänestys sulkeutui %s.",
	'survey:poll_closing_date' => "(Kyselyn sulkeutumisajankohta: %s)",

	'survey:convert:description' => 'VAROITUS: Löydettiin %s kyselyä, jotka eivät ole yhteensopivia nykyisen version kanssa.',
	'survey:convert' => 'Päivitä kyselyt',
	'survey:convert:confirm' => 'Päivitystä ei voi perua. Haluatko varmasti päivittää kyselyt?',

	'survey:settings:group:title' => "Salli ryhmien kyselyt?",
	'survey:settings:group_poll_default' => "Kyllä",
	'survey:settings:group_poll_not_default' => "Ei",
	'survey:settings:no' => "Ei",
	'survey:settings:group_access:title' => "Kuva voi luoda kyselyitä ryhmiin?",
	'survey:settings:group_access:admins' => "Ryhmien omistajat sekä sivuston ylläpitäjät",
	'survey:settings:group_access:members' => "Ryhmän jäsenet",
	'survey:settings:front_page:title' => 'Ota käyttöön mahdollisuus tehdä kyselystä "Päivän kysely"? (Vaatii Widget manager -pluginin.)',
	'survey:settings:allow_close_date:title' => "Ota käyttöön kyselyn sulkeutumispäivä?",
	'survey:settings:allow_open_poll:title' => "Ota käyttöön avoimet kyselyt? (Näyttää vastausten kohdalla niihin vastanneet henkilöt)",
	'survey:none' => "Ei kyselyitä",
	'survey:not_found' => "Kyselyä ei löytynyt",
	'survey:permission_error' => "Sinulla ei ole oikeuksia tämän kyselyn muokkaamiseen",
	'survey:vote' => "Vastaa",
	'survey:login' => "Kirjaudu sisään vastataksesi tähän kyselyyn",
	'group:poll:empty' => "Ei kyselyitä",
	'survey:settings:site_access:title' => "Kuka voi luoda sivustonlaajuisia kyselyitä?",
	'survey:settings:site_access:admins' => "Vain ylläpitäjät",
	'survey:settings:site_access:all' => "Sisäänkirjautuneet käyttäjät",
	'survey:can_not_create' => "Sinulla ei ole oikeuksia luoda uutta kyselyä",
	'survey:front_page_label' => 'Tee tästä "Päivän kysely"',
	'survey:open_poll_label' => "Näytä tuloksien yhteydessä, kuka on vastannut mihinkin kysymykseen",
	'survey:show_voters' => "Näytä vastaajat",

	/**
	 * Poll widget
	 */
	'survey:latest_widget_title' => "Uusimmat kyselyt",
	'survey:latest_widget_description' => "Näyttää sivuston viimeisimmät kyselyt",
	'survey:latestgroup_widget_title' => "Ryhmän uusimmat kyselyt",
	'survey:latestgroup_widget_description' => "Näyttää ryhmän viimeisimmät kyselyt",
	'survey:my_widget_title' => "Omat kyselyni",
	'survey:my_widget_description' => "Näyttää omat kyselysi",
	'survey:widget:label:displaynum' => "Näytettävien kyselyiden määrä",
	'survey:individual' => "Päivän kysely",
	'poll_individual:widget:description' => "Näyttää päivän kyselyn",
	'survey:widget:no_poll' => "%s ei ole vielä luonut kyselyitä.",
	'survey:widget:nonefound' => "Ei kyselyitä.",
	'survey:widget:think' => "Vastaa käyttäjän %s kyselyihin!",
	'survey:enable_poll' => "Ota käytöön ryhmän kyselyt",
	'survey:noun_response' => "ääni",
	'survey:noun_responses' => "ääntä",
	'survey:settings:yes' => "Kyllä",
	'survey:settings:no' => "Ei",

	'survey:month:01' => 'Tammikuuta',
	'survey:month:02' => 'Helmikuuta',
	'survey:month:03' => 'Maaliskuuta',
	'survey:month:04' => 'Huhtikuuta',
	'survey:month:05' => 'Toukokuuta',
	'survey:month:06' => 'Kesäkuuta',
	'survey:month:07' => 'Heinäkuuta',
	'survey:month:08' => 'Elokuuta',
	'survey:month:09' => 'Syyskuuta',
	'survey:month:10' => 'Lokakuuta',
	'survey:month:11' => 'Marraskuuta',
	'survey:month:12' => 'Joulukuuta',

	/**
	 * Notifications
	 */
	'survey:new' => 'Uusi kysely',
	'survey:notify:summary' => 'Uusi kysely: %s',
	'survey:notify:subject' => 'Uusi kysely: %s',
	'survey:notify:body' => '%s on luonut uuden kyselyn: %s

Vastaa kyselyyn täällä: %s
',

	/**
	 * Poll river
	 */
	'survey:settings:create_in_river:title' => "Näytä uudet kyselyt toimintalistauksessa?",
	'survey:settings:vote_in_river:title' => "Näytä yksittäiset äänet toimintalistauksessa?",
	'survey:settings:send_notification:title' => "Lähetä ilmoitukset uusista kyselyistä?",
	'river:create:object:poll' => '%s loi kyselyn %s',
	'river:vote:object:poll' => '%s vastasi kyselyyn %s',
	'river:comment:object:poll' => '%s kommentoi kyselyä %s',

	/**
	 * Status messages
	 */
	'survey:added' => "Lisättiin uusi kysely",
	'survey:edited' => "Kysely tallennettu",
	'survey:responded' => "Ääni tallennettu. Kiitos vastauksestasi.",
	'survey:deleted' => "Kysely poistettu",
	'survey:totalvotes' => "Vastausten kokonaismäärä: %s",
	'survey:voted' => "Ääni tallennettu. Kiitos vastauksestasi.",

	/**
	 * Error messages
	 */
	'survey:blank' => "Syötä vähintään nimi sekä yksi vastausvaihtoehto",
	'survey:novote' => "Valitse jokin vastausvaihtoehdoista",
	'survey:alreadyvoted' => "Olet vastannut tähän kyselyyn jo aiemmin",
	'survey:notfound' => "Kyselyä ei löytynyt",
	'survey:notdeleted' => "Kyselyn poistaminen epäonnistui",
);


