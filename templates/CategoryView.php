<h2>CATEGORY VIEW</h2>
<ul>
  <li>G1: Category Name</li>
    <ul>
      <li>Job 0</li>
      <li>Job 1</li>
    </ul>
  <li>G2: Category Name</li>
      <ul>
      <li>Job 2</li>
      <li>Job 3</li>
    </ul>
</ul>

<script>
CategoryView = document.getElementById('addGroup');

var addJobReq = new XMLHttpRequest();
function addGroupCallback() {
	text = this.responseText;
  //Transform text into a native data sctructure
  	message = JSON.parse(text);
	  console.log(text);
	document.getElementById('groupsList').innerText += message.data.name;
}
//This attaches a function to oReq that will handle responses from the server.
addJobReq.addEventListener("load", addGroupCallback);


//This is the event that sends the message to the server.
CategoryView.addEventListener('click', function(){
    console.log('sending message');
    addJobReq.open("POST", "/templates/groupController.php");
    name = document.getElementById('addGroupName');


    //setting the header so that JSON will be sent. Both directions of communication will be json.
    //It is the common language of this informal network layer. REST runs like this. Most things called
    //REST are really just json communication. So if you get this then you get like 70% of what people
    //mean when they say REST.
    addJobReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    numUsers = JSON.stringify({ "name": name.value });
    addJobReq.send(numUsers);
});
</script>