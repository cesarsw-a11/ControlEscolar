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

			$obtenerDatos = "select * from usuarios where email = '".$nombre."' ";
			$obtenerDatos = $this->db->query($obtenerDatos)->row();
			if(isset($obtenerDatos)){
				
			if($obtenerDatos->password == $pass && $obtenerDatos->id_rol == $rol ){
				$datosSesion = ["rol" => $obtenerDatos->id_rol];
				$this->session->set_userdata($datosSesion);
				$response['respuesta'] = "1";
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
