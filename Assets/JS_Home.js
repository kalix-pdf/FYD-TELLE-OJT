

var screenWidth = $(window).width();
var screenHeight = $(window).height();
// console.log("Screen width: " + screenWidth);
// console.log("Screen height: " + screenHeight);

$(document).ready(function(){
  $(".TodayBtn1").click(function(){
    $('.TodayBtn1').addClass("TodayBtnActive");
    $(".TodayBtn1").siblings().removeClass("TodayBtnActive");
  })
  $(".TodayBtn2").click(function(){
    $('.TodayBtn2').addClass("TodayBtnActive");
    $(".TodayBtn2").siblings().removeClass("TodayBtnActive");
  })
  $(".HomeMain-Modal").click(function(e){
    if($(e.target).hasClass('HomeMain-Modal')){
      $(this).hide();
      if(screenWidth <= 600){
        $(".FilterFloat").toggle(400);
      }
    }
  });
  $(".SearchDoctorModal").click(function(e){
    if($(e.target).hasClass('SearchDoctorModal')){
      $(this).hide();
    }
  });

  const myTimeout = setTimeout(timer2, 500);
  function timer2() {
    if($(window).width() <= 600) {
      $('.Banner_Div1FlexTitle').css("display", "none");
    } else {
      $('.Banner_Div1FlexTitle').css("display", "flex");
    }
  }
  const myTimeout2 = setTimeout(timer, 1000);
  function timer() {
    $('.Banner_Div2-Border').css("display", "flex");
  }
// =============================================================
  $(".ModalDivConPanelDiv").click(function(){
    if($(this).find(".fa-square").length > 0){
      $(this).find(".SDay").prop("checked", true);
      $(this).find(".fa-regular").removeClass("fa-square");
      $(this).find(".fa-regular").addClass("fa-square-check");
      $(this).css({"background-color": "#E0544F", "color": "white", "font-weight": "600"});      
    }
    else{
      $(this).find(".SDay").prop("checked", false);
      $(this).find(".fa-regular").removeClass("fa-square-check");
      $(this).find(".fa-regular").addClass("fa-square");
      $(this).css({"background-color": "white", "color": "black", "font-weight": "400"});
    }
    itemsArray = [];
    $(".SDay:checked").each(function() {
        itemsArray.push($(this).val());
    });
    var result = itemsArray.join("'-'");
    var text = JSON.stringify(result);
    var newText = text.replace(/[\[\],"]/g, '');
    $(".TextBoxFilter6").val(newText);
    
    itemsArrayDay2 = [];
    $(".SDay:checked").each(function() {
      itemsArrayDay2.push($(this).val());
    });
    var resultDay2 = itemsArrayDay2.join(", ");
    $(".TextBoxFilter6_2").val(resultDay2);
    FilterALl('Filter');
    $('.SearchPlaceholder6').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
  })

  $(".TodayBtn2").click(function(){
    $('.TodayBtn2').addClass("TodayBtnActive");
    $(".TodayBtn2").siblings().removeClass("TodayBtnActive");
  })
  

  $(".FilterFloatDivContainer0").click(function(){
    $('.FilterMobContainer').css("display","flex");
    $('.FilterFloatDivContainer1').css("display","flex");
    $('.FilterFloatDivContainer0').css("display","none");
  });
  $(".HideFilter").click(function(){

    $('.Main_Div2').addClass("Main_Div2Key");
    $('.FilterFloatDivContainer1').addClass("FilterFloatDivContainer1Key");
    
    const myTimeout = setTimeout(timer, 400);
    function timer() {
      $('.SearchDoctorModal').css("display","none");
      $('.FilterMobContainer').css("display","none");
      $('.FilterFloatDivContainer0').css("display","flex");
      $('.FilterFloatDivContainer1').css("display","none");
      $('.Main_Div2').removeClass("Main_Div2Key");
      $('.FilterFloatDivContainer1').removeClass("FilterFloatDivContainer1Key");
    }
  });


  
})








// FUNCTION ===============
function functionHMO(functionHMOId){
  if($(".HMO_ID_" + functionHMOId).find(".fa-square").length > 0){
    $(".HMO_ID_" + functionHMOId).find(".HMOOName").prop("checked", true);
    $(".HMO_ID_" + functionHMOId).find(".HMOOName2").prop("checked", true);
    $(".HMO_ID_" + functionHMOId).find(".fa-regular").removeClass("fa-square");
    $(".HMO_ID_" + functionHMOId).find(".fa-regular").addClass("fa-square-check");
    $(".HMO_ID_" + functionHMOId).css({"background-color": "#E0544F", "color": "white", "font-weight": "600"});    
  }
  else{
    $(".HMO_ID_" + functionHMOId).find(".HMOOName").prop("checked", false);
    $(".HMO_ID_" + functionHMOId).find(".HMOOName2").prop("checked", false);
    $(".HMO_ID_" + functionHMOId).find(".fa-regular").removeClass("fa-square-check");
    $(".HMO_ID_" + functionHMOId).find(".fa-regular").addClass("fa-square");
    $(".HMO_ID_" + functionHMOId).css({"background-color": "white", "color": "black", "font-weight": "400"});
  }
  

    itemsArray2 = [];
    $(".HMOOName:checked").each(function() {
        itemsArray2.push($(this).val());
    });
    var result = itemsArray2.join("'-'");
    var text = JSON.stringify(result);
    var newText = text.replace(/[\[\],"]/g, '');
    $(".TextBoxFilter4").val(newText);

    itemsArrayName = [];
    $(".HMOOName2:checked").each(function() {
        itemsArrayName.push($(this).val());
    });
    var result2 = itemsArrayName.join(", ");
    $(".TextBoxFilter4_2").val(result2);
    $(".HMOArrP").html(result2);
    FilterALl('Filter'); 
    $('.SearchPlaceholder4').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
}

function ScreenModalToggle(){
  if(screenWidth <= 600){
    $(".FilterFloat").toggle(400);
  }
}

function CloseDoctor(){
  $('.HomeMain-Modal').css("display","none");
  ScreenModalToggle();
}

function showHiddenFilter(){
  $('.HiddenFilter').toggle(400);
  $('.HiddenFilter').css("display","flex");
}

function OpenHMOAccreditationModal(){
  $('.HiddenFilter').toggle(400);
  $('.SearchDoctorModal').css("display","flex");
}

function CloseMainSpecialization(){
  $('.SearchDoctorModal').css("display","none");
}

function Loading(){
  const myTimeout = setTimeout(timer, 0);
  function timer() {
    $('.LoadingDiv1').css("display", "flex");
  }
}
function LoadingHide(){
  const myTimeout = setTimeout(timer, 0);
  function timer() {
    $('.LoadingDiv1').css("display", "none");
  }
}

function TelecastDiv(LinkAddress){
  // LinkAddress = "https://chatgpt.com/"; 
  window.open(LinkAddress, '_blank');
}


function FunctionClearText1(){
  FunctionClearText();
  FunctionClearText3();
}
function FunctionClearText2(){
  FunctionClearText();
}
function FunctionClearText3(){
  $('#InputSearchPlaceholder').val("");
}

function FunctionClearText(){
  $(".TextBoxFilter1").val("");
  $(".TextBoxFilter2").val("");
  $(".TextBoxFilter3").val("");
  $(".TextBoxFilter4").val("");
  $(".TextBoxFilter5").val("");
  $(".TextBoxFilter6").val("");
  $(".TextBoxFilter4_2").val("");
  $(".TextBoxFilter6_2").val("");
  
  $(".ModalDivConPanelDiv").find(".SDay").prop("checked", false);
  $(".ModalDivConPanelDiv").find(".fa-regular").removeClass("fa-square-check");
  $(".ModalDivConPanelDiv").find(".fa-regular").addClass("fa-square");
  $(".ModalDivConPanelDiv").css({"background-color": "white", "color": "black", "font-weight": "400"});

  $(".ModalDivConPanelDiv2").find(".SDay").prop("checked", false);
  $(".ModalDivConPanelDiv2").find(".fa-regular").removeClass("fa-square-check");
  $(".ModalDivConPanelDiv2").find(".fa-regular").addClass("fa-square");
  $(".ModalDivConPanelDiv2").css({"background-color": "white", "color": "black", "font-weight": "400"});
    
  $('.SearchPlaceholder1').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
  $('.SearchPlaceholder2').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
  $('.SearchPlaceholder3').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
  $('.SearchPlaceholder4').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
  $('.SearchPlaceholder5').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
  $('.SearchPlaceholder6').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});

  $('.TodayBtn1').addClass("TodayBtnActive");
  $(".TodayBtn1").siblings().removeClass("TodayBtnActive");
}


function OpenSearchModal1(){
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon1').css("display","flex");
  $(".ModalDivCon1").siblings().css("display","none");
}
function OpenSearchModal2(){
  SpecsEmpty = $(".TextBoxFilter1").val();
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon2').css("display","flex");
  $(".ModalDivCon2").siblings().css("display","none");
}
function OpenSearchModal3(){
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon3').css("display","flex");
  $(".ModalDivCon3").siblings().css("display","none");
}
function OpenSearchModal4(){
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon4').css("display","flex");
  $(".ModalDivCon4").siblings().css("display","none");
}
function OpenSearchModal5(){
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon5').css("display","flex");
  $(".ModalDivCon5").siblings().css("display","none");
}
function OpenSearchModal6(){
  $('.SearchDoctorModal').css("display","flex");
  $('.ModalDivCon6').css("display","flex");
  $(".ModalDivCon6").siblings().css("display","none");
}


function ClearTxtField1(){
  $('.TextBoxFilter1').val("");
  $('#refSpecsID').val("");
  FilterALl('Filter');
  $('.SearchPlaceholder1').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}
function ClearTxtField2(){
  $('.TextBoxFilter2').val("");
  FilterALl('Filter');
  $('.SearchPlaceholder2').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}
function ClearTxtField3(){
  $('.TextBoxFilter4_2').val("");
  $('.TextBoxFilter4').val("");
  $(".ModalDivConPanelDiv2").find(".SDay").prop("checked", false);
  $(".ModalDivConPanelDiv2").find(".fa-regular").removeClass("fa-square-check");
  $(".ModalDivConPanelDiv2").find(".fa-regular").addClass("fa-square");
  $(".ModalDivConPanelDiv2").css({"background-color": "white", "color": "black", "font-weight": "400"});
  FilterALl('Filter');
  $('.SearchPlaceholder4').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}
function ClearTxtField4(){
  $('.TextBoxFilter6_2').val("");
  $('.TextBoxFilter6').val("");
  $(".ModalDivConPanelDiv").find(".SDay").prop("checked", false);
  $(".ModalDivConPanelDiv").find(".fa-regular").removeClass("fa-square-check");
  $(".ModalDivConPanelDiv").find(".fa-regular").addClass("fa-square");
  $(".ModalDivConPanelDiv").css({"background-color": "white", "color": "black", "font-weight": "400"});
  FilterALl('Filter');
  $('.SearchPlaceholder6').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}
function ClearTxtField5(){
  $('.TextBoxFilter3').val("");
  FilterALl('Filter');
  $('.SearchPlaceholder3').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}
function ClearTxtField6(){
  $('.TextBoxFilter5').val("");
  FilterALl('Filter');
  $('.SearchPlaceholder5').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
}


function TeleText(TeleText){
  $('.SearchDoctorModal').css("display","none");
  $('.TextBoxFilter5').val(TeleText);
  FilterALl('Filter');
  $('.SearchPlaceholder5').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
}







// AJAX ===============
function SearchDoctor(SearchDoc){
  FunctionClearText2();
  var data = {
    SearchDoc: SearchDoc,
    SearchDocID: $('.InputSearchDoc').val(), 
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
      LoadingHide();
      
    }
  });
}

