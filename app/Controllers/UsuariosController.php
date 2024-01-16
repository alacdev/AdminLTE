<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UsuariosController extends \Com\Daw2\Core\BaseController {

    function mostrarUsuarios(): void {
        $modelo = new \Com\Daw2\Models\UsuarioModel();
        $usuarios = $modelo->getUsers();

        $data = [];
        $data['titulo'] = 'Usuarios';
        $data['seccion'] = 'usuarios';
        $data['breadcrumb'] = ['Usuarios'];
        $data['usuarios'] = $usuarios;
        $data['js'] = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/usuarios.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarUsuariosCarlos(): void {
        $modelo = new \Com\Daw2\Models\UsuarioModel();
        $usuarios = $modelo->getUsersNamedCarlos();

        $data = [];
        $data['titulo'] = 'Usuarios llamados Carlos';
        $data['seccion'] = 'usuariosCarlos';
        $data['breadcrumb'] = ['Usuarios llamados Carlos'];
        $data['usuarios'] = $usuarios;
        $data['js'] = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/usuarios.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuariosCarlos.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarUsuariosEstandar(): void {
        $modelo = new \Com\Daw2\Models\UsuarioModel();
        $usuarios = $modelo->getStandardUsers();

        $data = [];
        $data['titulo'] = 'Usuarios estándar';
        $data['seccion'] = 'usuariosStandard';
        $data['breadcrumb'] = ['Usuarios estándar'];
        $data['usuarios'] = $usuarios;
        $data['js'] = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/usuarios.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuariosStandard.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarUsuariosOrdenados(): void {
        $modelo = new \Com\Daw2\Models\UsuarioModel();
        $usuarios = $modelo->GetUsersOrderBySalaryDesc();

        $data = [];
        $data['titulo'] = 'Usuarios ordenados por salario bruto descendiente';
        $data['seccion'] = 'usuariosOrdenados';
        $data['breadcrumb'] = ['Usuarios ordenados'];
        $data['usuarios'] = $usuarios;
        $data['js'] = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/usuarios.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuariosOrdenados.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarUsuariosFiltrados(): void {
        $rolModel = new \Com\Daw2\Models\RolModel();
        $roles = $rolModel->getRolls();

        $input = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        $userModel = new \Com\Daw2\Models\UsuarioModel();
        if (!empty($_GET['id_rol']) && filter_var($_GET['id_rol'], FILTER_VALIDATE_INT)) {
            $usuarios = $userModel->getUsersFilteredByRol((int) $_GET['id_rol']);
        } else if (!empty($_GET['username']) && filter_var($_GET['username'])) {
            $usuarios = $userModel->getUsersFilteredByUsername($_GET['username']);
        } else if ((!empty($_GET['minSalary']) && is_numeric($_GET['minSalary'])) || (!empty($_GET['maxSalary']) && is_numeric($_GET['maxSalary']))) {
            $minSalary = (!empty($_GET['minSalary']) && is_numeric($_GET['minSalary'])) ? (float) $_GET['minSalary'] : NULL;
            $maxSalary = (!empty($_GET['maxSalary']) && is_numeric($_GET['maxSalary'])) ? (float) $_GET['maxSalary'] : NULL;

            $usuarios = $userModel->getUsersFilteredBySalaryRange($minSalary, $maxSalary);
        } else if ((!empty($_GET['minRet']) && is_numeric($_GET['minRet'])) || (!empty($_GET['maxRet']) && is_numeric($_GET['maxRet']))) {

            $min = (!empty($_GET['minRet']) && is_numeric($_GET['minRet'])) ? (int) $_GET['minRet'] : NULL;
            $max = (!empty($_GET['maxRet']) && is_numeric($_GET['maxRet'])) ? (int) $_GET['maxRet'] : NULL;

            $usuarios = $userModel->getUsersFilteredByRetentionRange($min, $max);
        } else {
            $usuarios = $userModel->getUsers();
        }

        $data = [];
        $data['titulo'] = 'Usuarios con filtros';
        $data['seccion'] = 'usuariosConFiltros';
        $data['breadcrumb'] = ['Usuarios con filtros'];
        $data['usuarios'] = $usuarios;
        $data['roles'] = $roles;
        $data['js'] = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/usuarios.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuariosConFiltros.view.php', 'templates/footer.view.php'), $data);
    }
}
