<?php
global $CONFIG;
$shared_url = full_url();

/*
<div id="fb-root" style="float:right;"></div><script src="http://connect.facebook.net/en_US/all.js#appId=5936143137&amp;xfbml=1"></script><fb:like href="<?php echo $shared_url; ?>" send="false" layout="button_count" width="80" show_faces="false" font=""></fb:like>

<img src="<?php echo $CONFIG->url; ?>mod/socialshare/graphics/facebook.png" style="height:24px; margin-top:4px;" />

*/
/*
<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="formavia" data-lang="fr">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<div class="clearfloat"></div>
*/

$lang = get_current_language();


echo '<iframe src="https://www.facebook.com/plugins/like.php?locale=' . $lang . '&href=' . $shared_url . '&layout=button_count" title="' . elgg_echo('socialshare:facebook:title') . '" style="width:90px; height:20px; border:0; margin-top:2px;"></iframe>';

// <!-- Placez cette balise où vous souhaitez faire apparaître le gadget Bouton +1. -->

/*
<a href="http://twitter.com/home?status=<?php echo $shared_url; ?>"><img src="<?php echo $CONFIG->url; ?>mod/socialshare/graphics/twitter.png" /></a>
*/
echo '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr" data-hashtags="" data-dnt="true">' . elgg_echo('socialshare:twitter:title') . '</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

echo '<a href="mailto:?subject=' . elgg_echo('socialshare:mail:params', array($shared_url)) . '" title="' . elgg_echo('socialshare:mail:title') . '"><img src="' . $CONFIG->url . 'mod/socialshare/graphics/mail.png" style="height:28px; margin-top:2px;" /></a>';

/*
// Google +1
<span style="float:left;"><div class="g-plusone" data-size="tall" data-annotation="inline" data-width="120" data-href="<?php echo full_url(); ?>"></div></span>
*/

echo '<div class="clearfloat"></div>';

