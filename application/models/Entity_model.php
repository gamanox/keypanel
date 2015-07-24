<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Entity_model
 * Entidades de la plataforma
 */
class Entity_model extends CI_model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
                $this->load->model("Address_model", "address");
                $this->load->model("Contact_model", "contact");
        }

        /**
         * @var String
         */
        public $table= "entities";

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
         * @var Object
         */
        public $addresses= null;

        /**
         * @var Object
         */
        public $contacts= null;

        /**
         * @var Object
         */
        public $comments= null;

        /**
         * @var Object
         */
        public $posts= null;

        public $user_types = array(
           'SUPERADMIN'  => SUPERADMIN,
           'ADMIN' => ADMIN,
           'MEMBER' => MEMBER,
           'PROFILE' => PROFILE
        );


        /**
         * save
         *
         * Guarda una entidad
         *
         * @param Array $entity
         * @return Integer
         */
        public function save($entity) {
                $entity['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $entity);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza datos de una entidad
         *
         * @param Array $entity
         * @return Integer
         */
        public function update($entity) {
                $entity['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $entity, array("id" => $entity['id']));
                return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una entidad lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
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
         * find
         *
         * Devuelve un objeto entidad
         *
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

        /**
         * find_all
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos entities del sistema
         *
         * @param Mixed $user_type String|Array|Null
         * @param String $status_row    ENABLED|DISABLED
         * @param String $order_by  Order by column1 asc|desc
         *
         * @return Object
         */
        function find_all($user_type=null, $status_row= ENABLED, $order_by=null) {
            $user_type= (is_null($user_type) ? array_keys($this->user_types) : array($user_type));
            $status_row= (is_array($status_row) ? $status_row : array($status_row));

            $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name",false);

            if(count($user_type)){
                $this->db->where_in("type", $user_type);
            }

            if(count($status_row)){
                $this->db->where_in("status_row", $status_row);
            }

            if(!is_null($order_by)){
                $this->db->order_by($order_by);
            }

            $entities= $this->db->get($this->table. " u");

            return $entities;
        }


}