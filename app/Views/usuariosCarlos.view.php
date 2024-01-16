<div class="row">    
    <?php
    if (isset($usuarios)) {
        ?>
        <div class="col-12">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabla de usuarios</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table id='usuarioTable' class='table table-bordered table-striped'> <tr><th>Nombre del usuario</th><th>Rol</th><th>Salario Bruto</th><th>Retención IRPF</th></tr>
                        <?php
                        foreach ($usuarios as $usuario => $datosUsuario) {
                            if ($datosUsuario['activo'] == 0) {
                                echo '<tr style="background-color: rgba(255, 0, 0, 0.75);">';
                            } else {
                                echo '<tr>';
                            }
                            echo '<td>' . $datosUsuario['username'] . '</td>';
                            echo '<td>' . $datosUsuario['rol'] . '</td>';
                            echo '<td>' . $datosUsuario['salarioBruto'] . '</td>';
                            echo '<td>' . $datosUsuario['retencionIRPF'] . '</td>';
                            echo '</tr>';
                        }
                        ?> 
                    </table>
                </div>
            </div>
        </div>  
        <?php
    }
    ?>                      
</div>
