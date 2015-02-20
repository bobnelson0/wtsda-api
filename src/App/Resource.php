<?php

namespace App;

use App\Util\Config;
use App\Util\Log;
use Slim\Slim;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use App\Util\Response;

abstract class Resource
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NO_CONTENT = 204;

    const STATUS_MULTIPLE_CHOICES = 300;
    const STATUS_MOVED_PERMANENTLY = 301;
    const STATUS_FOUND = 302;
    const STATUS_NOT_MODIFIED = 304;
    const STATUS_USE_PROXY = 305;
    const STATUS_TEMPORARY_REDIRECT = 307;

    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_NOT_ACCEPTED = 406;
    const STATUS_CONFLICT = 409;

    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_NOT_IMPLEMENTED = 501;

    /**
     * @var \Slim\Slim
     */
    private $slim;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    protected $key = 'resource';

    /**
     * Construct
     */
    public function __construct()
    {
        $this->setSlim(Slim::getInstance());
        $this->setEntityManager();

        $this->init();
    }

    /**
     * Default init, use for overwrite only
     */
    public function init()
    {}

    /**
     * Default get method
     *
     * HEAD also maps to this
     *
     * @param $id
     */
    public function get($id = null)
    {
        $this->response(self::STATUS_METHOD_NOT_ALLOWED, array('id' => $id));
    }

    /**
     * Default post method
     */
    public function post()
    {
        $this->response(self::STATUS_METHOD_NOT_ALLOWED);
    }

    /**
     * Default put method
     *
     * @param $id
     */
    public function put($id)
    {
        $this->response(self::STATUS_METHOD_NOT_ALLOWED, array('id' => $id));
    }

    /**
     * Default delete method
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->response(self::STATUS_METHOD_NOT_ALLOWED, array('id' => $id));
    }

    /**
     * General options method
     */
    public function options()
    {
        $this->response(self::STATUS_METHOD_NOT_ALLOWED);
    }

    /**
     * General patch method
     */
    public function patch()
    {
        $this->response(self::STATUS_NOT_IMPLEMENTED);
    }

    /**
     * @param int $status
     * @param array $data
     * @param array $allow
     */
    public static function response($status = 200, array $data = array(), $allow = array())
    {
        /**
         * @var \Slim\Slim $slim
         */
        $slim = \Slim\Slim::getInstance();

        $slim->status($status);
        $slim->response()->header('Content-Type', 'application/json');

        if (!empty($data)) {
            $slim->response()->body(json_encode($data));
        }

        if (!empty($allow)) {
            $slim->response()->header('Allow', strtoupper(implode(',', $allow)));
        }

        return;
    }

    /**
     * @param \Exception $e
     * @param int $status
     */
    public static function sendException(\Exception $e, $status = 500)
    {
        /**
         * @var \Slim\Slim $slim
         */
        $slim = \Slim\Slim::getInstance();

        $slim->status($status);
        $slim->response()->header('Content-Type', 'application/json');
        $data = array(
            'type' => get_class($e),
            'message' => $e->getMessage()
        );
        if($slim->config('debug')) {
            $debugOpts = array(
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            );
            $data = array_merge($data, $debugOpts);
        }
        //var_dump($e);exit;
        $slim->response()->body(json_encode($data));

        if (!empty($allow)) {
            $slim->response()->header('Allow', strtoupper(implode(',', $allow)));
        }

        //Log exception
        //Log::error($e);

        return;
    }

    /**
     * @param $resource
     * @return mixed
     */
    public static function load($resource)
    {
        $class = __NAMESPACE__ . '\\Resource\\' . ucfirst($resource);
        if (!class_exists($class)) {
            return null;
        }

        return new $class();
    }

    /**
     * @return \Slim\Slim
     */
    public function getSlim()
    {
        return $this->slim;
    }

    /**
     * @param \Slim\Slim $slim
     */
    public function setSlim($slim)
    {
        $this->slim = $slim;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Create a entity manager instance
     */
    public function setEntityManager()
    {
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__ . '/Entity'));
        $config->setMetadataDriverImpl($driverImpl);

        $config->setProxyDir(__DIR__ . '/Entity/Proxy');
        $config->setProxyNamespace('Proxy');

        $ini = Config::getSection(__DIR__ . '/../../config/local.ini', 'database');

        $connectionOptions = array(
            'driver'   => $ini['driver'],
            'host'     => $ini['host'],
            'dbname'   => $ini['name'],
            'user'     => $ini['user'],
            'password' => $ini['pass'],
        );

        $this->entityManager = EntityManager::create($connectionOptions, $config);
    }

    public function formatResponse($code, $data, $message = null){
        return Response::getResponseData($code, $message, $this->key, $data);
    }
}