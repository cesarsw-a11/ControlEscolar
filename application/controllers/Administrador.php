<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {
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
            "email" => $alumnoData['correo'],
            "localidad" => $alumnoData['localidad'],
            "password" => $alumnoData['contraseña'],
            "foto" => "",
            "estado" => $alumnoData['estado'],
            "cursando" => $alumnoData['cursando']       );
            
            if(isset($_FILES['file']['name'])){

                /* Obtenemos el nombre del archivo, en este caso una imagen */
                $filename = $_FILES['file']['name'];
             
                /* Ruta */
                $ruta = "imagenes/".$filename;
                $datosInsertar['foto'] = $ruta;
                $imageFileType = pathinfo($ruta,PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
             
                /* Valid extensions */
                $valid_extensions = array("jpg","jpeg","png");
             
                $response = 0;
                /* Check file extension */
                if(in_array(strtolower($imageFileType), $valid_extensions)) {
                   /* Upload file */
                   if(move_uploaded_file($_FILES['file']['tmp_name'],$ruta)){
                      $response = $ruta;
                   }
                }
             }
        
        $insert = $this->administrador_m->guardarAlumno($datosInsertar);
        if($insert){
            echo json_encode(['insertado' => 1 , 'mensaje' => 'El alumno se a guardado exitosamente.',"alumno" => $datosInsertar]);
        }else{
            echo json_encode(['insertado' => 0 , 'mensaje' => 'El correo ingresado ya existe.']);
        }
       
    }
    
    public function obtenerAlumnos(){
        $query = "select * from alumnos";
        $query = $this->db->query($query)->result_array();
        return $query;
    }
	public function acceder(){
		$msg = ["msg" => "todo bien"];
		echo json_encode($msg);
    }
}
