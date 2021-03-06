<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test Task</title>
        <link href="/template/css/styles.css" rel="stylesheet">
        <link href="/template/css/bootstrap.min.css" rel="stylesheet">
        
    </head>
    <body>
        <div class="panel panel-default">
            <div class="panel-body">

                <form id="createFolder" class="form-inline inline-block display-none" role="form">
                <div class="form-group">
                    <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-folder-open " aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control" name="folder" placeholder="Folder name">
                    </div>
                </div>
                <button class="btn btn-info" data-control="createFolder">Create folder</button>
                </form>

                <form id="uploadImage" class="form-inline inline-block display-none" role="form">
                <div class="form-group">
                    <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-cloud-upload " aria-hidden="true"></span>
                    </div>
                    <input type="file" class="form-control" name="file">
                    </div>
                </div>
                <button class="btn btn-info">Upload image</button>
                </form>

            </div>
        </div>      

        <?php require($view); ?>

        <script src="/template/js/app.js"></script>
    </body>
</html>