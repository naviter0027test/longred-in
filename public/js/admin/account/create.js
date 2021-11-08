$(document).ready(function() {
    $('.form1').validate();
    $('[name=Privileges]').selectize({
        'create': false,
        'sortField': {
            'field': 'text',
            'direction': 'asc'
        }
    });
});

