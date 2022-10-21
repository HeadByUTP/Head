<?php 

	class Home extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
		}

		public function home()
		{
			$data['page_tag'] = "HAED - Inicio";
			$data['page_title'] = "HAED: Herramienta de Autoevaluación Docente";
			$data['page_name'] = "HAED - Inicio";
			$this->views->getView($this,"home",$data);
		}

	}
 ?>