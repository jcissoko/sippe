<?php

include("../../../default/settings.php");


$retour = 1;
if(!empty($_POST['date']))
{
	$date = $_POST['date'];
	$classe = $_POST['classe'];
	
	if(!empty($_POST['salle']))
		$salle = $_POST['salle'];
		
	if(!empty($_POST['nom']))
		$nom = $_POST['nom'];
	
	if(!empty($_POST['couleur']))
		$couleur = $_POST['couleur'];
	
	$con = mysqli_connect($databases["default"]["default"]["host"], $databases["default"]["default"]["username"], $databases["default"]["default"]["password"], $databases["default"]["default"]["database"]);
	
	
	// Check connection
	if (mysqli_connect_errno())
	{
		die("Failed to connect to MySQL: " . mysqli_connect_error());
	}
	else
	{
		mysqli_set_charset($con, "utf8");
		$result = mysqli_query($con, "Select date from events_calendar where date=".mysqli_real_escape_string($con, $date)." and classe='".mysqli_real_escape_string($con, $classe)."'");
				
		$row = mysqli_num_rows($result);
		
			
		if($row != 0)	//update
		{
			$result = mysqli_query($con, "Update events_calendar set intervenant='".mysqli_real_escape_string($con, $nom)."', salle='".mysqli_real_escape_string($con, $salle)."', classe_couleur='".mysqli_real_escape_string($con, $couleur)."' where date=".mysqli_real_escape_string($con, $date)." and classe='".mysqli_real_escape_string($con, $classe)."'");
			
			if(!$result)
				$retour = -2;
		}
		else		//insert
		{
			$result = mysqli_query($con, "Insert into events_calendar (date, salle, intervenant, classe, classe_couleur) values(".mysqli_real_escape_string($con, $date).", '".mysqli_real_escape_string($con, $salle)."', '".mysqli_real_escape_string($con, $nom)."', '".mysqli_real_escape_string($con, $classe)."', '".mysqli_real_escape_string($con, $couleur)."')");
			
			if(!$result)
				$retour = -3;
		}
		mysqli_close($con);
	}
}
else
{
	$retour = -1;
}

echo $retour;