<?php 
  $Conn = 1;
  if($Conn == 1){
    $connMysqli = mysqli_connect("localhost", "root", "", "eac_findyourdoctor_db"); //MySQL
    $connPDO = new PDO('mysql:host=localhost;dbname=eac_findyourdoctor_db', 'root', ''); //PDO
  }
  else{
    $connMysqli = mysqli_connect("sql100.infinityfree.com", "if0_37913553_eac_findyourdoctor_db", "X1pRjs8XgY7a", "if0_37913553"); //MySQL
    $connPDO = new PDO('mysql:host=sql100.infinityfree.com;dbname=if0_37913553_eac_findyourdoctor_db', 'if0_37913553', 'X1pRjs8XgY7a'); //PDO
  }
  // else{
  //   $connMysqli = mysqli_connect("localhost", "u745168153_alfelor", "h!!2l7U&", "u745168153_alfelor"); //MySQL
  //   $connPDO = new PDO('mysql:host=localhost;dbname=u745168153_alfelor', 'u745168153_alfelor', 'h!!2l7U&'); //PDO
  // }
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
?>