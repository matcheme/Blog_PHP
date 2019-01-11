<!-- Début d'ajout de fil d'arianne -->
<div class="container"  style="margin-top:11%">
		
		<ul class="breadcrumb" align="left">
			<li>
                <a href='http://localhost/Blog/Blog_php/profil.php?nom=<?php echo $_SESSION['nom']; ?>'>Acceul</a>
            </li>
            <li>
                 <?php echo $_SESSION["nom"]; ?>
            </li>
         
		</ul><br>
<!-- fin d'ajout de fil d'arianne -->
        
<!-- Création des tables profil -->

    <!--  la table de Votre photo de profil. -->
        <div style="margin: 0% 10% 0% 10%">
            <form method="POST" align="right" action="http://localhost/Blog/Blog_php/edition_profil.php?nom=<?php if(isset($_SESSION['nom'])){ echo $_SESSION['nom'];} ?>">
                <input  type="submit" name="Modifier" value="Modifier" class="btn btn-primary">
            </form><br>
            <table class="table table-hover" style="box-shadow: 0px 0px  8px;">
                <thead>
                  <tr>
                    <th>Votre photo de profil.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><img src="#"> Votre photo: Votre Nom.</td>
                  </tr>
                  <tr>
                    <td>Dernier Mise à jour: <?php  echo date('dateM') ; ?></td>
                  </tr>
                </tbody>
              </table>

              <!--  la table à propos de vous -->
              <table class="table table-hover" style="box-shadow: 0px 0px  8px;">
                <thead>
                  <tr>
                    <th>A propos de vous.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> Votre Nom: Votre nom.</td>
                  </tr>
                  <tr>
                    <td> Votre E-mail: Votre E-mail.</td>
                  </tr>
                  <tr>
                    <td >Dernier Mise à jour : Date ... </td>
                  </tr>
                </tbody>
              </table>

              <!--  Information sur le compte. -->
              <table class="table table-hover" style="box-shadow: 0px 0px  8px;">
                <thead>
                  <tr>
                    <th>Information sur le compte.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td > Date d'inscription : Date......</td>
                  </tr>
                  <tr>
                    <td >Date de la connexion: Durée de la dernière connexion ...</td>
                  </tr>
                </tbody>
              </table>
    </div>
</div>