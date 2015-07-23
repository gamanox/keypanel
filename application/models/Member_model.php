<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';
/**
 * Member_model
 * Clase miembro
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
         * @var Object
         */
        public $history= null;


        /**
         * validate_credentials
         *
         * Valida las credenciales de un miembro, si son correctas devuelve un array de lo contrario null
         *
         * @param Array $member_data username y password dentro del arreglo
         * @return Array|Null Array('status'=>boolean, 'user_data'=>Array())
         */
        public function validate_credentials($member_data) {
            $response = array('status' => false);
            $this->db->select("u.id, u.username, u.first_name, u.type")
            ->where("(u.username = '".$member_data['username']."' OR u.email= '".$member_data['username']."')")
            ->where('u.password', $member_data['password'])
            ->where('u.status_row', ENABLED);

            $member = $this->db->get($this->table. " u");

            if( $member->num_rows() > 0 ){
                $response['status']    = true;
                $response['user_data'] = $member->row_array();
            }

            return $response;
        }

        /**
         * find_me
         *
         * Devuelve una entidad Member
         *
         * @return Object
         */
        public function find_me() {
                $me= $this->find($this->session->id);
                $me->history= $this->history;
                if(isset($me->id)){
                    $me->history= $this->history();
                }
                return $me;
        }

        /**
         * is_membership_valid
         *
         * Devuelve *1 o 0* si la membresía de un miembro es válida o no.
         *
         * @return Boolean
         */
        public function is_membership_valid() {
                // TODO implement here
                return 1;
        }

        /**
         * history
         *
         * Devuelve un objeto de resultado de bases de datos que contiene los objetos de perfiles vistos
         *
         * @param Integer $limit    Por default null todos
         * @param Integer $offset   A partir de cual registro devolverá la consulta, por default null desde el comienzo
         * @return Object
         */
        public function history($limit=null, $offset=null) {
            $this->db->where("id_entity", $this->session->id);
            $this->db->where('status_row', ENABLED);
            $this->db->order_by("id_entity desc,user_type,nombre");

            if((isset($limit) and is_numeric($limit))){
                $this->db->limit($limit);
            }

            if((isset($offset) and is_numeric($offset))){
                $this->db->offset($offset);
            }

            return $this->db->get("entities_history");
        }

        /**
         * history_save
         *
         * Guarda una relación del perfil visto por el miembro
         *
         * @param Array $history
         * @return Integer
         */
        public function history_save($history) {
                $history['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert("entities_history", $history);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * history_delete
         *
         * Elimina lógicamente uno, varios o todos los perfiles vistos por el miembro, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Mixed $id null, id o array con id's
         * @return Integer Devuelve la cantidad de registros afectados
         */
        public function history_delete($id= null ) {
            $this->db->where("id_entity", $this->session->id);

            if(!is_null($id)){
                $id = (is_array($id) ? $id : array($id));
                $this->db->where_in("id", $id);
                $this->db->limit(count($id));
            }

            $success= $this->db->update("entities_history", array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));


            return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
        }

}