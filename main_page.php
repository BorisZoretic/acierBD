<?php
session_start ();
require_once 'system/header.php';
header ( 'Content-Type: text/html; charset=utf-8' );
if(!isset($_SESSION['current_page'])){
	header('Location: '. '/login.php');
}

?>
<title>Dashboard</title>
</head>

<body id="page-top">

	<!-- Navigation -->
	<nav id="mainNav"
		class="navbar static-top navbar-toggleable-md navbar-inverse bg-inverse">
		<button class="navbar-toggler navbar-toggler-right" type="button"
			data-toggle="collapse" data-target="#navbarExample"
			aria-controls="navbarExample" aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#">Fastech Inc.</a>
		<div class="collapse navbar-collapse" id="navbarExample">
			<ul class="sidebar-nav navbar-nav">
			<?php 
			$pages = array("Semaine"=> "Semaine",
					"Employe"=>"Employé",
					"Projet"=> "Projet",
					"Prix revient"=> "Prix revient",
					"Taux revient"=> "Taux revient",
					"Departement"=>"Département",
					"Prime"=> "Prime",
					"CCQ"=> "CCQ",
					"Banque"=> "Banque",
					"Compte"=> "Compte"
			);
			$icons = array("Semaine"=> "<i class='fa fa-calendar' aria-hidden='true'></i>",
					"Employe"=>"<i class='fa fa-users' aria-hidden='true'></i>",
					"Projet"=> "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>",
					"Prixrevient"=> "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>",
					"Tauxrevient"=> "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>",
					"Departement"=>"<i class='fa fa-industry' aria-hidden='true'></i>",
					"Prime"=> "<i class='fa fa-file-powerpoint-o' aria-hidden='true'></i>",
					"CCQ"=> "<i class='fa fa-user' aria-hidden='true'></i>",
					"Banque"=> "<i class='fa fa-bank' aria-hidden='true'></i>",
					"Compte"=> "<i class='fa fa-address-card-o' aria-hidden='true'></i>");
			foreach($pages as $key => $value){
				$key= str_replace(' ', '', $key);
				echo" <li id='class$key' class='nav-item ";
				if($key == $_SESSION['current_page']){
					echo " active";
				}
				echo "'><a  data-animation='ripple' id='onglet$key' class='nav-link changeOnglet' href='javascript:void(0)'>";
				echo $icons[$key] . "&nbsp;" . $value . "</a></li>";
			}
			?>
				
			</ul>
		</div>
		<a  class="nav-link logout" href="login.php">Deconnexion</a>
	</nav>

	<div id="content" class="content-wrapper py-3"></div>
	

	<a class="scroll-to-top rounded" href="#page-top"> <i
		class="fa fa-chevron-up"></i>
	</a>


	<?php
		require_once 'system/footer.php';
	?>
	
	<script>

	
	$("#<?php 
		echo $_SESSION['current_page'];
	?>").trigger("click");
	</script>
	<style>
	
.forceBorder td,.forceBorder tr,
.forceBorder table, .forceBorder thead,
.forceBorde tfoot, .forceBorder table tfoot td,
.forceBorder table thead td{
	border:1px solid black !important;
}
	</style>
</body>



</html>