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
        $this->db->select("u.id, u.username, u.first_name, u.last_name, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name, u.avatar, u.type")
            ->where("(u.username = '".$member_data['username']."' OR u.email= '".$member_data['username']."')")
            ->where('u.password', $member_data['password'])
            ->where_in('u.type', array( SUPERADMIN, MEMBER ))
            ->where('u.status_row', ENABLED);

        $member = $this->db->get($this->table. " u");

        if( $member->num_rows() > 0 ){
            $response['status']    = true;
            $response['user_data'] = $member->row_array();
        }

        return $response;
    }

    /**
     * find
     *
     * Devuelve un objeto miembro
     *
     * @param Integer $id
     * @return Object
     */
    public function find($id) {
        $this->db->select("u.*");
        $this->db->where("id", $id);
        $this->db->where('type', MEMBER);
        $this->db->where("status_row", ENABLED);
        $q      = $this->db->get($this->table." u");
        $entity = ($q->num_rows() > 0 ? $q->row(0,"Member_model") : $q->row());

        if( isset($entity) ){
            $entity->history = $this->history;

            if(isset($entity->id)){
                $entity->addresses = $this->address->find_by_entity($entity->id);
                $entity->contact   = $this->contact->find($entity->id_contact);
                $entity->history   = $this->history();
            }
        }

        return $entity;
    }

    /**
     * find_me
     *
     * Devuelve una entidad Member
     *
     * @return Object
     */
    public function find_me() {
        $me = $this->find($this->session->id);

        if( isset($me) ){
            $me->history = $this->history;
            if(isset($me->id)){
                $me->history= $this->history();
            }
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
     * @param Integer $id_member Id del miembro
     * @param Integer $limit    Por default null todos
     * @param Integer $offset   A partir de cual registro devolverá la consulta, por default null desde el comienzo
     * @return Object
     */
    public function history($id_member=null, $limit=null, $offset=null) {
        $id_member= (is_null($id_member) ? $this->session->id : $id_member);
        $this->db->where("id_member", $id_member);
        $this->db->where('status_row', ENABLED);
        $this->db->order_by("create_at",'desc');

        if((isset($limit) and is_numeric($limit))){
            $this->db->limit($limit);
        }

        if((isset($offset) and is_numeric($offset))){
            $this->db->offset($offset);
        }

        $history= $this->db->get("entities_history");

        foreach ($history->result() as $row) {
            $row->profile= parent::find($row->id_profile);
        }

        return $history;
    }

    /**
     * history_save
     *
     * Guarda una relación del perfil visto por el miembro
     *
     * @param Array $history
     * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
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

    /**
     * update_access_log
     *
     * Esta funcion actualiza el log de accesos del usuario loggeado
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function update_access_log(){
        $this->load->model("Access_log_model","access_log");
        $this->load->library('user_agent');
        $id_entity = $this->session->id;

        $access_log_history = $this->access_log->find_by_entity($id_entity);

        $new_access_log = array(
                'id_entity'  => $id_entity,
                'date'       => date('Y-m-d H:i:s'),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'browser'    => $this->agent->browser .' '. $this->agent->version .' '. $this->agent->platform
            );

        if( $access_log_history->num_rows() < 10 ){
            $this->access_log->save($new_access_log);
        }
        else {
            // Eliminamos el primer login
            $this->access_log->delete($access_log_history->row('id'));

            // Registramos el nuevo
            $this->access_log->save($new_access_log);
        }
    }
}