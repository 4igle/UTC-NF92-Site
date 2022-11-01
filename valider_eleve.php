<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Valider un élève</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php

          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");

          if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['naissance'])) //tous les champs sont bien remplis
          {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $naissance = htmlspecialchars($_POST['naissance']);

            if ($naissance < $date) //pas de date de naissance dans le futur
            {

              /*
                la fonction htmlspecialchars() transforme les caractères html (comme "<" ou ">" pour devenir &lt; et &gt;) afin d'éviter une faille XSS
                (éviter que la saisie de l'utilisateur puisse être interprétée comme du code, du javascript par exemple)
              */

              //echo "Nom : $nom <br>";
              //echo "Prénom : $prenom <br>";
              //echo "Date de naissance : $naissance <br>";

              include('connexion.php');
              //include est un équivalent à require
              /* Documentation php sur include :
              require est identique à include mis à part le fait que lorsqu'une erreur survient,
              il produit également une erreur fatale de niveau E_COMPILE_ERROR.
              En d'autres termes, il stoppera le script alors que include n'émettra qu'une alerte de niveau E_WARNING,
              ce qui permet au script de continuer.
              */

              $query = "SELECT * FROM eleves WHERE nom='" . $nom . "' AND prenom='" . $prenom . "'";
              //echo "<br>$query<br>";
              $result = mysqli_query($connect, $query);
              if (!$result)
              {
                echo "<br>pas bon ".mysqli_error($connect);
                exit;
              }
              $compteur = mysqli_num_rows($result);
              if ($compteur == 0) //cas où personne n'a le même nom et prénom
              {
                $query = "INSERT INTO eleves VALUES (NULL, '$nom', '$prenom', '$naissance', '$date')"; //on peut changer la valeur de l'ancienne variable query, nous n'en avons plus besoin
                //echo "<br>$query<br>";
                $result = mysqli_query($connect, $query);
                if (!$result)
                {
                  echo "<br>pas bon ".mysqli_error($connect);
                  exit;
                }
                else
                {
                  echo "L'élève '$prenom $nom' né le $naissance a bien été ajouté à la base de données.<br><br> Vous allez être redirigés vers la page d'ajout d'un élève.";
                  header ("Refresh: 10;URL=ajout_eleve.html");
                }
              }
              else //profil avec ce nom et prénom déjà existant, demande de confirmation
              {
                echo "<div class='aligner'>Un ou plusieurs élèves correspondant à \"$prenom $nom\" existe déjà dans la base de données,
                ajouter quand même ?<br><br>";
                echo "<table class='center'>
                        <tr>
                          <td>
                            <form method='POST' action='ajouter_eleve.php'>
                              <input type='hidden' name='nom' value='$nom'>
                              <input type='hidden' name='naissance' value='$naissance'>
                              <input type='hidden' name='prenom' value='$prenom'>
                              <input type='submit' value='Oui' class='bouton'>
                            </form>
                          </td>
                          <td>
                            <form method='POST' action='ajout_eleve.html'>
                              <input type='submit' value='Non' class='bouton'>
                            </form>
                          </td>
                        </tr>
                      </table>
                    </div>";
              }
              // J'ai trouvé plus esthétique de faire deux boutons Oui/Non, donc deux formulaires plutôt que des input de type radio,
              // cela me permet également de gérer toutes les redirections conditionnelles sur cette page
              mysqli_close($connect);
            }
            else
            {
              echo "Date de naissance incorrecte <br><br>Vous allez être redirigés vers la page d'ajout d'un élève.";
              header ("Refresh: 10;URL=ajout_eleve.html");
            }
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
