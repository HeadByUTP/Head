<?php 

	class Descubre extends Controllers{
		public function __construct()
		{
			parent::__construct();
		}
 
		public function descubre()
		{
			$data['page_tag'] = "HAED - Descubre"; 
			$data['page_title'] = "Herramienta de Autoevaluación Docente (HAED)";
			$data['page_name'] = "HAED - Descubre";
			$this->views->getView($this,"descubre",$data);
		}

	}
 ?>