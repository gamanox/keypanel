<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 *
 * Clase para el FAQ
 */
class Faq_model extends CI_Model {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @var String
     */
    public $table = "faqs";

    /**
     * @var Integer
     */
    public $id;

    /**
     * @var String
     */
    public $content;

    /**
     * @var String
     */
    public $title;

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
     * save
     *
     * Guarda un faq
     *
     * @param Array $faq
     * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
     */
    public function save($faq) {
        $faq['create_at']= date('Y-m-d H:i:s');
        $success= $this->db->insert($this->table, $faq);
        return ($success ? $this->db->insert_id() : 0);
    }

    /**
     * update
     *
     * Actualiza datos de  un faq
     *
     * @param Array $faq
     * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
     */
    public function update($faq) {
        $faq['update_at']= date('Y-m-d H:i:s');
        $success= $this->db->update($this->table, $faq, array("id" => $faq['id']));
        return ($success ? 1 : 0);
    }

    /**
     * delete
     *
     * Elimina un faq lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
     *
     * @param Integer $id
     * @return Integer Devuelve la cantidad de registros afectados
     */
    public function delete($id ) {
        $id = (is_array($id) ? $id : array($id));
        if(count($id)){
            $this->db->where_in("id", $id);
            $this->db->limit(count($id));
            $success = $this->db->update($this->table, array("update_at" => date('Y-m-d H:i:s'), "status_row" => DELETED));
        }

        return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
    }

    /**
     * find
     *
     * Devuelve un objeto faq
     *
     * @param Integer $id
     * @return Object
     */
    public function find($id) {
        $this->db->where("id", $id);
        $this->db->where("status_row", ENABLED);
        $faq = $this->db->get($this->table);

        return ($faq->num_rows() > 0 ? $faq->row(0,"Faq_model") : $faq->row());
    }

    /**
     * find_all
     *
     * Devuelve un objeto de resultado de bases de datos que contiene a todos los objetos post
     *
     * @return Object
     */
    public function find_all() {
        $this->db->where('status_row', ENABLED);
        $this->db->order_by("create_at","desc");
        $faqs = $this->db->get($this->table);

        return $faqs;
    }
}