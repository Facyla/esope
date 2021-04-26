<?php
exit;

/* TODO 
 * Plugin de gestion de la distribution via git : 
 *  - effectuer un git pull
 *  - effectuer un revert : params = présélections (avant mise à niveau, HEAD, etc.) | N commits
 *  - changer de branche
 *  - mode automatique : 
 *    * vérification tous les X intervales
 *    * délai de X jours depuis la dernière MAJ de la branche distante (pour s'assurer qu'elle est stable)
 */

//if ( $_POST['git-run'] ) {
if ( isset($_GET['git-run']) && !empty($_GET['git-run'])) {
	switch($_GET['git-run']) {
		case 'git-status': 
			echo "<p><strong>git-status</strong></p>";
			$return = shell_exec( 'cd /Datastore/www/PHP7/esope_3.3 && git status' );
			echo '<pre>' . print_r($return, true) . '</pre>';
		default:
			echo "<p>Commande invalide.</p>";
	}
} else {
	echo "<p>Aucune commande.</p>";
}

echo '<p>';
	echo '<a href="?git-run=git-status">git status</a>';
echo '</p>';

