<?php 

	class Carreras extends Controllers
    {
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(4);
		}
 
		public function Carreras()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Carreras";
			$data['page_name'] = "carreras";
			$data['page_title'] = "CARRERAS <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_carreras.js";
			$this->views->getView($this,"carreras",$data);
		}

        public function getCarreras()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectCarreras();

				for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewCarr('.$arrData[$i]['idCarrera'].')" title="Ver carrera"><i class="far fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditCarr(this,'.$arrData[$i]['idCarrera'].')" title="Editar carrera"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelCarr('.$arrData[$i]['idCarrera'].')" title="Eliminar carrera"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setCarrera()
        {
            if($_POST){
                if(empty($_POST['txtNombrecarr']))
                {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                }else{ 
                    $idCarrera = intval($_POST['idCarrera']);
                    $strNombreCarr = strClean($_POST['txtNombrecarr']);
                    $request_carr = "";
					$option = 0; 

                    if($idCarrera == 0)
                    {
                        $option = 1; 
                        if($_SESSION['permisosMod']['w']){
                            $request_carr = $this->model->insertCarrera($strNombreCarr); 
                        }
                    } 
					else{
                        $option = 2;
                        if($_SESSION['permisosMod']['u']){
                            $request_carr = $this->model->updateCarrera($idCarrera,$strNombreCarr);
                        }
                    }

                    if(intval($request_carr) > 0)
					{
                        if($option == 1){
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.'); 
                        }
						elseif($option == 2){
                            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        }
                    } elseif($request_carr == "exist"){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe una carrera con ese nombre, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
					
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
 
		public function getCarrera($idcarrera)
        { 
			if($_SESSION['permisosMod']['r']){
				$idcarr = intval($idcarrera);
				if($idcarr > 0)
				{ 
					$arrData = $this->model->selectCarrera($idcarr);

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

		public function delCarrera()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdCarrera = intval($_POST['idcarr']);
					$requestDelete = $this->model->deleteCarrera($intIdCarrera);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la carrera.');
					}elseif($requestDelete == 'dependence'){
						$arrResponse = array('status' => false, 'msg' => 'No se puede eliminar una carrera relacionada con información académica de usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la carrera.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
?>