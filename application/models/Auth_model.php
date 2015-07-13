<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Auth_model extends CI_Model {

        /**
         *
         */
        public function __construct() {
                parent::__construct();
        }

        public $table= "entities_auth";

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
        public $user_type;

        /**
         * @var Integer
         */
        public $id_entity;

        /**
         * @var Integer
         */
        public $create;

        /**
         * @var Integer
         */
        public $read;

        /**
         * @var Integer
         */
        public $update;

        /**
         * @var Integer
         */
        public $delete;

        /**
         * Devuelve un objeto de resultado de bases de datos que contiene los objetos de permisos que tiene la entidad ordenados por el permiso especifico, dejando al final los permisos generales de su tipo de entidad
         * @param Integer $entity_id
         * @param String $entity_type
         * @return Object
         */
        public function find_by_entity($entity_id, $entity_type) {
                $this->db->where("id_entity", $entity_id);
                $this->db->or_where("user_type", $entity_type);
                $this->db->order_by("id_entity,user_type,nombre");

                return $this->db->get($this->table);
        }

        /**
         * Devuelve *1 o 0* que define si esta o no autorizado para ejecutar la acción solicitada
         * @param String $auth
         * @param String $mode
         * @return Boolean
         */
        public function is_auth($auth, $mode) {
                if ($this->session->type == SUPERADMIN) {
                        return true;
                } else {
                        $permisos = $this->find_by_entity($this->session->id, $this->session->type);

                        foreach ($permisos->result() as $permiso) {
                                if ($permiso->nombre === $auth and isset($permiso->$mode) and $permiso->$mode) {
                                        return true;
                                }
                        }

                        return false;
                }
        }

}