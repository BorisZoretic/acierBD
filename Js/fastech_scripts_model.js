//onglet click event
$(document)
.on(
		"click",
		".changeOnglet",
		function() {
			var windowName = $(this).attr("id");
		
			var content = "";
			
			$(".changeOnglet").closest("li").removeClass("active");
			$(this).closest("li").addClass("active");
			
			var content = getContentHtml(windowName);
			$("#content").html("");
			$("#content").html(content);
			
			updateTable(windowName);
			if(windowName == "ongletEmploye"){
				$("#departementList").load("MVC/view/getDepSelect.php");
			}else if (windowName == "ongletBanque"){
				$("#selectEmp").load("MVC/view/getEmpSelect.php");
			}
			
			$('input').keypress(function(event){
				  if(event.which==95){
					    return false;
				  }
				})
		});

//fill content with onglet
function getContentHtml(windowName){
	var content = "";
	
	if(windowName === "ongletPrime"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout prime</h1>";
		content += "<form id='formPrime'>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='name'>Nom</label><input name='name' class='form-control inputMarginTop inputForm' placeholder='Nom de la prime'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='amount'>Taux </label><input name='amount' class='form-control inputMarginTop inputForm' type='number' placeholder='Taux de la prime'></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'"
				+ "   typeName='prime'>Ajouter</a></form>";
		
		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des primes </h1>";
		content += "<table class='table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead><tr class='cursorDefault' id='header'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printPrime'>Imprimer</a>";

		content += "</div>";
		
	} else if(windowName === "ongletSemaine"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout semaine</h1>";
		content += "<form id='formSemaine'>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='name'>Suffixe</label><input name='name' class='form-control inputMarginTop inputForm' placeholder='Suffixe pour la semaine' id='suffixe'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='begin_date'>Terminant le</label><input name='begin_date' class='form-control inputMarginTop' type='date' id='debut'></input>";
		content += "</div>";
		
		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly' typeName='work_weeks'>Ajouter</a></form>";

		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des semaines </h1>";
		content += "<table class=' table-responsive table table-bordered tblObject' width='100%'  cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Suffixe</th>";
		content += "<th>Terminant le</th>";
		content += "<th>Payable le</th>";
		content += "</tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Suffixe</th>";
		content += "<th>Terminant le</th>";
		content += "<th>Payable le</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";


		content += "</div>";
		
	} else if(windowName === "ongletEmploye"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout employé</h1>";
		content += "<form id='formEmploye'>";
		
		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='id_employe'>Code</label><input name='id_employe' class='form-control inputMarginTop inputForm' type='number' placeholder='Code de lemployé' id='idEmploye'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='family_name'>Nom</label><input name='family_name' class='form-control inputMarginTop inputForm' placeholder='Nom de lemployé' id='nom'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='first_name'>Prénom</label><input name='first_name' class='form-control inputMarginTop inputForm' placeholder='Prénom de lemployé' id='prenom'></input>";
		content += "</div>";
		
		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='hour_rate'>Taux horaire</label><input name='hour_rate' class='form-control inputMarginTop inputForm' type='number' placeholder='Taux horaire de lemployé' id='taux'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='departement'>Département</label><select id='departementList' name='departement' class='form-control formLeft inputMarginTop inputForm'><option value='departement1'>departement1</option>";
		content += "<option value='departement2'>departement2</option>";
		content += "<option value='departement3'>departement3</option>";
		content += "<option value='departement4'>departement4</option></select>";
		content += "</div>";
		
		content += "<div class='form-group formLeft col-lg-2 col-md-2 col-xs-12'>";
		content += "<label for='bool_ccq'>CCQ</label><input name='bool_ccq' class='form-control inputMarginTop inputForm' type='checkbox'' id='ccq'></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple'  class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo'   typeName='employees'>Ajouter</a></form>";
		
		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des employés </h1>";
		content += "<table class=' table-responsive table table-bordered tblObject' width='100%'  cellspacing='0'><thead class='cursorDefault'><tr id='header'>";
content += "<th>Tri</th>";
		content += "<th>Code</th>";
		content += "<th>Nom</th>";
		content += "<th>Prénom</th>";
		content += "<th>Taux horaire</th><th>Département</th><th style='text-align: center'>CCQ</th><th style='text-align: center'>Désactivé</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";
content += "<th>Tri</th>";
		content += "<th>Code</th>";
		content += "<th>Nom</th>";
		content += "<th>Prénom</th>";
		content += "<th>Taux horaire</th>";
		content += "<th>Département</th>";
		content += "<th style='text-align: center'>CCQ</th><th style='text-align: center'>Désactivé</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printEmploye'>Imprimer</a>";

		content += "</div>";
	   
		
	} else if(windowName === "ongletProjet"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout projet</h1>";
		content += "<form id='formProjet'>";

		content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
		content += "<label for='name'>Suffixe</label><input name='name' class='form-control inputMarginTop inputForm' placeholder='Code utilisé pour le projet' id='suffixeProjet'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
		content += "<label for='start_date'>Date début</label><input name='start_date' class='form-control inputMarginTop inputForm' type='date' id='debutProjet'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
		content += "<label for='budget'>Budget</label><input name='budget' class='form-control inputMarginTop inputForm' placeholder='Budget pour le projet' type='number' id='budget'></input>";
		content += "</div>";
		
		content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
		content += "<label for='bool_autre'>Autres</label><input name='bool_autre' class='form-control inputMarginTop inputForm' type='checkbox'' ></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'  typeName='projects'>Ajouter</a></form>";
		
		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des projets </h1>";
		content += "<table class=' table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Suffixe</th>";
		content += "<th>Date début</th>";
		content += "<th>Cumulatif production</th><th>Budget</th><th>Autres</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Suffixe</th>";
		content += "<th>Date début</th>";
		content += "<th>Cumulatif production</th><th>Budget</th><th>Autres</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printProject'>Imprimer</a>";

		
		content += "</div>";
		
	} else if(windowName === "ongletDepartement"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout département</h1>";
		content += "<form id='formDepartement'>";

		content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
		content += "<label for='name'>Nom</label><input name='name' class='form-control inputMarginTop inputForm' placeholder='Nom du département' id='nom'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
		content += "<label for='amount'>Taux </label><input name='amount' class='form-control inputMarginTop inputForm' type='number' placeholder='Taux du département' id='taux'></input>";
		content += "</div>";
		
		content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
		content += "<label for='bool_production'>Cumulatif Production</label><input name='bool_production' class='form-control inputMarginTop inputForm' type='checkbox'' id='ccq'></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'"
				+ "  typeName='departement'>Ajouter</a></form>";
		
		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des départements </h1>";
		content += "<table class=' table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th><th>Cumulatif production</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th><th>Cumulatif production</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printDepartement'>Imprimer</a>";

		content += "</div>";
		
	} else if(windowName === "ongletCompte"){
		
		content += "<div class='container-fluid'>";
		content += "<h1> Informations du compte </h1>";
		
		content += "<table class='table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Nom d'utilisateur</th>";
		content += "<th>Mot de passe</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Nom d'utilisateur</th>";
		content += "<th>Mot de passe</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "</div>";
		
	} else if(windowName === "ongletCCQ"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout métier CCQ</h1>";
		content += "<form id='formCCQ'>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='name'>Nom</label><input name='name' class='form-control inputMarginTop inputForm' placeholder='Nom du métier CCQ'></input>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='amount'>Taux </label><input name='amount' class='form-control inputMarginTop inputForm' type='number' placeholder='Taux du métier CCQ'></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'"
				+ "   typeName='ccq'>Ajouter</a></form>";
		
		content += "<div class='table-responsive fastechTable'>";
		content += "<h1> Liste des métiers CCQ </h1>";
		content += "<table class='table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Nom</th>";
		content += "<th>Taux ($/h)</th><th>Ordre de Tri</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printPrimeCCQ'>Imprimer</a>";

		content += "</div>";
		
	} else if(windowName === "ongletBanque"){
		
		content += "<div class='container-fluid'>";
		
		content += "<h1 class='formTitleMargin'>Ajout heures banque</h1>";
		content += "<form id='formBanque'>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='id_employe'>Employé</label><select id='selectEmp' name='id_employe' class='form-control formLeft inputMarginTop inputForm'>";
		content += "</select>";
		content += "</div>";

		content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
		content += "<label for='hours'>Heures</label><input name='hours' class='form-control inputMarginTop inputForm' type='number' placeholder='Heures à ajouter'></input>";
		content += "</div>";

		content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

		content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'"
				+ "   typeName='banque'>Ajouter</a></form>";
		
		content += "<h1 class='fastechTable'> Liste des heures en banques</h1>";
		content += "<div class='table-responsive'>";
		content += "<table class='table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Code employé</th>";
		content += "<th>Nom</th>";
		content += "<th style='text-align:center'>Heures en banques</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Code employé</th>";
		content += "<th>Nom</th>";
		content += "<th style='text-align:center'>Heures en banques</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printBank'>Imprimer</a>";

		content += "</div>";
		
	} else if(windowName == "ongletPrixrevient"){
		content += "<div class='container-fluid'>";
		
		content += "<h1> Liste des prix de revient</h1>";
		content += "<div class='table-responsive'>";
		content += "<table class='table-responsive table table-bordered tblObject' width='100%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Suffixe</th>";
		content += "<th>Projet</th><th>Date début</th><th>Date fin</th><th>Achats cumul</th><th>Facturation cumul</th></tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Suffixe</th>";
		content += "<th>Projet</th><th>Date début</th><th>Date fin</th><th>Achats cumul</th><th>Facturation cumul</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";
		content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printBank'>Imprimer</a>";

		content += "</div>";
	} else if(windowName == "ongletTauxrevient"){
		content += "<div class='container-fluid'>";
		content += "<div class='table-responsive'>";
		content += "<table class='table-responsive table table-bordered tblObject' style='width:20%' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

		content += "<th>Taux</th>";
		content += "</tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

		content += "<th>Taux</th>";
		content += "</tr></tfoot><tbody>";

		content += "</tbody></table></div>";

		content += "</div>";
	}

	
	return content;
}

