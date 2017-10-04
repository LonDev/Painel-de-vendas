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
			var min = 02;
			var seg = 00;

	//basca resultados do servidor
	buscaResultado = function(){
		$(".container, .container_super").fadeOut(1200).promise().done(function(){

			var url_comum = "controller/service.php";
			var url_force = "controller/service.php?up=t";

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
		$scope.nva_meta = response.data.vendas.meta_nva;
		$scope.mcz_meta = response.data.vendas.meta_mcz;

		$scope.nva_atingido = response.data.vendas.atingido_nva;
		$scope.mcz_atingido = response.data.vendas.atingido_mcz;

		$scope.nva_gap = $scope.nva_meta - $scope.nva_atingido;
		$scope.mcz_gap = $scope.mcz_meta - $scope.mcz_atingido;

		$scope.supervisores = response.data.supervisor;

		if ($scope.nva_gap <= 0)
			$scope.nva_gap = 0;

		if ($scope.mcz_gap <= 0)
			$scope.mcz_gap = 0;

		$scope.conversao_dia = (response.data.vendas.conversao * 100).toFixed(1);
		$scope.localizacao_dia = (response.data.vendas.localizacao * 100).toFixed(1);

		$(".loading").fadeOut(1000).promise().done(function(){
			$(".container").fadeIn(1200);
		})

		calculaCoroa($scope.nva_atingido, $scope.mcz_atingido, $scope.nva_meta, $scope.mcz_meta);

					//console.log(response.data.vendas);
				});
})
	}
		//calcula a posição da coroa
		calculaCoroa = function(nva,mcz, nva_meta, mcz_meta){
			nva_coroa = (nva / nva_meta * 100).toFixed(0);
			mcz_coroa = (mcz / mcz_meta * 100).toFixed(0);

			/*
			var coroa_mcz = document.getElementById('coroa_mcz');
			var coroa_nva = document.getElementById('coroa_nva');


			if(mcz_coroa > nva_coroa){
				coroa_mcz.style.visibility ='visible';
				coroa_nva.style.visibility ='hidden';
				console.log(mcz_coroa);
			}
			else if(nva_coroa > mcz_coroa){
				coroa_mcz.style.visibility ='hidden';
				coroa_nva.style.visibility ='visible';
				console.log(nva_coroa);

			}
			else{
				coroa_mcz.style.visibility ='visible';
				coroa_nva.style.visibility ='visible';
			}
			*/

			$scope.nva_concluido = nva_coroa;
			$scope.mcz_concluido = mcz_coroa;

			//console.log("nva_coroa: "+nva_coroa+" mcz_coroa: "+mcz_coroa);

		}

		mostrarContainer = function(){
			var supervisores = document.getElementById('container_super');
			var resultados = document.getElementById('container');

			console.log("mostrarContainer");

			if(supervisores.style.display == 'none')
			{
				supervisores.style.display = 'block';
				resultados.style.display = 'none';
			}
			else{
				supervisores.style.display = 'none';
				resultados.style.display = 'block';
			}
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
		temporiza();
		buscaResultado();
		mostrarContainer();

		setInterval(temporiza, 1000);
		//setInterval(buscaResultado,120 * 1000); //atualiza a cada 2 min
		setInterval(mostrarContainer,20 * 1000);
		
	});

(function(){
	// Opera 8.0+
	var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

	// Firefox 1.0+
	var isFirefox = typeof InstallTrigger !== 'undefined';

	// Safari 3.0+ "[object HTMLElementConstructor]" 
	var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

	// Internet Explorer 6-11
	var isIE = /*@cc_on!@*/false || !!document.documentMode;

	// Edge 20+
	var isEdge = !isIE && !!window.StyleMedia;

	// Chrome 1+
	var isChrome = !!window.chrome && !!window.chrome.webstore;

	// Blink engine detection
	var isBlink = (isChrome || isOpera) && !!window.CSS;


	if(isIE){
		alert("Voce esta usando um navegador incompativel.\nO navegador recomendado é o Google Chrome");
	}
	
})();