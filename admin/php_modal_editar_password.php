<?php
session_start();
$usuarioR = $_POST['usuario'];
$miUsuario = $_SESSION['usuarioSession'];
        ?>
        <div class="container" >                
                <div class="form-group">
                    <div class="form-row">
                        <label for="passNueva">Nueva contraseña</label>
                        <input type="password" class="form-control mb-3" id="passNueva" title="Nueva contraseña" value="">
                    </div>
                    <div class="form-row">
                        <label for="passConfirmar">Confirmar nueva contraseña</label>
                        <input type="password" class="form-control mb-3" id="passConfirmar" title="Confirmar nueva contraseña" value="">
                    </div>
                    <button id="btn_actualizarPassoword" type="button" class="btn btn-danger" onclick="cambiar_password('<?php echo $usuarioR; ?>','<?php echo $miUsuario; ?>')">Actualizar</button>
                </div>
        </div>

