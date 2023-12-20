<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class ContarLetrasController extends \Com\Daw2\Core\BaseController {

    private const EXPRESION_REGULAR = '/[^a-zA-Z0-9]/';

    function mostrarFormulario() {
        $data = array (
            'titulo' => 'Contar letras',
            'seccion' => 'contarLetras'
        );

        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $this->view->showViews(array('templates/header.view.php', 'contarLetras.view.php', 'templates/footer.view.php'), $data);
    }

    function procesarFormulario(): void {
        $data = array (
            'titulo' => 'Contar letras',
            'seccion' => 'contarLetras'
        );

        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $data['errores'] = $this->checkForm($_POST);

        if (count($data['errores']) === 0) {
            $data['resultado'] = $this->contarLetras($_POST['texto']);
        }

        $this->view->showViews(array('templates/header.view.php', 'contarLetras.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkForm(array $post): array {
        $errores = [];

        $texto = $post['texto'];
        
        if (strlen(preg_replace('/[^a-zA-Z]/', '', $texto)) === 0) {
            $errores['texto'] = 'Inserte una cadena con al menos una letra';
        }
        return $errores;
    }

    private function contarLetras(string $texto): array {
        $textoLimpio = preg_replace('/[^a-zA-Z]/', '', $texto);
        
        $resultado = [];
        
        for ($i = 0; $i < strlen($textoLimpio); $i++) {
            $caracter = $textoLimpio[$i];
            if(isset($resultado[$caracter])) {
                $resultado[$caracter]++;
            }
            else {
                $resultado[$caracter] = 1;
            }
        }
        arsort($resultado);
        return $resultado;
    }
}
