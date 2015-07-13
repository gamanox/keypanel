<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';
/**
 *
 */
class Member_model extends Entity_model {


        /**
         * @var String
         */
        public $last_name;

        /**
         * @var Object
         */
        public $membership;


        /**
         * Valida las credenciales de un miembro, si son correctas devuelve el objeto Member de lo contrario null
         * @param String $username
         * @param String $password
         * @return Object
         */
        public function validate_credentials($username, $password) {
                $this->db->where('u.username', $username)
                        ->or_where('u.email', $username)
                        ->where('u.password', $password)
                        ->where('u.status_row', ENABLED);

                $member = $this->db->get($this->table. " u");
                if( $member->num_rows() <= 0 ){
                        return null;
                }

                return $member->row(0,"Member_model");
        }

        /**
         * Devuelve una entidad Member
         * @return return Object
         */
        public function find_me() {
                $me= $this->find($this->session->id);
                return $me;
        }

        /**
         * Devuelve *1 o 0* si la membresía de un miembro es válida o no.
         * @return Boolean
         */
        public function is_membership_valid() {
                // TODO implement here
                return 1;
        }

        /**
         * Devuelve un objeto de resultado de bases de datos que contiene los objetos de perfiles vistos
         * @return return Object[]
         */
        public function history() {
                // TODO implement here
                return null;
        }

        /**
         * Guarda una relación del perfil visto por el miembro
         * @param Integer $id_profile
         * @return Integer
         */
        public function history_save($id_profile) {
                // TODO implement here
                return null;
        }

        /**
         * Elimina lógicamente un perfil visto por el miembro, es decir actualiza  el campo __status_row__ a __DELETED__
         * @param Integer $id
         * @return Boolean
         */
        public function history_delete($id= null ) {
                // TODO implement here
                return null;
        }

}