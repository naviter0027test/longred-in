$(document).ready(function() {
    $('[name=SubId]').selectize({
        'create': false,
        'sortField': {
            'field': 'text',
            'direction': 'asc'
        }
    });

    $('[name=SubId]').on('change', function() {
        console.log($(this).text());
        $('[name=SubName]').val($(this).text());
    });

    $('[name=SalesName]').selectize({
        'create': false,
        'sortField': {
            'field': 'text',
            'direction': 'asc'
        }
    });
});
