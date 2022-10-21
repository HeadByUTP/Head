<?php 

class Canal extends Controllers{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
    }

    public function canal()
    {
        $data['page_tag'] = "HAED - Canal Youtube";
        $data['page_title'] = "Canal de Youtube";
        $data['page_name'] = "HAED - Canal Youtube";
        $pagina = 1;
        $cantVideos = $this->model->cantVideos();
        $total_registro = $cantVideos['total_videos'];
        $desde = ($pagina - 1) * VIDPORPAGINA;
        $total_paginas = ceil($total_registro / VIDPORPAGINA);
        $data['videos'] = $this->model->selectVideosPage($desde, VIDPORPAGINA);
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $this->views->getView($this,"canal",$data);
    }

    public function page($pagina = null){

        $pagina = $pagina != null ? $pagina : 1;

        $data['page_tag'] = "HAED - Canal Youtube";
        $data['page_title'] = "Canal de Youtube";
        $data['page_name'] = "HAED - Canal Youtube";
        $cantVideos = $this->model->cantVideos();
        $total_registro = $cantVideos['total_videos'];
        $desde = ($pagina - 1) * VIDPORPAGINA;
        $total_paginas = ceil($total_registro / VIDPORPAGINA);
        $data['videos'] = $this->model->selectVideosPage($desde, VIDPORPAGINA);
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $this->views->getView($this,"canal",$data);
    }

    public function search(){
        if(empty($_REQUEST['s'])){
            header("Location: ".base_url());
        }else{
            $busqueda = strClean($_REQUEST['s']);
        }

        $pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
        $cantVideos = $this->model->cantVideosSearch($busqueda);

        $total_registro = $cantVideos['total_videos'];
        $desde = ($pagina - 1) * VIDBUSCAR;
        $total_paginas = ceil($total_registro / VIDBUSCAR);
        $data['videos'] = $this->model->selectVideosSearch($busqueda,$desde, VIDBUSCAR);
        $data['page_tag'] = "HAED - Canal Youtube";
        $data['page_title'] = "Resultado de: ".$busqueda; 
        $data['page_name'] = "HAED - Canal Youtube"; 
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $data['busqueda'] = $busqueda;
        $this->views->getView($this,"search",$data);

    }

}
?>