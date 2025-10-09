<?php 
  // Fetch All Doctors
  $AllDoctors1 = "SELECT * FROM doctor WHERE doctor_status = 'ACTIVE' ";
  $AllDoctors1 = mysqli_query($connMysqli,$AllDoctors1);
  
  // Doctors Schedule
  $DoctorsSchedule1 = "SELECT * FROM doctor_schedule ";
  $DoctorsSchedule1 = mysqli_query($connMysqli,$DoctorsSchedule1);



  $CountTotalDoctor = mysqli_query($connMysqli, "SELECT * FROM doctor WHERE doctor_status = 'ACTIVE' ");
  $CountTotalDoctor = mysqli_num_rows($CountTotalDoctor);


  $Today = "Thursday";

  $CountTotalDoctorAvailableToday = mysqli_query($connMysqli, "SELECT DISTINCT schedule_doctor_id,doctor_schedule_day FROM doctor_schedule WHERE doctor_schedule_day = '$Today' ");
  $CountTotalDoctorAvailableToday = mysqli_num_rows($CountTotalDoctorAvailableToday);


  // $CountDoctorHMO = mysqli_query($connMysqli, "SELECT * FROM doctor_hmo WHERE  hmo_doctor_id = 1");
  // $CountDoctorHMO = mysqli_num_rows($CountDoctorHMO);
?>