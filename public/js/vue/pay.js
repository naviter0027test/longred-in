var v = new Vue({
    el: '#vueApp',
    data: {
        'records': [],
        'keyword': '',
        'PayStatus': '',
        'status1': true,
        'status2': false,
        'status3': false,
        'status4': false,
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
        var payStatus = this.getUrlParameter('PayStatus');
        this.statusChoice(payStatus);
    },
    methods: {
        statusChoice: function(payStatus) {
            console.log(payStatus);
            if(payStatus == false) {
                payStatus = '';
                this.status1 = true;
                this.status2 = false;
                this.status3 = false;
                this.status4 = false;
            }
            else if(payStatus == '已撥款') {
                this.status1 = false;
                this.status2 = true;
                this.status3 = false;
                this.status4 = false;
            }
            else if(payStatus == '缺資料未撥款') {
                this.status1 = false;
                this.status2 = false;
                this.status3 = true;
                this.status4 = false;
            }
            else if(payStatus == '資料已齊待撥款') {
                this.status1 = false;
                this.status2 = false;
                this.status3 = false;
                this.status4 = true;
            }
            this.PayStatus = payStatus;
            this.search();
        },
        search: function() {
            console.log('search key:'+ this.keyword);
            console.log('search status:'+ this.PayStatus);
            var selfthis = this;
            var postData = {};
            postData['keyword'] = this.keyword;
            postData['PayPageStatus'] = this.PayStatus;
            postData['nowPage'] = this.nowPage;
            postData['offset'] = this.offset;
            $.ajax({
                'type': "POST",
                'url': "/user/case/pay",
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
        see: function(index) {
            console.log('see:'+ index);
            console.log(this.records[index]);
            window.sessionStorage.setItem('pay-record', JSON.stringify(this.records[index]));
            location.href = "/vue/pay-see.html";
        },
        getUrlParameter: function(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
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
