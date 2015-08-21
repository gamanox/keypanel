<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 * Profile_model
 * Clase perfil
 */
class Profile_model extends Entity_model {


    /**
     * @var String
     */
    public $last_name;

    /**
     * @var Object
     */
    public $related_tags;

    /**
     * find
     *
     * Devuelve un objeto perfil
     *
     * @param Integer $id
     * @return Object
     */
    public function find($id) {
        $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name");
        $this->db->where("id", $id);
        $this->db->where('type', PROFILE);
        $this->db->where("status_row", ENABLED);
        $q= $this->db->get($this->table." u");
        $entity= ($q->num_rows() > 0 ? $q->row(0,"Profile_model") : $q->row());

        if(isset($entity->id)){
                $entity->address= $this->address->find_by_entity($entity->id);
                $entity->address= $entity->address->row();

                if(!isset($entity->address->id)){
                    $entity->address= $this->address;
                }

                $entity->contact= $this->contact->find($entity->id_contact);
                if(!isset($entity->contact->id)){
                    $entity->contact= $this->contact;
                }
                
                $entity->tags= $this->entity_tag->find_tags_by_entity($entity->id);
        }

        return $entity;
    }

    /**
     * find_all_by_breadcrumb
     * Devuelve un objeto de resultado de base de datos que contiene perfiles de un breadcrumb especifico
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return object
     */
    public function find_all_by_breadcrumb( $breadcrumb, $position = 'after' ){
        $this->db->select('*')
            ->from('entities')
            ->where('type','PROFILE')
            ->like('breadcrumb', $breadcrumb, $position)
            ->where('status_row', 'ENABLED');

        $profiles = $this->db->get();

        return $profiles;
    }

}