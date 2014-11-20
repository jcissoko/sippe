
$(function() 
{
	// mise en place de l'icone d'attente lors des appels AJAX
	$body = $("body");
	$(document).on({
		ajaxStart: function() { $body.addClass("loading");    },
		ajaxStop: function() { $body.removeClass("loading"); }    
	});

	var path = window.location.toString();
	var tab = new Array();
	tab = path.split("/");
	var classe = tab[tab.length - 1].substr(0, 2);

	var allFields;							//tableau des composants à vérifier	
	var tips;								//élément pour afficher les messages d'erreurs
	
   $.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'dd/mm/yy',             //pour les années yy correspond à 4 caractères : 1990 par exemple
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	$.datepicker.setDefaults($.datepicker.regional['fr']);
	
    $( "#dialog-form-jours-multiples" ).dialog
	({
		autoOpen: false,
		height: 350,
		width: 420,
		modal: true,
		resizable: false,
		closeText: "",
		buttons: 
		{
			"Ajouter un cours": function() 
			{
				tips = $( ".validateTips" );	
				var bValid = true;					//indique si tous les champs sont valides
				var name, salle, couleur, date_debut, date_fin;		//les éléments correspondant aux champs
				name = $("#periode_name");
				salle = $("#periode_salle");
				date_debut = $("#periode_date_debut_datepicker");
				date_fin = $("#periode_date_fin_datepicker");
				couleur = $( "#periode_color option:selected");
				var color;
				if(couleur.val() == "")
					color = "white";
				else
					color = couleur.val();
					
				//vérification des champs
				bValid = bValid && checkDates(date_debut, date_fin, "La date de début doit être inférieure à la date de fin");
				bValid = bValid && checkRegexp(date_debut, /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$/, "Respectez le format suivant : jj/mm/aaaa");
				bValid = bValid && checkRegexp(date_fin, /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$/, "Respectez le format suivant : jj/mm/aaaa");

				
				if ( bValid ) {
					//on envoie au fichier php : le nom du type, la salle, la date de début, la date de fin, et la couleur de la case
					$.ajax
					({
						url: "sites/all/modules/bash_planning/bash_persistence_multiples_events.php",
						type: "POST",
						async: true,
						//timeout: 240000,
						dataType: 'json',
						data:{ nom : name.val(), salle : salle.val(), dateDebut : date_debut.val(), dateFin : date_fin.val(), classe : classe, couleur : color},
						success: function(data, textStatus, jqXHR){
							switch(data)
							{
								case -1 :	
									alert("Impossible de récupérer les dates de l'évènement");
									break;
								
								case -2 :
									alert("L'update de l'évènement a échoué");
									break;
								
								case -3 :
									alert("L'insertion du nouvel évènement a échoué");
									break;
									
								default:	
									$.each(data, function(key, value){
										elem = $("#"+value);	
										elem.find(".cours_jour").text(name.val());
										elem.find(".numero_salle").text(salle.val()); 
										elem.removeClass();
										elem.addClass("case_classique");
										elem.addClass(color);							
									});
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert("L'évènement n'a pas pu être sauvegardé en base");
						}
					});			
					$( this ).dialog( "close" );
				}
			},
			"Annuler" : function()
			{
				allFields.val( "" ).removeClass( "ui-state-error" );		// on supprime la classe d'erreur sur tous les champs
				$( this ).dialog("close");
			}
		},
		open: function(){
			allFields = $( [] ).add("#periode_name").add("#periode_salle").add("#periode_date_debut_datepicker").add("#periode_date_fin_datepicker");			
			$("#periode_name").val("");
			$("#periode_salle" ).val("");
			$("#periode_date_debut_datepicker").val("");
			$("#periode_date_fin_datepicker").val("");
			$("#periode_color option").each(function(){
				if($(this).attr("value") == "white")
					$(this).prop("selected", true);
				else
					$(this).prop("selected", false);
			});
			//initialisation du datepicker
			$("#periode_date_debut_datepicker").datepicker();
			$("#periode_date_fin_datepicker").datepicker();
		}
    });

    $( "#add_cours_button" )
       .click(function() {
			$( "#dialog-form-jours-multiples" ).dialog( "open" );
    });
	
	//vérifie que la valeur du champ passé en paramètre correspond à la regex
	function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
	
	//vérifie que la date de début est inferieur à la date de fin
	function checkDates(dateDeb, dateFin, message)
	{
		var dateDebObjSplitted = dateDeb.val().split("/");
		var dateDebObj = new Date(dateDebObjSplitted[2], dateDebObjSplitted[1], dateDebObjSplitted[0]);
		var dateFinObjSplitter = dateFin.val().split("/");
		var dateFinObj = new Date(dateFinObjSplitter[2], dateFinObjSplitter[1], dateFinObjSplitter[0]);
		if(dateDebObj >= dateFinObj)
		{
			dateDeb.addClass( "ui-state-error" );
			dateFin.addClass( "ui-state-error" );
			updateTips(message);
			return false;
		}
		else
			return true;
	}
	
	//met à jour le message d'erreur à afficher
	function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
	
});