<?php

return [
    'create/folder' => 'main/createFolder',
    'edit' => 'main/edit',
    'delete' => 'main/delete',
    'log' => 'main/getLog',
    'gallery/(.*)' => 'main/read/$1',
    'gallery' => 'main/read', //actionRead in MainController
    '' => 'main/redirectToGallery'
];