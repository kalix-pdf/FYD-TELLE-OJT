<?php
  session_start();
  include "./Config/Configure.php";
  include "./Components/Fetch_Home.php";
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
  <link href = "./Assets/Images/EACMC_LOGO 1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="./Assets/CSS_Index.css?ver=<?php echo time();?>">
  <link rel="stylesheet" href="./Assets/CSS_Public.css?ver=<?php echo time();?>">
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <title>EACMed - Find Your Doctor</title>
</head>
<body>
  <div class="EACMed_Body">
    <!-- BANNER -->
      <section class="Home_Banner">
        <div class="Banner_Div">
          <div class="Banner_Div1">
            <div class="Banner_Div1Flex">
              <img src="./Assets/Images/EACMed Logo.png" alt="">
              <h3 class="HDiv Banner_Div1FlexTitle">EAC Medical Center  - Cavite</h3>
            </div>
            <div class="Banner_Div2">
              <div class="Banner_Div2-Border">
                <h1>FIND A <span>DOCTOR</span></h1>
              </div>
            </div>
          </div>
        </div>
      </section>
    <!-- END -->
  
    <!-- MAIN -->
    <section class="Home_Main">
      <div class="Main_Div">
        <div class="Main_Div1">
          <div class="Main_Div1-Header HDiv">
            <h2 class="">Available Doctors</h2>
            <div class="Flex ">
              <div class="SearchDoctor InputText1">
                <i class="fa-solid fa-user-doctor"></i>
                <input type="text" placeholder="Search Doctor's Name" id="InputSearchPlaceholder"  class="InputSearchDoc" onkeyup="SearchDoctor('SearchDoc')">
                <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearText('Reload')"></i>
              </div>
              <div class="AllToday">
                <button class="AllTOdayBtn TodayBtn1 TodayBtnActive" onclick="BtnALlDocFilter('AllDoctor')">All</button>
                <button class="AllTOdayBtn TodayBtn2" onclick="BtnALlDocFilter('TodayDoctor')">Today</button>
              </div>
            </div>
          </div>

          <div class="Main_Div1-HeaderMob SDiv">
            <div class="Main_Div1-HeaderMobDiv1">
              <div class="SearchDoctor InputText1">
                <i class="fa-solid fa-user-doctor"></i>
                <input type="text" placeholder="Doctors Name" id="InputSearchPlaceholder2" class="InputSearchDoc2" onkeyup="SearchDoctor2('SearchDoc')">
                <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearText2('Reload')"></i>
              </div>
            </div>
          </div>

          <div class="Main_Div1-Section">
            <?php  while($row = mysqli_fetch_assoc($AllDoctors1)){
              $DID = $row['doctor_account_id'];
              $DSex = $row['doctor_sex'];
              if($DSex == "Male"){
                $DR_SexColor = "ImgBColor1";
              } else{
                $DR_SexColor = "ImgBColor2";
              }echo "
              <div class='Main_Div1-Box' onclick='ViewDoctor(`".$DID."`)'>
                <div class='Main_Div1-Box1'>
                  <div class='Img ".$DR_SexColor."'><img src='./Uploaded/".$row['profile_image']."' alt=''></div>
                  <div class=''>
                    <h1>Dr. ".$row['doctor_lastname'].".  ".substr($row['doctor_middlename'], 0, 1)." ".$row['doctor_firstname']."</h1>
                  
                    ";
                    $DoctorsSpecs1 = "SELECT * FROM doctor_specialization WHERE specialization_doctor_id = '$DID' LIMIT 1";
                    $DoctorsSpecs1 = mysqli_query($connMysqli,$DoctorsSpecs1);
                    while($row3 = mysqli_fetch_assoc($DoctorsSpecs1)){echo "
                      <h4>".$row3['doctor_specialization_name']."</h4>
                    ";};
                    
                    echo"
                    <div class='SubSpecializationNameDiv'>
                      ";
                      $DoctorsSubSpecs1 = "SELECT * FROM doctor_sub_specialization WHERE sub_specialization_doctor_id = '$DID' LIMIT 2";
                      $DoctorsSubSpecs1 = mysqli_query($connMysqli,$DoctorsSubSpecs1);
                      while($row4 = mysqli_fetch_assoc($DoctorsSubSpecs1)){echo "
                        <p>".$row4['doctor_sub_specialization_name']."</p>
                      ";};
                      echo"
                    </div>
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


            ";}?>
          </div>
        </div>
        <div class="Main_Div2 HDiv">
          <div class="Main_Div2-Section">
            <input type="hidden" readonly="readonly" id="refSpecsID">
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-stethoscope"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal1()" class="TextBoxFilter1">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField1()"></i>
              <div class="HoverP SearchPlaceholder1"><p>SPECIALIZATION</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-address-card"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal2()" placeholder="" class="TextBoxFilter2">
              <!-- <input type="text" class="TextBoxFilter2_2"> -->
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField2()"></i>
              <div class="HoverP SearchPlaceholder2"><p>SUB SPECIALIZATION</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-calendar-days"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal4()" placeholder="" class="TextBoxFilter6_2">
              <input type="text" readonly="readonly" placeholder="Clinic Day" class="TextBoxFilter6">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField4()"></i>
              <div class="HoverP SearchPlaceholder6"><p>CLINIC DAY</p></div>
            </div>
            <br>


            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-person-half-dress"></i>
              <input type="text"  readonly="readonly" onclick="OpenSearchModal5()" placeholder="" class="TextBoxFilter3">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField5()"></i>
              <div class="HoverP SearchPlaceholder3"><p>SEX</p></div>
            </div>
            <br>
            
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-video"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal6()" placeholder="" class="TextBoxFilter5">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField6()"></i>
              <div class="HoverP SearchPlaceholder5"><p>WITH TELECONSULTATION</p></div>
            </div>
            
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-id-card-clip"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal3()" placeholder="" class="TextBoxFilter4_2">
              <input type="text" readonly="readonly"  placeholder="Hidden HMO Accreditation" class="TextBoxFilter4">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField3()"></i>
              <div class="HoverP SearchPlaceholder4"><p>HMO ACCREDITATION</p></div>
            </div>

            <br>
            <div class="">
              <button onclick="ClearText('Clear')" class="Btn_1"><i class="fa-solid fa-eraser"></i> Clear All</button>
            </div>
          </div>
          <br>
          <div class="Main_Div2-Section2">
            <div class="">
              <div class="">
                <p>All Doctors: <span><?php echo $CountTotalDoctor?></span></p>
                <p>Available Doctors Today: <span><?php echo $CountTotalDoctorAvailableToday?></span></p>
              </div>
            </div>
          </div>
          <p class="Italic">DISCLAIMER: Doctors' clinic schedules are subject to change without prior notice.</p>
        </div>
      </div>
    </section>

    <!-- DOCTOR MODAL -->
    <section class="SearchDoctorModal">
      <!-- Container 1 -->
      <div class="ModalDivCon ModalDivCon1">
        <div class="ModalDivConHeader">
          <h1>Specialization</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()" ><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel">
          <input type="text" placeholder="Search Specialization" class="InputSpecialization" onkeyup="SearchSpecs('SearchSpecs')">
          <div class="ModalDivConPanel1">
            <ul class="DoctorsSpecsList">
              <?php  
                $DoctorSpecialization = "SELECT * FROM specialization ";
                $DoctorSpecialization = mysqli_query($connMysqli,$DoctorSpecialization);
                while($row = mysqli_fetch_assoc($DoctorSpecialization)){echo "
                  <li onclick='SelectSpecs(".$row['specialization_id'].")'><i class='fa-solid fa-circle-dot'></i> <p id='SpecsID_".$row['specialization_id']."'>".$row['specialization_name']."</p></li>
              ";}?>

            </ul>
          </div>
        </div>
      </div>
      <!-- Container 2 -->
      <div class="ModalDivCon ModalDivCon2">
        <div class="ModalDivConHeader">
          <h1>Sub Specialization</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel">
          <input type="text" placeholder="Search Sub Specialization" class="InputSubSpecialization" onkeyup="SearchSubSpecs('SearchSubSpecs')">
          <div class="ModalDivConPanel1">
            <ul class="doctor_sub_specializationDiv">
              <?php  
                $DoctorSubSpecialization = "SELECT * FROM sub_specialization ";
                $DoctorSubSpecialization = mysqli_query($connMysqli,$DoctorSubSpecialization);
                while($row = mysqli_fetch_assoc($DoctorSubSpecialization)){echo "
                  <li onclick='SelectSubSpecs(".$row['sub_specialization_id'].")'><i class='fa-solid fa-circle-dot'></i> <span id='SubsSpecsID_".$row['sub_specialization_id']."'>".$row['sub_specialization_name']."</span></li>
              ";}?>

            </ul>
          </div>
        </div>
      </div>
      <!-- Container 3 -->
      <div class="ModalDivCon ModalDivCon3">
        <div class="ModalDivConHeader">
          <h1>HMO Accreditation/s</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel">
          <input type="text" placeholder="Search a 'HMO Accreditation'" class="InputSearchHMO" onkeyup="SearchHMO('SearchHMO')">
          <div class="HMOArr"><p class="HMOArrP"></p></div>
          <div class="ModalDivConPanel1">
            <ul class="doctor_HMODiv">
              <?php  
                $DoctorSpecialization = "SELECT * FROM hmo ORDER BY hmo_name ASC";
                $DoctorSpecialization = mysqli_query($connMysqli,$DoctorSpecialization);
                while($row = mysqli_fetch_assoc($DoctorSpecialization)){echo "
                  <div class='ModalDivConPanelDiv2 HMO_ID_".$row['hmo_id']."' onclick='functionHMO( ".$row['hmo_id'].")'>
                    <i class='fa-regular fa-square'></i> 
                    <p>".$row['hmo_name']."</p>
                    <input type='checkbox' class='HMOOName ScheduleDay1' value='".$row['hmo_id']."'>      
                    <input type='checkbox' class='HMOOName2 ScheduleDay1' value='".$row['hmo_name']."'>
                  </div>
              ";}?>
            </ul>
          </div>
        </div>
      </div>
      <!-- Container 4 -->
      <div class="ModalDivCon ModalDivCon4">
        <div class="ModalDivConHeader">
          <h1>Clinic Day</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel">
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Monday</p> <input type="checkbox" class="SDay ScheduleDay1" value="Monday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Tuesday</p> <input type="checkbox" class="SDay ScheduleDay2" value="Tuesday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Wednesday</p> <input type="checkbox" class="SDay ScheduleDay3" value="Wednesday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Thursday</p> <input type="checkbox" class="SDay ScheduleDay4" value="Thursday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Friday</p> <input type="checkbox" class="SDay ScheduleDay5" value="Friday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Saturday</p> <input type="checkbox" class="SDay ScheduleDay6" value="Saturday"></div>
          <div class="ModalDivConPanelDiv"><i class="fa-regular fa-square"></i> <p>Sunday</p> <input type="checkbox" class="SDay ScheduleDay7" value="Sunday"></div>
        </div>
      </div>
      <!-- Container 5 -->
      <div class="ModalDivCon ModalDivCon5">
        <div class="ModalDivConHeader">
          <h1>SEX</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel ModalDivConPanelMinHeight">
          <div class="HiddenDropDown">
            <button onclick="SelectSex('Male')" class="Btn_1">Male</button>
            <button onclick="SelectSex('Female')" class="Btn_2">Female</button>
          </div>
        </div>
      </div>
      <!-- Container 6 -->
      <div class="ModalDivCon ModalDivCon6">
        <div class="ModalDivConHeader">
          <h1>WITH TELECONSULTATION</h1>
          <div class="CircleDiv" onclick="CloseMainSpecialization()"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="ModalDivConPanel ModalDivConPanelMinHeight">
          <div class="HiddenDropDown">
            <button onclick="TeleText('YES')" class="Btn_1">YES</button>
            <button onclick="TeleText('NO')" class="Btn_2">NO</button>
          </div>
        </div>
      </div>
    </section>

    <!-- HOME MODAL -->
    <section class="Home_Modal">
      <div class="HomeMain-Modal">
        <!-- EMPTY -->
      </div>
    </section>

    <!-- HOME LOADING -->
    <section class="Home_Loading">
      <!-- EMPTY 0 -->
    </section>

    <!-- FILTER - MOBILE VIEW -->
    <section class="FilterFloat SDiv">
      <div class="FilterFloatDivContainer0">
        <p>Filter</p>
        <span class="material-symbols-sharp">filter_list</span>
      </div>
      <div class="FilterFloatDivContainer1">
        <div class="AllToday">
          <div class="Flex">
            <button class="AllTOdayBtn TodayBtn1 TodayBtnActive" onclick="BtnALlDocFilter('AllDoctor')">All</button>
            <button class="AllTOdayBtn TodayBtn2" onclick="BtnALlDocFilter('TodayDoctor')">Today</button>
          </div>
          <div class="AllToday-HideBtn HideFilter">
            <h4>Hide</h4>
            <lord-icon
              src="https://cdn.lordicon.com/whtfgdfm.json"
              trigger="loop"
              delay="2000"
              style="width:20px;height:20px">
            </lord-icon>
          </div>
        </div>
      </div>

      <!-- FILTER CONTAINER- MOBILE -->
      <div class="FilterMobContainer">
        <div class="Main_Div2">
          <h2>Filter</h2>
          <div class="Main_Div2-Section">
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-stethoscope"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal1()" class="TextBoxFilter1">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField1()"></i>
              <div class="HoverP SearchPlaceholder1"><p>SPECIALIZATION</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-address-card"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal2()" placeholder="" class="TextBoxFilter2">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField2()"></i>
              <div class="HoverP SearchPlaceholder2"><p>SUB SPECIALIZATION</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-calendar-days"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal4()" placeholder="" class="TextBoxFilter6_2">
              <input type="text" readonly="readonly" placeholder="Clinic Day" class="TextBoxFilter6">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField4()"></i>
              <div class="HoverP SearchPlaceholder6"><p>CLINIC DAY</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-person-half-dress"></i>
              <input type="text"  readonly="readonly" onclick="OpenSearchModal5()" placeholder="" class="TextBoxFilter3">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField5()"></i>
              <div class="HoverP SearchPlaceholder3"><p>SEX</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-video"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal6()" placeholder="" class="TextBoxFilter5">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField6()"></i>
              <div class="HoverP SearchPlaceholder5"><p>WITH TELECONSULTATION</p></div>
            </div>
            <br>
            <div class="SearchDoctor InputText1">
              <i class="fa-solid fa-id-card-clip"></i>
              <input type="text" readonly="readonly" onclick="OpenSearchModal3()" placeholder="" class="TextBoxFilter4_2">
              <input type="text" readonly="readonly"  placeholder="Hidden HMO Accreditation" class="TextBoxFilter4">
              <i class="fa-regular fa-circle-xmark XCursor" onclick="ClearTxtField3()"></i>
              <div class="HoverP SearchPlaceholder4"><p>HMO ACCREDITATION</p></div>
            </div>
            <br>
            <div class="">
              <button onclick="ClearText('Clear')" class="Btn_1"><i class="fa-solid fa-eraser"></i> Clear All</button>
            </div>
          </div>
          <br>
          <p class="Italic">DISCLAIMER: Doctors' clinic schedules are subject to change without prior notice.</p>
        </div>
      </div>
    </section>

    <!-- START LOGO -->
    <div class="Welcome-Logo">

    </div>
    <!-- END -->
  </div>

  <script type="text/javascript" src="./Assets/JS_Home.js?ver=<?php echo time();?>"></script>
</body>
</html>