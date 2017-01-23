"use strict";
(function () {
    function post(url, data, done, fail) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        var formData = new FormData();
        for (var key in data) {
            formData.append(key, data[key]);
        }
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            if (xhr.readyState != 4) return;
            if (xhr.status == 200) done(xhr.responseText);
            else fail(xhr.status, xhr.statusText);
        };
    }

    function Handlers() { }
    /*
        client-side validation
        if we pop() 'item' params must match
        @param string windowPath (/window/location)
        @param string itemPath   (/window/location/item)
        @return bool
    */
    Handlers.prototype.pathsMatched = function (windowPath, itemPath) {
        try {
            var lastItem = itemPath.split('/').pop();
            itemPath = itemPath.replace('/' + lastItem, '');
            return windowPath === itemPath;
        } catch (e) {
            console.log(e);
            return false;
        }
    };

    Handlers.prototype.delete = function (target) {
        var path = target.dataset.path;
        var location = window.location.pathname;
        if (!this.pathsMatched(location, path)) return;

        post('/delete',
            { path: path },
            function (data) {
                var className = 'item';
                //'item' - is class name of div we need remove
                while(target.className.indexOf(className) == -1) {
                    target = target.parentNode;
                }
                target.remove();
                var items = document.getElementsByClassName(className);
                if (items.length == 0) {
                    document.getElementById('gallery').innerHTML = 
                    '<div class="alert alert-info" role="alert"><p>This folder is empty.</p></div>';
                }
            },
            function (status, error) { 
                alert(error);
            });
    }

    var handlers = new Handlers();

    document.body.addEventListener('click', function (event) {
        var target = event.target;
        if (target.dataset.control === 'delete') this.delete(target);


    }.bind(handlers));
})();
