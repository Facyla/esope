<?php
global $CONFIG;
?>
<p>Personnel Inria, si vous disposez déjà d'un compte, vous pouvez utiliser la COnnexion CAS. Pour une première connexion ou un accès extérieur, utilisez la connexion par identifiant / mot de passe</p>

<div class="elgg-cas-login">
	<a href="<?php echo $CONFIG->url; ?>cas_auth" class="elgg-button elgg-button-action cas-login"><?php echo elgg_echo('elgg_cas:loginbutton'); ?></a>
</div>


