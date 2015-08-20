<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * AccessLog_model
 * Log de accesos al sistema
 */
class Access_log_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_access_log";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Integer
         */
        public $id_user;

        /**
         * @var String
         */
        public $date;

        /**
         * @var String
         */
        public $ip_address;

        /**
         * @var String
         */
        public $browser;

        /**
         * save
         *
         * Guarda un acceso
         *
         * @param Array $access_log
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($access_log) {
                $access_log['date']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $access_log);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * delete
         *
         * Elimina a un acceso
         *
         * @param Integer $id
         * @return Integer Devuelve la cantidad de registros afectados
         */
        public function delete($id) {
                $id = (is_array($id) ? $id : array($id));
                if(count($id)){
                    $this->db->where_in("id", $id);
                    $this->db->limit(count($id));
                    $success= $this->db->delete($this->table);
                }

                return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
        }

        /**
         * find_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos de acceso de una entidad especificada
         *
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $access_logs= $this->db->get($this->table);

                return $access_logs;
        }

}