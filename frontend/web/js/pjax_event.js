// $(document).on('click', 'input#Async', function () {
//     switchManner($(this));
// });


// $(document).on('pjax:complete', function () {
//     switchManner($('input#Async'));
// });

$(document).on('pjax:beforeSend', function () {
    $('.alert-danger,.alert-success').map(function () {
        this.remove();
    });
});

$(document).ready(function () {
    $('input#Async').click(function () {
        switchManner($(this));
    });
});

function switchManner(e) {
    var $manner = false;
    switch (e[0].checked) {
        case true:
            $manner = 'async';
            $('#equationForm').attr('data-pjax', 'true');
            break;
        case false:
            $manner = 'sync';
            $('#equationForm').removeAttr('data-pjax');
            break;
    }
    if ($manner) {
        $.post('game/change-manner', {'manner': $manner}).done(function () {
            // console.log('success');
        }).fail(function () {
            // console.log('error');
        });

    }
}
