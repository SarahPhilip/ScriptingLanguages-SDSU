$(document).ready(function() {
  alert("Enter");
  var errorStatusHandle = $('#message_line');
  function isEmpty(fieldValue) {
    return $.trim(fieldValue).length == 0;    
  }
  function isValidData() {
      errorStatusHandle.text(""); 
      if(isEmpty($.trim($('[name="email"]').val()))) { 
      errorStatusHandle.text("*Please enter the email");          
      return false;
    }
      if(isEmpty($.trim($('[name="pass"]').val()))) {
        errorStatusHandle.text("*Please enter password");       
        return false;
      }
  }
  $(':submit').on('click', function() {
    for(var i=0; i <= 1; i++)
    errorStatusHandle.text("");
    if(isValidData()) {
      var req = new HttpRequest('login.php');
      req.send();
      e.preventDefault();
    }
    else
      return isValidData();
  });

  $(':reset').on('click', function() {
    for(var i=0; i <= 1; i++)
    errorStatusHandle.text("");
    $('[name="user"]').focus(); 
  });
});
