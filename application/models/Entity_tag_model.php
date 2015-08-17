<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entity_tag_model
 * Perfiles etiquetados
 */
class Entity_tag_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_tags";

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
        public $tag;

        /**
         * find_entities_by_tag
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos entidades  etiquetados con id de etiqueta especificado
         *
         * @param Integer $id
         * @return Object
         */
        public function find_entities_by_tag($id) {
            $this->db->select("et.id id_relation, e.*");
            $this->db->where("et.id_tag", $id);
            $this->db->where('e.status_row', ENABLED);
            $this->db->where('et.status_row', ENABLED);
            $this->db->join("entities e","e.id=et.id_entity");
            $nodes= $this->db->get($this->table." et");

            return $nodes;
        }

        /**
         * find_tags_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos etiquetas asignadas a un id entidad especificado
         *
         * @param Integer $id
         * @return Object
         */
        public function find_tags_by_entity($id) {
            $this->db->select("et.id id_relation, t.*");
            $this->db->where("et.id_entity", $id);
            $this->db->where('t.status_row', ENABLED);
            $this->db->where('et.status_row', ENABLED);
            $this->db->join("tags t","t.id=et.id_tag");
            $nodes= $this->db->get($this->table." et");

            return $nodes;
        }

        /**
         * save
         *
         * Guarda una relación entity tag
         *
         * @param Array $entity_tag
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($entity_tag ) {
            $entity_tag['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $entity_tag);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Guarda una relación entity tag
         *
         * @param Array $entity_tag
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($entity_tag ) {
            $entity_tag['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $entity_tag, array("id" => $entity_tag['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina una relación entity tag lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
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