jQuery('.budget').click(function (e) {
    var name = $(this).attr('id');
    if (name == 'total') {
        $('#mensuel').prop('checked', false);
    } else {
        $('#total').prop('checked', false);
    }
});