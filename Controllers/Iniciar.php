<?php

class Iniciar extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if(!empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/home');
        }
    }

    public function iniciar()
    {
        $data['page_tag'] = "HAED - Iniciar sesión";
        $data['page_name'] = "Iniciar sesión";
        $data['page_title'] = "Iniciar sesión";
        $this->views->getView($this,"iniciar",$data);
    }

}

?>