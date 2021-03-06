<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 * Organization_model
 * Organigrama
 */
class Organization_model extends Entity_model {

    /**
     * Constructor
     */
    public function __construct() {
            parent::__construct();
            $this->load->model("Entity_tag_model","entity_tag");
    }

    /**
     * @var String
     */
    public $name;

    /**
     * @var Object
     */
    public $categories= null;

    /**
     * @var Object
     */
    public $tags= null;

    /**
     * find
     *
     * Devuelve un objeto organization
     *
     * @param Integer $id
     * @return Object
     */
    public function find($id) {
        $this->db->select("u.*, u.first_name as name");
        $this->db->where("id", $id);
        $this->db->where('type', ORGANIZATION);
        $this->db->where("status_row", ENABLED);
        $q= $this->db->get($this->table." u");
        $entity= ($q->num_rows() > 0 ? $q->row(0,"Organization_model") : $q->row());

        if(isset($entity->id)){
                $entity->addresses= $this->address->find_by_entity($entity->id);
                $entity->contact= $this->contact->find($entity->id_contact);

                if(!isset($entity->contact->id)){
                    $entity->contact= $this->contact;
                }

                if($entity->id_parent==1){
                    $entity->id_parent=null;
                }

                $entity->categories= $this->entity_category->find_categories_by_entity($entity->id);
                $entity->tags= $this->entity_tag->find_tags_by_entity($entity->id);
        }

        return $entity;
    }

    /**
     * find_children
     *
     * Devuelve un objeto de resultado de bases de datos que contiene objetos nodos hijos de un nodo padre que componen el organigrama
     *
     * @param Integer $id
     * @return Object
     */
    public function find_children($id) {
        $this->db->select("u.*, u.first_name as name, , trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name");
        $this->db->where("id_parent", $id);
        $this->db->where('status_row', ENABLED);
        $nodes= $this->db->get($this->table. " u");

        return $nodes;
    }

    /**
     * find_parents
     *
     * Devuelve un objeto de resultado de bases de datos que contiene objetos nodos organization
     *
     * @return Object
     */
    public function find_parents() {
        $this->db->select("u.*, u.first_name as name");
        $this->db->where("type",ORGANIZATION);
        $this->db->where('status_row', ENABLED);
        $nodes= $this->db->get($this->table. " u");

        return $nodes;
    }

    public function find_parents_by_category( $category ) {
        $this->db->select("u.*, u.first_name as name");
        $this->db->from($this->table. " u");
        $this->db->join('entities_categories ec','ec.id_entity = u.id');
        $this->db->where("type",ORGANIZATION);
        $this->db->where('u.status_row', ENABLED);
        $this->db->where('ec.id_category', $category);
        $this->db->group_by('u.id');
        $nodes= $this->db->get();

        return $nodes;
    }
}