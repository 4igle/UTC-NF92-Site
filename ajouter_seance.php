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
          date_default_timezone_set('Europe/Paris');
          $date = date("Y\-m\-d");
          include('connexion.php');
          $idtheme=$_POST['idtheme'];
          $DateSeance=$_POST['DateSeance'];
          $EffMax=$_POST['EffMax'];
          if(!empty($idtheme) and !empty($DateSeance) and !empty($EffMax) and $EffMax >= 1) //toutes les données bien saisies et valides (max doit être au moins 1)
          {
            $query="SELECT nom FROM themes WHERE idtheme='$idtheme'";         //récupération du nom du thème pour le récapitulatif de saisie
            //echo "<br> $query <br>";
            $result=mysqli_query($connect,$query);
            if(!$result)
            {
              echo "<br>pas bon".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            $nomtheme = $row[0];
            //echo "<br>Le nom du theme est '$nomtheme'";
            //echo "<br> L'effectif max est $EffMax";
            //echo "<br> La date de la séance $DateSeance<br>"; //Vérifications pendant la phase de développement
            if ($DateSeance < $date) //pas de séance dans le passé
            {
              echo 'Date incorrecte<br>';
              echo "<br> Vous allez être redirigés vers la page d'ajout d'une séance.";
              header ("Refresh: 10;URL=ajout_seance.php");
            }
            else
            {
              $query="SELECT * FROM seances WHERE DateSeance='$DateSeance' AND Idtheme='$idtheme'";
              //echo "<br> $query <br>";
              $result=mysqli_query($connect,$query);
              if(!$result)
              {
                echo "<br>pas bon".mysqli_error($connect);
                exit;
              }
              $n=mysqli_num_rows($result);
              //echo "<br> il y a $n lignes";
              if ($n != 0) //Une séance pour le jour et le thème défini existe déjà
              {
                echo "Il existe deja une séance pour ce thème ce jour là.<br>";
                echo "<br>Vous allez être redirigés vers la page d'ajout d'une séance.";
                header ("Refresh: 10;URL=ajout_seance.php");
              }
              else
              {
                $query="INSERT INTO seances VALUES(NULL,'$DateSeance',$EffMax,$idtheme)";
                //echo "<br> $query";
                $result=mysqli_query($connect,$query);
                if(!$result)
                {
                  echo "<br>pas bon".mysqli_error($connect);
                  exit;
                }
                echo "La séance du $DateSeance sur le thème '$nomtheme' avec $EffMax élèves au maximum a bien été créée.<br>";
                echo "<br> Vous allez être redirigés vers la page d'ajout d'une séance.";
                header ("Refresh: 10;URL=ajout_seance.php");
              }
            }
          }
          else
          {
            echo "Veuillez remplir tous les champs et leur donner un domaine valide.<br><br> Vous allez être redirigés vers la page d'ajout d'une séance.";
            header ("Refresh: 10;URL=ajout_seance.php");
          }
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
