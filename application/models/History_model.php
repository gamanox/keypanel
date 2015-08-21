<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * History_model
 * Perfiles vistos
 */
class History_model extends CI_Model {

        /**
         * Contructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_history";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $member;

        /**
         * @var Object
         */
        public $profile;

        /**
         * @var String
         */
        public $create_at;

        /**
         * @var String
         */
        public $update_at;

        /**
         * @var String
         */
        public $status_row;



}