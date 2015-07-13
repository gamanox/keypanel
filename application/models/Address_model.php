<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Address_model extends CI_Model {

        /**
         *
         */
        public function __construct() {
                parent::__construct();
        }

        public $table= "entities_address";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $type;

        /**
         * @var String
         */
        public $street;

        /**
         * @var String
         */
        public $num_ext;

        /**
         * @var String
         */
        public $num_int;

        /**
         * @var String
         */
        public $neighborhood;

        /**
         * @var String
         */
        public $zip_code;

        /**
         * @var String
         */
        public $city;

        /**
         * @var String
         */
        public $state;

        /**
         * @var String
         */
        public $country;

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
         * Guarda una dirección
         * @param Array $address
         * @return Integer
         */
        public function save($address) {
                $address['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $address);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * Actualiza datos de una dirección
         * @param Array $address
         * @return Integer
         */
        public function update($address) {
                $address['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $address, array("id" => $address['id']));
                return ($success ? 1 : 0);
        }

        /**
         * Elimina a una dirección lógicamente, es decir actualiza  el campo __status_row__ a __DELETED__
         * @param Integer $id
         * @return Integer
         */
        public function delete($id) {
                $id = (is_array($id) ? $id : array($id));
                if(count($id)){
                    $this->db->where_in("id", $id);
                    $this->db->limit(count($id));
                    $success= $this->db->update($this->table, array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));
                }

                return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
        }

        /**
         * Devuelve un objeto dirección
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->where("id", $id);
                $address= $this->db->get($this->table)->row(0,"Address_model");

                return $address;
        }

        /**
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos dirección de una entidad especificada
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $address= $this->db->get($this->table);

                return $address;
        }



}