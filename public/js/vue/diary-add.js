var v = new Vue({
    el: '#vueApp',
    data: {
        'SubId': 0,
        'WorkMemo': '',
        'VisitDate': '',
        'companies': [],
        'keyword': '',
        'nowPage': 1,
        'offset': 9999
    },
    created: function() {
        console.log('created');
        $.ajax({
            'type': "GET",
            'url': "/user/isLogin",
            'success': function(data) {
                console.log(data);
                var json = JSON.parse(data);
                if(json['status'] == false) {
                    alert("尚未登入");
                    location.href = "/vue/login.html";
                }
            }
        });
        this.companiesSearch();
    },
    methods: {
        companiesSearch: function() {
            console.log('search key:'+ this.keyword);
            var selfthis = this;
            var postData = {};
            postData['keyword'] = this.keyword;
            postData['nowPage'] = this.nowPage;
            postData['offset'] = this.offset;
            $.ajax({
                'type': "POST",
                'url': "/user/companies",
                'data': postData,
                'success': function(data) {
                    var json = JSON.parse(data);
                    if(json['result'] == true) {
                        selfthis.companies = json.companies;
                        console.log(json);
                    }
                }
            });
        },
        add: function() {
            console.log(this.SubId);
            console.log(this.WorkMemo);
            console.log(this.VisitDate);
            if(this.SubId == 0) {
                alert('請選擇車行');
                return;
            }
            if(this.WorkMemo == '') {
                alert('請填寫日誌內容');
                return;
            }
            if(this.VisitDate == '') {
                alert('請填寫日期');
                return;
            }
            var postData = {};
            postData['SubId'] = this.SubId;
            postData['WorkMemo'] = this.WorkMemo;
            postData['VisitDate'] = this.VisitDate;
            $.post('/user/sales/diary/create', postData, function(data) {
                console.log(data);
                var json = JSON.parse(data);
                if(json.result == true) {
                    alert('新增成功');
                    location.href = 'diary.html';
                }
                else
                    alert(json.msg);
            });
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
