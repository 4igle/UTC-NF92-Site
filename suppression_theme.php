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
          include('connexion.php');
          $query = 'SELECT * FROM themes WHERE supprime = 0';
          //echo $query;
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          echo "<form  METHOD='POST' ACTION='supprimer_theme.php'>
                  <table>
                    <tr>
                      <td>Choix du thème à supprimer :</td>
                      <td>
                        <SELECT name='idtheme' required class=\"full\">
                          <option value='' selected disabled>-- Séléctionnez un thème --</option>";
                          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                          {
                            echo "<option value='$row[0]'>$row[1]</option>";
                          }
          echo        "</SELECT>
                      </td>
                    </tr>
                    <tr>
                      <td colspan=\"2\"><INPUT type='submit' value='Valider' class=\"full\"></td>
                    <tr>
                  </table>
                </form>"; //choix du thème à supprimer
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
