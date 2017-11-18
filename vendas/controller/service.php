 <?php
 require_once("TestController.php");
 require_once('Connect.php');

$objConexao = new Conecta();
$objConexao->insereIp($_SERVER['REMOTE_ADDR']);

 $service = new Service();

 $service->main();
