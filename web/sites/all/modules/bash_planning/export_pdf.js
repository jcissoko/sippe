$(function() 
{	
		$("#mail_button").click(function(){
		var table = $("#div_export").html();
		
		var path = window.location.toString();
		var tab = new Array();
		tab = path.split("/");
		var classe = tab[tab.length - 1].substr(0, 2);
		$.ajax({
				url: "sites/all/modules/bash_planning/export_pdf.php",
				type: "POST",
				data:{"table" : table, "classe" : classe},
				success: function(data, textStatus, jqXHR){
					switch(data)
					{
						case -1 :	
							alert("Les paramètres requis n'ont pas été transmis");
							break;
						
						case -2 :
							alert("L'envoi de mail a échoué");
							break;
						
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert("Le fichier 'export_pdf.php' est introuvable");
				}
			});
	});

});