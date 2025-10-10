<?php
include '../Config/Configure.php';
date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");
$Day = date('l');

//CREATE RANDOM ID
function generateDoctorAccountId() {
  $date = date("Ymd");
  $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
  $accountId = $date . '-' . $randomNumber;
  return $accountId;
}

// DECRYPT ID
function decrypt_user_id($encrypted_data) {
  $encryption_key = 'your-encryption-key';
  list($encrypted_user_id, $iv) = explode('::', base64_decode($encrypted_data), 2);
  return openssl_decrypt($encrypted_user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
}

// PAGINATION
if (isset($_POST["page"])) {
  $page = $_POST['page'];
  $limit = 5; // Number of records per page
  $start = ($page - 1) * $limit;
  $query = "SELECT * FROM hmo LIMIT $start, $limit";
  $result = mysqli_query($connMysqli, $query);
  $output = '';
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $output .= '<div>' . $row['hmo_name'] . '</div>';
    }
    // Pagination links
    $query_total = "SELECT * FROM hmo";
    $result_total = mysqli_query($connMysqli, $query_total);
    $total_records = mysqli_num_rows($result_total);
    $total_pages = ceil($total_records / $limit);

    $output .= '<ul class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
      $active = ($i == $page) ? 'active' : '';
      $output .= '<li class="page-item ' . $active . '"> <a class="page-link" href="#sdf' . $i . '" data-page="' . $i . '"><button>' . $i . '</button></a></li>';
    }
    $output .= '</ul>';
  } else {
    $output .= '<p>No data found</p>';
  }
  echo $output;
}


// INSERT NEW DOCTOR
if (isset($_POST["InsertDoctor"])) {
  global $connMysqli;
  $LastName = $_POST["LastName"];
  $MiddleName = $_POST["MiddleName"];
  $FirstName = $_POST["FirstName"];
  $Gender = $_POST["Gender"];
  $Category = $_POST["Category"];
  $Specialization = $_POST["Specialization"];
  $SubSpecialization = $_POST["SubSpecialization"];
  $Schedule = $_POST["Schedule"];
  $Secretary = $_POST["Secretary"];
  $Room = $_POST["Room"];
  $HMOAccreditation = $_POST["HMOAccreditation"];
  $TeleConsultation = $_POST["TeleConsultation"];
  $Remarks = $_POST["Remarks"];

  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  if ($Gender == "Male") {
    $Profile_Img = "Doctor1.png";
  } else {
    $Profile_Img = "Doctor2.png";
  }

  $doctorAccountId = generateDoctorAccountId();

  if (!empty($Specialization) && is_array($Specialization)) {
    $ids = implode(",", array_map('intval', $Specialization));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM specialization WHERE specialization_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_specialization` (specialization_doctor_id, specialization_id_2, doctor_specialization_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['specialization_id'], $spec['specialization_name']]);
    }
  } else {
      echo "No valid specializations selected.";
  }


  if (!empty($SubSpecialization) && is_array($SubSpecialization)) {
    $ids = implode(",", array_map('intval', $SubSpecialization));

    $DoctorSubSpecsFetchQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSubSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_sub_specialization` (sub_specialization_doctor_id, sub_specialization_id_2, doctor_sub_specialization_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['sub_specialization_id'], $spec['sub_specialization_name']]);
    }

  } else {
      echo "No valid specializations selected.";
  }


  if (!empty($Schedule) && is_array($Schedule)) {
    foreach ($Schedule as $schedule) {
        [$doctor_schedule_day, $doctor_schedule_time] = explode(", ", $schedule);
        $InsertDoctorSchedule = $connPDO->prepare("INSERT INTO `doctor_schedule` (schedule_doctor_id, doctor_schedule_day, doctor_schedule_time) VALUES (?, ?, ?)");
        $InsertDoctorSchedule->execute([$doctorAccountId, $doctor_schedule_day, $doctor_schedule_time]);
    }
  } else {
      echo "No valid schedules found.";
  }



  if (!empty($Secretary) && is_array($Secretary)) {
    foreach ($Secretary as $index => $secretary) {
        // Ensure $secretary is an array with the expected keys
        if (
            isset(
                $secretary['name'],
                $secretary['network'],
                $secretary['number'],
                $secretary['network2'],
                $secretary['number2']
            )
        ) {
            $InsertDoctorSecretary = $connPDO->prepare("
                INSERT INTO `doctor_secretary` 
                (secretary_doctor_id, doctor_secretary_first_name, doctor_secretary_first_network, doctor_secretary_first_number, doctor_secretary_second_network, doctor_secretary_second_number) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $InsertDoctorSecretary->execute([
                $doctorAccountId,
                $secretary['name'],
                $secretary['network'],
                $secretary['number'],
                $secretary['network2'],
                $secretary['number2']
            ]);
        } else {
            // Echo invalid data
            echo "Invalid secretary data at index {$index}: ";
            echo "<pre>" . htmlspecialchars(print_r($secretary, true)) . "</pre>";
        }
    }
  } else {
      echo "Failed";
  }



  if (!empty($Room) && is_array($Room)) {
    $ids = implode(",", array_map('intval', $Room));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM room WHERE room_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedRoom = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!$DoctorSpecsFetchQuery) {
      die('MySQL ErrorL ' . mysqli_error($conn));
    }
    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_room` (room_doctor_id,doctor_room_number) VALUES (?,?)");

    foreach ($fetchedRoom as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['room_floor_name']]);
    }
  } else {
      echo "No valid Room selected.";
  }

  if (!empty($HMOAccreditation) && is_array($HMOAccreditation)) {
    $ids = implode(",", array_map('intval', $HMOAccreditation));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM hmo WHERE hmo_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_hmo` (hmo_doctor_id, hmo_id_2, doctor_hmo_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['hmo_id'], $spec['hmo_name']]);
    }
  } else {
      echo "No valid specializations selected.";
  }


  $InsertDoctor = $connPDO->prepare("INSERT INTO `doctor`(doctor_account_id, doctor_firstname, doctor_middlename, doctor_lastname, doctor_category, profile_image, doctor_sex) VALUES(?,?,?,?,?,?,?)");
  $InsertDoctor->execute([$doctorAccountId, $FirstName, $MiddleName, $LastName, $Category, $Profile_Img, $Gender]);

  $InsertConsultation = $connPDO->prepare("INSERT INTO `doctor_teleconsult`(teleconsult_doctor_id, teleconsult_link) VALUES(?,?)");
  $InsertConsultation->execute([$doctorAccountId, $TeleConsultation]);

  $InsertRemarks = $connPDO->prepare("INSERT INTO `doctor_notes`(notes_doctor_id, doctor_notes_details) VALUES(?,?)");
  $InsertRemarks->execute([$doctorAccountId, $Remarks]);


  $EventByID = "123";
  $EventByName = "France";
  $EventType = "New Account";
  $EditDetails = "Create Account of Dr. ".$FirstName ." ". $MiddleName ." ". $LastName;

  $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
  $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);




  echo "Doctor have been successfully inserted!";

}


