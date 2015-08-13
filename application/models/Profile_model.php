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
         * find
         *
         * Devuelve un objeto perfil
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
            // TODO implement here
            return parent::find($id);
        }

    /**
     * find_all_by_breadcrumb
     *
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