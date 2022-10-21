<?php 
	class Tipopreguntas extends Controllers
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
			getPermisos(9);
		}

		public function Tipopreguntas()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Tipos Preguntas";
			$data['page_name'] = "tipos preguntas";
			$data['page_title'] = "TIPOS DE PREGUNTA <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_tipopreguntas.js";
			$this->views->getView($this,"tipopreguntas",$data);
		}

		public function setTipopreguntas()
		{
			if($_POST)
			{
				if(empty($_POST['txtDesctipopreg'])){
					$arrResponse = array("status" => false, "msg"> 'Datos incorrectos.');
				}else{
					$idTipopregunta = intval($_POST['idPreguntas']);
					$strdescTipoPregunta = strClean($_POST['txtDesctipopreg']);
					$request_pregunta = "";
					$option = 0;	

					if($idTipopregunta == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_pregunta = $this->model->insertTipopreguntas($strdescTipoPregunta);
						}
					}
					else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_pregunta = $this ->model->updateTipoPregunta($idTipopregunta, $strdescTipoPregunta);
						}
					}

					if (intval($request_pregunta) > 0)
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}
						else{
							$arrResponse = array('status'=>true, 'msg'=>'Datos actualizados correctamente.');
						}
					}
					elseif($request_pregunta == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el tipo de pregunta ya existe.');
					}
					else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}		 
		
		public function getTipopreguntas()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectTipopreguntas();
				//dep($arrData);
				//exit;

				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idTipopregunta'].')" title="Ver tipo pregunta"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idTipopregunta'].')" title="Editar tipo pregunta"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idTipopregunta'].')" title="Eliminar tipo pregunta"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectTipopreguntas()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectTipopreguntas();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idTipopregunta'].'">'.$arrData[$i]['descTipopregunta'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getTipopregunta($idTipopregunta)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$Idpreg = intval($idTipopregunta);
				if ($Idpreg > 0)
				{
					$arrData = $this->model->selectTipopregunta($Idpreg);
					if(empty ($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();	
		}

		public function delTipopreguntas()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpreg = intval($_POST['idPreguntas']);
					$requestDelete = $this->model->deleteTipopregunta($intIdpreg);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el tipo de pregunta.');
					}elseif($requestDelete == 'dependence'){
						$arrResponse = array('status' => false, 'msg' => 'No se puede eliminar un tipo de pregunta asociado a preguntas.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el tipo de pregunta.');
					}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>