 <?php

include("../../../default/settings.php");

$retour = 1;
if(!empty($_POST['initiales']) && !empty($_POST['nom']))
{
	$initiales = $_POST['initiales'];
	$nom = $_POST['nom'];
	
	$con = mysqli_connect($databases["default"]["default"]["host"], $databases["default"]["default"]["username"], $databases["default"]["default"]["password"], $databases["default"]["default"]["database"]);

	// Check connection
	if (mysqli_connect_errno())
	{
		$retour = "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else
	{
		mysqli_set_charset($con, "utf8");
		$result = mysqli_query($con, "Insert into legend_calendar (initiales, nom) values('".mysqli_real_escape_string($con, $initiales)."', '".mysqli_real_escape_string($con, $nom)."')");
		if(!$result)
			$retour = -2;
	}
	mysqli_close($con);
}
else
{
	$retour = -1;
}
echo $retour;
