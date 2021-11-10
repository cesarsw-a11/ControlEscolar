<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumno extends CI_Controller {
	//Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->model("administrador_m");
    }
	
	public function index()
	{
        #Solo los usuarios de tipo Admin podran acceder a esta vista.
        if($this->session->userdata("rol") == "3"){
            $data['alumno'] = $this->obtenerAlumno();
            $this->load->view('alumnos/menu_alumno',$data);
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
    }
    
    public function obtenerAlumno(){
        $query = "select * from alumnos where idalumno = '".$this->session->userdata('id')."' ";
        $query = $this->db->query($query)->row();
        return $query;

    }

    public function organigrama(){
        if($this->session->userdata("rol") == "3"){
            echo "Organigrama";
           /*  $data['alumno'] = $this->obtenerAlumno();
            $this->load->view('menu_alumno',$data); */
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
    }

    public function kardex(){
        if($this->session->userdata("rol") == "3"){
            $data['alumno'] = $this->obtenerAlumno();
            $this->load->view('alumnos/kardex',$data); 
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
    }
}
