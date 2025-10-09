<?php 
    session_start(); 
    include '../Config/Configure.php';

    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d");
    $date2 = date("Y-M-d");
    $time = date("h:i:sa");

    if (!isset($_SESSION['Admin_Id'])) {
        header("Location: ../Admin Panel Login");
        exit();
    }

    if (isset($_POST['GoBackToLogin'])) {
        header("Location: Remove.php"); 
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- <meta http-equiv="refresh" content="3600; url=logout.php"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <link href = "../Assets/Images/EACMC_LOGO 1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="../Assets/CSS_Public.css?ver=<?php echo time();?>">
  <link rel="stylesheet" href="../Assets/CSS_Admin_Login.css?ver=<?php echo time();?>">
  <title>EACMC - Find Your Doctor</title>
</head>
<body>
  <div class="Overlay-Background">

  </div>

  <div class="Admin-LoginPage">
    <div class="Admin-LoginDiv">
      <div class="Admin-LoginLogo">
        <img src="../Assets/Images/EACMed Logo.png" alt="">
      </div>
        
      <form action="" class="FormLogin" method="POST" autocomplete="off">
        <div class="FlexColumnHeightAuto Admin-SetupPasswordPageForm">
            <h1>Success!</h1>
            <p>Password updated successfully! Redirecting back to Login.</p>
            <br> <br>   

            <button type="submit" class="Btn_3" name="GoBackToLogin">Go Back to Login</button>
        </div>
      </form>


  </div>
</div>
  <script type="text/javascript" src="../Assets/JS_Login.js?ver=<?php echo time();?>"></script>
</body>
</html>