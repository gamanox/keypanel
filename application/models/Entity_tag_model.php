<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Entity_tag_model extends CI_Model {

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
         * @var \\Entity
         */
        public $entity;

        /**
         * @var \\Tag
         */
        public $tag;



}