<?php
/*
require_once('controller/Connect.php');

$objConexao = new Conecta();
$objConexao->insereIp($_SERVER['REMOTE_ADDR']);
*/
$url = @$_REQUEST['url'];

if(empty($url)){
	include_once('view/index.php');
}
else{
	$url = explode('/',$_REQUEST['url']);
	$page = $url[0].'.php';
	
	if(file_exists("view/$page")){
		include_once("view/$page");
	}
	else{
		include_once('view/404.php');
	}
}
