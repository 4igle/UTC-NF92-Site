<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Noter les élèves</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fond.css">
  </head>
  <body>
    <h1 class="AM">AUTO MOTO</h1>
    <div class="traitement">
      <div class="traitement_contenu">
        <h1 class="center_m">Noter les élèves d'une séance</h1>
        <?php
          if (!empty($_POST['idseance']))
          {
            $idseance = (int) $_POST['idseance'];
            include('connexion.php');
            $query = "SELECT nom, prenom, eleves.ideleve, inscription.note FROM eleves JOIN inscription ON inscription.ideleve = eleves.ideleve WHERE idseance = '".$idseance."'";
            //echo "<br>$query<br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            if (mysqli_num_rows($result) == 0)
            {
              echo "Aucun élève n'a participé à cette séance.<br>";
              mysqli_close($connect);
              echo "<br>Vous allez être redirigés vers la page de la liste des séances à évaluer.";
              header ("Refresh: 10;URL=validation_seance.php"); //redirection vers la page de séléction de séance car aucun élève à noter
            }
            else
            {
              echo "<div>
                      <FORM  METHOD='POST' ACTION='noter_eleves.php' >
                        <div class='scroll'>
                          <table>";
              while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
              {
                echo    "<tr>
                          <td>$row[1] $row[0] :</td>
                          <td><input type='number' name='$row[2]' value='$row[3]' max='40' min='0' class='almost_full'></td>
                        </tr>";
              }
              echo       "</table>
                        </div>
                        <INPUT type='hidden' name='idseance' value='$idseance'>
                        <INPUT type='submit' value='Valider' class=\"full\" style='margin-top: 30px;'>
                      </FORM>
                    </div>"; //définir ou redéfinir la note des élèves ayant participé à la séance
              mysqli_close($connect);
            }
          }
          else
          {
            echo "Veuillez entrer toutes les données.<br><br>Vous allez être redirigés vers la page de la liste des séances à évaluer.";
            header ("Refresh: 10;URL=validation_seance.php");
          }
        ?>
      </div>
    </div>
  </body>
</html>
