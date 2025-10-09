<?php
  session_start();
  include '../Config/Configure.php';

  date_default_timezone_set("Asia/Manila");
  $date = date("Y-m-d");
  $date2 = date("Y-M-d");
  $time = date("h:i:sa");

if(isset($_POST['Login-Admin'])){
    $login_email_address = mysqli_real_escape_string($connMysqli, $_POST['username']); // Sanitize input
    $login_password = mysqli_real_escape_string($connMysqli, $_POST['password']); // Sanitize input

    $stmt = $connMysqli->prepare("SELECT admin_id , admin_username, admin_password, admin_account_status FROM admin_accounts WHERE admin_username = ? LIMIT 1");

    if ($stmt) {
      $stmt->bind_param("s", $login_email_address);
        if ($stmt->execute()) {
            $stmt->bind_result($db_access_id, $db_email_address, $db_password_hash, $db_account_status);
            if ($stmt->fetch()) {
                if (password_verify($login_password, $db_password_hash)) {
                    $_SESSION['Admin_Id'] = $db_access_id;
                    $_SESSION['message'] = 'Welcome ' . $db_email_address;

                    if ($db_account_status == 'New' || $db_account_status == 'Reset') {
                        $_SESSION['Password_Setup'] = true;
                        header("Location: ../Admin Password Setup");
                        exit();
                    } else {
                        header("Location: ../Admin - Panel");
                        exit();
                    }
                } else {
                    $message[] = 'Incorrect Username or Password!';
                }
            } else {
                $message[] = 'Incorrect Username or Password!';
            }
        } else {
            $message[] = 'Incorrect Username or Password!';
        }
    $stmt->close();
    } else {
        $message[] = 'Incorrect Username or Password!';
    }
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

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
        <div class="Admin-LoginPageForm">
          <h1>Admin Panel</h1>
          <p>Login to access your admin account.</p>
          <div class="SearchDoctor InputText1">
            <i class="fa-solid fa-user-lock"></i>
            <input type="text" name="username" placeholder="Username">
            <div class=""></div>
          </div>
          <br>
          <div class="SearchDoctor InputText1">
            <i class="fa-solid fa-key"></i>
            <input type="password" class="test-input" name="password" id="InputPass" placeholder="Password">
          </div>
          <div class="Checkbox-Div">
            <input type="checkbox" id="ShowPass" class="checkShowPassword">
            <label for="ShowPass">Show Password</label>
          </div>
          <br>
          <button type="submit" class="Btn_3" name="Login-Admin">Login</button>

          <?php
              if (isset($_SESSION['error_message'])) {
                echo '<div class="PopUpMessage"><p><i class="fa-solid fa-triangle-exclamation"></i> ' . $_SESSION['error_message'] . '</p></div>';
                unset($_SESSION['error_message']); 
              }
          ?>

        </div>
      </form>

    </div>
  </div>
  
  <script type="text/javascript" src="../Assets/JS_Login.js?ver=<?php echo time();?>"></script>
</body>
</html>