// only allow two timeslots on Saturday
document.getElementById("date").addEventListener("change", function() {
    var input = this.value;
    var dateEntered = new Date(input);
    var weekdayslots = document.getElementsByClassName("weekday_slot");

    if (dateEntered.getDay() == 6)
    {
        for(var i = 0; i < weekdayslots.length; i++)
        {
            weekdayslots[i].style.display = "none";
            document.getElementById("weekend_slot1").selected=true;
        }
    }
    else
    {
        for(var i = 0; i < weekdayslots.length; i++)
        {
            weekdayslots[i].style.display = "block";
        }
    }
});