<?php
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  include '../templates/header.php';
  ?>

<button type="button" id="clickme">Click me for the date</button>
  <script>
function reqListener () {
    elem.innerText = this.responseText;
    console.log('message returned');
  console.log(this.responseText);
}

var oReq = new XMLHttpRequest();
oReq.addEventListener("load", reqListener);
var elem = document.getElementById("clickme");
elem.addEventListener('click', function(){
    console.log('sending message');
    oReq.open("GET", "./controllerExample.php");
    oReq.send();
});

  </script>

<?php

include_once '../templates/footer.php';