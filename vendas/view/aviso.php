
<?php
require_once("controller/connect.php");

$objConexao = new Conecta();

if(isset($_REQUEST['titulo']) && isset($_REQUEST['mensagem']))
{
	if($objConexao->atualizar_aviso($_REQUEST['titulo'],$_REQUEST['mensagem'])){

		unset($_REQUEST['titulo']);
		unset($_REQUEST['mensagem']);

		echo "<div style='background: #b3ffb3;border: 1px solid green; color:green;'>
		<center>Salvo com sucesso.</center>
		</div>";
	}
	else{
		echo "<div style='background: #ff4d4d;border: 1px solid red; color:red;'>
		<center>Erro ao salvar.</center>
		</div>";
	}
}

$dados = $objConexao->buscar_aviso();

$titulo = $dados['titulo'];
$mensagem = $dados['mensagem'];

?>
<html ng-app="app">
<head>
	<title>BBCap - Escrever Aviso</title>
	<link rel="stylesheet" type="text/css" href="css/style2.css">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	
</head>
<body ng-controller="controller">
	<div class="container_aviso">
		<form method="POST">
			<p align="right">
				<button>Salvar</button>
			</p>
			Titulo:<input type="text" name="titulo" value="<?php echo @$titulo;?>"><br>
			<br>
			<textarea name="mensagem"><?php echo @$mensagem;?></textarea>
		</form>
	</div>
	<div style="clear: both"></div>
	<div class="rodape">
		Desenvolvido por <b><i>Odilon Silva</i></b>
	</div>
</body>
</html>