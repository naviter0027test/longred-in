var v = new Vue({
    el: '#vueApp',
    data: {
        'records': [],
        'keyword': '',
        'orderName': '',
        'orderBy': 'asc',
        'status1': true,
        'status2': false,
        'status3': false,
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
        var orderName = this.getUrlParameter('OrderName');
        this.statusChoice(orderName);
    },
    methods: {
        statusChoice: function(orderName) {
            console.log(orderName);
            if(orderName == false) {
                orderName = '';
                this.status1 = true;
                this.status2 = false;
                this.status3 = false;
                this.orderBy = 'asc';
            }
            else if(orderName == 'SubIdName') {
                this.status1 = false;
                this.status2 = true;
                this.status3 = false;
                this.orderBy = 'desc';
            }
            else if(orderName == 'CustAllowDenyTime') {
                this.status1 = false;
                this.status2 = false;
                this.status3 = true;
                this.orderBy = 'desc';
            }
            this.orderName = orderName;
            this.search();
        },
        search: function() {
            console.log('search key:'+ this.keyword);
            console.log('search order name:'+ this.orderName);
            console.log('search order by:'+ this.orderBy);
            var selfthis = this;
            var postData = {};
            postData['keyword'] = this.keyword;
            postData['orderName'] = this.orderName;
            postData['orderBy'] = this.orderBy;
            postData['nowPage'] = this.nowPage;
            postData['offset'] = this.offset;
            $.ajax({
                'type': "POST",
                'url': "/user/case/preorder",
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
            window.sessionStorage.setItem('preorder-record', JSON.stringify(this.records[index]));
            location.href = "/vue/preorder-see.html";
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