$(document)
.on(
		"click",
		".modifPrime",
		function() {
			var form = $(this).closest("form");
			var dataToSend = form.serialize();

			var originalId = $("table").attr('idweek');
			var formName = $(this).attr("typename");
			
			console.log(originalId);
			console.log(dataToSend);
			console.log(formName);
			//console.log(windowName);
			$.ajax({method : "POST",
				url : "ajaxRelated/edit-object_process.php?typeName=" + formName + "&weekId=" + originalId,
				data : dataToSend,
				beforeSend : function() {
					// TO INSERT - loading animation
				},
				success : function(response) {
					
					if(response== "success" || response =="Wsuccess"){
						updateTableHour(originalId , "ongletHeure", "tblHeure");
						state = response;
					}else{
						state = "danger";
					}
				}
			});
		});


//btn ajout event
$(document)
.on(
		"click",
		".addInfo",
		function() {
			var form = $(this).closest("form");
			var dataToSend = form.serialize();
			var windowName = $(".active > a").attr("id");
			var originalId = $("table").attr('idweek');
			var formName = $(this).attr("typename");
			if($(this).attr("typename") == 'employe_week_hours'){
				 originalId = $("table").attr('idweek');
				 dataToSend+="&id_work_week="+originalId ;
			} else if($(this).attr("typename") == 'prix_revient'){
				originalId = $("table").attr('idObj');
				dataToSend+="&id_project=" + originalId;
			} else if($(this).attr("typename") == 'taux_departement_revient'){
				originalId = $("table").attr('idObj');
				dataToSend+="&id_prix_revient=" + originalId;
			}
			console.log(dataToSend);
			console.log(formName);
			//console.log(windowName);
			$
					.ajax({
						method : "POST",
						data : dataToSend,
						url : "ajaxRelated/ajout-object_process.php?typeName=" + formName,
						beforeSend : function() {
							$(this)
									.html(
											'<span class="glyphicon glyphicon-transfer"></span> &nbsp;Ajout...');
							$(this).prop("disabled", true);
						},
						success : function(response) {
							// response = response.replace(/\s/g, '');
							if (response == "success" || response =="Wsuccess") {
								if(formName == "employe_week_hours"){
									originalId = $("table").attr('idweek');
									updateTableHour(originalId, "ongletHeure", "tblHeure");
									updateTableHour(originalId, "ongletHeure", "ccqs");
								} else if(formName == "taux_departement_revient"){
									var idRevient = $(".clickDeleteSpec").attr('idRevient');
									
									updateSpec(idRevient);
									updateRevient(windowName, originalId);
								} else if (formName != "prix_revient"){
									updateTable(windowName);
								}

								$(document).find("form").find("input").val("");
								$("#errorForm").css("color", "white");
$("#errorForm").css("width", "1px");


							} else {
								$("#errorForm").css("color", "rgb(37, 51, 112)");
$("#errorForm").css("width", "300px");
							}

							$(this).prop("disabled", false);
						}
					});
		});

