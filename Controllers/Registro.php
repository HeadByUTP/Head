<?php

class Registro extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if(!empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/home');
        }
    }

    public function registro()
    {
        $data['page_tag'] = "HAED - Crear Cuenta";
        $data['page_name'] = "Crear cuenta";
        $data['page_title'] = "Crear cuenta";
        $this->views->getView($this,"registro",$data);
    }

    public function setCliente(){
		error_reporting(0);
		if($_POST){
			if(empty($_POST['txtMatricula']) || empty($_POST['txtNombre']) || empty($_POST['txtApellidos']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) ||  empty($_POST['txtEdad']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$strIdentificacion = strClean($_POST['txtMatricula']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
                $strFechaN = strClean($_POST['txtEdad']);
				$intTipoId = 2;
				$request_user = "";

                $strPassword = passGenerator();
                $strPasswordEncript = hash("SHA256",$strPassword);
                $request_user = $this->model->insertCliente($strIdentificacion,
                                                            $strNombre, 
                                                            $strApellido, 
                                                            $intTelefono, 
                                                            $strEmail,
                                                            $strPasswordEncript,
                                                            $intTipoId,
                                                            $strFechaN);

				if(intval($request_user) > 0 )
				{
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente. Revise el correo enviado');
                    $nombreUsuario = $strNombre.' '.$strApellido;
                    $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                                            'email' => $strEmail,
                                            'password' => $strPassword,
                                            'asunto' => 'Bienvenido al Sistema HAED UTP');
                    sendEmail($dataUsuario,'email_bienvenida'); 	
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

}

?>