
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

$submit = isset($_POST["submit"]);
if ($submit) {

    //déclaration des variables de controle des diférents champs du formulaire.
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = sha1($_POST["password"]);
    $re_password = sha1($_POST["re_password"]);
    $agree_term = isset($_POST["agree-term"]);

    //conditions pour voir si les champs du formulaire ne sont pas vide!
    if (!empty($name) AND !empty($email) AND !empty($_POST["password"]) AND !empty($_POST["re_password"]) AND !empty($agree_term)) {

        $nameLength = strlen($_POST["name"]);
        if ($nameLength < 30) {

            //Vérification si nom utilisateur existe déjà pour eviter le doublon!
            $reqnom = $bdd->prepare("SELECT * FROM membres WHERE nom =?");
            $reqnom->execute(array( $name));
            $nomrexiste = $reqnom->rowCount();
            if ($nomrexiste == 0) {
            
                //Vérification de la validation du mail utilisateur
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    //Vérification si Email existe.
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail =?");
                    $reqmail->execute(array($email));
                    $mailrexiste = $reqmail->rowCount();
                    if ($mailrexiste == 0) {
                    
                        if ($password == $re_password ) {
                            // Contrôle de champs de password par l'expression régulière!
                            $regexpassword = "#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#";
                            $mdp = $_POST["password"];
                            if ( preg_match($regexpassword, $mdp) ) {
                                // requette d'inscription d'utilisateur
                                $requser =  $bdd->prepare("INSERT INTO membres(nom, mail,motdepasse, dateM)  VALUES(?,?,?, now()) ");
                                $requser->execute(array($name,$email,$password));
                                header("Location: http://localhost/Blog/Blog_php/index.php");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Créer un compte</h2>
                        <div style="color: red">
                           <?php if (isset($erreur)) {
                                    echo $erreur;
                                 } ?> 
                                 <br>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="form-input" name="name" id="name" placeholder="Votre Nom" value="<?php if(isset($name)){ echo $name;} ?>" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Votre Email" value="<?php if(isset($email)){ echo $email;} ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Votre Mot de passe"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeter votre Mot de Passe"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>J'accepte tous les termes d'utilisation  <a href="http://localhost/Blog/Vues/index.php" class="term-service">Les Termes d'utilisation</a></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Créer son Compte"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Avez vous un Compte ? <a href="../Login/sign_in.php" class="loginhere-link">Se Connecter ici</a>
                    </p>
                    

                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>