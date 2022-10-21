<?php 

class Preguntas extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(10); 
	}

	public function Preguntas()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Preguntas";
		$data['page_title'] = "PREGUNTAS <small>Sistema HAED</small>";
		$data['page_name'] = "preguntas";
		$data['page_functions_js'] = "functions_preguntas.js";
		$this->views->getView($this,"preguntas",$data);
	}
 
	public function getOpciones()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectOpciones();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectSecciones()
	{
		$result = [];
		$htmlOptions = ""; 
		$arrDatas = $this->model->selectSecciones();
		$arrDatac = $this->model->selectCuestionarios();
		$arrDatatp = $this->model->selectTipopreguntas();
		if(count($arrDatas) > 0 && count($arrDatac) > 0 && count($arrDatatp) > 0){
			$result = [
				"cuestionario" => $arrDatac,
				"secciones" => $arrDatas,
				"tiposp" => $arrDatatp
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}	
		die();		
	} 

	public function setPregunta()
	{
		if($_POST){
			if($_POST['cuestionario'] == "" || $_POST['seccion'] == "" || $_POST['tipopregunta'] == "" || $_POST['pregunta'] == ""){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{
				$idpregunta = intval($_POST['idpregunta']);
				$idCuestionario = intval($_POST['cuestionario']);
				$idSeccion = intval($_POST['seccion']);
				$idTipoPregunta = intval($_POST['tipopregunta']);
				$pregunta = strClean($_POST['pregunta']);
				$textoMixto = empty($_POST['textoMixto']) ? '' : strClean($_POST['textoMixto']); 

				$opcionesexisten = empty($_POST['opcionesexisten']) ? '' : $_POST['opcionesexisten'];
				$opcionesnuevas = empty($_POST['opcionesnuevas']) ? '' : $_POST['opcionesnuevas'];

				$request_pregunta = "";
				$request_opexiste = [];
				$request_opnueva = []; 
				$request_optnuevaretro = [];



				if($idpregunta == 0){ 
					$option = 1; 
                    if($_SESSION['permisosMod']['w']){
                        $request_pregunta = $this->model->insertPregunta($pregunta, $textoMixto, $idSeccion, $idTipoPregunta, $idCuestionario); 
						
						if($request_pregunta == "exist"){
							$arrResponse = array("status" => false, "msg" => 'Pregunta existente.');
						}else{
							if($idTipoPregunta != 3){
								if($opcionesexisten != ''){
									for ($i=0; $i < count($opcionesexisten); $i++) { 
										$request_opexiste[] = $this->model->insertRetroalimentacion(strClean($opcionesexisten[$i][0]['retroalimentacionOE']), intval($opcionesexisten[$i][0]['idopcion']), $request_pregunta);
									} 
								}
		
								if($opcionesnuevas != ''){
									for ($n=0; $n < count($opcionesnuevas); $n++) { 
										$request_opnueva[] = $this->model->insertOpcion(strClean($opcionesnuevas[$n][0]['opcionnueva']));
									}
		
									if(count($opcionesnuevas) == count($request_opnueva)){
										for($r=0; $r < count($opcionesnuevas); $r++){ 
											$request_optnuevaretro[] = $this->model->insertRetroalimentacion(strClean($opcionesnuevas[$r][0]['retroalimentacionueva']), intval($request_opnueva[$r]), $request_pregunta);
										}
									}
								}
							}
						}
					}
				} 

				if(intval($request_pregunta) > 0){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.'); 
					
				} elseif($request_pregunta == "exist"){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! la pregunta ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
	}
}

?>