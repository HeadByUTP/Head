<?php 

    class UniversidadesModel extends Mysql
    {
        public $intIdUni;
        public $strNomuni;
        public $intStatus;

        public function __construct()
        {
            parent::__construct();
        }

        public function selectUniversidades()
        {
            $sql = "SELECT idUniversidad, nombreUniversidad,status FROM universidad";
            $request = $this->select_all($sql);
            return $request; 
        }

        public function insertUniversidad(string $strNombreUni, int $strStatus){

            $this->strNomuni = $strNombreUni;
            $this->intStatus = $strStatus;
    
            $return = "";
            $sql = "SELECT * FROM universidad WHERE nombreUniversidad = '{$this->strNomuni}' ";
            $request = $this->select_all($sql);  
    
            if(empty($request))
            {
                $query_insert  = "INSERT INTO universidad(nombreUniversidad,status) 
                                  VALUES(?,?)"; 
                $arrData = array($this->strNomuni, $this->intStatus); 
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert; 
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectUniversidad(int $iduniversidad){
            $this->intIdUni = $iduniversidad;
            $sql = "SELECT idUniversidad, nombreUniversidad, status FROM universidad WHERE idUniversidad = $this->intIdUni;";
            $request = $this->select($sql);
            return $request; 
        }

        public function updateUniversidad($idUniversidad,$strNombreUni, $strStatus){

            $this->intIdUni = $idUniversidad;
            $this->strNomuni = $strNombreUni;
            $this->intStatus = $strStatus;

    
            $sql = "SELECT * FROM universidad WHERE nombreUniversidad = '$this->strNomuni'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE universidad SET nombreUniversidad = ?, status = ? WHERE idUniversidad = $this->intIdUni ";
				$arrData = array($this->strNomuni, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;	
        }

    }
?>