<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller {
	//Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->model("administrador_m");
    }
	
	public function index()
	{
        #Solo los usuarios de tipo Admin podran acceder a esta vista.
        if($this->session->userdata("rol") == "1"){
            $data['alumnos'] = $this->obtenerAlumnos();
            $this->load->view('administrador/crearAlumno',$data);
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
	}

}
