$(document).ready(function(){
  
  if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
  }

  const myTimeout = setTimeout(timer2, 4000);
  function timer2() {
    // $('.PopUpMessage').css("display","none");
    $('.PopUpMessage').slideUp();
  }

  


  $('.checkShowPassword').click(function(){
    if('password' == $('.test-input').attr('type')){
         $('.test-input').prop('type', 'text');
    }else{
         $('.test-input').prop('type', 'password');
    }
  });

  $('.checkNewShowPassword').click(function(){
    if ($('.NewPassword').attr('type') === 'password' && $('.test-input').attr('type') === 'password') {
        $('.NewPassword').prop('type', 'text');
        $('.test-input').prop('type', 'text');
    } else {
        $('.NewPassword').prop('type', 'password');
        $('.test-input').prop('type', 'password');
    }
  });
})