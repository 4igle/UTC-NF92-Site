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
        <h1 class="center_m">Inscription d'un élève à une séance</h1>
        <form action="inscrire_eleve.php" method="post" >
            <?php
              date_default_timezone_set('Europe/Paris');
              $date = date("Y\-m\-d");
              include('connexion.php');
              $query = "SELECT * FROM eleves";
              //echo "<br> $query <br><br>";
              $result = mysqli_query($connect, $query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              echo "<table style='margin: auto'>
                      <tr>
                        <td>Vous voulez ajouter l'élève: </td>
                        <td><select name='ideleve' required class='full'>"; //séléction de l'élève
              echo "<option value='' selected disabled>-- Séléctionnez un élève --</option>";
              while ($row = mysqli_fetch_array($result, MYSQL_NUM))
              {
                echo "<option value=$row[0]>$row[2] $row[1]</option>";
              }
              echo "</select>
                  </td>
                </tr>";


              $query = "SELECT seances.idseance, seances.DateSeance, seances.EffMax, themes.nom FROM `themes`
              JOIN `seances` ON themes.idtheme = seances.idtheme WHERE themes.supprime = 0 AND DateSeance > '".$date."'";
              //Pas de séance dans le passé et pas de séance avec un thème inactif.
              //echo "<br> $query <br><br>";
              $result = mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              echo "<tr>
                      <td>Pour la séance: </td>
                      <td><select name='idseance' required class='full'>"; //choisir la séance
              echo "<option value='' selected disabled>-- Séléctionnez une séance --</option>";
              while ($row = mysqli_fetch_array($result, MYSQL_NUM))
              {
                echo "<option value ='".$row[0]."'>";
                echo "Séance avec le thème '".$row[3]."' du ".$row[1]." (Max : ".$row[2]." )";
                echo "</option>";
              }
              echo "</select>
                  </td>
                </tr>";
              mysqli_close($connect);
            ?>
            <tr>
              <td colspan="2"><input type='submit' value='Valider' class="full"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </body>
</html>
