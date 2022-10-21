<?php
class CanalModel extends Mysql
{

	public function __construct()
	{
		parent::__construct();
	}

    public function selectVideos(){
        $sql = "SELECT categoria, nombreVideo, autor, fecha, descVideo, url FROM video LIMIT ".CONTVIDEOS;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectVideosPage($desde, $porpagina){
        $sql = "SELECT idVideo, categoria, nombreVideo, autor, fecha, descVideo, url, url_yt FROM video WHERE status = 1 ORDER BY idVideo DESC LIMIT $desde, $porpagina"; 
        $request = $this->select_all($sql);
        return $request;
    }

    public function cantVideos(){
        $sql = "SELECT COUNT(*) AS total_videos FROM video WHERE status = 1";
        $result_register = $this->select($sql);
        $total_registro = $result_register;
        return $total_registro;

    }

    public function cantVideosSearch($busqueda){

        $sql = "SELECT COUNT(*) AS total_videos FROM video WHERE nombreVideo LIKE '%$busqueda%' OR nombreVideo LIKE '%$busqueda%' AND status = 1";
        $result_register = $this->select($sql);
        $total_registro = $result_register;
        return $total_registro;
    }

    public function selectVideosSearch($busqueda,$desde, $porpagina){
        $sql = "SELECT idVideo, categoria, nombreVideo, autor, fecha, descVideo, url, url_yt FROM video WHERE status = 1 AND nombreVideo LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' ORDER BY idVideo DESC LIMIT $desde, $porpagina"; 
        $request = $this->select_all($sql);
        return $request;
    }
}
 
?>