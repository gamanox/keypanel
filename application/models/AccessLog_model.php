<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class AccessLog_model extends CI_Model {

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
         * @var Integer
         */
        public $id_user;

        /**
         * @var String
         */
        public $date;

        /**
         * @var String
         */
        public $ip_address;

        /**
         * @var String
         */
        public $browser;

}