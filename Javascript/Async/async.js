document.addEventListener("DOMContentLoaded", function (event) {

  var httpRequest;
  document.getElementById("ajax").onclick = function () {
    makeRequestAjax('api.php');
  };
  document.getElementById("promise").onclick = function () {
    makeRequestPromise('api.php');
  };
  
  function makeRequest(url, callback) {
    alert('makeRequest');
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
      alert('Giving up :( Cannot create an XMLHTTP instance');
      return false;
    }
    httpRequest.onreadystatechange = callback;
    httpRequest.open('GET', url);
    httpRequest.send();    
  }

  function makeRequestAjax(url) {
    alert('makeRequestAjax');
    makeRequest(url, handleResponseAjax);
  }
  function handleResponseAjax() {
    var result = '?';
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        result = httpRequest.responseText;
      } else {
        result = 'There was a problem with the request.';
      }
      alert(result);
    }
  }

  function makeRequestPromise(url) {
    alert('makeRequestPromise');
    var promise = new Promise(function (resolve, reject) {
      makeRequest(url, handleResponsePromise);
      var response = handleResponsePromise(); 
      if (response) {
        resolve("Stuff worked!");
      } else {
        reject(Error("It broke"));
      }
    });
    promise.then(function (result) {
      alert(result);
    }, function (err) {
      alert(err);
    });
  }

  function handleResponsePromise() {
    var result = '?';
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        result = httpRequest.responseText;
      } else {
        result = false;
      }
      return result;
    }
  }

});
