<?php
/**
 * handle actions uploading files
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.2.0
 */
namespace lib;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Exception;

class FileHandlerController
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

    /**
     * remove file action
     * 
     * @return Response
     */
    public function removeAction()
    {
        $file       = Initializer::$request->get('file');
        $fullPath   = MEDIA_PATH . '/' . $file;
        $exists     = file_exists($fullPath);
        $message    = [
            'status'    => 'success',
            'message'   => ''
        ];

        if ($file && $exists) {
            $fileSystem = new Filesystem();

            try {
                $fileSystem->remove([$fullPath]);
            } catch (IOException $e) {
                $message['status']  = 'fail';
                $message['message'] = $e->getMessage();
            } catch (Exception $e) {
                $message['status']  = 'fail';
                $message['message'] = $e->getMessage();
            }
        }

        return new Response(json_encode($message));
    }
}
