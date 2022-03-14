new Vue({
    el: '#vueApp',
    data: {
        privileges: [],
        privilegesSelected: []
    },
    created: function() {
        var selfthis = this;
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
        $.ajax({
            'type': "GET",
            'url': "/user/privileges",
            'success': function(data) {
                console.log(data);
                var json = JSON.parse(data);
                if(json['status'] == true) {
                    selfthis.privileges = json['privileges'];
                }
            }
        });
    },
    methods: {
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
