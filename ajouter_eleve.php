<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter un élève</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php

          date_default_timezone_set('Europe/Paris'); //définition de la date
          $date = date("Y-m-d");

          if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['naissance'])) //tous les champs sont bien remplis
          {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $naissance = htmlspecialchars($_POST['naissance']);

            /*
              la fonction htmlspecialchars() transforme les caractères html (comme "<" ou ">" pour devenir &lt; et &gt;) afin d'éviter une faille XSS
              (éviter que la saisie de l'utilisateur puisse être interprétée comme du code, du javascript par exemple)
            */

            if ($naissance < $date) //pas de date de naissance dans le futur
            {

              //echo "Nom : $nom <br>";
              //echo "Prénom : $prenom <br>";
              //echo "Date de naissance : $naissance <br>"; //Vérifications utilisées pendant le développement

              include('connexion.php');
              //include est un équivalent à require
              /* Documentation php sur include :
              "require est identique à include mis à part le fait que lorsqu'une erreur survient,
              il produit également une erreur fatale de niveau E_COMPILE_ERROR.
              En d'autres termes, il stoppera le script alors que include n'émettra qu'une alerte de niveau E_WARNING,
              ce qui permet au script de continuer."
              */

              $query = "INSERT INTO eleves VALUES (NULL, "."'$nom'".", "."'$prenom'".", "."'$naissance'".", "."'$date'".")";
              //echo "<br>$query<br>";

              $result = mysqli_query($connect, $query);
              if (!$result)
              {
                echo "<br>pas bon ".mysqli_error($connect);
                exit;
              }
              echo "L'élève '$prenom $nom' né le $naissance a bien été ajouté à la base de données.<br>";

              mysqli_close($connect);
            }
            else
            {
              echo "<br>Date de naissance incorrecte<br>";
            }
            echo "<br> Vous allez être redirigés vers la page d'ajout d'un élève.";
            header ("Refresh: 10;URL=ajout_eleve.html");
          }
          else
          {
            echo "Veuillez entrer toutes les données <br> Vous allez être redirigés vers la page d'ajout d'un élève.";
            header ("Refresh: 10;URL=ajout_eleve.html");
          }

         ?>
    </div>
   </div>
  </body>
</html>
