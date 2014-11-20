<?php

	$promo_planning = $_GET['classe'];
	
	if($promo_planning == "M1" || $promo_planning == "M2")
	{
		chdir('AquaPlannings');
		$filename = 'Planning_'.$promo_planning;
	
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		readfile($filename.'.pdf');

	}
