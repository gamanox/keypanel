<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Category_model
 * Categorias del los organigramas
 */
class Category_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "categories";

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
         * Guarda una categoria
         *
         * @param Array $category
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($category ) {
            $category['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $category);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza una categoria
         *
         * @param Array $category
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($category ) {
            $category['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $category, array("id" => $category['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una categoria lógicamente, es decir actualiza  el campo <b>status_row  a <i>DELETED</i></b>
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
         * Devuelve un objeto categoria
         *
         * @param void $id
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $this->db->where('status_row', ENABLED);
            $node= $this->db->get($this->table);

            return ($node->num_rows() > 0 ? $node->row(0,"Category_model") : $node->row());
        }

        /**
         * find_by_slug
         *
         * Devuelve un objeto categoria
         *
         * @param void $slug slug de la categoría
         * @return Object
         */
        public function find_by_slug($slug) {
            $this->db->where("slug", $slug);
            $this->db->where('status_row', ENABLED);
            $node= $this->db->get($this->table);

            return ($node->num_rows() > 0 ? $node->row(0,"Category_model") : $node->row());
        }

        /**
         * find_children
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos categorias hijos que tienen como antecesor a una categoria nodo padre
         *
         * @param Integer $id
         * @return Object
         */
        public function find_children($id) {
            $this->db->where("id_parent", $id);
            $this->db->where('status_row', ENABLED);
            $categories= $this->db->get($this->table);

            return $categories;
        }

        /**
         * find_parents
         *
         * Devuelve un objeto de resultado de bases de datos que contiene categorias nodos padres que no tienen un nodo padre asignado
         *
         * @return Object
         */
        public function find_parents() {
            $this->db->where("id_parent is null");
            $this->db->where('status_row', ENABLED);
            $categories= $this->db->get($this->table);

            return $categories;
        }

}