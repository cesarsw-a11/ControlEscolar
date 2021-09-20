<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	//Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function index()
	{
	 $rol = "select * from usuariosRoles";
	 if($this->db->query($rol)){
	  $data['roles'] = $this->db->query($rol)->result_array();
	 }
	  $this->load->view('login',$data);
	}

	public function acceder(){
		$response = ["respuesta" => "0"];
		$datos = $this->input->post();
		$nombre = $datos['nombre'];
		$pass = $datos['password'];
		$rol = $datos['rol'];

		if(!empty($nombre) && !empty($pass)){
			$contraseñaEncriptada = hash("sha256",$pass);
			switch($rol){
				case 1 : 
				 $tabla = "usuarios";
				 $tipoRol = "ADM";
				 $rol = 1;
			break;
				case 2 : 
				 $tabla = "docentes";
				 $tipoRol = "DOCENTE";
				 $rol = 2;
			break;
				case 3 : 
				 $tabla = "alumnos";
				 $tipoRol = "ALUMNO";
				 $rol = 3;
			break;
				die("Revise con su administrador para ver si tiene rol asignado");
			}
			$obtenerDatos = "select * from ".$tabla." where email = '".$nombre."' and password = '".$contraseñaEncriptada."' ";
			$obtenerDatos = $this->db->query($obtenerDatos)->row();
			if(isset($obtenerDatos)){

			if($obtenerDatos->password == $contraseñaEncriptada && $obtenerDatos->id_rol == $rol ){
				$datosSesion = ["rol" => $obtenerDatos->id_rol,
				"logged" => true ,"id" => (isset($obtenerDatos->idalumno) ? $obtenerDatos->idalumno : '' ) ];
				$this->session->set_userdata($datosSesion);

				switch($rol){
					case 1 : 
						$response['respuesta'] = "1";
				break;
					case 2 : 
						$response['respuesta'] = "2";
				break;
					case 3 : 
						$response['respuesta'] = "3";
				break;
					die("Revise con su administrador para ver si tiene rol asignado");
				}
				echo json_encode($response);
				return;
			}
		}
		}
		echo json_encode($response);
	}
	public function logout(){
		header("location:".base_url("/"));

		$this->session->unset_userdata("rol");
	}
}
