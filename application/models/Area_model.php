<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 * Area_model
 * Organigrama
 */
class Area_model extends Entity_model {

    /**
     * Constructor
     */
    public function __construct() {
            parent::__construct();
    }

    /**
     * @var String
     */
    public $name;

    /**
     * find
     *
     * Devuelve un objeto area
     *
     * @param Integer $id
     * @return Object
     */
    public function find($id) {
        $this->db->select("u.*, u.first_name as name");
        $this->db->where("id", $id);
        $this->db->where('type', AREA);
        $this->db->where("status_row", ENABLED);
        $q= $this->db->get($this->table." u");
        $entity= ($q->num_rows() > 0 ? $q->row(0,"Area_model") : $q->row());

        return $entity;
    }
}