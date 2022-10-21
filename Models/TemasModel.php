<?php 

    class TemasModel extends Mysql
    {
        public $intIdTem;
        public $strNomtem;
        public $strDescTem;

        public function __construct()
        {
            parent::__construct();
        }

        public function insertTemas(string $strNombretema, string $strdesc)
        {
            $this->strNomtem = $strNombretema;
            $this->strDescTem = $strdesc;
            $return = "";
            $sql = "SELECT * FROM tema WHERE nombreTema = '{$this -> strNomtem}' ";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_insert = "INSERT INTO tema (nombreTema, descTema,status) VALUES(?,?,?)";
                $arrData = array ($this->strNomtem, $this->strDescTem,1);
                $request_insert = $this->insert($query_insert,$arrData);
                $return=$request_insert;
            }
            else{
                $return = "exist";
            }

            return $return;
        }

        public function selectTemas()
        {
            $sql = "SELECT idTema, nombreTema, descTema FROM tema WHERE status != 0";
            $request = $this->select_all($sql);
            return $request; 
        }

        public function selectTema(int $idTema)
        {
            $this->intIdTemas = $idTema;
            $sql = "SELECT idTema, nombreTema, descTema FROM tema WHERE idTema = $this->intIdTemas AND status != 0";
            $request = $this->select($sql);
            return $request;
        }

        public function updateTema(int $idTema,string $strNombretema, string $strdesc)
        {
            $this->intIdTem = $idTema;
            $this->strNomtem= $strNombretema;
            $this->strDescTem= $strdesc;
            $sql = "SELECT * FROM tema WHERE nombreTema = '$this->strNomtem' AND descTema = '$this->strDescTem'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE tema SET nombreTema=?, descTema=?
                        WHERE idTema = $this->intIdTem";
                $arrData = array($this->strNomtem,
                                $this->strDescTem);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteTema(int $intIdTemas)
        {
            $this->intIdTem = $intIdTemas;
            $sql = "UPDATE tema SET status = ? WHERE idTema = $this->intIdTem ";
            $arrData = array(0); 
            $request_del = $this->update($sql,$arrData); 
            return $request_del; 
        }

    }
?>