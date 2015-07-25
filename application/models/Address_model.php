<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Address_model
 * Clase dirección
 */
class Address_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
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
         * save
         *
         * Guarda una dirección
         *
         * @param Array $address
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($address) {
                $address['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $address);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza datos de una dirección
         *
         * @param Array $address
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($address) {
                $address['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $address, array("id" => $address['id']));
                return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una dirección lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Integer $id
         * @return Integer Devuelve la cantidad de registros afectados
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
         * find
         *
         * Devuelve un objeto dirección
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->where("id", $id);
                $address= $this->db->get($this->table)->row(0,"Address_model");

                return $address;
        }

        /**
         * find_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos dirección de una entidad especificada
         *
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $address= $this->db->get($this->table);

                return $address;
        }



}