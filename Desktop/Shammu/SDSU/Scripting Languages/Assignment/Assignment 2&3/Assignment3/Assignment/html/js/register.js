$(document).ready(function() {
  var errorStatusHandle = $('#message_line');
  var elementHandle = new Array();
  elementHandle[0] = $('[name="first_name"]');
  elementHandle[1] = $('[name="last_name"]');
  elementHandle[2] = $('[name="email"]');
  elementHandle[3] = $('[name="password1"]')
  elementHandle[4] = $('[name="password2"]')
  
  function handleAnswer(answer) {
    if($.trim(answer) == "OK")  {
      var params = $('form').serialize();
      send_file_parent();
    }
    else if ($.trim(answer) == "PDUP") {
      var params = $('form').serialize();
      send_file_child();
    }   
    else if ($.trim(answer) == "CDUP")
      $('#status').html("ERROR, Duplicate");
    else
      $('#status').html("Database error");        
  }

function isEmpty(fieldValue) {
  return $.trim(fieldValue).length == 0;    
}

function isEmail(fieldValue) {
  var re = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i;
  return re.test(fieldValue);
}

function isPassword() {
  
    var pass = $('input[name=password1]').val();
    var repass = $('input[name=password2]').val();
    var result = true;
    if(($('input[name=password1]').val().length == 0) || ($('input[name=password2]').val().length == 0)){
        result = false;
    }
    else if (pass != repass) {
        result = false;
    }
    return result;
} 

    $("#fname").focus();
    
    $('.name').on('input', function() {

      var input=$(this);
      var name=$.trim(input.val());
      if(!name) {
        input.removeClass("valid invalid border_invalid");
      }
      else {
        if(!isEmpty(name)){
          input.removeClass("invalid").addClass("valid");
          errorStatusHandle.text("");
        }
        else{
          input.removeClass("valid").addClass("invalid");
        }
      }
    });


    
    <!--Email must be an email -->
    $('#email').on('input', function() {
      var input=$(this);
      var email=$.trim(input.val());
      if(!email) {
        input.removeClass("invalid valid border_invalid");
      }
      else {
        if(isEmail(email)) {
          input.removeClass("invalid").addClass("valid");
          errorStatusHandle.text("");
        }
        else {
          input.removeClass("valid").addClass("invalid");
        }
      }
    });

  function isValidData() {
    
    if(isEmpty($.trim(elementHandle[0].val()))) {
      elementHandle[0].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the First Name");
      elementHandle[0].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[1].val()))) {
      elementHandle[1].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Last Name");
      elementHandle[1].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[2].val()))) {
      elementHandle[2].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the email id");
      elementHandle[2].focus();            
      return false;
    }
    if(!isEmail($.trim(elementHandle[2].val()))) {
      elementHandle[2].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid email id");
      elementHandle[2].focus();            
      return false;
    }

    if(isEmpty($.trim(elementHandle[3].val()))) {
      elementHandle[3].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the password");
      elementHandle[3].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[4].val()))) {
      elementHandle[4].addClass("border_invalid");
      errorStatusHandle.text("*Please retype the password");
      elementHandle[4].focus();            
      return false;
    }
    if(!isPassword()) {
      elementHandle[3].addClass("border_invalid");
      elementHandle[4].addClass("border_invalid");
      errorStatusHandle.text("*Passwords did not match! Please enter them again");
      elementHandle[3].focus();            
      return false;
    }

    // alert("End");
    return true;
  }       
  $(':submit').on('click', function(e) {
    for(var i=0; i <= 4; i++)
      elementHandle[i].removeClass("border_invalid invalid valid border_valid");
    errorStatusHandle.text("");
    if(isValidData()) {
      // var params = "email=" + $("[name='pemail']").val() +
      // "&first_name=" + $("[name='fname']").val();         
      // params = encodeURI(params);  
      //    alert(params);           
      //   var req = new HttpRequest('ajax_check_dups.php?'+params,
      //     handleAnswer);
        var req = new HttpRequest('register.php');
        req.send();
        e.preventDefault();
      }
      else
        return isValidData();
    });

  $(':reset').on('click', function() {
    for(var i=0; i <= 4; i++)
      elementHandle[i].removeClass("border_invalid invalid valid border_valid");
    errorStatusHandle.text("");
    elementHandle[0].focus(); 
  });
});


