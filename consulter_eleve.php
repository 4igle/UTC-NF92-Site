<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Consulter un élève</title>
    <link rel="stylesheet" href="fond.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <h1 class="center_m">Consulter un élève</h1>
        <?php
          if (!empty($_POST['ideleve']))
          {
            include('connexion.php');
            $ideleve = (int) $_POST['ideleve'];
            $query="SELECT * FROM eleves WHERE ideleve = '$ideleve'";         //selection des élèves
            //echo "<br> $query <br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo "L'élève '$row[2] $row[1]' est né le $row[3] et est inscrit depuis le $row[4]<br>"; //Infos de l'élève
            mysqli_close($connect);
          }
          else
          {
            echo 'Veuillez entrer toutes les données.<br>';
          }
          echo "<br>Vous allez être redirigés vers la page de choix de consultation d'un élève";
          header ("Refresh: 10;URL=consultation_eleve.php");
        ?>
      </div>
    </div>
  </body>
</html>
