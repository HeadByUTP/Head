<?php 
class PreguntasModel extends Mysql
{
	private $intIdPregunta;
	private $strPregunta;
	private $strDescMixto;
	private $intIdSeccion;
	private $intTipoPregunta;
	private $intIdCuestionario;
	private $intIdOpcion;
	private $strOpcion;
    private $intIdRetroalimentacion;
    private $strRetroalimentacion;
 
	public function __construct()
	{
		parent::__construct();
	}	

	public function selectOpciones()
	{
		$sql = "SELECT idOpcion, nombreOpcion FROM opcion;";
		$request = $this->select_all($sql); 
		return $request;
	}

	public function selectSecciones()
    {
        $sql = "SELECT idSeccion, nombreSeccion FROM seccion";
        $request = $this->select_all($sql);
        return $request; 
    }

	public function selectCuestionarios()
    {
        $sql = "SELECT idCuestionario, nombreCuestionario FROM cuestionario";
        $request = $this->select_all($sql);
        return $request; 
    }

	public function selectTipopreguntas()
    {
        $sql = "SELECT idTipopregunta, descTipopregunta FROM tipopregunta";
        $request = $this->select_all($sql);
        return $request; 
    }

	public function insertPregunta($pregunta, $textoMixto,$idSeccion, $idTipoPregunta, $idCuestionario){

		$this->strPregunta = $pregunta;
		$this->strDescMixto = $textoMixto;
		$this->intIdSeccion = $idSeccion;
		$this->intTipoPregunta = $idTipoPregunta;
		$this->intIdCuestionario = $idCuestionario;

		$sql = "SELECT * FROM pregunta WHERE pregunta = '{$this->strPregunta}';";
		$request = $this->select_all($sql);
		$return = "";

		if(empty($request))
		{
			$query_insert  = "INSERT INTO pregunta(pregunta,descripcionMixta,idSeccion,idTipopregunta,idCuestionario) 
                                  VALUES(?,?,?,?,?)"; 
                $arrData = array($this->strPregunta,
								$this->strDescMixto, 
								$this->intIdSeccion, 
								$this->intTipoPregunta, 
								$this->intIdCuestionario); 
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert; 
		}else{
			$return = "exist"; 
		}

		return $return;
	}

	public function insertRetroalimentacion($retroalimentacion, $idopcion, $idpregunta){

		$this->strRetroalimentacion = $retroalimentacion;
		$this->intIdOpcion = $idopcion;
		$this->intIdPregunta = $idpregunta;

		$query_insert  = "INSERT INTO retroalimentacion(descRetroalimentacion,idOpcion,idPregunta) 
                                  VALUES(?,?,?)"; 
		$arrData = array($this->strRetroalimentacion, $this->intIdOpcion, $this->intIdPregunta); 
		$request_insert = $this->insert($query_insert,$arrData);
		$return = $request_insert; 
	}

	public function insertOpcion($descOpcion){

		$this->strOpcion = $descOpcion;

		$sql = "SELECT idOpcion FROM opcion WHERE nombreOpcion = '{$this->strOpcion}';";
		$request = $this->select_all($sql);
		$return = 0;

		if(empty($request))
		{
			$query_insert  = "INSERT INTO opcion(nombreOpcion) 
                                  VALUES(?)"; 
                $arrData = array($this->strOpcion); 
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert; 
		}else{
			$return = $request[0]['idOpcion']; 
		}

		return $return;
	}
}

 ?>