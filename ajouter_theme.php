<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter un thème</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php

          if (!empty($_POST['nom']) and !empty($_POST['description'])) //tous les champs sont bien remplis
          {
            $nom = htmlspecialchars($_POST['nom']);
            $description = htmlspecialchars($_POST['description']);
            //echo "Nom du thème : $nom <br>";
            //echo "Desciption : $description <br>";

            include('connexion.php'); //identifiants de connexion

            /*================================================== Vérification si déjà existant ===========================================================*/

            $query = "SELECT * FROM themes WHERE nom='" . $nom . "'"; //On vérifie si il exite déjà un thème avec ce nom
            //echo "<br>$query<br>";

            $result = mysqli_query($connect, $query);
            if (!$result)
            {
              echo "<br>pas bon ".mysqli_error($connect);
              exit;
            }

            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            $idtheme = $row[0];
            $supprime = $row[2];
            $n=mysqli_num_rows($result);
            // echo "il y a $n lignes";
            if ($n != 0)
            {
              if ($supprime == 0) //Un thème non supprimé existe déjà sous ce nom
              {
                echo "Un thème non supprimé existe déjà sous le nom '$nom'.<br>";
              }
              else
              {
                $query = "UPDATE themes SET supprime = 0, descriptif='$description' WHERE idtheme='" . $idtheme . "'"; //Un thème supprimé existe déjà sous ce nom, on le réactive
                //echo "<br>$query<br>";

                $result = mysqli_query($connect, $query);
                if (!$result)
                {
                  echo "<br>pas bon ".mysqli_error($connect);
                  exit;
                }
                echo "Un thème supprimé existe déjà sous le nom '$nom', il a donc été réactivé avec comme nouvelle description '$description'.<br>";
              }
            }

            /*======================================== Insertion si aucun thème actif n'a le même nom =======================================*/
            else
            {
              $query = "insert into themes values (NULL, "."'$nom'".", 0, "."'$description'".")";
              //echo "<br>$query<br>";

              $result = mysqli_query($connect, $query);
              if (!$result)
              {
                echo "<br>pas bon ".mysqli_error($connect);
                exit;
              }
              mysqli_close($connect);
              echo "Le thème '$nom' avec comme description '$description' a bien été ajouté à la base de données.<br>";
            }
          }
          else
          {
            echo 'Veuillez entrer toutes les données.<br>';
          }
          echo "<br> Vous allez être redirigés vers la page d'ajout d'un thème.";
          header ("Refresh: 10;URL=ajout_theme.html");

         ?>
      </div>
    </div>
  </body>
</html>
