<?php
/*
$dbName = '10.221.230.72';
$db_database = 'db_BrasilCap_Neoflow_PDB';
$dbuser = 'NEOBPO/odilon.silva';
$dbpass = 'tivit,isa7';

try{
//$pdo = new PDO("odbc:mssql;SERVERNAME=mssql;DATABASE=.$dbName,$dbuser, $dbpass");
$pdo = new PDO("odbc:Server=$dbName;Database=$db_database","$dbuser","$dbpass");

} catch (PDOException $e) {
    echo "Erro de Conexão " . $e->getMessage() . "\n";
    exit;
  }








*/?>
<html ng-app="app">
<head>
	<title>BBCap - test</title>

	<link rel="stylesheet" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="/vendas/css/style2.css">
	<link rel="shortcut icon" type="image/x-icon" href="/vendas/favicon.ico" />
	<script src="/vendas/js/jquery-1.12.4.min.js?1.5"></script>
	<script src="/vendas/js/angular.min.js?1.5"></script>
	<script type="text/javascript">
		angular.module('app',[]).controller('controller',function($scope){
			$scope.supervisores = [{"nome":"NATASHA","venda":34},{"nome":"ALEX","venda":30},{"nome":"RAFAEL","venda":22},{"nome":"KATILA","venda":20},{"nome":"ALOISIO","venda":5},{"nome":"ANTONIA","venda":0},{"nome":"OSMAR","venda":0},{"nome":"TAMIRIS","venda":10}]; 

			var date = new Date();
			var hora = date.getHours();
			var fundo_manha = "url('img/morning.jpg')";
			var fundo_tarde = "url('img/midday.jpg')";
			var fundo_noite = "url('img/back.jpg')";

			if(hora <= 12){
				document.body.style.backgroundImage = fundo_manha;
			}
			else if(hora >= 13 && hora <= 18){
				document.body.style.backgroundImage = fundo_tarde;
			}
			else{
				document.body.style.backgroundImage = fundo_noite;
			}

		});
	</script>

	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body ng-controller="controller">
	<div class="container-fluid">
		<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval='2000' data-pause='null'>
			
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
					<div id="container_result" class="container_result">
						<div class="nva_venda">
							<div id="coroa_nva">
								<img src="img/coroa.png" width="50" height="50" />
							</div>
							<h2>NVA</h2>
							<div id="result">32</div>
							<div class="metas">
								Meta: 174
							</div>
							<div class="atingido">
								Atingido: 54%
							</div>
							<div class="gap">
								Faltam: 12
							</div>
						</div>
						<div class="mogi_venda">
							<div id="coroa_mcz">
								<img src="img/coroa.png" width="50" height="50" />
							</div>
							<h2>MCZ</h2>
							<div id="result">30</div>
							<div class="metas">
								Meta: 132
							</div>
							<div class="atingido">
								Atingido: 50%
							</div>

							<div class="gap">
								Faltam: 22
							</div>
						</div>
					</div>

				</div>

				<div class="item">
					<div  id="container_super" class="container_super entrar">
						<div id="super" ng-repeat="super in supervisores">
							<img ng-show='$index == 0' src="img/coroa.png" width="40" height="40" />
							<tag ng-bind=' super.nome +": "+ super.venda'/>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>

	<div class="rodape">
		Desenvolvido por <b><i>Odilon Silva</i></b>
	</div>
</body>
</html>
