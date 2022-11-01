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
        <h1 class="center_m">Suppression d'un thème</h1>
        <?php
        if (!empty($_POST['idtheme']))
        {
          $idtheme = (int) $_POST['idtheme'];
          include('connexion.php');
          $query = "SELECT nom FROM themes WHERE idtheme = '".$idtheme."'";
          //echo "<br>$query<br>";
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          $row = mysqli_fetch_array($result, MYSQLI_NUM);
          $nom = $row[0];

          $query = "UPDATE themes SET supprime = 1 WHERE idtheme = '".$idtheme."'"; //on met supprime=1 pour désactiver le thème
          //echo "<br>$query<br>";
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          mysqli_close($connect);
          echo "Le thème '$nom' a bien été supprimé<br>";
          echo "<br>Vous allez être redirigés vers la page de suppression d'un thème.";
          header ("Refresh: 10;URL=suppression_theme.php");
        }
        else
        {
          echo "Veuillez entrer toutes les données.<br><br>Vous allez être redirigés vers la page de suppression d'un thème.";
          header ("Refresh: 10;URL=suppression_theme.php");
        }
        ?>
      </div>
    </div>
  </body>
</html>
