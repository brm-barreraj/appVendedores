function sendAjax(url, action, data) {
  var result;
  if (typeof data === 'string') {
    data += "&accion=" + action;
  } else {
    data.accion = action;
  }
  result = null;
  $.ajaxSetup({
    async: false
  });
  $.ajax({
    "url": url,
    "dataType": 'json',
    "type": 'POST',
    "data": data,
    "success": function(dataResult) {
      return result = dataResult;
    },
    "error": function(result) {
      return console.log(result, 'error');
    }
  });
  return result;
};

function logout(){
  sendAjax('serviceAdmin.php', 'logout', {});
}

function showmessage(message){

	$( "#message" ).animate({
	    top: "0",
	  }, 2000, function() {
	  	$("#message p").html(message);
	  });

}