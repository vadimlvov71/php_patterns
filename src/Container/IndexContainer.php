<?php
namespace App\Container;


use App\Controller\IndexController;
use App\Repository\UserRepository;
use App\Entity\UserEntity;
/**
 * A psr-11 compliant container
 */
class IndexContainer extends Container 
{

    private array $objects = [];

    public function __construct()
    {
 
        $this->objects = [
            //'db' => fn() => new Db(),
            UserEntity::class => fn() => new UserEntity(),
            UserRepository::class => fn() => new UserRepository($this->get(UserEntity::class)),
            IndexController::class => fn() => new IndexController($this->get(UserRepository::class)),
        ];
    }
/*
    public function has(string $id): bool
    {
        if (!$this->has($id)) {
            throw new DependencyNotRegisteredException($dependency); //DependencyNotRegisteredException implements NotFoundExceptionInterface
        }
        return isset($this->objects[$id]);
    }
*/
    /*
    public function get(string $id)
    {
       // $classReflector = new \ReflectionClass($id);
       // $constructReflector = $classReflector->getConstructor();
       // var_dump( $constructReflector );
        return 
        isset($this->objects[$id]) 
          ? $this->objects[$id]() 		 // "Старый подход"
          : $this->prepareObject($id); // "Новый" подход$this->objects[$id]();
    }
    */
    private function prepareObject(string $class): object
    {
        
        if (empty($constructReflector)) {
            return new $class;
        }

        // Получаем рефлекторы аргументов конструктора
        // Если аргументов нет - сразу возвращаем экземпляр класса
        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        // Перебираем все аргументы конструктора, собираем их значения
        $args = [];
        foreach ($constructArguments as $argument) {
            // Получаем тип аргумента
            $argumentType = $argument->getType()->getName();
            // Получаем сам аргумент по его типу из контейнера
            $args[$argument->getName()] = $this->get($argumentType);
        }

        // И возвращаем экземпляр класса со всеми зависимостями
        return new $class(...$args);
    }
}