<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Comment_model extends CI_Model {

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
         * @var Comment
         */
        public $parent;

        /**
         * @var String
         */
        public $content;

        /**
         * @var String
         */
        public $approved;

        /**
         * @var String
         */
        public $type;

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