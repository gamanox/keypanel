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

}