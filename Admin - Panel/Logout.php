<?php
  session_start();
  unset($_SESSION['Admin_Id']);
  session_destroy();
  header("Location: ../Admin Panel Login");
?>