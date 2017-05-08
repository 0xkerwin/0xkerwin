$('[name=time_range]').cnDateRangePicker({
    "showDropdowns": true,
    "showWeekNumbers": true,
    "showISOWeekNumbers": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "opens": "center",
    "locale": {
        "format": "YYYY/MM/DD HH:mm:ss",
    },
    // "startDate": "00/00/0000 00:00:00",
    // "endDate": "05/08/2017"
}, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY-MM-DD HH:mm:ss') + ' to ' + end.format('YYYY-MM-DD HH:mm:ss') + ' (predefined range: ' + label +')');
});