function updateTable(windowName){
	
	$
	.ajax({
		method : "GET",
		url : "MVC/view/getObjectDynamicTable.php?objectName=" + windowName,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		beforeSend : function() {
			/*$('.tblObject tbody')
					.append(
							"<span id='download'>Telechargement..</span>");*/
		},
		success : function(response) {
			//$('#download').remove();
			$('.tblObject tbody').html("");
			$('.tblObject tbody').append(response);
			if(windowName == "ongletSemaine" || windowName == "ongletProjet" || windowName == "ongletPrixrevient"){
				addConsultButtons(windowName);
			} else if(windowName == "ongletPrime" || windowName == "ongletCCQ" || windowName == "ongletDepartement"){
				addDeletetButtons(windowName);
			}
		}
	});
	
}

function updateTableHour(id, windowName, tableId){
	var isCCQ = 1;

	if(tableId == "ccqs"){
		isCCQ = 2;	
	}
	
	$
	.ajax({
		method : "GET",
		
		url : "MVC/view/getObjectDynamicTable.php?isCCQ="+isCCQ+"&objectName=" + windowName + "&id=" + id,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		beforeSend : function() {
			/*$('.tblObject tbody')
					.append(
							"<span id='download'>Telechargement..</span>");*/
		},
		success : function(response) {
			//$('#download').remove();
			$("#" + tableId + " tbody").html("");
			$("#" + tableId + " tbody").append(response);
			
			if(windowName == "ongletHeure"){
				$
				.ajax({
					method : "GET",
					url : "MVC/view/getWeekTotals.php?weekId=" + id + "&tableId=" + tableId,
					beforeSend : function() {
						// TO INSERT - loading animation
					},
					beforeSend : function() {
						/*$('.tblObject tbody')
								.append(
										"<span id='download'>Telechargement..</span>");*/
					},
					success : function(response) {
						var id_employe = $(this).text();
						$("#" + tableId + " tbody").append(response);
					}
				});	
			}
		}
	});
}

