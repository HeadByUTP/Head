<?php 

	class Dashboard extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(1);
		}

		public function dashboard()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url());
			}
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard - Sistema Haed";
			$data['page_title'] = "Dashboard - Sistema Haed";
			$data['page_name'] = "dashboard";
			$data['page_functions_js'] = "functions_dashboard.js";
			$this->views->getView($this,"dashboard",$data);
		}
 
		public function selectGraficas(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectGraficas();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = "<span class='badge badge-success'>Activo</span>";
					}else{
						$arrData[$i]['status'] = "<span class='badge badge-danger'>Concluido</span>";
					}

					$arrData[$i] = "
					<div class='col-md-6 col-lg-4'>
						<a href='".base_url()."/Graficas/getGraficas/{$arrData[$i]['idCuatrimestre']}' style='text-decoration: none;'>
						<div class='widget-small primary coloured-icon'><i class='icon fa fa-bar-chart fa-3x'></i>
						<div class='info'>
							<h5>{$arrData[$i]['nombre']}</h5>
							<h5>{$arrData[$i]['cicloEscolar']}</h5>
							<p><b>{$arrData[$i]['status']}</b></p>
						</div> 
						</div>
						</a>
					</div>
					";

				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
		    die();
		}

	}
 ?>