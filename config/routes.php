<?php

return [
    'create/folder' => 'create/createFolder',
    'edit' => 'edit/edit',
    'delete' => 'delete/delete',
    'log' => 'read/getLog',
    'gallery/(.*)' => 'read/read/$1',
    'gallery' => 'read/read', //actionRead in ReadController
    '' => 'read/redirectToGallery'
];