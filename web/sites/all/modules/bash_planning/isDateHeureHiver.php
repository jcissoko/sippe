<?php

//le changement d'heure se fait le dernier dimanche du mois d'octobre
function isDateHeureHiver($dateJour)
{
	$changementHeure = false;
	if(date('n', $dateJour) == 10)		//on ne fait le test que si l'on est en octobre
	{
		$annee = date('Y', $dateJour);
		$premierJourMois = mktime(0, 0, 0, 10, 1, $annee);	//on se met au premier jour du mois
		$nbJoursMois = date('t', $premierJourMois);			//on récupère le nombre de jours du mois d'octobre...
		$numJourSemaine = date('w', $premierJourMois);		//on détermine à quel jour de la semaine correspond le permier jour du mois
		$intervallePremierDimanche = 7 - $numJourSemaine;	//on détermine combien de jours il faut pour ariver au premier dimanche du mois
		$nbJoursrestants = $nbJoursMois - $intervallePremierDimanche;	//nombre de jours pour terminer le mois
		$numDernierDimanche = $intervallePremierDimanche + floor($nbJoursrestants / 7) * 7;		//numéro du dernier dimanche du mois
		$dateDernierDimanche = mktime(0, 0, 0, 10, $numDernierDimanche, $annee);		//date compete (timestamp) du dernier dimanche d'octobre
		if($dateJour == $dateDernierDimanche)				//si la date passée en paramètre correspond à la date du changement d'heure on retourne true
			$changementHeure = true;
	}
	return $changementHeure;
}
