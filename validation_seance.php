<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Choix de la séance</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <h1 class="center_m">Noter les élèves d'une séance</h1>
        <?php
          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");
          include('connexion.php');
          $query = "SELECT idseance, DateSeance, themes.nom FROM seances JOIN themes ON seances.idtheme=themes.idtheme WHERE DateSeance <= '".$date."'";
          //echo "<br>$query<br>";
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          echo "<FORM  METHOD='POST' ACTION='valider_seance.php'>
                  <table>
                    <tr>
                      <td>Choix de la séance :</td>
                      <td>
                        <SELECT name='idseance' required class=\"full\">
                          <option value='' selected disabled>-- Séléctionnez une séance --</option>";
                          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                          {
                            echo "<OPTION value='$row[0]'>Séance avec le thème '$row[2]' du $row[1]</OPTION>";
                          }
          echo        "</SELECT>
                      </td>
                    </tr>
                    <tr>
                      <td colspan=\"2\"><INPUT type='submit' value='Valider' class=\"full\"></td>
                    </tr>
                  </table>
                </FORM>";
          mysqli_close($connect); //choix de la séance
        ?>
      </div>
    </div>
  </body>
</html>
