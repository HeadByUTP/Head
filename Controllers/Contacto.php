<?php 

class Contacto extends Controllers{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
    }

    public function contacto()
    {
        $data['page_tag'] = "HAED - Contacto";
        $data['page_title'] = "Contáctanos";
        $data['page_name'] = "HAED - Contacto";
        $this->views->getView($this,"contacto",$data);
    }

    public function envio(){
        if($_POST){
            $nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
            $email  = strtolower(strClean($_POST['emailContacto']));
            $asunto = strClean($_POST['asuntoContacto']);
            $telefono = strClean($_POST['telefonoContacto']);
            $mensaje  = strClean($_POST['mensajeContacto']);

            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $ip        = $_SERVER['REMOTE_ADDR'];
            $dispositivo= "PC";

            if(preg_match("/mobile/i",$useragent)){
                $dispositivo = "Movil";
            }else if(preg_match("/tablet/i",$useragent)){
                $dispositivo = "Tablet";
            }else if(preg_match("/iPhone/i",$useragent)){
                $dispositivo = "iPhone";
            }else if(preg_match("/iPad/i",$useragent)){
                $dispositivo = "iPad";
            }

            $userContact = $this->model->setContacto($nombre,$email,$asunto,$telefono,$mensaje,$ip,$dispositivo,$useragent);
            if($userContact > 0){
                $arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente.");
                //Enviar correo
                $dataUsuario = array('asunto' => "Nuevo Usuario en contacto",
                                    'email' => EMAIL_CONTACTO,
                                    'nombreContacto' => $nombre,
                                    'emailContacto' => $email,
                                    'mensaje' => $mensaje );
                sendEmail($dataUsuario,"email_contacto"); 
            }else{
                $arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

        }
        die();
    }

}
?>