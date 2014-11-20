<?php

include("../../../default/settings.php");
include("getHolidays.php");
include("isDateHeureHiver.php");


$retour = 1;

if(!empty($_POST['dateDebut']) && !empty($_POST['dateFin']))
{
	$dateDebut = $_POST['dateDebut'];
	$dateFin = $_POST['dateFin'];
	$classe = $_POST['classe'];
	$salle = $_POST['salle'];
	$nom = $_POST['nom'];
	$couleur = $_POST['couleur'];
	
	$retour .= $classe.$salle.$nom.$couleur;
	
	$con = mysqli_connect($databases["default"]["default"]["host"], $databases["default"]["default"]["username"], $databases["default"]["default"]["password"], $databases["default"]["default"]["database"]);
	
	
	// Check connection
	if (mysqli_connect_errno())
	{
		$retour = "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else
	{
		mysqli_set_charset($con, "utf8");
		
		
		$tabDebut = explode('/',$dateDebut);
		$timestampDebut = mktime(0, 0, 0, $tabDebut[1],$tabDebut[0],$tabDebut[2]);
		
		
		$tabFin = explode('/',$dateFin);
		$timestampFin = mktime(0, 0, 0, $tabFin[1],$tabFin[0],$tabFin[2]);
		
		
		$tab_to_send = array();
		
		//on va de la date de début à celle de fin
		while($timestampDebut <= $timestampFin)
		{
			$date_courante = date("d/m/Y",$timestampDebut);
			$tabDebut = explode('/',$date_courante);
			
			$timestampDebut = mktime(0, 0, 0, $tabDebut[1],$tabDebut[0],$tabDebut[2]);
			
			
			$num_du_jour = date("N", $timestampDebut);
			
			$holidays = getHolidays(date("Y", $timestampDebut));	
			//vérification si le jour est férié
			if(!array_search($timestampDebut, $holidays))
			{
				//vérification si le jour est un samedi ou un dimanche
				if($num_du_jour != 6 && $num_du_jour != 7)
				{
					//si c'est ok on l'ajoute dans la bdd
					$result = mysqli_query($con, "Select date from events_calendar where date=".mysqli_real_escape_string($con, $timestampDebut)." and classe='".mysqli_real_escape_string($con, $classe)."'");
						
					$row = mysqli_num_rows($result);
					
					if($row != 0)	//update
					{
						$result = mysqli_query($con, "Update events_calendar set intervenant='".mysqli_real_escape_string($con, $nom)."', salle='".mysqli_real_escape_string($con, $salle)."', classe_couleur='".mysqli_real_escape_string($con, $couleur)."' where date=".mysqli_real_escape_string($con, $timestampDebut)." and classe='".mysqli_real_escape_string($con, $classe)."'");
						
						if(!$result)
							$retour = -2;
					}
					else		//insert
					{
						$result = mysqli_query($con, "Insert into events_calendar (date, salle, intervenant, classe, classe_couleur) values(".mysqli_real_escape_string($con, $timestampDebut).", '".mysqli_real_escape_string($con, $salle)."', '".mysqli_real_escape_string($con, $nom)."', '".mysqli_real_escape_string($con, $classe)."', '".mysqli_real_escape_string($con, $couleur)."')");
						
						if(!$result)
							$retour = -3;
					}
					$tab_to_send[] = $timestampDebut;
				}
			}
			if(isDateHeureHiver($timestampDebut))
				$timestampDebut += 90000;
			$timestampDebut += 86400;
		}
		mysqli_close($con);
		$retour = $tab_to_send;
	}
}
else
{
	$retour = -1;
}

echo json_encode($retour);
