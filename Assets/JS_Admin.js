function LinkToLogout() {
  location.href = "../Admin - Panel/Logout.php";
}

function BTNDashboard() {
  $(".AdminDashboard").css("display", "flex");
  $(".AdminDashboard").siblings().css("display", "none");
  $(".SBFocus1").siblings().removeClass("Sidebar_Active");
  $(".SBFocus1").addClass("Sidebar_Active");
  updateChartData();
  updateChartData2();
}
function BTNDoctors() {
  $(".DoctorsDiv").css("display", "flex");
  $(".DoctorsDiv").siblings().css("display", "none");

  $(".SBFocus2").siblings().removeClass("Sidebar_Active");
  $(".SBFocus2").addClass("Sidebar_Active");
}
function BTNAccounts() {
  $(".AccountsDiv").css("display", "flex");
  $(".AccountsDiv").siblings().css("display", "none");

  $(".SBFocus3").siblings().removeClass("Sidebar_Active");
  $(".SBFocus3").addClass("Sidebar_Active");
}
function BTNActivity() {
  $(".ActivityLogs").css("display", "flex");
  $(".ActivityLogs").siblings().css("display", "none");

  $(".SBFocus4").siblings().removeClass("Sidebar_Active");
  $(".SBFocus4").addClass("Sidebar_Active");
}
function BTNArchive() {
  $(".ArchivesDiv").css("display", "flex");
  $(".ArchivesDiv").siblings().css("display", "none");

  $(".SBFocus5").siblings().removeClass("Sidebar_Active");
  $(".SBFocus5").addClass("Sidebar_Active");
}
function BTN_HMO(){
  $(".HMO_Div").css("display", "flex");
  $(".HMO_Div").siblings().css("display", "none");

  $(".SBFocus6").siblings().removeClass("Sidebar_Active");
  $(".SBFocus6").addClass("Sidebar_Active");
}
function BTN_Room(){
  $(".Room_Div").css("display", "flex");
  $(".Room_Div").siblings().css("display", "none");

  $(".SBFocus7").siblings().removeClass("Sidebar_Active");
  $(".SBFocus7").addClass("Sidebar_Active");
}
function BTN_Specialization(){
  $(".Specialization_Div").css("display", "flex");
  $(".Specialization_Div").siblings().css("display", "none");

  $(".SBFocus8").siblings().removeClass("Sidebar_Active");
  $(".SBFocus8").addClass("Sidebar_Active");
}
function BTN_SubSpecialization(){
  $(".SubSpecialization_Div").css("display", "flex");
  $(".SubSpecialization_Div").siblings().css("display", "none");

  $(".SBFocus9").siblings().removeClass("Sidebar_Active");
  $(".SBFocus9").addClass("Sidebar_Active");
}

function clearText() {
  $(".CT1").val("");
  $(".CT2").val("");
}



function editNav(navId){  
  $(".edit-nav" + navId).addClass("editNavActive").removeClass("editNavInactive") .siblings().removeClass("editNavActive") .addClass("editNavInactive");
  $(".editDoctor-Child" + navId).css({"display":"flex"}).siblings().css({"display":"none"});

}

// Dashboard Chart
var chart;
function FuncChart(data = []) {

  var inputChartName1 = $("#chartInputSpecs-Names1").val() || "";
  var inputChartName2 = $("#chartInputSpecs-Names2").val() || "";
  var inputChartName3 = $("#chartInputSpecs-Names3").val() || "";
  var inputChartName4 = $("#chartInputSpecs-Names4").val() || "";
  var inputChartName5 = $("#chartInputSpecs-Names5").val() || "";

  var categories = [inputChartName1, inputChartName2, inputChartName3, inputChartName4, inputChartName5]
    .filter(name => name !== ""); // remove empty names

  var options = {
    series: [{ data: Array.isArray(data) ? data : [] }], // ensure it's always an array
    chart: {
      type: "bar",
      height: 250,
      dropShadow: { enabled: true, top: 0, left: 0, blur: 2, opacity: 0.2 }
    },
    plotOptions: {
      bar: { borderRadius: 4, borderRadiusApplication: "end", horizontal: true }
    },
    fill: { colors: ["#318499"] },
    dataLabels: { enabled: false },
    xaxis: { categories: categories.length ? categories : ["No Data"] } // fallback label
  };

  if (chart) chart.destroy();

  chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
}



function updateChartData(resetToZero = false) {
  var inputSpecsChart1 = Number($("#chartInputSpecs-IDs1").val()) || 0;
  var inputSpecsChart2 = Number($("#chartInputSpecs-IDs2").val()) || 0;
  var inputSpecsChart3 = Number($("#chartInputSpecs-IDs3").val()) || 0;
  var inputSpecsChart4 = Number($("#chartInputSpecs-IDs4").val()) || 0;
  var inputSpecsChart5 = Number($("#chartInputSpecs-IDs5").val()) || 0;

  var newData = [
    inputSpecsChart1,
    inputSpecsChart2,
    inputSpecsChart3,
    inputSpecsChart4,
    inputSpecsChart5
  ];

  if (resetToZero) {
    newData = newData.map(() => 0);
  }

  if (chart) {
    chart.updateSeries([{ data: newData }]);
  }
}

// initial data from PHP
var initialData = [
  Number($("#chartInputSpecs-IDs1").val()) || 0,
  Number($("#chartInputSpecs-IDs2").val()) || 0,
  Number($("#chartInputSpecs-IDs3").val()) || 0,
  Number($("#chartInputSpecs-IDs4").val()) || 0,
  Number($("#chartInputSpecs-IDs5").val()) || 0
];

// create chart

FuncChart(initialData);



// Dashboard Chart 2
var chart2;
var chart2; // define globally so you can destroy/re-render later

function FuncChart2(data = []) {
  var inputChartName1 = $("#chartInputHMO-Names1").val() || "";
  var inputChartName2 = $("#chartInputHMO-Names2").val() || "";
  var inputChartName3 = $("#chartInputHMO-Names3").val() || "";
  var inputChartName4 = $("#chartInputHMO-Names4").val() || "";
  var inputChartName5 = $("#chartInputHMO-Names5").val() || "";

  var categories = [
    inputChartName1,
    inputChartName2,
    inputChartName3,
    inputChartName4,
    inputChartName5
  ].filter(name => name !== "");

  if (categories.length === 0) categories = ["No Data"];

  if (!Array.isArray(data)) {
    console.warn("FuncChart2(): Invalid data argument, expected array. Got:", data);
    data = [];
  }

  var options = {
    series: [{
      data: data
    }],
    chart: {
      type: "bar",
      height: 250,
      dropShadow: {
        enabled: true,
        top: 0,
        left: 0,
        blur: 2,
        opacity: 0.2
      }
    },
    plotOptions: {
      bar: {
        borderRadius: 4,
        borderRadiusApplication: "end",
        horizontal: true
      }
    },
    fill: { colors: ["#318499"] },
    dataLabels: { enabled: false },
    xaxis: {
      categories: categories
    }
  };

  if (chart2) {
    chart2.destroy();
  }

  chart2 = new ApexCharts(document.querySelector("#chart2"), options);
  chart2.render();
}




