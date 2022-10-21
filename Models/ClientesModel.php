<?php

	class ClientesModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
		private $intIdUniversidad;
		private $intIdCarrera;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid){

			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$return = 0;

			$sql = "SELECT * FROM persona WHERE 
					email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid) 
								VALUES(?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipoId);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function delDatosAcademicos($idUser){
			$this->intIdUsuario = $idUser;
			$sql = "DELETE FROM persona_unicarr WHERE idPersona = $this->intIdUsuario";
			$request = $this->delete($sql);
			return $request;
		}

		public function setDatosAcademicos($idUni, $idCarrera, $idPersona){
			$this->intIdUniversidad = $idUni;
			$this->intIdCarrera = $idCarrera;
			$this->intIdUsuario = $idPersona;

			$query_insert = "INSERT INTO persona_unicarr(idUniversidad, idCarrera, idPersona)
							VALUES (?,?,?)";
			$arrData = array($this->intIdUniversidad,
							$this->intIdCarrera,
							$this->intIdUsuario);
			$request_insert = $this->insert($query_insert,$arrData);
			$return = $request_insert;

			return $return;
		}

		public function selectClientes()
		{
			$sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status 
					FROM persona 
					WHERE rolid = 2 and status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCliente(int $idpersona)
		{
			$this->intIdUsuario = $idpersona;

			$sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status, DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM persona
					WHERE idpersona = $this->intIdUsuario and rolid = 2";
			$request = $this->select($sql);
			if(count($request) > 0){
				$sqlUni = "SELECT idUniversidad, nombreUniversidad FROM universidad";
				$resUni = $this->select_all($sqlUni);
				if(count($resUni) > 0){
					for ($u=0; $u < count($resUni); $u++) { 
						$intIdUni = $resUni[$u]['idUniversidad'];

						$sqlCarr = "SELECT idCarrera, nombreCarrera FROM carrera";
						$arrCarr = $this->select_all($sqlCarr);
						$resUni[$u]['carreras'] = $arrCarr;
					} 
				}

				$intIdUsuario = $request['idpersona'];
						$sqlUniCarr = "
						SELECT u.idUniversidad, u.nombreUniversidad, c.idCarrera, c.nombreCarrera FROM persona_unicarr AS puc 
						INNER JOIN universidad AS u ON puc.idUniversidad = u.idUniversidad
						INNER JOIN carrera AS c ON puc.idCarrera = c.idCarrera
						WHERE puc.idPersona = $intIdUsuario";
						$arrUC = $this->select_all($sqlUniCarr);
						if(count($arrUC) > 0){
							$request['datosacademicos'] = $arrUC;
							
						}
						$request['unicarreras'] = $resUni;
			}
			return $request;
		}

		public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password){

			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;

			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
										OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword  != "")
				{
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->strPassword);
				}else{
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteCliente(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}

?>