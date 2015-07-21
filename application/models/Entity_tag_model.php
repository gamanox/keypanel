<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entity_tag_model
 * Perfiles etiquetados
 */
class Entity_tag_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "entities_tags";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $entity;

        /**
         * @var Object
         */
        public $tag;



}