var inputChart1 = $("#chartInputHMO-IDs1").val();
var inputChart2 = $("#chartInputHMO-IDs2").val();
var inputChart3 = $("#chartInputHMO-IDs3").val();
var inputChart4 = $("#chartInputHMO-IDs4").val();
var inputChart5 = $("#chartInputHMO-IDs5").val();

function updateChartData2() {
  var newData = [0, 0, 0, 0, 0];
  var newData2 = [inputChart1, inputChart2, inputChart3, inputChart4, inputChart5];
  chart2.updateSeries([{ data: newData }]);
  chart2.updateSeries([{ data: newData2 }]);
}
var initialData2 = [inputChart1, inputChart2, inputChart3, inputChart4, inputChart5];
FuncChart2(initialData2);






$(document).ready(function () {
  // POP UP MESSAGE / WELCOME ADMIN
  const myTimeout = setTimeout(timer2, 3000);
  function timer2() {
    $(".PopUp-Div").css("display", "none");
    $(".AddDoctorDiv").removeClass("PopUp-Div-Add");
  }

  // PAGINATION - LOAD DATA
  function loadData(page) {
    $.ajax({
      url: "../Components/Function_Admin.php",
      type: "POST",
      data: { page: page },
      success: function (response) {
        // console.log(response);
        $("#data-container").html(response);
      },
    });
  }
  loadData(1);
  $(document).on("click", ".pagination li a", function (e) {
    e.preventDefault();
    var page = $(this).attr("data-page");
    loadData(page);
  });

  // ADD DOCTOR
  $(".BtnAddDoctor").click(function () {
    $(".AddDoctorDiv").css("display", "flex");
  });

  // CLOSE ADD DOCTOR CONTAINER
  $(".Close-AddDoctorDiv").click(function () {
    $(".AddDoctorDivContainer").css("display", "flex");
    $(".AddDoctorDivContainer").addClass("AddDoctorDivContainerClosing");
    $(".AddDoctorDiv").addClass("AddDoctorDivClosing");
    const myTimeout = setTimeout(timer2, 900);
    function timer2() {
      $(".AddDoctorDiv").css("display", "none");
      $(".AddDoctorDivContainer").removeClass("AddDoctorDivContainerClosing");
      $(".AddDoctorDiv").removeClass("AddDoctorDivClosing");
    }
  });
});

let EditSpecializationArr = [];
let EditSubSpecializationArr = [];
let EditNewRoomarr = [];
let EditNewHMOarr = [];
let EditNewScheduleArr = [];
let EditedNewSecretaryArr = [];
// ============= AJAX =============
// HIDE MODAL
function ModalSidebarExit() {
  EditSpecializationArr = [];
  EditSubSpecializationArr = [];
  EditNewRoomarr = [];
  EditNewHMOarr = [];
  EditNewScheduleArr = [];
  EditedNewSecretaryArr = [];

  $(".Modal-Sidebar").css("display", "none");
}

// DOCTOR ==================================
// OPEN NEW DOCTOR - MODAL
function AddDoctor() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-AddDoctor").css("display", "flex");
  $(".Modal-AddDoctor").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

// OPEN MODAL / VIEW DOCTOR DETAILS
function ViewDoctor(ViewDoctorType,ViewDoctor_ID) {
  var data = {
    ViewDoctorType: ViewDoctorType,
    ViewDoctor_ID: ViewDoctor_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      if(ViewDoctorType == "View" || ViewDoctorType == "ArchivedView"){
        $(".Modal-Sidebar").css("display", "flex");
        $(".Modal-Container").css("display", "flex");
        $(".Modal-ViewDoctor").css("display", "flex");
        $(".Modal-ViewDoctor").siblings().css("display", "none");
        $(".Modal-ViewDoctor").html(response);

        if(ViewDoctorType == "ArchivedView"){
          $(".Modal-Sidebar-Bottom").css("display", "none");
        }
      }
    },
  });
}

// OPEN MODAL / EDIT DOCTOR DETAILS
function EditDoctor(ViewEdit_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditDoctor").css("display", "flex");
  $(".Modal-EditDoctor").siblings().css("display", "none");

  selectedDoctorID = ViewEdit_ID;

  var data = {
    ViewEdit_ID: ViewEdit_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".Modal-EditDoctor").html(response);
    },
  });
}

// BACK TO DOCTOR DETAILS
function BackToViewDoctor() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewDoctor").css("display", "flex");
  $(".Modal-ViewDoctor").siblings().css("display", "none");
}

// PROMPT MESSAGE / HIDE PROMPT MODAL
function HidePromptMessage() {
  $(".Prompt-Message").css("display", "none");
  $(".Prompt-AddNewDoctor").css("display", "none");
}

