$(function () {
    $('.select2').select2();
    $('.datetimepicker').datetimepicker();

    $("#create_event_btn").click(function(event) {
        event.preventDefault();
        $(window).scrollTo($("#add_event_form"), 1000);
    });
});