<?php

require __DIR__ . '/vendor/autoload.php'; #Cargar todas las dependencias



use Phroute\Phroute\Dispatcher;

use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

use Phroute\Phroute\Exception\HttpRouteNotFoundException;

use Phroute\Phroute\RouteCollector;







ini_set('display_errors', 0);

ini_set("log_errors", 1);

ini_set("error_log", __DIR__ . "/logs/" . date("Y-m-d") . ".log");

if (!file_exists(RUTA_LOGS)) {

    mkdir(RUTA_LOGS);

}

$collector = new RouteCollector();

$collector->get("/", function(){

	echo "<a href='index.php/slider'>Diego</a>";

});

$collector->get("home", function(){

	 require_once ("views/admin/home.php");

});
$collector->get("evento", function(){

    require_once ("views/admin/home.php");

});
$collector->get("slider", function(){

	 require_once ("views/admin/slider/slider.php");

});

$despachador = new Dispatcher($collector->getData());

$rutaCompleta = $_SERVER["REQUEST_URI"];

$metodo = $_SERVER['REQUEST_METHOD'];

$rutaLimpia = parsearUrl($rutaCompleta);

try {

  

    $despachador->dispatch($metodo, $rutaLimpia);

} catch (HttpRouteNotFoundException $e) {

    echo "Error: Ruta [ $rutaLimpia ] no encontrada";

} catch (HttpMethodNotAllowedException $e) {

    echo "Error: Ruta [ $rutaLimpia ] encontrada pero método [ $metodo ] no permitido";

}

function parsearUrl($uri)

{

 return implode('/',

        array_slice(

            explode('/', $uri), 2));

}