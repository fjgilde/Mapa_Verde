<?php

@session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('PÁGINA RESTRINGIDA');</script>";
} else {
    include('navbar.php');
    include('db-connect.php');

    if (isset($_POST['alta'])) {

        include('db-connect.php');

        $nuevo_empleado = $_POST['nuevo_empleado'];
        $departamento = $_POST['departamento'];
        $color = $_POST['color'];
        $dias_disponibles = $_POST['dias_disponibles'];

        $dias_disponibles = implode($dias_disponibles); //Juntar array en una string


        $sql = "SELECT * FROM empleados WHERE color = '$color'";

        if (!$consulta = $conn->query($sql)) {
            echo "ERROR: no se pudo ejecutar la consulta!";
        } else {
            $filas = mysqli_num_rows($consulta);

            if ($filas == 1) {
                $error_usuario = "<style>#error_usuario{display: inline-block;}</style>Elija otro color. Color repetido.";
            } else {
                $q = "INSERT INTO empleados (color, id_departamento, nombre, disponible) VALUES ('$color', '$departamento', '$nuevo_empleado', '$dias_disponibles')";

                if (!mysqli_query($conn, $q)) {
                } else {
                    $nueva_alta_ok = "<style>#nueva_alta_ok{display: inline-block;}</style>Nueva alta correcta <i class='bi bi-check-circle-fill'></i>";
                }
            }
        }
    }


    if (isset($_POST['editar_nombre_empleado'])) {

        include('db-connect.php');

        $empleado_a_editar = $_POST['empleado_a_editar'];
        $editar_nombre = $_POST['editar_nombre'];


        $q = "UPDATE empleados SET nombre = '$editar_nombre' WHERE color = '$empleado_a_editar'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $editar_ok = "<style>#editar_ok{display: inline-block;}</style>Editado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }

    if (isset($_POST['editar_departamento'])) {

        include('db-connect.php');

        $empleado_a_editar = $_POST['empleado_a_editar'];
        $otro_departamento = $_POST['otro_departamento'];


        $q = "UPDATE empleados SET id_departamento = '$otro_departamento' WHERE color = '$empleado_a_editar'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $editar_ok = "<style>#editar_ok{display: inline-block;}</style>Editado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }

    if (isset($_POST['editar_disponibles'])) {

        include('db-connect.php');

        $empleado_a_editar = $_POST['empleado_a_editar'];
        $editar_dias_disponibles = $_POST['editar_dias_disponibles'];

        $editar_dias_disponibles = implode($editar_dias_disponibles); //Juntar array en una string

        $q = "UPDATE empleados SET disponible = '$editar_dias_disponibles' WHERE color = '$empleado_a_editar'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $editar_ok = "<style>#editar_ok{display: inline-block;}</style>Editado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }

    if (isset($_POST['editar_color'])) {

        include('db-connect.php');

        $empleado_a_editar = $_POST['empleado_a_editar'];
        $color_editado = $_POST['color_editado'];

        $q = "UPDATE empleados SET color = '$color_editado' WHERE color = '$empleado_a_editar'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $editar_ok = "<style>#editar_ok{display: inline-block;}</style>Editado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }


    if (isset($_POST['baja'])) {

        include('db-connect.php');


        $color = $_POST['color'];

        $q = "UPDATE empleados SET estado = 'baja' WHERE color = '$color'";

        if (!mysqli_query($conn, $q)) {
            echo "Error: " . $q . "<br>" . mysqli_error($conexion);
        } else {
            $baja_ok = "<style>#baja_ok{display: inline-block;}</style>Empleado borrado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }

    if (isset($_POST['alta_usuario'])) {

        include('db-connect.php');

        $nuevo_usuario = $_POST['nuevo_usuario'];
        $nueva_pass = $_POST['nueva_pass'];
        $rol = $_POST['rol'];
        $usuario_empleado = $_POST['usuario_empleado'];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$nuevo_usuario'";

        if (!$consulta = $conn->query($sql)) {
            echo "ERROR: no se pudo ejecutar la consulta!";
        } else {
            $filas = mysqli_num_rows($consulta);

            if ($filas == 1) {
                $error_nuevo_usuario = "<style>#error_nuevo_usuario{display: inline-block;}</style>Ese usuario ya existe";
            } else {
                $q = "INSERT INTO usuarios (usuario, passw, rol, empleado) VALUES ('$nuevo_usuario', '$nueva_pass', '$rol', '$usuario_empleado')";

                if (!mysqli_query($conn, $q)) {
                } else {
                    $nuevo_usuario_ok = "<style>#nuevo_usuario_ok{display: inline-block;}</style>Nueva alta correcta <i class='bi bi-check-circle-fill'></i>";
                }
            }
        }
    }

    if (isset($_POST['alta_departamento'])) {

        include('db-connect.php');

        $nuevo_departamento = $_POST['nuevo_departamento'];

        $q = "INSERT INTO departamentos (nombre_departamento) VALUES ('$nuevo_departamento')";

        if (!mysqli_query($conn, $q)) {
        } else {
            $nuevo_dept_ok = "<style>#nuevo_dept_ok{display: inline-block;}</style>Guardado correctamente <i class='bi bi-check-circle-fill'></i>";
        }
    }

    if (isset($_POST['duracion_cita'])) {

        include('db-connect.php');

        $dep_duracion_cita = $_POST['dep_duracion_cita'];
        $duracion = $_POST['duracion'];


        $q = "UPDATE departamentos SET tiempo_cita = '$duracion' WHERE id_departamento = '$dep_duracion_cita'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $duracion_cita_ok = "<style>#duracion_cita_ok{display: inline-block;}</style>Guardado correctamente <i class='bi bi-check-circle-fill'></i>";

        }
    }

    if (isset($_POST['duracion_cita_null'])) {

        include('db-connect.php');

        $dep_duracion_cita = $_POST['dep_duracion_cita'];

        $q = "UPDATE departamentos SET tiempo_cita = NULL WHERE id_departamento = '$dep_duracion_cita'";

        if (!mysqli_query($conn, $q)) {
        } else {
            $duracion_cita_ok = "<style>#duracion_cita_ok{display: inline-block;}</style>Guardado correctamente <i class='bi bi-check-circle-fill'></i>";

        }
    }
    //Inserccion de nueva mutua
    if(isset($_POST['alta_mutua'])){

    include('db-connect.php');

    $nueva_mutua = $_POST['nueva_mutua'];

    $query = "INSERT INTO mutuas (nombre_mutua) VALUES ('$nueva_mutua')";
    if(!mysqli_query($conn, $query)){
        echo"No lo inserta";
    }else{
        echo"Lo inserta";
        $nueva_mutua_ok = "<style>#nueva_mutua:ok{display: inline-block;}</style>Guardado correctamente <i class='bi bi-check-circle-fill'></i>";
    }
    }
       
?>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
        $(document).ready(function() {
            $('#mostrar_contrasena, #mostrar_contrasena2, #mostrar_contrasena3').click(function() {
                if ($('#mostrar_contrasena, #mostrar_contrasena2, #mostrar_contrasena3').is(':checked')) {
                    $('.passw').attr('type', 'text');
                } else {
                    $('.passw').attr('type', 'password');
                }
            });

            $("#select_dias").multipleSelect({
                filter: true
            });
            $("#select_dias2").multipleSelect({
                filter: true
            });

        });
    </script>
    <div class="container justify-content-center">


        <div class="row">
            <!-- Nuevo empleado -->
            <div class="col-md-3 col-xs-12" align="center">

                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Nuevo empleado
                    </button>
                </p>
                <div class="collapse show" id="collapseExample">
                    <div class="card card-body">

                        <form action="" method="POST" id="form_control">
                            <label>Inserte nombre del empleado, departamento y el color identificativo:</label><br /><br />
                            <input required type="text" name="nuevo_empleado" placeholder="Nombre empleado"><br /><br />
                            <select required name="departamento" id="departamento">
                            <!-- selecciona todo de departamentos -->   
                            <option value="" disabled selected>Departamento</option>
                                <?php
                                $consulta = $conn->query("SELECT * FROM departamentos");

                                while ($row = $consulta->fetch_assoc()) {

                                    echo '<option value="' . $row["id_departamento"] . '">' . $row["nombre_departamento"] . '</option>';
                                }
                                ?>
                            </select><br /><br />
                            <label>Selecciona un color identificativo</label><br /><input required type="color" name="color" value="#000000"><br />

                            <label>Seleccione los días de disponibilidad</label>
                            <!-- A multiple select element -->
                            <select id="select_dias" multiple="multiple" name="dias_disponibles[]">
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                            </select>
                            <br />
                            <div class="alert alert-danger" id="error_usuario" role="alert"><?php echo @$error_usuario; ?></div><br />
                            <br />
                            <div class="alert alert-success" id="nueva_alta_ok" role="alert"><?php echo @$nueva_alta_ok; ?></div><br />
                            <input type="submit" name="alta" value="Dar de alta"><br /><br /><br />
                        </form>
                    </div>
                </div>
            </div>



            <!-- Editar empleado -->
            <div class="col-md-3 col-xs-12" align="center">

                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                        Editar empleado
                    </button>
                </p>
                <div class="collapse show" id="collapseExample1">
                    <div class="card card-body">

                        <form action="" method="POST" id="form_control4">
                            <label for="empleado_a_editar">Seleccione empleado que quiere editar</label>
                            <select class="form-control chosen-select" required name="empleado_a_editar" id="empleado_a_editar">
                                <option value="" disabled selected></option>
                                <?php
                                //Generar el select con los empleados separados por departamentos
                                $consulta_d = $conn->query("SELECT COUNT(*) as num FROM departamentos");
                                while ($row = $consulta_d->fetch_assoc()) {
                                    $num_departamentos = $row['num'];
                                }
                                for ($i = 1; $i <= $num_departamentos; $i++) {

                                    $consulta2 = $conn->query("SELECT nombre_departamento FROM departamentos WHERE id_departamento = '$i'");
                                    while ($fila = mysqli_fetch_array($consulta2)) {

                                        $nombre = $fila['nombre_departamento'];
                                    }

                                    echo '<optgroup label="' . $nombre . '">';
                                    mysqli_free_result($consulta2);
                                    $consulta = $conn->query("SELECT color, nombre FROM empleados INNER JOIN departamentos Where empleados.id_departamento = '$i' AND departamentos.id_departamento = '$i' AND empleados.estado = 'alta'");

                                    while ($row = $consulta->fetch_assoc()) {
                                        echo '<option value="' . $row["color"] . '">' . $row["nombre"] . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                ?>
                            </select>
                            <label>Nuevo nombre</label><br /><input type="text" name="editar_nombre" value=""><br /><br />
                            <input type="submit" name="editar_nombre_empleado" value="Editar nombre empleado"><br /><br />
                            <label>Especialidad</label><br />
                            <select required name="otro_departamento" id="otro_departamento">
                                <?php
                                $consulta = $conn->query("SELECT * FROM departamentos");

                                while ($row = $consulta->fetch_assoc()) {

                                    echo '<option value="' . $row["id_departamento"] . '">' . $row["nombre_departamento"] . '</option>';
                                }
                                ?>
                            </select><br /><br />
                            <input type="submit" name="editar_departamento" value="Editar especialidad empleado"><br /><br />
                            <!-- A multiple select element -->
                            <label>Días disponibles</label><br />
                            <select id="select_dias2" multiple="multiple" name="editar_dias_disponibles[]">
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                            </select>
                            <br /><br />
                            <input type="submit" name="editar_disponibles" value="Editar días empleado"><br /><br />
                            <br />
                            <label>Editar color del empleado</label><br /><input required type="color" name="color_editado" value="#000000"><br />
                            <input type="submit" name="editar_color" value="Editar color empleado"><br /><br />
                            <div class="alert alert-success" id="editar_ok" role="alert"><?php echo @$editar_ok; ?></div><br />
                        </form>
                    </div>
                </div>
            </div>



            <!-- Borrar empleado -->
            <div class="col-md-3 col-xs-12" align="center">

                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                        Borrar empleado
                    </button>
                </p>

                <div class="collapse show" id="collapseExample2">
                    <div class="card card-body">
                        <form action="" method="POST" id="form_control2">
                            <label for="color">Selecciona empleado para darlo de baja:</label><br /><br />

                            <select required name="color" id="color">
                                <option value="" disabled selected>-----</option>
                                <?php

                                $consulta_d = $conn->query("SELECT COUNT(*) as num FROM departamentos");
                                //$num_departamentos = $mysqli_num_rows($consulta_d);
                                while ($row = $consulta_d->fetch_assoc()) {
                                    $num_departamentos = $row['num'];
                                }
                                for ($i = 1; $i <= $num_departamentos; $i++) {

                                    $consulta2 = $conn->query("SELECT * FROM departamentos WHERE id_departamento = '$i'");
                                    while ($fila = mysqli_fetch_array($consulta2)) {

                                        $nombre = $fila['nombre_departamento'];
                                    }

                                    echo '<optgroup label="' . $nombre . '">';
                                    mysqli_free_result($consulta2);
                                    $consulta = $conn->query("SELECT * FROM empleados INNER JOIN departamentos Where empleados.id_departamento = '$i' AND departamentos.id_departamento = '$i' AND empleados.estado = 'alta'");

                                    while ($row = $consulta->fetch_assoc()) {
                                        echo '<option value="' . $row["color"] . '">' . $row["nombre"] . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                ?>
                            </select><br /><br />
                            <!--<p style="color: red;">¡Atención! Esta opción eliminará todos los eventos del empleado</p><br/>-->

                            <br />
                            <div class="alert alert-success" id="baja_ok" role="alert"><?php echo @$baja_ok; ?></div><br />
                            <input type="submit" name="baja" value="Dar de baja"><br /><br /><br />
                        </form>
                    </div>
                </div>
            </div>

            <!-- Nuevo usuario inicio de sesión -->
            <div class="col-md-3 col-xs-12" align="center">
                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                        Nuevo usuario
                    </button>
                </p>

                <div class="collapse show" id="collapseExample3">
                    <div class="card card-body">

                        <form action="" method="POST" id="form_control3">
                            <label>Inserte nombre del usuario y contraseña:</label><br /><br />
                            <input required type="text" name="nuevo_usuario" maxlength="12"  placeholder="Nombre usuario"><br /><br />
                            <div><input required class="passw" type="password" maxlength="12"  name="nueva_pass" placeholder="Contraseña"><br /><input type="checkbox" id="mostrar_contrasena" title="Clic para mostrar contraseña" />Mostrar Contraseña</div><br /><br />
                            <br /><select required name="rol">
                                <option value="trabajador" selected>Trabajador</option>
                                <option value="admin">Admin</option>
                            </select><br />
                            <label for="empleado_a_editar">Seleccione empleado</label>
                            <select class="form-control chosen-select" required name="usuario_empleado" id="usuario_empleado">
                                <option value="" disabled selected></option>
                                <?php
                                //Generar el select con los empleados separados por departamentos
                                $consulta_d = $conn->query("SELECT COUNT(*) as num FROM departamentos");
                                while ($row = $consulta_d->fetch_assoc()) {
                                    $num_departamentos = $row['num'];
                                }
                                for ($i = 1; $i <= $num_departamentos; $i++) {

                                    $consulta2 = $conn->query("SELECT nombre_departamento FROM departamentos WHERE id_departamento = '$i'");
                                    while ($fila = mysqli_fetch_array($consulta2)) {

                                        $nombre = $fila['nombre_departamento'];
                                    }

                                    echo '<optgroup label="' . $nombre . '">';
                                    mysqli_free_result($consulta2);
                                    $consulta = $conn->query("SELECT color, nombre FROM empleados INNER JOIN departamentos Where empleados.id_departamento = '$i' AND departamentos.id_departamento = '$i' AND empleados.estado = 'alta'");

                                    while ($row = $consulta->fetch_assoc()) {
                                        echo '<option value="' . $row["color"] . '">' . $row["nombre"] . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                ?>
                            </select>
                            <br />
                            <div class="alert alert-danger" id="error_nuevo_usuario" role="alert"><?php echo @$error_nuevo_usuario; ?></div><br />
                            <br />
                            <div class="alert alert-success" id="nuevo_usuario_ok" role="alert"><?php echo @$nuevo_usuario_ok; ?></div><br />
                            <input type="submit" name="alta_usuario" value="Dar de alta"><br /><br /><br />
                        </form>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <!-- Nuevo departamento -->
            <div class="col-md-3 col-xs-12" align="center">
                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">
                        Nueva especialidad
                    </button>
                </p>

                <div class="collapse show" id="collapseExample4">
                    <div class="card card-body">

                        <form action="" method="POST" id="form_control5">
                            <label>Inserte nombre de la especialidad:</label><br /><br />
                            <input required type="text" name="nuevo_departamento" placeholder="Nombre especialidad"><br /><br />
                            

                            <div class="alert alert-success" id="nuevo_dept_ok" role="alert"><?php echo @$nuevo_dept_ok; ?></div><br />
                            <input type="submit" name="alta_departamento" value="Guardar"><br /><br /><br />
                        

                                     </form>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-xs-12" align="center">
                <p>
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample5">
                        Duración cita por especialidad
                    </button>
                </p>

                <div class="collapse show" id="collapseExample5">
                    <div class="card card-body">

                        <form action="" method="POST" id="form_control6">
                            <label>Especialidad</label><br />
                            <select required name="dep_duracion_cita" id="dep_duracion_cita">
                                <?php
                                $consulta = $conn->query("SELECT * FROM departamentos");

                                while ($row = $consulta->fetch_assoc()) {

                                    echo '<option value="' . $row["id_departamento"] . '">' . $row["nombre_departamento"] . '</option>';
                                }
                                ?>
                            </select><br />
                            <label>Inserte duración de la cita (minutos):</label><br /><br />
                            <input  type="number" name="duracion" placeholder="Duración (minutos)"><br /><br />

                            <div class="alert alert-success" id="duracion_cita_ok" role="alert"><?php echo @$duracion_cita_ok; ?></div><br />
                            <input type="submit" name="duracion_cita" value="Guardar"><br /><br />
                            <input type="submit" name="duracion_cita_null" value="Restablecer por defecto"><br /><br />
                        </form>
                    </div>

                </div>
            </div>

        <!-- Nueva mutua -->
        <div class="col-md-3 col-xs-12" align="center">
        <p>
            <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6">
            Nueva Mutua
            </button>
        </p>
        <div class="collapse show" id="collapseExample6">
            <div class="card card-body">
            <form action="" method="POST" id="form_control6">
                <label>Inserte nombre de la mutua:</label><br /><br />
                <input required type="text" name="nueva_mutua" placeholder="Nombre de la mutua"><br /><br />             
                
                <?php /**<div class="alert alert-success" id="nueva_mutua_ok" role="alert"><?php // echo @$nueva_mutua_ok; ?></div><br />
                  */ ?>
                <input type="submit" name="alta_mutua" value="Guardar"><br /><br /><br />
            </form>
            </div>

            </div>
        </div>
    </div>
    </div>
    <div id="footer">@Copyright Delta Gestión y Control de Sistemas S.L.</div>

    </body>

    </html>

<?php } ?>