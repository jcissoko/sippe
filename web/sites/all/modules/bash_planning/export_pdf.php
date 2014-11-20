<?php
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

$retour = 1;

if(!empty($_POST['table']) && !empty($_POST['classe']))
{
	$promo_planning = $_POST['classe'];

	/********************************************************************************************	création fichier pdf	*********************************************************************************/
	$table = $_POST['table'];
	$css = file_get_contents('export_pdf.css');
	
	$html2convert = "<style type='text/css'>".$css."</style>".$table;
	
	$fileName = "./AquaPlannings/Planning_$promo_planning.pdf";
	
	$html2pdf = new HTML2PDF('P','A3','fr');
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->WriteHTML($html2convert);
	$content_PDF = $html2pdf->Output('', true);		//on écrit dans une variable
	
	file_put_contents($fileName, $content_PDF);		//on écrit ensuite dans un fichier
	
	/*******************************************************************************************	Envoi du mail	*******************************************************************************************/
	// Déclaration de l'adresse de destination.
	if($promo_planning == 'M1')
	{
		$mail = 'sippe1@googlegroups.com'; 		//sippe1@googlegroups.com
	}
	else
	{
		$mail = 'sippe2@googlegroups.com';		//sippe2@googlegroups.com
	}
	
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_html = "<html><head></head><body><p>Bonjour, <br/><br/>vous trouverez ci-joint le nouvel emploi du temps.<br/><br/>Cordialement</p></body></html>";
	//==========
	 
	//=====Lecture et mise en forme de la pièce jointe.
	$attachement = chunk_split(base64_encode(file_get_contents("./AquaPlannings/Planning_$promo_planning.pdf")));
	/*fclose($fichier);*/
	//==========

	//=====Création de la boundary.
	$boundary = "-----=".md5(rand());
	$boundary_alt = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Nouvel emploi du temps";
	//=========

	//=====Création du header de l'e-mail.
	$header = "From: \"VAIRET Isabelle\"<i.vairet@vichy-valallier.fr>".$passage_ligne;
	$header.= "Reply-to: \"VAIRET Isabelle\" <i.vairet@vichy-valallier.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	 
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
	$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
	 
	//=====Ajout du message au format HTML.
	$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========

	//=====On ferme la boundary alternative.
	$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
	//==========
	 
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	 
	//=====Ajout de la pièce jointe.
	$message.= "Content-Type: application/pdf; name=\"EDT.pdf\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
	$message.= "Content-Disposition: attachment; filename=\"EDT.pdf\"".$passage_ligne;
	$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne; 
	//========== 
	
	//=====Envoi de l'e-mail.
	if(!mail($mail,$sujet,$message,$header))
		$retour = -2;
	//==========
}
else
	$retour = -1;
echo $retour;