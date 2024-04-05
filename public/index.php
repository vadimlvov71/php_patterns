<?php
use App\Container\IndexContainer;
use App\Controller\IndexController;

require '../vendor/autoload.php';

echo "users:" . "<br>";; 
try {
    //$controller = (new IndexContainer())->get('controller.index');
    $controller = (new IndexContainer())->get(IndexController::class);
    $users =  $controller->index();
    foreach($users as $user){
        echo $user . "<br>";
    }
} catch (Throwable $exception) {
    echo 'error index: ' . $exception->getMessage();
}
            