<?php
  $dbhost = '';
  $dbuser = '';
  $dbpass = '';
  $dbname = '';
  $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
  mysqli_set_charset($connect, 'utf8');
  /*
    Avec ce fichier, les identifiants sont centralisés, ainsi si ils changent un  jour, les
    changer ici affecte tout les fichiers. De plus, si un jour le code doit être partagé, avoir les identifiants
    dans un fichier séparé permet d'éviter de les partager par inadvertance.
  */
?>
