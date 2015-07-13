<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Contact_model extends CI_Model {

        /**
         *
         */
        public function __construct() {
                parent::__construct();
        }

        public $table= "contacts";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $bio;

        /**
         * @var String
         */
        public $description;

        /**
         * @var String
         */
        public $phone_personal;

        /**
         * @var String
         */
        public $phone_business;

        /**
         * @var String
         */
        public $facebook;

        /**
         * @var String
         */
        public $twitter;

        /**
         * @var String
         */
        public $linkedin;

        /**
         * @var String
         */
        public $gplus;

        /**
         * @var String
         */
        public $email_personal;

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
         * Guarda un contacto
         * @param Array $contact
         * @return Integer
         */
        public function save($contact) {
                $contact['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $contact);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * Actualiza un contacto
         * @param Array $contact
         * @return Integer
         */
        public function update($contact) {
                $contact['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $contact, array("id" => $contact['id']));
                return ($success ? 1 : 0);
        }

        /**
         * Elimina contacto lógicamente, es decir actualiza  el campo __status_row__ a __DELETED__
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
         * Devuelve un objeto contacto
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->where("id", $id);
                $contact= $this->db->get($this->table)->row(0,"Contact_model");

                return $contact;
        }

        /**
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos dirección de una entidad especificada
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $contact= $this->db->get($this->table);

                return $contact;
        }



}