// ACCESS ACCOUNT
if (isset($_POST["AccessAccount"])) {
  global $connMysqli;

  $AccessUsername = $_POST["AccessUsername"];
  $AccessType = $_POST["AccessType"];
  $DefaultAccess = '$2y$10$ZkgThNp4XqRGDaXyuXVtr.5RGI0DsFW3Bop9MW1m.ZE7WVT6AnHvO';
  $StrTimestamp = strtotime("$Date $Time");
  $Current_Timestamp = date("Y-m-d H:i:s", $StrTimestamp);
  $AccountStatus = 'New';
  $DefaultStatus = 'Active';

  $InsertAdmin = $connPDO->prepare("INSERT INTO `admin_accounts`(admin_username, admin_password, admin_account_status, admin_status, account_access, account_created_timestamp) VALUES(?, ?, ?, ?, ?, ?)");
  $InsertAdmin->execute([$AccessUsername, $DefaultAccess, $AccountStatus, $DefaultStatus, $AccessType, $Current_Timestamp]);
}


// VIEW ADMIN
if (isset($_POST["ViewAdmin_ID"])) {
  global $connMysqli;
  $Admin_ID = $_POST["ViewAdmin_ID"];

  $AdminFetchQuery = "SELECT * from admin_accounts
  WHERE admin_id = '$Admin_ID'";
  $AdminFetchQuery = mysqli_query($connMysqli, $AdminFetchQuery);

  if (!$AdminFetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($AdminFetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($AdminFetchQuery)) {
      $Admin_Timestamp = strtotime($row1['account_created_timestamp']); 
      $Admin_DateTime = date('M-d-Y h:i:s A', $Admin_Timestamp);


      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Admin Account</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>
                <div class='Div-Container1'>
                  <div class='Doctor-Img-Profile'><img src='../Uploaded/Doctor1.png' alt=''></div>
                  <div class=''>
                    <p>" . $row1['admin_username'] . "</p>
                    <div class='Doctor-Active Doctor-Capitalize'><i class='fa-solid fa-circle'></i><span>" . $row1['admin_status'] . "</span></div>
                  </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Access Level:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['account_access'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Created on</i>
                  <div class='InputFieldForm-Info'> <span> " . $Admin_DateTime . " </span> </div>
                </div>

               <!-- <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Last edited on</i>
                  <div class='InputFieldForm-Info'> 
                    <span> " . $row1['account_created_timestamp'] . " </span> 
                    <br>
                    <span> (by a Super Admin) </span>
                  </div>
                </div> -->

                
                <!-- <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Remarks:</i>

                  <div class='InformationField'></div>
                </div> -->
              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='EditAdmin(" . $row1['admin_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ResetPasswordAdmin(" . $row1['admin_id'] . ")'>Reset Password</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }
}

// VIEW ACTIVITY LOGS 

if (isset($_POST["ViewActivityLogs_ID"])) {
  global $connMysqli;
  $ActivityLogs_ID = $_POST["ViewActivityLogs_ID"];

  $ActivityLogsFetchQuery = "SELECT * from admin_activity_logs
  INNER JOIN admin_accounts ON activity_logs_admin_id = admin_id
  WHERE admin_activity_logs_id = '$ActivityLogs_ID'";
  $ActivityLogsFetchQuery = mysqli_query($connMysqli, $ActivityLogsFetchQuery);

  if (!$ActivityLogsFetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($ActivityLogsFetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($ActivityLogsFetchQuery)) {
      $ActivityLogs_Timestamp = strtotime($row1['time_stamp']); 
      $ActivityLogs_DateTime = date('M-d-Y h:i:s A', $ActivityLogs_Timestamp);

      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-clock-rotate-left'></i>
              <h4>View Activity Log</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>

           <!-- <div class='Div-Container1'>
              <div class='Doctor-Img-Profile'><img src='../Uploaded/Doctor1.png' alt=''></div>
                  <div class=''>
                    <p>" . $row1['admin_username'] . "</p>
                    <div class='Doctor-Active Doctor-Capitalize'><i class='fa-solid fa-circle'></i><span>" . $row1['admin_status'] . "</span></div>
                  </div>
                </div> -->

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Event By:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['admin_username'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Event Date/Time:</i>
                  <div class='InputFieldForm-Info'> <span> " . $ActivityLogs_DateTime . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Event Type:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['event_type'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Event Details:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['edit_details'] . " </span> </div>
                </div>

                <!-- <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Remarks:</i>

                  <div class='InformationField'></div>
                </div> -->
              </div>
            </div>
            <!-- <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='EditAdmin(" . $row1['admin_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ResetPasswordAdmin(" . $row1['admin_id'] . ")'>Reset Password</button>
            </div> -->";
    };
  } else {
    echo "No Data Found";
  }
}







//PROMPT - RESET PASSWORD - ADMIN (FUNCTION)
if (isset($_POST["ResetPasswordAdmin_ID"])) {
  global $connMysqli;
  $Admin_ID = $_POST["ResetPasswordAdmin_ID"];

  $AdminFetchQuery = "SELECT * from admin_accounts
  WHERE admin_id = '$Admin_ID'";
  $AdminFetchQuery = mysqli_query($connMysqli, $AdminFetchQuery);

  if (!$AdminFetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($AdminFetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($AdminFetchQuery)) {
      echo " 
      <div class='Prompt-Message-Top'>
            <lord-icon src='https://cdn.lordicon.com/ygvjgdmk.json' trigger='loop' delay='1500' class='lord-icon'></lord-icon>
            <h4>Are you sure?</h4>
          </div>
          <div class='Prompt-Message-Center'>
            <p class='P-Message'>Are you sure you want to reset the password of this admin account?</p>
          </div>
          <div class='Prompt-Message-Bottom'>
            <button class='Btn_1' onclick='Yes_ResetPasswordAdmin(" . $Admin_ID . ")'>Yes</button>
            <button class='Btn_2' onclick='HidePromptMessage()'>No</button>
      </div>";
    };
  } else {
    echo "No Data Found";
  }
}


//RESET PASSWORD - ADMIN
if (isset($_POST["Yes_ResetPasswordAdmin_ID"])) {

  header('Content-Type: application/json');

  global $connMysqli;
  $Admin_ID = $_POST["Yes_ResetPasswordAdmin_ID"];
  $AdminDefaultPass = '$2y$10$ZkgThNp4XqRGDaXyuXVtr.5RGI0DsFW3Bop9MW1m.ZE7WVT6AnHvO';
  $Admin_Reset_Status = 'Reset';

  $UserID =  $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  $ResetPasswordValidation = "SELECT * from admin_accounts 
  WHERE admin_id = '$Admin_ID'";
  $ResetPasswordValidation = mysqli_query($connMysqli, $ResetPasswordValidation);

  if (!$ResetPasswordValidation) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($ResetPasswordValidation->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($ResetPasswordValidation)) {
      $Admin_Password = $row1['admin_password'];
      $Admin_Username = $row1['admin_username'];
      $Account_Access = $row1['account_access'];

      if ($Admin_Password === $AdminDefaultPass) {
        echo json_encode([
            "status" => "error",
            "message" => "The password is already set to default and cannot be changed."
        ]);
        exit;
      } 
      
      else {
        // UPDATE RESET PASSWORD - ADMIN

        $ResetPasswordQuery = "UPDATE admin_accounts SET admin_password = '$AdminDefaultPass', admin_account_status = '$Admin_Reset_Status' WHERE admin_id = '$Admin_ID'";
        mysqli_query($connMysqli, $ResetPasswordQuery);

        $EventType = "Reset Password"; 
        $EditDetails = "The current password for the $Account_Access user, ". $Admin_Username . " has been reset.";

        $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
        $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);

        echo json_encode([
            "status" => "success",
            "message" => "The password for the user has been successfully reset."
        ]);
        exit;
      }
    };
  } else {
    echo "No Data Found";
  }
}


// Search Doctor Specialization
if (isset($_POST["SearchSpecs"])) {
  global $connMysqli;
  
  $Admin_ID = $_POST["SpecializationInput"];
  echo $Admin_ID;
}


// VIEW DOCTOR
if (isset($_POST["ViewDoctorType"])) {
  global $connMysqli;
  $ViewDoctorType = $_POST["ViewDoctorType"];
  $ViewDoctor_ID = $_POST["ViewDoctor_ID"];

  if($ViewDoctorType == "View" || $ViewDoctorType == "ArchivedView"){
    $DoctorFetchQuery = "SELECT DISTINCT * from doctor 
    WHERE doctor_account_id = '$ViewDoctor_ID'";
    $DoctorFetchQuery = mysqli_query($connMysqli, $DoctorFetchQuery);
    if (!$DoctorFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorFetchQuery->num_rows > 0) {
      while ($row = mysqli_fetch_assoc($DoctorFetchQuery)) {
        echo " 
          <div class='Modal-Sidebar-Top'>
            <i class='fa-solid fa-user-doctor'></i>
            <h4>View Doctor Information</h4>
          </div>
          <div class='Modal-Sidebar-Main'>
            <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>
              <div class='Div-Container1'>
                <div class='Doctor-Img-Profile'><img src='../Uploaded/".$row['profile_image']."' alt=''></div>
                <div class=''>
                  <h3 class='capitalize'>Dr. ".$row['doctor_firstname']." ".substr($row['doctor_middlename'], 0, 1).". ".$row['doctor_lastname']."</h3>
                  <div class='Doctor-Active'><i class='fa-solid fa-circle'></i> ".$row['doctor_status']."</div>
                </div>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Category:</i>
                <input type='text' readonly placeholder='' value='".$row['doctor_category']."'>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Specialization:</i>
                <div class='InformationField'>
                  ";
                    $DoctorSpecsFetchQuery = "SELECT * from doctor_specialization
                    WHERE specialization_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
                    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSpecsFetchQuery->num_rows > 0) {
                      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$SpecsRow['doctor_specialization_name']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Sub Specialization:</i>
  
                <div class='InformationField'>
                  ";
                    $DoctorSubSpecsFetchQuery = "SELECT * from doctor_sub_specialization
                    WHERE sub_specialization_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSubSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSubSpecsFetchQuery);
                    if (!$DoctorSubSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSubSpecsFetchQuery->num_rows > 0) {
                      while ($SubSpecsRow = mysqli_fetch_assoc($DoctorSubSpecsFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$SubSpecsRow['doctor_sub_specialization_name']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Secretary:</i>
                <div class='InformationField'>";
                    $DoctorSecretaryFetchQuery = "SELECT * from doctor_secretary
                    WHERE secretary_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSecretaryFetchQuery = mysqli_query($connMysqli, $DoctorSecretaryFetchQuery);
                    if (!$DoctorSecretaryFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSecretaryFetchQuery->num_rows > 0) {
                      while ($SecretaryRow = mysqli_fetch_assoc($DoctorSecretaryFetchQuery)) {echo" 
                          <div class='InformationFieldTag'>
                            <p>".$SecretaryRow['doctor_secretary_first_name']."</p> 
                            <ul>
                              <li><i>".$SecretaryRow['doctor_secretary_first_network']."</i> <p>".$SecretaryRow['doctor_secretary_first_number']."</p></li>
                              <li><i>".$SecretaryRow['doctor_secretary_second_network']."</i> <p>".$SecretaryRow['doctor_secretary_second_number']."</p></li>
                            </ul>
  
                          </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Room Number:</i>
                <div class='InformationField'>
                  ";
                    $DoctorRoomFetchQuery = "SELECT * from doctor_room
                    WHERE room_doctor_id = '$ViewDoctor_ID'";
                    $DoctorRoomFetchQuery = mysqli_query($connMysqli, $DoctorRoomFetchQuery);
                    if (!$DoctorRoomFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorRoomFetchQuery->num_rows > 0) {
                      while ($RoomRow = mysqli_fetch_assoc($DoctorRoomFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$RoomRow['doctor_room_number']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Schedule:</i>
                <div class='InformationField'>
                  <table class='table-doctor-schedule'>
                      ";
                        $DoctorScheduleFetchQuery = "SELECT * from doctor_schedule
                        WHERE schedule_doctor_id = '$ViewDoctor_ID'";
                        $DoctorScheduleFetchQuery = mysqli_query($connMysqli, $DoctorScheduleFetchQuery);
                        if (!$DoctorScheduleFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                        if ($DoctorScheduleFetchQuery->num_rows > 0) {
                          while ($ScheduleRow = mysqli_fetch_assoc($DoctorScheduleFetchQuery)) {echo" 
                            <tr>
                              <td>".$ScheduleRow['doctor_schedule_day']."</td> 
                              <td>".$ScheduleRow['doctor_schedule_time']."</td> 
                            </tr>
                            ";
                          }
                        }
                      echo"
                  </table>
                  
                </div>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>HMO Accreditation:</i>
  
                <div class='InformationField'>
                  ";
                    $DoctorHMOFetchQuery = "SELECT * from doctor_hmo
                    WHERE hmo_doctor_id = '$ViewDoctor_ID' ORDER BY doctor_hmo_name";
                    $DoctorHMOFetchQuery = mysqli_query($connMysqli, $DoctorHMOFetchQuery);
                    if (!$DoctorHMOFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorHMOFetchQuery->num_rows > 0) {
                      while ($HMOrow = mysqli_fetch_assoc($DoctorHMOFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$HMOrow['doctor_hmo_name']."</p></div> 
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Remarks:</i>
                <div class='InformationField'>
                  ";
                    $DoctorNotesFetchQuery = "SELECT * from doctor_notes
                    WHERE notes_doctor_id = '$ViewDoctor_ID'";
                    $DoctorNotesFetchQuery = mysqli_query($connMysqli, $DoctorNotesFetchQuery);
                    if (!$DoctorNotesFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorNotesFetchQuery->num_rows > 0) {
                      while ($NotesRow = mysqli_fetch_assoc($DoctorNotesFetchQuery)) {echo" 
                          <p>".$NotesRow['doctor_notes_details']."</p> 
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
            </div>
          </div>
          <div class='Modal-Sidebar-Bottom'>
            <button class='Btn_1' onclick='EditDoctor(`".$row['doctor_account_id']."`)'>Edit</button>
            <button class='Btn_1 yellow_btn' onclick='PromptDoctor(`DeactivateDoctor`, `".$row['doctor_account_id']."`)'>Deactivate</button>
            <button class='Btn_2' onclick='PromptDoctor(`RemoveDoctor`,`".$row['doctor_account_id']."`)'>Delete</button>
          </div>
        ";
      };
    } else {
      echo "No Data Found";
    }
  }
}


// EDIT MODAL DOCTOR
if (isset($_POST["ViewEdit_ID"])) {
  global $connMysqli;
  $ViewEdit_ID = $_POST["ViewEdit_ID"];
  $DoctorFetchQuery = "SELECT * from doctor 
  WHERE doctor_account_id = '$ViewEdit_ID'";
  $DoctorFetchQuery = mysqli_query($connMysqli, $DoctorFetchQuery);
  if (!$DoctorFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
  if ($DoctorFetchQuery->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($DoctorFetchQuery)) {
      $DoctorSex = $row['doctor_sex'];
      $DoctorCategory = $row['doctor_category'];
      if($DoctorSex == "Male"){$SelectedSexIsMale = "Selected"; $SelectedSexIsFemale = "";}
      else{$SelectedSexIsFemale = "Selected";$SelectedSexIsMale = "";}
      if($DoctorCategory == "Regular Consultant"){$DocCategoryRegular = "Selected"; $DocCategoryWaiting = "";}
      else{$DocCategoryWaiting = "Selected";$DocCategoryRegular = "";}

      echo " 
        <div class='Modal-Sidebar-Top'>
          <i class='fa-solid fa-user-pen'></i>
          <h4>Edit Doctor</h4>
        </div>
        <div class='Modal-Sidebar-Main'>
          <div class='EditDoctorDivContainer-Form'>
            <div class='editDoctor-navigation'>
              <ul>
                <li onclick='editNav(1)' class='edit-nav1 editNavActive'>Doctor</li>
                <li onclick='editNav(2)' class='edit-nav2 editNavInactive'>Secretary</li>
              </ul>
            </div>
            <div class='editDoctor-Container'>

              <div class='editDoctor-Child1'>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Last Name:</i>
                  <input type='text' id='EditLastName' placeholder='Last Name' value='".$row['doctor_lastname']."'>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>First Name:</i>
                  <input type='text' id='EditFirstName' placeholder='First Name' value='".$row['doctor_firstname']."'>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Middle Name:</i>
                  <input type='text' id='EditMiddleName' placeholder='Middle Name' value='".$row['doctor_middlename']."'>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Gender:</i>
                  <select name='EditGender' id='EditGender'>
                    <option value='Male' $SelectedSexIsMale>Male</option>
                    <option value='Female' $SelectedSexIsFemale>Female</option>
                  </select>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Category:</i>
                  <select name='' id='EditCategory'>
                    <option value='Regular Consultant' $DocCategoryRegular>Regular Consultant</option>
                    <option value='Visiting Consultant' $DocCategoryWaiting>Visiting Consultant</option>
                  </select>
                </div>
                <br>
                <hr>
                <br>

                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Specialization:</i>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(`Edit`,1)' id='edit_Search1' class='CT1' placeholder='Search Specialization'>
                      <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul id='Edit_Dropdown1' class='EditDropdown1'>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InputFieldForm-i-div'>
                    <div class='hiddenInformationField' id='hiddenInformationFieldIDSpecs'>
                      <!-- Function -->
                        "; 
                          $DoctorSpecsFetchQuery = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$ViewEdit_ID'";
                          $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
                          if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                          if ($DoctorSpecsFetchQuery->num_rows > 0) {
                            while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
                              $specName = htmlspecialchars($SpecsRow['doctor_specialization_name'], ENT_QUOTES, 'UTF-8');
                              echo" 
                                <div class='ClickableList' >
                                  <i class='fa-solid fa-trash' onclick=\"removeSelected(this, '$specName')\"></i>
                                  <p>$specName</p>
                                </div>
                              ";
                            }
                          }
                        echo "
                    </div>
                  </div>
                </div>

                <br>

                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Sub Specialization:</i>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(`Edit`, 2)' id='edit_Search2' class='CT2' placeholder='Search Sub Specialization'>
                      <div class='inputFlexIcon' onclick='closeSearch(2)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul id='Edit_Dropdown2'>
                          <!-- Function -->
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InputFieldForm-i-div'>
                    <div class='hiddenInformationField' id='hiddenInformationFieldIDSubSpecs'>
                          <!-- Function -->
                          "; 
                              $DoctorSpecsFetchQuery = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$ViewEdit_ID'";
                              $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
                              if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                              if ($DoctorSpecsFetchQuery->num_rows > 0) {
                                while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
                                  <div class='ClickableList'><i class='fa-solid fa-trash'></i> <p>".$SpecsRow['doctor_sub_specialization_name']."</p></div>
                              ";
                            }
                          }
                        echo "
                    </div>
                  </div>
                </div>



                <br>
                <hr>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Schedule:</i>
                  <div class='InputFieldForm-div'>
                    <div class='InputFieldForm-schedule'>
                      <p>Select Day</p>
                      <select id='day-select' name='day-select'>
                        <option value='Monday'>Monday</option>
                        <option value='Tuesday'>Tuesday</option>
                        <option value='Wednesday'>Wednesday</option>
                        <option value='Thursday'>Thursday</option>
                        <option value='Friday'>Friday</option>
                        <option value='Saturday'>Saturday</option>
                        <option value='Sunday'>Sunday</option>
                      </select>
                    </div>
                    <div class='InputFieldForm-divFlexColumn'>
                      <div class='InputFieldForm-schedule'>
                        <p>Time Start</p>
                        <input type='time' id='pick-time' name='pick-time'>
                      </div>
                      <div class='InputFieldForm-schedule'>
                        <p>Time End</p>
                        <input type='time' id='pick-time' name='pick-time'>
                      </div>
                      <div class='InputFieldForm-schedule'>
                        <button class='Btn_1'>Add</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InformationField'></div>
                </div>
 
 
 
 




                
                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Room:</i>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(`Edit`, 3)' id='edit_Search3' placeholder='Search Room'>
                      <div class='inputFlexIcon' onclick='closeSearch(3)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul id='Edit_Dropdown3'>
                          <!-- Function -->
                      </ul>
                    </div>
                  </div>
                </div>
                
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                    <div class='InputFieldForm-i-div'>
                      <div class='hiddenInformationField' id='hiddenInformationFieldIDSubSpecs'>
                        <!-- Function -->
                          "; 
                              $DoctorRoomFetchQuery = "SELECT * FROM doctor_room WHERE room_doctor_id = '$ViewEdit_ID'";
                                  $DoctorRoomFetchQuery = mysqli_query($connMysqli, $DoctorRoomFetchQuery);
                                  if (!$DoctorRoomFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                                  if ($DoctorRoomFetchQuery->num_rows > 0) {
                                    while ($RoomRow = mysqli_fetch_assoc($DoctorRoomFetchQuery)) {
                                    echo" 
                                      <div class='ClickableList'><i class='fa-solid fa-trash'></i> <p>".$RoomRow['doctor_room_number']."</p></div>
                                    ";
                                }
                              }
                          echo "
                        </div>
                      </div>
                    </div>
                <br>

                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>HMO Accreditation:</i>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(`Edit`, 4)' id='edit_Search4' placeholder='Search HMO Accreditation'>
                      <div class='inputFlexIcon' onclick='closeSearch(4)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul id='Edit_Dropdown4'>
                          <!-- Function -->
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InputFieldForm-i-div'>
                    <div class='hiddenInformationField' id='hiddenInformationFieldIDHMO'>
                      <!-- Function -->
                        ";
                            $DoctorHMOFetchQuery = "SELECT * from doctor_hmo
                            WHERE hmo_doctor_id = '$ViewEdit_ID' ORDER BY doctor_hmo_name";
                            $DoctorHMOFetchQuery = mysqli_query($connMysqli, $DoctorHMOFetchQuery);
                            if (!$DoctorHMOFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                            if ($DoctorHMOFetchQuery->num_rows > 0) {
                              while ($HMORow = mysqli_fetch_assoc($DoctorHMOFetchQuery)) {
                                echo" 
                                   <div class='ClickableList'><i class='fa-solid fa-trash'></i> <p>".$HMORow['doctor_hmo_name']."</p></div>
                                ";
                              }
                            }
                        echo"
                    </div>
                  </div>
                </div>

                <br>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Teleconsultaion:</i>
                  ";
                    $TeleconsultationSelectQuery = "SELECT * from doctor_teleconsult WHERE teleconsult_doctor_id = '$ViewEdit_ID'";
                    $TeleconsultationSelectQuery = mysqli_query($connMysqli, $TeleconsultationSelectQuery);
                    if (!$TeleconsultationSelectQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                      if ($TeleconsultationSelectQuery->num_rows > 0) {
                        while ($TeleconsultRow = mysqli_fetch_assoc($TeleconsultationSelectQuery)) {
                          echo" 
                            <input type='text' id='DoctorsTeleConsult' placeholder='Teleconsultation' value = ". $TeleconsultRow['teleconsult_link'].">
                          ";
                        }
                      }

                    echo "
                </div>

                <br>
                <hr>
                <br>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Remarks:</i>
                    ";
                      $RemarksSelectQuery = "SELECT * from doctor_notes WHERE notes_doctor_id = '$ViewEdit_ID'";
                      $RemarksSelectQuery = mysqli_query($connMysqli, $RemarksSelectQuery);
                      if (!$RemarksSelectQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                        if ($RemarksSelectQuery->num_rows > 0) {
                          while ($RemarksRow = mysqli_fetch_assoc($RemarksSelectQuery)) {
                            echo" 
                              <textarea name='' id='DoctorsRemarks' class='DoctorRemarks' placeholder='Input Notes'>". $RemarksRow['doctor_notes_details']."</textarea>
                            ";
                          }
                        }
                    echo "
                </div>
              


              </div>

              <div class='editDoctor-Child2'>
                <h4>Secretary</h4>
                <table>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Primary Number</th>
                      <th>Secondary Number</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                      ";
                        $DoctorSecretaryFetchQuery = "SELECT * from doctor_secretary
                        WHERE secretary_doctor_id = '$ViewEdit_ID'";
                         $DoctorSecretaryFetchQuery = mysqli_query($connMysqli,  $DoctorSecretaryFetchQuery);
                        if (! $DoctorSecretaryFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                        if ( $DoctorSecretaryFetchQuery->num_rows > 0) {
                          while ($SecretaryRow = mysqli_fetch_assoc($DoctorSecretaryFetchQuery)) {echo" 
                            <tr>
                              <td>".$SecretaryRow['doctor_secretary_first_name']."</td> 
                              <td>".$SecretaryRow['doctor_secretary_first_number']."</td> 
                              <td>".$SecretaryRow['doctor_secretary_second_number']."</td> 
                              <td> <button> Delete </button> </td>
                            </tr>
                            ";
                          }
                        }
                      echo"
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
        <div class='Modal-Sidebar-Bottom'>
          <button class='Btn_1' onclick='PromptDoctor(`UpdateDoctor`,`".$row['doctor_account_id']."`)'>Save</button>
          <button class='Btn_2' onclick='BackToViewDoctor()'>Cancel</button>
        </div>
      ";
    };
  } else {
    echo "No Data Found";
  }
}


// SEARCH
if (isset($_POST["searchId"])) {
  global $connMysqli;
  $searchId = $_POST["searchId"];
  $searchName = $_POST["searchName"];
  $SearchType = $_POST["SearchType"];

  if($searchId == 1){
    $DoctorSpecsFetchQuery = "SELECT * from specialization
    WHERE specialization_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
        if($SearchType == "Edit"){
          echo" 
            <li onclick='selectThis(`Specs`,".$SpecsRow['specialization_id'].",`InsertEditSpecs`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['specialization_name']."</p></li>
          ";
        }
        else{
          echo" 
            <li onclick='selectThis(`Specs`,".$SpecsRow['specialization_id'].",`InsertSpecs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['specialization_name']."</p></li>
          ";
        }
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 2){
    $DoctorSpecsFetchQuery = "SELECT * from sub_specialization
    WHERE sub_specialization_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
        if($SearchType == "Edit") {
          echo" 
            <li onclick='selectThis(`SubSpecs`,".$SpecsRow['sub_specialization_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['sub_specialization_name']."</p></li>
          ";
        }
        else { 
          echo" 
            <li onclick='selectThis(`SubSpecs`,".$SpecsRow['sub_specialization_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['sub_specialization_name']."</p></li>
          ";
        }
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 3){
    $DoctorSpecsFetchQuery = "SELECT * from room
    WHERE room_floor_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
        if ($SearchType == "Edit") {
          echo "
             <li onclick='selectThis(`Room`,".$SpecsRow['room_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['room_floor_name']."</p></li>
          ";
        }
        else {
          echo" 
            <li onclick='selectThis(`Room`,".$SpecsRow['room_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['room_floor_name']."</p></li>
          ";
        }
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 4){
    $DoctorSpecsFetchQuery = "SELECT * from hmo
    WHERE hmo_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
        if($SearchType == "Edit") { 
          echo" 
            <li onclick='selectThis(`HMO`,".$SpecsRow['hmo_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['hmo_name']."</p></li>
          ";
        }
        else {
          echo" 
            <li onclick='selectThis(`HMO`,".$SpecsRow['hmo_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['hmo_name']."</p></li>
          ";
        }
      }
    }
    else{
      echo "Nothing Found!";
    }
  }

}


// SELECT SPECS
if (isset($_POST["functionSelectedItems"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems"];
  $selectedId = $_POST["selectedId"];
  $selectedCode = $_POST["selectedCode"];
  $selectedDoctorID = $_POST["selectedDoctorID"];

  if($selectedCode == "InsertEditSpecs"){
      $InsertEditSpecs = $connPDO->prepare("INSERT INTO `doctor_specialization`(specialization_doctor_id, specialization_id_2, doctor_specialization_name) VALUES(?,?,?)");
      $InsertEditSpecs->execute([$selectedDoctorID, $selectedId, 'Updated']);
      
      echo "Insert new Edit Specs";
  }
  else{
    if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
      $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
      $DoctorSpecsFetchQuery = "SELECT * FROM specialization WHERE specialization_id IN ($ids)";
      $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
      if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsFetchQuery->num_rows > 0) {
        while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
          $specName = htmlspecialchars($SpecsRow['specialization_name'], ENT_QUOTES, 'UTF-8');
          echo" 
            <div class='ClickableList' data-id='{$SpecsRow['specialization_id']}'>
              <i class='fa-solid fa-trash' onclick=\"removeSelected(this, '{$SpecsRow['specialization_id']}', 'Specs')\"></i>
              <p>$specName</p>
            </div>
          ";
        }
      }
      else{
        echo "Nothing Found!";
      }
    } else {
        echo "No valid items selected.";
    }
  }


}


// SELECT SUB SPECS
if (isset($_POST["functionSelectedItems2"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems2"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {
        $specSubName = htmlspecialchars($SpecsRow['sub_specialization_name'], ENT_QUOTES, 'UTF-8');
        echo" 
            <div class='ClickableList' data-id='{$SpecsRow['sub_specialization_id']}'>
              <i class='fa-solid fa-trash' onclick=\"removeSelected(this, '{$SpecsRow['sub_specialization_id']}', 'SubSpecs')\"></i>
              <p>$specSubName</p>
            </div>
          ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}

// SELECT ROOM
if (isset($_POST["functionSelectedItems3"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems3"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM room WHERE room_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo"
          <div class='ClickableList'><i class='fa-solid fa-trash' onclick='removeClickableList(this)'></i> <p>".$SpecsRow['room_floor_name']."</p></div>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}


// SELECT HMO 
if (isset($_POST["functionSelectedItems4"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems4"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM hmo WHERE hmo_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
          <div class='ClickableList'><i class='fa-solid fa-trash' onclick='removeClickableList(this)'></i> <p>".$SpecsRow['hmo_name']."</p></div>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}


// ADD ITEMS DIV
if (isset($_POST["AddItemsItemType"])) {
  global $connMysqli;
  $AddItemsItemType = $_POST["AddItemsItemType"];

  if($AddItemsItemType == "Specs"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Specialization</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <label for='AddName'>Name</label>
            <input type='text' id='InsertDataName'>
            <button onclick='InsertDocData(`Specs`)'>Insert</button>
          </div>
        </div>
        
        <div class='Add-Items-Message'></div>
    ";
  }
  elseif($AddItemsItemType == "SubSpecs"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Sub Specialization</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <div class='Add-Items-Div'>
              <!-- <label for='AddName'>Specialization Name</label> -->
              <!-- <input type='text' id='InsertDataSpecsName' onkeyup='SearchAddSpecs(`InsertDataSpecsName`)'> -->
              <input type='hidden' id='InsertDataID'>

              <div class='Add-Items-List'>
                list
              </div>
            </div>
            <div class=''>
              <label for='AddName'>Sub Specialization Name</label>
              <input type='text' id='InsertDataName'>
            </div>
          </div>
          <br>
            <button onclick='InsertDocData(`SubSpecs`)'>Insert</button>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }
  elseif($AddItemsItemType == "HMO"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add HMO</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <label for='AddName'>Name</label>
            <input type='text' id='InsertDataName'>
            <button onclick='InsertDocData(`HMO`)'>Insert</button>
          </div>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }

  elseif($AddItemsItemType == "Room"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Room</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <div class='Add-Items-Div'>
              <label for='AddName'>Floor Level</label>
              <input type='text' id='InsertDataFloorLevel'>
            </div>
            <div class=''>
              <label for='AddName'>Room Number</label>
              <input type='text' id='InsertDataRoomNumber'>
            </div>
          </div>
          <br>
            <button onclick='InsertDocData(`Room`)'>Insert</button>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }
}


// INSERT DATA ITEMS      
if (isset($_POST["InsertDocDataItemType"])) {
  global $connMysqli;
  $InsertDocDataItemType = $_POST["InsertDocDataItemType"];
  if($InsertDocDataItemType == "Room"){
    $InsertDocDataName = $_POST["InsertDocDataName"];
  }
  else if($InsertDocDataItemType == "SubSpecs"){
    $InsertDocDataName = $_POST["InsertDocDataName"];
    $InsertDocDataID = $_POST["InsertDocDataID"];
  }
  else{
    $InsertDocDataName = $_POST["InsertDocDataName"];
  }

  if($InsertDocDataName != ""){
    if($InsertDocDataItemType == "Specs"){
      $DoctorSpecsInsertQuery = "SELECT * FROM specialization WHERE specialization_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `specialization`(specialization_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "SubSpecs"){
      $DoctorSpecsInsertQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `sub_specialization`(sub_specs_id, sub_specialization_name) VALUES(?,?)");
        $InsertDoctorSpecs->execute([$InsertDocDataID, $InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "HMO"){
      $DoctorSpecsInsertQuery = "SELECT * FROM hmo WHERE hmo_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `hmo`(hmo_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "Room"){
      // $InsertDataFloorLevel = $_POST["InsertDataFloorLevel"];
      // $InsertDataFloorNumber = $_POST["InsertDataFloorNumber"];
      // $InsertData = $InsertDataFloorLevel . " - " . $InsertDocDataName;
      $DoctorSpecsInsertQuery = "SELECT * FROM room WHERE room_floor_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `room`(room_floor_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
  
  }
  else{
    echo "Input Text!";
  }
}


// SEARCH FOR SUB SPECS
if (isset($_POST["SearchAddSpecs"])) {
  global $connMysqli;
  $InsertDataSpecsName = $_POST["InsertDataSpecsName"];

  $DoctorSpecsInsertQuery = "SELECT * FROM specialization WHERE specialization_name LIKE '%$InsertDataSpecsName%' ";

  $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
  if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
  if ($DoctorSpecsInsertQuery->num_rows > 0) {
    while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsInsertQuery)) {echo" 
      <p onclick='selectThisAddSubSpecs(`".$SpecsRow['specialization_name']."`, `".$SpecsRow['specialization_id']."`)' >".$SpecsRow['specialization_name']."</p>
      ";
    }
  }
  else{
    echo "Nothing Found";
  }
}


// ADD SCHEDULE
if (isset($_POST["AddSchedule"])) {
  global $connMysqli;
  $AddSchedule = $_POST["AddSchedule"];
  $together = $_POST["together"];

  $arr = implode(",", $AddSchedule);
  foreach ($AddSchedule as $schedule) {
    echo "
      <div class='ClickableList'><i class='fa-solid fa-trash' onclick='removeClickableList(this)'></i> <p>". htmlspecialchars($schedule) ."</p></div>
    ";
  }
}



// ADD SECRETARY
if (isset($_POST["AddSecretary"])) {
  $AddSecretary = $_POST["AddSecretary"];

  foreach ($AddSecretary as $remarks) {
      if (is_array($remarks) && isset($remarks['name'], $remarks['number'], $remarks['network'])) {
          echo "
          <div class='SecretaryCard'>
              <ul>
                  <li><div class='SecHeader'><h3>" . htmlspecialchars($remarks['name']) . "</h3> <i class='fa-solid fa-trash' onclick='removeClickableList(this)'></i></div></li>
                  <li>" . htmlspecialchars($remarks['network']) . " - " . htmlspecialchars($remarks['number']) . "</li>
                  <li>" . htmlspecialchars($remarks['network2']) . " - " . htmlspecialchars($remarks['number2']) . "</li>
              </ul>
          </div>
          ";
      } else {
          echo "<p>Invalid secretary data.</p>";
      }
  }
}



// UPDATE DOCTOR
if (isset($_POST["UpdateDoctorType"])) {
  global $connMysqli;
  $UpdateDoctorType = $_POST["UpdateDoctorType"];
  $DoctorID = $_POST["DoctorID"];
  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  $FetchDoctorId = "SELECT * FROM doctor WHERE doctor_account_id = '$DoctorID' ";
  $FetchDoctorId = mysqli_query($connMysqli, $FetchDoctorId);
  if (!$FetchDoctorId) {die('MySQL ErrorL ' . mysqli_error($conn));}
  if ($FetchDoctorId->num_rows > 0) {
    while ($DocRow = mysqli_fetch_assoc($FetchDoctorId)) {
      $DocFullName = $DocRow['doctor_firstname'] . " " . $DocRow['doctor_middlename'] . " " . $DocRow['doctor_lastname'];
    }
  }else{echo "Nothing Found";}

  if($UpdateDoctorType == "Delete"){
    $query = "DELETE FROM `doctor` WHERE `doctor_account_id` = '$DoctorID'";
    mysqli_query($connMysqli, $query);
    $EventType = "Remove Doctor";
    $EditDetails = "Removed Doctor: Dr. ".$DocFullName;
    // echo "Account Deleted.";

  }

  if($UpdateDoctorType == "Deactivate"){
    $query = "UPDATE doctor SET `doctor_status` = 'INACTIVE', `doctor_archive_status` = 'VISIBLE' WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);
    $EventType = "Remove Doctor";
    $EditDetails = "Deactivated Doctor: Dr. ".$DocFullName;
    // echo "Account Deactivated.";

  }

  elseif($UpdateDoctorType == "Restore"){
    $query = "UPDATE doctor SET doctor_archive_status = 'VISIBLE' WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);

    $query = "UPDATE doctor SET doctor_status = 'ACTIVE' WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);
    
    $EventType = "Restore Doctor";
    $EditDetails = "Restored: ".$DocFullName;
    // echo "Account Restored.";
  }

  elseif($UpdateDoctorType == "Edit"){

    $EditLastname = $_POST["EditLastname"];
    $EditFirstname = $_POST["EditFirstname"];
    $EditMiddlename = $_POST["EditMiddlename"];
    $EditGender = $_POST["EditGender"];
    $EditCategory = $_POST["EditCategory"];

    $query = "UPDATE doctor SET 
    doctor_lastname = '$EditLastname', 
    doctor_firstname = '$EditFirstname', 
    doctor_middlename = '$EditMiddlename',
    doctor_sex = '$EditGender',
    doctor_category = '$EditCategory'
    WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);

    $EventType = "Update Doctor";
    $EditDetails = "Updated Doctor Information of Dr. ".$DocFullName;
    echo "Account Updated.";
  }
  $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
  $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
}



//ADD HMO 
if (isset($_POST["AddHMO"])) {
  $HMOName = $_POST["HMOName"];
  $UserID =  $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  $query = $connPDO->prepare("INSERT INTO `hmo`(hmo_name) VALUES(?)");
  $query->execute([$HMOName]); 

  $EventType = "Added Data"; 
  $EditDetails = 'Added HMO (HMO Name: '. $HMOName .')';

  $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
  $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);

}

//EDIT HMO 
if (isset($_POST["EditHMO_ID"])) {
  global $connMysqli;
  $HMO_ID = $_POST["EditHMO_ID"];

  $FetchQuery = "SELECT * from hmo
  WHERE hmo_id = '$HMO_ID'";
  $FetchQuery = mysqli_query($connMysqli, $FetchQuery);

  if (!$FetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($FetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($FetchQuery)) {
      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Edit HMO</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>

                <label for=''> Details </label>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>HMO Name</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['hmo_name'] . " </span> </div>
                </div>

                <label for=''> Edit Section </label>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>New HMO Name: </i>
                  <input type='text' id='EditHMOName' placeholder='".$row1['hmo_name']."' value=''>
                </div>

              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='PromptHMO(" . $row1['hmo_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ModalSidebarExit()'>Cancel</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }

}

//IF YES EDIT HMO 
if (isset($_POST["Yes_EditHMO"])) { 
  global $connMysqli;

  $EditedHMO_ID = $_POST["Yes_EditHMO"]; 
  $NewHMOName = $_POST["NewHMOName"];

  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  //Fetching previous data before updating 
  $LastUpdateQuery = "SELECT hmo_name from hmo
  WHERE hmo_id = '$EditedHMO_ID'";
  $LastUpdateQuery = mysqli_query($connMysqli, $LastUpdateQuery);

    if($LastUpdateQuery->num_rows > 0) {
      while($row = mysqli_fetch_assoc($LastUpdateQuery)) {
      $LastHMOName = $row['hmo_name'];

      $query = "UPDATE hmo SET hmo_name = '$NewHMOName' WHERE hmo_id = '$EditedHMO_ID'";
      mysqli_query($connMysqli, $query);

      $EventType = "Update Data"; 
      $EditDetails = 'Updated HMO Name (Before: ' . $LastHMOName . ', After: ' . $NewHMOName . ')';

      $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
      $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
    }
  }

}


//ADD ROOM 
if (isset($_POST["AddRoom"])) {
  $FloorLevel = $_POST["FloorLevel"];
  $RoomNumber = $_POST["RoomNumber"];

  $Room = $FloorLevel . ' - ' . $RoomNumber;

  $query = $connPDO->prepare("INSERT INTO `room`(room_floor_name) VALUES(?)");
  $query->execute([$Room]);
}

//EDIT ROOM 
if (isset($_POST["EditRoom_ID"])) {
  global $connMysqli;
  $Room_ID = $_POST["EditRoom_ID"];

  $FetchQuery = "SELECT * from room
  WHERE room_id = '$Room_ID'";
  $FetchQuery = mysqli_query($connMysqli, $FetchQuery);

  if (!$FetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($FetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($FetchQuery)) {
      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Edit Room</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>

                <label for=''> Details </label>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Floor/Room:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['room_floor_name'] . " </span> </div>
                </div>
              
                <label for=''> Edit Section </label>
                

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>New Floor/Room: </i>
                  <input type='text' id='EditRoomName' placeholder='Current: ".$row1['room_floor_name']."' value=''>
                </div>

              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='PromptRoom(" . $row1['room_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ModalSidebarExit()'>Cancel</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }

}

//IF YES EDIT ROOM
if (isset($_POST["Yes_EditRoom_ID"])) { 
  global $connMysqli;

  $EditedRoom_ID = $_POST["Yes_EditRoom_ID"]; 
  $NewRoomName = $_POST["NewRoomName"];

  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  //Fetching previous data before updating 
  $LastUpdateQuery = "SELECT room_floor_name from room
  WHERE room_id = '$EditedRoom_ID'";
  $LastUpdateQuery = mysqli_query($connMysqli, $LastUpdateQuery);

    if($LastUpdateQuery->num_rows > 0) {
      while($row = mysqli_fetch_assoc($LastUpdateQuery)) {
      $LastRoomName = $row['room_floor_name'];

      $query = "UPDATE room SET room_floor_name = '$NewRoomName' WHERE room_id = '$EditedRoom_ID'";
      mysqli_query($connMysqli, $query);

      $EventType = "Update Data"; 
      $EditDetails = 'Updated Floor/Room Name (Before: ' . $LastRoomName . ', After: ' . $NewRoomName . ')';

      $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
      $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
    }
  }

}



//ADD SPECIALIZATION 
if (isset($_POST["AddSpecialization"])) {
  $SpecializationName = $_POST["SpecializationNameToBeAdded"];
  $UserID =  $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  $query = $connPDO->prepare("INSERT INTO `specialization`(specialization_name) VALUES(?)");
  $query->execute([$SpecializationName]); 

  $EventType = "Added Data"; 
  $EditDetails = 'Added Specialization (Specialization Name: '. $SpecializationName .')';

  $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
  $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
}

//EDIT SPECIALIZATION
if (isset($_POST["EditSpecialization_ID"])) {
  global $connMysqli;
  $Specialization_ID = $_POST["EditSpecialization_ID"];

  $FetchQuery = "SELECT * from specialization
  WHERE specialization_id = '$Specialization_ID'";
  $FetchQuery = mysqli_query($connMysqli, $FetchQuery);

  if (!$FetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($FetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($FetchQuery)) {
      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Edit Specialization</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>

                <label for=''> Details </label>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Specialization Name</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['specialization_name'] . " </span> </div>
                </div>
              
                <label for=''> Edit Section </label>
                

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>New Specialization Name: </i>
                  <input type='text' id='EditSpecializationName' placeholder='Current: ".$row1['specialization_name']."' value=''>
                </div>

              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='PromptSpecialization(" . $row1['specialization_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ModalSidebarExit()'>Cancel</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }

}

//IF YES EDIT SPECIALIZATION
if (isset($_POST["Yes_EditSpecialization_ID"])) { 
  global $connMysqli;

  $EditedSpecialization_ID = $_POST["Yes_EditSpecialization_ID"]; 
  $NewSpecializationName = $_POST["NewSpecializationName"];

  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  //Fetching previous data before updating 
  $LastUpdateQuery = "SELECT specialization_name from specialization
  WHERE specialization_id = '$EditedSpecialization_ID'";
  $LastUpdateQuery = mysqli_query($connMysqli, $LastUpdateQuery);

    if($LastUpdateQuery->num_rows > 0) {
      while($row = mysqli_fetch_assoc($LastUpdateQuery)) {
      $LastSpecializationName = $row['specialization_name'];

      $query = "UPDATE specialization SET specialization_name = '$NewSpecializationName' WHERE specialization_id = '$EditedSpecialization_ID'";
      mysqli_query($connMysqli, $query);

      $EventType = "Update Data"; 
      $EditDetails = 'Updated Specialization Name (Before: ' . $LastSpecializationName . ', After: ' . $NewSpecializationName . ')';

      $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
      $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
    }
  }

}


//ADD SUB-SPECIALIZATION 
if (isset($_POST["AddSubSpecialization"])) {
  $SubSpecializationName = $_POST["SubSpecializationNameToBeAdded"];
  $SelectedSpecialization = $_POST["Sub SpecializationToDepend"];
  $UserID =  $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  $query = $connPDO->prepare("INSERT INTO `sub_specialization`(sub_specs_id, sub_specialization_name) VALUES(?,?)");
  $query->execute([$SelectedSpecialization, $SubSpecializationName]); 

  $SpecializationDataQuery = "SELECT specialization_name from specialization
  WHERE specialization_id = '$SelectedSpecialization'";
  $SpecializationDataQuery = mysqli_query($connMysqli, $SpecializationDataQuery);

    if($SpecializationDataQuery->num_rows > 0) {
      while($row = mysqli_fetch_assoc($SpecializationDataQuery)) {
      $SpecializationName = $row['specialization_name'];

      $EventType = "Added Data"; 
      $EditDetails = 'Added Sub-Specialization (Sub-specialization Name: '. $SubSpecializationName .', under ' . $SpecializationName . ')';

      $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
      $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
    }
  }
}



//EDIT SUB-SPECIALIZATION
if (isset($_POST["EditSubSpecialization_ID"])) {
  global $connMysqli;
  $SubSpecialization_ID = $_POST["EditSubSpecialization_ID"];

  $FetchQuery = "SELECT * from sub_specialization
  INNER JOIN specialization ON sub_specialization.sub_specs_id = specialization.specialization_id
  WHERE sub_specialization_id = $SubSpecialization_ID";
  $FetchQuery = mysqli_query($connMysqli, $FetchQuery);

  if (!$FetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($FetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($FetchQuery)) {
      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Edit Sub-specialization</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>

                <label for=''> Details </label>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Sub-specialization Name</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['sub_specialization_name'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Specialization Name</i>
                  <div class='InputFieldForm-Info'> 
                    <span> 
                    ". $row1['specialization_name'] ."
                    </span> 
                  </div>
                </div>
              
                <label for=''> Edit Section </label>
                
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>New Specialization Name: </i>
                  <select name='NewSpecForSubSpec' id='NewSpecForSubSpec'> ";
                  $sub_specs_id = $row1['sub_specs_id']; 

                  $query = "SELECT * FROM specialization"; 
                  $query = mysqli_query($connMysqli, $query);

                  if($query->num_rows > 0) {
                    while($row2 = mysqli_fetch_assoc($query)) {
                        $NewSelectedSpecialization = ($row2['specialization_id'] == $sub_specs_id) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($row2['specialization_id']) . "' $NewSelectedSpecialization>" . htmlspecialchars($row2['specialization_name']) . "</option>";
                    };
                  }  
                          
                  else {
                        echo "No data found";     
                  }

                echo "
                  </select>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>New Sub-specialization Name: </i>
                  <input type='text' id='EditSubSpecializationName' placeholder='Current: ".$row1['sub_specialization_name']."' value='".$row1['sub_specialization_name']."'>
                </div>

              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='PromptSubSpecialization(" . $row1['sub_specialization_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ModalSidebarExit()'>Cancel</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }

}

//IF YES EDIT SUB-SPECIALIZATION
if (isset($_POST["Yes_EditSubSpecialization_ID"])) { 
  global $connMysqli;

  $EditedSubSpecialization_ID = $_POST["Yes_EditSubSpecialization_ID"]; 
  $NewSubSpecializationName = $_POST["NewSubSpecializationName"];
  $NewSelectedSpecialization = $_POST["NewSelectedSpecialization"];

  $UserID = $_POST["UserID"];
  $decrypted_user_id = decrypt_user_id($UserID);

  //Fetching previous data before updating 
  $LastUpdateQuery = "SELECT * from sub_specialization
  INNER JOIN specialization ON sub_specialization.sub_specs_id = specialization.specialization_id
  WHERE sub_specialization_id = '$EditedSubSpecialization_ID'";
  $LastUpdateQuery = mysqli_query($connMysqli, $LastUpdateQuery);

    if($LastUpdateQuery->num_rows > 0) {
      while($row = mysqli_fetch_assoc($LastUpdateQuery)) {
      $LastSubSpecializationName = $row['sub_specialization_name'];
      $LastSpecializationName = $row['specialization_name'];

      $query = "UPDATE sub_specialization SET sub_specialization_name = '$NewSubSpecializationName', sub_specs_id = $NewSelectedSpecialization WHERE sub_specialization_id = $EditedSubSpecialization_ID";
      mysqli_query($connMysqli, $query);

      //Fetching updated specialization name
      $FetchingSpecializationName = "SELECT * from sub_specialization
      INNER JOIN specialization ON sub_specialization.sub_specs_id = specialization.specialization_id
      WHERE sub_specialization_id = $EditedSubSpecialization_ID";
      $FetchingSpecializationName = mysqli_query($connMysqli, $FetchingSpecializationName);

      if($FetchingSpecializationName->num_rows > 0) {
        while($row1 = mysqli_fetch_assoc($FetchingSpecializationName)) {
          $UpdatedSpecializationName = $row1['specialization_name'];
          $UpdatedSubSpecializationName = $NewSubSpecializationName;

          $EventType = "Update Data"; 
          $EditDetails = 'Updated Sub-Specialization Name (Before: ' . $LastSubSpecializationName . ' under '. $LastSpecializationName .', After: ' . $UpdatedSubSpecializationName . ' under ' . $UpdatedSpecializationName . ')';

          $InsertLogs = $connPDO->prepare("INSERT INTO `admin_activity_logs`(activity_logs_admin_id, event_type, edit_details) VALUES(?,?,?)");
          $InsertLogs->execute([$decrypted_user_id, $EventType, $EditDetails]);
        }
      }
      else {
        echo "error";
      }
    }
  }

  else {
    echo "error, please try again";
  }
}


?>