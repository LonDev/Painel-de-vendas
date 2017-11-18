<?php require_once('header.php');?>
<body ng-app="app"  ng-controller="controller">
	<div class="hora_passada">
		<tag id='counter'/>
	</div>
	<div  id="container_super" class="container_super">
		<div id="super" ng-repeat="super in supervisores">
			<img ng-show='$index == 0' src="img/coroa.png" width="40" height="40" />
			<tag ng-bind=' super.nome +": "+ super.venda'/>
		</div>
	</div>
	<div id="container" class="container">
		<div class="nva_venda">
			<div class='container_coroa'>
				<div id="coroa_nva" ng-show='coroa_nva'>
					<img src="img/coroa.png" width="50" height="50" />
				</div>
			</div>
			<h2>NVA</h2>
			<div id="result"><tag ng-bind='nva_atingido'/></div>
			<div class="metas">
				Meta: <tag ng-bind='nva_meta'/>
			</div>
			<div class="atingido">
				Atingido: <tag ng-bind='nva_concluido +"%"'/>
			</div>
			<div class="gap">
				Faltam: <tag ng-bind='nva_gap'/>
			</div>
			<div class="metas">
				Faturamento: R$<tag ng-bind='nva_fat | number'/>
			</div>
		</div>
		<div class="mogi_venda">
			<div class="container_coroa">
				<div id="coroa_mcz" ng-show='coroa_mcz'>
					<img src="img/coroa.png" width="50" height="50" />
				</div>
			</div>
			<h2>MCZ</h2>
			<div id="result"><tag ng-bind='mcz_atingido'/></div>
			<div class="metas">
				Meta: <tag ng-bind='mcz_meta'/>
			</div>
			<div class="atingido">
				Atingido: <tag ng-bind='mcz_concluido +"%"'/>
			</div>

			<div class="gap">
				Faltam: <tag ng-bind='mcz_gap'/>
			</div>
			<div class="metas">
				Faturamento: R$<tag ng-bind='mcz_fat | number'/>
			</div>
		</div>
	</div>
	<div id="container_aviso" class="container_aviso">
		<!--h1><tag ng-bind='titulo'/></h1-->
		<div class="aviso">
			<img src="img/ppt1.jpg" />
			<!--textarea ng-bind='mensagem'/></textarea-->
		</div>
	</div>
	<div id="container_aviso1" class="container_aviso">
		<!--h1><tag ng-bind='titulo'/></h1-->
		<div class="aviso">
			<img src="img/ppt2.jpg" />
			<!--textarea ng-bind='mensagem'/></textarea-->
		</div>
	</div>
	
	<div style="clear: both"></div>
	<div class="loading">
		<img src="img/loading.gif" />
		<br>
		Carregando...
	</div>
	<div class="rodape">
		Desenvolvido por <b><i>Odilon Silva</i></b>
	</div>
</body>
</html>