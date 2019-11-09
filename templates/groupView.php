<h2>MY GROUPS</h2>
<button id="addGroup" type="button">Create</button>
<input type="text" id="addGroupName" />
<ul id="groupsList">
  <li>Group Name </li>
	<ul>Members
	<li>Member 1</li>
	<li>Member 2</li>
	</ul>
 
  <li>Owned Groups</li>
  
  <button>Create new group</button>  <button>Join a group</button>
  
</ul>
<script>
addGroup = document.getElementById('addGroup');


var addGroupReq = new XMLHttpRequest();
function addGroupCallback() {
	text = this.responseText;
  //Transform text into a native data sctructure
  	message = JSON.parse(text);
	  console.log(text);
	document.getElementById('groupsList').innerText += message.data.name;
}
//This attaches a function to oReq that will handle responses from the server.
addGroupReq.addEventListener("load", addGroupCallback);


//This is the event that sends the message to the server.
addGroup.addEventListener('click', function(){
    console.log('sending message');
    addGroupReq.open("POST", "/templates/groupController.php");
    groupNameText = document.getElementById('addGroupName').value;


    //setting the header so that JSON will be sent. Both directions of communication will be json.
    //It is the common language of this informal network layer. REST runs like this. Most things called
    //REST are really just json communication. So if you get this then you get like 70% of what people
    //mean when they say REST.
    addGroupReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    numUsers = JSON.stringify({ "name": groupNameText });
    addGroupReq.send(numUsers);
});
</script>