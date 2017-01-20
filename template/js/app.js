(function () {

    function post(url, data, done, fail) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        var formData = new FormData();
        for (key in data) {
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
            { location: location, path: path },
            function (data) { 
                document.body.insertAdjacentHTML('afterBegin', data);
             },
            function (status, error) { console.log('fail!'); });


    }

    var handlers = new Handlers();

    document.body.addEventListener('click', function (event) {
        var target = event.target;
        if (target.dataset.control === 'delete') this.delete(target);


    }.bind(handlers));
})();
