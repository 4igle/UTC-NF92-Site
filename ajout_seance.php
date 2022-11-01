<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajout d'une séance</title>
    <link rel="stylesheet" href="fond.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <?php
          include('connexion.php'); // connection à la bdd dans un fichier à part pour éviter de retaper le code
          $query="SELECT * FROM themes where supprime=0";         //selection de tout les thèmes actifs
          //echo "<br> $query <br>";
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          echo "<h1 class='center_m'>Ajout d'une séance</h1>
                  <FORM  METHOD='POST' ACTION='ajouter_seance.php' >
                    <table>
                      <tr>
                        <td>Choix du thème :</td>
                        <td>
                          <SELECT name='idtheme' required class=\"full\">
                            <option value='' selected disabled>-- Séléctionnez un thème --</option>";
                            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                            {
                              echo "<OPTION value='$row[0]'>$row[1]</OPTION>";
                            }
          echo           "</SELECT>
                        </td>
                      </tr>
                      <tr>
                        <td>Effectif max :</td>
                        <td><input type='number' name='EffMax' required class=\"almost_full\" min='1'></td>
                      </tr>
                      <tr>
                        <td>Date de la séance : </td>
                        <td><input type='date' name='DateSeance' required class=\"full\"></td>
                      </tr>
                      <tr>
                        <td colspan=\"2\"><INPUT type='submit' value='Enregistrer séance' class=\"full\"></td>
                      </tr>
                    </table>
                  </FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
