<?php
//hola 
// /* Conectar a una base de datos de MySQL Local */
// $db_host = 'mysql:dbname=style_spectrum;host=localhost';
// $usuario = 'root';
// $password = '';


// /* Conectar a una base de datos de MySQL remoto
// $db_host = 'mysql:dbname=id16840286_db_web;host=localhost';
// $usuario = 'id16840286_db_aplicaciones';
// $password = 'Utc_web2021*'; */
// try {
// 	$cnnPDO = new PDO("$db_host,$usuario, $password");
// 	echo "se conecto correctamente puto";

// } catch (PDOException $e) {

// 	echo "<br><br><center>
// 	<div class='card text-white bg-danger mb-3' style='max-width: 50rem;'>
// 	<div class='card-header'><h3>Error de Conexión</h3></div>
// 	<div class='card-body'>
// 	<h4 class='card-title'>Ha surgido un error y no se puede conectar a la base de datos!</h4>
// 	<h5 class='card-title'>Detalle:</h5>
// 	<p class='card-text text-white'>" . $e->getMessage() . "</p>
// 	</div>
// 	</div>
// 	";
// }



$host = 'DESKTOP-FP8PSR4';
$dbname = 'style_spectrum';
$username = 'luis';
$pasword = 'luis2002';
$puerto = 1433;

//phpinfo();
try {
	$cnnPDO = new PDO("sqlsrv:server=$host;Database=$dbname", $username, $pasword);
	// echo "Se conectó correctamen a la base de datos";
} catch (PDOException $exp) {
	echo ("No se logró conectar correctamente con la base de datos: $dbname, error: $exp");
}
return $cnnPDO;
?>