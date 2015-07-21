<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Organization_model
 * Organigrama
 */
class Organization_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "organization";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $parent;

        /**
         * @var String
         */
        public $breadcrumb;

        /**
         * @var String
         */
        public $name;

        /**
         * @var String
         */
        public $description;

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
         * Guarda un nodo en el organigrama
         *
         * @param Array $node
         * @return Integer
         */
        public function save($node ) {
            $node['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $node);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza un nodo en el organigrama
         *
         * @param Array $node
         * @return Integer
         */
        public function update($node ) {
            $node['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $node, array("id" => $node['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a un nodo del organigrama lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param void $id
         * @return Integer
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
         * Devuelve un objeto Organization
         *
         * @param void $id
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $node= $this->db->get($this->table)->row(0,"Organization_model");

            return $node;
        }

        /**
         * find_children
         *
         * Devuelve un objeto de resultado de bases de datos que contiene objetos nodos hijos de un nodo padre que componen el organigrama
         *
         * @param Integer $id
         * @return Object
         */
        public function find_children($id) {
            $this->db->where("id_parent", $id);
            $nodes= $this->db->get($this->table);

            return $nodes;
        }

}