function addConsultButtons(windowName){
	//$('.tblObject thead tr').append("<th></th>");
	$('.tblObject > tbody > tr').each(function(){
		var id = $(this).find("input").eq(0).val();
		var idInitial = id;
		if(windowName == "ongletProjet"){
			id += "_" + $(this).find("input").eq(1).val();
			id += "_" + $(this).find("input").eq(2).val();
			id += "_" + $(this).find("input").eq(3).val();
			
		} else if (windowName == "ongletSemaine"){
			id += "_" + $(this).find("input").eq(1).val();
		} else if (windowName == "ongletPrixrevient"){
			id += "_" + $(this).find("input").eq(2).val();
			id += "_" + $(this).find("input").eq(3).val();
			id += "_" + $(this).find("input").eq(4).val();
			id += "_" + $(this).find("input").eq(5).val();
		}
		
		if(windowName != "ongletProjet"){
			$(this).append("<td><a idweek='"+idInitial+"' class='cursor clickWeek underlineBtn' id='" + id + "'>Consulter</a></td>");
		} else {
			if($(this).find("input").eq(4).val() != 2){
				$(this).append("<td><a idweek='"+idInitial+"' class='cursor clickWeek underlineBtn' id='" + id + "'>Consulter</a></td>");
			}
		}
	});
	//$('.tblObject tfoot tr').append("<th></th>");
}

function addDeletetButtons(windowName){
	$('.tblObject > tbody > tr').each(function(){
		var id = $(this).find("input").eq(2).val();
		var idInitial = id;
		
		$(this).append("<td><a class='cursor clickDelete underlineBtn' windowName='"+windowName+"' id='" + id + "'>Supprimer</a></td>");
	});
}

$(document).on("click",".clickDelete",function(){
	var id= $(this).attr("id");
	var windowName= $(this).attr("windowName");
	var self = $(this);
	

	$
	.ajax({
		method : "GET",
		url : "ajaxRelated/delete-object_process.php?windowName=" + windowName + "&id=" + id,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		beforeSend : function() {
			/*$('.tblObject tbody')
					.append(
							"<span id='download'>Telechargement..</span>");*/
		},
		success : function(response) {
			if(response == "success"){
				var row = self.closest("tr");
				row.remove();
			}
			
		}
	});	
	
	
});



