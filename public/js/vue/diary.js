var v = new Vue({
    el: '#vueApp',
    data: {
        'memos': [],
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
        this.search();
    },
    methods: {
        search: function() {
            console.log('search key:'+ this.keyword);
            var selfthis = this;
            var postData = {};
            postData['keyword'] = this.keyword;
            postData['nowPage'] = this.nowPage;
            postData['offset'] = this.offset;
            $.ajax({
                'type': "POST",
                'url': "/user/sales/diary",
                'data': postData,
                'success': function(data) {
                    var json = JSON.parse(data);
                    if(json['result'] == true) {
                        selfthis.memos = json.memos;
                        console.log(json);
                    }
                }
            });
        },
        see: function(index) {
            console.log('see:'+ index);
            console.log(this.memos[index]);
            /*
            window.sessionStorage.setItem('memos', JSON.stringify(this.memos[index]));
            location.href = "/vue/diary-see.html";
            */
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
