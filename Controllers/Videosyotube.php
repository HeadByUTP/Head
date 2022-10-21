<?php 

	class Videosyotube extends Controllers{
		//Constructor que invoca al constructor de la clase padre 
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(12);
		}
  
		//Manda a llamar a la vista
		public function Videosyotube()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Videos"; 
			$data['page_title'] = "VIDEOS <small>Sistema HAED</small>";
			$data['page_name'] = "videos";
			$data['page_functions_js'] = "functions_videos.js";
			$this->views->getView($this,"videosyotube",$data);
		}
 
		//Muestra todos los registros de la entidad en DataTable
		public function getVideos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectVideos();
				dep($arrData);
				exit;
				for ($i=0; $i < count($arrData); $i++)
				{
					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewVideo('.$arrData[$i]['idVideo'].')" title="Ver vídeo"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditVideo(this,'.$arrData[$i]['idVideo'].')" title="Editar vídeo"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelVideo('.$arrData[$i]['idVideo'].')" title="Eliminar vídeo"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		//Muestra los datos del registro específicado
		public function getVideo($idVideo)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idvideo = intval($idVideo);
				if($idvideo > 0)
				{
					$arrData = $this->model->selectVideo($idvideo);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		//Inserta o actualiza datos de un registro, según sea el caso
		public function setVideo()
		{
			if($_POST){

				if(empty($_POST['txtNombrevideo']) || empty($_POST['txtDesc']) || empty($_POST['txtAutor']) || empty($_POST['txtCat']) || 
                empty($_POST['txtUrl']) || empty($_POST['listStatus']) || empty($_POST['txtFecha'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
                    $idVideo = intval($_POST['idVideo']);
                    $strNom = strClean($_POST['txtNombrevideo']); 
                    $strDesc = strClean($_POST['txtDesc']); 
                    $strAutor = strClean($_POST['txtAutor']); 
                    $strCat = strClean($_POST['txtCat']); 
                    $strUrl = strClean($_POST['txtUrl']); 
                    $intStatus = intval(strClean($_POST['listStatus']));
                    $strFecha = strClean($_POST['txtFecha']); 
					$request_vid = "";
					$option = 0;

					if($idVideo == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_vid = $this->model->insertVideo($strNom, $strDesc, $strAutor, $strCat, $strUrl, $intStatus, $strFecha);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_vid = $this->model->updateVideo($idVideo, $strNom, $strDesc, $strAutor, $strCat, $strUrl, $intStatus, $strFecha);
						}
					}

					if(intval($request_vid) > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
						}
					}else if($request_vid == "exist"){
						$arrResponse = array('status' => false, 'msg' => 'El vídeo ya existe, ingrese otro registro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		//Elimina el registro específicado
		public function delVideo()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdCuatrimestre = intval($_POST['idVideo']);
					$requestDelete = $this->model->deleteVideo($intIdVideo);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el vídeo');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el vídeo.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
 ?>