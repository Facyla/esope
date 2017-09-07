<?php
return array(
	
	'pdfexport'	=>	"Export PDF",
	'pdfexport:download:alt' => "Télécharger en PDF",
	'pdfexport:download:title' => "Télécharger cette publication au format PDF",
	
	// PDF introduction header
	'pdfexport:separator' => "<hr /><br /><br />",
	'pdfexport:publishedby' => "Publié par ",
	'pdfexport:publishedin' => "Publié dans ",
	'pdfexport:publisheddate' => " le ",
	'pdfexport:generated' => "Page générée le ",
	'pdfexport:generated:format' => "d/m/Y \à H:i",
	'pdfexport:entitydate:format' => "d/m/Y",
	'pdfexport:lastupdated' => "dernière mise à jour le ",
	'pdfexport:tags' => "Tags ",
	
	// Errors
	'pdfexport:externalhtml' => "Page générée à partir d'un texte non issu de ce site",
	'pdfexport:error:guid' => "Pas de page à exporter ou GUID invalide",
	'pdfexport:error:badtype' => "Export impossible pour ce type d'entité.",
	'pdfexport:error:user' => "Export des membres du site impossible.",
	'pdfexport:error:group' => "Export des groupes impossible.",
	'pdfexport:error:site' => "Export des espaces impossible.",
	
	// Settings
	'pdf_export:disableintro' => "Désactiver le bloc d'introduction en entête des pages exportées en PDF (non par défaut, car cela fournit des informations utiles sur la page exportée)",
	'pdf_export:validsubtypes' => "Types de publications (subtypes) pour lesquelles un export PDF est disponible. Effacer pour récupérer la liste par défaut.",
	'pdf_export:validsubtypes:default' => "Liste par défaut : %s",
	
);

