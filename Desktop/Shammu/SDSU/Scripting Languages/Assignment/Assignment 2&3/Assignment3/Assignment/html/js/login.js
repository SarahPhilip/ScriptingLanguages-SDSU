$(document).ready(function() {
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
      if(!isEmail($.trim($('[name="email"]').val()))) {
        errorStatusHandle.text("*Please enter a valid email id");
        return false;
      }
      if(isEmpty($.trim($('[name="pass"]').val()))) {
        errorStatusHandle.text("*Please enter password");       
        return false;
      }
  }
  function isEmail(fieldValue) {
  var re = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i;
  return re.test(fieldValue);
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