function SearchDoctor2(SearchDoc){
  FunctionClearText2();
  var data = {
    SearchDoc: SearchDoc,
    SearchDocID: $('.InputSearchDoc2').val(), 
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
      LoadingHide();
    }
  });
}

function ClearText(Reload){
  FunctionClearText1();
  var data = {
    Clear1: Reload,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
      LoadingHide();
    }
  });
}

function ClearText2(Reload){
  $('#InputSearchPlaceholder2').val("");
  var data = {
    Clear1: Reload,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
      LoadingHide();
    }
  });
}

function SearchSpecs(SearchSpecs){
  var data = {
    SearchDocSpecs: $('.InputSpecialization').val(), 
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.DoctorsSpecsList').html(response);
    }
  });
}

function SearchSubSpecs(SearchSubSpecs){
  var data = {
    SearchSubSpecs2: $('.InputSubSpecialization').val(), 
    InputSpecialization: $('.TextBoxFilter1').val(), 
    refSpecsID: $('#refSpecsID').val(),
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      console.log(response);
      $('.doctor_sub_specializationDiv').html(response);
    }
  });
}

function SearchHMO(SearchHMO){
  var data = {
    SearchHMO: $('.InputSearchHMO').val(), 
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.doctor_HMODiv').html(response);
    }
  });
}

