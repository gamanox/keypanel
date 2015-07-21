<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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
         * Devuelve un objeto perfil
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
            // TODO implement here
            return parent::find($id);
        }

}