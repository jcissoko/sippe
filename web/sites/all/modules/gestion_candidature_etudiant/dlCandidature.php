<?php

	$filename = 'listeCandidatures_SIPPE';

	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	readfile($filename.'.pdf');

?>