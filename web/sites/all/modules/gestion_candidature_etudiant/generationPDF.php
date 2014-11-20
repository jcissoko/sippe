<?php 
   require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

	$content =  "  
					<style type='text/css'>
						
						.bbBottom{
							border-bottom : 1px solid black;
						}

						h1{
							text-align:center;
						}

					</style>
					
					<h1>Gestion des candidatures</h1>
					<div>
						<table cellspacing='15'>
							<tr>
								<th class='bbBottom'>ID</th>
								<th class='bbBottom'>N° Dossier</th>
								<th class='bbBottom'>Nom</th>
								<th class='bbBottom'>Prénom</th>
								<th class='bbBottom'>Email</th>
								<th class='bbBottom'>Etat</th>
							</tr>					
				";

	$tableauEtat = array('En attente', 'Acceptée', "Refusée");
	$mysqli = new mysqli("91.121.70.192", "c0sippenetbeta", "sippenet","c0c0sippenet_beta");
	$query="SELECT * FROM candidature;";

	if($result=$mysqli->query($query))
	{
		while ($row = $result->fetch_assoc()) {
			$content .= "	<tr style='border-bottom: 1px solid black'>
								<td>". $row['id_candidature'] ."</td>
								<td>". $row['nDossier'] ."</td>
								<td>". $row['nom_candidat'] ."</td>
								<td>". $row['prenom_candidat'] ."</td>
								<td>". $row['email_candidat'] ."</td>
								<td>". $tableauEtat[$row['etat']-1] ."</td>
							</tr>
						";
		}
	}

	$content .= "</table></div>";

	
 	ob_start();
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('listeCandidatures_SIPPE.pdf');

	$content = ob_get_clean();
	file_put_contents('listeCandidatures_SIPPE.pdf', $content);
