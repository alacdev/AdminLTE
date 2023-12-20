<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class NotasController extends \Com\Daw2\Core\BaseController {

    private const PATRON = '/[^a-zA-Z]+/';

    function mostrarFormulario(): void {
        $data = [];
        $data['titulo'] = 'Notas';
        $data['seccion'] = 'notas';

        $this->view->showViews(array('templates/header.view.php', 'notas.view.php', 'templates/footer.view.php'), $data);
    }

    function procesarFormulario(): void {
        $data = [];
        $data['titulo'] = 'Notas';
        $data['seccion'] = 'notas';
        $data['errores'] = $this->checkForm($_POST);
        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (count($data['errores']) == 0) {
            $data['resultado'] = $this->procesarNotas(json_decode($_POST['notas'], true));
        }
        $this->view->showViews(array('templates/header.view.php', 'notas.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkForm(array $post): array {
        $arrayMaterias = json_decode($_POST['notas'], true);
        $errores = [];
        $erroresTexto = [];

        if (empty($post['notas'])) {
            $erroresTexto[] = 'Campo obligatorio';
        } else if (is_null($arrayMaterias)) {
            $erroresTexto[] = 'No se ha enviado un Json válido';
        } else {
            foreach ($arrayMaterias as $nombreMateria => $datosMateria) {
                if (!is_string($nombreMateria)) {
                    $erroresTexto[] = "'$nombreMateria' no es un nombre de asignatura válido";
                }
                if (!is_array($datosMateria)) {
                    $erroresTexto[] = "'$nombreMateria' no tiene asignado un array de datos";
                } else {
                    foreach ($datosMateria as $alumno => $nota) {
                        if (!is_string($alumno)) {
                            $erroresTexto[] = "Asignatura: '$nombreMateria' el alumno '$alumno' no tiene un nombre válido";
                        }
                        if (!is_numeric($nota)) {
                            $erroresTexto[] = "Asignatura: '$nombreMateria' alumno '$alumno' tiene como nota '$nota' que no es válida";
                        } else {
                            if ($nota < 0 || $nota > 10) {
                                $erroresTexto[] = "Asignatura: '$nombreMateria' alumno '$alumno' tiene como nota '$nota' que no es válida";
                            }
                        }
                    }
                }
            }
        }

        if (count($erroresTexto) > 0) {
            $errores['notas'] = $erroresTexto;
        }

        return $errores;
    }

    private function procesarNotas(array $datos): array {
        $resultados = [];

        foreach ($datos as $nombreAsignatura => $datosAsignatura) {
            $media = 0;
            $suspensos = 0;
            $aprobados = 0;
            $max = array(
                'alumno' => '',
                'nota' => 0
            );
            $min = array(
                'alumno' => '',
                'nota' => 10
            );
            foreach ($datosAsignatura as $alumno => $nota) {
                $media += $nota;
                if ($nota < 5) {
                    $suspensos++;
                } else {
                    $aprobados++;
                }
                if ($max['nota'] < $nota) {
                    $max['nota'] = $nota;
                    $max['alumno'] = $alumno;
                }
                if ($min['nota'] > $nota) {
                    $min['nota'] = $nota;
                    $min['alumno'] = $alumno;
                }
            }
            $media /= count($datosAsignatura);
            $resultados[$nombreAsignatura] = [];
            $resultados[$nombreAsignatura]['media'] = $media;
            $resultados[$nombreAsignatura]['suspensos'] = $suspensos;
            $resultados[$nombreAsignatura]['aprobados'] = $aprobados;
            $resultados[$nombreAsignatura]['max'] = $max;
            $resultados[$nombreAsignatura]['min'] = $min;
        }

        return $resultados;
    }

    private function procesarAlumnos(array $datos): array {
        $listado = [];

        foreach ($datos as $nombreMateria => $datosMateria) {
            foreach ($datosMateria as $alumno => $nota) {
                if (!isset($listado[$alumno])) {
                    $listado[$alumno] = [
                        "aprobados" => 0,
                        "suspensos" => 0
                    ];
                }
                $nota >= 5 ? $listado[$alumno]["aprobados"]++ : $listado[$alumno]["suspensos"]++;
            }
        }
    }
}
