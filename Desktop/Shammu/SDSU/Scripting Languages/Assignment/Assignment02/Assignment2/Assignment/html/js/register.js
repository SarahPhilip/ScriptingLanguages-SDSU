$(document).ready(function() {
  var errorStatusHandle = $('#message_line');
  var elementHandle = new Array();
  elementHandle[0] = $('[name="program"]');
  elementHandle[1] = $('[name="fname"]');
  elementHandle[2] = $('[name="lname"]');
  elementHandle[3] = $('[name="mname"]');
  elementHandle[4] = $('[name="nickname"]');
  elementHandle[5] = $('[name="dob"]');
  elementHandle[6] = $('[name="email"]');
  elementHandle[7] = $('[name="gender"]');
  elementHandle[8] = $('[name="photo"]');
  elementHandle[9] = $('[name="relationship"]');
  elementHandle[10] = $('[name="pfname"]');
  elementHandle[11] = $('[name="plname"]');
  elementHandle[12] = $('[name="pmname"]');
  elementHandle[13] = $('[name="pemail"]');
  elementHandle[14] = $('[name="address1"]');
  elementHandle[15] = $('[name="address2"]');
  elementHandle[16] = $('[name="city"]');
  elementHandle[17] = $('[name="state"]');
  elementHandle[18] = $('[name="zipcode"]');
  elementHandle[19] = $('[name="home_phone_area"]');
  elementHandle[20] = $('[name="home_phone_prefix"]');
  elementHandle[21] = $('[name="home_phone"]');
  elementHandle[22] = $('[name="cell_phone_area"]');
  elementHandle[23] = $('[name="cell_phone_prefix"]');
  elementHandle[24] = $('[name="cell_phone"]');
  elementHandle[25] = $('[name="medical_conditions"]');
  elementHandle[26] = $('[name="special_req"]');
  elementHandle[27] = $('[name="ename"]');
  elementHandle[28] = $('[name="emer_cell_phone_area"]');
  elementHandle[29] = $('[name="emer_cell_phone_prefix"]');
  elementHandle[30] = $('[name="emer_cell_phone"]');
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

  function handleAjaxPost(answer) {
    $('#status').html(answer);
  } 

  function send_file_parent() {    
    var form_data = new FormData($('form')[0]);     
    form_data.append("image", document.getElementById("photo").files[0]);
    $.ajax({
      url: 'ajax_file_upload.php', 
      dataType: 'text',  
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,                         
      type: 'post',
      success: function(response) {
        $('#pic').html("");
        if(response == 'File is not an image.') {
          $('#status').html("File is not an image.");
        }
        else if (response == 'Sorry, file already exists.') {
          $('#status').html("Sorry, choose a different image file name.");
        }

        else if (response == 'Sorry, your file is too large.') {
          $('#status').html("Sorry, your file is too large.");
        }
        else if (response == 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.') {
          $('#status').html("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        else if (response == 'Sorry, your file was not uploaded.') {
          $('#status').html("Sorry, your file was not uploaded.");
        }
        else if (response == 'Sorry, there was an error uploading your file.') {
          $('#status').html("Sorry, there was an error uploading your file.");
        }
        else if (response == 'The file has been uploaded.') {
          $('#status').html("The file has been uploaded.");
          var fname = $("#photo").val();
          var toDisplay = "<img src=\"/~jadrn042/proj2-b/uplo_ds/" + fname + "\" />";               
          $('#pic').html(toDisplay);
          var params = 

          "relationship=" + $("[name='relationship']").val() +
          "&pfname=" + $("[name='pfname']").val() +
          "&pmname=" + $("[name='pmname']").val() +
          "&plname=" + $("[name='plname']").val() +
          "&pemail=" + $("[name='pemail']").val() +
          "&address1=" + $("[name='address1']").val() +
          "&address2=" + $("[name='address2']").val() +
          "&city=" + $("[name='city']").val() +
          "&state=" + $("[name='state']").val() +
          "&zipcode=" + $("[name='zipcode']").val() +
          "&home_phone_area=" + $("[name='home_phone_area']").val() +
          "&home_phone_prefix=" + $("[name='home_phone_prefix']").val() +
          "&home_phone=" + $("[name='home_phone']").val() +
          "&cell_phone_area=" + $("[name='cell_phone_area']").val() +
          "&cell_phone_prefix=" + $("[name='cell_phone_prefix']").val() +
          "&cell_phone=" + $("[name='cell_phone']").val() +
          "&program=" + $("[name='program']").val() +
          "&fname=" + $("[name='fname']").val() +
          "&mname=" + $("[name='mname']").val() +
          "&lname=" + $("[name='lname']").val() +
          "&nickname=" + $("[name='nickname']").val() +
          "&dob=" + $("[name='dob']").val() +
          "&gender=" + $("input[name=gender]:checked").val() +
          "&photo=" + $("[name='photo']").val() +
          "&medical_conditions=" + $("[name='medical_conditions']").val() +
          "&special_req=" + $("[name='special_req']").val() +
          "&ename=" + $("[name='ename']").val() +
          "&emer_cell_phone_area=" + $("[name='emer_cell_phone_area']").val() +
          "&emer_cell_phone_prefix=" + $("[name='emer_cell_phone_prefix']").val() +
          "&emer_cell_phone=" + $("[name='emer_cell_phone']").val();         
          params = encodeURI(params);
          $.post('ajax_process_request.php', params,handleAjaxPost);
        }
      },
      error: function(response) {
        alert(response);
        $('#status').css('color','red');
        $('#status').html("Sorry, an upload error occurred, "+response.statusText);
      }
    });

}

function send_file_child() {    
  var form_data = new FormData($('form')[0]);    
  form_data.append("image", document.getElementById("photo").files[0]);
  $.ajax({
    url: 'ajax_file_upload.php',
    dataType: 'text',  
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,                         
    type: 'post',
    success: function(response) {
      $('#pic').html("");
      if(response == 'File is not an image.') {
        $('#status').html("File is not an image.");
      }
      else if (response == 'Sorry, file already exists.') {
        $('#status').html("Sorry, file already exists.");
      }

      else if (response == 'Sorry, your file is too large.') {
        $('#status').html("Sorry, your file is too large.");
      }
      else if (response == 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.') {
        $('#status').html("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
      }
      else if (response == 'Sorry, your file was not uploaded.') {
        $('#status').html("Sorry, your file was not uploaded.");
      }
      else if (response == 'Sorry, there was an error uploading your file.') {
        $('#status').html("Sorry, there was an error uploading your file.");
      }
      else if (response == 'The file has been uploaded.') {
        $('#status').html("The file has been uploaded.");
        var fname = $("#photo").val();
        var toDisplay = "<img src=\"/~jadrn042/proj2-b/uplo_ds/" + fname + "\" />";               
        $('#pic').html(toDisplay);
        var params = "relationship=" + $("[name='relationship']").val() +
        "&pfname=" + $("[name='pfname']").val() +
        "&pmname=" + $("[name='pmname']").val() +
        "&plname=" + $("[name='plname']").val() +
        "&pemail=" + $("[name='pemail']").val() +
        "&address1=" + $("[name='address1']").val() +
        "&address2=" + $("[name='address2']").val() +
        "&city=" + $("[name='city']").val() +
        "&state=" + $("[name='state']").val() +
        "&zipcode=" + $("[name='zipcode']").val() +
        "&home_phone_area=" + $("[name='home_phone_area']").val() +
        "&home_phone_prefix=" + $("[name='home_phone_prefix']").val() +
        "&home_phone=" + $("[name='home_phone']").val() +
        "&cell_phone_area=" + $("[name='cell_phone_area']").val() +
        "&cell_phone_prefix=" + $("[name='cell_phone_prefix']").val() +
        "&cell_phone=" + $("[name='cell_phone']").val() +
        "&program=" + $("[name='program']").val() +
        "&fname=" + $("[name='fname']").val() +
        "&mname=" + $("[name='mname']").val() +
        "&lname=" + $("[name='lname']").val() +
        "&nickname=" + $("[name='nickname']").val() +
        "&dob=" + $("[name='dob']").val() +
        "&gender=" + $("input[name=gender]:checked").val() +
        "&photo=" + $("[name='photo']").val() +
        "&medical_conditions=" + $("[name='medical_conditions']").val() +
        "&special_req=" + $("[name='special_req']").val() +
        "&ename=" + $("[name='ename']").val() +
        "&emer_cell_phone_area=" + $("[name='emer_cell_phone_area']").val() +
        "&emer_cell_phone_prefix=" + $("[name='emer_cell_phone_prefix']").val() +
        "&emer_cell_phone=" + $("[name='emer_cell_phone']").val();         
        params = encodeURI(params);
        $.post('ajax_process_request_child.php', params,handleAjaxPost);
      }

    },
    error: function(response) {
      $('#pic').html("");
      $('#status').css('color','red');
      $('#status').html("Sorry, an upload error occurred, "+response.statusText);
    }
  });

}

function isEmpty(fieldValue) {
  return $.trim(fieldValue).length == 0;    
}

  // Check for valid date
  // Code from : http://www.jquerybyexample.net/2011/12/validate-date-using-jquery.html
  function isDate(txtDate)
  {
    var currVal = txtDate;
    if(currVal == '')
      return false;
    
    //Declare Regex  
    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null)
     return false;
   
    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[1];
    dtDay= dtArray[3];
    dtYear = dtArray[5];

    if (dtMonth < 1 || dtMonth > 12)
      return false;
    else if (dtDay < 1 || dtDay> 31)
      return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
      return false;
    else if (dtMonth == 2)
    {
     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
     if (dtDay> 29 || (dtDay ==29 && !isleap))
      return false;
  }
  return true;
}
  // ------------End of function--------------

  // ------------Check if age>12 and <18 -----
  function isAge(value)
  {
    var dateOfBirth = value;
    var arr_dateText = dateOfBirth.split("/");
    month = arr_dateText[0];
    day = arr_dateText[1];
    year = arr_dateText[2];
    var dob = new Date(year, month - 1, day, 0, 0, 0);
    var campDate = new Date(2015, 5, 1, 0, 0, 0);
    var maxDate = new Date(campDate.getFullYear() - 12, campDate.getMonth(), campDate.getDate()+1, 0, 0, 0);
    var minDate = new Date(campDate.getFullYear() - 18, campDate.getMonth(), campDate.getDate()-1, 0, 0, 0);
    if ((dob > minDate)&&(dob < maxDate)) {
      return true;
    }
    return false;
  }

  function isEmail(fieldValue) {
    var re = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i;
    return re.test(fieldValue);
  }

  function isAddress(fieldValue) {
    var re = /^[a-zA-Z0-9] ?([a-zA-Z0-9-\/]|[a-zA-Z0-9-\/] )*[a-zA-Z0-9-\/]$/;
    return re.test(fieldValue);
  }

  function isState(state) {                                
    var stateList = new Array("AK","AL","AR","AZ","CA","CO","CT","DC",
      "DC2","DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA",
      "MA","MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH",
      "NJ","NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN",
      "TX","UT","VA","VT","WA","WI","WV","WY","AS", "DC", "FM", "GU", 
      "MH", "MP", "PR", "PW", "VI");
    for(var i=0; i < stateList.length; i++) 
      if(stateList[i] == $.trim(state.toUpperCase()))
        return true;
      return false;
    }

    function isCity (city) {
      var re = /^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/;
      return re.test(city);
    }

    function isZip (zip) {
      var re = /^\d{5}$/;
      return re.test(zip);
    }

    function isAreaPrefix(fieldValue) {
      var re = /^\d{3}$/;
      return re.test(fieldValue);
    }

    function isPhone(value) {
      var re = /^\d{4}$/;
      return re.test(value);
    }

    function isSelected(value) {
      if (value.length == 0 || value == "") {
        return false;
      }
      return true;
    }

    $("#relationship").focus();
    $('#program').on('change', function() {
      var input=$(this);
      if(isSelected(input)) {
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#fname").focus();
      }
    }); 
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


    $('.dob').on('input', function() {
      var input=$(this);
      var dob=$.trim(input.val());
      if(!dob) {
        input.removeClass("invalid valid border_invalid");
      }
      else {
        if(isDate(dob)) {
          if(isAge(dob)) {
            input.removeClass("invalid").addClass("valid");
            errorStatusHandle.text("");
            $("#email").focus();
          }
        }
        else {
          input.removeClass("valid").addClass("invalid");
        } 
      }   
    });
    $('.dob').focusout(function() {
      var input=$(this);
      if(input.hasClass("invalid")) {
        errorStatusHandle.text("*It should be a valid date and child should be between 12-18 years of age to register");
        input.removeClass("invalid").addClass("border_invalid");
      }  
    });

    $(':radio').change(function () {
      $(':radio[name=' + this.name + ']').removeClass('invalid border_invalid');
      $(this).addClass('valid border_valid');
      errorStatusHandle.text("");
    });
    $('#relationship').on('change', function() {
      var input=$(this);
      if(isSelected(input)) {
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#pfname").focus();
      }
    }); 
    <!--Email must be an email -->
    $('#email,#pemail').on('input', function() {
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
    $('#email,#pemail').focusout(function() {
      var input=$(this);
      if(input.hasClass("invalid")) {
        errorStatusHandle.text("*Enter a valid email Id");
        input.removeClass("invalid").addClass("border_invalid");
      }  
    });

    <!--Address -->
    $('.address').on('input', function() {

      var input=$(this);
      var address=$.trim(input.val());
      if(!address) {
        input.removeClass("valid invalid border_invalid");
      }
      else {
        if(!isEmpty(address)){
          input.removeClass("invalid").addClass("valid");
          errorStatusHandle.text("");
        }
        else{
          input.removeClass("valid").addClass("invalid");
        }
      }
    });

    $('.address').focusout(function() {
      var input=$(this);
      if(input.hasClass("invalid")) {
        input.removeClass("invalid").addClass("border_invalid");
      } 

    });

  // ----State----
  $('#state').on('input', function() {
    var input=$(this);
    var state=$.trim(input.val());
    if(!state) {
      input.removeClass("valid invalid border_invalid");
    }
    else {
      if(!isState(state)){
        input.removeClass("valid").addClass("invalid");
      }
      else{
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
      }
    }
  });
  $('#state').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*The state appears to be invalid, "+
        "Please use the two letter state abbreviation");
      input.removeClass("invalid").addClass("border_invalid");
    } 

  });

  $('#city').on('input', function() {
    var input=$(this);
    var city=$.trim(input.val());
    if(!city) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isCity(city)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#city').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*City should contain only alphabets");
      input.removeClass("invalid").addClass("border_invalid");
    } 

  });

  $('#zip').on('input', function() {
    var input=$(this);
    var zip=$.trim(input.val());
    if(!zip) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isZip(zip)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#home_phone_area").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#zip').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Zip should contain only numbers, and should have only 5 digits");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#home_phone_area').on('input', function() {
    var input=$(this);
    var area=$.trim(input.val());
    if(!area) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(area)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#home_phone_prefix").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#home_phone_area').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#home_phone_prefix').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#home_phone").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });

  $('#home_phone_prefix').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#home_phone').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isPhone(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#cell_phone_area").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#home_phone').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#cell_phone_area').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#cell_phone_prefix").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#cell_phone_area').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#cell_phone_prefix').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#cell_phone").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#cell_phone_prefix').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#cell_phone').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isPhone(value)) {
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#program").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#cell_phone').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#emer_cell_phone_area').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#emer_cell_phone_prefix").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#emer_cell_phone_area').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#emer_cell_phone_prefix').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isAreaPrefix(value)){
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#emer_cell_phone").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#emer_cell_phone_prefix').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  $('#emer_cell_phone').on('input', function() {
    var input=$(this);
    var value=$.trim(input.val());
    if(!value) {
      input.removeClass("valid invalid border_valid border_invalid");
    }
    else {
      if(isPhone(value)) {
        input.removeClass("invalid").addClass("valid");
        errorStatusHandle.text("");
        $("#submit").focus();
      }
      else{
        input.removeClass("valid").addClass("invalid");
      }
    }
  });
  $('#emer_cell_phone').focusout(function() {
    var input=$(this);
    if(input.hasClass("invalid")) {
      errorStatusHandle.text("*Please enter a valid phone number");
      input.removeClass("invalid").addClass("border_invalid");
    } 
  });

  function isValidData() {
    if(!isSelected(elementHandle[9].val())) {
      elementHandle[9].addClass("border_invalid");
      errorStatusHandle.text("*Please select the relationship");
      elementHandle[9].focus();
      return false;
    }
    if(isEmpty($.trim(elementHandle[10].val()))) {
      elementHandle[10].addClass("border_invalid");
      errorStatusHandle.text("*Please enter parent/guardian's First Name");
      elementHandle[10].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[11].val()))) {
      elementHandle[11].addClass("border_invalid");
      errorStatusHandle.text("*Please enter parent/guardian's Last Name");
      elementHandle[11].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[13].val()))) {
      elementHandle[13].addClass("border_invalid");
      errorStatusHandle.text("*Please enter parent/guardian's email id");
      elementHandle[13].focus();            
      return false;
    }
    if(!isEmail($.trim(elementHandle[13].val()))) {
      elementHandle[13].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid email id");
      elementHandle[13].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[14].val()))) {
      elementHandle[14].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the address");
      elementHandle[14].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[16].val()))) { 
      elementHandle[16].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the city");
      elementHandle[16].focus();            
      return false;
    }
    if(!isCity($.trim(elementHandle[16].val()))) {
      elementHandle[16].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid city name");
      elementHandle[16].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[17].val()))) { 
      elementHandle[17].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the State");
      elementHandle[17].focus();            
      return false;
    }
    if(!isState($.trim(elementHandle[17].val()))) {
      elementHandle[17].addClass("border_invalid");
      errorStatusHandle.text("*The state appears to be invalid, "+
        "Please use the two letter state abbreviation");
      elementHandle[17].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[18].val()))) { 
      elementHandle[18].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Zip code");
      elementHandle[18].focus();            
      return false;
    }
    if(!$.isNumeric($.trim(elementHandle[18].val()))) {
      elementHandle[18].addClass("border_invalid");
      errorStatusHandle.text("*The zip code appears to be invalid, "+
        "numbers only please. ");
      elementHandle[18].focus();            
      return false;
    }
    if($.trim(elementHandle[18].val()).length != 5) {
      elementHandle[18].addClass("border_invalid");
      errorStatusHandle.text("*The zip code must have exactly five digits")
      elementHandle[18].focus();            
      return false;
    }
    if(!isEmpty($.trim(elementHandle[19].val()))) {
      if(!isAreaPrefix($.trim(elementHandle[19].val()))) {
        elementHandle[19].addClass("border_invalid");
        errorStatusHandle.text("*Please enter a valid area code");
        elementHandle[19].focus();            
        return false;
      }
    }
    if(!isEmpty($.trim(elementHandle[20].val()))) { 
      if(!isAreaPrefix($.trim(elementHandle[20].val()))) {
        elementHandle[20].addClass("border_invalid");
        errorStatusHandle.text("*Please enter a valid phone number prefix");
        elementHandle[20].focus();            
        return false;
      }
    }
    if(!isEmpty($.trim(elementHandle[21].val()))) { 
      if(!isPhone($.trim(elementHandle[21].val()))) {
        elementHandle[21].addClass("border_invalid");
        errorStatusHandle.text("*Please enter a valid phone number");
        elementHandle[21].focus();            
        return false;
      }
    }
    if(isEmpty($.trim(elementHandle[22].val()))) { 
      elementHandle[22].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the area code");
      elementHandle[22].focus();            
      return false;
    }
    if(!isAreaPrefix($.trim(elementHandle[22].val()))) {
      elementHandle[22].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid area code");
      elementHandle[22].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[23].val()))) { 
      elementHandle[23].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the phone number prefix");
      elementHandle[23].focus();            
      return false;
    }
    if(!isAreaPrefix($.trim(elementHandle[23].val()))) {
      elementHandle[23].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid phone number prefix");
      elementHandle[23].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[24].val()))) { 
      elementHandle[24].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the phone number");
      elementHandle[24].focus();            
      return false;
    }
    if(!isPhone($.trim(elementHandle[24].val()))) {
      elementHandle[24].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid phone number");
      elementHandle[24].focus();            
      return false;
    }
    if(!isSelected(elementHandle[0].val())) {
      elementHandle[0].addClass("border_invalid");
      errorStatusHandle.text("*Please select a program");
      elementHandle[0].focus();
      return false;
    }
    if(isEmpty($.trim(elementHandle[1].val()))) {
      elementHandle[1].addClass("border_invalid");
      errorStatusHandle.text("*Please enter child's first name");
      elementHandle[1].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[2].val()))) {
      elementHandle[2].addClass("border_invalid");
      errorStatusHandle.text("*Please enter child's last name");
      elementHandle[2].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[4].val()))) {
      elementHandle[4].addClass("border_invalid");
      errorStatusHandle.text("*Please enter child's preferred name");
      elementHandle[4].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[5].val()))) {
      elementHandle[5].addClass("border_invalid");
      errorStatusHandle.text("*Please enter Date of Birth");
      elementHandle[5].focus();            
      return false;
    }
    if(!isDate($.trim(elementHandle[5].val()))) {
      elementHandle[5].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid date");
      elementHandle[5].focus();            
      return false;
    }
    if(!isAge($.trim(elementHandle[5].val()))) {
      elementHandle[5].addClass("border_invalid");
      errorStatusHandle.text("*Child should be between 12-18 years of age to register ");
      elementHandle[5].focus();            
      return false;
    }
    if(!isEmpty($.trim(elementHandle[6].val()))) {
      if(!isEmail($.trim(elementHandle[6].val()))) {
        elementHandle[6].addClass("border_invalid");
        errorStatusHandle.text("*Please enter a valid email id");
        elementHandle[6].focus();            
        return false;
      }
    }
    if($('input[name=gender]:checked').length<=0)
    {
     elementHandle[7].addClass("border_invalid");
     errorStatusHandle.text("*Please select the gender");
     elementHandle[7].focus();            
     return false;
   }
    ////////////
    if(isEmpty($.trim($('[name="photo"]').val()))) { 
      $('[name="photo"]').addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Photo");
      $('[name="photo"]').focus();            
      return false;
    }
    


    ///////////
    if(isEmpty($.trim(elementHandle[27].val()))) { 
      elementHandle[27].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Emergency Contact Person's Name");
      elementHandle[27].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[28].val()))) { 
      elementHandle[28].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Emergency Contact Person's phone number");
      elementHandle[28].focus();            
      return false;
    }
    if(!isAreaPrefix($.trim(elementHandle[28].val()))) {
      elementHandle[28].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid area code");
      elementHandle[28].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[29].val()))) { 
      elementHandle[29].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Emergency Contact Person's phone number");
      elementHandle[29].focus();            
      return false;
    }
    if(!isAreaPrefix($.trim(elementHandle[29].val()))) {
      elementHandle[29].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid phone number prefix");
      elementHandle[29].focus();            
      return false;
    }
    if(isEmpty($.trim(elementHandle[30].val()))) { 
      elementHandle[30].addClass("border_invalid");
      errorStatusHandle.text("*Please enter the Emergency Contact Person's phone number");
      elementHandle[30].focus();            
      return false;
    }
    if(!isPhone($.trim(elementHandle[30].val()))) {
      elementHandle[30].addClass("border_invalid");
      errorStatusHandle.text("*Please enter a valid phone number");
      elementHandle[30].focus();            
      return false;
    }

    return true;
  }       
  $(':submit').on('click', function(e) {
    for(var i=0; i <= 30; i++)
      elementHandle[i].removeClass("border_invalid invalid valid border_valid");
    errorStatusHandle.text("");
    if(isValidData()) {
      var params = "email=" + $("[name='pemail']").val() +
      "&first_name=" + $("[name='fname']").val();         
      params = encodeURI(params);  
        // alert(params);           
        var req = new HttpRequest('ajax_check_dups.php?'+params,
          handleAnswer);
        req.send();
        e.preventDefault();
      }
      else
        return isValidData();
    });

  $(':reset').on('click', function() {
    for(var i=0; i <= 30; i++)
      elementHandle[i].removeClass("border_invalid invalid valid border_valid");
    errorStatusHandle.text("");
    elementHandle[0].focus(); 
  });
});


