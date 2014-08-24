<?php
/**
 * handle actions for file list page
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.1.0
 */
namespace lib;

use Symfony\Component\HttpFoundation\Response;

class FileListController
{
    /**
     * will display list of uploaded files
     * 
     * @return Response
     */
    public function indexAction()
    {
        return new Response('File List');
    }
}
