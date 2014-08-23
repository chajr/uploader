<?php
use lib\Initializer;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

require_once 'lib/Initializer.php';
$init = new Initializer();



$mainTemplate       = new FilesystemLoader('skin/templates/index.php');
$dropzoneTemplate   = new FilesystemLoader('skin/templates/dropzone.php');
$main               = new PhpEngine(new TemplateNameParser(), $mainTemplate);
$dropzone           = new PhpEngine(new TemplateNameParser(), $dropzoneTemplate);


echo $main->render('index', [
    'dropzone' => $dropzone->render('dropzone'),
]);
