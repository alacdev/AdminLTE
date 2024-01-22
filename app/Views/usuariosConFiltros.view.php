<!--Inicio HTML -->
<div class="row">       
    <?php
    if ($_ENV['app.debug'] & isset($_GET)) {
        ?>
        <div class="col-6">
            <div class="alert alert-info">
                <?php var_dump($_GET); ?>
            </div>
        </div>
        <div class="col-6">
            <div class="alert alert-info">
                <?php var_dump($input); ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">      
                <input id="order" name="order" type="hidden" value="<?php echo $order; ?>"/> 
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">

                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control select2" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']; ?>" <?php echo (isset($input['id_rol']) && $rol['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo ucfirst($rol['nombre_rol']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" value="<?php echo (isset($input['username'])) ? $input['username'] : ''; ?>" />
                            </div>
                        </div> 
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="salario">Salario:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_salar" id="min_salar" value="<?php echo isset($input['min_salar']) ? $input['min_salar'] : ''; ?>" placeholder="Mí­nimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salar" id="max_salar" value="<?php echo isset($input['max_salar']) ? $input['max_salar'] : ''; ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="retencion">Retención:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_ret" id="min_ret" value="<?php echo isset($input['min_ret']) ? $input['min_ret'] : ''; ?>" placeholder="Mí­nima" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_ret" id="max_ret" value="<?php echo isset($input['max_ret']) ? $input['max_ret'] : ''; ?>" placeholder="Máxima" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_country">Paises:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2" data-placeholder="Países" multiple>                                    
                                    <?php foreach ($countries as $pais) { ?>
                                        <option value="<?php echo $pais['id']; ?>" <?php echo (isset($input['id_country']) && in_array($pais['id'], $input['id_country'])) ? 'selected' : ''; ?>><?php echo $pais['country_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>                         
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">                     
                        <a href="/usuariosConFiltros" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>    
    <div class="col-12">
        <?php
        if (count($usuarios) > 0) {
            ?>
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <table id="tabladatos" class="table table-striped">                    
                        <thead>
                            <tr>
                                <th><a href="/usuariosConFiltros?order=<?php echo ($order == 1) ? '-' : ''; ?>1&<?php echo $parameters; ?>">Nombre usuario</a> <?php echo (abs($order) == 1) ? '<i class="fas fa-sort-amount-' . ($order < 0 ? 'up' : 'down') . '-alt">' : ''; ?></th>
                                <th><a href="/usuariosConFiltros?order=<?php echo ($order == 2) ? '-' : ''; ?>2&<?php echo $parameters; ?>">Rol</a> <?php echo (abs($order) == 2) ? '<i class="fas fa-sort-amount-' . ($order < 0 ? 'up' : 'down') . '-alt">' : ''; ?></th>
                                <th><a href="/usuariosConFiltros?order=<?php echo ($order == 3) ? '-' : ''; ?>3&<?php echo $parameters; ?>">Salario bruto</a> <?php echo (abs($order) == 3) ? '<i class="fas fa-sort-amount-' . ($order < 0 ? 'up' : 'down') . '-alt">' : ''; ?></th>
                                <th><a href="/usuariosConFiltros?order=<?php echo ($order == 4) ? '-' : ''; ?>4&<?php echo $parameters; ?>">Retención</a> <?php echo (abs($order) == 4) ? '<i class="fas fa-sort-amount-' . ($order < 0 ? 'up' : 'down') . '-alt">' : ''; ?></th> 
                                <th><a href="/usuariosConFiltros?order=<?php echo ($order == 5) ? '-' : ''; ?>5&<?php echo $parameters; ?>">País</a> <?php echo (abs($order) == 5) ? '<i class="fas fa-sort-amount-' . ($order < 0 ? 'up' : 'down') . '-alt">' : ''; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $u) {
                                ?>
                                <tr class="<?php echo $u['activo'] == 0 ? 'table-danger' : ''; ?>">
                                    <td><?php echo $u['username']; ?></td>
                                    <td><?php echo $u['rol']; ?></td>
                                    <td><?php echo number_format($u['salarioBruto'], 2, ',', '.'); ?></td>
                                    <td><?php echo $u['retencionIRPF']; ?>%</td>  
                                    <td><?php echo $u['country_name']; ?></td>
                                </tr>                    
                                <?php
                            }
                            ?>
                        </tbody>                    
                    </table>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning">No se han encontrado usuarios que cumplan los requisitos.</div>
            <?php
        }
        ?>
    </div>                        
</div>
<!--Fin HTML -->