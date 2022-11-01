<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Désinscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <h1 class="center_m">Désinscription d'un élève</h1>
        <?php
          include('connexion.php');
          if (!empty($_POST['ideleve']) and !empty($_POST['idseance']))
          {
            $ideleve = (int) $_POST['ideleve'];
            $idseance = (int) $_POST['idseance'];

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

            $query = "SELECT * FROM inscription WHERE ideleve = '".$ideleve."' AND idseance = '".$idseance."'";
            //echo "<br>$query<br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $n=mysqli_num_rows($result);

            $query = "SELECT seances.DateSeance, themes.nom FROM seances
            INNER JOIN themes ON seances.idtheme = themes.idtheme
            WHERE seances.idseance = '".$idseance."'";
            //echo "<br>$query<br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }

            $row = mysqli_fetch_array($result, MYSQLI_NUM);

            $nomtheme = $row[1];
            $dateSeance = $row[0];

            if ($n == 0)
            {
              echo "L'élève '$prenom $nom' n'est pas inscrit à la séance '$nomtheme' du $dateSeance.<br>";
            }
            else
            {
              $query = "DELETE FROM inscription WHERE ideleve = '".$ideleve."' AND idseance = '".$idseance."'";
              //echo "<br>$query<br>";
              $result=mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              echo "L'élève '$prenom $nom' a bien été désincrit de la séance '$nomtheme' du $dateSeance.<br>";
            }
            mysqli_close($connect);
            echo "<br>Vous allez être redirigés vers la page de désinscription d'un élève à une séance.";
            header ("Refresh: 10;URL=desinscription_seance.php");
          }
          else
          {
            echo "Veuillez entrer toutes les données.<br><br>Vous allez être redirigés vers la page de désinscription d'un élève à une séance.";
            header ("Refresh: 10;URL=desinscription_seance.php");
          }
        ?>
      </div>
    </div>
  </body>
</html>
