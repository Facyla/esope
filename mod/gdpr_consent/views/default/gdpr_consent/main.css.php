<?php
$url = elgg_get_site_url();
?>

.gdpr-consent-banner { width: 100%; background: white; border: 1px solid black; border-width: 1px 0 1px 0; padding: .5rem 1rem; color: #333; }
.elgg-page-footer .gdpr-consent-banner a { color: #000; }
.elgg-page-footer .gdpr-consent-banner a:hover { color: #000; text-decoration: underline; }

/* Page d'un document à valider */
.gdpr-consent-overlay.gdpr_consent-document { width: 100%; }
.gdpr-consent-banner.gdpr_consent-document {  }

/* Toutes autres pages du site */
.gdpr-consent-overlay:not(.gdpr_consent-document) { position: fixed; top: 4rem; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.5); padding: 10vh 10vw; }
.gdpr-consent-banner:not(.gdpr_consent-document) {  }


#gdpr_consent-statistics {  }
#gdpr_consent-statistics th, #gdpr_consent-statistics td { border: 1px solid #333; padding: .125rem .5rem; }
#gdpr_consent-statistics th { font-weight: bold; }
#gdpr_consent-statistics td {  }