// PROMPT MESSAGE / ADD NEW DOCTOR
function AddNewDoctor() {
    var DocInput1 = $("#DoctorsFirstName").val();
    var DocInput3 = $("#DoctorsLastName").val();
    var DocInput4 = $("#DoctorGender").val();
    var DocInput5 = $("#DoctorCategory").val();

    var DoctorTele = $("#DoctorsTeleConsult").val();
    var DocInputsSpecs = $("#hiddenInformationFieldIDSpecs").text().trim();
    var DocInputSchedule = $("#informationFieldAddSchedule").text().trim();
    var DocInputsRoom = $("#hiddenInformationFieldIDRoom").text().trim();
    var DocInputSecretary = $("#InformationFieldAddSecretary").text().trim();
    var DoctorInputHMO = $("#hiddenInformationFieldIDHMO").text().trim();

    let hasError = false;
      $("#FirstNameWarning, #LastNameWarning, #GenderWarning, #SpecializationWarning, #warningRoom, #warningSchedule, #HMOWarning, #secretaryWarning, #categoryWarning").html(""); // Clear previous warnings

      if (DocInput1 === "") {
        $("#FirstNameWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInput3 === "") {
        $("#LastNameWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInput4 === "" || DocInput4 === null) {
        $("#GenderWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInput5 === null) {
        $("#categoryWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInputsSpecs === "") {
        $("#SpecializationWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInputSchedule === "") {
        $("#warningSchedule").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DocInputsRoom === "") {
        $("#warningRoom").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true;
      }
      if (DoctorTele === "") {
        $("#warningTele").html("N/A");
        hasError = false; 
      }
      if (DocInputSecretary === "") {
        $("#secretaryWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true; 
      }
      if (DoctorInputHMO === "") {
        $("#HMOWarning").html("*");
        $("#AddNewDoctorMessage").html("Please fill out the required fields.");
        hasError = true; 
      }

      if (hasError) {
        return;
      }

    if (!hasError) {
        $(".Prompt-Message").css("display", "flex");
        $(".Prompt-AddNewDoctor").css("display", "flex");
        $(".Prompt-AddNewDoctor").siblings().css("display", "none");
    }
}

// PROMPT MESSAGE / UPDATE DOCTOR
// function UpdateDoctor() {
//   $(".Prompt-Message").css("display", "flex");
//   $(".Prompt-UpdateDoctor").css("display", "flex");
//   $(".Prompt-UpdateDoctor").siblings().css("display", "none");
// }

// PROMPT MESSAGE / Prompt DOCTOR
let DoctorID = "";
function PromptDoctor(PromptType, Prompt_ID) {
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-" + PromptType).css("display", "flex");
  $(".Prompt-" + PromptType).siblings().css("display", "none");
  DoctorID = Prompt_ID;
}


// PROMPT MESSAGE / ADD ACCESS ACCOUNT
function AddNewAccess() {
  var AccessUsername  = $("#AccessUsername").val(); 
  var AccessType  = $("#AccessType").val();

  let warning = false;

  if (AccessUsername === "") {
    $("#AccessAccountWarning").html("Please enter a username.");  
    warning = true;
  }
  if (AccessType === null) {
    $("#AccessTypeWarning").html("Please select an access type.");
    warning = true;
  }
  if (warning) {
    return;
  }


  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AccessAccount").css("display", "flex");
  $(".Prompt-AccessAccount").siblings().css("display", "none");
}

// PROMPT MESSAGE / RESET PASSWORD - ADMIN
function ResetPasswordAdmin(ResetPasswordAdmin_ID) {
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-ResetAdminAccount").css("display", "flex");
  $(".Prompt-ResetAdminAccount").siblings().css("display", "none");
  var data = {
    ResetPasswordAdmin_ID: ResetPasswordAdmin_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      $(".Prompt-ResetAdminAccount").html(response);
      // console.log(response);
    },
  });
}





// ACCOUNT ==================================
// OPEN NEW ADMIN - MODAL
function AddAdmin() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-AddAdmin").css("display", "flex");
  $(".Modal-AddAdmin").siblings().css("display", "none");
}

// INSERT NEW DOCTOR
function PopMessages(PopMsg) {
  $("#Pop-Message").html(PopMsg);
  $(".Prompt-Message").css("display", "none");
  $(".PopUp-Message").css("display", "flex");
  $(".PopUp-Message").addClass("AddPopUp-Message");
  $(".Modal-Sidebar").css("display", "none");
  const myTimeout = setTimeout(timer2, 3000);
  function timer2() {
    $(".PopUp-Message").css("display", "none");
  }
}


// INSERT NEW DOCTOR
function InsertNewDoctor(InsertDoctor) {
  var data = {
    InsertDoctor: InsertDoctor,
    LastName: $("#DoctorsLastName").val(),
    MiddleName: $("#DoctorsMiddleName").val(),
    FirstName: $("#DoctorsFirstName").val(),
    Gender: $("#DoctorGender").val(),
    Specialization: selectedIds,
    SubSpecialization: selectedIds2, 
    Schedule: scheduleArr,
    Secretary: secretaryArr,
    Remarks: $("#DoctorsRemarks").val(),
    Room: roomArr,
    HMOAccreditation: hmoArr,
    TeleConsultation: $("#DoctorsTeleConsult").val(),
    UserID: UserID,

    Category: $("#DoctorCategory").val(),
    PrimarySecretary: $("#DoctorsFirstName").val(),
    PrimaryFirstNumber: $("#DoctorsFirstName").val(),
    PrimaryFirstNetwork: $("#DoctorsFirstName").val(),
    PrimarySecondNumber: $("#DoctorsFirstName").val(),
    PrimarySecondNetwork: $("#DoctorsFirstName").val(),
    SecondarySecretary: $("#DoctorsFirstName").val(),
    SecondarySecondNumber: $("#DoctorsFirstName").val(),
    SecondarySecondNetwork: $("#DoctorsFirstName").val(),
  };
  if (data.TeleConsultation === ""|| data.TeleConsultation == null) {
    data.TeleConsultation = "N/A";
  }
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      reloadDiv('account_table');
      $(".Modal-Container").css("display", "none");
      $(".hiddenContainer").css("display", "none");
      clearText();
      if(response == "Doctor have been successfully inserted!"){
        PopMessages(response);
        location.reload();
      }
      location.reload();
    },
  });

  selectedIds.splice(0, selectedIds.length);
  selectedIds2.splice(0, selectedIds2.length);
  scheduleArr.splice(0, scheduleArr.length);
  secretaryArr.splice(0, secretaryArr.length);
  roomArr.splice(0, roomArr.length);
  hmoArr.splice(0, hmoArr.length);
  
  $("#hiddenInformationFieldIDSpecs").html("");
  $("#hiddenInformationFieldIDSpecs2").html("");

  $("#hiddenInformationFieldIDSubSpecs").html("");
  $("#DoctorsRemarks").val("");
  $("#day-select").val("Monday");
  $("#pick-timeIn").html("");
  $("#pick-timeOut").html("");
  $("#DoctorsRemarks").html("");


  $(".InformationFieldAddSchedule").html("");
  $(".InformationFieldAddSecretary").html("");
  $("#hiddenInformationFieldIDRoom").html("");
  $("#hiddenInformationFieldIDHMO").html("");
  $(".Prompt-Message").css("display","none");

}






function doctorSpecs(SearchSpecs){
  if($("#SpecializationInput").val() == ""){
    $(".HiddenInputFieldForm1").css("display", "none");
  }
  else{
    // $(".HiddenInputFieldForm1").css("display", "flex");
    var data = {
      SearchSpecs: SearchSpecs,
      SpecializationInput: $("#SpecializationInput").val(),
    };
    $.ajax({
      url: "../Components/Function_Admin.php",
      type: "post",
      data: data,
      success: function (response) {
        // console.log(response);
        $(".InformationField").html("response");
      },
    });
  }
}


