<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 * Organization_model
 * Organigrama
 */
class Organization_model extends Entity_model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
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
            $this->db->where('status_row', ENABLED);
            $nodes= $this->db->get($this->table);

            return $nodes;
        }

        /**
         * find_parents
         *
         * Devuelve un objeto de resultado de bases de datos que contiene objetos nodos organization
         *
         * @return Object
         */
        public function find_parents() {
            $this->db->where("type",ORGANIZATION);
            $this->db->where('status_row', ENABLED);
            $nodes= $this->db->get($this->table);

            return $nodes;
        }

}