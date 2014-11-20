jQuery(document).ready(function() {
	/* Gestion de la mise à jour de l'état des candidatures. */
	$('.editionEtat').click(function(){
		var classe = $(this).attr('class');
		classe = classe.split('_');

		var lol = $('#selectEtat_'+ classe[1] +' option:selected').val();

		var datasString = "etat="+lol+"&id="+classe[1];

		var request = $.ajax({
			type:"POST",
			url:"sites/all/modules/gestion_candidature_etudiant/majBDD.php",
			data:datasString,
				success:function(data){

					if($('.msgElement').length){
						$('.msgElement').remove();
					}
					$('#afficherformulaire').before(data);

				},
				error:function(xhr, ajaxOptions, thrownError){alert('erreur : ' + xhr.status + ' ' + thrownError)}
		});

		request.fail(function( jqXHR, textStatus ) {
 		console.log("Request failed: " + textStatus );
		});
	});

	function testEtEnleveClassCss(element, nomClass){
		if(element.hasClass(nomClass)){
			element.removeClass(nomClass);
		}
	}

	/* Conversion en PDF */
	$('.genererCandidature').click(function(){
		var leRequete = $.ajax({
			type:"POST",
			url:"sites/all/modules/gestion_candidature_etudiant/generationPDF.php",
			success:function(data){

			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log('erreur : ' + xhr.status + ' ' + thrownError);
			}
		});
	});


 // mise en place de l'icone d'attente lors des appels AJAX
$body = $("body");
$(document).on({
ajaxStart: function() { $body.addClass("loading");    },
ajaxStop: function() { $body.removeClass("loading"); }    
});


});

