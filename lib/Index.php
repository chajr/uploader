<?php
/**
 * handle actions for index page
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.2.0
 */
namespace lib;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends CommonController
{
    /**
     * display main page
     * 
     * @return Response
     */
    public function indexAction()
    {
        $mainTemplate       = new FilesystemLoader('skin/templates/index.php');
        $dropzoneTemplate   = new FilesystemLoader('skin/templates/dropzone.php');
        $main               = new PhpEngine(new TemplateNameParser(), $mainTemplate);
        $dropzone           = new PhpEngine(new TemplateNameParser(), $dropzoneTemplate);

        $response = $main->render('index', [
            'header'    => $this->createContent('header'),
            'menu'      => $this->createContent('menu'),
            'dropzone'  => $dropzone->render('dropzone'),
            'footer'    => $this->createContent('footer'),
        ]);

        return new Response($response);
    }
}
