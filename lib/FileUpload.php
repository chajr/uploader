<?php
/**
 * handle actions uploading files
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.1.0
 */
namespace lib;

use Symfony\Component\HttpFoundation\Response;

class FileUploadController
{
    /**
     * handle files that will be uploaded
     * 
     * @return Response
     */
    public function indexAction()
    {
        return new Response('Upload');
    }
}