function BtnALlDocFilter(BtnDocFill){
  FunctionClearText1();
  var data = {
    BtnDocFill: BtnDocFill,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
      LoadingHide();

      $('.Main_Div2').addClass("Main_Div2Key");
      $('.FilterFloatDivContainer1').addClass("FilterFloatDivContainer1Key");
      
      const myTimeout = setTimeout(timer, 400);
      function timer() {
        $('.SearchDoctorModal').css("display","none");
        $('.FilterMobContainer').css("display","none");
        $('.FilterFloatDivContainer0').css("display","flex");
        $('.FilterFloatDivContainer1').css("display","none");
        $('.Main_Div2').removeClass("Main_Div2Key");
        $('.FilterFloatDivContainer1').removeClass("FilterFloatDivContainer1Key");
      }
    }
  });
}

function ViewDoctor(DID){
  if(screenWidth <= 600){
    $(".FilterFloat").toggle(400);
  }
  var data = {
    DoctorID: DID,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.HomeMain-Modal').css("display","flex");
      $('.HomeMain-Modal').html(response);
    }
  });
}

function SelectSpecs(SelectSpecsID){
  $('#InputSearchPlaceholder').val("");
  $('.TodayBtn1').addClass("TodayBtnActive");
  $(".TodayBtn1").siblings().removeClass("TodayBtnActive");
  $(".TextBoxFilter2").val("");
  SpecsID = $("#SpecsID_"+SelectSpecsID).html();
  var data = {
    SelectSpecsID: SelectSpecsID,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.doctor_sub_specializationDiv').html(response);
      $('.SearchDoctorModal').css("display","none");
      $('.TextBoxFilter1').val(SpecsID);
      $('#refSpecsID').val(SelectSpecsID);
      FilterALl("FillAll");
      $('.SearchPlaceholder1').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
      $('.SearchPlaceholder2').css({"top":"0px","left":"10px","font-size":"16px","height":"100%","background-color":"#00000000"});
    }
  });
}

