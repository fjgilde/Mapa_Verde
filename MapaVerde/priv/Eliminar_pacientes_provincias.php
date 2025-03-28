<?php
require_once('db-connect.php');

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    //cerrar si la sentencia no es post
    $conn->close();
}

@$provincia = $_POST['provincia'];
@$id = $_POST['id'];
/*
@$codigo_postal = $_POST['codigo_postal'];
*/

//Selecciona todos los campos de los pacientes por provincia
$sql_prov = "SELECT * FROM pacientesv2 WHERE provincia = '$provincia'";
$consulta_prov = $conn->query($sql_prov);

/*
//Selecciona todos los campos de los pancientes por el codigo postal
$sql_codigopos = "SELECT * FROM pacientesv2 WHERE codigo_postal = '$codigo_postal'";
$consulta_codigo = $conn->query($sql_codigopos);

if(mysqli_num_rows(result: $consulta_codigo) == '0'){
    //Elimine todos los usuarios sin codigo postal
    $sql_del_cod = "DELETE * FROM pacientesv2 WHERE codigo_postal IS NULL";
    echo "Se ha eliminado los pancientes sin codigo postal";
}else{
}*/
    //Actualizar el apartado provincia para poder eliminarlo
    $prov_granada = "UPDATE pacientesv2 SET provincia = 'Granada' WHERE provincia IN ('granda', 'GRANADA', 'GRanada', 'Granad' )";

if (mysqli_num_rows(result: $consulta_prov) == '0') {
    //Elimina los pancientes que no tienen provincia asignada
    $sql_del_prov = "DELETE * FROM pacientesv2 WHERE provincia IS NULL";
    echo "Se han eliminado todos los pacientes que no han puesto provincias";
}else{
    //Elimina los pancientes que su provincia sea distintas 
    $sql_dis_gra = "DELETE * FROM pacientesv2 WHERE provincia != 'Granada";
    echo"Se han eliminado los pacientes que tienen una provincia distinta a Granada";
}

?>