function Yes_AddNewAccess(AccessAccount) {
  PopMessages();
  var data = {
    AccessAccount: AccessAccount,
    AccessUsername: $("#AccessUsername").val(),
    AccessType: $("#AccessType").val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      reloadDiv('account_table')
      $("#Pop-Message").html("The new admin account has been successfully created!");
    },
  });
}

function View_Admin(ViewAdmin_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewAdmin").css("display", "flex");
  $(".Modal-Container").css("display", "flex");
  $(".Modal-ViewAdmin").siblings().css("display", "none");

  var data = {
    ViewAdmin_ID: ViewAdmin_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      $(".Modal-ViewAdmin").html(response);
      // console.log(response);
    },
  });
}


// OPEN MODAL / VIEW ADMIN
function ViewAdmin() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewAdmin").css("display", "flex");
  $(".Modal-Container").css("display", "flex");
  $(".Modal-ViewAdmin").siblings().css("display", "none");
}

function PopErrorMessages(PopErrorMsg) {
  $("#Pop-ErrorMessage").html(PopErrorMsg);
  $(".Prompt-Message").css("display", "none");
  $(".PopUp-ErrorMessage").css("display", "flex");
  $(".PopUp-ErrorMessage").addClass("AddPopUp-ErrorMessage");
  $(".Modal-Sidebar").css("display", "none");
  const myTimeout = setTimeout(timer2, 3000);
  function timer2() {
    $(".PopUp-ErrorMessage").css("display", "none");
  }
}


function Yes_ResetPasswordAdmin(Yes_ResetPasswordAdmin_ID) {
  var data = {
    Yes_ResetPasswordAdmin_ID: Yes_ResetPasswordAdmin_ID,
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    dataType: "json",
    success: function (response) {
      console.log(response)
      if (response.status === "success") {
        $("#Pop-Message").html(response.message);
        PopMessages(); 
      } else {
        $("#Pop-ErrorMessage").html(response.message);
        PopErrorMessages(); 
      }
    },
  });
}






// ADD DOCTOR - SEARCH
function editSearch(SearchType, searchId) {
  if(SearchType == "Insert"){
    const searchElement = $("#editSearch" + searchId);
    if (searchElement.val().length === 0) {
      searchElement.parent().siblings().css("display", "none");
    } else {
      searchElement.parent().siblings().css("display", "flex");
  
      var data = {
        searchId: searchId, 
        SearchType: SearchType, 
        searchName: $("#editSearch" + searchId).val(), 
      };
      $.ajax({
        url: "../Components/Function_Admin.php",
        type: "post",
        data: data,
        success: function (response) {
          // console.log(response);
          // console.log(searchId);
          $("#EditDropdown" + searchId).html(response);
        },
      });
    }
  }

  else if(SearchType == "Edit"){
    const searchElement = $("#edit_Search" + searchId);
    
    if (searchElement.val().length === 0) {
      searchElement.parent().siblings().css("display", "none");
    } else {
      searchElement.parent().siblings().css("display", "flex");
  
      var data = {
        searchId: searchId, 
        SearchType: SearchType, 
        searchName: $("#edit_Search" + searchId).val(), 
      };
      $.ajax({
        url: "../Components/Function_Admin.php",
        type: "post",
        data: data,
        success: function (response) {
          // console.log(response);
          // console.log(searchId);
          $("#Edit_Dropdown" + searchId).html(response);
        },
      });
    }


    console.log("Edit Type");
  }

}




const selectedIds = [];
const selectedIds2 = [];
const scheduleArr = [];
const secretaryArr = [];
const roomArr = [];
const hmoArr = [];
let RemovedSpecsFromEdit = [];


function selectThis(selectedType, selectedId, SearchType) {
  const selectedElementId = $("#hiddenInformationFieldID" + selectedType);
  if (selectedType === "Specs") {
    selectedElementId.css("display", "flex");

    if (SearchType === "Edit") {
      if (!EditSpecializationArr.includes(selectedId)) {
        EditSpecializationArr.push(selectedId);
      }  
      selectedItems(EditSpecializationArr, selectedId, SearchType);

    } else {
      if (!selectedIds.includes(selectedId)) {
        selectedIds.push(selectedId);
      }  
      selectedItems(selectedIds,selectedId, SearchType);
    }
    
    closeSearch(selectedId);
  
    $("#editSearch1").val("");
    $(".hiddenContainer").css("display", "none");
  }

  else if(selectedType === "SubSpecs"){
    selectedElementId.css("display", "flex");
    if (SearchType === "Edit") {
      if (!EditSubSpecializationArr.includes(selectedId)) {
        EditSubSpecializationArr.push(selectedId);
      }  
      selectedItems2(EditSubSpecializationArr, SearchType);

    } else {
      if (!selectedIds2.includes(selectedId)) {
        selectedIds2.push(selectedId);
      }  
      selectedItems2(selectedIds2, SearchType);
    }
    
    closeSearch(selectedId);
  
    $("#editSearch2").val("");
    $(".hiddenContainer").css("display", "none");
  }
  else if(selectedType === "Room"){
    selectedElementId.css("display", "flex");

    if (SearchType === "Edit") {
      if (!EditNewRoomarr.includes(selectedId)) {
        EditNewRoomarr.push(selectedId);
      }
      selectedItems3(EditNewRoomarr, SearchType);
    
    } else {
      if (!roomArr.includes(selectedId)) {
        roomArr.push(selectedId);
      }
      selectedItems3(roomArr, SearchType);
    }
      
    closeSearch(selectedId);
    
    $("#editSearch3").val("");
    $(".hiddenContainer").css("display", "none");
  }
  else if(selectedType === "HMO"){
    selectedElementId.css("display", "flex");

    if (SearchType === "Edit") {
      if (!EditNewHMOarr.includes(selectedId)) {
        EditNewHMOarr.push(selectedId);
      }
      selectedItems4(EditNewHMOarr, SearchType);
    }
    else {
      if (!hmoArr.includes(selectedId)) {
        hmoArr.push(selectedId);
      }
      selectedItems4(hmoArr, SearchType);
    }
      
    closeSearch(selectedId);  
    
    $("#editSearch4").val("");
    $(".hiddenContainer").css("display", "none");
  }


}


// CLOSE DOCTOR - SEARCH
function closeSearch(closeId) {
  const searchElement = $("#editSearch" + closeId);
  searchElement.val("");
  searchElement.parent().siblings().css("display", "none");
}

