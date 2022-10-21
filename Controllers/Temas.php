<?php

	class Temas extends Controllers
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
			getPermisos(7);
		}

		public function Temas()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Temas";
			$data['page_name'] = "temas";
			$data['page_title'] = "TEMAS <small>Sistema HAED</small>";
			$data['page_functions_js'] = "functions_temas.js";
			$this->views->getView($this,"temas",$data);
		}

		public function setTemas()
		{
			if ($_POST){
				if(empty($_POST['txtNombretema']) || empty($_POST['txtDesctema'])){
					$arrResponse = array("status" => false, "msg"> 'Datos incorrectos.');
				}else{
					$idTema = intval($_POST['idTemas']);
					$strNombreTema= strClean($_POST['txtNombretema']);
					$strdesc = strClean($_POST['txtDesctema']);
					$request_tema = "";
					$option = 0;

					if($idTema == 0)
					{
						if($_SESSION['permisosMod']['w']){
							$option = 1;
							$request_tema = $this->model->insertTemas($strNombreTema, $strdesc);
						}
					}
					else {
						$option = 2;
						if($_SESSION['permisosMod']['u']){
						$request_tema = $this ->model->updateTema($idTema,$strNombreTema,$strdesc);
						}
					}

					if (intval($request_tema) > 0)
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}
						else{
							$arrResponse = array('status'=>true, 'msg'=>'Datos actualizados correctamente.');
						}
					}
					elseif($request_tema == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el Tema ya existe.');
					}
					else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			//dep($request_tema);
			//exit;
			die();
		}

		public function getTemas()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectTemas();
				
				//dep($arrData);
				//exit;

				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idTema'].')" title="Ver tema"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idTema'].')" title="Editar tema"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idTema'].')" title="Eliminar tema"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectTemas()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectTemas();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idTema'].'">'.$arrData[$i]['nombreTema'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getTema($idTema)
		{
			if($_SESSION['permisosMod']['r']){
				$idTem = intval($idTema);
				if($idTem > 0)
				{
					$arrData = $this->model->selectTema($idTem);
					//Valida que nos pase los datos correctos
					//dep($arrData);
					//exit();
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

		public function delTemas()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdTemas = intval($_POST['idTemas']);
					$requestDelete = $this->model->deleteTema($intIdTemas); 
					if($requestDelete)
					{
						$arrResponse = array('status'=>true, 'msg'=>'Se ha eliminado el tema');
					}else{
						$arrResponse = array('status' => false,'msg'=>'Error al eliminar el tema.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}

?>