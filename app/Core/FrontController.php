<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController{
    
    static function main(){
        Route::add('/', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->index();
                }
                , 'get');
        
        Route::add('/formulario', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\FormularioExamenController();
                    $controlador->mostrarFormulario();
                }
                , 'get');
                
        Route::add('/formulario', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\FormularioExamenController();
                    $controlador->procesarFormulario();
                }
                , 'post');
        
        Route::add('/anagrama', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\AnagramaController();
                    $controlador->mostrarFormulario();
                }
                , 'get');
                
        Route::add('/anagrama', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\AnagramaController();
                    $controlador->procesarFormulario();
                }
                , 'post');
        
        Route::add('/letra-palabras', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\PrimeraLetraPalabrasController();
                    $controlador->mostrarFormulario();
                }
                , 'get');
                
        Route::add('/letra-palabras', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\PrimeraLetraPalabrasController();
                    $controlador->procesarFormulario();
                }
                , 'post');
                
        Route::add('/contarLetras', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\ContarLetrasController();
                    $controlador->mostrarFormulario();
                }
                , 'get');
                
        Route::add('/contarLetras', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\ContarLetrasController();
                    $controlador->procesarFormulario();
                }
                , 'post');   
                
        Route::add('/notas', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\NotasController();
                    $controlador->mostrarFormulario();
                }
                , 'get');
                
        Route::add('/notas', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\NotasController();
                    $controlador->procesarFormulario();
                }
                , 'post');  
                
        Route::add('/usuarios', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuariosController();
                    $controlador->mostrarUsuarios();
                }
                , 'get');   
                
        Route::add('/usuariosOrdenados', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuariosController();
                    $controlador->mostrarUsuariosOrdenados();
                }
                , 'get'); 
                
        Route::add('/usuariosStandard', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuariosController();
                    $controlador->mostrarUsuariosEstandar();
                }
                , 'get');   
                
        Route::add('/usuariosCarlos', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuariosController();
                    $controlador->mostrarUsuariosCarlos();
                }
                , 'get'); 
                
        Route::add('/usuariosConFiltros', 
                function(){
                    $controlador = new \Com\Daw2\Controllers\UsuariosController();
                    $controlador->mostrarUsuariosFiltrados();
                }
                , 'get');                 
                
                
        Route::pathNotFound(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );
        
        Route::methodNotAllowed(
            function(){
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}

