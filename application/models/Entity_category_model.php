<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entity_category_model
 * Perfiles y organigramas categorizadas
 */
class Entity_category_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_categories";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $entity;

        /**
         * @var Object
         */
        public $category;

        /**
         * find_entities_by_category
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos entidades categorizadas con id de categoria especificado
         *
         * @param Integer $id
         * @return Object
         */
        public function find_entities_by_category($id) {
            $this->db->select("e.*");
            $this->db->where("ec.id_category", $id);
            $this->db->where('e.status_row', ENABLED);
            $this->db->where('ec.status_row', ENABLED);
            $this->db->join("entities e","e.id=ec.id_entity");
            $nodes= $this->db->get($this->table." ec");

            return $nodes;
        }

        /**
         * find_categories_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos categorias asignadas a un id entidad especificado
         *
         * @param Integer $id
         * @return Object
         */
        public function find_categories_by_entity($id) {
            $this->db->select("c.*");
            $this->db->where("ec.id_entity", $id);
            $this->db->where('c.status_row', ENABLED);
            $this->db->where('ec.status_row', ENABLED);
            $this->db->join("categories c","c.id=ec.id_category");
            $nodes= $this->db->get($this->table." ec");

            return $nodes;
        }

        /**
         * save
         *
         * Guarda una relación entity category
         *
         * @param Array $entity_category
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($entity_category ) {
            $entity_category['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $entity_category);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * delete
         *
         * Elimina una relación entity category lógicamente, es decir actualiza el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Integer $id
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
}