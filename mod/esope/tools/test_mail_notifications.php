<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php';

admin_gatekeeper();

// Deprecated tool URL
$full_url = full_url();
error_log("Deprecated tools URL used : $full_url - redirecting to esope/tools");
register_error("Ces outils sont désormais accessibles depuis une page unique d'outils d'administration avancés. Veuillez mettre à jour vos marques-pages.");
forward('esope/tools');

