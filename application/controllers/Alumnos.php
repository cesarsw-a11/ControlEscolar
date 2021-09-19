<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {
	//Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->model("alumnos_m");
    }
	
	public function index()
	{
        #Solo los usuarios de tipo Admin podran acceder a esta vista.
        if($this->session->userdata("rol") == "1"){
            $this->load->view('administrador/crearAlumno');
        }else{
            echo "sin acceso a esta vista";
        }
	}

/**
 * Funcion para guardar un alumno
 *
 * @return Object
 */
	public function guardarAlumno(){
        $alumnoData = $this->input->post();

        $datosInsertar = array(
            "numcontrol" => $alumnoData['numcontrol'],
            "nombre" => $alumnoData['nombre'],
            "appaterno" => $alumnoData['appaterno'],
            "apmaterno" => $alumnoData['apmaterno'],
            "genero" => $alumnoData['genero'],
            "curp" => $alumnoData['curp'],
            "numcel" => $alumnoData['numcel'],
            "correo" => $alumnoData['correo'],
            "localidad" => $alumnoData['localidad'],
            "contraseña" => $alumnoData['contraseña'],
            "foto" => $alumnoData['foto'],
            "estado" => $alumnoData['estado'],
            "cursando" => $alumnoData['cursando']       );   
        
        $insert = $this->alumnos_m->guardarAlumno($datosInsertar);
        if($insert){
            echo json_encode(['insertado' => 1 , 'mensaje' => 'El alumno se a guardado exitosamente.']);
        }else{
            echo json_encode(['insertado' => 0 , 'mensaje' => 'El alumno no se ha guardado correctamente.']);
        }
       
	}
	public function acceder(){
		$msg = ["msg" => "todo bien"];
		echo json_encode($msg);
	}
}
