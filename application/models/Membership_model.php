<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Membership_model
 * Clase Membresía
 */
class Membership_model extends CI_Model {

        /**
         * Contructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_membership";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $name;

        /**
         * @var String
         */
        public $since;

        /**
         * @var String
         */
        public $until;

        /**
         * @var String
         */
        public $status_row;


}