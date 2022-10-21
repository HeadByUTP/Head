<?php 

	class Secciones extends Controllers
	{
		//Constructor
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(8);
		}

		//Manda a llamar a la vista
        public function Secciones()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Secciones";
			$data['page_name'] = "secciones";
			$data['page_title'] = "SECCIONES <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_secciones.js";
			$this->views->getView($this,"secciones",$data);
		}

		//Muestra todos los registros de la entidad en DataTable
		public function getSecciones()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectSecciones();
                
                //dep($arrData);
                //exit;

                for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewSec('.$arrData[$i]['idSeccion'].')"
						 title="Ver sección"><i class="far fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditSec(this,'.$arrData[$i]['idSeccion'].')" 
						title="Editar sección"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelSec('.$arrData[$i]['idSeccion'].')" 
						title="Eliminar sección"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectSecciones()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectSecciones();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idSeccion'].'">'.$arrData[$i]['nombreSeccion'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}

		//Muestra los datos del registro específicado
		public function getSeccion($idSeccion)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idsec = intval($idSeccion);
				if($idsec > 0)
				{
					$arrData = $this->model->selectSeccion($idsec);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		
		//Inserta o actualiza datos de un registro, según sea el caso
		public function setSeccion()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombreseccion']) || empty($_POST['listTema'])){
					$arrResponse = array("status" => false, "msg"> 'Datos incorrectos.');
				}else{
					$idSeccion = intval($_POST['idSeccion']);
					$strNombreSec= strClean($_POST['txtNombreseccion']);
					$strTema = intval(strClean($_POST['listTema']));
					$request_sec = "";
					$option = 0;

	
					if($idSeccion == 0)
					{	
						$option = 1;			
						if($_SESSION['permisosMod']['w']){							
							$request_sec = $this->model->insertSeccion($strNombreSec, $strTema);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_sec = $this->model->updateSeccion($idSeccion, $strNombreSec, $strTema);
						}
					}
					
					if(intval($request_sec) > 0)
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}
						elseif($option == 2){
							$arrResponse = array('status' => true, 'msg'=>'Datos actualizados correctamente.');
						}
					}
					elseif($request_sec == 'exist'){					
						$arrResponse = array('status' => false, 'msg' => 'La sección ya existe, ingrese otro registro.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		//Elimina el registro específicado
		public function delSeccion()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdSec = intval($_POST['idsec']);
					$requestDelete = $this->model->deleteSeccion($intIdSec);
					if($requestDelete == "ok"){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la sección.');
					}elseif($requestDelete == "dependence"){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una sección asociada a preguntas.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la sección.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
 ?>
 