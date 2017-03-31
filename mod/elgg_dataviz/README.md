D3js
====

This plugin adds visualisation libraries to Esope https://github.com/Facyla/esope
 - Chart.js
 - D3.js
 - NVD3
 - Dygraphs
 - Vega
 - Crossfilter
 - DataTables (jQuery plugin)
 - Raphaël (SVG)
 - AnyChart (also CDN : https://cdn.anychart.com/js/latest/anychart-bundle.min.js)

See also DataWrapper, which is an interesting, but standalone app (not included)


It uses these libraries to enable data visualisations as reusable Elgg views.


## Installation
- upload repository content to /mod/elgg_dataviz/
- Go to Admin > Administer plugins and enable "Data Visualisation" plugin


## Usage

### Examples
- Go to {elgg_site_url}/dataviz for a list of example of visualisations
- See pages/elgg_dataviz/index.php for view calling examples

### Developpers
- Use elgg_dataviz/[viz_name] views for generic visualisation views
- Use elgg_dataviz/[viz_lib]/[viz_name] views for library-specific views

For new visualisations
- call elgg_require_js('elgg.dataviz.viz_lib') to include wanted JS lib



