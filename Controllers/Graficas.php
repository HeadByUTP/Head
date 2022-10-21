<?php

class Graficas extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(15); 
	}

	public function getGraficas(string $params)
	{
		if($_SESSION['permisosMod']['r']){
			if($_SESSION['userData']['idrol'] == 1){

				if(empty($params)){
					header('Location: '.base_url().'/dashboard');
				}else{
					$idCuatrimestre = intval(strClean($params));
					if(is_int($idCuatrimestre)){
						$arrData = $this->model->selectIdCuatrimestre($idCuatrimestre);
					}else{
						header('Location: '.base_url().'/dashboard');
					}
					if($arrData == 'noexist'){
						header('Location: '.base_url().'/dashboard');
					}else{
						$data['page_tag'] = "Gráficas";
						$data['page_title'] = "GRÁFICAS <small>Sistema Haed</small>";
						$data['page_name'] = "gráficas";
						$data['page_functions_js'] = "functions_graficas.js";
						$data['cuatrimestre'] = $arrData['idCuatrimestre'];
						$this->views->getView($this,"graficas",$data);
					}
				}
			}elseif($_SESSION['userData']['idrol'] == 2){
				if(empty($params)){
					header('Location: '.base_url().'/dashboard');
				}else{
					$idCuatrimestre = intval(strClean($params));
					if(is_int($idCuatrimestre)){
						$arrData = $this->model->selectIdCuatrimestre($idCuatrimestre);
					}else{
						header('Location: '.base_url().'/dashboard');
					}
					if($arrData == 'noexist'){
						header('Location: '.base_url().'/dashboard');
					}else{
						$data['page_tag'] = "Mis Resultados";
						$data['page_title'] = "MIS RESULTADOS <small>Sistema Haed</small>";
						$data['page_name'] = "Mis Resultados";
						$data['page_functions_js'] = "functions_graficas.js";
						$data['cuatrimestre'] = $arrData['idCuatrimestre'];
						$this->views->getView($this,"graficas",$data);
					}
				}
			}
		}
		die();
	}

	public function getDatos(int $idCuatri){

		$idCuatrigrafic = intval(strClean($idCuatri));
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->getGraficas($idCuatrigrafic);

			// dep($arrData);
			// exit;
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}




}
?>