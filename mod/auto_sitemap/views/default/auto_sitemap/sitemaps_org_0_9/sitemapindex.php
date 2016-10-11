<?php
/* ######################################################
 *  Ramón Iglesias / ura soul
 *  www.ureka.org
 * ###################################################### */

header ("Content-Type:text/xml");

$body .='<?xml version="1.0" encoding="UTF-8"?>';

if ( $vars['flagXsl'] )
{
    $body .='<?xml-stylesheet type="text/xsl" 
    href="' . elgg_get_site_url() . 'sitemapindex.xsl"?>
<sitemapindex
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
    http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" 
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
}
else
{
    $body .='<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
}

foreach ( $vars['sitemaps'] as $entity) 
{
    $body .= '<sitemap><loc>' . elgg_get_site_url() . 'auto_sitemap/' . $entity . '</loc></sitemap>';
}

$body .= '</sitemapindex>';

echo $body;