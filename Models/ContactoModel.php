<?php
class ContactoModel extends Mysql
{

	public function __construct()
	{
		parent::__construct();
	}

    public function setContacto(string $nombre, string $email, string $asunto, string $telefono,string $mensaje, string $ip, string $dispositivo, string $useragent){
		$nombre  	 = $nombre != "" ? $nombre : ""; 
		$email 		 = $email != "" ? $email : ""; 
        $asunto 		 = $asunto != "" ? $asunto : ""; 
        $telefono 		 = $telefono != "" ? $telefono : ""; 
		$mensaje	 = $mensaje != "" ? $mensaje : ""; 
		$ip 		 = $ip != "" ? $ip : ""; 
		$dispositivo = $dispositivo != "" ? $dispositivo : ""; 
		$useragent 	 = $useragent != "" ? $useragent : ""; 
		$query_insert  = "INSERT INTO contacto(nombre, asunto, telefono, email, mensaje, ip, dispositivo, useragent) 
						  VALUES(?,?,?,?,?,?,?,?)";
		$arrData = array($nombre,$email,$asunto,$telefono,$mensaje,$ip,$dispositivo,$useragent);
		$request_insert = $this->insert($query_insert,$arrData);
		return $request_insert; 
	}
}
 
?>