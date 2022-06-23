(function () {
    Guestbook = {
        init: function (params) {
            this.name = params ? document.querySelector(params.name) : '';
            this.email = params ? document.querySelector(params.email) : '';
            this.text = params ? document.querySelector(params.text) : '';
            this.submit = params ? document.querySelector(params.submit) : '';
            this.form = params ? document.querySelector(params.form) : '';
            this.message = params ? document.querySelector(params.message) : '';
            this.posts = params ? document.querySelector(params.posts) : '';
            this.bind();
            this.get();
        },

        bind: function () {
            this.submit.addEventListener('click', function (event) {
                event.preventDefault();
                Guestbook.send();
            }, true);
        },

        send: function () {
            let http = new XMLHttpRequest();

            let form =
                {
                    name: this.name.value,
                    email: this.email.value,
                    text: this.text.value
                };
            let params = 'add=' + JSON.stringify(form);
            http.open('POST', '/api.php', true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {
                if(http.readyState == 4 && http.status == 200) {
                    let res = JSON.parse(http.responseText);
                    Guestbook.message.innerHTML = res;
                    Guestbook.get();
                }
            }
            http.send(params);
        },

        get: function () {
            var http = new XMLHttpRequest();
            http.onreadystatechange = function() {
                if (http.readyState == XMLHttpRequest.DONE) {
                    Guestbook.fill(http.responseText);
                }
            }
            http.open('GET', '/api.php?get=posts', true);
            http.send(null);
        },

        fill: function (data) {
            let posts = JSON.parse(data);
            let html = '';
            for (let i = 0; i < posts.length; i++) {
                html += '<div class="post">' +
                    '<div class="post__name"><a href="mailto:' + posts[i]['email'] + '">' + posts[i]['name'] + '</a></div>' +
                    '<div class="post__date">' + posts[i]['dtime'] + '</div>' +
                    '<div class="post__message">' +
                        posts[i]['body'] +
                    '</div>' +
                '</div>';
            }
            this.posts.innerHTML = html;
        },
    }
})();