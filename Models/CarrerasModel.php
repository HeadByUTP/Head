<?php 

    class CarrerasModel extends Mysql
    {
        public $intIdCarr;
        public $strNomcarr;

        public function __construct()
        {
            parent::__construct();
        }

        public function selectCarreras()
        {
            $sql = "SELECT * FROM carrera";
            $request = $this->select_all($sql);
            return $request; 
        }

        public function insertCarrera(string $strNombreCarr)
        {
            $this->strNomcarr = $strNombreCarr;
            $return = "";
            $sql = "SELECT * FROM carrera WHERE nombreCarrera = '{$this->strNomcarr}' ";
            $request = $this->select_all($sql);  
    
            if(empty($request))
            {
                $query_insert  = "INSERT INTO carrera(nombreCarrera) VALUES (?)"; 
                $arrData = array($this->strNomcarr); 
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert; 
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectCarrera(int $idcarrera)
        {
            $this->intIdCarr = $idcarrera;
            $sql = "SELECT idCarrera, nombreCarrera FROM carrera WHERE idCarrera = $this->intIdCarr;";
            $request = $this->select($sql);
            return $request; 
        }

        public function updateCarrera($idCarrera,$strNombreCarr)
        {
            $this->intIdCarr = $idCarrera;
            $this->strNomcarr = $strNombreCarr;
            $sql1 = "SELECT * FROM carrera WHERE nombreCarrera = '$this->strNomcarr'";
			$request1 = $this->select_all($sql1);

			if(empty($request1))
			{
				$sql = "UPDATE carrera SET nombreCarrera = ? WHERE idCarrera = $this->intIdCarr";
				$arrData = array($this->strNomcarr);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;	
        }

        public function deleteCarrera($idcarrera)
        {
            $this->intIdCarr = $idcarrera;
            $sql1 = "SELECT * FROM persona_unicarr WHERE idCarrera = '$this->intIdCarr'";
			$request = $this->select_all($sql1);

			if(empty($request))
			{
				$sql = "DELETE FROM carrera WHERE idCarrera = $this->intIdCarr";
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