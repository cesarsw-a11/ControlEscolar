<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Docente extends CI_Controller
{
    //Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->model("administrador_m");
    }

    public function index()
    {
        #Solo los usuarios de tipo Admin podran acceder a esta vista.
        if ($this->session->userdata("rol") == "2") {
            $data['docente'] = $this->obtenerDocente();
            $this->load->view('docentes/main_docente', $data);
        } else {
            echo "<h2>sin acceso a esta vista</h2><a href=" . base_url("/") . ">Volver a la pagina principal</a>";
        }
    }
    public function obtenerDocente()
    {
        $query = "select * from docentes where iddocente = '" . $this->session->userdata('id') . "' ";
        $query = $this->db->query($query)->row();
        return $query;
    }

    public function obtenerData()
    {
        $query = "select *,materias.nombre as nombreMateria,docentes.nombre as nombreDocente from materiasDocentes
                    left join materias on materiasDocentes.id_materia = materias.idmateria
                    left join docentes on materiasDocentes.id_docente = docentes.iddocente where iddocente = " . $this->session->userdata("id") . " ";
        $query = $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function capturaCalificaciones($grado = "", $id_materia = "", $nombre_materia = "")
    {
        $this->session->set_userdata("grado", $grado);
        $this->session->set_userdata("id_materia", $id_materia);
        $query = "select * from alumnos where cursando = '" . $grado . "' ";
        $query = $this->db->query($query)->result_array();
        $data['infoAlumno'] = $query;
        $data['id_materia']  = $id_materia;
        $data['nombre_materia'] = $nombre_materia;
        $this->load->view("docentes/capturaCalificaciones", $data);
    }

    public function obtenerAlumnosmaterias()
    {
        $id_materia = $this->session->userdata("id_materia");
        $query = "select *,idCalificacion as calificacion from capturaCalificaciones 
        left join alumnos on capturaCalificaciones.idAlumno = alumnos.idalumno where idMateria = " . $id_materia . " and dadaDeAlta = 1 ";
        //$query = "select * from alumnos where cursando = '".$this->session->userdata("grado")."' ";
        $query  = $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function capturarCalificacion()
    {
        $datos = $this->input->post();
        $id_alumno = $datos['idalumno'];
        $valorColumna = $datos['valorColumna'];
        $idmateria = $datos['idmateria'];
        $nombreColumna = $datos['nombreColumna'];
        $datosActualizar = array(
            $nombreColumna => $valorColumna
        );

        $this->db->where('idCalificacion', $datos['idCalificacion']);
        $this->db->set($datosActualizar);
        $this->db->update('capturaCalificaciones');
    }

    public function obtenerDataCalificacion()
    {
        $idCalificacion = $this->input->post("idCalificacion");
        $query = "select * from capturaCalificaciones where idCalificacion = '" . $idCalificacion . "' ";
        $query = $this->db->query($query)->result();

        echo json_encode($query);
    }

    public function editarCapturaCalificacion()
    {
        $datos = $this->input->post();
        $datosActualizar = array(
            "unidad1" => $datos['unidad1'],
            "unidad2" => $datos['unidad2'],
            "unidad3" => $datos['unidad3'],
            "opc" => $datos['observaciones']
        );

        $this->db->where('idCalificacion', $datos['idCalificacion']);
        $this->db->set($datosActualizar);
        $this->db->update('capturaCalificaciones');

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
}
