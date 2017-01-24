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

    var insertForm = function (title, container, editButton) {
        var titleValue = title.textContent.trim();

        return function () {
            var form = document.createElement('form');
            var saveId = 'save_' + Date.now();
            var cancelId = 'cancel_' + Date.now();

            form.insertAdjacentHTML('afterBegin',  
                '<div class="form-group">' +
                    '<input type="text" class="form-control" name="itemName" value="' + titleValue + '"/>' +
                    '<button id="' + saveId + '" class="btn btn-success">' +
                        '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' +
                    '</button>' +
                    '<button id ="' + cancelId + '" class="btn btn-danger">' +
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                    '</button>' +
                '</div>');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
            });

            form.querySelector('#' + cancelId).addEventListener('click', function(event){
                form.remove();
                title.textContent = titleValue;
            });

            form.querySelector('#' + saveId).addEventListener('click', function(event){
                if (!checkPaths(editButton)) {
                    alert("Error occured.");
                    alert("Please, refresh this page.");
                    return;
                }

                var elements = [].slice.apply(form.elements);
                var data = { path: editButton.dataset.path };
                for (var i = 0, n = elements.length; i < n; i++) {
                    if (elements[i] instanceof HTMLInputElement) {
                        data[elements[i].name] = elements[i].value;
                    }
                }

                post('/edit', data,
                    function(data) {

                    },
                    function(status, statusText) {
                        alert(statusText);
                    }
                );
                
            });

            title.textContent = '';
            container.appendChild(form);
            
        };
    };

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
        client-side validation
        if we pop() 'item' params must match
        @param string windowPath (/window/location)
        @param string itemPath   (/window/location/item)
        @return bool
    */
    function pathsMatched(windowPath, itemPath) {
        try {
            var lastItem = itemPath.split('/').pop();
            itemPath = itemPath.replace('/' + lastItem, '');
            return windowPath === itemPath;
        } catch (e) {
            console.log(e);
            return false;
        }
    }

    function checkPaths(target) {
        var path = target.dataset.path;
        var location = window.location.pathname;

        return pathsMatched(location, path);
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

    Handlers.prototype.delete = function (target) {
        if (!checkPaths(target)) return;
        var path = target.dataset.path;
        
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
        var child = [].slice.apply(div.childNodes).pop();

        if (child instanceof HTMLFormElement) return;

        insertForm(title, div, target)();
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