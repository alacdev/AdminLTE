<div class="row">    
    <?php
    if (isset($resultado)) {
        ?>
        <div class="col-12">
            <div class="alert alert-success">                
                <?php
                        echo "<table class='table table-bordered table-striped'> <tr><th>Asignatura</th><th>Media</th><th>Suspensos</th><th>Aprobados</th><th>Alumno con la nota más alta</th><th></th><th>Alumno con la nota más baja</th></tr>";
                foreach ($resultado as $nombreMateria => $datosMateria) {
                        echo '<tr>';
                        echo '<th style=text-transform:capitalize>' . $nombreMateria . '</th>';
                        echo '<td>' . $datosMateria['media'] . '</td>';
                        echo '<td>' .  $datosMateria['suspensos'] . '</td>';
                        echo '<td>' .  $datosMateria['aprobados'] . '</td>';
                        echo '<td>' .  $datosMateria['max']['alumno'] . '</td>';
                        echo '<td>' .  $datosMateria['max']['nota'] . '</td>';
                        echo '<td>' .  $datosMateria['min']['alumno'] . '</td>';
                        echo '<td>' .  $datosMateria['min']['nota'] . '</td>';
                        echo '</tr>';
                }
                echo "</table>";
                ?>                
            </div>
        </div>
        <?php
    }
    if (isset($listado)) {
        ?>
        <div class="col-12">
            <div class="alert alert-success">                
                <?php
                        
                ?>                
            </div>
        </div>
        <?php
    }
    ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Procesar asignatura</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post"> -->
                <form method="post" action="/notas">  
                    <div class="mb-3">
                        <label for="mi_src">Array de notas :</label>
                        <textarea class="form-control" id="notas" name="notas" rows="3"><?php echo isset($input['notas']) ? $input['notas'] : ''; ?></textarea>
                        <p class="text-danger"><?php echo (isset($errores['notas'])) ? $errores['notas'] : ''; ?></p>
                    </div>                
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>
