 <?php
class DashboardModel extends Mysql
{
	private $intIdCuatrimestre;
    private $strNombreCuatrimestre;
    private $dateCicloEscolar;
    private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

    public function selectGraficas(){
        $sql = "SELECT idCuatrimestre, nombre, cicloEscolar, status FROM cuatrimestre";
        $request = $this->select_all($sql);
        return $request;
    }
}
 
?>