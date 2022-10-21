<?php 

	class Cuatrimestres extends Controllers
	{
		//Constructor que invoca al contructor de la clase padre
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(6);
		}

		//Manda a llamar a la vista
		public function Cuatrimestres()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Cuatrimestres"; 
			$data['page_title'] = "CUATRIMESTRES <small>Sistema HAED</small>";
			$data['page_name'] = "cuatrimestres";
			$data['page_functions_js'] = "functions_cuatrimestres.js";
			$this->views->getView($this,"cuatrimestres",$data);
		}

		//Muestra todos los registros de la entidad en DataTable
		public function getCuatrimestres()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectCuatrimestres();

				for ($i=0; $i < count($arrData); $i++)
				{
					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewCuatrimestre('.$arrData[$i]['idCuatrimestre'].')" title="Ver cuatrimestre"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditCuatrimestre(this,'.$arrData[$i]['idCuatrimestre'].')" title="Editar cuatrimestre"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelCuatrimestre('.$arrData[$i]['idCuatrimestre'].')" title="Eliminar cuatrimestre"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		//Muestra los datos del registro específicado
		public function getCuatrimestre($idCuatrimestre)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idcuatri = intval($idCuatrimestre);
				if($idcuatri > 0)
				{
					$arrData = $this->model->selectCuatrimestre($idcuatri);
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
		public function setCuatrimestre()
		{
			if($_POST){
				// dep($_POST);
				// exit;
				if(empty($_POST['txtNombrecuatri']) || empty($_POST['txtCicloescolar']) || empty($_POST['listStatus']) || empty($_POST['listCuestionario'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idCuatrimestre = intval($_POST['idCuatrimestre']);
					$strNombre = strClean($_POST['txtNombrecuatri']); 
					$strCicloEscolar = strClean($_POST['txtCicloescolar']);
					$intStatus = intval(strClean($_POST['listStatus']));
					$intCuestionario = intval(strClean($_POST['listCuestionario']));
					$request_cuatri = "";
					$option = 0;

					if($idCuatrimestre == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_cuatri = $this->model->insertCuatrimestre($strNombre, $strCicloEscolar, $intStatus, $intCuestionario);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_cuatri = $this->model->updateCuatrimestre($idCuatrimestre, $strNombre, $strCicloEscolar, $intStatus, $intCuestionario);
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
						$arrResponse = array('status' => false, 'msg' => 'El cuatrimestre ya existe, ingrese otro registro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		//Elimina el registro específicado
		public function delCuatrimestre()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdCuatrimestre = intval($_POST['idcuatri']);
					$requestDelete = $this->model->deleteCuatrimestre($intIdCuatrimestre);
					if($requestDelete){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cuatrimestre');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cuatrimestre.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
 ?>