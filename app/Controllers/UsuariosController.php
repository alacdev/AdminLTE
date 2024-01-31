<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use \PDO;

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
        $countryModel = new \Com\Daw2\Models\CountryModel();
        $countries = $countryModel->getCountries();

        $input = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        $userModel = new \Com\Daw2\Models\UsuarioModel();
        $usuarios = $userModel->filter($_GET);
        $numRegs = $userModel->getNumRegFilter($_GET);
        
        $copyGet = $_GET;
        unset($copyGet['order']);
        
        $pagMax = ceil ($numRegs[0]['total'] / $_ENV['page.size']);

        $data = [];
        $data['titulo'] = 'Usuarios con filtros';
        $data['seccion'] = 'usuariosConFiltros';
        $data['breadcrumb'] = ['Usuarios con filtros'];
        $data['usuarios'] = $usuarios;
        $data['roles'] = $roles;
        $data['countries'] = $countries;
        $data['input'] = $input;
        $data['order'] = $userModel->getOrder($_GET);
        $data['numRegs'] = $numRegs[0]['total'];
        $data['pagActual'] = $userModel->getPage($_GET);
        $data['pagMax'] = $pagMax;
        $data['parameters'] = http_build_query($copyGet);
        $data['js'] = array('plugins/select2/js/select2.full.min.js', 'assets/js/pages/usuarios.view.js', 'assets/js/pages/usuariosConFiltros.view.js');

        $this->view->showViews(array('templates/header.view.php', 'usuariosConFiltros.view.php', 'templates/footer.view.php'), $data);
    }
}
