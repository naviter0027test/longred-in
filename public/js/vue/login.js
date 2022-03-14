new Vue({
    el: '#vueApp',
    data: {
        'account': '',
        'password': ''
    },
    created: function() {
        $.ajax({
            'type': "GET",
            'url': "/user/isLogin",
            'success': function(data) {
                console.log(data);
                var json = JSON.parse(data);
                if(json['status'] == true)
                    location.href = "/vue/home.html";
            }
        });
    },
    methods: {
        login: function() {
            var postData = {};
            postData['account'] = this.account;
            postData['password'] = this.password;
            console.log(postData);
            $.ajax({
                'type': "POST",
                'url': "/user/login",
                'data': postData,
                'success': function(data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if(json['status'] == true)
                        location.href = "/vue/home.html";
                    else
                        alert("輸入帳密有誤");
                }
            });
        }
    }
});
