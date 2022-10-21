<?php 

    class SeccionesModel extends Mysql
    {
        //Propiedades correspondientes a la entidad en la BD
        public $intIdSec;
        public $strNomSec;
        public $intIdTem;

        //Constructor que invoca al constructor de la clase padre para conectar a la BD
        public function __construct()
        {
            parent::__construct();
        }

        //Devuelve todos los registros de la tabla
        public function selectSecciones()
        {
            $sql = "SELECT s.idSeccion, s.nombreSeccion, t.nombreTema 
            FROM seccion AS s 
            LEFT JOIN tema AS t 
            ON s.idTema=t.idTema;";
            $request = $this->select_all($sql);
            return $request; 
        }

        //Inserta un registro en la tabla
        public function insertSeccion(string $strNombreSec, int $intTema)
        {
            $this->strNomSec = $strNombreSec; 
            $this->intIdTem = $intTema;
            $return = "";
            $sql = "SELECT * FROM seccion WHERE nombreSeccion = '$this->strNomSec' AND idTema = '$this->intIdTem'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $query_insert = "INSERT INTO seccion (nombreSeccion, idTema) VALUES (?,?)";
                $arrData = array($this->strNomSec, $this->intIdTem);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        //Devuelve el registro del que coincida el id
        public function selectSeccion(int $idSeccion)
        {
            $this->intIdSec = $idSeccion;
            $sql = "SELECT s.idSeccion, s.nombreSeccion, t.idTema, t.nombreTema 
            FROM seccion AS s 
            LEFT JOIN tema AS t 
            ON s.idTema=t.idTema 
            WHERE idSeccion = $this->intIdSec";
            $request = $this->select($sql);
            return $request;
        }

        //Actualiza el registro indicado con los nuevos valores enviados
        public function updateSeccion($idSeccion, $strNombreSec, $intTema)
        {
            $this->intIdSec = $idSeccion;
            $this->strNomSec = $strNombreSec;
            $this->intIdTem = $intTema;           
            $sql = "SELECT * FROM seccion WHERE nombreSeccion = '$this->strNomSec' AND idTema = '$this->intIdTem'";
            $request = $this->select_all($sql);
        
            if(empty($request))
            {               
                $sql = "UPDATE seccion SET nombreSeccion = ?, idTema = ? WHERE idSeccion = $this->intIdSec;";
                $arrData = array($this->strNomSec, $this->intIdTem);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        //Elimina el registro del que coincida el id
        public function deleteSeccion(int $idseccion)
        {
            $this->intIdSec = $idseccion;
            $sql1 = "SELECT * FROM pregunta WHERE idSeccion = $this->intIdSec";
            $request1 = $this->select_all($sql1);
            
            if(empty($request1))
			{
				$sql = "DELETE FROM seccion WHERE idSeccion = $this->intIdSec";
				$request_del = $this->delete($sql);
				if($request_del)
				{
					$response = 'ok';	
				}else{
					$response = 'error';
				}
			}else{
				$response = 'dependence';
			}
			return $response;
        }
    }
?>