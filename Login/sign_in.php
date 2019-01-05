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

	//Création de la variable de connexion
	$formConnexion = isset($_POST["formConnexion"]);
	if ($formConnexion) {

		//Création des variables des champs de connexion
		$username = htmlspecialchars($_POST["username"]);
		$pass = sha1($_POST["pass"]);
		$passPost = $_POST["pass"];
		if (!empty($username) AND !empty($passPost)) {

			// On Verifit si l'utilisateur et mot de passe sont correctes.
			$requser = $bdd->prepare("SELECT * FROM membres WHERE nom =? AND motdepasse =?");
			$requser->execute(array($username,$pass));
			$userexiste = $requser->RowCount();
			if ($userexiste == 1) {
				$userinfo = $requser->fetch();
				$_SESSION["id"] = $userinfo["id"];
				$_SESSION["nom"] = $userinfo["nom"];
				$_SESSION["mail"] = $userinfo["mail"];
				$_SESSION["motdepasse"] = $userinfo["motdepasse"];
				header("Location: http://localhost/Blog/Blog_php/profil.php?nom=".$_SESSION["nom"]);

			}
			else
			{
				$erreur = "Nom d'utilisateur ou mot de passe incorrecte!";
			}

		}
		else
		{
			$erreur = " Tous les champs du formulaire doivent être remplis!";
		}
	}

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V8</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="POST" class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="#">
					<span class="login100-form-title">
						Se Connecter
					</span>
					<div style="color: red" align="center">
						<?php if (isset($erreur)) {
							echo $erreur;
						} ?>
					</div>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Entrer votre Nom Utilisateur">
						<input class="input100" type="text" name="username" placeholder="Votre Nom d'Utilisateur">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Entrer votre Mot de Passe">
						<input class="input100" type="password" name="pass" placeholder="Votre Mot de Passe">
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
						<a href="http://localhost/Blog/Blog_php/index.php" class="txt2">
							Nom d'Utilisateur / Mot de Passe?
						</a>
						<span class="txt1">
							Oublié
						</span>
					</div>

					<div class="container-login100-form-btn">
						<input type="submit" name="formConnexion" value="Se Connecter" class="login100-form-btn">
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							N'avez vous pas un Compte?
						</span>

						<a href="../Inscription/sign_up.php" class="txt3">
							S'Inscrire Ici
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>