<?p
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Organization_entity_model
 * Perfiles de un organigrama
 */
class Organization_entity_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "organization_profiles";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $organization;

        /**
         * @var Object
         */
        public $entity;

        /**
         * find_entities_by_organization
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos entidades de un id organización especificado
         *
         * @param Integer $id
         * @return Object
         */
        public function find_entities_by_organization($id) {
            $this->db->select("e.*");
            $this->db->where("oe.id_organization", $id);
            $this->db->join("entities e","e.id=oe.id_entity");
            $nodes= $this->db->get($this->table." oe");

            return $nodes;
        }

        /**
         * save
         *
         * Guarda una relación organization entity
         *
         * @param Array $entity_organization
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($entity_organization ) {
            $entity_organization['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $entity_organization);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * delete
         *
         * Elimina una relación organization entity lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
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