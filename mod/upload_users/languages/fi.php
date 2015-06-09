<?php


$finnish = array( 
	 'upload_users:upload_users'  =>  "Lähetä käyttäjät" , 
	 'upload_users:choose_file'  =>  "Valitse tiedosto" , 
	 'upload_users:encoding'  =>  "Valitse merkistö" , 
	 'upload_users:delimiter'  =>  "Valitse erotin" , 
	 'upload_users:send_email'  =>  "Lähetä sähköposti uusille käyttäjille" , 
	 'upload_users:yes'  =>  "Kyllä" , 
	 'upload_users:no'  =>  "Ei" , 
'upload_users:create_users' => 'Luo käyttäjätunnukset',
'upload_users:success'  =>  "Käyttäjän luominen onnistui" ,
	'upload_users:creation_report' => 'raportti luoduista käyttäjistä',
	'upload_users:process_report' => 'Luotavien käyttäjien esikatselu',
'upload_users:no_created_users' => 'Ei luotuja käyttäjiä.',
	'upload_users:number_of_accounts'  =>  "Käyttäjien kokonaismäärä" , 
	 'upload_users:number_of_errors'  =>  "Virheiden määrä" , 
	 'upload_users:statusok' => 'Käyttäjä voidaan luoda',
	 'upload_users:submit'  =>  "Lähetä" , 
	 'upload_users:upload_help'  =>  "<p>Valitse CSV-tiedosto ja lähetä se luodaksesi uusia käyttäjiä.</p><p>
Ensimmäisellä rivillä pitää olla tiedot sarakkeiden sisällöstä. Vaadittuja kenttiä ovat username (käyttäjätunnus), name (koko nimi) ja email (sähköpostiosoite). Jos salasanakenttää (password) ei ole tiedostossa, luo järjestelmä satunnaisen salasanan käyttäjälle. Halutessasi käyttäjätunnukset lähetetään käyttäjille sähköpostilla.</p><p>
Voit määrittää tiedostossa niin monta kenttää kuin haluat. Ylimääräisten kenttien tiedot lisätään käyttäjän metadataan. Jos kenttien erottimena on jokin muu kuin pilkku (,), voit kentän arvo olla pilkulla erotettu tagi-lista.</p><p>
Tässä on esimerkki CSV-tiedostosta:</p>" , 
	 'upload_users:error:file_open_error'  =>  "Virhe avattaessa tiedostoa" , 
	 'upload_users:error:wrong_csv_format'  =>  "CSV-tiedosto on väärässä formaatissa" , 
	 'upload_users:email:message'  =>  "Hei %s!

Sinulle on luotu käyttäjätunnus %s -palveluun. Käytä käyttäjätunnustasi ja salasanaasi kirjautuaksesi sisään.

Käyttäjätunnus: %s
Salasana: %s

Menee osoitteeseen %s kirjautuaksesi sisään." , 
	 'upload_users:email:subject'  =>  "Käyttäjätunnuksesi %s -palveluun"
); 

add_translation('fi', $finnish); 

?>