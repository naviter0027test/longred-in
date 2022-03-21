var v = new Vue({
    el: '#vueApp',
    data: {
        'keyword': ''
    },
    created: function() {
        console.log('created');
    },
    methods: {
        search: function() {
            console.log('search');
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
