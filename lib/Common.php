<?php
/**
 * common class for controllers
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
use DirectoryIterator;

class CommonController
{
    /**
     * create simple content from given template
     * 
     * @param string $type
     * @param array $data
     * @return false|string
     */
    public function createContent($type, $data = [])
    {
        $mainTemplate  = new FilesystemLoader('skin/templates/' . $type . '.php');
        $main          = new PhpEngine(new TemplateNameParser(), $mainTemplate);
        $content       = $main->render($type, $data);

        return $content;
    }

    /**
     * count files in media directory
     * 
     * @return int
     */
    public function countFiles()
    {
        $iterator   = new DirectoryIterator(MEDIA_PATH);
        $count      = 0;

        foreach ($iterator as $element) {
            if ($element->getFilename() === '.htaccess') {
                continue;
            }

            if ($element->isFile()) {
                $count++;
            }
        }

        return $count;
    }
}
