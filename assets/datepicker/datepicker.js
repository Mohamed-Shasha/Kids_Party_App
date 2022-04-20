require('bootstrap-datepicker/js/bootstrap-datepicker');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');

$(document).ready(function () {
    const date = new Date();
     $('input').each(function () {
        $(this).datepicker({
            startDate: date
        });
    });
});