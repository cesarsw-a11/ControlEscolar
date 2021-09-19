<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {
	//Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function index()
	{
        if($this->session->userdata("rol") == "1"){
            $this->load->view('administrador/crearAlumno');
        }else{
            echo "sin acceso a esta vista";
        }
	}

	public function guardarAlumno(){
        $alumnoData = $this->input->post();
        $datos = array(
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
        
        foreach($datos as $dato => $value){
            if(empty($value)){;
            echo json_encode(['insertado' => "No se agrego correctamente."]);
            }
        break;
        return false;
        }       
        
        //$registroAgregado = $this->db->insert_id();
        if($this->db->insert('alumno', $datos)){
            echo json_encode(['insertado' => "Registro agregado correctaemnte."]);
        }else{
            echo json_encode(['insertado' => "No se agrego correctamente."]);
        }
		/* $contraseñaEncriptada = hash('sha256',$alumno['nombre']);
		echo $contraseñaEncriptada; */
	}
	public function acceder(){
		$msg = ["msg" => "todo bien"];
		echo json_encode($msg);
	}
}
