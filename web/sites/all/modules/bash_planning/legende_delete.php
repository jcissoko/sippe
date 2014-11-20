 <?php

include("../../../default/settings.php");

$retour = 1;
if(!empty($_POST['id']))
{
	$con = mysqli_connect($databases["default"]["default"]["host"], $databases["default"]["default"]["username"], $databases["default"]["default"]["password"], $databases["default"]["default"]["database"]);
	
	// Check connection
	if (mysqli_connect_errno())
	{
		$retour = "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else
	{
		mysqli_set_charset($con, "utf8");
		$result = mysqli_query($con, "DELETE FROM legend_calendar WHERE id=".mysqli_real_escape_string($con, $_POST['id']));
		if(!$result)
			$retour = -2;
	}
	mysqli_close($con);
 }
else
{
	$return = -1;
}
echo $retour;