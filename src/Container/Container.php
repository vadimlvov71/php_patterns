<?php
namespace App\Container;

use Psr\Container\ContainerInterface;
/**
 * Class Container
 */
class Container implements ContainerInterface
{
	/**
	 * @var array
	 */
	protected $instances = [];

	/**
	 * @param      $abstract
	 * @param null $concrete
	 */
	public function set($abstract, $concrete = NULL)
	{
		if ($concrete === NULL) {
			$concrete = $abstract;
		}
		$this->instances[$abstract] = $concrete;
	}

	/**
	 * @param       $abstract
	 * @param array $parameters
	 *
	 * @return mixed|null|object
	 * @throws Exception
	 */
	public function get($abstract, $parameters = [])
	{
		// if we don't have it, just register it
		if (!isset($this->instances[$abstract])) {
			$this->set($abstract);
		}

		return $this->resolve($this->instances[$abstract], $parameters);
	}
	public function has(string $id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }
        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }
        return isset($item);
    }
	/**
	 * resolve single
	 *
	 * @param $concrete
	 * @param $parameters
	 *
	 * @return mixed|object
	 * @throws Exception
	 */
	public function resolve($concrete, $parameters)
	{
		if ($concrete instanceof Closure) {
			return $concrete($this, $parameters);
		}

		$reflector = new \ReflectionClass($concrete);
		// check if class is instantiable
		if (!$reflector->isInstantiable()) {
			throw new Exception("Class {$concrete} is not instantiable");
		}
		
		// get class constructor
		$constructor = $reflector->getConstructor();
		if (is_null($constructor)) {
			// get new instance from class
			return $reflector->newInstance();
		}
		
		// get constructor params
		$parameters   = $constructor->getParameters();
		echo "_____<pre>";
		print_r($parameters);
		echo "</pre>";
		$dependencies = $this->getDependencies($parameters);

		// get new instance with dependencies resolved
		return $reflector->newInstanceArgs($dependencies);
	}

	/**
	 * get all dependencies resolved
	 *
	 * @param $parameters
	 *
	 * @return array
	 * @throws Exception
	 */
	public function getDependencies($parameters)
	{
		$dependencies = [];
		foreach ($parameters as $parameter) {
			// get the type hinted class
			$dependency = $parameter->getClass();
			//$dependency = $parameter->getType()->getName();
			
			if ($dependency === NULL) {
				// check if default value for a parameter is available
				if ($parameter->isDefaultValueAvailable()) {
					// get default value of parameter
					$dependencies[] = $parameter->getDefaultValue();
				} else {
					throw new Exception("Can not resolve class dependency {$parameter->name}");
				}
			} else {
				// get dependency resolved
				$dependencies[] = $this->get($dependency->name);
			}
		}
		//echo gettype($dependency)."<br>";
		echo "<pre>";
		print_r($dependencies);
		echo "</pre>";
		return $dependencies;
	}
}
