 <?php
 require_once("supervisor.php");
 require_once("Connect.php");
 
 $o = new Service;
 $o->main();

 class Service{
 	private $meta_nva = 147;
 	private $meta_mcz = 147;
 	private $tkm_nva = 0;
 	private $tkm_mcz = 0;
 	private $info_venda = array();
 	private $array_supervisor = array();
 	private $mcz = 0;
 	private $nva = 0;
 	private $error = 0;
 	private $coroa_nva = false;
 	private $coroa_mcz = false;


 	public function valida_site($sup){
 		//compara os nomes, caso seja os mesmos adiciona uma venda a cada iteração
 		foreach ($this->array_supervisor as $super) {
 			if($sup == $super->get('nome'))
 			{
 				$venda = $super->get('vendas');
 				$super->set('vendas',$venda +=1);

 				$site = $super->get('site');

 				if($site == 'MCZ'){
 					$this->mcz++;
 				}
 				elseif ($site == 'NVA') {
 					$this->nva++;
 				}
 				else
 				{
 					$this->error++;
 				}

 				//echo $super->get('nome').': '.$super->get('vendas').$super->get('site').'<br>';
 			}
 			
 		}
 		
 	}

 	public function insere_supervisor(){
 		$row = 0;
 		$row2 = 0;
 		$i = 0;
 		$objConexao = new Conecta();

 		if (($handle = fopen("supervisores.csv", "r")) !== FALSE) {
 			while(($data = fgetcsv($handle, 150000, ";")) !== FALSE) {

 				for ($c=0; $c < count($data); $c++) {
 					
 					$supervisor = new Supervisor;

 					//se encontrar o nome do site adiciona ao array sites e pula para proxima iteração
 					if($data[$c] == 'MCZ' || $data[$c] == 'NVA')
 					{
 						$sites[$row2] = $data[$c]; 
 						$row2++;
 						continue;
 					}
 					$supervisor->set('nome',$data[$c]);

 					$array_supervisor[$row] = $supervisor;

 					$row++;
 				}
 			}
 			fclose($handle);

 			foreach ($array_supervisor as $value) {
 				$value->set('site',$sites[$i]);
 				$i++;
 			}
 		}

 		if($objConexao->insereSuper($array_supervisor))
 			return true;

 		return false;

 	}
 	public function atualizar_dados()
 	{
 		$objConexao = new Conecta();
 		$row = 0;
 		if (($handle = fopen("../dados.csv", "r")) !== FALSE) {
 			while(($data = fgetcsv($handle, 1500000, ",")) !== FALSE) {
 				
 				for ($c=0; $c < count($data); $c++) {
 					
 					if($data[$c] == 'VENDA')
 					{
 						$info_venda[$row] = $data;
 						$row++;
 					}

 				}
 			}
 			fclose($handle);
 			//busca os nomes dos supervisores
 			$this->array_supervisor = $objConexao->buscar_supervisor();

 			for ($i = 0; $i < count($info_venda); $i++){

	    	//extrair o primeiro nome do supervisor
 				$temp_sup = explode(" ",substr($info_venda[$i][8],4));

 				$supervisor[$i] = $temp_sup[0];

 				$this->valida_site($supervisor[$i]);

 			}
	}//end if


}

public function array_orderby()
{
	$args = func_get_args();
	$data = array_shift($args);
	foreach ($args as $n => $field) {
		if (is_string($field)) {
			$tmp = array();
			foreach ($data as $key => $row)
				$tmp[$key] = $row[$field];
			$args[$n] = $tmp;
		}
	}
	$args[] = &$data;
	call_user_func_array('array_multisort', $args);
	return array_pop($args);
}

public function main() {
	
	date_default_timezone_set('America/Sao_Paulo');

	$objConexao = new Conecta();

	//recupera a ultima hora que foi atualizado
	$last = date("H:i:s",strtotime($objConexao->buscar_hora()));
	//recupera a hora atual
	$date = date('H:i:s');
	//armazena as horas em um array para conversão em segundos
	$list = array($last,$date);

	$itera_list = 0;

	//força a atualização
	if(isset($_REQUEST['up']) && $_REQUEST['up'] == 't')
	{
		//guarda a hora de atualização
		$objConexao->atualizar_hora(date("Y-m-d H:i:s"));

		$this->atualizar_dados();

		//salva cache em db local
		$objConexao->atualizar_cache($this->nva,$this->mcz, $this->array_supervisor);

	}
	else{
		//percorre o array de horas e converte as horas em segundos
		foreach ($list as $item) {
			list($hor, $min, $seg) = explode(":", $item);
			$hora[$itera_list] = $hor * 3600 + $min * 60 + $seg;
			$itera_list++;
		}

		//verifica se a hora atual é maior do que a ultima atualização mais 5min
		if($hora[1] >= ($hora[0] + 121))
		{
			//guarda a hora de atualização
			$objConexao->atualizar_hora(date("Y-m-d H:i:s"));
			$this->atualizar_dados();

			//salva cache em db local
			$objConexao->atualizar_cache($this->nva,$this->mcz,$this->array_supervisor);

		}
		else{
			//recupera o cache em db local
			$cache = $objConexao->buscar_cache();
			$itera_super = 0;

			foreach ($cache as $value) {
				$supervisor = new Supervisor();
				$supervisor->set('nome',$value['nome']);
				$supervisor->set('vendas',$value['vendas']);

				$this->array_supervisor[$itera_super] = $supervisor;


				$this->nva = $value['NVA_VENDAS'];
				$this->mcz = $value['MCZ_VENDAS'];

				$itera_super++;
			}
			
		}
	}

	if($this->nva > $this->mcz){
		$this->coroa_nva = true;
		$this->coroa_mcz = false;
	}
	elseif ($this->nva == $this->mcz) {
		$this->coroa_nva = true;
		$this->coroa_mcz = true;
	}
	else{
		$this->coroa_nva = false;
		$this->coroa_mcz = true;
	}


	//$dados_aviso = $objConexao->buscar_aviso();

	//$aviso = array('titulo'=>0,'mensagem'=>0);


	$result = array(
		'atingido_nva'=>$this->nva,
		'meta_nva'=>$this->meta_nva,
		'atingido_mcz'=>$this->mcz,
		'meta_mcz'=>$this->meta_mcz,
		'coroa_nva'=>$this->coroa_nva,
		'coroa_mcz'=>$this->coroa_mcz,
		'error'=>$this->error
	);

	$i = 0;
	foreach ($this->array_supervisor as $value) {
		$valor[$i] = array('nome'=>$value->get('nome'),'venda'=>$value->get('vendas')); 
		$i++;
	}

	$sort = $this->array_orderby($valor,'venda',SORT_DESC,$valor,'nome',SORT_DESC);
	
	/*
	foreach ($this->array_supervisor as $value) {
		echo $value->get('nome').': '.$value->get('vendas').' '.$value->get('site').'<br>';
	}
	*/
		//echo json_encode(array("vendas"=>$result,"supervisor"=>$sort)); //,'aviso'=>$aviso));

		var_dump($valor);
	}

}