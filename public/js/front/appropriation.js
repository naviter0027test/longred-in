function formatDate(d) {
    var month = '' + (d.getMonth() + 1);
    var day = '' + d.getDate();
    var year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

function showTable(jsonData) {
    $('.search-result tbody').html('');
    window.sessionStorage.setItem('recordList', JSON.stringify(jsonData));
    jsonData['records'].forEach(function(record, idx) {
        var tr = document.createElement('tr');
        $(tr).append("<td>"+ record['created_at'] +"</td>");
        $(tr).append("<td>"+ record['CustGID'] +"</td>");
        $(tr).append("<td>"+ record['productName'] +"</td>");
        $(tr).append("<td>"+ record['schedule'] +"</td>");
        $(tr).attr('recordId', record['id']);
        $('.search-result tbody').append(tr);
        $(tr).on('click', function() {
            window.sessionStorage.setItem('clickRecordId', $(this).attr('recordId'));
            location.href = "/front/record";
        });
    });
}

function getRecord(postData) {
    var action = $('.search-form').attr('action');
    $.post(action, postData, function(data) {
        var jsonData = JSON.parse(data);
        console.log(jsonData);
        $('.search-result tbody').html('');
        if(jsonData['result'] == true) {
            showTable(jsonData);
        }
        else
            alert(jsonData['msg']);
    });
}

function initSearch() {
    var monthAgo = new Date();
    monthAgo.setMonth(monthAgo.getMonth() - 1);
    var monthAgoDate = formatDate(monthAgo);
    var nowDate = formatDate(new Date());
    var postData = {
        'checkStatus': '核准',
        'startDate': monthAgoDate,
        'endDate': nowDate,
        'nowPage': 1,
        'offset': 9999
    };
    getRecord(postData);
}

$(document).ready(function() {
    initSearch();

    $('[name=schedule]').on('change', function() {
        var schedule = $('[name=schedule]').val();
        var keyword = $('[name=keyword]').val();
        var nowDate = formatDate(new Date());
        var searchData = {
            'endDate': nowDate,
            'checkStatus': '核准',
            'schedule': schedule,
            'keyword': keyword,
            'nowPage': 1,
            'offset': 9999
        };
        var monthAgo = new Date();
        monthAgo.setMonth(monthAgo.getMonth() - 1);
        var monthAgoDate = formatDate(monthAgo);
        searchData['startDate'] = monthAgoDate;
        if($('.three-month').hasClass('tag-hover')) {
            var monthAgo = new Date();
            monthAgo.setMonth(monthAgo.getMonth() - 3);
            var monthAgoDate = formatDate(monthAgo);
            searchData['startDate'] = monthAgoDate;
        }
        getRecord(searchData);
    });

    $('[name=keyword]').on('keyup', function() {
        var schedule = $('[name=schedule]').val();
        var keyword = $('[name=keyword]').val();
        var nowDate = formatDate(new Date());
        var searchData = {
            'endDate': nowDate,
            'checkStatus': '核准',
            'schedule': schedule,
            'keyword': keyword,
            'nowPage': 1,
            'offset': 9999
        };
        var monthAgo = new Date();
        monthAgo.setMonth(monthAgo.getMonth() - 1);
        var monthAgoDate = formatDate(monthAgo);
        searchData['startDate'] = monthAgoDate;
        if($('.three-month').hasClass('tag-hover')) {
            var monthAgo = new Date();
            monthAgo.setMonth(monthAgo.getMonth() - 3);
            var monthAgoDate = formatDate(monthAgo);
            searchData['startDate'] = monthAgoDate;
        }
        getRecord(searchData);
    });

    $('.tag').on('click', function() {
        $('.tag').removeClass('tag-hover');
        $(this).addClass('tag-hover');
        var schedule = $('[name=schedule]').val();
        var keyword = $('[name=keyword]').val();
        var nowDate = formatDate(new Date());
        var postData = {
            'endDate': nowDate,
            'checkStatus': '核准',
            'schedule': schedule,
            'keyword': keyword,
            'nowPage': 1,
            'offset': 9999
        };
        if($(this).hasClass('one-month')) {
            var monthAgo = new Date();
            monthAgo.setMonth(monthAgo.getMonth() - 1);
            var monthAgoDate = formatDate(monthAgo);
            postData['startDate'] = monthAgoDate;
        }
        else {
            var monthAgo = new Date();
            monthAgo.setMonth(monthAgo.getMonth() - 3);
            var monthAgoDate = formatDate(monthAgo);
            postData['startDate'] = monthAgoDate;
        }
        getRecord(postData);
    });
});
