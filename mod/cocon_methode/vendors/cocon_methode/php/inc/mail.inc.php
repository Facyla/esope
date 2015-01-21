<?php
	function createHTMLEmail($_model){
		$message = '';
		if(file_exists(PATH_ROOT.'/_mail/mail.html')){
			$message = file_get_contents(PATH_ROOT.'/_mail/mail.html');
		}else{
			return false;
		}

		if(file_exists(PATH_ROOT.'/_mail/'.$_model.'.html')){
			$message = str_replace("%message%", file_get_contents(PATH_ROOT.'/_mail/'.$_model.'.html'), $message);
		}else{
			return false;
		}
		$message = str_replace("%SITE_URL%", SITE_URL, $message);
		$message = str_replace("%SITE_NAME%", SITE_NAME, $message);
		
		return $message;
	}
	
	/**
	 * Envoi un email au format HTML.
	 * @param String $target : Destinataire
	 * @param String $subject : Objet du message
	 * @param String $message : Corps du message
	 */
	function sendMail($target, $subject, $message){
		global $_server;
		
		// Si le serveur est local, alors on n'envoi pas d'email.
		if($_server == 'local'){
			return true;
		}
		
		$headers = '';
		$headers = "MIME-Version: 1.0\n";
		$headers .= "From: Service notification<".EMAIL_SENDER.">\n";
		$headers .= "Content-Type: text/html; charset=utf-8";

		return mail($target, $subject, $message, $headers);
	}
	
?>