<?php
/**
 * The purpose of this file is to define the Request class that encompasses
 * response data to the user agent (head and body)
 * @package naf
 */
namespace Naf\http;

/**
 * HTTP response representation class
 */
class Response
{
    /**
     * @var array HTTP response header key/values
     */
    private $head;

    /**
     * @var Content object that emits response body
     */
    private $body;

    public function __construct(array $head)
    {
        $this->head = $head;
    }

    public static function create($head, \Naf\di\Container $container, $body = '\Naf\http\body\EmptyBody')
    {
        $response = new self($head);
        $response->setBody($container->create($body));
        return $response;
    }

    public function setBody(body\Body $body)
    {
        $this->body = $body;
    }

    public function emit()
    {
        foreach ((array)$this->head as $header) {
            header($header);
        }
        $this->body->emit();
    }

    /**
     * Immediately redirect without sending any other headers or body
     * @param string
     * @param int HTTP status code -- defaults to SEE OTHER as this
         will usually be used for post/redirect/get
     */
    public function redirect($location = '', $status = 303)
    {
        header("Location: " . $location, true, $status);
        exit;
    }

   /**
    * Get or set a cookie (based on the number of arguments)
    * @param string cookie name (for both get and set)
    * @param multi if a string, cookie name is set to expire in 30 days for document root for HTTP_HOST
    *    if an array, the following values may be used: [value, expire, path, domain, secure, httponly]
    */
   public function cookie()
   {
      $name = func_get_arg(0);
      if (func_num_args() === 1) {
         if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
         }
         return null;
      }
      else {
         $value = func_get_arg(1);
         $defaults = array(
            'name' => $name,
            'value' => '',
            'expire' => strtotime('+30 days'),
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => false,
            'httponly' => false
         );
         if (is_array($value)) {
            $value = array_merge($defaults, $value);
         }
         else {
            $defaults['value'] = $value;
            $value = $defaults;
         }
         call_user_func_array('setcookie', $value);
      }
   }
}
?>