let selectedDoctorID = "";
function selectedItems(selectedIds,selectedId, SearchType){
  var data = {
    functionSelectedItems: SearchType == "Edit" ? EditSpecializationArr : selectedIds,
    selectedId: selectedId,
    selectedCode: SearchType,
    selectedDoctorID: selectedDoctorID,
  }; 
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      var newItem = $(response);

      if (SearchType === "Edit") {
        EditSpecializationArr.forEach(function (specId) {

          if ($("#hiddenInformationFieldIDSpecsEdit").find("[data-specid='" + specId + "']").length === 0) {
            $("#hiddenInformationFieldIDSpecsEdit").append(newItem.filter("[data-specid='" + specId + "']"));
          }
        });
      } else {
        $("#hiddenInformationFieldIDSpecs").html(response);
      }
      
    },
  });
}

function selectedItems2(selectedIds, SearchType){
  var data = {
    functionSelectedItems2: SearchType == "Edit" ?  EditSubSpecializationArr : selectedIds,
    selectedCode: SearchType,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      var newItem = $(response);

      if (SearchType === "Edit") {
          EditSubSpecializationArr.forEach(function (specId) {

          if ($("#hiddenInformationFieldIDSubSpecsEdit").find("[data-specid='" + specId + "']").length === 0) {
            $("#hiddenInformationFieldIDSubSpecsEdit").append(newItem.filter("[data-specid='" + specId + "']"));
          }
        });
      } else {
        $("#hiddenInformationFieldIDSubSpecs").html(response);
      }
    },
  });
}

function selectedItems3(selectedIds, SearchType){
  var data = {
    functionSelectedItems3: selectedIds,
    selectedCode: SearchType,
  }; 
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      var newItem = $(response);

      if (SearchType === "Edit") {
          EditNewRoomarr.forEach(function (specId) {
          
            if ($("#hiddenInformationFieldIDRoomEdit").find("[data-specid='" + specId + "']").length === 0) {
              $("#hiddenInformationFieldIDRoomEdit").append(newItem.filter("[data-specid='" + specId + "']"));
            }
          });
      } else {
        $("#hiddenInformationFieldIDRoom").html(response);
      }
    },
  });
}

function selectedItems4(selectedIds, SearchType){
  var data = {
    functionSelectedItems4: selectedIds,
    selectedCode: SearchType,
  }; console.log(data);
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      var newItem = $(response);

      if (SearchType === "Edit") {
          EditNewHMOarr.forEach(function (specId) {
          
            if ($("#hiddenInformationFieldIDHMOEdit").find("[data-specid='" + specId + "']").length === 0) {
              $("#hiddenInformationFieldIDHMOEdit").append(newItem.filter("[data-specid='" + specId + "']"));
            }
          });
      } else {
        $("#hiddenInformationFieldIDHMO").html(response);
      }
    },
  });
}





function AddItems(ItemType){
  var data = {
    AddItemsItemType: ItemType,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
    $(".Add-Items-Container").css("display", "flex");
      $(".Add-Items-Container").html(response);
    },
  });
}



function InsertDocData(ItemType){
  if(ItemType == "Room"){
    const InsertDataFloorLevel = $("#InsertDataFloorLevel").val();
    const InsertDataFloorNumber = $("#InsertDataRoomNumber").val();
    InsertDocDataName = InsertDataFloorLevel + " - " + InsertDataFloorNumber;
  }
  else{
    InsertDocDataName =  $("#InsertDataName").val();
  }
  var data = {
    InsertDocDataItemType: ItemType,
    InsertDocDataName: InsertDocDataName,
    InsertDocDataID: $("#InsertDataID").val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#InsertDataName").val("");
      $(".Add-Items-Message").css("display", "flex");
      $(".Add-Items-Message").html(response);

      const myTimeout = setTimeout(timer2, 3000);
      function timer2() {
        $(".Add-Items-Message").css("display", "none");
      }
    },
  });
}

function CloseAddItems(){
  $(".Add-Items-Container").css("display", "none");
}


function SearchAddSpecs(InsertDataSpecsName){
  var data = {
    SearchAddSpecs: InsertDataSpecsName,
    InsertDataSpecsName: $("#InsertDataSpecsName" ).val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);

    // $("#InsertDataName").val("");
    $(".Add-Items-List").css("display", "flex");
    $(".Add-Items-List").html(response);
    },
  });
}


function selectThisAddSubSpecs(selectThisAddSubSpecsName,selectThisAddSubSpecsID){
  $("#InsertDataSpecsName").val(selectThisAddSubSpecsName);
  $("#InsertDataID").val(selectThisAddSubSpecsID);
  $(".Add-Items-List").css("display", "none");
}




function AddSchedule(Type) {

  const addDay = Type === "FromEdit" ? $("#day-selectEdit").val() : $("#day-select").val();
  const addIn = Type === "FromEdit" ? $("#pick-timeInEdit").val() : $("#pick-timeIn").val();;
  const addOut = Type === "FromEdit" ? $("#pick-timeOutEdit").val() : $("#pick-timeOut").val();;

  if (!addDay || !addIn || !addOut) {
    console.error("Please select all fields before adding to the schedule.");
    return;
  }
  const formattedIn = formatTime(addIn);
  const formattedOut = formatTime(addOut);

  const together = `${addDay}, ${formattedIn} - ${formattedOut}`;

  if (Type === "FromEdit") {
    if (!EditNewScheduleArr.includes(together)) {
      EditNewScheduleArr.push(together);
    }
  } else {
    if (!scheduleArr.includes(together)) {
      scheduleArr.push(together);
    }
  }

  var data = {
    AddSchedule: Type === "FromEdit" ? EditNewScheduleArr : scheduleArr,
    together: together,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      var newItem = $(response);

      if (Type === "FromEdit") {
        EditNewScheduleArr.forEach(function (specId) {
          if ($("#InformationFieldDoctorScheduleEdit").find("[data-specid='" + specId + "']").length === 0) {
            $("#InformationFieldDoctorScheduleEdit").append(newItem.filter("[data-specid='" + specId + "']"));
          }
        });
      }
      else {
        $(".InformationFieldAddSchedule").html(response);
      }
    },
  });
}

function formatTime(time) {
  const [hours, minutes] = time.split(":");
  const period = hours >= 12 ? "PM" : "AM";
  const formattedHours = hours % 12 || 12; 
  return `${formattedHours}:${minutes}${period}`;
}


