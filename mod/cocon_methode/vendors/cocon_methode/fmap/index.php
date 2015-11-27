<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="IE=Edge" http-equiv="X-UA-Compatible">
	<title>Coll&egrave;ges connect&eacute;s</title>
	<meta http-equiv="pragma" content="no-cache" />
    <meta name="expires" content="tue, 01 Jun 2010 19:45:00 GMT" />
	<link rel="stylesheet" media="all" href="css/global.css" />
	<link rel="stylesheet" media="all" href="css/font-awesome.min.css" />
	<script type="text/javascript" src="js/jquery/jquery-1.7.2.js"></script>
	<script type="text/javascript" type="text/javascript" src="js/utils/utils.js"></script>
	<script type="text/javascript" src="js/utils/querystring.js"></script>
	<script type="text/javascript" src="js/utils/ajax_delegate.js"></script>
	<script type="text/javascript" src="js/explorer.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />
	<link rel="shortcut icon" type="image/png" href="css/images/favicon.png" />
	
	<style type="text/css">
		
		td.fiche_item{
			width: 12.5%;
			height: 80px;
			text-align: center;
			vertical-align: middle;
			cursor:pointer;
			color:#000000;
			font-size:12px;
		}

		#black_mask{
			position: absolute;
			width: 100%;
			height: 100%;
			background-color:#666666;
			left:0px;
			top:0px;
			opacity: 0.4;
			filter: alpha(opacity=40); /* For IE8 and earlier */
			display:none;
		}

		#float_win{
			position:absolute;
			left:0px;
			top:0px;
			width:0px;
			height:0px;
			overflow:auto;
			display:none;
			background-color:#ffffff;
			-moz-box-shadow: 0px 0px 10px 5px #cfcfcf;
			-webkit-box-shadow: 0px 0px 10px 5px #cfcfcf;
			-o-box-shadow: 0px 0px 10px 5px #cfcfcf;
			box-shadow: 0px 0px 10px 5px #cfcfcf;
			filter:progid:DXImageTransform.Microsoft.Shadow(color=#cfcfcf, Direction=NaN, Strength=10);	
		}
		
	</style>
</head>

<body>
	<div id="content" class="content">
		<header>
			<div class="">
				<div class="interne">
					<h1>
						<img src="css/images/header_ministere.jpg" class="ministere">
						<a title="Aller sur la page d'accueil" href="http://cocon.eduscol.education.fr/"><img style="margin-left:14px;" src="css/images/header_cocon.png" class="cocon"></a>
						<img src="css/images/cartouche_strategie_numerique.png" class="cartouche">
					</h1>
					<nav>
					</nav>					
				</div>
			</div>
		</header>
		<section>
			<div class="interne interne-content">
				<table class="app_table" id="app_table" style="background-color:#ffffff;width:100%">
					<tr>
						<td colspan="4" class="app_title" style="background-color:#eeeeee;height: 24px;">Vos fiches de mise en pratique</td>
					</tr>
					<tr>
						<td colspan="3" class="app_content" id="app_content"></td>
					</tr>
					<tr>
						<td colspan="3">
							<table width="100%">
								<tr>
									<td class="app_menu" width="25%" id="btnNew" onclick="javascript:newFiche();">Créer une nouvelle fiche</td>
									<td class="app_menu" width="25%" id="btnEdit" onclick="javascript:editFiche();">Modifier la fiche</td>
									<td class="app_menu" width="25%" id="btnEdit" onclick="javascript:downloadFiche();">Télécharger la fiche</td>
									<td class="app_menu" width="25%" id="btnDel" onclick="javascript:removeFiche();">Supprimer la fiche</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div id="app_loader">
					<div></div>
				</div>
				<div id="black_mask" onclick="javascript:closeFloatWin();"></div>				
				<div id="float_win" class="center"></div>
			</div>
		</section>
		<footer class="footer-cocon">
			<div class="interne">
				<ul>
				</ul>
			</div>
		</footer>		
	</div>
</body>