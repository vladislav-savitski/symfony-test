jQuery('.budget').click(function (e) {
    var name = $(this).attr('id');
    if (name == 'total') {
        $('#mensuel').prop('checked', false);
    } else {
        $('#total').prop('checked', false);
    }
});
jQuery('.pagination').click(function (e){
    var page = $(this).attr('id');

    $('#page').val(page);
    $('#pagination').submit();
})