var v = new Vue({
    el: '#vueApp',
    data: {
        'record': {}
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
        var recordStr = window.sessionStorage.getItem('staging-record');
        this.record = JSON.parse(recordStr);
        console.log(this.record);
    },
    methods: {
        remove: function() {
            if(confirm('確定刪除?')) {
                var stagingId = this.record.id;
                console.log(stagingId);
                $.get('/user/staging/remove/'+stagingId, function(resData) {
                    console.log(resData);
                    var resJson = JSON.parse(resData);
                    if(resJson['result'] == true) {
                        alert("刪除成功");
                        location.href = "/vue/staging.html";
                    }
                });
            }
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
