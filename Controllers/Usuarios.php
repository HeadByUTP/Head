<?php 

	class Usuarios extends Controllers
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
			getPermisos(2);
		}

		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios"; 
			$data['page_title'] = "USUARIOS <small>Sistema HAED</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){			
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{					
					$idUsuario = intval($_POST['idUsuario']); 
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$datos = json_decode($_POST["datos"]);
					$datosAcademicos = [];
					$arrData = [];
					$request_user = "";
					$option = 0;
					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);

						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertUsuario($strIdentificacion,
																				$strNombre, 
																				$strApellido, 
																				$intTelefono, 
																				$strEmail,
																				$strPassword, 
																				$intTipoId, 
																				$intStatus );
						}
					}else{
						$option = 2;

						$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateUsuario($idUsuario,
																		$strIdentificacion, 
																		$strNombre,
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$strPassword, 
																		$intTipoId, 
																		$intStatus);
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
			die();
		}

		public function getUsuarios()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectUsuarios();
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
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) ){
							$btnEdit = '<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['idpersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and
							($_SESSION['userData']['idpersona'] != $arrData[$i]['idpersona'] )
							 ){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
						}else{
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
 
		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);

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

		public function getPerfil(){

			$idusuario = intval($_SESSION['userData']['idpersona']);
			if($idusuario > 0)
			{
				$arrData = $this->model->selectUsuario($idusuario);
				
				if(array_key_exists('datosacademicos', $arrData)){
					$_SESSION['datosUni'] = true;
				}else{
					$_SESSION['datosUni'] = false;
				}

				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
 
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}
  
		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updatePerfil($idUsuario,
																$strIdentificacion, 
																$strNombre,
																$strApellido, 
																$intTelefono, 
																$strPassword);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
 ?>