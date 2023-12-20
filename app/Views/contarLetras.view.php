<div class="row">    
    <?php
    if(isset($resultado)){        
        ?>
    <div class="col-12">
        <div class="alert alert-success">
            <?php
                foreach ($resultado as $caracter => $apariciones){
                echo "<p>$caracter: $apariciones</p>";
                }
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
                <h6 class="m-0 font-weight-bold text-primary">Contar letras</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="/contarLetras">  
                    <div class="mb-3">
                        <label for="texto">Palabra:</label>
                        <input class="form-control" id="texto" type="text" name="texto" placeholder="Palabra a comprobar" value="<?php echo isset($input['texto']) ? $input['texto'] : ''; ?>">                        
                        <p class="text-danger"><?php echo isset($errores['texto']) ? $errores['texto'] : ''; ?></p>
                    </div>                         
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>