function AddSecretary(Type) {
  const DoctorsSecretaryName = Type === "FromEdit" ? $("#DoctorsSecretaryNameEdit").val() : $("#DoctorsSecretaryName").val();
  const SecretaryMobile1 = Type === "FromEdit" ? $("#SecretaryMobile1Edit").val() : $("#SecretaryMobile1").val();
  const SecretaryMobile2 = Type === "FromEdit" ? $("#SecretaryMobile2Edit").val() : $("#SecretaryMobile2").val();
  const selectNetwork1 = Type === "FromEdit" ? $("#selectNetwork1Edit").val() : $("#selectNetwork1").val();
  const selectNetwork2 = Type === "FromEdit" ? $("#selectNetwork2Edit").val() : $("#selectNetwork2").val();

  const formattedMobile1 = `'${SecretaryMobile1}'`; 
  const formattedMobile2 = `'${SecretaryMobile2}'`; 

  const secretaryObject = {
    name: DoctorsSecretaryName,
    number: SecretaryMobile1,
    number2: SecretaryMobile2,
    network: selectNetwork1,
    network2: selectNetwork2,
  };

  const exists = Type === "FromEdit" ? EditedNewSecretaryArr.some(
    (item) =>
      item.name === secretaryObject.name &&
      item.number === secretaryObject.number &&
      item.network === secretaryObject.network &&
      item.number2 === secretaryObject.number2 &&
      item.network2 === secretaryObject.network2
  ) : 
  secretaryArr.some(
    (item) =>
      item.name === secretaryObject.name &&
      item.number === secretaryObject.number &&
      item.network === secretaryObject.network &&
      item.number2 === secretaryObject.number2 &&
      item.network2 === secretaryObject.network2
  );

  if (!exists) {
    if (Type === "FromEdit") {
      EditedNewSecretaryArr.push(secretaryObject);
    } else {
      secretaryArr.push(secretaryObject);
    }
  } else {
    console.warn("This Secretary already exists:", secretaryObject);
  }
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: { AddSecretary: Type === "FromEdit" ? EditedNewSecretaryArr : secretaryArr,
            Type: Type,
          },
    success: function (response) {

      if (Type === "FromEdit") {
        var newItem = $(response);

        EditedNewSecretaryArr.forEach(function (secretaryObject) {
          var specId = secretaryObject.number;
         if ($("#InformationFieldAddSecretaryEdit").find("[data-specid='" + specId + "']").length === 0) {
              $("#InformationFieldAddSecretaryEdit").append(newItem.filter("[data-specid='" + specId + "']"));
            }
          });

        $("#DoctorsSecretaryNameEdit").val("");
        $("#SecretaryMobile1Edit").val("");
        $("#selectNetwork1Edit").val("");
        $("#SecretaryMobile2Edit").val("");
        $("#selectNetwork2Edit").val("");

      } else {
        $(".InformationFieldAddSecretary").html(response);

        $("#DoctorsSecretaryName").val("");
        $("#SecretaryMobile1").val("");
        $("#SecretaryMobile2").val("");
        $("#selectNetwork1").val("-");
        $("#selectNetwork2").val("-");
      }
      
    },
  });
}

function UpdateDoctorDB(UpdateType, DoctorID){
  var EditLastname = $("#EditLastName").val();
  var EditFirstname = $("#EditFirstName").val();
  var EditMiddlename = $("#EditMiddleName").val();
  var EditGender = $("#EditGender").val();
  var EditCategory = $("#EditCategory").val();
  var EditRemarks = $("#EditDoctorsRemarks").val();
  var EditTele = $("#EditDoctorsTeleConsult").val();
  
  var data = {
    UpdateDoctorType: UpdateType,
    DoctorID: DoctorID,
    UserID: UserID,
    EditLastname: EditLastname,
    EditFirstname: EditFirstname,
    EditMiddlename: EditMiddlename,
    EditGender: EditGender,
    EditCategory: EditCategory,
    EditRemarks: EditRemarks,
    EditTele: EditTele,
    EditSecretary: JSON.stringify(EditedNewSecretaryArr),

    RemovedSpecs: JSON.stringify(RemovedSpecsFromEdit),
    RemovedSubSpecs: JSON.stringify(RemovedSubSpecsFromEdit),
    RemovedRoom: JSON.stringify(RemovedRoom),
    RemovedHMO: JSON.stringify(RemovedHMO),
    RemovedSchedule: JSON.stringify(RemovedSchedule),
    EditedNewSpecs: JSON.stringify(EditSpecializationArr),
    EditNewSubSpecs: JSON.stringify(EditSubSpecializationArr),
    EditedNewRoom: JSON.stringify(EditNewRoomarr),
    EditedNewHMO: JSON.stringify(EditNewHMOarr),
    EditedNewSchedule: JSON.stringify(EditNewScheduleArr),
    EditedNewSecretary: JSON.stringify(RemovedSecretary),
  }; 
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      PopMessages(response)
      $("#Pop-Message").html("Restored successfully!");
      updateChartData();
      updateChartData2();
      setTimeout(function() {
        location.reload();
      }, 1000);
    },
  });
}


function reloadDiv(UpdateDiv){
  $(".tbody-doctor").load(location.href + " .tr-doctor");
  $(".tbodyActivityLogs").load(location.href + " .tr-ActivityLogs");
  $(".tbody-archived").load(location.href + " .tr-archived");
  $(".account-tbody").load(location.href + " .account-tr");

  $("#DashCount1").load(location.href + " #DashCount-1");
  $("#DashCount2").load(location.href + " #DashCount-2");
  $("#DashCount3").load(location.href + " #DashCount-3");
  $("#DashCount4").load(location.href + " #DashCount-4");
  $("#DashCount5").load(location.href + " #DashCount-5");
  $("#DashCount6").load(location.href + " #DashCount-6");
  $("#DashCount7").load(location.href + " #DashCount-7");

  // console.log(UpdateDiv);
  // $("#DIV").load(location.href + " #DashCount-7");
}

// VIEW ACTIVITY LOGS SIDEBAR

function View_ActivityLogs(ViewActivityLogs_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewActivityLogs").css("display", "flex");
  $(".Modal-Container").css("display", "flex");
  $(".Modal-ViewActivityLogs").siblings().css("display", "none");

  var data = {
    ViewActivityLogs_ID: ViewActivityLogs_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      $(".Modal-ViewActivityLogs").html(response);
      // console.log(response);
    },
  });
}





//Additional CRUD for HMO, Room, Specialization, Sub-specialization 

//HMO 
//ADD HMO MODAL 
function AddHMO() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-AddHMO").css("display", "flex");
  $(".Modal-AddHMO").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

//ADD HMO PROMPT 
function AddNewHMO() {
  const name = $("#HMOName").val();

  if (name === "") {
    $("#HMOWarningAdd").html("Please enter HMO name.");
    return;
  }
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AddHMO").css("display", "flex");
  $(".Prompt-AddHMO").siblings().css("display", "none");
}