function SelectSubSpecs(SelectSubSpecsID){
  $('#InputSearchPlaceholder').val("");
  $('.TodayBtn1').addClass("TodayBtnActive");
  $(".TodayBtn1").siblings().removeClass("TodayBtnActive");
  SubSpecsID = $("#SubsSpecsID_"+SelectSubSpecsID).html();
  console.log(SubSpecsID);
  $('.TextBoxFilter2').val(SubSpecsID);
  // $('.TextBoxFilter2_2').val(SubSpecsID);
  $('.SearchDoctorModal').css("display","none");
  FilterALl("FillAll");
  $('.SearchPlaceholder2').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
}

function SelectSex(SelectSex){
  $('.SearchDoctorModal').css("display","none");
  $('#InputSearchPlaceholder').val("");
  $('.TodayBtn1').addClass("TodayBtnActive");
  $(".TodayBtn1").siblings().removeClass("TodayBtnActive");
  Text3Fill = $(".TextBoxFilter3").val(SelectSex);
  FilterALl(SelectSex);
  $('.SearchPlaceholder3').css({"top":"-10px","left":"-20px","font-size":"12px","height":"fit-content","background-color":"white"});
}

function FilterALl(FilterAll){
  Text1Fill = $(".TextBoxFilter1").val();
  Text2Fill = $(".TextBoxFilter2").val();
  Text3Fill = $(".TextBoxFilter3").val();
  Text4Fill = $(".TextBoxFilter4").val();
  Text5Fill = $(".TextBoxFilter5").val();
  Text6Fill = $(".TextBoxFilter6").val();
  var data = {
    Filter_All: FilterAll,
    Text1Fill: Text1Fill,
    Text2Fill: Text2Fill,
    Text3Fill: Text3Fill,
    Text4Fill: Text4Fill,
    Text5Fill: Text5Fill,
    Text6Fill: Text6Fill,
  };
  $.ajax({
    url: './Components/Function_Home.php',
    type: 'post',
    data: data,
    success: function(response){
      $('.Main_Div1-Section').html(response);
    }
  });
}