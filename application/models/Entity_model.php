<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Entity_model extends CI_model {
        public $table= "entities";
        /**
         *
         */
        public function __construct() {
                parent::__construct();
                $this->load->model("Address_model", "address");
                $this->load->model("Contact_model", "contact");
        }

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $name;

        /**
         * @var String
         */
        public $type;

        /**
         * @var String
         */
        public $username;

        /**
         * @var String
         */
        public $password;

        /**
         * @var String
         */
        public $email;

        /**
         * @var String
         */
        public $avatar;

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
         * @var Array
         */
        public $addresses= array();

        /**
         * @var Array
         */
        public $contacts= array();

        /**
         * @var Array
         */
        public $comments= array();

        /**
         * @var Array
         */
        public $posts= array();


        /**
         * Guarda una entidad
         * @param Array $entity
         * @return Integer
         */
        public function save($entity) {
                $entity['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $entity);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * Actualiza datos de una entidad
         * @param Array $entity
         * @return Integer
         */
        public function update($entity) {
                $entity['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $entity, array("id" => $entity['id']));
                return ($success ? 1 : 0);
        }

        /**
         * Elimina a una entidad lógicamente, es decir actualiza  el campo __status_row__ a __DELETED__
         * @param Integer $id
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
         * Devuelve un objeto entidad
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name",false);
                $this->db->where("id", $id);
                $entity= $this->db->get($this->table. " u")->row(0,"Entity_model");

                if(isset($entity->id)){
                        $entity->addresses= $this->address->find_by_entity($entity->id);
                        $entity->contacts= $this->contact->find_by_entity($entity->id);
                }

                return $entity;
        }

}