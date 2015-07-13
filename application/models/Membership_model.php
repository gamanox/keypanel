<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Membership_model extends CI_Model {

        /**
         *
         */
        public function __construct() {
                parent::__construct();
        }

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