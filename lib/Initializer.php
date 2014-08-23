<?php
/**
 * initialize application
 * 
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.1.0
 */
namespace lib;

use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;

class Initializer
{
    /**
     * @var Request
     */
    public static $request;

    /**
     * composer autoloader instance
     *
     * @var ClassLoader
     */
    private $loader;

    /**
     * initialize application
     */
    public function __construct()
    {
        $this->setPath()->autoLoader()->initFramework();
    }

    /**
     * include and lunch class autoloader
     * 
     * @return Initializer
     */
    protected function autoLoader()
    {
        $bool = file_exists(MAIN_PATH . '/bin/autoload.php');

        if ($bool) {
            $this->loader = require_once MAIN_PATH . '/bin/autoload.php';
        }

        return $this;
    }

    /**
     * set some base paths as constant
     * 
     * @return Initializer
     */
    protected function setPath()
    {
        $main = dirname(__DIR__);
        define('MAIN_PATH', $main);
        define('MEDIA_PATH', $main . '/media');

        return $this;
    }

    /**
     * initialize some framework components
     * 
     * @return Initializer
     */
    protected function initFramework()
    {
        self::$request = Request::createFromGlobals();

        return $this;
    }
}
