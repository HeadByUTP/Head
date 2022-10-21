<?php 
class ContactosModel extends Mysql{

	public function selectContactos()
	{
		$sql = "SELECT idContacto, nombre, email, DATE_FORMAT(datecreated, '%d/%m/%Y') as fecha
				FROM contacto ORDER BY idContacto DESC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectMensaje(int $idmensaje){
		$sql = "SELECT idContacto, nombre, email, DATE_FORMAT(datecreated, '%d/%m/%Y') as fecha, mensaje
				FROM contacto WHERE idContacto = {$idmensaje}";
		$request = $this->select($sql);
		return $request;
	}

}
 ?>