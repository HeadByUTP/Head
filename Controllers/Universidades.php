<?php 

	class Universidades extends Controllers{
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
 
		public function Universidades()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Universidades";
			$data['page_name'] = "universidades";
			$data['page_title'] = "Universidades <small> Sistema Haed</small>";
			$data['page_functions_js'] = "functions_universidades.js";
			$this->views->getView($this,"universidades",$data);
		}

        public function getUniversidades()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectUniversidades();

                // dep($arrData);
                // exit;

				for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewUni('.$arrData[$i]['idUniversidad'].')" title="Ver universidad"><i class="far fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditUni(this,'.$arrData[$i]['idUniversidad'].')" title="Editar universidad"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelUni('.$arrData[$i]['idUniversidad'].')" title="Eliminar universidad"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setUniversidad(){
            // error_reporting(0); 
            if($_POST){
                if(empty($_POST['txtNombreuni']) || empty($_POST['listStatus']) )
                {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                }else{ 
                    $idUniversidad = intval($_POST['idUniversidad']);
                    $strNombreUni = strClean($_POST['txtNombreuni']); 
                    $strStatus = intval(strClean($_POST['listStatus']));
                    $request_uni = "";
					$option = 0; 

                    if($idUniversidad == 0)
                    {
                        $option = 1; 
                        if($_SESSION['permisosMod']['w']){
                            $request_uni = $this->model->insertUniversidad($strNombreUni, $strStatus); 
                        }
                    } 
					else{
                        $option = 2;
                        if($_SESSION['permisosMod']['u']){
                            $request_uni = $this->model->updateUniversidad($idUniversidad,$strNombreUni, $strStatus);
                        }
                    }


                    if(intval($request_uni) > 0){
                        if($option == 1){
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.'); 
                        }
						elseif($option == 2){
                            $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                        }
                    } elseif($request_uni == "exist"){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! la universidad ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
					
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
 
		public function getUniversidad($iduniversidad){ 
			if($_SESSION['permisosMod']['r']){
				$iduni = intval($iduniversidad);
				if($iduni > 0)
				{ 
					$arrData = $this->model->selectUniversidad($iduni);

					if($arrData['status'] == 1)
					{
						$arrData['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

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

		
	}
 ?>