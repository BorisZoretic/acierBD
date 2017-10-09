<?php
session_start ();
session_destroy();
require_once 'system/header.php';
?>
<link rel="stylesheet" type="text/css" href="Css/fastech_style_login.css">
<title>Connexion</title>
</head>
<body>

	<div id="wrapper">
		<div id="page-wrapper" style="margin-top: 35vh;">

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-3 col-md-6 col-xs-12" style="margin: auto;">
						<form id='formLogin'>
						<img src="image/logo.png" alt="logo_fastech" style="width:90%; display: block; margin-left: auto; margin-right: auto; margin-bottom: 15px;">
						<span id="error"></span>
							<div class="form-group">
								<input class="form-control" value='' placeholder="Nom d'utilisateur"
									name="username"></input>
							</div>
							<div class="form-group">
								<input class="form-control" value='' placeholder="Mot de passe"
									type="password" name="password"></input>
							</div>
							<input class="btn btn-default" readonly='readonly'  value="Connexion" id="btnLogin"></input>
						</form>
					</div>
				</div>
			</div>

		</div>
	
<?php
require_once 'system/footer.php';
?>

<script>



$(document).on("click", "#btnLogin", function() {
	var dataToSend = $("#formLogin").serialize();
        console.log(dataToSend);
	$.ajax({
		  method: "GET",
		  data: dataToSend,
		  url: "ajaxRelated/login_process.php",
		  beforeSend: function() {
              $(this).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp;Connexion...');
              $(this).prop("disabled", true);
          },
          success: function(response) {
              response = response.replace(
                  /\s/g, '');
              if (response == "success") {
                  $(this).html(' &nbsp;  Envoyer ...');
             
                  window.location.href = "main_page.php";
              } else {
                  $("#error").fadeIn(3000,
                          function() {
                              $(this).html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erreur de connexion');
                          });
              }
             
              $(this).prop("disabled", false);
          }
      });
});


</script>

</body>

</html>