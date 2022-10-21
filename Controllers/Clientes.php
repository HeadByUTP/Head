<?php 

class Clientes extends Controllers
{
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
		getPermisos(3);
	}

	public function Clientes()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Profesores";
		$data['page_title'] = "PROFESORES <small>Sistema HAED</small>";
		$data['page_name'] = "profesores";
		$data['page_functions_js'] = "functions_clientes.js";
		$this->views->getView($this,"clientes",$data);
	}

	public function setCliente(){
		error_reporting(0);
		if($_POST){
			if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$datos = json_decode($_POST["datos"]);
				$datosAcademicos = [];
				$arrData = [];
				$intTipoId = 2;
				$request_user = "";
				$option = 0;
				if($idUsuario == 0)
				{
					$option = 1;
					$strPassword =  empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];
					$strPasswordEncript = hash("SHA256",$strPassword);
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertCliente($strIdentificacion,
																			$strNombre, 
																			$strApellido, 
																			$intTelefono, 
																			$strEmail,
																			$strPasswordEncript,
																			$intTipoId);
					}
				}else{
					$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
					if($_SESSION['permisosMod']['u']){
						$request_user = $this->model->updateCliente($idUsuario,
																	$strIdentificacion, 
																	$strNombre,
																	$strApellido, 
																	$intTelefono, 
																	$strEmail,
																	$strPassword);
						$arrDelete = $this->model->delDatosAcademicos($idUsuario);
						for ($i=0; $i < count($datos); $i++) { 
							$datosAcademicos[$i] = [
								'idPersona' => $idUsuario,
								'idUniversidad' => $datos[$i][0]->idUni,
								'idCarrera' => $datos[$i][0]->idCarrera
								];
												
								$arrData[] = $this->model->setDatosAcademicos($datosAcademicos[$i]["idUniversidad"], $datosAcademicos[$i]["idCarrera"],$datosAcademicos[$i]["idPersona"]);
						}
					}
				}

				if(intval($request_user) > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido al Sistema HAED UTP');
						sendEmail($dataUsuario,'email_bienvenida'); 
					}elseif($option == 2 && count($datosAcademicos) == count($arrData)){
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}elseif($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function setDatosAcademicos(){
		if($_POST){
			if($_SESSION['permisosMod']['r']){
				$idUser = $_POST["user"];
				$datos = json_decode($_POST["datos"]);
				$datosAcademicos = [];
				$arrData = [];
				// dep($datos);
				// exit;
				$arrDelete = $this->model->delDatosAcademicos($idUser);

				for ($i=0; $i < count($datos); $i++) { 
					$datosAcademicos[$i] = [
						'idPersona' => $idUser,
						'idUniversidad' => $datos[$i][0]->idUni,
						'idCarrera' => $datos[$i][0]->idCarrera
					];

					$arrData[] = $this->model->setDatosAcademicos($datosAcademicos[$i]["idUniversidad"], $datosAcademicos[$i]["idCarrera"],$datosAcademicos[$i]["idPersona"]);
				}

				if(count($datosAcademicos) == count($arrData)){
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No fue posible almacenar los datos.');
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
		}
		die();
	}

	public function getClientes()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectClientes();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpersona'].')" title="Ver cliente"><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpersona'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpersona'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getCliente($idpersona){
		if($_SESSION['permisosMod']['r']){
			$idusuario = intval($idpersona);
			if($idusuario > 0)
			{
				$arrData = $this->model->selectCliente($idusuario);
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

	public function delCliente()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteCliente($intIdpersona);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al cliente.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

}

?>