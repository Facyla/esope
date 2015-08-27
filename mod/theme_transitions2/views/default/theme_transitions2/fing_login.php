<?php
echo '<hr />';
echo '<a href="http://reseau.fing.org/login">';
echo 'Me connecter avec mon compte Réseau Fing';
echo '</a>';

/*
Envoie les accès sur form spécifique RSFing, qui les vérifie, et répond si auth OK ou pas.
*/


$username = 'facyla';
$password = 'testtest';
$address = "http://localhost/public/departements-en-reseaux.fr/fing/auth?username=$username&password=$password";
$result = file_get_contents($address);
$obj = json_decode($result);

if ($obj->result) {
	echo "Connexion OK";
	
} else {
	echo '<blockquote>' . $obj->message . '</blockquote>';
}
echo print_r($obj, true);
echo '<hr />';


