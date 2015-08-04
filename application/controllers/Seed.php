<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seed extends CI_Controller {
        public function __construct(){
            parent::__construct();
            // can only be called from the command line
//            if (!$this->input->is_cli_request()) {
//                exit('Direct access is not allowed');
//            }

            // can only be run in the development environment
            if (ENVIRONMENT !== 'development') {
                exit('Wowsers! You don\'t want to do that!');
            }

            // initiate faker
            $this->faker = Faker\Factory::create();
            //$this->faker->seed(4321);

            // load any required models
            $this->load->model('Member_model','member');
            $this->load->model('Profile_model','profile');
            $this->load->model('Access_log_model','access');
            $this->load->model('History_model','history');
            $this->load->model('Organization_category_model','category');
        }

	public function run($limit=50)
	{
            // purge existing data
            $this->_truncate_db();

            // seed users
            $this->_seed_entities($limit);
            $this->_seed_history();
            $this->_seed_categories();

        }

        private function _seed_entities($limit)
        {
            echo "seeding $limit users";

            //admin
            $entity = array(
                'username' => 'admin', // get a unique nickname
                'password' => md5("demo"),
                'type' => ADMIN,
                'first_name' => 'Administrador',
                'last_name' => 'General',
                'email' => 'admin@keypanel.org',
                'status_row' => ENABLED
            );
            $id_entity= $this->member->save($entity);

            // create a bunch of base buyer accounts
            for ($i = 0; $i < $limit+1; $i++) {
                echo ".";

                if($i==0){
                    //member
                    $entity = array(
                        'username' => 'johndoe', // get a unique nickname
                        'password' => md5("demo"),
                        'type' => MEMBER,
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'email' => 'johndoe@keypanel.org',
                        'status_row' => ENABLED
                    );
                }else{
                    $types= array('MEMBER','PROFILE');
                    $entity = array(
                        'username' => $this->faker->unique()->userName, // get a unique nickname
                        'password' => md5("demo"),
                        'type' => $this->faker->randomElement($types),
                        'first_name' => $this->faker->firstName,
                        'last_name' => $this->faker->lastName,
                        'email' => $this->faker->unique()->email,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                        //'avatar' => $this->faker->imageUrl,
                    );
                }

                $id_entity= $this->member->save($entity);

                //logs
                $random= rand(1,10);
                for($j=0; $j<=$random; $j++){
                    $data = array(
                        'id_entity' => $id_entity,
                        'ip_address' => $this->faker->ipv4,
                        'browser' => $this->faker->userAgent,
                    );

                    $this->access->save($data);
                }

                //address
                if(rand(1,0)){
                    $types= array('HOME','BUSINESS', 'POBOX');
                    $data = array(
                        'id_entity' => $id_entity,
                        'type' => $this->faker->randomElement($types),
                        'street' => $this->faker->streetName,
                        'num_ext' => $this->faker->buildingNumber,
                        'num_int' => $this->faker->buildingNumber,
                        'neighborhood' => $this->faker->realText(rand(20, 40)),
                        'zip_code' => $this->faker->randomNumber(5),
                        'city' => $this->faker->city,
                        'state' => $this->faker->realText(rand(20, 40)),
                        'country' => $this->faker->country,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                        //'avatar' => $this->faker->imageUrl,
                    );

                    $this->address->save($data);
                }

                //contacts
                if(rand(1,0)){
                    $data = array(
                        'id_entity' => $id_entity,
                        'bio' => $this->faker->realText(rand(10, 400)),
                        'description' => $this->faker->realText(rand(100, 1000)),
                        'phone_personal' => $this->faker->phoneNumber,
                        'phone_business' => $this->faker->phoneNumber,
                        'facebook' => $this->faker->url,
                        'twitter' => $this->faker->url,
                        'linkedin' => $this->faker->url,
                        'gplus' => $this->faker->url,
                        'email_personal' => $this->faker->email,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                        //'avatar' => $this->faker->imageUrl,
                    );

                    $this->contact->save($data);
                }

            }

            echo PHP_EOL;
        }

        private function _seed_history(){
            echo "seeding history users from members";
            //history
            foreach ($this->member->find_all(MEMBER)->result() as $member) {
                $random= rand(1,20);
                for($k=0; $k<=$random; $k++){
                    $profiles= $this->profile->find_all(PROFILE);

                    $data = array(
                        'id_member' => $member->id,
                        'id_profile' => $profiles->row(rand(0, $profiles->num_rows()-1))->id,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );

                    $this->member->history_save($data);
                }
            }

            echo PHP_EOL;
        }

        private function _seed_categories(){
            echo "seeding categories";

            //categorias fijas
            $data = array(
                'id_parent' => NULL,
                'breadcrumb' => NULL,
                'name' => 'PÚBLICO',
            );

            $id_cat_publico= $this->category->save($data);

            $data = array(
                'id_parent' => NULL,
                'breadcrumb' => NULL,
                'name' => 'OTROS',
            );

            $id_cat_otros= $this->category->save($data);


            //categorias publicas hijas
            {
                $data = array(
                    'id_parent' => $id_cat_publico,
                    'breadcrumb' => $id_cat_publico,
                    'name' => 'ESTADO CENTRAL',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $insert_id= $this->category->save($data);
                $breadcrumb= $id_cat_publico."|".$insert_id;
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION EJECUTIVA',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $insert_id_x= $this->category->save($data);
                    $breadcrumb_x= $breadcrumb."|".$insert_id_x;
                        $data = array(
                            'id_parent' => $insert_id_x,
                            'breadcrumb' => $breadcrumb_x,
                            'name' => 'MINISTERIOS',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);
                        $data = array(
                            'id_parent' => $insert_id_x,
                            'breadcrumb' => $breadcrumb_x,
                            'name' => 'MINISTERIO COORDINADOR',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);

                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION LEGISLATIVA',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION JUDICIAL',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION ELECTORAL',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION DE TRANSPARECIA Y CONTROL SOCIAL',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'OTROS',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $insert_id= $this->category->save($data);
                    $breadcrumb= $breadcrumb."|".$insert_id;
                        $data = array(
                            'id_parent' => $insert_id,
                            'breadcrumb' => $breadcrumb,
                            'name' => 'CUERPOS COLEGIADOS',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);
                        $data = array(
                            'id_parent' => $insert_id,
                            'breadcrumb' => $breadcrumb,
                            'name' => 'EMPRESAS PUBLICAS',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);


                $data = array(
                    'id_parent' => $id_cat_publico,
                    'breadcrumb' => $id_cat_publico,
                    'name' => 'GADS',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $insert_id= $this->category->save($data);
                $breadcrumb= $id_cat_publico."|".$insert_id;
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'PERFECTURAS',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);

                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'ALCALDIAS',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);

            }

            {
                //categorias otras hijas
                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'EMBAJADAS Y CONSULADOS',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'FUNDACIONES',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'MEDIOS DE COMUNICACION',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'ACADEMIA',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'ORGANISMOS INTERNACIONALES',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);
            }


            echo PHP_EOL;
        }

        private function _truncate_db(){

            foreach ($this->db->list_tables() as $table) {
                $this->db->truncate($table);
            }

        }

}