<?php 

	class Haed extends Controllers{
		public function __construct()
		{
			parent::__construct();
		}

		public function Haed()
		{
			$data['page_tag'] = "HAED";
			$data['page_title'] = "Haed";
			$data['page_name'] = "HAED";
			$this->views->getView($this,"home",$data);
		}


		public function registro(){

		}


	}
 ?>