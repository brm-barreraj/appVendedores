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
  sendAjax('url', 'logout', {});
}