//on change tbl event
$(document.body).on('change',".editable",function (e) {
	
	var self = $(this);

	var idOriginal = $("#tblHeure").attr('idweek');
	
	
	
	var form = self.closest(".edit");
	var windowName = $(".active > a").attr("id");
	var idObj = self.closest(".edit").attr("idObj");
		
	var formName = form.attr("table");
	var value = self.prop("value").split(' ').join('_');

	if(self.attr("type") == "checkbox"){
		if(value == 1){
			value = 2;
		} else {
			value = 1;
		}
	}
	

	/*if(formName == "payements"){
		var tr = self.closest('tr');
		var id_employe = tr.find('td').eq(0).text();
		idObj += "_" + id_employe + "_" + idOriginal;
	}*/
	
	var data = "name="+ self.attr("name")+"&value="+ value +"&id=" +idObj;
	var rowIndex = self.closest('tr').prevAll().length; 
	rowIndex+=2;
	var state ="";
	$.ajax({method : "POST",
		url : "ajaxRelated/edit-object_process.php?typeName=" + formName,
		data : data,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		success : function(response) {
			
				if(response== "success" || response =="Wsuccess"){
					
					if(formName=="payements" || formName == "prime_payement" || formName == "ccq_payement"){
						
						updateTableHour(idOriginal , "ongletHeure", "tblHeure");
						updateTableHour(idOriginal , "ongletHeure", "ccqs");
					}
					else{
						updateTable(windowName);
					}
					state = response;
				}else{
					state = "danger";
				}
		},
		complete : function(){
			setTimeout(function()
			{
			highlightRow(rowIndex,state);
			}, 100);
		}
	
		});
	
	
});

function highlightRow(rowIndex, state){
	var compter =0;
	$('.tblObject tr').each(function() {
		if (compter==rowIndex){
			$(this).addClass(state).delay(1000).queue(function(){
				if(state=="success" || state=="Wsuccess"){
					$(this).delay(1000).removeClass(state).dequeue();
					$(this).delay(1000).removeClass("Wsuccess").dequeue();
					$(this).delay(1000).removeClass("danger").dequeue();
				}
				
				return null;
			});
		}
	
		compter++;
	});
	
	
}

