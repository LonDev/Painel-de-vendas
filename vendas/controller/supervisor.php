<?php
	
	/**
	* 
	*/
	class Supervisor
	{
		private $nome;
		private $vendas;

		public function set($prop, $value)
		{
			if(property_exists($this, $prop))
				$this->$prop = $value;
		}
		
		public function get($prop)
		{
			if(property_exists($this, $prop))
				return $this->$prop;
		}
	}
























  ?>