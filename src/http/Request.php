<?php
/**
 * The purpose of this file is to define the Request class that encompasses
 * user agent requests
 * @package naf
 */
namespace Naf\http;

/**
 * HTTP request representation class
 */
class Request
{
    /**
     * @var server request method
     */
    private $method;

    /**
     * @var path info
     */
    private $path;

    /**
     * @var array requested parameters unfolded from path info string
     */
    private $parameters = array();

    /**
     * Set up Request defaults
     * @var string PATH_INFO (requested path relative to document root)
     * @var string REQUEST_METHOD
     */
    public function __construct($path, $method)
    {
        $this->path = $path;
        $this->method = $method;
    }

    /**
     * Create a Request object
     * @param string user agent request path
     * @param array available routes
     * @see routes.php
     */
    public static function create($path, $method, Naf\route\Router $router)
    {
        $request = new self($path, $method);

        $request = $router->route($request);
        if (!$request->CONTROLLER || !$request->ACTION) {
            throw new RequestException("Route '$request->ROUTE' was matched against the request: '{$request->getPath()}', but the controller and/or action is missing");
        }
        return $request;
    }

    /**
     * Get the path info
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the request method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get a parameter set by the user agent request
     * Headers get special treatment as there can be
     * several of them
     */
    public function __get($name)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }
        else if ($name == 'headers') {
            return array();
        }
   }

    /**
     * Set a parameter based on the name
     * All-uppercase parameters are typically special cases
     */
    public function __set($name, $value)
    {
        if (!isset($this->parameters[$name])) {
            $this->parameters[$name] = $value;
        }
    }

    /**
     * Split the provided named parameter by the given
     * symbol (+ by default).
     * @return array
     */
    public function multi($name, $separator = '+')
    {
        $item = $this->$name;
        if ($item) {
            return array_filter(explode($separator, $item));
        }
        return array();
    }

    /**
     * Retrieve a _GET superglobal parameter
     * @param string
     * @param string return if requested parameter is not found
     * @param bool whether to remove surrounding whitespace from the value (yes by default)
     */
    public function get($name, $default = null, $trim = true)
    {
        if (!isset($_GET[$name])) {
            return $default;
        }
        else if ($trim) {
            return $this->trim($_GET[$name]);
        }
        return $_GET[$name];
    }

    /**
     * Retrieve a _POST superglobal parameter
     * @param string
     * @param string return if requested parameter is not found
     * @param bool whether to remove surrounding whitespace from the value (yes by default)
     */
    public function post($name, $default = null, $trim = true)
    {
        if (!isset($_POST[$name])) {
            return $default;
        }
        else if ($trim) {
            return $this->trim($_POST[$name]);
        }
        return $_POST[$name];
    }

    /**
     * Trim whitespace from provided item recursively
     */
    public function trim($item)
    {
        if (is_array($item)) {
            foreach ($item as &$piece) {
                $piece = $this->trim($piece);
            }
            return $item;
        }
        return trim($item);
    }
}
?>
