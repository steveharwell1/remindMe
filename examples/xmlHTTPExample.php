<?php
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  include '../templates/header.php';
  ?>

<button type="button" id="clickme">Get all user names and emails</button>
<div id='result-container'>
</div>


  <script>
function reqListener () {
  //capture response text
  text = this.responseText;
  //Transform text into a native data sctructure
  message = JSON.parse(text);

  //get data key out of the JSON object 'message'
  outputDiv = document.getElementById("result-container");
  //this outputs the raw data
  outputDiv.innerText = JSON.stringify(message['data']);

  //This turns the data into DOM elements.
  for( row of message['data']) {
    rowNode = document.createElement('div');
    rowNode.innerText = "Name: " + row.name + " Email: " + row.email;
    outputDiv.appendChild(rowNode);
  }
}

//just make one of these per request type
//in the example page you can see that the you can press the
//action button multiple times and this object will get reused multiple times as oReq
var oReq = new XMLHttpRequest();

//This attaches a function to oReq that will handle responses from the server.
oReq.addEventListener("load", reqListener);
var elem = document.getElementById("clickme");

//This is the event that sends the message to the server.
elem.addEventListener('click', function(){
    console.log('sending message');
    oReq.open("POST", "./controllerExample.php");
    
    //setting the header so that JSON will be sent. Both directions of communication will be json.
    //It is the common language of this informal network layer. REST runs like this. Most things called
    //REST are really just json communication. So if you get this then you get like 70% of what people
    //mean when they say REST.
    oReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    numUsers = JSON.stringify({ "count": 2 });
    oReq.send(numUsers);
});

  </script>

<?php

include_once '../templates/footer.php';