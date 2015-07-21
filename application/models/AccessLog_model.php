<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * AccessLog_model
 * Log de accesos al sistema
 */
class AccessLog_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_access_log";

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