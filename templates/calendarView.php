<h2 id="monthName"></h2>
<button id="prevMonth" type="button">Previous</button>
<button id="nextMonth" type="button">Next</button>
<form id="addReminderForm" action="templates/jobView.php" method="POST" style="display: none;">
    <input id="addReminderDate" name="date"/>
    <input id="updateReminderID" name="reminderID"/>
</form>
<table id="cal-table">
    <thead>
        <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </tr>
    </thead>
    <tbody id="days-container">
    </tbody>

</table>
<script>

//just make one of these per request type
//in the example page you can see that the you can press the
//action button multiple times and this object will get reused multiple times as oReq
var oReq = new XMLHttpRequest();

function populateTable () {
    //capture response text
    text = this.responseText;
    //Transform text into a native data sctructure
    message = JSON.parse(text);
    console.log(message);
    //This turns the data into DOM elements.
    for( row of message['data']) {
        rowNode = document.createElement('div');
        rowNode.style.color = row.color;
        rowNode.classList.add('job');

        rowType = document.createElement('i');
        rowNode.appendChild(rowType);
        switch(row.type) {
            case 'INFORMATIONAL':
                rowType.innerText = 'I';
                rowType.className='info';
                break;
            case 'TODO':
                rowType.innerText = 'T';
                rowType.className='todo';
                break;
            case 'DEADLINE':
                rowType.innerText = 'D';
                rowType.className='deadline';
                break;
            case 'EVENT':
                rowType.innerText = 'E';
                rowType.className='event';
                break;
            default:
                console.log(row.type)
        } 

        //console.log(row.id);
        let id = row.id;
        rowNode.addEventListener('click', function () {
            //alert(id);
            document.getElementById('addReminderDate').value = '';
            document.getElementById('updateReminderID').value = id;
            document.getElementById('addReminderForm').submit();
        });
        rowNode.appendChild(document.createTextNode(row.title));

        surround = document.createElement('div');
        surround.classList.add('surround');
        surround.classList.add('group' + row.group);
        surround.appendChild(rowNode);
        if(row.owns){
            butt = document.createElement('a');
            butt.innerText = 'X';
            butt.href = '/controllers/deleteJobController.php?delete=' + row.id;
            surround.appendChild(butt);
        }
        index = new Date(row.date);
        
        index = index.getDate() - 1;
        //console.log(index);
        dayElements[index].appendChild(surround);
    }
}

//This attaches a function to oReq that will handle responses from the server.
oReq.addEventListener("load", populateTable);


    var dayElements = [];
    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];
    var monthImages = ["winter", "winter", "spring", "spring", "spring", "summer",
                        "summer", "summer", "autumn", "autumn", "autumn", "winter"];

function makeDayTable(month, year) {
    dayElements = [];
    monthElem = document.getElementById('monthName');
    cal = document.getElementById('days-container');
    cal.innerHTML = "";//clear old calendar

    //first day of Month
    firstDay = new Date(year, month);
    monthElem.innerText = monthNames[firstDay.getMonth()] + " " + firstDay.getFullYear();
    document.getElementsByTagName('html')[0].className = "";
    document.getElementsByTagName('html')[0].classList.add(monthImages[firstDay.getMonth()]);
    //monthElem.appendChild(groupChooser);
    blanks = firstDay.getDay();
    numDays = new Date(year, month+1, 0).getDate();//add one to month because 0th day is last day of previous month.
    firstRow = document.createElement('tr');
    
    
    if(blanks != 0){
        cal.appendChild(firstRow);
    
        //Add blanks to the first row.
        for(i = 0; i < blanks; i++){
            blank = document.createElement('td');
            //blank.innerText = 'blank';
            blank.classList.add("blank");
            firstRow.appendChild(blank);
        }
    }


    //add 
    currentRow = firstRow;
    //console.log(numDays);
    for(i = 1; i < numDays + 1; i++){
        if((blanks + i) % 7 == 1){
            currentRow = document.createElement('tr');
            cal.appendChild(currentRow);
        }
        currentDay = document.createElement('td');
        currentDay.classList.add("day");

        addReminder = document.createElement('button');
        addReminder.innerText = '+';
        d = new Date(year, month, i);
        addReminder.value = d.toISOString().slice(0,10);
        //console.log(addReminder.value);
        addReminder.addEventListener('click', function() {
            //alert(this.value);
            document.getElementById('updateReminderID').value = '';
            document.getElementById('addReminderDate').value = this.value;
            document.getElementById('addReminderForm').submit();
        });
        currentDay.innerText = i;
        currentDay.appendChild(addReminder);
        currentRow.appendChild(currentDay);

        dayElements.push(currentDay);
    }
};

function getMonthData(month, year) {
    console.log('sending message');
    oReq.open("POST", "/templates/calendarController.php");
    oReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    numUsers = JSON.stringify({ "month": month + 1, 'year': year });//adding 1 to month for sql
    oReq.send(numUsers);
};


var date = new Date();
date.setDate(1);//all months have a day 1
makeDayTable(date.getMonth(), date.getFullYear());
getMonthData(date.getMonth(), date.getFullYear());

var prevMonth = document.getElementById('prevMonth');
var nextMonth = document.getElementById('nextMonth');

prevMonth.addEventListener('click', function () {
    month = date.getMonth() == 0? 11 : date.getMonth() - 1;
    date.setMonth(month);


    if(month == 11)
    {
        date.setFullYear(date.getFullYear() - 1);
    }
    makeDayTable(date.getMonth(), date.getFullYear());
    getMonthData(date.getMonth(), date.getFullYear());
});

nextMonth.addEventListener('click', function () {
    month = date.getMonth() == 11? 0 : date.getMonth() + 1;
    date.setMonth(month);


    if(month == 0)
    {
        date.setFullYear(date.getFullYear() + 1);
    }
    makeDayTable(date.getMonth(), date.getFullYear());
    getMonthData(date.getMonth(), date.getFullYear());
});

</script>