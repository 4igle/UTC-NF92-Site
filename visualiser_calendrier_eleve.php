<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Calendrier</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <h1 class="center_m">Liste des inscriptions</h1>
        <?php
          include('connexion.php');
          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");
          if (!empty($_POST['ideleve']))
          {
            $ideleve = (int) $_POST['ideleve'];

            $query = "SELECT nom, prenom FROM eleves WHERE ideleve = '".$ideleve."'"; //récupération du nom de l'élève
            //echo "<br>$query<br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            $nom = $row[0];
            $prenom = $row[1];

            $query = "SELECT seances.DateSeance, themes.nom FROM inscription
            INNER JOIN seances ON inscription.idseance = seances.idseance
            INNER JOIN themes ON seances.idtheme = themes.idtheme
            WHERE inscription.ideleve = '".$ideleve."' AND seances.DateSeance > '".$date."'";
            //récupération des séances de l'élève, la requête pour le nom à été faire séparément car le nom ne change pas,
            //inutile de chercher le nom autant de fois qu'il y a de séances
            //echo "<br>$query<br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }

            $n=mysqli_num_rows($result);
            if ($n == 0)
            {
              echo "L'élève '$prenom $nom' n'est inscrit à aucune séance<br>";
            }
            else
            {
              if ($n == 1)
              {
                echo "L'élève '$prenom $nom' est inscrit à la séance suivante :<br><br>";
              }
              else
              {
                echo "L'élève '$prenom $nom' est inscrit aux séances suivantes :<br><br>";
              }
              while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
              {
                echo "'$row[1]' le $row[0]<br>";
              }
            }
            mysqli_close($connect);
            echo "<br>Vous allez être redirigés vers la page de visualisation des séances futures d'un élève.";
            header ("Refresh: 10;URL=visualisation_calendrier_eleve.php");
          }
          else
          {
            echo "Veuillez entrer toutes les données.<br><br>Vous allez être redirigés vers la page de visualisation des séances futures d'un élève.";
            header ("Refresh: 10;URL=visualisation_calendrier_eleve.php");
          }
        ?>
      </div>
    </div>
  </body>
</html>
