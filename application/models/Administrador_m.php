<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador_m extends CI_Model {

    //Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

#Funcion que inserta los datos del alumno en la tabla
    public function guardar($dataInsertar,$tabla){
        //$registroAgregado = $this->db->insert_id();
        if($tabla != 'materias' && $tabla != "materiasDocentes"){
            $contraseñaEncriptada = hash('sha256',$dataInsertar['password']);
            $dataInsertar['password'] = $contraseñaEncriptada;
        }
        $this->db->db_debug = false;

        if(!$this->db->insert($tabla, $dataInsertar)){
            $error = $this->db->error();
            if($error['code'] == 1062){
                $msg = 'Registro duplicado';
                $this->db->db_debug = true;
                return false;
            }
        }else{
            return $this->db->insert_id();
        }

    }

    public function obtener($tabla){
        $query = "select * from ".$tabla." ";
        $query = $this->db->query($query)->result_array();
        return $query;
    }

}



?>