<?php
/**
 * handle actions uploading files
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.3.0
 */
namespace lib;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
        $fileSystem = new Filesystem();
        $file       = Initializer::$request->get('file');
        $fullPath   = MEDIA_PATH . '/' . $file;
        $exists     = $fileSystem->exists($fullPath);
        $message    = [
            'status'    => 'success',
            'message'   => ''
        ];

        if ($file && $exists) {
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

    /**
     * handle upload action for single file
     * 
     * @return Response
     */
    public function uploadAction()
    {
        $fileSystem = new Filesystem();
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file       = Initializer::$request->files->get('file');
        $path       = MEDIA_PATH . '/' . $file->getClientOriginalName();

        if ($file->getError()) {
            return new Response($file->getErrorMessage(), 500);
        }

        if ($fileSystem->exists($path)) {
            return new Response('File already exists', 500);
        }

        try {
            $fileSystem->copy((string)$file, $path);
        } catch (IOException $e) {
            return new Response(var_export($e, true), 500);
        } catch (Exception $e) {
            return new Response(var_export($e, true), 500);
        }

        return new Response('File was uploaded');
    }

    /**
     * return file to download
     * 
     * @return Response
     */
    public function downloadAction()
    {
        $fileSystem = new Filesystem();
        $path       = 'media/' . Initializer::$request->get('file');

        if (!$fileSystem->exists($path)) {
            return new Response('File not exists', 500);
        }

        $response       = new Response(file_get_contents($path));
        $description    = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            Initializer::$request->get('file')
        );

        $response->headers->set('Content-Disposition', $description);
        return $response;
    }
}
