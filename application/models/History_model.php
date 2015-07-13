<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class History_model extends CI_Model {

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
         * @var \\Member
         */
        public $member;

        /**
         * @var \\Profile
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