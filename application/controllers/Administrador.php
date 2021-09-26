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

/**
 * Funciones para mostrar las vistas principales para el administrador:
 * Alumnos
 * Docentes
 * Materias
 */
    public function alumnos(){
        if($this->validarAcceso()){
        $this->load->view('administrador/registroAlumnos');
        }
    }

    public function docentes(){
        if($this->validarAcceso()){
        $this->load->view('administrador/registroDocentes');
        }
    }

    public function materias(){
        if($this->validarAcceso()){
        $this->load->view('administrador/registroMaterias');
        }
    }

/**
 * Funciones para listar todos los registros de las tablas solicitadas
 */
    public function obtenerMaterias(){
        $tabla = "materias";
        $data = $this->administrador_m->obtener($tabla);
        echo json_encode($data);
    }
    
    public function obtenerAlumnos(){
        $tabla = "alumnos";
        $data = $this->administrador_m->obtener($tabla);
        echo json_encode($data);
    }

    public function obtenerDocentes(){
        $tabla = "docentes";
        $data = $this->administrador_m->obtener($tabla);
        echo json_encode($data);
    }

/**Funciones para obtener registros por id 
 * 
*/
    public function obtenerMateriaPorId(){
        $id = $this->input->post("id");
        $query = "select * from materias where idmateria = ".$id." ";
        $query = $this->db->query($query)->row();
        echo json_encode(['datos' => $query]);

    }
    public function obtenerAlumnoPorId(){
        $id = $this->input->post("id");
        $query = "select * from alumnos where idalumno = ".$id." ";
        $query = $this->db->query($query)->row();
        echo json_encode(['datos' => $query]);

    }
    public function obtenerDocentePorId(){
        $id = $this->input->post("id");
        $query = "select * from docentes where iddocente = ".$id." ";
        $query = $this->db->query($query)->row();
        echo json_encode(['datos' => $query]);

    }

/**
 * Funciones para editar un registro por id
 *
 */
    public function editarMateria(){
        $idmateria = $_POST['idmateria'];
        $datos = $this->input->post();
       
        $this->db->where('idmateria', $idmateria);
        $this->db->set($datos);
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

    public function editarAlumno(){
        $idalumno = $_POST['idalumno'];
        $datos = $this->input->post();

        $this->db->where('idalumno', $idalumno);
        $this->db->set($datos);
        $this->db->update('alumnos');
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
    public function editarDocente(){
        $iddocente = $_POST['iddocente'];
        $datos = $this->input->post();

        $this->db->where('iddocente', $iddocente);
        $this->db->set($datos);
        $this->db->update('docentes');
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

/**
 * Funcioes para eliminar un registro de la base de datos
 *
 */
    public function eliminarMateria(){
        $idmateria = $_POST['idmateria'];
        $this->db->where('idmateria', $idmateria);
        $this->db->delete('materias');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
                );
        } else {
            $return = array(
                'error' => false,
                'mensaje' => 'Registro eliminado correctamente',
                );
        }
        echo json_encode($return);

    }
    public function eliminarAlumno(){
        $idalumno = $_POST['idalumno'];
        $this->db->where('idalumno', $idalumno);
        $this->db->delete('alumnos');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
                );
        } else {
            $return = array(
                'error' => false,
                'mensaje' => 'Registro eliminado correctamente',
                );
        }
        echo json_encode($return);

    }
    public function eliminarDocente(){
        $iddocente = $_POST['iddocente'];
        $this->db->where('iddocente', $iddocente);
        $this->db->delete('docentes');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
                );
        } else {
            $return = array(
                'error' => false,
                'mensaje' => 'Registro eliminado correctamente',
                );
        }
        echo json_encode($return);

    }

/**
 * Funcion de guardado general
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

    /**
     * Función para validar el acceso a los modulos del administrador
     */
    public function validarAcceso(){
        if($this->session->userdata("rol") == "1"){
            return true;
        }else{
            echo "<h2>sin acceso a esta vista</h2><a href=".base_url("/").">Volver a la pagina principal</a>";
        }
        
    }

}