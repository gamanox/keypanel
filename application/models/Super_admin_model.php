<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 * Admin_model
 * Clase admin
 */
class Super_admin_model extends Entity_model {


    /**
     * @var String
     */
    public $last_name;

    /**
     * find
     *
     * Devuelve un objeto superadmin
     *
     * @return Object
     */
    public function find_me() {
        $this->db->select("u.*");
        $this->db->where("id", $this->session->type);
        $this->db->where('type', SUPERADMIN);
        $this->db->where("status_row", ENABLED);
        $q= $this->db->get($this->table." u");
        $entity= ($q->num_rows() > 0 ? $q->row(0,"Super_admin_model") : $q->row());
        return $entity;
    }

}