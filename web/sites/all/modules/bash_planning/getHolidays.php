<?php

function getHolidays($year = null)
{
	if ($year === null)
	{
		$year = intval(date('Y'));
	}

	$easterDate  = easter_date($year);
	$easterDay   = date('j', $easterDate);
	$easterMonth = date('n', $easterDate);
	$easterYear   = date('Y', $easterDate);

	$holidays = array(
	// Dates fixes
	'1er janvier' => mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
	'Fête du travail' => mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
	'Arm. 1945' => mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
	'Fête nat.' => mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
	'Assomption' => mktime(0, 0, 0, 8,  15, $year),  // Assomption
	'Toussaint' => mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
	'Arm. 1918' => mktime(0, 0, 0, 11, 11, $year),  // Armistice
	'Noël' => mktime(0, 0, 0, 12, 25, $year),  // Noel

	// Dates variables
	'Pâques' => mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
	'Ascension' => mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
	'Pentecôte' => mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear)
	);

	return $holidays;
}
