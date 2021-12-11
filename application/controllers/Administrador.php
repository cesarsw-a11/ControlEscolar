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
    public function asignarMaterias(){
        if($this->validarAcceso()){
            $docentes = "select * from docentes where estado = 1";
            $docentes = $this->db->query($docentes)->result_array();
            $materias = "select * from materias where estado = 1";
            $materias = $this->db->query($materias)->result_array();
            $data['docentes'] = $docentes;
            $data['materias'] = $materias;
            $this->load->view('administrador/asignarMaterias',$data);
        }
    }

    public function tomarInasistencias(){
        if($this->validarAcceso()){
           $alumnos = "select * from alumnos";
           $data['alumnos'] = $this->db->query($alumnos)->result_array(); 
           $this->load->view("administrador/tomarInasistencias",$data);
        }
    }
    public function obtenerDataInasistencias(){
        $alumnos = "select * from alumnos";
         $alumnos = $this->db->query($alumnos)->result_array();

         echo json_encode($alumnos);

    }

    public function actualizarInasistencias(){
        $inasistencia = $this->input->post("inasistencia");
        $idalumno = $this->input->post("idalumno");
       
        $this->db->where('idalumno', $idalumno);
        $this->db->set(["inasistencias" => $inasistencia]);
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

    function obtenerRelacionMateriasDocentes(){
        $query = "select *,materias.nombre as nombreMateria,docentes.nombre as nombreDocente from materiasDocentes
        left join materias on materiasDocentes.id_materia = materias.idmateria
        left join docentes on materiasDocentes.id_docente = docentes.iddocente";
        $query = $this->db->query($query)->result_array();
        echo json_encode($query);
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
        $query = "select *,materias.nombre as nombreMateria,docentes.nombre as nombreDocente from materiasDocentes
        left join materias on materiasDocentes.id_materia = materias.idmateria
        left join docentes on materiasDocentes.id_docente = docentes.iddocente";
        $query = $this->db->query($query)->row();
        echo json_encode(['datos' => $query]);

    }

    public function obtenerMateriaDocentePorId(){
        $id = $this->input->post("id");
        $query = "select * from materiasDocentes where id = ".$id." ";
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
        unset($datos['formulario']);
       
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

    public function editarMateriaDocente(){
        $idmateria = $_POST['id'];
        $datos = $this->input->post();
        $datosActualizar = array(
            'id_docente' => $datos['docente'],
            'id_materia' => $datos['materia']
        );
        unset($datos['formulario']);
       
        $this->db->where('id', $idmateria);
        $this->db->set($datosActualizar);
        $this->db->update('materiasDocentes');
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
        $contraseñaEncriptada = hash('sha256',$datos['contraseña']);
        $datosActualizar = array(
            "numcontrol" => $datos['numcontrol'],
            "nombre" => $datos['nombre'],
            "appaterno" => $datos['appaterno'],
            "apmaterno" => $datos['apmaterno'],
            "genero" => $datos['genero'],
            "curp" => $datos['curp'],
            "numcel" => $datos['numcel'],
            "email" => $datos['correo'],
            "localidad" => $datos['localidad'],
            "cursando" => $datos['cursando'],
            "estado" => $datos['estado'],
            "password" => $contraseñaEncriptada
        );

        if(!empty($_FILES['file']['name'])){

                /* Obtenemos el nombre del archivo, en este caso una imagen */
                $filename = $_FILES['file']['name'];
             
                /* Ruta */
                $ruta = "imagenes/".$filename;
                $datosActualizar['foto'] = $ruta;
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
        $this->db->db_debug = false;
        $this->db->where('idalumno', $idalumno);
        $this->db->set($datosActualizar);
        if(!$this->db->update('alumnos')){
            
            $error = $this->db->error();
            var_dump($error);
            die;
            if($error['code'] == 1062){
                $return = array(
                    'error' => true,
                    'mensaje' => 'Numero de control o email duplicado',
                    );
                $this->db->db_debug = true;
            }elseif(isset($error)){
                $return = array(
                    'error' => true,
                    'mensaje' => 'No se pudo editar este registro',
                    );
            }
        }else{
            $return = array(
                'error' => false,
                'mensaje' => 'Registro editado correctamente',
                );
        }
        
        /* $this->db->trans_complete();
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
        } */
        echo json_encode($return);
    }

    public function eliminarimagen(){
        $ruta = "imagenes/dd.png";
        unlink($ruta);
    }

    public function editarDocente(){
        $iddocente = $_POST['iddocente'];
        $datos = $this->input->post();
        $contraseñaEncriptada = hash('sha256',$datos['password']);
        $datosActualizar = array(
            "nombre" => $datos['nombre'],
            "appaterno" => $datos['appaterno'],
            "apmaterno" => $datos['apmaterno'],
            "genero" => $datos['genero'],
            "email" => $datos['email'],
            "password" => $contraseñaEncriptada,
            "estado" => $datos['estado'],
        );

        if(!empty($_FILES['file']['name'])){

                /* Obtenemos el nombre del archivo, en este caso una imagen */
                $filename = $_FILES['file']['name'];
             
                /* Ruta */
                $ruta = "imagenes/".$filename;
                $datosActualizar['foto'] = $ruta;
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

        $this->db->where('iddocente', $iddocente);
        $this->db->set($datosActualizar);
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
    public function eliminarRelacionMateriaDocente(){
        $idmateria = $_POST['idmateria'];
        $this->db->where('id', $idmateria);
        $this->db->delete('materiasDocentes');
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
                    "cursando" => $data['cursando'],
                    "adeudos" => $data['adeudos']       );
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
            case 'materiasDocentes':
                $datosInsertar = array(
                    "id_materia" => $data['materia'],
                    "id_docente" => $data['docente']
                );
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
                $this->load->database();
              $datosInsertar['idalumno'] = $insert;
              $id_alumno = $insert;
              $dadaDeAlta = 1;
              $queryMaterias = "select * from materias where grado = '".$data['cursando']."' ";
              $queryMaterias = $this->db->query($queryMaterias)->result_array();
              foreach($queryMaterias as $materia){
                $datosCaptura = array(
                    "idMateria" => $materia['idmateria'],
                    "idAlumno" => $id_alumno,
                    "dadaDeAlta" => $dadaDeAlta
                );
            
            $this->db->insert('capturaCalificaciones', $datosCaptura);
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
              }
            
            break;
            case 'docentes':
                $datosInsertar['iddocente'] = $insert;
            break;
            case 'materias':
                $datosInsertar['idmateria'] = $insert;
            break;
            case 'materiasDocentes':
                $query = "select *,materias.nombre as nombreMateria,docentes.nombre as nombreDocente from materiasDocentes
                left join materias on materiasDocentes.id_materia = materias.idmateria
                left join docentes on materiasDocentes.id_docente = docentes.iddocente where id = ".$insert." ";
                $query = $this->db->query($query)->result_array();
                $datosInsertar['idAsignacionMateria'] = $insert;
                $datosInsertar['datosJoin'] = $query;
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