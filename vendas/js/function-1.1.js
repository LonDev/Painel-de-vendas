angular.module('app',[])
.controller("controller",
	function($scope,$http){
			//inicializa as metas.
			$scope.nva_meta = 0;
			$scope.mcz_meta = 0;
			
			$scope.nva_atingido = 0;
			$scope.mcz_atingido = 0;
			
			$scope.nva_meta = 0;
			$scope.mcz_meta = 0;

			$scope.mcz_concluido = 0;
			$scope.nva_concluido = 0;

			$scope.nva_fat = 0;
			$scope.mcz_fat = 0;

			var min = 02;
			var seg = 00;
			var itera_view = 0;
	//basca resultados do servidor
	buscaResultado = function(){
		$(".container, .container_super").fadeOut(1000).promise().done(function(){

			var url_comum = "controller/service.php";
			var url_force = url_comum; //"controller/service.php?up=t";

			var query = location.search.slice(1);
			var partes = query.split('&');
	//var data = {};
	
	partes.forEach(function (parte) {
		var chaveValor = parte.split('=');
		chave = chaveValor[0];
    //var valor = chaveValor[1];
    //data[chave] = valor;
});

	//força a atualização
	if(chave == 'up'){
		url = url_force;
		//redireciona para url comum
		setTimeout(function(){location = "/vendas/"},3000);
	}
	else
	{
		url = url_comum;
	}

	$http.get(url)
	.then(function(response){

		$scope.supervisores = response.data.supervisor;

		$scope.nva_meta = response.data.vendas.meta_nva;
		$scope.mcz_meta = response.data.vendas.meta_mcz;

		$scope.nva_fat = Number(response.data.vendas.fat_nva);
		$scope.mcz_fat = Number(response.data.vendas.fat_mcz);

		$scope.nva_atingido = response.data.vendas.atingido_nva;
		$scope.mcz_atingido = response.data.vendas.atingido_mcz;

		$scope.coroa_nva = response.data.vendas.coroa_nva;
		$scope.coroa_mcz = response.data.vendas.coroa_mcz;

		var data = new Date();
		dia = data.getDay();

		//reduz a meta se for sabado
		if(dia == 6){
			$scope.nva_meta = ($scope.nva_meta /2).toFixed(0);
			$scope.mcz_meta = ($scope.mcz_meta /2).toFixed(0);
		}

		//calcula percentual atingido
		$scope.nva_concluido = ($scope.nva_atingido / $scope.nva_meta * 100).toFixed(0);
		$scope.mcz_concluido = ($scope.mcz_atingido / $scope.mcz_meta * 100).toFixed(0);

		//calcula gap
		$scope.nva_gap = $scope.nva_meta - $scope.nva_atingido;
		$scope.mcz_gap = $scope.mcz_meta - $scope.mcz_atingido;

		if ($scope.nva_gap <= 0)
			$scope.nva_gap = 0;

		if ($scope.mcz_gap <= 0)
			$scope.mcz_gap = 0;

		$(".loading").fadeOut(1000).promise().done(function(){
			$(".container").fadeIn(1000);
		});
	});
})
	}
	calculaFundo = function(){
			//calcula o fundo de acordo com o horario
			var date = new Date();
			var hora = date.getHours();
			var fundo_manha = "url('img/morning.jpg')";
			var fundo_tarde = "url('img/midday.jpg')";
			var fundo_noite = "url('img/night.jpg')";

			if(hora <= 12){
				document.body.style.backgroundImage = fundo_manha;
			}
			else if(hora >= 13 && hora <= 18){
				document.body.style.backgroundImage = fundo_tarde;
			}
			else{
				document.body.style.backgroundImage = fundo_noite;
			}

		}

		mostrarContainer = function(){

			var supervisores 		= document.getElementById('container_super');
			var container_aviso		= document.getElementById('container_aviso');
			var container_aviso2	= document.getElementById('container_aviso1');
			var container 		 	= document.getElementById('container');
			var containers = [container_super,container];//,container_aviso, container_aviso2];
			
			//esconde todos os containers 
			for(i = 0; i < containers.length; i++){
				containers[i].style.display = 'none';
			}

			containers[itera_view].style.display = 'block';
			//console.log("mostrarContainer: "+containers[itera_view].id);
			
			itera_view++;

			if(itera_view >= containers.length)
				itera_view = 0;

		}

		temporiza = function(){
			
			if(min == 00 && seg == 00){
				min = 02;
				seg = 00;
				buscaResultado();
			}
			if (seg == 00) {
				seg = 59;
				min --;
			}

			document.title = "BBCap - Vendas - "+min +":"+seg;
			document.getElementById('counter').innerText = min +":"+seg;
			//console.log(min+":"+seg);
			seg --;
		}

		calculaFundo();
		buscaResultado();
		temporiza();
		//mostrarContainer();

		setInterval(temporiza, 1000);
		setInterval(calculaFundo,120 * 1000); //atualiza a cada 5 min
		setInterval(mostrarContainer,25 * 1000);
		
	});