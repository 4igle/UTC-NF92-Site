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
          include('connexion.php');
          $query="SELECT * FROM eleves";         //selection des élèves
          //echo "<br> $query <br>";
          $result=mysqli_query($connect,$query);
          if(!$result)
          {
            echo "<br>pas bon".mysqli_error($connect);
            exit;
          }
          echo "<FORM  METHOD='POST' ACTION='consulter_eleve.php' >
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
                      <td colspan=\"2\"><INPUT type='submit' value='Valider' class=\"full\"></td>
                    </tr>
                  </table>
                </FORM>"; //formulaire de séléction d'un élève
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
