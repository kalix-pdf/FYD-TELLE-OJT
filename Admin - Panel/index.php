<?php
  session_start();
  include "../Config/Configure.php";
  if (isset($_SESSION['Admin_Id'])) {
    $Admin_id = $_SESSION['Admin_Id'];
    $ACCOUNT = "SELECT * FROM admin_accounts WHERE `admin_id`= '$Admin_id' ";
    $ACCOUNT = mysqli_query($connMysqli, $ACCOUNT);
    while ($row = mysqli_fetch_assoc($ACCOUNT)) {
      $user_id = $row['admin_id'];
      $AdminName = $row['admin_username'];

      // ENCRYPT ID
      function encrypt_user_id($user_id) {
        $encryption_key = 'your-encryption-key';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted_user_id = openssl_encrypt($user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted_user_id . '::' . $iv);
      }
      // DECRYPT ID
      function decrypt_user_id($encrypted_data) {
        $encryption_key = 'your-encryption-key';
        list($encrypted_user_id, $iv) = explode('::', base64_decode($encrypted_data), 2);
        return openssl_decrypt($encrypted_user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
      }
      $encrypted_user_id = encrypt_user_id($user_id);
      $decrypted_user_id = decrypt_user_id($encrypted_user_id);

    }
    // ACCOUNT ACCESS
    $ACCESS = "SELECT * FROM admin_accounts WHERE `admin_id`= '$Admin_id' AND (account_access = 'Super Admin')";
    $ACCESS = mysqli_query($connMysqli, $ACCESS);
    if ($ACCESS === false) {
      echo 'MySQL Error:' . mysqli_error($conn);
    }

    //COUNT
    $CountTotalDoctorQuery = mysqli_query($connMysqli, "SELECT * FROM doctor ");
    $CountTotalDoctorRow = mysqli_num_rows($CountTotalDoctorQuery);
    $CountTotalDoctor = $CountTotalDoctorRow;

    $CountTotalActiveDoctor = mysqli_query($connMysqli, "SELECT * FROM doctor WHERE doctor_status = 'ACTIVE' ");
    $CountTotalActiveDoctor = mysqli_num_rows($CountTotalActiveDoctor);
    
    $CountTotalInActiveDoctor = mysqli_query($connMysqli, "SELECT * FROM doctor WHERE doctor_status = 'INACTIVE' ");
    $CountTotalInActiveDoctor = mysqli_num_rows($CountTotalInActiveDoctor);
    
    $CountTotalAdmin = mysqli_query($connMysqli, "SELECT * FROM admin_accounts WHERE admin_status = 'Active' ");
    $CountTotalAdmin = mysqli_num_rows($CountTotalAdmin);

    $CountTotalVisitingConsultation = mysqli_query($connMysqli, "SELECT * FROM doctor WHERE doctor_category = 'Visiting Consultant'  ");
    $CountTotalVisitingConsultation = mysqli_num_rows($CountTotalVisitingConsultation);

    $CountTotalRegularConsultation = mysqli_query($connMysqli, "SELECT * FROM doctor WHERE doctor_category = 'Regular Consultant' ");
    $CountTotalRegularConsultation = mysqli_num_rows($CountTotalRegularConsultation);

    $CountTotalHMO = mysqli_query($connMysqli, "SELECT * FROM hmo ");
    $CountTotalHMO = mysqli_num_rows($CountTotalHMO);


  } else {
    header('location: ../Admin Panel Login');
  };
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://cdn.lordicon.com/libs/mojs/2.7.0/mojs.min.js"></script>
  <script defer type="text/javascript" src="../Assets/JS_Admin.js?ver=<?php echo time(); ?>"></script>
  <link href="../Assets/Images/EACMC_LOGO 1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="../Assets/CSS_Public.css?ver=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Assets/CSS_Admin.css?ver=<?php echo time(); ?>">
  <title>EACMed - Admin</title>
</head>

<body>
  <div class="AdminDiv">
    <!-- SIDEBAR -->
      <section class="AdminSidebar">
        <div class="AdminSidebarDiv1">
          <div class="AdminSidebarDiv1IMG"><img src="../Assets/Images/EACMed Logo.png" alt=""></div>
        </div>
        <div class="AdminSidebarDiv2">
          <ul>
            <li class="Sidebar_Focus SBFocus1 Sidebar_Active" onclick="BTNDashboard()"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li class="Sidebar_Focus SBFocus2 " onclick="BTNDoctors()"> <i class="fa-solid fa-user-doctor"></i> Doctors</li>

            <?php if (mysqli_num_rows($ACCESS) > 0) { ?>
              <li class="Sidebar_Focus SBFocus6 " onclick="BTN_HMO()"> <i class="fa-solid fa-notes-medical"></i> HMO </li>
              <li class="Sidebar_Focus SBFocus7 " onclick="BTN_Room()"> <i class="fa-solid fa-door-closed"></i> Room </li>
              <li class="Sidebar_Focus SBFocus8 " onclick="BTN_Specialization()"> <i class="fa-solid fa-stethoscope"></i> Specialization </li>
              <li class="Sidebar_Focus SBFocus9 " onclick="BTN_SubSpecialization()"> <i class="fa-solid fa-stethoscope"></i> Sub-Specialization </li>
              <li class="Sidebar_Focus SBFocus3 " onclick="BTNAccounts()"> <i class="fa-solid fa-user-tie"></i> Accounts</li>
              <li class="Sidebar_Focus SBFocus4 " onclick="BTNActivity()"> <i class="fa-regular fa-rectangle-list"></i> Activity Logs</li>
              <li class="Sidebar_Focus SBFocus5 " onclick="BTNArchive()"> <i class="fa-solid fa-file-zipper"></i> Archived Doctors</li>
            <?php } ?>

          </ul>
        </div>
        <div class="AdminSidebarDiv3">
          <div class="AdminSidebarDiv3_Flex">
            <div class="AdminDashboard-Profile-Box">
              <div class="AdminDashboard-Profile-Box-Circle">
                <img src="../Uploaded/Doctor1.png" alt="">
              </div>
              <h4 class="Text-Trans-Upper"><?php echo $AdminName; ?></h4>
            </div>
            <button class="Btn_1" onclick="LinkToLogout()"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
          </div>
        </div>
      </section>
    <!-- END -->

    <!-- ADMIN MAIN -->
    <section class="AdminMain">
      <!-- Dashboard -->
        <div class="AdminDashboard AdminMainDiv">
          <div class="AdminDashboard-Header">
            <div class="Flex">
              <h4>DASHBOARD</h4>
              <div class="">

              </div>
            </div>
            <div class="Pop-Container">
              <?php
              if (isset($_SESSION['message'])) {
                echo "
                        <div class='PopUp-Div'>
                          <lord-icon class='Lord-Icon'
                            src='https://cdn.lordicon.com/jnzhohhs.json'
                            trigger='loop'
                            colors='primary:#ffffff'
                            delay='2000'>
                          </lord-icon>
                          <h4 class='Text-Trans-Upper'>{$_SESSION['message']}</h4>
                        </div>
                      ";
                unset($_SESSION['message']);
              }
              ?>
            </div>
          </div>

          <div class="AdminDashboard-Container">
            <div class="AdminDashboard-Panel">
              <div class="AdminDashboard-Panel-Div AdminDashboard-Box1">

                <!-- COUNT -->
                <div class="Dashboard-Box-Ch Dashboard-Box1-Ch">
                  <div class="Dashboard-Box-Total">
                    <p>Total Doctors</p>
                    <h2 id="DashCount1"> <span id="DashCount-1"><i class="fa-solid fa-user-doctor"></i> <?php echo" $CountTotalDoctor"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total Active Doctors</p>
                    <h2 id="DashCount2"> <span id="DashCount-2"> <i class="fa-solid fa-user-large"></i> <?php echo" $CountTotalActiveDoctor"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total Inactive Doctors</p>
                    <h2 id="DashCount3"> <span id="DashCount-3"> <i class="fa-solid fa-user-large-slash"></i> <?php echo" $CountTotalInActiveDoctor"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total Admins</p>
                    <h2 id="DashCount4"> <span id="DashCount-4"> <i class="fa-solid fa-user-tie"></i> <?php echo" $CountTotalAdmin"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total Visiting Consultation</p>
                    <h2 id="DashCount5"> <span id="DashCount-5"> <i class="fa-solid fa-user-nurse"></i> <?php echo" $CountTotalVisitingConsultation"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total Regular Consultation</p>
                    <h2 id="DashCount6"> <span id="DashCount-6"> <i class="fa-solid fa-hospital-user"></i> <?php echo" $CountTotalRegularConsultation"?></span></h2>
                  </div>
                  <div class="Dashboard-Box-Total">
                    <p>Total HMOs</p>
                    <h2 id="DashCount7"> <span id="DashCount-7"> <i class="fa-solid fa-briefcase"></i> <?php echo" $CountTotalHMO"?></span></h2>
                  </div>
                </div>

                <!-- CHART -->
                <div class="Dashboard-Box-Ch Dashboard-Box2-Ch">
                  <div class="Dashboard-Box2-Header">
                    <h4>Chart</h4>
                  </div>
                  <div class="Dashboard-Box2-Chart">
                    <div class="">
                      <h4>TOP 5 Specialization</h4>
                      <?php  
                        $DoctorSpecs = "SELECT 
                          specialization.specialization_id, 
                          specialization.specialization_name, 
                          COUNT(doctor_specialization.specialization_id_2) AS specs_count
                        FROM 
                          specialization
                        INNER JOIN 
                          doctor_specialization ON specialization.specialization_id = doctor_specialization.specialization_id_2
                        GROUP BY 
                          specialization.specialization_id
                        ORDER BY 
                          specs_count DESC
                        LIMIT 5
                       ";

                        $DoctorSpecs = mysqli_query($connMysqli, $DoctorSpecs);
                        $Id = 1;
                        while($row = mysqli_fetch_assoc($DoctorSpecs)) {
                          echo "
                            <input type='hidden' id='chartInputSpecs-IDs".$Id."' value='" . $row['specs_count'] . "'>
                            <input type='hidden' id='chartInputSpecs-Names".$Id."' value='" . $row['specialization_name'] . "'>
                          ";
                          $Id++;
                        }
                      ?>
                      <div id="DIV">
                        <div id="chart"></div>
                      </div>
                    </div>


                    <div class="">
                      <h4>TOP 5 HMO</h4>
                        <!-- <input type="hidden" id="chartInput" value=""> -->
                        <?php  
                          $DoctorHMO = "SELECT 
                            hmo.hmo_id, 
                            hmo.hmo_name, 
                            COUNT(doctor_hmo.hmo_id_2) AS doctor_count
                            FROM 
                              hmo
                            INNER JOIN 
                              doctor_hmo ON hmo.hmo_id = doctor_hmo.hmo_id_2
                            GROUP BY 
                              hmo.hmo_id
                            ORDER BY 
                              doctor_count DESC
                            LIMIT 5
                          ";

                          $DoctorHMO = mysqli_query($connMysqli, $DoctorHMO);
                          $Id = 1;
                          while($row = mysqli_fetch_assoc($DoctorHMO)) {
                            echo "
                            <input type='hidden' id='chartInputHMO-IDs".$Id."' value='" . $row['doctor_count'] . "'>
                            <input type='hidden' id='chartInputHMO-Names".$Id."' value='" . $row['hmo_name'] . "'>
                            ";

                            $Id++;
                          }
                        ?>
                      <div id="chart2"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="AdminDashboard-Panel-Div AdminDashboard-Box2">
                <div class="Dashboard-Table Dashboard-Table1">
                  <div class="Dashboard-Table-Header">
                    <h4>HMOs</h4>
                    <p>See More <i class="fa-solid fa-angle-right"></i></p>
                  </div>
                  <table>
                    <?php  
                      $DoctorHMO = "SELECT 
                        hmo.hmo_id, 
                        hmo.hmo_name, 
                        COUNT(doctor_hmo.hmo_id_2) AS doctor_count
                        FROM 
                          hmo
                        INNER JOIN 
                          doctor_hmo ON hmo.hmo_id = doctor_hmo.hmo_id_2
                        GROUP BY 
                          hmo.hmo_id
                        ORDER BY 
                          doctor_count DESC
                        LIMIT 10
                      ";

                      $DoctorHMO = mysqli_query($connMysqli, $DoctorHMO);

                      while($row = mysqli_fetch_assoc($DoctorHMO)) {
                        echo "
                          <tr>
                            <td>" . $row['hmo_name'] . "</td>
                            <td>" . $row['doctor_count'] . "</td>
                          </tr>
                        ";
                      }
                    ?>
                  </table>
                </div>
                <div class="Dashboard-Table Dashboard-Table2">
                  <div class="Dashboard-Table-Header">
                    <h4>Specialization</h4>
                    <p>See More <i class="fa-solid fa-angle-right"></i></p>
                  </div>
                  <table>
                    <?php  
                    $DoctorSpecs = "SELECT 
                      specialization.specialization_id, 
                      specialization.specialization_name, 
                      COUNT(doctor_specialization.specialization_id_2) AS specs_count
                    FROM 
                      specialization
                    INNER JOIN 
                      doctor_specialization ON specialization.specialization_id = doctor_specialization.specialization_id_2
                    GROUP BY 
                      specialization.specialization_id
                    ORDER BY 
                      specs_count DESC
                    LIMIT 10
                  ";

                    $DoctorSpecs = mysqli_query($connMysqli, $DoctorSpecs);

                    while($row = mysqli_fetch_assoc($DoctorSpecs)) {
                      echo "
                        <tr>
                          <td>" . $row['specialization_name'] . "</td>
                          <td>" . $row['specs_count'] . "</td>
                        </tr>
                      ";
                    }
                    ?>
                  </table>
                </div>
                <div class="Dashboard-Table Dashboard-Table2">
                  <div class="Dashboard-Table-Header">
                    <h4>Sub Specialization</h4>
                    <p>See More <i class="fa-solid fa-angle-right"></i></p>
                  </div>
                  <table>
                  <?php  
                    $DoctorSubSpecs = "SELECT 
                      sub_specialization.sub_specialization_id, 
                      sub_specialization.sub_specialization_name, 
                      COUNT(doctor_sub_specialization.sub_specialization_id_2) AS sub_specs_count
                    FROM 
                      sub_specialization
                    INNER JOIN 
                      doctor_sub_specialization ON sub_specialization.sub_specialization_id = doctor_sub_specialization.sub_specialization_id_2
                    GROUP BY 
                      sub_specialization.sub_specialization_id
                    ORDER BY 
                      sub_specs_count DESC
                    LIMIT 10
                  ";

                    $DoctorSubSpecs = mysqli_query($connMysqli, $DoctorSubSpecs);

                    while($row = mysqli_fetch_assoc($DoctorSubSpecs)) {
                      echo "
                        <tr>
                          <td>" . $row['sub_specialization_name'] . "</td>
                          <td>" . $row['sub_specs_count'] . "</td>
                        </tr>
                      ";
                    }
                    ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Doctors -->
        <div class="DoctorsDiv AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Doctor</h4>
            </div>
            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddDoctor()"><i class="fa-solid fa-plus"></i> Add Doctor</button>
              <div class="InputText3">
                <input type="text" placeholder="Filter By Specialization">
                <i class="fa-solid fa-chevro
                n-down"></i>
              </div>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>Name</th>
                    <th>Specialization</th>
                    <th class="TCenter">Number of HMO/s</th>
                    <th class="TCenter">Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="tbody-doctor">
                  <?php
                  $FetchDoctor = "SELECT DISTINCT * FROM doctor WHERE doctor_archive_status = 'VISIBLE' AND doctor_status = 'ACTIVE' ORDER BY doctor_id DESC";
                  $FetchDoctor = mysqli_query($connMysqli, $FetchDoctor);
                  while ($row = mysqli_fetch_assoc($FetchDoctor)) {
                    $Status = $row['doctor_status'];
                    $StatusColor = ($Status == 'ACTIVE') ? '#326932' : '#FF0000';

                    $docId = $row['doctor_account_id'];
                    $CountDoctorHMO = mysqli_query($connMysqli, "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$docId'");
                    $CountDoctorHMO = mysqli_num_rows($CountDoctorHMO);
                    echo "
                      <tr class='tr-doctor'>
                        <td class='capitalize'>" . $row['doctor_lastname'] . ", " . $row['doctor_firstname'] . " " . substr($row['doctor_middlename'], 0, 1) . ".</td>
                        <td class='TCenter'>
                          ";
                            $FetchDoctorSpecs = "SELECT DISTINCT * FROM doctor_specialization WHERE specialization_doctor_id = '$docId'";
                            $FetchDoctorSpecs = mysqli_query($connMysqli, $FetchDoctorSpecs);
                            while ($row2 = mysqli_fetch_assoc($FetchDoctorSpecs)) {
                              echo $row2['doctor_specialization_name'];
                            }
                           echo "
                        </td>
                        <td class='TCenter'>$CountDoctorHMO</td>
                        <td class='TCenter' style='color: ". $StatusColor ."; font-weight: bold;'>". $Status ." </td>
                        <td><div class='td-div'><button class='Btn_1' onclick='ViewDoctor(`View`,`".$row['doctor_account_id']."`)'><i class='fa-regular fa-eye'></i>View</button></div></td>
                      </tr>
                    ";
                  }; ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Accounts -->
        <div class="AccountsDiv AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Admin Accounts</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddAdmin()"><i class="fa-solid fa-plus"></i> Add Admin</button>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>Username</th>
                    <th>Access Level</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="account-tbody">
                  <?php
                  $FetchAdmin = "SELECT * FROM admin_accounts";
                  $FetchAdmin = mysqli_query($connMysqli, $FetchAdmin);
                  while ($row = mysqli_fetch_assoc($FetchAdmin)) {

                    // Determine the status and set color accordingly
                    $AdminStatus = $row['admin_status'];
                    $StatusColor = ($AdminStatus == 'Active') ? '#326932' : '#FF0000';
                    echo "
                        <tr class='tr-center account-tr'>
                          <td>" . $row['admin_username'] . "</td>
                          <td class='td-center'> " . $row['account_access'] . " </td>
                          <td class='td-center'><span style='color: $StatusColor; font-weight: bold; text-transform: uppercase;'>" . $AdminStatus . "</span></td>
                          <td><div class='td-div'><button class='Btn_1' onclick='View_Admin(" . $row['admin_id'] . ")'><i class='fa-regular fa-eye'></i> View</button></div></td>
                        </tr>
                      ";
                  }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Activity Logs -->
        <div class="ActivityLogs AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Activity Logs</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <!-- <button class="Btn_1" onclick="AddAdmin()"><i class="fa-solid fa-plus"></i> Add Admin</button> -->
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table class="tableActivityLogs">
                <thead>
                  <tr class="Tr-Header">
                    <th>Date/Time</th>
                    <th>Event By</th>
                    <th>Event Type</th>
                    <th>Event Details</th>
                    <!-- <th>Event Location</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="tbodyActivityLogs">
                  <?php
                  $FetchActivityLogs = "SELECT * FROM admin_activity_logs
                  INNER JOIN admin_accounts ON admin_activity_logs.activity_logs_admin_id = admin_accounts.admin_id
                  ORDER BY admin_activity_logs_id DESC;
                  ";
                  $FetchActivityLogs = mysqli_query($connMysqli, $FetchActivityLogs);
                  while ($row = mysqli_fetch_assoc($FetchActivityLogs)) {
                    $timestamp = strtotime($row['time_stamp']);
                    $time_stamp = date('M-d-Y h:i:s A', $timestamp);


                    echo "
                        <tr class='tr-ActivityLogs'>
                          <td>".$time_stamp."</td>
                          <td>".$row['admin_username']."</td>
                          <td>".$row['event_type']."</td>
                          <td>".$row['edit_details']."</td>
                          <!-- <td>".$row['admin_username']."</td> -->
                          <td><button class='Btn_1' onclick='View_ActivityLogs(`".$row['admin_activity_logs_id']."`)' <i class='fa-regular fa-eye'></i> View</button></td>
                        </tr>
                      ";
                  }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Archived Doctors -->
        <div class="ArchivesDiv AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Archived Doctors</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="tbody-archived">
                  <?php
                  $FetchDoctor = "SELECT DISTINCT * FROM doctor WHERE doctor_archive_status = 'VISIBLE' AND doctor_status = 'INACTIVE' ORDER BY doctor_id DESC";
                  $FetchDoctor = mysqli_query($connMysqli, $FetchDoctor);
                  while ($row = mysqli_fetch_assoc($FetchDoctor)) {
                    $Status = $row['doctor_status'];
                    $StatusColor = ($AdminStatus == 'ACTIVE') ? '#326932' : '#FF0000';

                    echo "
                      <tr class='tr-archived'>
                        <td class='TCenter'>".$row['doctor_account_id']." </td>
                        <td class='capitalize'>" . $row['doctor_lastname'] . ", " . $row['doctor_firstname'] . " " . substr($row['doctor_middlename'], 0, 1) . ".</td>
                        <td class='TCenter' style='color:". $StatusColor ."; font-weight: bold; '>". $Status ." </td>
                        <td >
                          <div class='td-div'>
                            <button class='Btn_1' onclick='ViewDoctor(`ArchivedView`,`".$row['doctor_account_id']."`)'><i class='fa-regular fa-eye'></i>View</button>
                            <button class='Btn_2 green' onclick='PromptDoctor(`RestoreDoctor`,`".$row['doctor_account_id']."`)'><i class='fa-solid fa-trash-arrow-up'></i>Activate</button>
                            <button class='Btn_2' onclick='PromptDoctor(`RemoveDoctor`,`".$row['doctor_account_id']."`)'><i class='fa-solid fa-trash-arrow-up'></i>Delete</button>
                          </div>
                        </td>
                      </tr>
                    ";
                  }; ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- HMO -->
        <div class="HMO_Div AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Manage HMO</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddHMO()"><i class="fa-solid fa-plus"></i> Add HMO</button>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>ID</th>
                    <th>HMO Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="tbody-archived">
                  <?php
                  $FetchHMO = "SELECT * from hmo";
                  $FetchHMO = mysqli_query($connMysqli, $FetchHMO);
                  while ($row = mysqli_fetch_assoc($FetchHMO)) {
                    echo "
                      <tr class='tr-archived'>
                        <td class='TCenter'>".$row['hmo_id']." </td>
                        <td class='TCenter'>" . $row['hmo_name'] . " </td>
                        <td> 
                            <div class='td-div'>
                            <button class='Btn_1' onclick='EditHMO(".$row['hmo_id'].")'><i class='fa-solid fa-pen-to-square'></i>Edit</button>
                            <!-- <button class='Btn_2' onclick=''><i class='fa-solid fa-trash-arrow-up'></i>Set Inactive</button> -->
                          </div>
                        </td>
                      </tr>
                    ";
                  }; ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Room -->
       <div class="Room_Div AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Manage Room/s</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddRoom()"><i class="fa-solid fa-plus"></i> Add Room</button>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>ID</th>
                    <th>Room Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="tbody-archived">
                  <?php
                  $FetchRoom = "SELECT * from room";
                  $FetchRoom = mysqli_query($connMysqli, $FetchRoom);
                  while ($row = mysqli_fetch_assoc($FetchRoom)) {
                    echo "
                      <tr class='tr-archived'>
                        <td class='TCenter'>".$row['room_id']." </td>
                        <td class='TCenter'>" . $row['room_floor_name'] . " </td>
                        <td> 
                            <div class='td-div'>
                            <button class='Btn_1' onclick='EditRoom(".$row['room_id'].")'><i class='fa-solid fa-pen-to-square'></i>Edit</button>
                            <!-- <button class='Btn_2' onclick=''><i class='fa-solid fa-trash-arrow-up'></i>Set Inactive</button> -->
                          </div>
                        </td>
                      </tr>
                    ";
                  }; ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Specialization -->
       <div class="Specialization_Div AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Manage Specialization/s</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddSpecialization()"><i class="fa-solid fa-plus"></i> Add Specialization</button>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>ID</th>
                    <th>Specialization Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="tbody-archived">
                  <?php
                  $FetchSpecialization = "SELECT * from specialization";
                  $FetchSpecialization = mysqli_query($connMysqli, $FetchSpecialization);
                  while ($row = mysqli_fetch_assoc($FetchSpecialization)) {
                    echo "
                      <tr class='tr-archived'>
                        <td class='TCenter'>".$row['specialization_id']." </td>
                        <td class='TCenter'>" . $row['specialization_name'] . " </td>
                        <td> 
                            <div class='td-div'>
                            <button class='Btn_1' onclick='EditSpecialization(".$row['specialization_id'].")'> <i class='fa-solid fa-pen-to-square'></i> Edit</button>
                          </div>
                        </td>
                      </tr>
                    ";
                  }; ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      <!-- END -->

      <!-- Sub-specialization -->
       <div class="SubSpecialization_Div AdminMainDiv">
          <div class="MainDiv-Header">
            <div class="">
              <h4>Manage Sub-Specialization/s</h4>
            </div>

            <div class="MainDiv-Header-Right">
              <button class="Btn_1" onclick="AddSubSpecialization()"><i class="fa-solid fa-plus"></i> Add Sub-specialization</button>
              <div class="InputText3">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
            </div>
          </div>
          <div class="MainDiv-Main DoctorsDiv-Main">
            <div class="Table-Div">
              <table>
                <thead>
                  <tr class="Tr-Header">
                    <th>ID</th>
                    <th>Sub-specialization Name</th>
                    <th>Specialization Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="tbody-archived">
                  <?php
                  $FetchSubSpecialization = "SELECT * from sub_specialization
                  INNER JOIN specialization ON sub_specialization.sub_specs_id = specialization.specialization_id";
                  $FetchSubSpecialization = mysqli_query($connMysqli, $FetchSubSpecialization);
                  while ($row = mysqli_fetch_assoc($FetchSubSpecialization)) {
                    echo "
                      <tr class='tr-archived'>
                        <td class='TCenter'>".$row['sub_specialization_id']." </td>
                        <td class='TCenter'>" . $row['sub_specialization_name'] . " </td>
                        <td class='TCenter'>" . $row['specialization_name'] . " </td>
                        <td> 
                            <div class='td-div'>
                            <button class='Btn_1' onclick='EditSubSpecialization(".$row['sub_specialization_id'].")'><i class='fa-solid fa-pen-to-square'></i>Edit</button>
                          </div>
                        </td>
                      </tr>
                    ";
                  }; ?>

                </tbody>

              </table>
            </div>
          </div>
        </div> 
      <!-- END --> 
    </section>
    <!-- END -->


    <!-- Modal Sidebar -->
      <section class="Modal-Sidebar">
        <div class="Modal-Container">
          <div class="Modal-Sidebar-Exit" onclick="ModalSidebarExit()"><i class="fa-solid fa-xmark"></i></div>
          <div class="Modal-Sidebar-Container">
            <!-- Add Doctor -->
              <div class="Modal-DivDoctor Modal-AddDoctor D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-user-plus"></i>
                  <h4>Add Doctor</h4>
                </div>
                <div class="Modal-Sidebar-Main">
                  <div class="AddDoctorDivContainer-Form"> 
                    <h4>Doctor Information</h4>
                    <span id="AddNewDoctorMessage"></span> 
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">First Name:</i>
                      <input type="text" placeholder="First Name" class="CT1" id="DoctorsFirstName" required>
                    </div>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Middle Name:</i>
                      <input type="text" placeholder="Middle Name" class="CT1" id="DoctorsMiddleName">
                    </div>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Last Name:</i>
                      <input type="text" placeholder="Last Name" class="CT1" id="DoctorsLastName">
                    </div>
                    <div class="InputFieldForm" required>
                      <i class="InputFieldForm-i">Gender:</i>
                      <select name="" id="DoctorGender" class="CT1" required>
                        <option value="" selected disabled>-</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <br>
                    <h4>Category</h4>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Category:</i>
                      <select name="" id="DoctorCategory" class="CT1">
                        <option value="" selected disabled>-</option>
                        <option value="Regular Consultant">Regular Consultant</option>
                        <option value="Waiting Consultant">Waiting Consultant</option>
                      </select>
                    </div>
                    <br>

                    <h4>Specialization</h4>
                    <div class='InputFieldForm'>
                      <div class='InputFieldFormChild1'>
                        <i class='InputFieldForm-i'>Specialization:</i>
                        <button class='Btn_1' onclick="AddItems('Specs')">Add Specialization</button>
                      </div>
                      <div class='searchContainer-Parent'>
                        <div class='inputFlex'>
                          <input type='text' onkeyup='editSearch(`Insert`,1)' id='editSearch1' class="CT1" placeholder='Search Specialization'>
                          <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                        </div>
                        
                        <div class='hiddenContainer'>
                          <ul id='EditDropdown1'>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'></i>
                      <div class='InputFieldForm-i-div'>
                        <div class='hiddenInformationField' id='hiddenInformationFieldIDSpecs'>
                          <!-- Function -->
                        </div>
                      </div>
                    </div>


                    <h4>Sub Specialization</h4>
                    <div class='InputFieldForm'>
                      <div class='InputFieldFormChild1'>
                        <i class='InputFieldForm-i'>Sub Specialization:</i>
                        <button class='Btn_1' onclick="AddItems('SubSpecs')">Add Sub Specialization</button>
                      </div>
                      <div class='searchContainer-Parent'>
                        <div class='inputFlex'>
                          <input type='text' onkeyup='editSearch(`Insert`,2)' id='editSearch2' class="CT1" placeholder='Search Sub Specialization'>
                          <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                        </div>
                        
                        <div class='hiddenContainer'>
                          <ul id='EditDropdown2'>
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
                        </div>
                      </div>
                    </div>

                    <br>
                    <hr>
                    <br>
                    <h4>Schedule</h4>
                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'>Schedule:</i>
                      <div class='InputFieldForm-div'>
                        <div class="InputFieldFormSchedule">
                          <span id="warningSchedule"></span>
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
                            <input type='time' id='pick-timeIn' name='pick-time'>
                          </div>
                          <div class='InputFieldForm-schedule'>
                            <p>Time End</p>
                            <input type='time' id='pick-timeOut' name='pick-time'>
                          </div>
                          <div class='InputFieldForm-schedule'>
                            <button class='Btn_1' onclick="AddSchedule('FromInsert')">Add</button>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'></i>
                      <div class='InformationField InformationFieldAddSchedule' id="informationFieldAddSchedule">
                        <!-- Function -->
                      </div>
                    </div>

                    <h4>Room</h4>
                    <div class='InputFieldForm'>
                      <div class='InputFieldFormChild1'>
                        <span id="warningRoom"></span>
                        <i class='InputFieldForm-i'>Room:</i>
                        <button class='Btn_1' onclick="AddItems('Room')">Add Room</button>
                      </div>
                      <div class='searchContainer-Parent'>
                        <div class='inputFlex'>
                          <input type='text' onkeyup='editSearch(`Insert`,3)' id='editSearch3' class="CT1" placeholder='Search Room'>
                          <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                        </div>
                        
                        <div class='hiddenContainer'>
                          <ul id='EditDropdown3'>
                            <!-- Function -->
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'></i>
                      <div class='InputFieldForm-i-div'>
                        <div class='hiddenInformationField' id='hiddenInformationFieldIDRoom'>
                          <!-- Function -->
                        </div>
                      </div>
                    </div>

                    <br>
                    <h4>Teleconsultaion</h4>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Teleconsultaion:</i>
                      <input type="text" id="DoctorsTeleConsult" placeholder="Teleconsultaion" class="CT1">
                    </div>
                    <br>

                    <br>
                    <h4>HMO Accreditation</h4>
                    <div class='InputFieldForm'>
                      <div class='InputFieldFormChild1'>
                        <i class='InputFieldForm-i'>HMO Accreditation:</i>
                        <button class='Btn_1' onclick="AddItems('HMO')">Add HMO</button>
                      </div>
                      <div class='searchContainer-Parent'>
                        <div class='inputFlex'>
                          <input type='text' onkeyup='editSearch(`Insert`,4)' id='editSearch4' class="CT1" placeholder='Search HMO'>
                          <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                        </div>
                        
                        <div class='hiddenContainer'>
                          <ul id='EditDropdown4'>
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
                        </div>
                      </div>
                    </div>

                    <br>
                    <hr>
                    <br>
                    <h4>Remarks</h4>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Remarks:</i>
                      <textarea name="" id="DoctorsRemarks" class="DoctorRemarks" placeholder="Input Notes"></textarea>
                    </div>
                    <br>

                    <br>
                    <hr>
                    <br>
                    <h4>Secretary</h4>
                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'>Secretary:</i>
                      <div class='InputFieldForm-div'>
                        <div class=''>
                          <p>Secretary Name</p>
                          <input type="text" id="DoctorsSecretaryName" placeholder="Ex. Maria Angelica Cruz" class="CT1">
                        </div>
                        <div class="">
                          <p>Primary Number </p>
                          <div class='InputFieldForm-divFlexColumn'>
                            <input type="number" id="SecretaryMobile1" placeholder="Required">
                            <select id='selectNetwork1' name='selectNetwork1'>
                              <option value='-' selected disabled>Network</option>
                              <option value='Globe'>Globe</option>
                              <option value='Smart'>Smart</option>
                              <option value='DITO'>DITO</option>
                              <option value='Sun'>Sun</option>
                              <option value='Cherry Prepaid'>Cherry Prepaid</option>
                              <option value='GOMO'>GOMO</option>
                            </select>
                          </div>
                        </div>
                        <div class="">
                          <p>Secondary Number </p>
                          <div class='InputFieldForm-divFlexColumn'>
                            <input type="number" id="SecretaryMobile2" placeholder="Optional">
                            <select id='selectNetwork2' name='selectNetwork2'>
                              <option value='-' selected disabled>Network</option>
                              <option value='Globe'>Globe</option>
                              <option value='Smart'>Smart</option>
                              <option value='DITO'>DITO</option>
                              <option value='Sun'>Sun</option>
                              <option value='Cherry Prepaid'>Cherry Prepaid</option>
                              <option value='GOMO'>GOMO</option>
                            </select>
                          </div>
                        </div>
                        <button class="Btn_1" onclick="AddSecretary()">Add Secretary</button>
                      </div>
                    </div>

                    <div class='InputFieldForm'>
                      <i class='InputFieldForm-i'></i>
                      <div class='InformationField InformationFieldAddSecretary'>
                        <!-- Function -->
                      </div>
                    </div>

                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewDoctor()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div>
            <!-- END -->

            <!-- View Doctor -->
              <div class="Modal-DivDoctor Modal-ViewDoctor D1">
                <!-- Function View Doctor -->
              </div>
            <!-- END -->

            <!-- Edit Doctor -->
              <div class="Modal-DivDoctor Modal-EditDoctor D1">
                <!-- Function Edit Doctor -->
              </div>
            <!-- END -->

            <!-- Add Admin -->
              <div class="Modal-DivDoctor Modal-AddAdmin D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-user-plus"></i>
                  <h4>Add Admin Account</h4>
                </div>
                <div class="Modal-Sidebar-Main Modal-Not-Capitalize">
                  <div class="AddDoctorDivContainer-Form">
                    <!-- <h4>Username</h4> -->
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Username</i>
                      <input type="text" placeholder="Username" id="AccessUsername">
                    </div>
                    <div class="InputFieldForm">
                      <i class="InputFieldForm-i">Access</i>
                      <select name="" id="AccessType">
                        <option value="" selected disabled>-</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewAccess()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div>
            <!-- End -->

            <!-- View Admin -->
              <div class="Modal-DivDoctor Modal-ViewAdmin D1">
                <!-- Function -->
              </div>
            <!-- End -->

            <!-- View Activity Logs --> 
              <div class="Modal-DivDoctor Modal-ViewActivityLogs D1">
                <!-- Function --> 
              </div>
            <!-- End --> 

            <!-- Add HMO --> 
             <div class="Modal-DivDoctor Modal-AddHMO D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-notes-medical"></i>
                  <h4>Add HMO</h4>
                </div>
                <div class="Modal-Sidebar-Main Modal-Not-Capitalize">
                  <div class="AddDoctorDivContainer-Form">
                    <!-- <h4>Username</h4> -->
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>HMO Name</i>
                      <input type="text" placeholder="HMO Name" id="HMOName">
                    </div>
                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewHMO()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div>
            <!-- END --> 

            <!-- Edit HMO --> 
              <div class="Modal-DivDoctor Modal-EditHMO D1">
                  <!-- Function Edit HMO -->
              </div>
            <!-- END --> 

            <!-- Add Room -->
             <div class="Modal-DivDoctor Modal-Room D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-notes-medical"></i>
                  <h4>Add Room</h4>
                </div>
                <div class="Modal-Sidebar-Main Modal-Not-Capitalize">
                  <div class="AddDoctorDivContainer-Form">
                    <!-- <h4>Username</h4> -->
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Floor Level</i>
                      <input type="text" placeholder="(ex. 1st Floor)" id="FloorLevel">
                    </div>
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Room Number</i>
                      <input type="number" placeholder="(ex. 1311)" id="RoomNumber">
                    </div>
                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewRoom()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div>
            <!-- END --> 

            <!-- Edit Room -->
            <div class="Modal-DivDoctor Modal-EditRoom D1">
                  <!-- Function Edit Room -->
            </div>
            <!-- END -->

            <!-- Add Specialization -->
             <div class="Modal-DivDoctor Modal-Specialization D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-notes-medical"></i>
                  <h4>Add Specialization</h4>
                </div>
                <div class="Modal-Sidebar-Main Modal-Not-Capitalize">
                  <div class="AddDoctorDivContainer-Form">
                    <!-- <h4>Username</h4> -->
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Specialization</i>
                      <input type="text" placeholder="(ex. Internal Medicine)" id="Specialization_ToBeAdd">
                    </div>
                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewSpecialization()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div> 
            <!-- END --> 
            
            <!-- Edit Specialization -->
              <div class="Modal-DivDoctor Modal-EditSpecialization D1">
                    <!-- Function Edit Specialization -->
              </div>
            <!-- END -->

            <!-- Add Sub-specialization --> 
            <div class="Modal-DivDoctor Modal-SubSpecialization D1">
                <div class="Modal-Sidebar-Top">
                  <i class="fa-solid fa-notes-medical"></i>
                  <h4>Add Sub-specialization</h4>
                </div>
                <div class="Modal-Sidebar-Main Modal-Not-Capitalize">
                  <div class="AddDoctorDivContainer-Form">
                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Sub-Specialization</i>
                      <input type="text" placeholder="(ex. Cardiology)" id="SubSpecializationToAdd">
                    </div>

                    <div class="InputFieldForm">
                      <i class='InputFieldForm-i'>Specialization</i>
                      <select name="SubSpecializationToDepend" id="SubSpecializationToDepend">
                        <?php 
                          $query = "SELECT * FROM specialization"; 
                          $query = mysqli_query($connMysqli, $query);

                          if($query->num_rows > 0) {
                            while($row = mysqli_fetch_assoc($query)) {
                              echo "<option value='" . htmlspecialchars($row['specialization_id']) . "'>" . htmlspecialchars($row['specialization_name']) . "</option>";
                            };
                          }  
                          
                          else {
                              echo "No data found";     
                          }
                        ?>
                      </select>
                    </div>
                    
                  </div>
                </div>
                <div class="Modal-Sidebar-Bottom">
                  <button class="Btn_1" onclick="AddNewSubSpecialization()">Add</button>
                  <button class="Btn_2" onclick="ModalSidebarExit()">Cancel</button>
                </div>
              </div>
            <!-- END --> 

            <!-- Edit Sub-specialization --> 
            <div class="Modal-DivDoctor Modal-EditSubSpecialization D1">
                <!-- Function Edit Sub-specialization -->
            </div>
            <!-- END -->

          </div>
        </div>
      </section>
    <!-- END -->


    <!-- Prompt Message -->
      <section class="Prompt-Message">
        <div class="Prompt-Message-Div">
          <!-- Add New Doctor -->
          <div class="Prompt-Div Prompt-AddNewDoctor">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add this doctor?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="InsertNewDoctor('InsertDoctor')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- Add Update Doctor -->
          <div class="Prompt-Div Prompt-UpdateDoctor Hide">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to update this doctor?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="UpdateDoctorDB('Edit', DoctorID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- Remove Doctor -->
          <div class="Prompt-Div Prompt-RemoveDoctor Hide">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to remove this doctor?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="UpdateDoctorDB('Delete', DoctorID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- MODAL DEACTIVATION -->
          <div class="Prompt-Div Prompt-DeactivateDoctor Hide">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to Deactivate this doctor?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="UpdateDoctorDB('Deactivate', DoctorID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- Restore Doctor -->
          <div class="Prompt-Div Prompt-RestoreDoctor Hide">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to activate this doctor?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="UpdateDoctorDB('Restore', DoctorID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- Add Access Account -->
          <div class="Prompt-Div Prompt-AccessAccount">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add an access account?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_AddNewAccess('Access')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>

          <!-- Reset Password - Admin -->
          <div class="Prompt-Div Prompt-ResetAdminAccount">
            <!-- FUNCTION -->
          </div>

          <!-- Add HMO - Prompt --> 
          <div class="Prompt-Div Prompt-AddHMO">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add this HMO?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_AddHMO('AddHMO')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END --> 

          <!-- Edit HMO - Prompt -->
          <div class="Prompt-Div Prompt-EditHMO">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to update this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_EditHMO(HMO_ID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END -->

          <!-- Add Room - Prompt -->
          <div class="Prompt-Div Prompt-AddRoom">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_AddRoom('AddHMO')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END --> 

          <!-- Edit Room - Prompt -->
          <div class="Prompt-Div Prompt-EditRoom">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to update this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_EditRoom(Room_ID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END --> 

          <!-- Add Specialization - Prompt --> 
          <div class="Prompt-Div Prompt-AddSpecialization">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_AddSpecialization('AddSpecialization')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END --> 

          

          <!-- Edit Specialization - Prompt --> 
          <div class="Prompt-Div Prompt-EditSpecialization">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to update this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_EditSpecialization(Specialization_ID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END --> 

          <!-- Add Sub-specialization - Prompt --> 
          <div class="Prompt-Div Prompt-AddSubSpecialization">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to add this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_AddSubSpecialization('AddSubSpecialization')">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END -->

          <!-- Edit Sub-specialization - Prompt --> 
          <div class="Prompt-Div Prompt-EditSubSpecialization">
            <div class="Prompt-Message-Top">
              <lord-icon src="https://cdn.lordicon.com/ygvjgdmk.json" trigger="loop" delay="1500" class="lord-icon"></lord-icon>
              <h4>Are you sure?</h4>
            </div>
            <div class="Prompt-Message-Center">
              <p class="P-Message">Are you sure you want to update this data?</p>
            </div>
            <div class="Prompt-Message-Bottom">
              <button class="Btn_1" onclick="Yes_EditSubSpecialization(Sub_Specialization_ID)">Yes</button>
              <button class="Btn_2" onclick="HidePromptMessage()">No</button>
            </div>
          </div>
          <!-- END -->

        </div>
      </section>
    <!-- END -->

    <!-- ADD ITEMS -->
      <div class="Add-Items-Container">
        <!-- Function -->
      </div>
    <!-- END -->


    <!-- POP UP -->
     <!-- Success Pop Up --> 
      <section class="PopUp-Message">
        <div class="PopUp-Container">
          <h4 id="Pop-Message"></h4>
          <lord-icon src="https://cdn.lordicon.com/lomfljuq.json" trigger="loop" delay="1500" class="lord-icon" colors="primary:#9acd32" style="width:60px;height:60px"> </lord-icon>
        </div>
      </section>
      <section class="PopUp-ErrorMessage">
        <div class="PopUp-ErrorContainer">
          <h4 id="Pop-ErrorMessage"></h4>
          <i class="fa-solid fa-circle-exclamation errorIcon" style="color: #f20006;"></i>
        </div>
      </section>
    <!-- END -->

  </div>
  <script>var UserID = '<?= $encrypted_user_id ?>';</script>
</body>
</html>