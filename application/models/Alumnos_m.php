<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos_m extends CI_Model {

    //Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

#Funcion que inserta los datos del alumno en la tabla
    public function guardarAlumno($dataInsertar){
        //$registroAgregado = $this->db->insert_id();
        $contraseñaEncriptada = hash('sha256',$dataInsertar['contraseña']);
        $dataInsertar['contraseña'] = $contraseñaEncriptada;
        $this->db->db_debug = false;

        if(!$this->db->insert('alumno', $dataInsertar)){
            $error = $this->db->error();
            if($error['code'] == 1062){
                $msg = 'Registro duplicado';
                $this->db->db_debug = true;
                return false;
            }
        }else{
            return true;
        }

    }

}



?>