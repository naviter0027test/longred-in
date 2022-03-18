var v = new Vue({
    el: '#vueApp',
    data: {
        selectize: null,
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
        this.getPrivileges();
    },
    watch: {
        privilegesSelected: function() {
            console.log('watch');
            console.log(this.privilegesSelected);
            var postData = {};
            postData['privileges'] = this.privilegesSelected;
            $.ajax({
                'type': "POST",
                'url': "/user/privileges/setsee",
                'data': postData,
                'success': function(data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if(json['status'] == true) {
                    }
                }
            });
        }
    },
    methods: {
        getPrivileges: function() {
            console.log('getPrivileges');
            var selfthis = this;
            $.ajax({
                'type': "GET",
                'url': "/user/privileges",
                'success': function(data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if(json['status'] == true) {
                        selfthis.privileges = json['privileges'];
                        setTimeout(function() {
                            var $select = $('.pri-select select').selectize({
                                'create': false,
                                'onChange': function(value) {
                                    //console.log(value);
                                    if(value == null)
                                        selfthis.privilegesSelected = [];
                                    else
                                        selfthis.privilegesSelected = value;
                                },
                                'sortField': {
                                    'field': 'text',
                                    'direction': 'asc'
                                }
                            });
                            selfthis.selectize = $select[0].selectize;
                            selfthis.getSeePrivileges();
                        }, 1000);
                    }
                }
            });
        },
        getSeePrivileges: function() {
            var selfthis = this;
            $.get('/user/privileges/getsee', function(resData) {
                console.log(resData);
                var resJson = JSON.parse(resData);
                if(resJson['status'] == true) {
                    selfthis.privilegesSelected = resJson['privileges'];
                    selfthis.selectize.setValue(selfthis.privilegesSelected);
                }
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
