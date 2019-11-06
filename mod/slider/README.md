# slider
Provides a slider object and configurable slider views

This plugin provides a customizable slider view.

One main slider can be configured by admins for the site.

More sliders can be edited by users.
Sliders can be included into Elgg content using a shortcode, into cmspages using a custom call code, or as an iframe for external sites embed.


## Included Sliders
- Anything slider : Responsive, any content. This is the main sliders used by this plugin.

The other sliders libraries are included, but not directly used ; these are the ones used by the "Meta slider" extension for WordPress. 
They are available for developpers to build upon them.
- Nivo Slider : Responsive, 16 transition effects, 4 themes
- Flex Slider 2 : Responsive, 2 transition effects, carousel mode
- Responsive Slides : Responsive & light weight
- Coin Slider : 4 transition effects


## History

0.9 : 20150719
  - Update to Elgg 1.11
  - Specific rendering views for 5 different slider vendors

0.8 : 20150522
  - unique identifier (allows to call a slider by its name)

0.7 : 20150415
  - editor switch
  - new form structure

0.6 : 20150414 - slider editor
  - fully functionnal slider editor (add/remove slides, reordering)
  - add display view
  - add slider shortcode

0.5 : 20150414 - start slider editor
  - add a bunch of slider libraries
  - set basic editor structure

0.4 : updated to Elgg 1.8
	- new version for Elgg 1.8
	- new library : NivoSlider replaced by AnythingSlider https://github.com/CSS-Tricks/AnythingSlider/

0.3.3 : 2012.08.30
  - allow localadmins to change plugin settings

0.3.2 : 2012.08.30
  - changed settings : from 1 to 15 slides

0.3.1 : 2012.08.22
  - changed settings to use longtext input for HTML content

0.3 : 2011.09.19 - default slider
  - admin settings for default slider (from 2 to 9 slides, image, link, HTML caption)
  - usage : echo elgg_view('slider/slider');

0.2 : css loaded as a view (instead of extending metatags)

