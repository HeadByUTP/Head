<?php 

    class TipopreguntasModel extends Mysql
    {
        public $intIdTipoPregunta;
        public $strDesctipopre;

        public function __construct()
        {
            parent::__construct();
        }
        
        public function insertTipopreguntas(string $strdescTipoPregunta)
        {
            $this->strDesctipopre = $strdescTipoPregunta;
            $return = "";
            $sql = "SELECT*FROM tipopregunta WHERE descTipopregunta= '{$this -> strDesctipopre}' ";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_insert = "INSERT INTO tipopregunta (descTipopregunta) VALUES(?)";
                $arrData = array ($this->strDesctipopre);
                $request_insert = $this->insert($query_insert,$arrData);
                $return=$request_insert;
            }
            else{
                $return = "exist";
            }

            return $return;
        }


        public function selectTipopreguntas()
        {
            $sql = "SELECT idTipopregunta, descTipopregunta FROM tipopregunta";
            $request = $this->select_all($sql);
            return $request; 
        }

        public function selectTipopregunta(int $idTipopregunta){
            $this->intIdpreg = $idTipopregunta;
            $sql = "SELECT idTipopregunta, descTipopregunta FROM tipopregunta WHERE idTipopregunta  = $this->intIdpreg";
            $request = $this->select($sql);
            return $request;
        }

        public function updateTipopregunta(int $idTipopregunta, string $strdescTipoPregunta)
        {
            $this->intIdTipoPregunta = $idTipopregunta;
            $this->strDesctipopre= $strdescTipoPregunta;
            $sql = "SELECT * FROM tipopregunta WHERE descTipopregunta = '$this->strDesctipopre'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE tipopregunta SET descTipopregunta=?
                        WHERE idTipopregunta = $this->intIdTipoPregunta";
                $arrData = array($this->strDesctipopre);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteTipopregunta(int $idtipo)
        {
            $this->intIdTipoPregunta = $idtipo;
            $sql1 = "SELECT * FROM pregunta WHERE idTipopregunta = $this->intIdTipoPregunta";
            $request1 = $this->select_all($sql1);
                   
            if(empty($request1))
			{
				$sql = "DELETE FROM tipopregunta WHERE idTipopregunta = $this->intIdTipoPregunta";
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