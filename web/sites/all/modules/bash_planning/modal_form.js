$(function() 
{
    var name, salle;
	var idCase;
	
	var path = window.location.toString();
	var tab = new Array();
	tab = path.split("/");
	var classe = tab[tab.length - 1].substr(0, 2);
	
	var current_color;
	
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 250,
      width: 420,
      modal: true,
	  resizable: false,
	  closeText: "",
      buttons: {
        "Ajouter un cours": function() {
			name = $( "#name" );
			salle = $( "#salle" );
			couleur = $("#color option:selected").val();
			if(couleur == "")
				couleur = "white";
			$.ajax({
				url: "sites/all/modules/bash_planning/bash_persistence_event.php",
				type: "POST",
				data:{ nom : name.val(), salle : salle.val(), date : idCase, classe : classe, couleur : couleur},
				success: function(data, textStatus, jqXHR){
					switch(data)
					{
						case "-1" :	
							alert("Impossible de récupérer la date de l'évènement");
							break;
						
						case "-2" :
							alert("L'update de l'évènement a échoué");
							break;
						
						case "-3" :
							alert("L'insertion du nouvel évènement a échoué");
							break;
							
						default:
							elem = $("#"+idCase); 
							elem.removeClass();
							elem.addClass("case_classique");
							elem.addClass(couleur);
							elem.find(".cours_jour").text(name.val());
							elem.find(".numero_salle").text(salle.val()); 
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert("L'évènement n'a pas pu être sauvegardé en base.");
				}
			});
			$( this ).dialog( "close" );
		},
		"Annuler" : function()
		{
			$( this ).dialog( "close" );
		}
    
      },
	   open: function() {
			elem = $("#"+idCase);
			//on récupère les infos actuelles pour les afficher
			$("#name").val(elem.find(".cours_jour").text());
			$("#salle").val(elem.find(".numero_salle").text());  
			$("#color option").each(function(){
				if($(this).attr("value") == current_color)
					$(this).prop("selected", true);
				else
					$(this).prop("selected", false);
			});
      },
    });
 
 
    $( ".case_classique" )
       .click(function() {
			idCase = $(this).attr('id');
			dateObj = new Date(idCase*1000);
			date = dateObj.getDate()+"/"+(dateObj.getMonth()+1)+"/"+dateObj.getFullYear();
			new_title = "Ajouter un cours - "+date;
			classes_case = $(this).attr("class").split(" ");
			current_color = classes_case[classes_case.length - 1];		//la couleur est la dernière classe
			$("#dialog-form").dialog("option", "title", new_title);
			$( "#dialog-form" ).dialog( "open" );
      });
});