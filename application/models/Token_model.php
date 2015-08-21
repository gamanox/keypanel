<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Token_model
 * Clase token
 */
class Token_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
                $this->load->model('Member_model','member');
        }

        /**
         * @var String
         */
        public $table= "tokens";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $entity;

        /**
         * @var String
         */
        public $token;

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
        public $expires_at;

        /**
         * @var String
         */
        public $status_row;



        /**
         * save
         *
         * Guarda un token
         *
         * @param Array $token
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($token) {
                $token['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $token);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza un token
         *
         * @param Array $token
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($token) {
                $token['update_at']= date('Y-m-d H:i:s');
                $success= $this->db->update($this->table, $token, array("id" => $token['id']));
                return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina token lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
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
         * Devuelve un objeto token
         *
         * @param String $id Token
         * @return Object
         */
        public function find($id) {
            $today= date('Y-m-d H:i:s');
            $this->db->where("token", $id);
            $this->db->where("status_row", ENABLED);
            $this->db->where("create_at <=", $today);
            $this->db->where("expires_at >=", $today);
            $this->db->order_by("create_at","asc");
            $this->db->limit(1);
            $q= $this->db->get($this->table);

            $token= ($q->num_rows() > 0 ? $q->row(0,"Token_model") : $q->row());

            if(isset($token->id)){
                $token->entity= $this->member->find($token->id_entity);
            }

            return $token;
        }
}