<?php 

require 'Libraries/html2pdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

class Respuestas extends Controllers{ 

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
		getPermisos(11);
	}

	public function Respuestas()
	{
        // dep($_SESSION);
        // exit;
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Respuestas";
		$data['page_title'] = "RESPUESTAS <small>Sistema HAED</small>";
		$data['page_name'] = "respuestas";
		$data['page_functions_js'] = "functions_respuestas.js";
		$this->views->getView($this,"respuestas",$data); 
	}

    public function getRespuestas(){
        if($_SESSION['permisosMod']['r']){

            $idUsuario = $_SESSION['userData']['idpersona'];

            if($_SESSION['userData']['idrol'] == 1){
                $arrData = $this->model->selectRespuestas();
            }
            if($_SESSION['userData']['idrol'] == 2){
                $arrData = $this->model->selectRespuestasProfesor($idUsuario);
            }

            for ($i=0; $i < count($arrData) ; $i++) { 
                $btnView = '';
                if($_SESSION['permisosMod']['r']){
                    $btnView = '<a title="Generar PDF" href="'.base_url().'/respuestas/getRespuesta/'.$arrData[$i]['idRespuesta'].'" target="_blanck" class="btn btn-danger btn-sm"> <i class="fas fa-file-pdf"></i> </a> ';
                    // $btnView = '<button class="btn btn-info btn-sm" onClick="fntGeneraPdf('.$arrData[$i]['idRespuesta'].')" title="Generar PDF"><i class="fas fa-file-pdf"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getRespuesta($idRespuesta){
        if($_SESSION['permisosMod']['r']){
            $idRespuesta = intval($idRespuesta);
            if($idRespuesta > 0){
                $arrData = $this->model->selectRespuesta($idRespuesta);
                if(empty($arrData)){
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{

                    // dep($arrData);
                    // exit;
                    $idRespuesta = $arrData['usuario']['idRespuesta'];
                    ob_end_clean();  
                    $html = getFile("Template/Modals/comprobantePDF",$arrData);
                    $html2pdf = new Html2Pdf('p','letter','es','true','UTF-8',array(10, 10, 10, 10)); 
                    $html2pdf->writeHTML($html); 
                    $html2pdf->output('resultadosHaed-'.$idRespuesta.'.pdf');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
            }
        }
        die();
    }


}
?>