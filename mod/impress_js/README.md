# Impress.js Elgg plugin

This plugin wraps https://github.com/bartaz/impress.js into an Elgg plugin, to provide developers with usable library and eventually views and authoring tools.

Impress.js is "a presentation framework based on the power of CSS3 transforms and transitions in modern browsers and inspired by the idea behind prezi.com.
Watch presentaiton and demo on http://bartaz.github.com/impress.js"


# Impress editors
The plugin also embeds a few editors, and some other have been tested too ; here are some tests results :

### Impressionnist
The editor has not much evolved since 2013, but it works nicely. 
Allow localstorage saving + export HTML. 
Slides-like interface, can use text formatting and images. Use "orchestrate" view to place slides on a map.

### Strut
Tech note : use git repo to build a client-side dist.
This one is impressive : can embed live websites, videos, shapes.
3 export modes : 
1. Impress : impress.js style presentation (similar to Prezi)
2. Bespoke : portfolio slideshow
3. Handouts : presentation mode of slides, with side notes

### Builder4impress
That one is pretty basic, and UI is "textful", but it works

### Azexo composer
It is more a webpage editor than a presentation tool.
Promising but not so open as latest releases and CMS integrations are paid-versions. 
Opensource version requires some integration because it uses a bunch of dependencies, and does not seem to use so much of Impress.js in fact.

### Dyapos
This project seems nice but is a Python project : so it cannot be used as an Elgg plugin.

### Impressify
Looks like a one-shot student project (for BP).



# Attributes API
This is a summary of the available attributes. Every effort will be made to keep it up to date. However, the project (as usual) evolves faster than the documentation. Refer to the code for details if you encounter trouble following this advice:

## SYSTEMIC ATTRIBUTES
Apply these to your #impress element.

### Animation Speed
data-transition-duration
Specified in milliseconds. Effects all impress functions/transitions. May one day be applicable to individual steps, but for now only exists globally.



## STEP FRAME ATTRIBUTES

### Cartesian Position
Where in 3D space to position the step frame in Cartesian space.

#### data-x, data-y, data-z
Define the origin location in 3D Cartesian space. Specified in pixels (sort-of).

#### data-rotate
Rotation of the step frame about its origin in the X-Y plane. This is akin to rotating a piece of paper in front of your face while maintaining it's ortho-normality to your image plane (did that explanation help? I didn't think so...). It rotates the way a photo viewer rotates, like when changing from portrait to landscape view.


### Polar Position
Rotation of the step frame about its origin along the theta (azimuth) and phi (elevation) axes. This effect is similar to tilting the frame away from you (elevation) or imaging it standing on a turntable -- and then rotating the turntable (azimuth).

#### data-rotate-x
Rotation along the theta (azimuth) axis

#### data-rotate-y
Rotation along the phi (elevation) axis


### Size
#### data-scale
The multiple of the "normal" size of the step frame. Has no absolute visual impact, but works to create relative size differences between frames. Effectively, it is controlling how "close" the camera is placed relative to the step frame.


