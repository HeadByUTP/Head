<?php 

	class Cuestionario extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(5);
		}

		public function Cuestionario()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Cuestionarios";
			$data['page_name'] = "cuestionarios";
			$data['page_title'] = "CUESTIONARIOS <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_cuestionario.js";
			$this->views->getView($this,"cuestionario",$data);
		}

        public function getCuestionarios()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectCuestionarios();


				for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idCuestionario'].')" title="Ver cuestionario"><i class="far fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idCuestionario'].')" title="Editar cuestionario"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idCuestionario'].')" title="Eliminar cuestionario"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectCuestionarios()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectCuestionarios();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idCuestionario'].'">'.$arrData[$i]['nombreCuestionario'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function setCuestionario(){
			error_reporting(0);
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idCuest= intval($_POST['idCuest']);
                    $strNombreCuest = ucwords(strClean($_POST['txtNombre']));
                    $strDescCuest = ucwords(strClean($_POST['txtDescripcion']));

					if($idCuest == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertCuestionario($strNombreCuest,
																				$strDescCuest
																			);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateCuestionario($idCuest,
																				$strNombreCuest,
																				$strDescCuest);
						}
					}
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCuestionario($idCuestionario){
			if($_SESSION['permisosMod']['r']){
				$idCuest = intval($idCuestionario);
				if($idCuest > 0)
				{
					$arrData = $this->model->selectCuestionario($idCuest);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	
		public function delCuestionario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdCuestionario = intval($_POST['idCuestionario']);
					$requestDelete = $this->model->deleteCuestionario($intIdCuestionario);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Cuestionario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Cuestionario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>