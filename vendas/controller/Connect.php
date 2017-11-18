<?php
/**
* 
*/
class Conecta
{
 private $pdo;

 function __construct()
 {
  global $pdo;

  try {
    $hostname = "localhost";
    $dbname = "dados";
    $username = "root";
    $pw = "";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Erro de Conexão " . $e->getMessage() . "\n";
    exit;
  }
}

public function buscar_hora()
{
  global $pdo;

  $query = $pdo->prepare("select LAST_HOUR FROM hora");
  $query->execute();
  
  
  if($query->rowcount() > 0)
  {
    $row = $query->fetch();
    return $row['LAST_HOUR'];
  }
  else{
    return 0;
  }

}

public function atualizar_hora($hora)
{
  global $pdo;

  $query = $pdo->prepare("update hora set LAST_HOUR=? WHERE id=1");
  $query->bindparam(1,$hora);

  if($query->execute())
    return true;

  return false;
}

public function atualizar_cache($nva,$mcz,$fat_nva,$fat_mcz,$supervisor)
{
  global $pdo;
  $i = 0;

  $query = $pdo->prepare("update cache set NVA_VENDAS=?, MCZ_VENDAS=?, NVA_FAT=?, MCZ_FAT=?  WHERE id=1");
  $query->bindparam(1,$nva);
  $query->bindparam(2,$mcz);
  $query->bindparam(3,$fat_nva);
  $query->bindparam(4,$fat_mcz);

  if($query->execute())
  {
    foreach ($supervisor as $sup) {
     $vendas = $sup->get('vendas');
     $nome = $sup->get('nome');
     
     $query_super = $pdo->prepare("update supervisores set vendas=? WHERE nome=?");

     $query_super->bindparam(1,$vendas);
     $query_super->bindparam(2,$nome);

     if(!$query_super->execute())
      return false;

  }
  return true;
}

}


public function buscar_cache()
{
  global $pdo;

  $query = $pdo->prepare("select nome, vendas, NVA_VENDAS, MCZ_VENDAS, NVA_FAT, MCZ_FAT from supervisores, cache");
  $query->execute();
  
  if($query->rowcount() > 0)
  {
    $row = $query->fetchAll();
    return $row;
  }
  else{
    return 0;
  }

}
public function buscar_supervisor()
{
  require_once('supervisor.php');  
  global $pdo;
  $array_supervisor = array();
  $itera = 0;

  $query = $pdo->prepare("select * from supervisores");
  $query->execute();
  
  if($query->rowcount() > 0)
  {
    $row = $query->fetchAll();
    foreach ($row as $value) {
      $supervisor = new Supervisor();
      $supervisor->set('nome',$value['nome']);
      //$supervisor->set('vendas',$value['vendas']);
      $supervisor->set('site',$value['site']);

      $array_supervisor[$itera] = $supervisor;
      $itera++;
    }

    return $array_supervisor;
  }
  else{
    return 0;
  }

}

public function buscar_aviso()
{
  global $pdo;

  $query = $pdo->prepare("select * from avisos");
  $query->execute();
  
  if($query->rowcount() > 0)
  {
    $row = $query->fetch();
    return $row;
  }
  else{
    return 0;
  }

}

public function atualizar_aviso($titulo,$mensagem)
{
  global $pdo;
  $i = 0;

  $query = $pdo->prepare("update avisos set titulo=?, mensagem=?  WHERE id=1");
  $query->bindparam(1,$titulo);
  $query->bindparam(2,$mensagem);

  if($query->execute())
    return true;

  return false;
}

public function insereSuper($supervisor)
{
  global $pdo;

  $busca = $pdo->prepare("select id from supervisores");
  $busca->execute();
  
  if($busca->rowcount() > 0)
  { 
    $deleta = $pdo->prepare("truncate supervisores");
    $deleta->execute();
  }

  foreach ($supervisor as $sup) {
   $nome = $sup->get('nome');
   $vendas = $sup->get('vendas');
   $site = $sup->get('site');
   
   $query_super = $pdo->prepare("insert  into supervisores (nome,vendas,site) VALUES (?,?,?)");

   $query_super->bindparam(1,$nome);
   $query_super->bindparam(2,$vendas);
   $query_super->bindparam(3,$site);

   if(!$query_super->execute())
     return false;
 }
 return true;

}

public function insereIp($ip)
{
  date_default_timezone_set('America/Sao_Paulo');
  global $pdo;
  $date = date("Y-m-d H:i:s");

  $busca = $pdo->prepare("select id from logs where ip=?");
  $busca->bindparam(1,$ip);
  $busca->execute();

  if($busca->rowcount() > 0)
  {
    $atualiza = $pdo->prepare("update logs set hora=? where ip=?");
    $atualiza->bindparam(1,$date);
    $atualiza->bindparam(2,$ip);

    if($atualiza->execute())
      return true;
  }
  else{
    $insere = $pdo->prepare("insert into logs (ip,hora) value (?,?)");
    $insere->bindparam(1,$ip);
    $insere->bindparam(2,$date);

    if($insere->execute())
      return true; 
  }

  return false;
}



}
?>
