<?php
include '../Config/Configure.php';

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");
$Day = date('l');


// VIEW ALL DOCTORS
if(isset($_POST["DoctorID"])){
  global $connMysqli;
  $DoctorID = $_POST["DoctorID"];


  $DoctorDetails = "SELECT * FROM doctor WHERE doctor_account_id = '$DoctorID'";
  $DoctorDetails = mysqli_query($connMysqli,$DoctorDetails);

  while($row = mysqli_fetch_assoc($DoctorDetails)){
    $DID = $row['doctor_account_id'];
    $DSex1 = $row['doctor_sex'];
    if($DSex1 == "Male"){$DR_SexColor = "ModalContainerProfileBorder1";} else{$DR_SexColor = "ModalContainerProfileBorder2";}
    echo "
      <div class='HomeMain-ModalContainer'>
        <div class='ModalContainer1'>
          <div class='ModalContainerDiv1'>
            <div class='ModalContainerDiv1Flex'>
              <div class='ModalContainerDiv1Img ".$DR_SexColor." '><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
              <div class='ModalContainerDiv1Names'>
                <h1 class='Capitalize'>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
                ";
                $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID'";
                $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
                while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
                  <h4>".$row3['doctor_specialization_name']."</h4>
                ";};
                echo"
                <div class='TeleDiv'>

                    ";
                    $DoctorTelConsult1 = "SELECT * FROM doctor_teleconsult WHERE teleconsult_doctor_id = '$DID' AND teleconsult_link != ''";
                    $DoctorTelConsult1 = mysqli_query($connMysqli,$DoctorTelConsult1);
                    while($row9 = mysqli_fetch_assoc($DoctorTelConsult1)){echo "
                      <p class='TelecastSpanP'><i class='fa-solid fa-arrow-up-right-from-square'></i> <span class='TelecastSpan' onclick='TelecastDiv(`".$row9['teleconsult_link']."`)'>Click here for teleconsultaion</span></p>
                    ";};
                    echo"

                </div>
              </div>
            </div>
            <div class='ModalContainerDiv1Close' onclick='CloseDoctor()'>
              <i class='fa-solid fa-xmark'></i>
            </div>
          </div>
        </div>
        <div class='ModalContainer2 D1'>
          <div class='ModalContainer2Div1'>
            <div class='ModalContainer2DivTitle'>
              <p>Sub-specialization:</p>
            </div>
            <div class='ModalContainer2Div1List'>
              ";
              $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID'";
              $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
              while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
                <div class='SubsSpecList'>
                  <p>".$row4['doctor_sub_specialization_name']."</p>
                </div>
              ";};
              echo"
            </div>
          </div>
          <br>
          <div class='ModalContainer2Div2'>
            <div class='ModalContainer2DivTitle'>
              <p>Clinic Schedule:</p>
            </div>
            <div class='ScheduleDiv'>
              <ul>
                ";
                $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
                $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
                while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
                  <li><i>".$row2['doctor_schedule_day'].": </i> <p>".$row2['doctor_schedule_time']."</p></li>
                ";};
                  echo"
              </ul>
            </div>
          </div>
          <br>
          <div class='ModalContainer2Div3'>
            <div class='ModalContainer2Div3Div'>
              <div class='Div3DivLi'>
                <p>Clinic Secretary:</p>          
              </div>
              ";
              $DoctorSecretary1 = "SELECT * FROM doctor_secretary WHERE secretary_doctor_id = '$DID'";
              $DoctorSecretary1 = mysqli_query($connMysqli,$DoctorSecretary1);
              while($row7 = mysqli_fetch_assoc($DoctorSecretary1)){
                
                $SecID= $row7['doctor_secretary_id'];
                echo "
                <div class='SecretaryDiv'>
                  <h4>".$row7['doctor_secretary_first_name']."</h4>
                  ";
                  $DoctorsSecNumber1 = "SELECT * FROM doctor_secretary WHERE doctor_secretary_id = '$SecID'";
                  $DoctorsSecNumber1 = mysqli_query($connMysqli,$DoctorsSecNumber1);
                  while($row8 = mysqli_fetch_assoc($DoctorsSecNumber1)){echo "
                    <p>".$row8['doctor_secretary_first_network']." - ".$row8['doctor_secretary_first_number']."</p>
                    <p>".$row8['doctor_secretary_second_network']." - ".$row8['doctor_secretary_second_number']."</p>
                  ";};
                    echo"

                </div>
              ";};
                echo"
            </div>
            <br>

            <div class='ModalContainer2Div3Div'>
              <div class='Div3DivLi'>
                <p>Room:</p>          
              </div>
              <div class='doctor_roomDiv'>

              ";
              $DoctorsRoom1 = "SELECT * FROM doctor_room WHERE room_doctor_id = '$DID'";
              $DoctorsRoom1 = mysqli_query($connMysqli,$DoctorsRoom1);
              while($row5 = mysqli_fetch_assoc($DoctorsRoom1)){echo "
                <div class='doctor_room'><h4>".$row5['doctor_room_number']."</h4></div>
              ";};
                echo"
              </div>
            </div>
          </div>
          <div class='ModalContainer2Div5'>
            <div class='ModalContainer2DivTitle'>
              <div class='ModalContainer3Div1Header'>
                <h4 class='TotalHMOH'>HMO Accreditation/s:</h4>


                ";
                $CountDoctorHMO = mysqli_query($connMysqli, "SELECT * FROM doctor_hmo WHERE  hmo_doctor_id = '$DID'");
                $CountDoctorHMO = mysqli_num_rows($CountDoctorHMO);
                  echo"
                <h4 class='TotalHMOH'>Total HMO/s Accredited: $CountDoctorHMO</h4>
                
                <h4 class='TotalHMOS'>$CountDoctorHMO HMO Accreditation/s:</h4>
              </div>
              <div class='HMOAccreditationDiv'>
                ";
                $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID'";
                $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
                while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
                  <h4><i class='fa-solid fa-circle-check'></i> ".$row5['doctor_hmo_name']."</h4>
                ";};
                  echo"

              </div>
            </div>
          </div>
        </div>
        <div class='ModalContainer3'>
          <div class='ModalContainer3Div'>
            <div class='ModalContainer3Div1'>
              
              <h4><?php include './Assets/SVG/RemarksIcon.svg'?> Notes:</h4> 
              <div class='ModalContainer3Div1RemarksDiv'>
                ";
                $DoctorsNotes1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
                $DoctorsNotes1 = mysqli_query($connMysqli,$DoctorsNotes1);
                while($row6 = mysqli_fetch_assoc($DoctorsNotes1)){echo "
          
                  <p>".$row6['doctor_notes_details']." </p>
                ";};
                  echo"
              </div>
            </div>
          </div>
        </div>
      </div>
    ";
  }
}

// SEARCH DOCTOR
if(isset($_POST["SearchDoc"])){
  global $connMysqli;
  $DocID = $_POST["SearchDocID"];
  if($DocID == ""){
    $SearchResult = "SELECT * FROM doctor";
    $SearchResult = mysqli_query($connMysqli, $SearchResult);
  }
  else{  
    // $SearchResult = "SELECT * FROM doctor WHERE doctor_name LIKE '%$DocID%' ";
    $SearchResult = "SELECT * FROM doctor WHERE doctor_firstname LIKE '%$DocID%' OR doctor_middlename LIKE '%$DocID%' OR doctor_lastname LIKE '%$DocID%'  ";
    $SearchResult = mysqli_query($connMysqli, $SearchResult);
  }

  if($SearchResult->num_rows > 0){
    while($row = mysqli_fetch_assoc($SearchResult)){
      $DID = $row['doctor_account_id'];
      $DSex = $row['doctor_sex'];
      if($DSex == "Male"){
        $DR_SexColor = "ImgBColor1";
      } else{
        $DR_SexColor = "ImgBColor2";
      }
      echo "
      <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
        <div class='Main_Div1-Box1'>
        <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
          <div class=''>
            <h1 class='Capitalize'>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
            ";
            $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
            $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
            while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
              <h4>".$row3['doctor_specialization_name']."</h4>
            ";};
            echo"
            ";
            $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
            $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
            while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
              <p>".$row4['doctor_sub_specialization_name']."</p>
            ";};
            echo"
          </div>
        </div>
        <div class='Main_Div1-Box2'>
          <div class='Main_Div1-Box2Flex1'>
            <div class='Main_Div1-Box2Flex1Div'> 
              <h4>Clinic Schedule</h4>
              <ul class='Main_Div1-Box2Flex1Schedule'>
  
              ";
              $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
              $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
              while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
                <li><i>".$row2['doctor_schedule_day']."</i> <p>".$row2['doctor_schedule_time']."</p></li>
              ";};
                echo"
  
              </ul>
            </div>
            <br>
            <div class='Box2Flex1Div1'>
              <h4>HMO Accreditation/s</h4>
              <div class='Flex'>
  
              ";
              $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID' LIMIT 3";
              $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
              while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
                <div class='Box2Flex1Border'><p>".$row5['doctor_hmo_name']."</p></div>
              ";};
                echo"
      
              </div>
            </div>
            <br>
            <div class='Box2Flex1Div2'>
              <h4>Notes</h4>
              ";
              $DoctorsRemarks1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
              $DoctorsRemarks1 = mysqli_query($connMysqli,$DoctorsRemarks1);
              while($row6 = mysqli_fetch_assoc($DoctorsRemarks1)){echo "
                <div class='Box2Flex1Border'><p>".$row6['doctor_notes_details']."</p></div>
              ";};
                echo"
            </div>
          </div>
          <div class='Main_Div1-Box2Flex2'>
            <button class='Btn_2'>More Details <i class='fa-solid fa-arrow-right'></i></button>
          </div>
        </div>
      </div>
    ";}

  }
  else{
    echo "<div class='NotFoundDiv'><h1>No results found for the specified doctor's name</h1></div>";
  }
}

// SEARCH SPECIALIZATION
if(isset($_POST["SearchDocSpecs"])){
  global $connMysqli;
  $SearchDocSpecs = $_POST["SearchDocSpecs"];

  $DoctorSpecialization = "SELECT * FROM specialization WHERE specialization_name LIKE '%$SearchDocSpecs%'";
  $DoctorSpecialization = mysqli_query($connMysqli,$DoctorSpecialization);

  if($DoctorSpecialization->num_rows > 0){
    while($row = mysqli_fetch_assoc($DoctorSpecialization)){echo "
      <li onclick='SelectSpecs(".$row['specialization_id'].")'><i class='fa-solid fa-circle-dot'></i> <p id='SpecsID_".$row['specialization_id']."'>".$row['specialization_name']."</p></li>
  ";}

  }else{
    echo "<p>Nothing found!</p>";
  }
}

// SEARCH SUB SPECIALIZATION
if(isset($_POST["SearchSubSpecs2"])){
  global $connMysqli;
  $SearchSubSpecs2 = $_POST["SearchSubSpecs2"];
  $InputSpecialization = $_POST["InputSpecialization"];
  $refSpecsID = $_POST["refSpecsID"];


  if($InputSpecialization == ""){
    $DoctorSubSpecialization2 = "SELECT * FROM sub_specialization WHERE sub_specialization_name LIKE '%$SearchSubSpecs2%'";
    $DoctorSubSpecialization2 = mysqli_query($connMysqli,$DoctorSubSpecialization2);
  }
  else{
    $DoctorSubSpecialization2 = "SELECT * FROM sub_specialization WHERE sub_specs_id = '$refSpecsID' AND sub_specialization_name LIKE '%$SearchSubSpecs2%'";
    $DoctorSubSpecialization2 = mysqli_query($connMysqli,$DoctorSubSpecialization2);
    // Prepare the SQL query
    // $sql = "SELECT * FROM sub_specialization WHERE sub_specs_id LIKE ? AND sub_specialization_name LIKE ?";
    // $stmt = $connMysqli->prepare($sql);
    // $searchDocSpecs2 = '%' . $SearchDocSpecs2 . '%'; // Add wildcards
    // $stmt->bind_param("ss", $searchDocSpecs2, $searchSubSpecs2);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // while ($row = $result->fetch_assoc()) {
    //     print_r($row);
    // }
    // $stmt->close();
  }



  if($DoctorSubSpecialization2->num_rows > 0){
    while($row = mysqli_fetch_assoc($DoctorSubSpecialization2)){echo "
      <li onclick='SelectSubSpecs(".$row['sub_specialization_id'].")'><i class='fa-solid fa-circle-dot'></i> <span id='SubsSpecsID_".$row['sub_specialization_id']."'>".$row['sub_specialization_name']."</span></li>
  ";}
  }else{
    echo "<p>Nothing found!</p>";
  }
}

// SEARCH HMO
if(isset($_POST["SearchHMO"])){
  global $connMysqli;
  $SearchHMO = $_POST["SearchHMO"];


  
  $DoctorSpecialization = "SELECT * FROM hmo WHERE hmo_name LIKE '%$SearchHMO%' ";
  $DoctorSpecialization = mysqli_query($connMysqli,$DoctorSpecialization);

  if($DoctorSpecialization->num_rows > 0){
    while($row = mysqli_fetch_assoc($DoctorSpecialization)){echo "
      <div class='ModalDivConPanelDiv2 HMO_ID_".$row['hmo_id']."' onclick='functionHMO( ".$row['hmo_id'].")'>
        <i class='fa-regular fa-square'></i> 
        <i>".$row['hmo_name']."</i> 
        <input type='checkbox' class='HMOOName ScheduleDay1' value='".$row['hmo_id']."'>      
        <input type='checkbox' class='HMOOName2 ScheduleDay1' value='".$row['hmo_name']."'>
      </div>
  ";}
  }else{
    echo "<p>Nothing found!</p>";
  }
}

// RESET FILTER
if(isset($_POST["Clear1"])){
  global $connMysqli;
  $SearchResult2 = "SELECT * FROM doctor";
  $SearchResult2 = mysqli_query($connMysqli, $SearchResult2);

  while($row = mysqli_fetch_assoc($SearchResult2)){
    $DID = $row['doctor_account_id'];
    $DSex = $row['doctor_sex'];
    if($DSex == "Male"){
      $DR_SexColor = "ImgBColor1";
    } else{
      $DR_SexColor = "ImgBColor2";
    }
    echo "
    <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
      <div class='Main_Div1-Box1'>
      <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
        <div class=''>
          <h1 class='Capitalize'>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
          ";
          $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
          $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
          while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
            <h4>".$row3['doctor_specialization_name']."</h4>
          ";};
          echo"
          ";
          $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
          $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
          while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
            <p>".$row4['doctor_sub_specialization_name']."</p>
          ";};
          echo"
        </div>
      </div>
      <div class='Main_Div1-Box2'>
        <div class='Main_Div1-Box2Flex1'>
          <div class='Main_Div1-Box2Flex1Div'> 
            <h4>Clinic Schedule</h4>
            <ul class='Main_Div1-Box2Flex1Schedule'>

            ";
            $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
            $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
            while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
              <li><i>".$row2['doctor_schedule_day']."</i> <p>".$row2['doctor_schedule_time']."</p></li>
            ";};
              echo"

            </ul>
          </div>
          <br>
          <div class='Box2Flex1Div1'>
            <h4>HMO Accreditation/s</h4>
            <div class='Flex'>

            ";
            $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID' LIMIT 3";
            $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
            while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
              <div class='Box2Flex1Border'><p>".$row5['doctor_hmo_name']."</p></div>
            ";};
              echo"
    
            </div>
          </div>
          <br>
          <div class='Box2Flex1Div2'>
            <h4>Notes</h4>
            ";
            $DoctorsRemarks1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
            $DoctorsRemarks1 = mysqli_query($connMysqli,$DoctorsRemarks1);
            while($row6 = mysqli_fetch_assoc($DoctorsRemarks1)){echo "
              <div class='Box2Flex1Border'><p>".$row6['doctor_notes_details']."</p></div>
            ";};
              echo"
          </div>
        </div>
        <div class='Main_Div1-Box2Flex2'>
          <button class='Btn_2'>More Details <i class='fa-solid fa-arrow-right'></i></button>
        </div>
      </div>
    </div>
  ";}
}

// SELECT SPECS ID
if(isset($_POST["SelectSpecsID"])){
  global $connMysqli;
  $SelectSpecsID = $_POST["SelectSpecsID"];
  // echo $SelectSpecsID;

  $DoctorSubSpecialization = "SELECT * FROM sub_specialization WHERE sub_specs_id = '$SelectSpecsID' ";
  $DoctorSubSpecialization = mysqli_query($connMysqli,$DoctorSubSpecialization);
  while($row = mysqli_fetch_assoc($DoctorSubSpecialization)){echo
    "
    <li onclick='SelectSubSpecs(".$row['sub_specialization_id'].")'><i class='fa-solid fa-circle-dot'></i> <span id='SubsSpecsID_".$row['sub_specialization_id']."'>".$row['sub_specialization_name']."</span></li>

  ";}
}

// FILTER DOCTOR / TODAY AND ALL
if(isset($_POST["BtnDocFill"])){
  global $connMysqli;

  if($_POST["BtnDocFill"] == "TodayDoctor"){

    $BtnFilter1 = "SELECT * FROM doctor_schedule WHERE doctor_schedule_day LIKE '$Day'";
    $BtnFilter1 = mysqli_query($connMysqli,$BtnFilter1);

    if($BtnFilter1->num_rows > 0){

      while($row = mysqli_fetch_assoc($BtnFilter1)){
        $BtnScheduleID = $row["schedule_doctor_id"];
    
        $SearchResult2 = "SELECT * FROM doctor WHERE doctor_account_id = '$BtnScheduleID'";
        $SearchResult2 = mysqli_query($connMysqli, $SearchResult2);
    
        while($row = mysqli_fetch_assoc($SearchResult2)){
          $DID = $row['doctor_account_id'];
          $DSex = $row['doctor_sex'];
          if($DSex == "Male"){
            $DR_SexColor = "ImgBColor1";
          } else{
            $DR_SexColor = "ImgBColor2";
          }
          echo "
          <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
            <div class='Main_Div1-Box1'>
            <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
              <div class=''>
                <h1 class='Capitalize'>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
                ";
                $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
                $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
                while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
                  <h4>".$row3['doctor_specialization_name']."</h4>
                ";};
                echo"
                ";
                $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
                $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
                while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
                  <p>".$row4['doctor_sub_specialization_name']."</p>
                ";};
                echo"
              </div>
            </div>
            <div class='Main_Div1-Box2'>
              <div class='Main_Div1-Box2Flex1'>
                <div class='Main_Div1-Box2Flex1Div'> 
                  <h4>Clinic Schedule</h4>
                  <ul class='Main_Div1-Box2Flex1Schedule'>
    
                  ";
                  $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
                  $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
                  while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
                    <li><i>".$row2['doctor_schedule_day']."</i> <p>".$row2['doctor_schedule_time']."</p></li>
                  ";};
                    echo"
    
                  </ul>
                </div>
                <br>
                <div class='Box2Flex1Div1'>
                  <h4>HMO Accreditation/s</h4>
                  <div class='Flex'>
    
                  ";
                  $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID' LIMIT 3";
                  $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
                  while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
                    <div class='Box2Flex1Border'><p>".$row5['doctor_hmo_name']."</p></div>
                  ";};
                    echo"
          
                  </div>
                </div>
                <br>
                <div class='Box2Flex1Div2'>
                  <h4>Notes</h4>
                  ";
                  $DoctorsRemarks1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
                  $DoctorsRemarks1 = mysqli_query($connMysqli,$DoctorsRemarks1);
                  while($row6 = mysqli_fetch_assoc($DoctorsRemarks1)){echo "
                    <div class='Box2Flex1Border'><p>".$row6['doctor_notes_details']."</p></div>
                  ";};
                    echo"
                </div>
              </div>
              <div class='Main_Div1-Box2Flex2'>
                <button class='Btn_2'>More Details <i class='fa-solid fa-arrow-right'></i></button>
              </div>
            </div>
          </div>
        ";}
      }

    }else{
      echo "<div class='NotFoundDiv'><h1>No Doctor/s available today</h1></div>";
    }
  }
  else{
    $SearchResult2 = "SELECT * FROM doctor";
    $SearchResult2 = mysqli_query($connMysqli, $SearchResult2);

    while($row = mysqli_fetch_assoc($SearchResult2)){
      $DID = $row['doctor_account_id'];
      $DSex = $row['doctor_sex'];
      if($DSex == "Male"){
        $DR_SexColor = "ImgBColor1";
      } else{
        $DR_SexColor = "ImgBColor2";
      }
      echo "
      <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
        <div class='Main_Div1-Box1'>
        <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
          <div class=''>
            <h1 class='Capitalize'>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
            ";
            $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
            $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
            while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
              <h4>".$row3['doctor_specialization_name']."</h4>
            ";};
            echo"
            ";
            $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
            $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
            while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
              <p>".$row4['doctor_sub_specialization_name']."</p>
            ";};
            echo"
          </div>
        </div>
        <div class='Main_Div1-Box2'>
          <div class='Main_Div1-Box2Flex1'>
            <div class='Main_Div1-Box2Flex1Div'> 
              <h4>Clinic Schedule</h4>
              <ul class='Main_Div1-Box2Flex1Schedule'>

              ";
              $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
              $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
              while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
                <li><i>".$row2['doctor_schedule_day']."</i> <p>".$row2['doctor_schedule_time']."</p></li>
              ";};
                echo"

              </ul>
            </div>
            <br>
            <div class='Box2Flex1Div1'>
              <h4>HMO Accreditation/s</h4>
              <div class='Flex'>

              ";
              $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID' LIMIT 3";
              $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
              while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
                <div class='Box2Flex1Border'><p>".$row5['doctor_hmo_name']."</p></div>
              ";};
                echo"
      
              </div>
            </div>
            <br>
            <div class='Box2Flex1Div2'>
              <h4>Notes</h4>
              ";
              $DoctorsRemarks1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
              $DoctorsRemarks1 = mysqli_query($connMysqli,$DoctorsRemarks1);
              while($row6 = mysqli_fetch_assoc($DoctorsRemarks1)){echo "
                <div class='Box2Flex1Border'><p>".$row6['doctor_notes_details']."</p></div>
              ";};
                echo"
            </div>
          </div>
          <div class='Main_Div1-Box2Flex2'>
            <button class='Btn_2'>More Details <i class='fa-solid fa-arrow-right'></i></button>
          </div>
        </div>
      </div>
    ";}
  }
}

// FILTER ALL DOCTOR
if(isset($_POST["Filter_All"])){
  global $connMysqli;
  $Text1Fill = $_POST["Text1Fill"]; 
  $Text2Fill = $_POST["Text2Fill"]; 
  $Text3Fill = $_POST["Text3Fill"];
  $Text4Fill = $_POST["Text4Fill"];
  $Text5Fill = $_POST["Text5Fill"];
  $Text6Fill = $_POST["Text6Fill"];

  $HMO = str_replace("-", ",", $Text4Fill);
  $Days = str_replace("-", ",", $Text6Fill);
  // $Array = array("Tuesday","Wednesday");
  // $days = implode("','", $Array);
  if($Text6Fill == ""){$A6 = "OR"; }
  else{$A6 = "AND";}

  if($Text4Fill == ""){$A4 = "OR"; }
  else{$A4 = "AND";}
  
  if($A6 == "OR"){$Result = "$A4 hmo_id_2 IN ('$HMO')$A6 doctor_schedule_day IN ('$Days')";}
  else{$Result = "$A6 doctor_schedule_day IN ('$Days')$A4 hmo_id_2 IN ('$HMO')";}

  if($A4 == "OR"){ $Result = " $A6 doctor_schedule_day IN ('$Days') $A4 hmo_id_2 IN ('$HMO')";}
  else{ $Result = " $A4 hmo_id_2 IN ('$HMO') $A6 doctor_schedule_day IN ('$Days')";}


  if($Text5Fill != ""){
    if($Text5Fill == "YES"){
      $TelResult1 = "INNER JOIN doctor_teleconsult ON doctor.doctor_account_id = doctor_teleconsult.teleconsult_doctor_id"; 
      $TelResult2 = "AND teleconsult_link IS NOT NULL AND teleconsult_link <> ''"; 
    }
    elseif($Text5Fill == "NO"){
      $TelResult1 = "INNER JOIN doctor_teleconsult ON doctor.doctor_account_id = doctor_teleconsult.teleconsult_doctor_id"; 
      $TelResult2 = "AND teleconsult_link IS NULL OR teleconsult_link = ''"; 
    }
  }
  else{
    $TelResult1 = ""; 
    $TelResult2 = ""; 
  }

  $SearchResult = "SELECT DISTINCT doctor.*FROM doctor
  INNER JOIN doctor_specialization ON doctor.doctor_account_id = doctor_specialization.specialization_doctor_id
  INNER JOIN doctor_sub_specialization ON doctor.doctor_account_id = doctor_sub_specialization.sub_specialization_doctor_id
  INNER JOIN doctor_schedule ON doctor.doctor_account_id = doctor_schedule.schedule_doctor_id
  INNER JOIN doctor_hmo ON doctor.doctor_account_id = doctor_hmo.hmo_doctor_id
  $TelResult1 
  WHERE 
        doctor_specialization_name LIKE '%$Text1Fill%'
        AND doctor_sub_specialization_name LIKE '%$Text2Fill%'
        AND doctor_sex LIKE '$Text3Fill%'
        $TelResult2
        $Result
        ";  
  $SearchResult5 = mysqli_query($connMysqli, $SearchResult);
  while($row = mysqli_fetch_assoc($SearchResult5)){
    $DID = $row['doctor_account_id'];
    $DSex = $row['doctor_sex'];
    if($DSex == "Male"){
      $DR_SexColor = "ImgBColor1";
    } else{
      $DR_SexColor = "ImgBColor2";
    } 
    echo "
    <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
      <div class='Main_Div1-Box1'>
      <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
        <div class=''>
          <h1 class='Capitalize'>Dr. ".$row['doctor_firstname']." ".$row['doctor_middlename']." ".$row['doctor_lastname']."</h1>
          ";
          $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
          $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
          while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
            <h4>".$row3['doctor_specialization_name']."</h4>
          ";};
          echo"
          ";
          $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
          $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
          while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
            <p>".$row4['doctor_sub_specialization_name']."</p>
          ";};
          echo"
        </div>
      </div>
      <div class='Main_Div1-Box2'>
        <div class='Main_Div1-Box2Flex1'>
          <div class='Main_Div1-Box2Flex1Div'> 
            <h4>Clinic Schedule</h4>
            <ul class='Main_Div1-Box2Flex1Schedule'>

            ";
            $DoctorsSchedule2 = "SELECT * FROM doctor_schedule WHERE schedule_doctor_id = '$DID'";
            $DoctorsSchedule2 = mysqli_query($connMysqli,$DoctorsSchedule2);
            while($row2 = mysqli_fetch_assoc($DoctorsSchedule2)){echo "
              <li><i>".$row2['doctor_schedule_day']."</i> <p>".$row2['doctor_schedule_time']."</p></li>
            ";};
              echo"

            </ul>
          </div>
          <br>
          <div class='Box2Flex1Div1'>
            <h4>HMO Accreditation/s</h4>
            <div class='Flex'>

            ";
            $DoctorsHMO1 = "SELECT * FROM doctor_hmo WHERE hmo_doctor_id = '$DID' LIMIT 3";
            $DoctorsHMO1 = mysqli_query($connMysqli,$DoctorsHMO1);
            while($row5 = mysqli_fetch_assoc($DoctorsHMO1)){echo "
              <div class='Box2Flex1Border'><p>".$row5['doctor_hmo_name']."</p></div>
            ";};
              echo"
    
            </div>
          </div>
          <br>
          <div class='Box2Flex1Div2'>
            <h4>Notes</h4>
            ";
            $DoctorsRemarks1 = "SELECT * FROM doctor_notes WHERE notes_doctor_id = '$DID'";
            $DoctorsRemarks1 = mysqli_query($connMysqli,$DoctorsRemarks1);
            while($row6 = mysqli_fetch_assoc($DoctorsRemarks1)){echo "
              <div class='Box2Flex1Border'><p>".$row6['doctor_notes_details']."</p></div>
            ";};
              echo"
          </div>
        </div>
        <div class='Main_Div1-Box2Flex2'>
          <button class='Btn_2'>More Details <i class='fa-solid fa-arrow-right'></i></button>
        </div>
      </div>
    </div>
  ";}
}


















?>