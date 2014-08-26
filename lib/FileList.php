<?php
/**
 * handle actions for file list page
 *
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.2.0
 */
namespace lib;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use DirectoryIterator;

class FileListController extends CommonController
{
    /**
     * display main page
     *
     * @return Response
     */
    public function indexAction()
    {
        $mainTemplate       = new FilesystemLoader('skin/templates/index.php');
        $fileListTemplate   = new FilesystemLoader('skin/templates/file_list.php');
        $main               = new PhpEngine(new TemplateNameParser(), $mainTemplate);
        $fileList           = new PhpEngine(new TemplateNameParser(), $fileListTemplate);

        $pages = [
            'upload'    => '',
            'list'      => 'active',
            'fileCount' => $this->countFiles(),
        ];
        $list = [
            'fileList'  => $this->getFilesList()
        ];

        $response = $main->render('index', [
            'header'    => $this->createContent('header'),
            'menu'      => $this->createContent('menu', $pages),
            'dropzone'  => $fileList->render('file_list', $list),
            'footer'    => $this->createContent('footer'),
        ]);

        return new Response($response);
    }

    /**
     * return list of files
     * 
     * @return array
     */
    protected function getFilesList()
    {
        $iterator   = new DirectoryIterator(MEDIA_PATH);
        $list       = [];
        $count      = 0;

        foreach ($iterator as $element) {
            if ($element->getFilename() === '.htaccess') {
                continue;
            }

            if ($element->isFile()) {
                $list[] = [
                    'lp'        => ++$count,
                    'name'      => $element->getFilename(),
                    'size'      => $this->fileSizeFormat($element->getSize()),
                    'creation'  => strftime('%d-%m-%Y - %H:%M:%S', $element->getMTime()),
                ];
            }
        }

        return $list;
    }

    /**
     * return proper value for filesize
     * 
     * @param int $size
     * @return string
     */
    protected function fileSizeFormat($size)
    {
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        if ($size == 0) {
            return(0 . ' ' . $sizes[0]);
        }

        return (round(
                $size/pow(1024, ($i = floor(log($size, 1024)))), 2
            ) . ' ' . $sizes[$i]);
    }
}
