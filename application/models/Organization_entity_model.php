<?p
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Organization_entity_model extends CI_Model {

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
         * @var \\Organization
         */
        public $organization;

        /**
         * @var \\Entity
         */
        public $entity;



}