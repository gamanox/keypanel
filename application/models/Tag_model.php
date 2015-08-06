<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Tag_model
 * Etiquetas del sistema
 */
class Tag_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "tags";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $breadcrumb;

        /**
         * @var String
         */
        public $name;

        /**
         * @var Object
         */
        public $parent;

        /**
         * @var String
         */
        public $create_at;

        /**
         * @var String
         */
        public $update_at;

        /**
         * @var String
         */
        public $status_row;

        /**
         * save
         *
         * Guarda una etiqueta
         *
         * @param Array $tag
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($tag ) {
            $tag['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $tag);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza una etiqueta
         *
         * @param Array $tag
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($tag ) {
            $tag['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $tag, array("id" => $tag['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una etiqueta lógicamente, es decir actualiza  el campo <b>status_row  a <i>DELETED</i></b>
         *
         * @param void $id
         * @return Integer Devuelve la cantidad de registros afectados
         */
        public function delete($id ) {
            $id = (is_array($id) ? $id : array($id));
            if(count($id)){
                $this->db->where_in("id", $id);
                $this->db->limit(count($id));
                $success= $this->db->update($this->table, array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));
            }

            return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
        }

        /**
         * find
         *
         * Devuelve un objeto Etiqueta
         *
         * @param void $id
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $tag= $this->db->get($this->table);

            return ($tag->num_rows() > 0 ? $tag->row(0,"Tag_model") : $tag->row());
        }

        /**
         * find_children
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos etiquetas hijos que tienen como antecesor a una etiqueta nodo padre
         *
         * @param Integer $id
         * @return Object
         */
        public function find_children($id) {
            $this->db->where("id_parent", $id);
            $tags= $this->db->get($this->table);

            return $tags;
        }

        /**
         * find_parents
         *
         * Devuelve un objeto de resultado de bases de datos que contiene etiquetas nodos padres que no tienen un nodo padre asignado
         *
         * @return Object
         */
        public function find_parents() {
            $this->db->where("id_parent is null");
            $tags= $this->db->get($this->table);

            return $tags;
        }

}