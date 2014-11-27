<?php
	
	if($_GET['file']){

		$filename = $_GET['file'];
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$_GET['file'].'"');
		//readfile('http://master-sippe.fr/sites/default/files/webform/' . $filename.'.pdf');
		readfile('http://master-sippe.fr/sites/default/files/webform/'.$_GET['file'].'.pdf');

	}

