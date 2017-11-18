<!DOCTYPE html>
<?php require_once('header.php');?>
<body style="background: url('img/back.png');">
	<div class="container_import">
		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="arquivo">
			<br>
			<button>Salvar</button>
		</form>
		<?php 
		//verifica se o campo não esta vazio
		if(@$_FILES['arquivo']['name'] != "")
		{
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'],'supervisores.csv'))
			{
				require_once('controller/TestController.php');

				$service = new Service();
				
				if($service->insere_supervisor())
					echo "<strong>Supervisores cadastrados com sucesso.</strong>";
			}
		}

		?>
		<div class="info_import">
			<br>Faça upload de um arquivo .csv com os nomes dos supervisores e seus respectivos sites conforme o exemplo abaixo:<br>
			JOAO;MCZ<br>
			MARIA;NVA
			<br>
			<br>
			<p>
				<small>Todos os supervisores serão apagados para dar espaço aos novos.<br><b>Insira todos os supervisores.</b></small>	
			</p>	
		</div>
	</div>
</body>
</html>