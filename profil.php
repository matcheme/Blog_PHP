<?php 
session_start();
	try{
		$bdd =new PDO('mysql:host=localhost;dbname=Blog; charset=utf8', 'matcheme', 'Divinement#1983');
		// Activation des erreurs PDO
		 $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// mode de fetch par défaut : FETCH_ASSOC / FETCH_OBJ / FETCH_BOTH
		 $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	} 
	catch(PDOException $e) {
		die('Erreur : ' . $e->getMessage());
	}

	if (isset($_GET["id"]) AND $_GET["id"] > 0 ) {
		$getid = intval($_GET["id"]);
		$requser = $bdd->prepare("SELECT * FROM membres WHERE id =?");
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();
	
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Profil de connexion </title>
</head>
<body>
	<div align="center">
		<h2> Profil de Connexion  de <?php echo $userinfo ["nom"]; ?> </h2>
		<div>
			 
			 Votre Nom: <?php echo $userinfo ["nom"]; ?><br><br>
			 Votre Mail: <?php echo $userinfo ["mail"]; ?><br><br>

			 <?php if (isset($_SESSION["id"]) AND $userinfo["id"] == $_SESSION["id"]){ ?>
			 	<a href="edition.php"> Editer mon profil!</a>
			 	<a href="deconnexion.php"> Se deconnecter</a>
			 <?php  }  ?>
		
		</div>
		

	</div>
</body>
</html>
<?php 
	}
 ?>
