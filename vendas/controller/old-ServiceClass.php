 <?php
 require_once("supervisor.php");
 require_once("connect.php");

 class Service{
 	private $meta_nva = 147;
 	private $meta_mcz = 147;
 	private $venda = 0;
 	private $row = 0;
 	private $row2 = 0;
 	private $info_venda = array();
 	private $supervisor = array();
 	private $supervisor_final = array();
 	private $mcz = 0;
 	private $nva = 0;
 	private $coroa_nva = false;
 	private $coroa_mcz = false;

 	private $KELLY = 0;
 	private $TAMIRIS = 0;
 	private $KATILA = 0;
 	private $JANAINA = 0;
 	private $ALOISIO = 0;
 	private $OSMAR = 0;
 	private $ALEX = 0;
 	private $NATASHA = 0;

 	public function valida_site($sup){

 		switch ($sup) {
 			case 'KELLY':
 			$this->KELLY++;
 			$this->mcz++;
 			break;
 			case 'TAMIRIS':
 			$this->TAMIRIS++;    			
 			$this->mcz++;
 			break;
 			case 'KATILA':
 			$this->KATILA++;    			
 			$this->mcz++;
 			break;
 			case 'JANAINA':
 			$this->JANAINA++;    			
 			$this->mcz++;
 			break;
 			case 'ALOISIO':
 			$this->ALOISIO++;    			
 			$this->nva++;
 			break;
 			case 'OSMAR':
 			$this->OSMAR++;    			
 			$this->nva++;
 			break;
 			case 'ALEX':
 			$this->ALEX++;    			
 			$this->nva++;
 			break;
 			case 'NATASHA':
 			$this->NATASHA++;    			
 			$this->nva++;
 			break;
 			default:
 			die("SUPERVISOR NÃO ENCONTRADO.<br>Erro em: $sup<br>");
 			break;
 		}

 	}

 	public function atualizar_dados()
 	{
 		global $venda, $row, $row2, $nva, $mcz,$supervisor;

 		if (($handle = fopen("../dados.csv", "r")) !== FALSE) {
 			while(($data = fgetcsv($handle, 1500000, ",")) !== FALSE) {
 				
 				for ($c=0; $c < count($data); $c++) {
 					//$row++;	

 					if($data[$c] == 'VENDA')
 					{
 						$venda++;
 						$info_venda[$row2] = $data;
 						$row2++;
 					}

 				}
 			}
 			fclose($handle);


 			for ($i = 1; $i < count($info_venda); $i++){

	    	//extrair o primeiro NOME do supervisor
 				$temp_sup = explode(" ",substr($info_venda[$i][8],4));

 				$supervisor[$i] = $temp_sup[0];

 				$this->valida_site($supervisor[$i]);

 			}
	}//end if

}
public function atualiza_supervisor(){
	if (($handle = fopen("../supervisores.csv", "r")) !== FALSE) {
		while(($data = fgetcsv($handle, 1500000, ",")) !== FALSE) {

			for ($c=0; $c < count($data); $c++) {

				$nome_supervisor[$c] = $data[$c];
				//echo $data[$c].'<br>';
			}
		}
		fclose($handle);
	}

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
	global $mcz, $nva;

	date_default_timezone_set('America/Sao_Paulo');

	$objConexao = new Conecta();


	//recupera a ultima hora que foi atualizado
	$last = date("H:i:s",strtotime($objConexao->buscar_hora()));
	//recupera a hora atual
	$date = date('H:i:s');
	//armazena as horas em um array para conversão em segundos
	$list = array($last,$date);

	$i = 0;

	//recupera o dia da ultima atualização
	$data_last = (int) date("d",strtotime($objConexao->buscar_hora()));
	$data_hoje = (int) date('d');

	//força a atualização
	if(isset($_REQUEST['up']) && $_REQUEST['up'] == 't')
	{
			//guarda a hora de atualização
		$objConexao->atualizar_hora(date("Y-m-d H:i:s"));

			//echo date("Y-m-d H:i:s");
		$this->atualizar_dados();

		$supervisor = array($this->KELLY,$this->TAMIRIS,$this->KATILA,$this->JANAINA,$this->ALOISIO,$this->OSMAR,
			$this->ALEX,$this->NATASHA);

			//salva cache em db local
		$objConexao->atualizar_cache($this->nva,$this->mcz, $supervisor);

			//unset($_REQUEST['up']);
			//header('Location: /vendas/');    
	}
	else{
		//percorre o array de horas e converte as horas em segundos
		foreach ($list as $item) {
			list($hor, $min, $seg) = explode(":", $item);
			$hora[$i] = $hor * 3600 + $min * 60 + $seg;
			//echo"<pre>".$item." - $hora[$i]<pre>";
			$i++;
		}


		//verifica se a hora atual é maior do que a ultima atualização mais 5min
		if($hora[1] >= ($hora[0] + 121))
		{
			//guarda a hora de atualização
			$objConexao->atualizar_hora(date("Y-m-d H:i:s"));

			//echo date("Y-m-d H:i:s");
			$this->atualizar_dados();

			$supervisor = array($this->KELLY,$this->TAMIRIS,$this->KATILA,$this->JANAINA,$this->ALOISIO,$this->OSMAR,
				$this->ALEX,$this->NATASHA);

			//salva cache em db local

			$objConexao->atualizar_cache($this->nva,$this->mcz,$supervisor);

		}
		else{
			//recupera o cache em db local
			$cache = $objConexao->buscar_cache();

			$this->nva = $cache['NVA_VENDAS'];
			$this->mcz = $cache['MCZ_VENDAS'];
			
			$this->KELLY = $cache['KELLY'];
			$this->TAMIRIS = $cache['TAMIRIS'];
			$this->KATILA = $cache['KATILA'];
			$this->JANAINA = $cache['JANAINA'];
			$this->ALOISIO = $cache['ALOISIO'];
			$this->OSMAR = $cache['OSMAR'];
			$this->ALEX = $cache['ALEX'];
			$this->NATASHA = $cache['NATASHA'];
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


	$venda_supervisor = array($this->KELLY,$this->TAMIRIS,$this->KATILA,$this->JANAINA,$this->ALOISIO,$this->OSMAR,
		$this->ALEX,$this->NATASHA);

	$nome_supervisor = array('ANTONIA','TAMIRIS','KATILA','RAFAEL','ALOISIO','OSMAR','ALEX','NATASHA');


	$result = array(
		'atingido_nva'=>$this->nva,
		'meta_nva'=>$this->meta_nva,
		'atingido_mcz'=>$this->mcz,
		'meta_mcz'=>$this->meta_mcz,
		'coroa_nva'=>$this->coroa_nva,
		'coroa_mcz'=>$this->coroa_mcz
	);

	$valor = array();
	for($i= 0;$i < count($nome_supervisor);$i++)
	{ 
		$valor[$i] =  array('nome'=>$nome_supervisor[$i],'venda'=>$venda_supervisor[$i]);
	}

	$sort = $this->array_orderby($valor,'venda',SORT_DESC,$valor,'nome',SORT_DESC);


	echo json_encode(array("vendas"=>$result,"supervisor"=>$sort)); //,'aviso'=>$aviso));
}


}