//on click week (stand by)
$(document)
.on(
		"click",
		".clickWeek",
		function() {
			var idOriginal = $(this).attr('idweek');
			var windowName = $(".active > a").attr("id");
			id = $(".tblObject").closest('tr').attr('id');
			if (id != "header" && id != "footer") {
				content = "";

				if(windowName == "ongletSemaine"){
					
					var semaine = $(this).attr('id');
					var arr = semaine.split('_');
					content += "<div class='container-fluid'>";
					
					// ******AJOUT HEURE*******
					content += "<div class='formMargin'>";
					content += "<h1>Ajout heure(s)</h1>";
					content += "<form id='formHeureSemaine'>";
	
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12' style='display:none'>";
					content += "<label for='id_work_week'>id_work_week</label><input id='inputWorkWeek' name='id_work_week' class='form-control formLeft inputMarginTop inputForm' value='" + arr[0] + "'>";
					content += "</input>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='id_employe'>Employé</label><select id='selectEmp' name='id_employe' class='form-control formLeft inputMarginTop inputForm'>";
					content += "</select>";
					content += "</div>";
	
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='id_project'>Projet</label><select id='selectProjet' name='id_project' class='form-control formLeft inputMarginTop inputForm'>";
					content += "</select>";
					content += "</div>";
	
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='departement'>Département</label><select id='selectDep' name='departement' class='form-control formLeft inputMarginTop inputForm'>";
					content += "</select>";
					content += "</div>";
	
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='hours'>Nb. heure(s)</label><input id='heure' name='hours' class='form-control inputMarginTop inputForm' placeholder='Heure(s)'></input>";
					content += "</div>";
	
					content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 btnForm addInfo' typeName='employe_week_hours'>Ajouter</a></form>";
					content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";
					content += "</div>";

                                        // ******MODIF PRIME*******
                                        content += "<div class='formMargin'>";
					content += "<h2>Modification heure prime</h2>";
					content += "<form id='formPrimeSemaine'>";
					
					content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
					content += "<label for='id_employe'>Employé</label><select id='selectEmpPrime' name='id_employe' class='form-control formLeft inputMarginTop inputForm'>";
					content += "</select>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
					content += "<label for='prime'>Prime</label><select id='selectPrime' name='prime' class='form-control formLeft inputMarginTop inputForm'>";
					content += "</select>";
					content += "</div>";
	
					content += "<div class='form-group formLeft col-lg-4 col-md-4 col-xs-12'>";
					content += "<label for='amount'>Nb. heure(s)</label><input name='amount' class='form-control inputMarginTop inputForm' placeholder='Heure(s)'></input>";
					content += "</div>";
	
					content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 btnForm modifPrime' typeName='prime_payement'>Modifier</a></form>";
					content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";
					content += "</div>";
					
	
					// ******TABLEAU******
					content += "<div class='table-responsive fastechTable'>";
					
					content += "<table idweek='"+arr[0]+"' class='table table-bordered tblObject' width='150%' id='tblHeure' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";
					content += "</tr></thead><tfoot class='cursorDefault'><tr id='footer'>";
					content += "</tr></tfoot><tbody>";
					content += "</tbody></table></div>";
					
					
					content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printTemp'>Imprimer</a>";
	
					
	
					content += "</div>";

					
					updateTableHour(arr[0], "ongletHeure", "tblHeure");
					
					$.ajax({method : "GET",
						url : "MVC/view/getObjectDynamicHeader.php?idObj="+arr[1]+"&objectName=" + windowName,
						beforeSend : function() {
							// TO INSERT - loading animation
						},
						success : function(response) {
							$("#header").html(response);
						//	$("#footer").html("<th>code</th><th>" + arr[1] + "</th><th>ENTR. MÉCAN</th><th>AUTRE</th><th>TOTAL</th><th>PAYÉ</th><th>RÉG.</th><th>TEMPS 1/2</th>" + response + "<th>Congé</th><th>BANQUE</th>");
							$("#ccqs").remove();
							$("<table id='ccqs' class='table table-bordered tblObject' width='100%' cellspacing='0'class='table table-bordered tblObject' width='100%' cellspacing='0'><thead id='headerccqs'></thead><tbody></tbody></table>").insertAfter($("#tblHeure"));
							
							$.ajax({method : "GET",
								url : "MVC/view/getObjectDynamicFooter.php?idObj="+arr[1]+"&objectName=" + windowName,
								beforeSend : function() {
									// TO INSERT - loading animation
								},
								success : function(response) {
									$("#headerccqs").html("");
									$("#headerccqs").html(response);
									}
							
								});
							
							
							
							updateTableHour(arr[0], "ongletHeure", "ccqs");
						}
					
						});
					
					
					$("#content").html(content);
					

					$("#selectEmp").load("MVC/view/getEmpSelect.php");
					$("#selectEmpPrime").load("MVC/view/getEmpSelect.php");
					$("#selectPrime").load("MVC/view/getPrimeSelect.php");
					$("#selectDep").load("MVC/view/getDepSelect.php");
					$("#selectProjet").load("MVC/view/getProjetSelect.php");
					
				} else if(windowName == "ongletProjet"){
					
					var toSplit = $(this).attr('id');
					var arr = toSplit.split('_');
					
					content += "<div class='container-fluid'>";
					
					content += "<h2 style='margin-bottom: 2px;'>Projet: " + arr[1] + "</h2>";
					content += "<h5 style='margin-bottom: 10px;'>" + arr[3] + "$</h5>";

					// ******TABLEAU******

					content += "<form id='formPrixRevient'>";
					content += "<div class='form-group formLeft col-lg-12 col-md-12 col-xs-12'>";
					content += "<label for='suffixe'>Suffixe</label><input name='suffixe' class='form-control formLeft inputMarginTop inputForm' placeholder='Suffixe pour le prix de revient'></input>";
					content += "</div>";

					content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
					content += "<label for='start_date'>Début</label><select id='startListWeek' name='start_date' class='form-control formLeft inputMarginTop inputForm'></select>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
					content += "<label for='end_date'>Fin</label><select id='endListWeek' name='end_date' class='form-control formLeft inputMarginTop inputForm'></select>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
					content += "<label for='achats_cumul'>Achats cumul</label><input name='achats_cumul' class='form-control inputMarginTop inputForm' type='number'></input>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-6 col-md-6 col-xs-12'>";
					content += "<label for='facturation_cumul'>Facturation cumul</label><input name='facturation_cumul' class='form-control inputMarginTop inputForm' type='number'></input>";
					content += "</div>";
					
					content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-3 cursor btnRevient addInfo' readonly='readonly' id='btnPrixRevient' typeName='prix_revient'>Prix de revient</a>";
					content += "</form>"
					content += "<div class='table-responsive fastechTableProjetHeure'>";
					content += "<table idObj='" + arr[0] + "'  class='table table-bordered tblObject' width='100%' id='tblHeureProjet' cellspacing='0'><thead class='cursorDefault'><tr id='header'>";

					content += "</tr></thead><tfoot class='cursorDefault'><tr id='footer'>";

					content += "</tr></tfoot><tbody>";
					content += "</tbody></table></div>";
					content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printSpecificProject'>Imprimer</a>";
					
					content += "</div>";
					
					updateHeaderFooter(windowName);
					
					updateTableHour(arr[0], "ongletProjetHeure", "tblHeureProjet");


					$("#content").html(content);
					

					$("#startListWeek").load("MVC/view/getWeeksSelect.php?begin_date=" + arr[2]);
					$("#endListWeek").load("MVC/view/getWeeksSelect.php?begin_date=" + arr[2]);
				} else if(windowName == "ongletPrixrevient"){
					var toSplit = $(this).attr('id');
					var arr = toSplit.split('_');
					console.log(arr);
					
					content += "<div class='container-fluid'>";
					
					content += "<h2 style='margin-bottom: 2px;'>Projet: " + arr[1] + "</h2>";
					content += "<h5 style='margin-bottom: 10px;'>" + arr[2] + "$</h5>";
					
					content += "<div class='table-responsive'>";
					content += "<table idObj='" + arr[0] + "'  class='table table-bordered tblObject cursorDefault' width='100%' id='tblHeureProjet' cellspacing='0'><thead><tr id='header'>";

					content += "</tr></thead><tfoot><tr id='footer'>";

					content += "</tr></tfoot><tbody>";
					content += "</tbody></table></div>";
					content += "<a data-animation='ripple' class='btn btn-default col-lg-2 col-md-2 col-xs-2 cursor btnForm btnImpression' readonly='readonly' id='printSpecificProject'>Imprimer</a>";
					
					
					updateRevient(windowName, arr[0]);
					
					content += "<div class='fastechSpecDep'>";
					content += "<h2 class='formTitleMargin'>Spécification taux départements</h2>";
					
					content += "<form id='formTauxDep'>";

					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='departement'>Département</label><select id='selectDepartement' name='departement' class='form-control formLeft inputMarginTop inputForm'></select>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='begin_date'>Débutant le</label><input name='begin_date' class='form-control inputMarginTop' type='date' id='debut' min='"+ arr[3] +"' max='"+ arr[4] +"'></input>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='end_date'>Terminant le</label><input name='end_date' class='form-control inputMarginTop' type='date' id='debut' min='"+ arr[3] +"' max='"+ arr[4] +"'></input>";
					content += "</div>";
					
					content += "<div class='form-group formLeft col-lg-3 col-md-3 col-xs-12'>";
					content += "<label for='taux'>Taux</label><input name='taux' class='form-control inputMarginTop inputForm' placeholder='Nouveau taux'></input>";
					content += "</div>";

					content += "<span id='errorForm'>Veuillez remplir tous les champs</span>";

					content += "<a data-animation='ripple' class='btn btn-default col-lg-3 col-md-3 col-xs-12 cursor btnForm addInfo' readonly='readonly'"
							+ "   typeName='taux_departement_revient'>Créer</a></form>";
					content += "</div>";
					
					content += "<div class='fastechTable'>";
					content += "<h2 style='margin-bottom: 2px;'>Tableau des spécifications</h2>";
					content += "<div class='table-responsive'>";
					content += "<table  class='table table-bordered tblSpec cursorDefault' width='100%' id='' cellspacing='0'><thead><tr id='header'>";

					content += "<th>Département</th>";
					content += "<th>Date début</th>";
					content += "<th>Date fin</th>";
					content += "<th>Taux</th>";
					content += "</tr></thead><tfoot><tr id='footer'>";

					content += "<th>Département</th>";
					content += "<th>Date début</th>";
					content += "<th>Date fin</th>";
					content += "<th>Taux</th>";
					content += "</tr></tfoot><tbody>";
					content += "</tbody></table></div>";
					content += "</div>";
					content += "</div>";
					
					updateSpec(arr[0]);
					
					
					$("#content").html(content);
					
					$("#selectDepartement").load("MVC/view/getDepSelect.php");
				}
				
			}
		});
