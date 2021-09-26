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
        if($this->validarAcceso()){
            $data['redirect'] = "administrador";
            $this->load->view('administrador/menuPrincipal',$data);
        }
    }

    public function alumnos(){
        $tabla = "alumnos";
        if($this->validarAcceso()){
        $data['alumnos'] = $this->administrador_m->obtener($tabla);
        $this->load->view('administrador/registroAlumnos',$data);
        }
    }

    public function docentes(){
        $tabla = "docentes";
        if($this->validarAcceso()){
        $data['docentes'] = $this->administrador_m->obtener($tabla);
        $this->load->view('administrador/registroDocentes',$data);
        }
    }

    public function materias(){
        if($this->validarAcceso()){
        $this->load->view('administrador/registroMaterias');
        }
    }

    public function obtenerMaterias(){
        $tabla = "materias";
        $data = $this->administrador_m->obtener($tabla);
        echo json_encode($data);
    }
    public function obtenerMateriaPorId(){
        $id = $this->input->post("id");
        $query = "select * from materias where idmateria = ".$id." ";
        $query = $this->db->query($query)->row();
        echo json_encode(['datos' => $query]);

    }
    public function editarMateria(){
        $idmateria = $_POST['idmateria'];
        $clavemateria = $_POST['clave'];
        $nombremateria = $_POST['nombre'];
        $gradomateria = $_POST['grado'];
        $estadomateria = $_POST['estado'];

        $this->db->where('idmateria', $idmateria);
        $this->db->set('clave', $clavemateria);
        $this->db->set('nombre', $nombremateria);
        $this->db->set('grado', $gradomateria);
        $this->db->set('estado', $estadomateria);
        $this->db->update('materias');
        $this->db->trans_complete();
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
    public function validarAcceso(){
        if($this->session->userdata("rol") == "1"){
            return true;
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
        
    }

/**
 * Funcion para guardar un alumno
 *
 * @return Object
 */
	public function guardar(){
        $data = $this->input->post();

        switch($data['formulario']){
            case 'alumnos':
                $datosInsertar = array(
                    "numcontrol" => $data['numcontrol'],
                    "nombre" => $data['nombre'],
                    "appaterno" => $data['appaterno'],
                    "apmaterno" => $data['apmaterno'],
                    "genero" => $data['genero'],
                    "curp" => $data['curp'],
                    "numcel" => $data['numcel'],
                    "email" => $data['correo'],
                    "localidad" => $data['localidad'],
                    "password" => $data['contraseña'],
                    "foto" => "",
                    "estado" => $data['estado'],
                    "cursando" => $data['cursando']       );
            break;
            case 'docentes':
                $datosInsertar = array(
                    "nombre" => $data['nombre'],
                    "appaterno" => $data['appaterno'],
                    "apmaterno" => $data['apmaterno'],
                    "genero" => $data['genero'],
                    "email" => $data['email'],
                    "password" => $data['password'],
                    "foto" => "",
                    "estado" => $data['estado']       );
            break;
            case 'materias':
                $datosInsertar = array(
                    "clave" => $data['clave'],
                    "nombre" => $data['nombre'],
                    "grado" => $data['grado'],
                    "estado" => $data['estado']   );
            break;
            
        }
       
            
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
        
        $insert = $this->administrador_m->guardar($datosInsertar,$data['formulario']);
        switch($data['formulario']){
            case 'alumnos':
              $datosInsertar['idalumno'] = $insert;
            break;
            case 'docentes':
                $datosInsertar['iddocente'] = $insert;
            break;
            case 'materias':
                $datosInsertar['idmateria'] = $insert;
            break;
            
        }
        if($insert){
            echo json_encode(['insertado' => 1 , 'mensaje' => 'Insertado exitosamente.',"data" => $datosInsertar
            ,"tipoFormulario" => $data['formulario']]);
        }else{
            echo json_encode(['insertado' => 0 , 'mensaje' => 'El correo ingresado ya existe.']);
        }
       
    }

}