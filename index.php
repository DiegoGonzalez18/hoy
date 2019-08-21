
<?php
session_start();
require __DIR__ . '/vendor/autoload.php'; #Cargar todas las dependencias
require __DIR__ . '/config/config.php';

use Phroute\Phroute\Dispatcher;

use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

use Phroute\Phroute\Exception\HttpRouteNotFoundException;

use Phroute\Phroute\RouteCollector;

use App\Controllers\SliderController;
use App\Controllers\UsuarioController;
ini_set('display_errors', 0);

ini_set("log_errors", 1);

ini_set("error_log", __DIR__ . "/logs/" . date("Y-m-d") . ".log");

if (!file_exists(RUTA_LOGS)) {

    mkdir(RUTA_LOGS);

}
$collector = new RouteCollector();
                $collector->get("/", function(){
                    require_once ('views/frontend/index.php');
                 });


                $collector->get("login", function(){
                
                                    require_once ('./views/admin/login.php');
                    
                });
                $collector->get("evento", function(){
                
                    echo "registrar Evento";
});
                $collector->get("listareventos", function(){
                                
                    echo "Listar Eventos";
                });
                $collector->get("asignareventos", function(){
                                
                    echo "Asignar Eventos";
                });
                $collector->get("home", function(){
                                    if(!isset( $_SESSION['user'])){
                                           require_once ('./views/admin/login.php');
                                     }else{
                                           require_once ('./views/admin/home.php');
                                     }

                });

                $collector->post("login2", function(){

                                     $a= new UsuarioController();
                                     $a->login($_POST["email"],$_POST["clave"]);
                    
                
                });

                $collector->get("/error", function(){

                                      require_once('./views/error/error.php');
                    
                
                });

                $collector->get("slider", function(){
                                      if(!isset( $_SESSION['user'])){
                                          require_once ('views/admin/login.php');
                                      }else{
                                          require_once ('views/admin/slider/registerSlider.php');
                                      }
                });

                $collector->post("slider", function(){
                                     $a=new SliderController();
                                     $a->registerSlider($_POST['titulo'],$_FILES['archivo']['tmp_name'],$_FILES['archivo']['name']);
                });

                $collector->get("sliders",function(){
                                     require_once ('views/admin/slider/slider.php');
                });

                $collector->post("eliminarslider", function(){

                    if(isset($_POST['idEliminar'])){
                        $a=new SliderController();
                        
                        $a->eliminar($_POST['idEliminar']);
                }
             });
             $collector->post("traigoslider", function(){

                if(isset($_POST['idEditar'])){
                    $a=new SliderController();
                          
                    $a->traerDatos($_POST['idEditar']);
                  }
             });
             $collector->post("editar", function(){

                if(isset($_POST['idEd'])){

                    if(!empty($_FILES['archivi']['tmp_name'])){
                      
                    $a= new SliderController();
                    $a->editarConImagen($_POST['idEd'],$_POST['titulo'],$_FILES['archivi']['tmp_name'],$_FILES['archivi']['name']);
                    }else {
                     
                    $a= new SliderController();
                    $a->editaSinImagen($_POST['idEd'],$_POST['titulo']);
                    }
                    }
             });
             $collector->post("asignar", function(){
                if(isset($_POST['traer'])){
                    $a= new SliderController();
                    $a->listarAsignacion();
                  }
             });
             $collector->post("visible", function(){
                if(isset($_POST['arreglo'])){

                    $a= new SliderController();
                    $a->asignar($_POST['arreglo']);
                  }
             });
             $collector->get("asignar", function(){
                require_once ('views/admin/slider/asignarSlider.php');
             });

             $despachador = new Dispatcher($collector->getData());

             $rutaCompleta = $_SERVER["REQUEST_URI"];
             
             $metodo = $_SERVER['REQUEST_METHOD'];
             
             $rutaLimpia = parsearUrl($rutaCompleta);
             
             try {
             
             
             
                 $despachador->dispatch($metodo, $rutaLimpia);
                 echo "<script>console.log('".$rutaCompleta."')</script>";
             } catch (HttpRouteNotFoundException $e) {
             
                 echo "Error: Ruta [ $rutaLimpia ] no encontrada";
             
             } catch (HttpMethodNotAllowedException $e) {
             
                 echo "Error: Ruta [ $rutaLimpia ] encontrada pero método [ $metodo ] no permitido";
             
             }
             
             function parsearUrl($uri)
             
             { 
                echo "<script>console.log('".$uri."')</script>";
                 if($uri=="/cmsUFPS/index.php/"){
                     $uri="/cmsUFPS/";

                     echo "<script>console.log('entro')</script>";
                     header("Location: /cmsUFPS/");
                     
                 } else if($uri=="/cmsUFPS/index.php/login/"){
                    $uri="/cmsUFPS/index.php/login/";

                    echo "<script>console.log('entro')</script>";
                    header("Location: /cmsUFPS/index.php/login");
                 }
             
              return implode('/',
             
                     array_slice(
             
                         explode('/', $uri), 3));
             
             }