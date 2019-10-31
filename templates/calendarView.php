<h2 id="monthName"></h2>
<button id="prevMonth" type="button">Previous</button>
<button id="nextMonth" type="button">Next</button>
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
    var dayElements = [];
    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];
function makeDayTable(month, year) {
    dayElements = [];
    monthElem = document.getElementById('monthName');
    cal = document.getElementById('days-container');
    cal.innerHTML = "";//clear old calendar

    //first day of Month
    firstDay = new Date(year, month);
    monthElem.innerText = monthNames[firstDay.getMonth()] + " " + firstDay.getFullYear();
    blanks = firstDay.getDay();
    numDays = new Date(year, month, 0).getDate();
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
    for(i = 1; i < numDays + 1; i++){
        if((blanks + i) % 7 == 1){
            currentRow = document.createElement('tr');
            cal.appendChild(currentRow);
        }
        currentDay = document.createElement('td');
        currentDay.classList.add("day");

        currentDay.innerText = i;
        currentRow.appendChild(currentDay);

        dayElements.push(currentDay);
    }
};

function populateTable(month, year) {
    //call controller here.
    dayElements[6].innerText += " Example Reminder";
};
var date = new Date();
date.setDate(1);//all months have a day 1
makeDayTable(date.getMonth(), date.getFullYear());
populateTable(date.getMonth(), date.getFullYear());

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
    populateTable(date.getMonth(), date.getFullYear());
});

nextMonth.addEventListener('click', function () {
    month = date.getMonth() == 11? 0 : date.getMonth() + 1;
    date.setMonth(month);


    if(month == 0)
    {
        date.setFullYear(date.getFullYear() + 1);
    }
    makeDayTable(date.getMonth(), date.getFullYear());
    populateTable(date.getMonth(), date.getFullYear());
});

</script>