//IF YES ADD HMO 
function Yes_AddHMO(AddHMO) {
  PopMessages();
  var data = {
    AddHMO: AddHMO,
    HMOName: $("#HMOName").val(),
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#Pop-Message").html("The data has successfully added!");
    },
  });
}

//EDIT HMO - FUNCTION 
function EditHMO(EditHMO_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditHMO").css("display", "flex");
  $(".Modal-EditHMO").siblings().css("display", "none");

  selectedID = EditHMO_ID;

  var data = {
    EditHMO_ID: EditHMO_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".Modal-EditHMO").html(response);
    },
  });
}

//IF YES EDIT HMO 
let HMO_ID = '';
function PromptHMO(PromptHMO_ID) {
  const newEditHMOName = $("#EditHMOName").val();
  
  if (newEditHMOName === "") {
    $("#NewEditHMOWarning").html("Please enter HMO name.");
    return;
  }

  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-EditHMO").css("display", "flex");
  $(".Prompt-EditHMO").siblings().css("display", "none");
  HMO_ID = PromptHMO_ID; 
  // console.log(HMO_ID);
}

function Yes_EditHMO(Yes_EditHMO) {
  var NewHMOName = $("#EditHMOName").val();

  PopMessages();
  var data = {
    Yes_EditHMO: Yes_EditHMO,
    NewHMOName: NewHMOName,
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $("#Pop-Message").html("The data has successfully updated!");
    },
  });
}



//ROOM
//ADD ROOM MODAL 
function AddRoom() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-Room").css("display", "flex");
  $(".Modal-Room").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

//ADD ROOM PROMPT 
function AddNewRoom() {
  const floorLevel = $("#FloorLevel").val();
  const roomNumber = $("#RoomNumber").val();

  let warningMessage = false;

  if (floorLevel === "") {
    $("#FloorlevelAddNewWarning").html("Please enter Floor Level.");
    warningMessage = true;
  }
  if (roomNumber === "") {
    $("#RoomNumberAddNewWarning").html("Please enter Room Number.");
    warningMessage = true;
  }
  if (warningMessage) {
    return;
  }

  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AddRoom").css("display", "flex");
  $(".Prompt-AddRoom").siblings().css("display", "none");
}

//IF YES ADD ROOM 
function Yes_AddRoom(AddRoom) {
  PopMessages();
  var data = {
    AddRoom: AddRoom,
    FloorLevel: $("#FloorLevel").val(),
    RoomNumber: $("#RoomNumber").val(),
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#Pop-Message").html("The data has successfully added!");
    },
  });
}

//EDIT ROOM - FUNCTION 
function EditRoom(EditRoom_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditRoom").css("display", "flex");
  $(".Modal-EditRoom").siblings().css("display", "none");

  selectedID = EditRoom_ID;

  var data = {
    EditRoom_ID: EditRoom_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".Modal-EditRoom").html(response);
    },
  });
}

//IF YES EDIT ROOM
let Room_ID = '';
function PromptRoom(PromptRoom_ID) {
  var newEditRoomFloorLevel = $("#EditRoomName").val();

  if (newEditRoomFloorLevel === "") {
    $("#NewEditRoomWarning").html("Please enter Room name.");
    return;
  }

  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-EditRoom").css("display", "flex");
  $(".Prompt-EditRoom").siblings().css("display", "none");
  Room_ID = PromptRoom_ID; 
  // console.log(HMO_ID);
}

function Yes_EditRoom(Yes_EditRoom_ID) {
  var NewRoomName = $("#EditRoomName").val();

  PopMessages();
  var data = {
    Yes_EditRoom_ID: Yes_EditRoom_ID,
    NewRoomName: NewRoomName,
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $("#Pop-Message").html("The data has successfully updated!");
    },
  });
}



//SPECIALIZATION 

//ADD SPECIALIZATION 
function AddSpecialization() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-Specialization").css("display", "flex");
  $(".Modal-Specialization").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

//ADD SPECIALIZATION PROMPT 
function AddNewSpecialization() {
  var NewSpecialization = $("#Specialization_ToBeAdd").val();

  if (NewSpecialization === "") {
    $("#SpecializationAddNewWarning").html("Please enter Specialization name.");
    return;
  }


  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AddSpecialization").css("display", "flex");
  $(".Prompt-AddSpecialization").siblings().css("display", "none");
}

//IF YES ADD NEW SPECIALIZATION
function Yes_AddSpecialization(AddSpecialization) {
  PopMessages();
  var data = {
    AddSpecialization: AddSpecialization,
    SpecializationNameToBeAdded: $("#Specialization_ToBeAdd").val(),
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#Pop-Message").html("The data has successfully added!");
    },
  });
}

//EDIT ROOM - FUNCTION 
function EditSpecialization(EditSpecialization_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditSpecialization").css("display", "flex");
  $(".Modal-EditSpecialization").siblings().css("display", "none");

  selectedID = EditSpecialization_ID;

  var data = {
    EditSpecialization_ID: EditSpecialization_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".Modal-EditSpecialization").html(response);
    },
  });
}

//IF YES EDIT SPECIALIZATION
let Specialization_ID = '';
function PromptSpecialization(PromptSpecialization_ID) {
  var EditSpecializationNameEdit = $("#EditSpecializationName").val();

  if (EditSpecializationNameEdit === "") {
    $("#NewEditSpecializationWarning").html("Please enter Specialization name.");
    return;
  }

  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-EditSpecialization").css("display", "flex");
  $(".Prompt-EditSpecialization").siblings().css("display", "none");
  Specialization_ID = PromptSpecialization_ID; 
  // console.log(Specialization_ID);
}

function Yes_EditSpecialization(Yes_EditSpecialization_ID) {
  var NewSpecializationName = $("#EditSpecializationName").val();

  PopMessages();
  var data = {
    Yes_EditSpecialization_ID: Yes_EditSpecialization_ID,
    NewSpecializationName: NewSpecializationName,
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $("#Pop-Message").html("The data has successfully updated!");
    },
  });
}




//SUB-SPECIALIZATION 

//ADD SUB-SPECIALIZATION 
function AddSubSpecialization() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-SubSpecialization").css("display", "flex");
  $(".Modal-SubSpecialization").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

//ADD SUB-SPECIALIZATION PROMPT 
function AddNewSubSpecialization() {
  var NewSubSpecialization = $("#SubSpecializationToAdd").val();

  if (NewSubSpecialization === "") {
    $("#SubSpecsWarningAdd").html("Please enter Sub-Specialization name.");
    return;
  }


  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AddSubSpecialization").css("display", "flex");
  $(".Prompt-AddSubSpecialization").siblings().css("display", "none");
}

