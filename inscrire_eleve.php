<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="fond.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php
          if (!empty($_POST['ideleve']) and !empty($_POST['idseance']))
          {
            include('connexion.php');
            $idseance = (int) $_POST['idseance']; //conversion des valeurs en entiers pour éviter des erreurs
            $ideleve = (int) $_POST['ideleve'];

            $query = "SELECT nom FROM themes JOIN seances ON themes.idtheme = seances.idtheme WHERE seances.idseance = '$idseance'"; //récuprération du nom du thème pour récapitulatif
            //echo "<br> $query <br>";
            $result = mysqli_query($connect, $query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result);
            $nomtheme = $row[0];

            $query = "SELECT nom, prenom FROM eleves WHERE ideleve = $ideleve"; //récuprération du nom de l'élève pour récapitulatif
            //echo "<br> $query <br>";
            $result = mysqli_query($connect, $query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result);
            $nomeleve = $row[1].' '.$row[0];

            // Récupération du nombre d'inscrit à la séance
            $query = "SELECT COUNT(*) FROM inscription WHERE idseance = $idseance";
            //echo "<br> $query <br>";
            $result = mysqli_query($connect, $query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result);
            $nbInscrits = $row[0];

            //Récupération du nombre max d'élèves pour cette séance
            $query = "SELECT * FROM seances WHERE idseance = '$idseance'";
            //echo "<br> $query <br>";
            $result = mysqli_query($connect, $query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result);
            $max = $row[2];
            $DateSeance = $row[1]; //récupération de la date de séance en même temps que le max pour récapitulatif, le faire en meme temps permet d'éviter de faire appel a la BDD une fois de plus

            // Voir si l'évève est déjà inscrit
            $query = "SELECT * FROM inscription WHERE ideleve = '$ideleve' AND idseance = '$idseance'";
            //echo "<br> $query <br>";
            $result = mysqli_query($connect, $query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result);


            //ajout si toutes les conditions sont remplies
            if(empty($row) and $nbInscrits < $max)
            {
              $query = "insert into inscription(idseance, ideleve) values ('$idseance', '$ideleve')";
              //echo "<br> $query <br>";
          		$result = mysqli_query($connect, $query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              echo "L'élève '$nomeleve' a été ajouté avec succès à la séance du $DateSeance avec comme thème '$nomtheme'.<br>";
            }
            else
            {
                if(!empty($row)) echo "L'élève est déjà inscrit.<br>";
                else echo "La séance est déjà complète.<br>";
            }
            mysqli_close($connect);
          }
          else
          {
            echo "Veuillez entrer toutes les données.<br>";
          }
          echo "<br> Vous allez être redirigés vers la page d'inscription d'un élève.";
          header ("Refresh: 10;URL=inscription_eleve.php");
         ?>
      </div>
    </div>
  </body>
</html>
