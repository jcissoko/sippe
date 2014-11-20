<?php

	include '../../../default/settings.php';
	if($_POST)
	{
		$etat=$_POST['etat'];
		$id=$_POST['id'];

		$lesEtats = array("En attente" => 1, "Acceptée" => 2, "Refusée" => 3);

		$con = mysqli_connect($databases["default"]["default"]["host"], $databases["default"]["default"]["username"], $databases["default"]["default"]["password"], $databases["default"]["default"]["database"]);
		$result = mysqli_query($con, "UPDATE candidature SET etat='". $lesEtats[mysqli_real_escape_string($con, $etat)] ."' WHERE id_candidature='".mysqli_real_escape_string($con, $id)."'");

		$mysqli = new mysqli("91.121.70.192", "c0sippenetbeta", "sippenet","c0c0sippenet_beta");
		$query="SELECT * FROM candidature WHERE id_candidature = " . mysqli_real_escape_string($con, $id);
		
		if($result=$mysqli->query($query))
		{

			$row = $result->fetch_assoc();
			$prenom_candidat = $row['prenom_candidat'];
			$nom_candidat = $row['nom_candidat'];
			$email_candidat = $row['email_candidat'];
   			

			if($result == 1){
				$messageMailGestionCandidature = 
							"<html><head>Votre candidature au Master SIPPE a été modifiée.</head><body><p>Votre status de candidature au sein du Master Stratégies Internet et Pilotage de Projets en Entreprise a été modifié.<br/>
											Votre candidature est maintenant " . $etat . ".</body></html>";

				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		     	// En-têtes additionnels
		     	$headers .= 'To: ' . $prenom_candidat . ' ' . $nom_candidat . ' <' . $email_candidat . '>' . "\r\n";
		     	$headers .= 'From: VAIRET Isabelle <i.vairet@vichy-valallier.fr>' . "\r\n";

		     	// Envoi
		     	mail($email_candidat, "Votre candidature au Master SIPPE", $messageMailGestionCandidature, $headers);

				echo "<p class='msgElement msgValid'>L'état de la candidature a bien été mis à jour.</p>";
			}else{
				echo "<p class='msgElement msgAlert'>Un problème a eu lieu. Merci de contacter un administrateur.</p>";
			}
		}
		else{
			echo "<p class='msgElement msgAlert'>Un problème a eu lieu. Merci de contacter un administrateur.</p>";
		}


	}
?>


