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

    public function altaMateria(){
        if($this->session->userdata("rol") == "3"){
            $data['alumno'] = $this->obtenerAlumno();
            $this->load->view('alumnos/altaMateria',$data); 
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
    }
    public function obtenerMateriasAlumno($grado = ""){
        $query = "select * from materias where grado = ".$grado." and estado = 1 ";
        $alta = "select dadaDeAlta from capturaCalificaciones where idAlumno='".$this->session->userdata("id")."' and idMateria = '".$this->session->userdata("materia")."' ";
        $dadaDeAlta = 0;
        if($this->db->query($alta)->row()){
            $dadaDeAlta = $this->db->query($alta)->row();
            if($dadaDeAlta !== null){
            $dadaDeAlta = $dadaDeAlta->dadaDeAlta;
            }
        }
        $query = $this->db->query($query)->result_array();
        echo json_encode(["infoMateria"=>$query , "dadaAlta" => $dadaDeAlta]);
    }
    public function darAltaMateria(){
        $id_materia = $this->input->post("id_materia");
        $this->session->set_userdata("materia",$id_materia);
        $id_alumno = $this->session->userdata("id");
        $dadaDeAlta = 1;
        $datosInsertar = array(
            "idMateria" => $id_materia,
            "idAlumno" => $id_alumno,
            "dadaDeAlta" => $dadaDeAlta
        );
   
    $this->db->insert('capturaCalificaciones', $datosInsertar);
    if ($this->db->trans_status() === false) {
        $return = array(
            'error' => true,
            'mensaje' => 'No se pudo editar este registro',
            );
    } else {
        $return = array(
            'error' => false,
            'mensaje' => 'Registro editado correctamente',
            );
    }
    echo json_encode($return);
    }
}
