var v = new Vue({
    el: '#vueApp',
    data: {
        'records': [],
        'keyword': '',
        'title': '',
        'img': null,
        'area': 1,
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
        var areaStr = this.getUrlParameter('Area');
        this.statusChoice(areaStr);
    },
    methods: {
        statusChoice: function(areaStr) {
            console.log(areaStr);
            if(areaStr == false) {
                area = 1;
                this.status1 = true;
                this.status2 = false;
                this.status3 = false;
                this.status4 = false;
            }
            else if(areaStr == '竹苗') {
                area = 2;
                this.status1 = false;
                this.status2 = true;
                this.status3 = false;
                this.status4 = false;
            }
            else if(areaStr == '台中') {
                area = 3;
                this.status1 = false;
                this.status2 = false;
                this.status3 = true;
                this.status4 = false;
            }
            else if(areaStr == '高屏') {
                area = 4;
                this.status1 = false;
                this.status2 = false;
                this.status3 = false;
                this.status4 = true;
            }
            this.area = area;
            this.search();
        },
        search: function() {
            console.log('search key:'+ this.keyword);
            console.log('search status:'+ this.area);
            var selfthis = this;
            var postData = {};
            postData['area'] = this.area;
            postData['nowPage'] = this.nowPage;
            postData['offset'] = this.offset;
            $.ajax({
                'type': "POST",
                'url': "/user/staging",
                'data': postData,
                'success': function(data) {
                    var json = JSON.parse(data);
                    if(json['result'] == true) {
                        selfthis.records = json.stagings;
                        console.log(json);
                    }
                }
            });
        },
        see: function(index) {
            console.log('see:'+ index);
            console.log(this.records[index]);
            window.sessionStorage.setItem('staging-record', JSON.stringify(this.records[index]));
            location.href = "/vue/staging-see.html";
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
        upload: function() {
            var selfthis = this;
            var formData = new FormData();
            formData.append('img', $('[name=img]')[0].files[0]);
            formData.append('title', this.title);
            formData.append('area', this.area);
            console.log(formData);
            $.ajax({
                'type': "POST",
                'url': "/user/staging/upload",
                'data': formData,
                'processData': false,
                'contentType': false,
                'success': function(data) {
                    console.log('success');
                    console.log(data);
                    var resJson = JSON.parse(data);
                    console.log(resJson);
                    if(resJson['result'] == true) {
                        alert('上傳成功');
                        selfthis.search();
                    }
                    else
                        alert(resJson['msg']);
                },
                'error': function(data) {
                    console.log('error');
                    console.log(data);
                },
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
