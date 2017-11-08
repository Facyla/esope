#leaflet-container {  }
#leaflet-main-map { width:100%; height:500px; }


.leaflet-textcontent { font-size:20px; text-shadow: 1px 1px 1px #fff; padding: 0 1ex; width: 90%; margin: 1ex auto 3ex auto; border: 1px solid black; background: rgba(255,255,255,0.95); }

.leaflet-map-message { text-align:center; position: absolute; top: 0; left: 0; right:0; bottom:0; background:rgba(255,255,255,0.6); z-index: 1002; padding: 5ex 10%; }



/* Map messages */
#locationerror { background: red; display: block; position: absolute; top: 0; padding: 0.1ex 0.4ex; }
#centermap { position: absolute; top: 0; right:0; margin-top:64px; margin-right: 66px; background: rgba(255,255,255,0.6); padding: 0; box-shadow: 0 1px 5px rgba(0,0,0,0.4); border-radius: 5px; height:36px; width:36px; }
#centermap a { display: block; height: 36px; width: 36px; text-align: center; text-decoration: none; color: #fff; font-size: 30px; line-height: 36px; text-shadow: 0px 0px 2px #000; }


/* Leaflet elements */
.leaflet-container a { text-decoration: none; }



#loading { position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 1500; text-align: center; font-size: 3ex; color: white; }
#loading i { position: absolute; bottom: 50%; }


/* Font Awesome icons style */
.leaflet-map-pane [class*="fa-"]:before { margin:0; padding:0; }



/* ROUTING */
/* @TODO Workaround pour modifier rendu mais pas top...
*/
.leaflet-overlay-pane path[stroke=black] { stroke-width: 9px; }
.leaflet-overlay-pane path[stroke=white] { stroke-width: 6px; }
.leaflet-overlay-pane path[stroke=orange] { stroke: red; stroke-width: 4px; }
.leaflet-marker-draggable { display: none; }

.leaflet-routing-container { width:auto; }
.leaflet-bar { box-shadow:none; border-radius:0; }
.leaflet-routing-alt, .leaflet-routing-geocoders { max-height:none; }
.leaflet-routing-alt-minimized { max-height:6ex; }


