<?php

// Rediriger vers l'action de logout native d'Elgg.
// L'event 'logout:after' (enregistré dans Bootstrap.php) interceptera le logout
// et redirigera vers le provider OIDC si l'utilisateur est un utilisateur SSO.
// Pour les utilisateurs locaux, le logout natif s'applique normalement.
openid_connect_forward(elgg_get_site_url() . 'action/logout');