//IF YES ADD NEW SUB-SPECIALIZATION
function Yes_AddSubSpecialization(AddSubSpecialization) {
  PopMessages();
  var data = {
    AddSubSpecialization: AddSubSpecialization,
    SubSpecializationNameToBeAdded: $("#SubSpecializationToAdd").val(),
    SubSpecializationToDepend: $("#SubSpecializationToDepend").val(),
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $("#Pop-Message").html("The data has successfully added!");
    },
  });
}

//FOR REMOVAL OF EXISITING DATA ARRAY

let RemovedSubSpecsFromEdit = [];
let RemovedRoom = [];
let RemovedHMO = [];
let RemovedSchedule = [];
let RemovedSecretary = [];

//REGEX FOR DAY AND TIME VALIDATION
function isValidDayTime(value) {
  const regex = /^(Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday),\s(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)\s-\s(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)$/i;
  return regex.test(value);

}
//funtion to remove selected items from the list and array
function removeSelected(iconElement, specId, arrayType) {
  const itemDiv = iconElement.closest(".ClickableList");
  if (itemDiv) itemDiv.remove();

  if (arrayType === "DeleteSecretary") {
    if (EditedNewSecretaryArr.length > 0) {

      const index = EditedNewSecretaryArr.findIndex(secretary => secretary.number == specId);
      if (index !== -1) {
        EditedNewSecretaryArr.splice(index, 1);
      }
      
    }
    const itemDiv = iconElement.closest(".ClickableLists");
    if (itemDiv) itemDiv.remove();
    RemovedSecretary.push(specId);
    
    return;
  }

  if (isValidDayTime(specId) === true) {
    if (arrayType === "schedule") {
      const index = scheduleArr.indexOf(specId);
      const indexEdit = EditNewScheduleArr.indexOf(specId);
      if (indexEdit !== -1) {
        EditNewScheduleArr.splice(indexEdit, 1);
      }
      if (index !== -1) {
        scheduleArr.splice(index, 1);
      }
    } 
    return; 
  } else {
    specId = parseInt(specId, 10);
  }

  if (arrayType === "SubSpecs") {
    const index = selectedIds2.indexOf(specId);
    if (index !== -1) {
      selectedIds2.splice(index, 1);
    }
  } 
  else if (arrayType === "Specs") {
    const index = selectedIds.indexOf(specId);
    if (index !== -1) {
        selectedIds.splice(index, 1);
      }
  } 
  else if (arrayType === "Room") {
      const index = roomArr.indexOf(specId);
      if (index !== -1) {
        roomArr.splice(index, 1);
      }
  }
  else if (arrayType === "HMO") {
      const index = hmoArr.indexOf(specId);
      if (index !== -1) {
        hmoArr.splice(index, 1);
      }
  }
  else if (arrayType === "schedule") {
      const index = scheduleArr.indexOf(specId);
      if (index !== -1) {
        scheduleArr.splice(index, 1);
      }
  }
  else if (arrayType === "addsec") {
    const index = secretaryArr.findIndex(secretary => secretary.number == specId);
    if (index !== -1) {
      secretaryArr.splice(index, 1);
    }
    const itemDiv = iconElement.closest(".SecretaryCard");
    if (itemDiv) itemDiv.remove();
  }
  // for edit function
  else if (arrayType === "RemoveFromEdit") {
    RemovedSpecsFromEdit.push(specId);
  }
  else if (arrayType === "RemoveFromEditSubSpecs") {
    RemovedSubSpecsFromEdit.push(specId);
  }
  else if (arrayType === "RemoveFromEditRoom") {
    RemovedRoom.push(specId);
  }
  else if (arrayType === "RemoveFromEditHMO") {
    RemovedHMO.push(specId);
  }
  else if (arrayType === "RemoveFromEditSchedule") {
    RemovedSchedule.push(specId);
  }

  //for removed from existing data
  else if (arrayType === "EditSpecs") {
    const index = EditSpecializationArr.indexOf(specId);
    if (index !== -1) {
        EditSpecializationArr.splice(index, 1);
      }
  }
  else if (arrayType === "EditSubSpecs") {
    const index = EditSubSpecializationArr.indexOf(specId);
    if (index !== -1) {
        EditSubSpecializationArr.splice(index, 1);
      }
  }
  else if (arrayType === "EditRoom") { 
    const index = EditNewRoomarr.indexOf(specId);
    if (index !== -1) {
        EditNewRoomarr.splice(index, 1);
      }
  }
  else if (arrayType === "EditHMO") {
    const index = EditNewHMOarr.indexOf(specId);
    if (index !== -1) {
        EditNewHMOarr.splice(index, 1);
      }
  }

}

function EditSubSpecialization(EditSubSpecialization_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditSubSpecialization").css("display", "flex");
  $(".Modal-EditSubSpecialization").siblings().css("display", "none");

  selectedID = EditSubSpecialization_ID;

  var data = {
    EditSubSpecialization_ID: EditSubSpecialization_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $(".Modal-EditSubSpecialization").html(response);
    },
  });
}

//IF YES EDIT SUB-SPECIALIZATION
let Sub_Specialization_ID = '';
function PromptSubSpecialization(PromptSubSpecialization_ID) {
  var EditSubSpecializationName = $("#EditSubSpecializationName").val();

  if (EditSubSpecializationName === "") {
    $("#NewEditSubSpecializationWarning").html("Please enter Sub-Specialization name.");
    return;
  }


  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-EditSubSpecialization").css("display", "flex");
  $(".Prompt-EditSubSpecialization").siblings().css("display", "none");
  Sub_Specialization_ID = PromptSubSpecialization_ID; 
  console.log(Sub_Specialization_ID);
}

function Yes_EditSubSpecialization(Yes_EditSubSpecialization_ID) {
  var NewSubSpecializationName = $("#EditSubSpecializationName").val();
  var NewSelectedSpecialization = $("#NewSpecForSubSpec").val();

  PopMessages();
  var data = {
    Yes_EditSubSpecialization_ID: Yes_EditSubSpecialization_ID,
    NewSubSpecializationName: NewSubSpecializationName,
    NewSelectedSpecialization: NewSelectedSpecialization,
    UserID: UserID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      $("#Pop-Message").html("The data has successfully updated!");
    },
  });
}
function editAdminName(){
  $("#Edit-Account-PopUpID").css("display", "block");

}
function HideEditAccountPopUp(){
  $("#Edit-Account-PopUpID").css("display", "none");
}