$(document)
.on(
		"click",
		".clickDeleteSpec",
		function() {
			var idToDelete = $(this).attr('idItem');
			var idRevient = $(this).attr('idRevient');
			var originalId = $("table").attr('idObj');
			var windowName = $(".active > a").attr("id");
			
			$.ajax({
				method : "POST",
				url : "ajaxRelated/delete-object_process.php?idItem=" + idToDelete,
				beforeSend : function() {
					/*$(this)
							.html(
									'<span class="glyphicon glyphicon-transfer"></span> &nbsp;Ajout...');
					$(this).prop("disabled", true);*/
				},
				success : function(response) {
					updateSpec(idRevient);
					updateRevient(windowName, originalId);
				}
			});
			
		});

function updateSpec(id){
	$.ajax({
		method : "GET",
		url : "MVC/view/getObjectDynamicTable.php?objectName=tableSpec&idRevient=" + id,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		beforeSend : function() {
			/*$('.tblObject tbody')
					.append(
							"<span id='download'>Telechargement..</span>");*/
		},
		success : function(response) {
			//$('#download').remove();
			$('.tblSpec tbody').html("");
			$('.tblSpec tbody').append(response);
		}
	});
}

function updateRevient(windowName, id){
	$.ajax({method : "GET",
		url : "MVC/view/getObjectDynamicHeader.php?idObj="+id+"&objectName=" + windowName,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		success : function(response) {
			$("#header").html(response);
			
			$.ajax({
				method : "GET",
				url : "MVC/view/getObjectDynamicTable.php?objectName=ongletConsultRevient&idRevient=" + id,
				beforeSend : function() {
					// TO INSERT - loading animation
				},
				beforeSend : function() {
					/*$('.tblObject tbody')
							.append(
									"<span id='download'>Telechargement..</span>");*/
				},
				success : function(response) {
					//$('#download').remove();
					$('.tblObject tbody').html("");
					$('.tblObject tbody').append(response);
				}
			});
		}
	});
}

