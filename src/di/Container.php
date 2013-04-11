<?php
/**
 * The purpose of this file is to define the Dependency Injection container class
 * @package naf
 */

/**
 * Class that manages dependencies.
 * This class works by type hinting.  It will create an instance of the requested
 * class and all instances of required objects specified by type hints in the
 * constructor.
 *
 * This class also keeps a record of created objects so when the same object is
 * requested, the same instance is given.  The registry of objects can be cleared,
 * and parameters can also be registered to objects (especially useful for
 * non-object parameters that cannot use type hinting

 For example, say you have three classes:

 Controller::__construct(Auth $auth, Sesh $sesh);
 Auth::__construct(Sesh $sesh);
 Sesh::__construct()

 Request a Controller via `Container::create('Controller')`.  Container checks the
 registry for Controller first.  If it is not there, it attempts to create it.  It
 looks at the constructor and sees an `Auth` instance is required, so it attempts
 to create that.  It sees that `Sesh` is required, so that is created.  `Sesh`
 requires no other instances, so `Sesh` and `Auth` are both registered and it
 continues checking required arguments for the Controller.  A `Sesh` instance is
 required.  Since `Sesh` was just registered by creating `Auth`, the same `Sesh`
 instance is pulled from the registry and used to create the `Controller` instance.
 */

namespace di;

class Container {
   /**
    * @var list of objects by class name => instance
    */
   private $objects = array();

   /**
    * @var list of parameters by class name => parameters
    */
   private $params = array();

   /**
    * Create the requested class.  If an instance for the className already exists
    * in the registry, return that instance.  Otherwise, create
    * a new class using either:
      1. Registered parameters, if any
      2. Object instances from type hints in constructor
      3. No arguments, if constructor not defined on class
    *
    * If the registry has a *string*, for the given className, use the className
    * from the registry instead (this allows for giving unique names to different
    * the same class, perhaps with different parameters)
    */
   public function create($className) {
      if (isset($this->objects[$className])) {
         if (is_string($this->objects[$className])) {
            $className = $this->objects[$className];
         }
         else {
            return $this->objects[$className];
         }
      }
      $class = new \ReflectionClass($className);

      if (isset($this->params[$className])) {
         return $class->newInstanceArgs($this->params[$className]);
      }

      $constructor = $class->getConstructor();
      if ($constructor) {
         return $class->newInstanceArgs($this->buildArgumentsFromDefinition($constructor));
      }
      else {
         return $class->newInstance();
      }
   }

   /**
    * Create an array of object instances based on type hints of the provided method
    * @uses self::create if an object instance is requested.  This allows the object/parameter
    * registries to be used and allows for recursive creation of objects
    */
   public function buildArgumentsFromDefinition($method) {
      $args = array();
      foreach ($method->getParameters() as $param) {
         $argvalue = null;

         $argname = $param->getClass();
         if ($argname) {
            $argname = $argname->name;
            $argvalue = self::create($argname);
            $this->objects[$argname] = $argvalue;
         }
         else if ($param->isDefaultValueAvailable()) {
            $argvalue = $param->getDefaultValue();
         }
         $args[] = $argvalue;
      }
      return $args;
   }

   /**
    * Add an object instance to the object registry
    *
    * You can register a nonextant class using a string
    * value for the target class.  This allows multiple
    * instances of the same class to be used correctly
    * by the type hints
    */
   public function register($name, $object) {
      $this->objects[$name] = $object;
      if (is_string($object)) {
         if (!class_exists($name, true)) {
            eval("class $name extends $object {}");
            $this->objects[$name] = $name;
         }
      }
   }

   /**
    * Remove an object instance from the registry
    */
   public function unregister($name) {
      unset($this->objects[$name]);
   }

   /**
    * Register parameters to the given object name
    */
   public function registerParams($name, $args) {
      $this->params[$name] = $args;
   }

   /**
    * Unregister parameters from the given object name
    */
   public function unregisterParams($name) {
      unset($this->objects[$name]);
   }
}
?>
