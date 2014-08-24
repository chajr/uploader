<?php
/**
 * initialize application
 * 
 * @package     lib
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   chajr/bluetree
 * @version     0.2.0
 */
namespace lib;

use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Initializer
{
    /**
     * list of system routers
     * 
     * @var array
     */
    protected $routers = [
        [
            'name'          => 'index',
            'route'         => '/',
            'controller'    => 'Index'
        ],
        [
            'name'          => 'files_list',
            'route'         => '/files_list',
            'controller'    => 'FileList'
        ],
        [
            'name'          => 'file_upload',
            'route'         => '/file_upload',
            'controller'    => 'FileUpload'
        ],
    ];

    /**
     * @var RouteCollection
     */
    protected $routCollection;

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
        $this->setPath()
            ->autoLoader()
            ->initFramework()
            ->routeMap()
            ->initRequest();
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

    /**
     * lunch routers from defined map
     * 
     * @return Initializer
     */
    protected function routeMap()
    {
        $this->routCollection = new RouteCollection();

        foreach ($this->routers as $rout) {
            $this->routCollection->add(
                $rout['name'],
                new Route(
                    $rout['route'],
                    ['controller' => $rout['controller']]
                )
            );
        }

        return $this;
    }

    /**
     * lunch controller and send response to browser
     */
    protected function initRequest()
    {
        $context = new RequestContext();
        $context->fromRequest(self::$request);
        $matcher = new UrlMatcher($this->routCollection, $context);

        try {
            $attributes = $matcher->match(self::$request->getPathInfo());
            $response = $this->callController($attributes);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (Exception $e) {
            $response = new Response('An error occurred', 500);
        }

        $response->send();
    }


    /**
     * call controller an specified action
     * 
     * @param array $attributes
     * @return Response
     */
    protected function callController(array $attributes)
    {
        $action = 'indexAction';

        if (isset($attributes['action'])) {
            $action = $attributes['action'] . 'Action';
        }

        $name = 'lib\\' . $attributes['controller'] . 'Controller';
        /** @var Controller $controller */
        $controller = new $name;

        return $controller->$action();
    }
}
