<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'models/Entity_model.php';

/**
 *
 */
class Profile_model extends Entity_model {


        /**
         * @var String
         */
        public $last_name;


        /**
         * Devuelve un objeto perfil
         * @param void $id
         * @return return Profile
         */
        public function find($id) {
                // TODO implement here
                return null;
        }

}