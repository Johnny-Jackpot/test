"use strict";
(function () {
    function Library() { }
    Library.prototype.post = function (url, data, done, fail) {
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
    };

    //return div container of for folder/image
    Library.prototype.findItemDiv = function (target, className) {
        while (!target.classList.contains(className)) {
            target = target.parentNode;
        }
        return target;
    };

    Library.prototype.findItemTitle = function (parent, className) {
        return parent.querySelector('.' + className);
    };

    Library.prototype.createForm = function (inputValue, saveId, cancelId) {
        var form = document.createElement('form');
        form.insertAdjacentHTML('afterBegin',
            '<div class="form-group">' +
                '<input type="text" class="form-control" name="itemName" value="' + inputValue + '"/>' +
                '<button id="' + saveId + '" class="btn btn-success">' +
                    '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' +
                '</button>' +
                '<button id ="' + cancelId + '" class="btn btn-danger">' +
                    '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                '</button>' +
            '</div>');

        return form;
    };

    /*
        client-side validation
        if we pop() 'item' params must match
        @param string windowPath (/window/location)
        @param string itemPath   (/window/location/item)
        @return bool
    */
    Library.prototype.pathsMatched = function (windowPath, itemPath) {
        try {
            windowPath = decodeURI(windowPath);
            var lastItem = itemPath.split('/').pop();
            itemPath = itemPath.replace('/' + lastItem, '');
            return windowPath === itemPath;
        } catch (e) {
            console.log(e);
            return false;
        }
    };

    Library.prototype.checkPaths = function (target) {
        var path = target.dataset.path;
        var location = window.location.pathname;

        return this.pathsMatched(location, path);
    };

    Library.prototype.getFormData = function(form) {
        var formData = {};
        var elements = [].slice.apply(form.elements);
            
        for (var i = 0, n = elements.length; i < n; i++) {
            if (elements[i] instanceof HTMLInputElement) {
                formData[elements[i].name] = elements[i].value;
            }
        }

        return formData;
    };

    /*
        @param obj params {
            string containerClassName,
            string titleClassName,
        }
    */
    function Handlers(params) {
        this.containerClassName = params.containerClassName;
        this.titleClassName = params.titleClassName;
    }

    Handlers.prototype = Object.create(Library.prototype);
    Handlers.prototype.constructor = Handlers;
    /*@param array ids
    */
    Handlers.prototype.applyPreventDefault = function(ids) {
        for (var i = 0, n = this.formIds.length; i < n; i++) {
            var form = document.getElementById(ids[i]);
            if (!form) continue;
            form.addEventListener('submit', function(event){
                event.preventDefault();
            });
        }
    };
    

    Handlers.prototype.delete = function (target) {
        if (!this.checkPaths(target)) return;
        var path = target.dataset.path;

        this.post('/delete',
            { path: path },
            function (data) {
                var div = this.findItemDiv(target, this.containerClassName);
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
    };

    Handlers.prototype.edit = function (target) {
        var div = this.findItemDiv(target, this.containerClassName);
        var title = this.findItemTitle(div, this.titleClassName);
        var titleValue = title.textContent.trim();
        var child = [].slice.apply(div.childNodes).pop();

        if (child instanceof HTMLFormElement) return;

        var saveId = 'save_' + Date.now();
        var cancelId = 'cancel_' + Date.now();
        var form = this.createForm(titleValue, saveId, cancelId);

        form.addEventListener('submit', function (event) { event.preventDefault(); });
        //cancel edit
        form.querySelector('#' + cancelId).addEventListener('click', function (event) {
            form.remove();
            title.textContent = titleValue;
        });
        //confirm edit
        form.querySelector('#' + saveId).addEventListener('click', function (event) {
            if (!this.checkPaths(target)) {
                alert("Error occured.");
                alert("Please, refresh this page.");
                return;
            }

            var data = this.getFormData(form);
            data.path = target.dataset.path;

            this.post('/edit', data,
                function (res) {
                    var newName = JSON.parse(res).newName;

                    title.textContent = newName;
                    //add new path to edit button
                    var newDataPath = target.dataset.path.split('/');
                    newDataPath.pop();
                    newDataPath.push(newName);
                    newDataPath = newDataPath.join('/');
                    target.dataset.path = newDataPath;
                    //add new path to delete button
                    div.querySelector('[data-control="delete"]')
                        .dataset
                        .path = newDataPath;
                    //add new href to <a>
                    var anchor = div.querySelector('a');
                    anchor.href = newDataPath;

                    form.remove();
                },
                function (status, statusText) {
                    title.textContent = titleValue;
                    alert(statusText);
                }
            );

        }.bind(this));

        title.textContent = '';
        div.appendChild(form);
    };

    Handlers.prototype.createFolder = function(target) {
        console.log('create folder');
    }

    var handlers = new Handlers({
        containerClassName: 'item',
        titleClassName: 'title'
    });

    handlers.applyPreventDefault(['createFolder', 'uploadImage']);

    document.body.addEventListener('click', function (event) {
        var target = event.target;
        if (target.dataset.control === 'delete') this.delete(target);
        if (target.dataset.control === 'edit') this.edit(target);
        if (target.dataset.control === 'createFolder') this.createFolder(target);
    }.bind(handlers));
})();