<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Notes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php
          include('connexion.php');
          $idseance = $_POST['idseance'];
          foreach ($_POST as $key => $value) //On récupère toutes les valeurs contenues dans post, $key contient l'id de l'élève et $value sa note
          {
            //Affichage des notes
            if ($key != 'idseance')
            {
              $query = "SELECT nom, prenom FROM eleves WHERE ideleve = '".$key."'";
              //echo "<br>$query<br>";
              $result=mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              $row = mysqli_fetch_array($result, MYSQLI_NUM);
              if ($value == '' or $value > 40 or $value < 0) //si la note n'est pas définie ou n'est pas dans un domaine valide
              {
                echo "L'élève $row[1] $row[0] n'a pas encore été noté.<br><br>";
              }
              else
              {
                echo "L'élève $row[1] $row[0] a fait $value fautes pour cette séance.<br><br>";
              }
            }

            //Mise à jour des notes
            if ($value <= 40 and $value >= 0 and $value != '' and $key != 'idseance') //si la valeur du champ est dans le bon intervalle et est remplie, et on ne prend pas en compte $_POST['idseance'] qui nous a servi pour récupérer l'id de la séance
            {
              $query = "UPDATE inscription SET note = '".$value."' WHERE idseance = '".$idseance."' AND ideleve = '".$key."'";
              //echo "<br>$query<br>";
              $result=mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
            }
            elseif ($value == '' and $key != 'idseance') //On laisse la possibilité à l'utilisateur d'effacer une ancienne note sans en définir de nouvelle
            {
              $query = "UPDATE inscription SET note = NULL WHERE idseance = '".$idseance."' AND ideleve = '".$key."'";
              //echo "<br>$query<br>";
              $result=mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
            }
          }
          mysqli_close($connect);
          echo "<br>Les nouvelles notes ont bien été prises en compte <br><br>
                Vous allez être redirigés vers la page de la liste des séances à évaluer.";
          header ("Refresh: 10;URL=validation_seance.php");
        ?>
      </div>
    </div>
  </body>
</html>
