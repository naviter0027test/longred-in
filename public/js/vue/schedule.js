var v = new Vue({
    el: '#vueApp',
    data: {
        'records': [],
        'keyword': '',
        'CustProjectStatus': '核准無缺',
        'nowPage': 1,
        'offset': 9999
    },
    created: function() {
        console.log('created');
        var selfthis = this;
        var postData = {};
        postData['keyword'] = this.keyword;
        postData['CustProjectStatus'] = this.CustProjectStatus;
        postData['nowPage'] = this.nowPage;
        postData['offset'] = this.offset;
        $.ajax({
            'type': "POST",
            'url': "/user/case/schedule",
            'data': postData,
            'success': function(data) {
                var json = JSON.parse(data);
                if(json['result'] == true) {
                    selfthis.records = json.records;
                    console.log(json);
                }
            }
        });
    },
    methods: {
        search: function() {
            console.log('search');
        },
        see: function(index) {
            console.log('see'+ index);
        },
        logout: function() {
            if(confirm('確定登出?')) {
                var href = $(this).attr('href');
                $.get('/user/logout', function(resData) {
                    console.log(resData);
                    var resJson = JSON.parse(resData);
                    if(resJson['status'] == true) {
                        alert('登出成功');
                        location.href = "/vue/login.html";
                    }
                });
            }
            return false;
        }
    }
});
