$(function() {
	$("#add_legende").click(function(){
		var initiales, nom;
		initiales = $("#initiales_elem");
		nom = $("#nom_elem");
		//requete AJAX pour l'ajout en base
		$.ajax
		({
			url: "sites/all/modules/bash_planning/legende_persistence.php",
			type: "POST",
			data:{initiales : initiales.val(), nom : nom.val()},
			success: function(data, textStatus, jqXHR){
				switch(data)
				{
					case -1 :	
						alert("Impossible de récupérer les informations pour créer cette légende");
						break;
					
					case -2 :
						alert("L'insertion en base a échoué");
						break;
					
					default:	
						location.reload();
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("la légende n'a pas pu être sauvegardée en base");
			}
		});	
					
	});
	
	
	$(".icon-delete-right").click(function(){
		//on récupère l'id
		id = $(this).attr('id');
		//on fait une requête AJAX pour supprimer de la base l'élément
		$.ajax
		({
			url: "sites/all/modules/bash_planning/legende_delete.php",
			type: "POST",
			data:{id : id},
			success: function(data, textStatus, jqXHR){
				switch(data)
				{
					case -1 :	
						alert("Impossible de récupérer l'identifiant de l'élément à supprimer");
						break;
					
					case -2 :
						alert("La suppression en base a échoué");
						break;
					
					default:	
						location.reload();
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("La légende n'a pas pu être supprimée de la base");
			}
		});		
	});
});