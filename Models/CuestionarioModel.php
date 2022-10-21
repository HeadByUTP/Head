<?php 

    class CuestionarioModel extends Mysql
    {
        public $intIdCuest;
        public $strNombreCuest;
        public $strDescCuest;

        public function __construct()
        {

            parent::__construct();
        }

        public function selectCuestionarios()
        {
            $sql = "SELECT idCuestionario, nombreCuestionario,descCuestionario FROM cuestionario";
            $request = $this->select_all($sql);
            return $request; 
        }

    public function insertCuestionario(string $NombreCuest, string $DescCuest){

		$this->strNombreCuest = $NombreCuest;
		$this->strDescCuest = $DescCuest;

		$return = 0;
		$sql = "SELECT * FROM Cuestionario WHERE 
				nombreCuestionario = '{$this->strNombreCuest}'";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO cuestionario(nombreCuestionario, descCuestionario) 
							  VALUES(?,?)";
        	$arrData = array($this->strNombreCuest,
    						$this->strDescCuest);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}

	public function selectCuestionario(int $idCuest){
		$this->intIdCuestionario = $idCuest;
		$sql = "SELECT idCuestionario,nombreCuestionario,descCuestionario 
				FROM Cuestionario
				WHERE idCuestionario = $this->intIdCuestionario";
		$request = $this->select($sql);
		return $request;
	}

	public function updateCuestionario(int $idCuestionario, string $NombreCuest, string $DescCuest){

		$this->intIdCuestionario = $idCuestionario;
		$this->strNombreCuest = $NombreCuest;
		$this->strDescCuest = $DescCuest;
		
		$sql = "SELECT * FROM cuestionario WHERE (idCuestionario = '{$this->intIdCuestionario}' AND nombreCuestionario != $this->strNombreCuest)
									  AND (DescCuestionario = '{$this->strDescCuest}'";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			
			$sql = "UPDATE Cuestionario SET nombreCuestionario=?, descCuestionario=?
					WHERE idCuestionario = $this->intIdCuestionario ";
			$arrData = array($this->strNombreCuest,
        					$this->strDescCuest);
			
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	}

	public function deleteCuestionario(int $idCuestionario)
	{
		$this->intIdCuestionario = $idCuestionario;
		$sql = "DELETE FROM Cuestionario WHERE idCuestionario = $this->intIdCuestionario ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
    }
    }
?>