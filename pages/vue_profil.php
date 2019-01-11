<?php 

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

$Modifier = isset($_POST["Modifier"]);
if ($Modifier) {

    //déclaration des variables de controle des diférents champs du formulaire.
    $nom = htmlspecialchars($_POST["nom"]);
    $mail = htmlspecialchars($_POST["mail"]);
    $mdp = sha1($_POST["mdp"]);
    $mdp2 = sha1($_POST["mdp2"]);
    //conditions pour voir si les champs du formulaire ne sont pas vide!
    if (!empty($nom) AND !empty($mail) AND !empty($_POST["mdp"]) AND !empty($_POST["mdp2"])) {

        $nameLength = strlen($_POST["nom"]);
        if ($nameLength < 30) {

            //Vérification si nom utilisateur existe déjà pour eviter le doublon!
            $reqnom = $bdd->prepare("SELECT * FROM membres WHERE nom =?");
            $reqnom->execute(array( $nom));
            $nomrexiste = $reqnom->rowCount();
            if ($nomrexiste == 0) {
            
                //Vérification de la validation du mail utilisateur
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                    //Vérification si Email existe.
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail =?");
                    $reqmail->execute(array($mail));
                    $mailrexiste = $reqmail->rowCount();
                    if ($mailrexiste == 0) {
                    
                        if ($_SESSION["motdepasse"]) {

                            // Contrôle de champs de password par l'expression régulière!
                            $regexpassword = "#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#";
                            $mdppost = $_POST["mdp"];
                            if ( preg_match($regexpassword, $mdppost) ) {
                            	if ($mdp ==  $_SESSION["motdepasse"]) {
                            	
		                            $sql = 'UPDATE membres SET nom = ?,mail=?, motdepasse =?, dateM = now() WHERE id =?';
		                                    // requette d'inscription d'utilisateur
		                            $requser =  $bdd->prepare($sql);
		                            $requser->execute(array($nom,$mail,$mdp2,$_SESSION['id']));


		                           //requette pour avoir accès aux nouvelles données
									$requser2 = $bdd->prepare("SELECT * FROM membres WHERE nom =? AND motdepasse =?");
									$requser2->execute(array($nom,$mdp2));
									$userexiste = $requser2->RowCount();
									if ($userexiste == 1) {
										$userinfo = $requser2->fetch();
										$_SESSION["id"] = $userinfo["id"];
										$_SESSION["nom"] = $userinfo["nom"];
										$_SESSION["mail"] = $userinfo["mail"];
										$_SESSION["motdepasse"] = $userinfo["motdepasse"];
										header("Location: http://localhost/Blog/Blog_php/profil.php?nom=".urlencode($_SESSION["nom"]));
										ob_end_flush();
								
									}
		                           	

                                }
                                else    
                                {
                                	$erreur = "Ce mot de passe ne correspond pas à l'ancien mot de passe!";
                                }
                                   
                            }
                            else
                            {
                                $erreur = "Le mot de passe doit avoir au moins 1 Majuscul, 1 minuscul, un caractères spéciale(#,/,*, ..) et un chiffre!";
                            }
                         
                        }
                        else
                        {
                            $erreur = "Les mots de passes ne correspondent pas!";
                        }
                    }
                    else
                    {
                        $erreur = "Ce Email est déja utilisé!";
                    }    
                }
                else
                {
                    $erreur = "Votre Email n'est pas valide !";
                }
            }
            else
            {
                $erreur = "Ce Nom est déjà utilisé !";
            }
            
        }
        else
        {
           $erreur = "Votre nom ne doit pas depasser 30 caractères!"; 
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être remplis!";
    }
}

 ?>
<!-- Début d'ajout de fil d'arianne -->
	<div align="center" style="margin-top:11%">
		
		<ul class="breadcrumb" align="left">
			<li>
                <a href="#">Qui sommes nous?</a>
            </li>
            <li>
                <a href="#">Blogs</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
            <li>Modifier Profil</li>
            
		</ul><br>
<!-- fin d'ajout de fil d'arianne -->

		<h2> Profil de <?php echo $_SESSION["nom"]; ?> </h2>
		<h5 style="color: red"> <?php if (isset($erreur)) {
			echo $erreur;
		} ?> </h3>
		<form method="POST" action="">

			<table>
				<tr>
					<td align="right"><br>
						<label for="nom"> Votre Nom : </label>
					</td>
					<td><br>
						<input type="text" name=" nom" placeholder="Votre nom" id="nom" value="<?php if(isset($_SESSION["nom"])){ echo $_SESSION["nom"];} ?>">
					</td>
				</tr>
				<tr>
					<td align="right"><br>
						<label for="mail"> Votre Mail : </label>
					</td>
					<td><br>
						<input type="email" name="mail" placeholder="Votre mail" id="mail"  value="<?php if(isset($_SESSION["mail"])){ echo $_SESSION["mail"];} ?>">
					</td>
				</tr>
				
				<tr>
					<td align="right"><br>
						<label for="mdp"> Ancien Mot de Passe : </label>
					</td>
					<td><br>
						<input type="password" name=" mdp" placeholder="Votre mot de passe" id="mdp">
					</td>
				</tr>
				<tr>
					<td align="right"><br>
						<label for="mdp2"> Nouveau Mot de Passe : </label>
					</td>
					<td><br>
						<input type="password" name=" mdp2" placeholder="Votre mot de passe de confirmation" id="mdp2">
					</td>
				</tr>

				<tr>
					<td>
						
					</td>
					<td align="left">
						<br>
						<input type="submit" name="Modifier" value="Modifier Profil ">
					</td>
				</tr>
				
			</table>
	
		</form>
		<br>
	</div>