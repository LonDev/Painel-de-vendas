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

  public function atualizar_cache($nva,$mcz,$sup)
  {
    global $pdo;
    $i = 0;

    $query = $pdo->prepare("update cache set NVA_VENDAS=?, MCZ_VENDAS=?, KELLY=?, TAMIRIS=?, KATILA=?, JANAINA=?,
    ALOISIO=?, OSMAR=?, ALEX=?, NATASHA=?  WHERE id=1");
    $query->bindparam(1,$nva);
    $query->bindparam(2,$mcz);

    while($i < count($sup))
    {
      $query->bindparam(($i +3),$sup[$i]);

      $i++;
    }
  
    if($query->execute())
      return true;

    return false;
  }

  public function buscar_cache()
  {
    global $pdo;

     $query = $pdo->prepare("select * from cache");
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


}
?>
