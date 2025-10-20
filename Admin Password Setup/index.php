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

if (isset($_POST['Set-Password'])) {
    $NewPassword1 = mysqli_real_escape_string($connMysqli, $_POST['new_password1']);
    $NewPassword2 = mysqli_real_escape_string($connMysqli, $_POST['new_password2']);
    $Admin_ID = $_SESSION['Admin_Id'];

    if ($NewPassword1 !== $NewPassword2) {
        $_SESSION['error_message'] = 'Passwords do not match!';
    } else {
        $stmt = $connMysqli->prepare("SELECT admin_password FROM admin_accounts WHERE admin_id = ?");
        $stmt->bind_param("i", $Admin_ID);
        $stmt->execute();
        $stmt->bind_result($CurrentPasswordHash);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($NewPassword1, $CurrentPasswordHash)) {
            $_SESSION['error_message'] = 'New password cannot be the same as the old password.';
        } else {
            $EncryptedPassword = password_hash($NewPassword1, PASSWORD_DEFAULT);
            $stmt = $connMysqli->prepare("UPDATE admin_accounts SET admin_password = ?, admin_account_status = 'Old' WHERE admin_id = ?");
            $stmt->bind_param("si", $EncryptedPassword, $Admin_ID);
            if ($stmt->execute()) {
                header("Location: SuccessMessage.php");
                exit();
            } else {
                $_SESSION['error_message'] = 'Error updating password.';
            }
            $stmt->close();
        }
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
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
        <h1>Welcome!</h1>
        <p>To setup your admin account, you need create your own password.</p>
        <br>

        <div class="SearchDoctor InputText1 RemoveIcon">
          <!-- <i class="fa-solid fa-user-lock"></i> -->
          <input type="password" class="NewPassword" name="new_password1" placeholder="Enter your new password">
          <div class=""></div>
        </div>
        <br>
        <div class="SearchDoctor InputText1 RemoveIcon">
          <!-- <i class="fa-solid fa-key"></i> -->
          <input type="password" class="test-input" name="new_password2" id="InputPass" placeholder="Re-enter your new password">
        </div>
        <br>
        <div class="Checkbox-Div">
          <input type="checkbox" id="ShowPass" class="checkNewShowPassword">
          <label for="ShowPass">Show Password</label>
        </div>
        <br>
        <button type="submit" class="Btn_3" name="Set-Password">Set</button>

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