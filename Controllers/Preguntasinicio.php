<?php 

	class Preguntasinicio extends Controllers
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
            //modulo creado en la base de datos.
			getPermisos(14);
		}

		//Manda a llamar a la vista
        public function Preguntasinicio()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Preguntas Inicio";
			$data['page_name'] = "Preguntas Inicio";
			$data['page_title'] = "PREGUNTAS INICIO <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_preguntasinicio.js";
			$this->views->getView($this,"preguntasinicio",$data);
		}

		//Muestra todos los registros de la entidad en DataTable
		public function  getPreguntasinicio()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectPreguntasinicio();
                
                //dep($arrData);
                //exit;

                for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewPre('.$arrData[$i]['idPregunta'].')"
						 title="Ver Pregunta"><i class="far fa-eye"></i></button>';
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditPre(this,'.$arrData[$i]['idPregunta'].')" 
						title="Editar Pregunta"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelPre('.$arrData[$i]['idPregunta'].')" 
						title="Eliminar Pregunta"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getPregunta($idPregunta)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idpre = intval($idPregunta);
				if($idpre > 0)
				{
					$arrData = $this->model->selectPregunta($idpre);
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

		public function delPregunta()
		{
			if($_POST)
			{
				/* dep($_POST);
				exit; */
				
				if($_SESSION['permisosMod']['d'])
				{
					$intIdPre = intval($_POST['idpre']);
					$requestDelete = $this->model->deletePregunta($intIdPre);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la pregunta');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la pregunta.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function setPreguntasInicio()
		{
			if($_POST){
				// dep($_POST);
				// exit;
				if(empty($_POST['txtNombrePregunta']) || empty($_POST['txtDescripMixta']) || empty($_POST['listStatus'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idPregunta = intval($_POST['idPregunta']);
					$strNombre = strClean($_POST['txtNombreSeccion']); 
					$strDescripMixta = strClean($_POST['txtPregunta']);
					$intStatus = intval(strClean($_POST['listStatus']));
					
					$request_pregunta = "";
					$option = 0;

					if($idPregunta == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_pregunta = $this->model->insertCuatrimestre($strNombre, $strDescripMixta, $intStatus);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_pregunta = $this->model->updatePreguntasInicio($idPregunta, $strNombre, $strDescripMixta, $intStatus);
						}
					}

					if(intval($request_cuatri) > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
						}
					}else if($request_cuatri == "exist"){
						$arrResponse = array('status' => false, 'msg' => 'La pregunta ya existe, ingrese otro registro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		
	}
 ?>
 