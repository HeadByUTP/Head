<?php 

    class VideosyModel extends Mysql
    {
        //Propiedades correspondientes a la entidad en la BD
		public $intIdVideo;
		public $strNom;
		public $strDesc;
        public $strAutor;
        public $strCat;
        public $strUrl;
		public $intStatus;
		public $strFecha;

        public function __construct()
        {
            parent::__construct();
        }

        public function selectVideosy()
        {
            $sql = "SELECT idVideo, nombreVideo, descVideo, autor, categoria,url,status,fecha FROM video";
            $request = $this->select_all($sql);
            return $request; 
        }

        		//Inserta un registro en la tabla
		public function insertVideo(string $strNombreVideo, string $strDescripcion, string $strAutor, 
        string $strCategoria, string $strUrlVideo, string $intStatusVideo, string $strFechaVideo)
		{
            $this->strNom = $strNombreVideo;
            $this->strDesc = $strDescripcion;
            $this->strAutor = $strAutor;
            $this->strCat = $strCategoria;
            $this->strUrl = $strUrlVideo;
            $this->intStatus = $intStatusVideo;
            $this->strFecha = $strFechaVideo;
			$return = "";
			$sql = "SELECT * FROM video WHERE nombreVideo = '$this->strNom' AND url = '$this->strUrl'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO `video` (`nombreVideo`, `descVideo`, `autor`, `categoria`, `url`, `status`, `fecha`) 
                VALUES (?,?,?,?,?,?,?)";
	        	$arrData = array($this->strNom, $this->strDesc, $this->strAutor, $this->strCat, $this->strUrl, $this->intStatus, $this->strFecha);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
		
		//Devuelve el registro del que coincida el id
		public function selectVideo(int $idVideo)
		{
			$this->intIdVideo = $idVideo;
			$sql = "SELECT * FROM video WHERE idVideo = $this->intIdVideo";
			$request = $this->select($sql);
			return $request;
		}

		//Actualiza el registro indicado con los nuevos valores enviados
		public function updateVideo($idVideo, $strNombreVideo, $strDescripcion, $strAutor, 
        $strCategoria, $strUrlVideo, $intStatusVideo, $strFechaVideo)
		{
			$this->intIdVideo = $idVideo;
            $this->strNom = $strNombreVideo;
            $this->strDesc = $strDescripcion;
            $this->strAutor = $strAutor;
            $this->strCat = $strCategoria;
            $this->strUrl = $strUrlVideo;
            $this->intStatus = $intStatusVideo;
            $this->strFecha = $strFechaVideo;
			$sql = "SELECT * FROM video WHERE nombreVideo = '$this->strNom' AND url = '$this->strUrl'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE video SET nombreVideo = ?, descVideo = ?, autor = ?, categoria = ?, 
                url = ?, status = ?, fecha = ? WHERE idVideo = $this->intIdVideo;";
				$arrData = array($this->strNom, $this->strDesc, $this->strAutor, $this->strCat, $this->strUrl, $this->intStatus, $this->strFecha);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
		
		//Elimina el registro del que coincida el id
		public function deleteVideo(int $idVideo)
		{
			$this->intIdVideo = $idVideo;
            $sql = "UPDATE video SET status = ? WHERE idVideo = $this->intIdVideo";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			if($request){
				$request = 'ok';
			}else{
				$request = 'error';
			}
			return $request;
		}

    }
?>