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
          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");
          $query = "SELECT * FROM eleves";
          //echo "<br>$query<br>";

          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }

          $query2 = "SELECT seances.idseance, seances.DateSeance, themes.nom FROM seances
          INNER JOIN themes ON seances.idtheme = themes.idtheme
          WHERE seances.DateSeance > '".$date."'"; //faire les deux requêtes avant le reste permet de mieux s'en sortir dans le code et de ne pas tout mélanger
          //echo "<br>$query2<br>";

          $result2=mysqli_query($connect,$query2);
          if(!$result2)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }

          echo "<FORM  METHOD='POST' ACTION='desinscrire_seance.php'>
                  <table>
                    <tr>
                      <td>Choix de l'élève :</td>
                      <td>
                        <SELECT name='ideleve' required class=\"full\">
                          <option value='' selected disabled>-- Séléctionnez un élève --</option>";
                          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                          {
                            echo "<OPTION value='$row[0]'>$row[2] $row[1]</OPTION>";
                          }
          echo        "</SELECT>
                      </td>
                    </tr>
                    <tr>
                      <td>Choix de la séance :</td>
                      <td>
                        <SELECT name='idseance' required class=\"full\">
                          <option value='' selected disabled>-- Séléctionnez une séance --</option>";
                          while ($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
                          {
                            echo "<OPTION value='$row2[0]'>'$row2[2]' le $row2[1]</OPTION>";
                          }
          echo        "</SELECT>
                      </td>
                    </tr>
                    <tr>
                      <td colspan=\"2\"><INPUT type='submit' value='Valider' class=\"full\"></td>
                    </tr>
                  </table>
                </FORM>";

          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
