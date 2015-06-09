{
	"geometry": {
		"type": "Point",
		"coordinates": [<?php echo $vars['coordinates']; ?>]
	},
	"type": "Feature",
	"properties": {
		"popupContent": "<?php echo $vars['content']; ?>"
<?php if (!empty($vars['style'])) { echo ', "style": { ' . $vars['style'] . '}'; } ?>
	}
<?php if (!empty($vars['id'])) { echo ', "id": ' . $vars['id'] . ''; } ?>
},

