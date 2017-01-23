"use strict";
(function () {
    /*
        return div container of for folder/image
    */
    function findItemDiv(target, className) {
        while (!target.classList.contains(className)) {
            target = target.parentNode;
        }
        return target;
    }

    function findItemTitle(parent, className) {
        return parent.querySelector('.' + className);
    }

    function insertForm(target) {
        var value = target.textContent.trim();

        var form = document.createElement('form');
        form.innerHTML =
            '<div class="form-group">' + 
                '<input type="text" class="form-control" value="' + value + '"/>' + 
            '</div>' +
            '<button type="submit" class="btn btn-default">Submit</button>';
        form.addEventListener('click', function(event) {
            event.preventDefault();
        });

        target.textContent = '';
        target.appendChild(form);
        
        
        console.log(value);
    }

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

    /*
        @param obj params
        {
            containerClassName,
            titleClassName 
        }
    */
    function Handlers(params) {
        this.containerClassName = params.containerClassName;
        this.titleClassName = params.titleClassName;
    }
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
                var div = findItemDiv(target, this.containerClassName);
                div.remove();
                var items = document.getElementsByClassName(this.containerClassName);
                if (items.length == 0) {
                    document.getElementById('gallery').innerHTML =
                        '<div class="alert alert-info" role="alert"><p>This folder is empty.</p></div>';
                }
            }.bind(this),
            function (status, error) {
                alert(error);
            });
    }

    Handlers.prototype.edit = function (target) {
        var div = findItemDiv(target, this.containerClassName);
        var title = findItemTitle(div, this.titleClassName);
        var input = insertForm(title);

        console.log(title);

    };

    var handlers = new Handlers({
        containerClassName: 'item',
        titleClassName: 'title'
    });

    document.body.addEventListener('click', function (event) {
        var target = event.target;
        if (target.dataset.control === 'delete') this.delete(target);
        if (target.dataset.control === 'edit') this.edit(target);


    }.bind(handlers));
})();
