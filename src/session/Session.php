<?php
/**
 * The purpose of this file is to define the session container class
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @package naf
 */
namespace Naf\session;

/**
 * Session handling class
 */
class Session {
   /**
    * @var namespace of _SESSION (**not** session_name)
    */
   private $name;

   /**
    * @var bool whether the session  has already been started
    */
   private $loaded = false;

   /**
    * Create a session with the appropriate namespace
    */
   public function __construct($name) {
      $this->name = $name;
   }

   /**
    * Get the requested session parameter from the session namespace
    * Lazy load
    */
   public function __get($key) {
      if (!$this->loaded) {
         $this->load();
      }

      if (isset($_SESSION[$this->name][$key])) {
         return $_SESSION[$this->name][$key];
      }
   }

   /**
    * Set the specified session value in the session namespace by name
    * Lazy load
    */
   public function __set($key, $value) {
      if (!$this->loaded) {
         $this->load();
      }
      $_SESSION[$this->name][$key] = $value;
   }

   /**
    * Initialize the PHP session
    */
   public function load() {
      if (!session_id()) {
         session_start();
      }

      if (!isset($_SESSION[$this->name])) {
         $_SESSION[$this->name] = array();
      }

      $this->loaded = true;
   }
}
?>
