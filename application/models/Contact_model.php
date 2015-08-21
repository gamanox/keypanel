<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Contact_model
 * Clase contacto
 */
class Contact_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_contacts";

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
         * save
         *
         * Guarda un contacto
         *
         * @param Array $contact
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($contact) {
                $contact['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $contact);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza un contacto
         *
         * @param Array $contact
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($contact) {
                $contact['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $contact, array("id" => $contact['id']));
                return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina contacto lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
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
         * Devuelve un objeto contacto
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->where("id", $id);
                $this->db->where("status_row", ENABLED);
                $contact= $this->db->get($this->table);

                return ($contact->num_rows() > 0 ? $contact->row(0,"Contact_model") : $contact->row());
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
                $this->db->where('status_row', ENABLED);
                $contact= $this->db->get($this->table);

                return $contact;
        }



}