function updateHeaderFooter(windowName){
	$.ajax({method : "GET",
		url : "MVC/view/getObjectDynamicHeader.php?objectName=" + windowName,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		success : function(response) {
			$("#header").html(response + "<th class='alignRight'>TOTAL</th>");

			}
	
		});
	
	$.ajax({method : "GET",
		url : "MVC/view/getObjectDynamicFooter.php?objectName=" + windowName,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		success : function(response) {
			$("#footer").html("");
			$("#footer").append(response + "<th class='alignRight'>TOTAL</th>");

			}
	
		});
}

$(document).on("click",".clickConge",function(){
	var idWeek = $("#tblHeure").attr("idWeek");
	var id_payement = $(this).attr('idpayement');
	var id_employe = $(this).attr('idemploye');
	
	$.ajax({method : "GET",
		url : "MVC/view/getConge.php?id_payement=" + id_payement + "&id_week=" + idWeek + "&id_employe=" + id_employe,
		beforeSend : function() {
			// TO INSERT - loading animation
		},
		success : function(response) {

			updateTableHour(idWeek, "ongletHeure", "tblHeure");
			updateTableHour(idWeek, "ongletHeure", "ccqs");

			}
	
		});
});

$(document).on("click",".btnImpression",function(){
	
	var windowName = $(this).attr("id");
	if($(this).attr("id") == "printSpecificProject"){
		windowName+= "&projectID=" + $("#tblHeureProjet").attr("idobj");
	}
  //window.open("pdfRelated/createPdf.php?"+"objectName="+windowName);
  
});




const isMobile = window.navigator.userAgent.match(/Mobile/) && window.navigator.userAgent.match(/Mobile/)[0] === "Mobile";
const event = isMobile ? "touchstart" : "click";	

$(document).on("click", '*[data-animation="ripple"]', function(e) {
		
		e.preventDefault();
		const button = e.target,
					rect = button.getBoundingClientRect(),
					originalBtn = this,
					btnHeight = rect.height,
					btnWidth = rect.width;
		let posMouseX = 0,
				posMouseY = 0;
		
		if (isMobile) {
			posMouseX = e.changedTouches[0].pageX - rect.left;
			posMouseY = e.changedTouches[0].pageY - rect.top;
			
		} else {
			posMouseX = e.pageX - rect.left;
			posMouseY = e.pageY - rect.top;
		}
		

		const baseCSS =  `position: absolute;
											width: ${btnWidth * 2}px;
											height: ${btnWidth * 2}px;
											transition: all linear 700ms;
											transition-timing-function:cubic-bezier(0.4, 0.0, 0.2, 1);
											border-radius: 50%;
											background: rgba(255,255,255,0.7);
											top:${posMouseY - btnWidth}px;
											left:${posMouseX - btnWidth}px;
											pointer-events: none;
											transform:scale(0)`;
		
		var rippleEffect = document.createElement("span");
		rippleEffect.style.cssText = baseCSS;
		
		//prepare the dom
		$(this).css("overflow", "hidden");
		this.appendChild(rippleEffect);
		
		//start animation
		setTimeout( function() { 
			rippleEffect.style.cssText = baseCSS + `transform:scale(1); opacity: 0;`;
		}, 5);
		
		setTimeout( function() {
			rippleEffect.remove();
			//window.location.href = currentBtn.href;
		},700);
	});
