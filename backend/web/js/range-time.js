$('[name=time_range]').cnDateRangePicker({
    "autoUpdateInput": false,
    "showDropdowns": true,
    "showWeekNumbers": true,
    "showISOWeekNumbers": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "opens": "center",
    "locale": {
        "format": "YYYY/MM/DD HH:mm:ss",
        "cancelLabel": '清空'
    },
    // "startDate": "00/00/0000 00:00:00",
    // "endDate": "05/08/2017"
}, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY/MM/DD HH:mm') + ' to ' + end.format('YYYY/MM/DD HH:mm') + ' (predefined range: ' + label +')');
});

$('input[name="time_range"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY/MM/DD HH:mm:ss'));
});

$('input[name="time_range"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });