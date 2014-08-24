<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>File uploader</title>
        <link rel="stylesheet" href="/skin/css/bootstrap.css"/>
        <link rel="stylesheet" href="/skin/css/bootstrap_dark.css"/>
        <link rel="stylesheet" href="/skin/css/elusive-webfont.css"/>
        <link rel="stylesheet" href="/skin/css/elusive-webfont-ie7.css"/>
        <link rel="stylesheet" href="/skin/css/dropzone.css"/>
        <link rel="stylesheet" href="/skin/css/style.css"/>
    </head>
    <body>
        <div class="btn-group">
            <a href="/" class="btn btn-default active">Upload files</a>
            <a href="/files_list" class="btn btn-default">
                Uploaded files list
                <span class="badge">14</span>
            </a>
        </div>

        <?php echo $dropzone;?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="/skin/js/bootstrap.js"></script>
        <script src="/skin/js/bootstrap_extend.js"></script>
        <script src="/skin/js/dropzone.js"></script>
        <script src="/skin/js/scripts.js"></script>
    </body>
</html>
