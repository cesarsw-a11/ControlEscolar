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

        if($this->db->insert('alumno', $dataInsertar)){
            return true;
        }else{
            return false;
        }

    }

}



?>