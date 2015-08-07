<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seed extends CI_Controller {
    var $entities_seed=0;
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
            $this->load->model('Category_model','category');
            $this->load->model('Entity_category_model','entity_category');
            $this->load->model('Post_model','post');
        }

	public function run($limit=50)
	{
            $this->entities_seed=$limit;
            // purge existing data
            $this->_truncate_db();

            // seed users
            $this->_seed_entities($limit);
            $id_organization=$this->_seed_organigrama();
            $this->_seed_organigrama_perfiles($id_organization);
            $this->_seed_categories($id_organization);
            $this->_seed_organigrama_categories($id_organization);
            $this->_seed_history();
            $this->_seed_news();


        }

        private function _seed_entities($limit)
        {
            echo "seeding $limit users";

            //admin
            $entity = array(
                'username' => 'admin', // get a unique nickname
                'password' => md5("demo"),
                'type' => SUPERADMIN,
                'first_name' => 'Administrador',
                'last_name' => 'General',
                'email' => 'admin@keypanel.org',
                'status_row' => ENABLED
            );
            $id_superadmin= $this->member->save($entity);

            // create a bunch of base buyer accounts
            for ($i = 0; $i < $limit+1; $i++) {
                echo ".";

                if($i==0){
                    //member
                    $entity = array(
                        'id_parent'=> $id_superadmin,
                        'breadcrumb'=> $id_superadmin,
                        'username' => 'johndoe', // get a unique nickname
                        'password' => md5("demo"),
                        'type' => MEMBER,
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'email' => 'johndoe@keypanel.org',
                        'status_row' => ENABLED
                    );
                }else{
                    $types= array('MEMBER','ORGANIZATION');
                    $entity = array(
                        'id_parent'=> $id_superadmin,
                        'breadcrumb'=> $id_superadmin,
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
                    $types= array('BUSINESS', 'POBOX');
                    $data = array(
                        'id_entity' => $id_entity,
                        'type' => ($entity['type']==MEMBER ? 'HOME' : $this->faker->randomElement($types)),
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

                    $id_contact= $this->contact->save($data);
                    $this->member->update(array("id"=>$id_entity,'id_contact'=>$id_contact));
                }

            }

            echo PHP_EOL;
        }

        private function _seed_organigrama() {
            echo "seeding organizations";
            $organization = array(
                'id_parent'=> 1,
                'breadcrumb'=> 1,
                'username' => 'ministeriosp', // get a unique nickname
                'password' => md5("demo"),
                'type' => ORGANIZATION,
                'first_name' => 'Ministerio de salud pública',
                'email' => 'info@ministeriosp.org',
                'status_row' => ENABLED
            );
            $id_organization= $this->member->save($organization);


            //logs
            $random= rand(1,10);
            for($j=0; $j<=$random; $j++){
                $data = array(
                    'id_entity' => $id_organization,
                    'ip_address' => $this->faker->ipv4,
                    'browser' => $this->faker->userAgent,
                );

                $this->access->save($data);
            }

            //address
            $data = array(
                'id_entity' => $id_organization,
                'type' => 'BUSINESS',
                'street' => $this->faker->streetName,
                'num_ext' => $this->faker->buildingNumber,
                'num_int' => $this->faker->buildingNumber,
                'neighborhood' => $this->faker->realText(rand(20, 40)),
                'zip_code' => $this->faker->randomNumber(5),
                'city' => $this->faker->city,
                'state' => $this->faker->realText(rand(20, 40)),
                'country' => $this->faker->country,
                'status_row' => ENABLED,
                //'avatar' => $this->faker->imageUrl,
            );
            $this->address->save($data);
            $data = array(
                'id_entity' => $id_organization,
                'type' => 'POBOX',
                'street' => $this->faker->streetName,
                'num_ext' => $this->faker->buildingNumber,
                'num_int' => $this->faker->buildingNumber,
                'neighborhood' => $this->faker->realText(rand(20, 40)),
                'zip_code' => $this->faker->randomNumber(5),
                'city' => $this->faker->city,
                'state' => $this->faker->realText(rand(20, 40)),
                'country' => $this->faker->country,
                'status_row' => ENABLED,
                //'avatar' => $this->faker->imageUrl,
            );
            $this->address->save($data);


            //contacts
            $data = array(
                'bio' => $this->faker->realText(rand(10, 400)),
                'description' => 'Ejerce el control sanitario y garantiza la salud através de servicios médicos',
                'phone_business' => $this->faker->phoneNumber,
                'facebook' => $this->faker->url,
                'twitter' => $this->faker->url,
                'linkedin' => $this->faker->url,
                'gplus' => $this->faker->url,
                'status_row' => ENABLED
            );

            $id_contact= $this->contact->save($data);
            $this->member->update(array("id"=>$id_organization,'id_contact'=>$id_contact));

            //AREAS DEL ORGANIGRAMA
            $breadcrumb= "1|".$id_organization;
            $area1 = array(
                'id_parent'=> $id_organization,
                'breadcrumb'=> $breadcrumb,
                'type' => AREA,
                'first_name' => 'Estructura Administrativa',
                'status_row' => ENABLED
            );
            $id_area1= $this->member->save($area1);
                $area11 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Coordinación General de Desarrollo Estratégico en Salud',
                    'status_row' => ENABLED
                );
                $id_area11= $this->member->save($area11);
                    $area111 = array(
                        'id_parent'=> $id_area11,
                        'breadcrumb'=> $area11['breadcrumb']."|".$id_area11,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Inteligencia de la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area111);
                    $area112 = array(
                        'id_parent'=> $id_area11,
                        'breadcrumb'=> $area11['breadcrumb']."|".$id_area11,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Economía de la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area112);
                $area12 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Coordinación General Estratégica',
                    'status_row' => ENABLED
                );
                $id_area12= $this->member->save($area12);
                    $area121 = array(
                        'id_parent'=> $id_area12,
                        'breadcrumb'=> $area12['breadcrumb']."|".$id_area12,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Planificación e Inversión',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area121);
                    $area122 = array(
                        'id_parent'=> $id_area12,
                        'breadcrumb'=> $area12['breadcrumb']."|".$id_area12,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Gestión de Riesgos',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area122);
                    $area123 = array(
                        'id_parent'=> $id_area12,
                        'breadcrumb'=> $area12['breadcrumb']."|".$id_area12,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Seguimiento, Evaluación y Control de la Gestión',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area123);
                    $area124 = array(
                        'id_parent'=> $id_area12,
                        'breadcrumb'=> $area12['breadcrumb']."|".$id_area12,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Estadística y Análisis de Información de Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area124);
                $area13 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Coordinación General de Gestión Estratégica',
                    'status_row' => ENABLED
                );
                $id_area13= $this->member->save($area13);
                    $area131 = array(
                        'id_parent'=> $id_area13,
                        'breadcrumb'=> $area13['breadcrumb']."|".$id_area13,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Gestión de Procesos',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area131);
                    $area132 = array(
                        'id_parent'=> $id_area13,
                        'breadcrumb'=> $area13['breadcrumb']."|".$id_area13,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Tecnologías de la Información y Comunicaciones',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area132);
                    $area133 = array(
                        'id_parent'=> $id_area13,
                        'breadcrumb'=> $area13['breadcrumb']."|".$id_area13,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Cambio de Cultura Organizacional',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area133);
                $area14 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Coordinación General de Asesoría Jurídica',
                    'status_row' => ENABLED
                );
                $id_area14= $this->member->save($area14);
                    $area141 = array(
                        'id_parent'=> $id_area14,
                        'breadcrumb'=> $area14['breadcrumb']."|".$id_area14,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional Jurídica',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area141);
                    $area142 = array(
                        'id_parent'=> $id_area14,
                        'breadcrumb'=> $area14['breadcrumb']."|".$id_area14,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Consultoría Legal',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area142);
                $area15 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Coordinación General Administrativa Financiera',
                    'status_row' => ENABLED
                );
                $id_area15= $this->member->save($area15);
                    $area151 = array(
                        'id_parent'=> $id_area15,
                        'breadcrumb'=> $area15['breadcrumb']."|".$id_area15,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Talento Humano',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area151);
                    $area152 = array(
                        'id_parent'=> $id_area15,
                        'breadcrumb'=> $area15['breadcrumb']."|".$id_area15,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional Financiera',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area152);
                    $area153 = array(
                        'id_parent'=> $id_area15,
                        'breadcrumb'=> $area15['breadcrumb']."|".$id_area15,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional Administrativa',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area153);
                    $area154 = array(
                        'id_parent'=> $id_area15,
                        'breadcrumb'=> $area15['breadcrumb']."|".$id_area15,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Contratación Pública',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area154);
                    $area155 = array(
                        'id_parent'=> $id_area15,
                        'breadcrumb'=> $area15['breadcrumb']."|".$id_area15,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Secretaría General',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area155);
                $area16 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Dirección Nacional de Cooperación y Relaciones Internacionales',
                    'status_row' => ENABLED
                );
                $this->member->save($area16);
                $area17 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Dirección Nacional de Comunicación, Imagen y prensa',
                    'status_row' => ENABLED
                );
                $this->member->save($area17);
                $area18 = array(
                    'id_parent'=> $id_area1,
                    'breadcrumb'=> $area1['breadcrumb']."|".$id_area1,
                    'type' => AREA,
                    'first_name' => 'Dirección Nacional de Auditoría Interna',
                    'status_row' => ENABLED
                );
		$this->member->save($area18);

            $area2 = array(
                'id_parent'=> $id_organization,
                'breadcrumb'=> $breadcrumb,
                'type' => AREA,
                'first_name' => 'Viceministerio de Gobernanza de la Salud',
                'status_row' => ENABLED
            );
            $id_area2= $this->member->save($area2);
                $area21 = array(
                    'id_parent'=> $id_area2,
                    'breadcrumb'=> $area2['breadcrumb']."|".$id_area2,
                    'type' => AREA,
                    'first_name' => 'Subsecretaría de Gobernanza de la Salud',
                    'status_row' => ENABLED
                );
                $id_area21= $this->member->save($area21);
                    $area211 = array(
                        'id_parent'=> $id_area21,
                        'breadcrumb'=> $area21['breadcrumb']."|".$id_area21,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Políticas y Modelamiento del Sistema Nacional de Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area211);
                    $area212 = array(
                        'id_parent'=> $id_area21,
                        'breadcrumb'=> $area21['breadcrumb']."|".$id_area21,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Articulación de la Red Pública y Complementaria',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area212);
                    $area213 = array(
                        'id_parent'=> $id_area21,
                        'breadcrumb'=> $area21['breadcrumb']."|".$id_area21,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Normalización',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area213);
                    $area214 = array(
                        'id_parent'=> $id_area21,
                        'breadcrumb'=> $area21['breadcrumb']."|".$id_area21,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Normatización del talento humano',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area214);
                    $area215 = array(
                        'id_parent'=> $id_area21,
                        'breadcrumb'=> $area21['breadcrumb']."|".$id_area21,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Medicamentos y Dispositivos Médicos',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area215);
                $area22 = array(
                    'id_parent'=> $id_area2,
                    'breadcrumb'=> $area2['breadcrumb']."|".$id_area2,
                    'type' => AREA,
                    'first_name' => 'Subsecretaría Nacional de Vigilancia de la Salud Pública',
                    'status_row' => ENABLED
                );
                $id_area22= $this->member->save($area22);
                    $area221 = array(
                        'id_parent'=> $id_area22,
                        'breadcrumb'=> $area22['breadcrumb']."|".$id_area22,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Vigilancia Epidemiológica',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area221);
                    $area222 = array(
                        'id_parent'=> $id_area22,
                        'breadcrumb'=> $area22['breadcrumb']."|".$id_area22,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Control Sanitario',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area222);
                    $area223 = array(
                        'id_parent'=> $id_area22,
                        'breadcrumb'=> $area22['breadcrumb']."|".$id_area22,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Estrategias de Prevención y Control',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area223);
					$area224 = array(
                        'id_parent'=> $id_area22,
                        'breadcrumb'=> $area22['breadcrumb']."|".$id_area22,
                        'type' => AREA,
                        'first_name' => 'Dirección General de la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area224);
				$area23 = array(
                    'id_parent'=> $id_area2,
                    'breadcrumb'=> $area2['breadcrumb']."|".$id_area2,
                    'type' => AREA,
                    'first_name' => 'Subsecretaría Nacional de Promoción de la Salud e Igualdad',
                    'status_row' => ENABLED
                );
                $id_area23= $this->member->save($area23);
                    $area231 = array(
                        'id_parent'=> $id_area23,
                        'breadcrumb'=> $area23['breadcrumb']."|".$id_area23,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Promoción de la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area231);
                    $area232 = array(
                        'id_parent'=> $id_area23,
                        'breadcrumb'=> $area23['breadcrumb']."|".$id_area23,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Derechos Humanos, generos e Inclusión',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area232);
                    $area233 = array(
                        'id_parent'=> $id_area23,
                        'breadcrumb'=> $area23['breadcrumb']."|".$id_area23,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Salud Intercultural',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area233);
					$area234 = array(
                        'id_parent'=> $id_area23,
                        'breadcrumb'=> $area23['breadcrumb']."|".$id_area23,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Ambiente y Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area234);
					$area235 = array(
                        'id_parent'=> $id_area23,
                        'breadcrumb'=> $area23['breadcrumb']."|".$id_area23,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Participación Social en la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area235);

            /*******/
            $area3 = array(
                'id_parent'=> $id_organization,
                'breadcrumb'=> $breadcrumb,
                'type' => AREA,
                'first_name' => 'Viceministerio de Atención Integral de la Salud',
                'status_row' => ENABLED
            );
            $id_area3= $this->member->save($area3);
                $area31 = array(
                    'id_parent'=> $id_area3,
                    'breadcrumb'=> $area3['breadcrumb']."|".$id_area3,
                    'type' => AREA,
                    'first_name' => 'Subsecretaría Nacional de Provisión de Servicios de la Salud',
                    'status_row' => ENABLED
                );
                $id_area31= $this->member->save($area31);
                    $area311 = array(
                        'id_parent'=> $id_area31,
                        'breadcrumb'=> $area31['breadcrumb']."|".$id_area31,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Centros Especializados',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area311);
                    $area312 = array(
                        'id_parent'=> $id_area31,
                        'breadcrumb'=> $area31['breadcrumb']."|".$id_area31,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Hospitales',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area312);
                    $area313 = array(
                        'id_parent'=> $id_area31,
                        'breadcrumb'=> $area31['breadcrumb']."|".$id_area31,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Primer Nivel de Atención en Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area313);
                    $area314 = array(
                        'id_parent'=> $id_area31,
                        'breadcrumb'=> $area31['breadcrumb']."|".$id_area31,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Discapacidades',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area314);
                    $area315 = array(
                        'id_parent'=> $id_area31,
                        'breadcrumb'=> $area31['breadcrumb']."|".$id_area31,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Atención Pre-Hospitalaria y Unidades Móviles',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area315);
                $area32 = array(
                    'id_parent'=> $id_area3,
                    'breadcrumb'=> $area3['breadcrumb']."|".$id_area3,
                    'type' => AREA,
                    'first_name' => 'Subsecretaría Nacional de Garantía de la Calidad de los Servicios de la Salud',
                    'status_row' => ENABLED
                );
                $id_area32= $this->member->save($area32);
                    $area321 = array(
                        'id_parent'=> $id_area32,
                        'breadcrumb'=> $area32['breadcrumb']."|".$id_area32,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Calidad de los Servicios de la Salud',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area321);
                    $area322 = array(
                        'id_parent'=> $id_area32,
                        'breadcrumb'=> $area32['breadcrumb']."|".$id_area32,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Infraestructura Sanitaria',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area322);
                    $area323 = array(
                        'id_parent'=> $id_area32,
                        'breadcrumb'=> $area32['breadcrumb']."|".$id_area32,
                        'type' => AREA,
                        'first_name' => 'Dirección Nacional de Equipamiento Sanitario',
                        'status_row' => ENABLED
                    );
                    $this->member->save($area323);

            echo PHP_EOL;

            return $id_organization;
        }

        private function _seed_organigrama_perfiles($id_organization){
            echo "seeding profiles from organizations";
            //history
            foreach ($this->member->find_all(AREA)->result() as $area) {
                $random= rand(3,20);
                for($k=0; $k<=$random; $k++){
                    $profile = array(
                        'id_parent'=> $area->id,
                        'breadcrumb'=> $area->breadcrumb."|".$area->id,
                        'username' => $this->faker->unique()->userName, // get a unique nickname
                        'password' => md5("demo"),
                        'first_name' => $this->faker->firstName,
                        'last_name' => $this->faker->lastName,
                        'email' => $this->faker->unique()->email,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                    );
                    $id_profile= $this->member->save($profile);

                    //logs
                    $random= rand(1,10);
                    for($j=0; $j<=$random; $j++){
                        $data = array(
                            'id_entity' => $id_profile,
                            'ip_address' => $this->faker->ipv4,
                            'browser' => $this->faker->userAgent,
                        );

                        $this->access->save($data);
                    }

                    //address
                    if(rand(1,0)){
                        $data = array(
                            'id_entity' => $id_profile,
                            'type' => 'HOME',
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

                        $id_contact= $this->contact->save($data);
                        $this->member->update(array("id"=>$id_profile,'id_contact'=>$id_contact));
                    }
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
                'slug' => 'publico',
            );

            $id_cat_publico= $this->category->save($data);

            $data = array(
                'id_parent' => NULL,
                'breadcrumb' => NULL,
                'name' => 'OTROS',
                'slug' => 'otros',
            );

            $id_cat_otros= $this->category->save($data);


            //categorias publicas hijas
            {
                $data = array(
                    'id_parent' => $id_cat_publico,
                    'breadcrumb' => $id_cat_publico,
                    'name' => 'ESTADO CENTRAL',
                    'slug' => 'estado-central',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $insert_id= $this->category->save($data);
                $breadcrumb= $id_cat_publico."|".$insert_id;
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION EJECUTIVA',
                        'slug' => 'funcion-ejecutiva',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $insert_id_x= $this->category->save($data);
                    $breadcrumb_x= $breadcrumb."|".$insert_id_x;
                        $data = array(
                            'id_parent' => $insert_id_x,
                            'breadcrumb' => $breadcrumb_x,
                            'name' => 'MINISTERIOS',
                            'slug' => 'ministerios',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);
                        $data = array(
                            'id_parent' => $insert_id_x,
                            'breadcrumb' => $breadcrumb_x,
                            'name' => 'MINISTERIO COORDINADOR',
                            'slug' => 'ministerio-coordinador',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);

                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION LEGISLATIVA',
                        'slug' => 'funcion-legislativa',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION JUDICIAL',
                        'slug' => 'funcion-judicial',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION ELECTORAL',
                        'slug' => 'funcion-electoral',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'FUNCION DE TRANSPARECIA Y CONTROL SOCIAL',
                        'slug' => 'funcion-de-transparencia-y-control-social',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'OTROS',
                        'slug' => 'otros-2',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $insert_id= $this->category->save($data);
                    $breadcrumb= $breadcrumb."|".$insert_id;
                        $data = array(
                            'id_parent' => $insert_id,
                            'breadcrumb' => $breadcrumb,
                            'name' => 'CUERPOS COLEGIADOS',
                            'slug' => 'cuerpos-colegiados',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);
                        $data = array(
                            'id_parent' => $insert_id,
                            'breadcrumb' => $breadcrumb,
                            'name' => 'EMPRESAS PUBLICAS',
                            'slug' => 'empresas-publicas',
                            'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                        );
                        $this->category->save($data);


                $data = array(
                    'id_parent' => $id_cat_publico,
                    'breadcrumb' => $id_cat_publico,
                    'name' => 'GADS',
                    'slug' => 'gads',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $insert_id= $this->category->save($data);
                $breadcrumb= $id_cat_publico."|".$insert_id;
                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'PERFECTURAS',
                        'slug' => 'perfecturas',
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );
                    $this->category->save($data);

                    $data = array(
                        'id_parent' => $insert_id,
                        'breadcrumb' => $breadcrumb,
                        'name' => 'ALCALDIAS',
                        'slug' => 'alcaldias',
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
                    'slug' => 'embajadas-y-consulados',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'FUNDACIONES',
                    'slug' => 'fundaciones',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'MEDIOS DE COMUNICACION',
                    'slug' => 'medios-de-comunicacion',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'ACADEMIA',
                    'slug' => 'academia',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);

                $data = array(
                    'id_parent' => $id_cat_otros,
                    'breadcrumb' => $id_cat_otros,
                    'name' => 'ORGANISMOS INTERNACIONALES',
                    'slug' => 'organismos-internacionales',
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );
                $this->category->save($data);
            }


            echo PHP_EOL;
        }

        private function _seed_organigrama_categories($id_organization){
            echo "seeding organizations - categories";
            $ids= array(5,6,7,8,9,10,12,13,17,18,19,20,21);

            foreach ($ids as $id_cat) {
                $data = array(
                    'id_entity' => $id_organization,
                    'id_category' => $id_cat,
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );

                $this->entity_category->save($data);
            }
            echo PHP_EOL;
        }

        private function _seed_news(){
            echo "seeding news";
            $superadmin= $this->member->find_all(SUPERADMIN)->row();
            //history
            for($k=0; $k<=20; $k++){
                $title= trim($this->faker->realText(rand(10,20)));
                $post = array(
                    'id_entity' => $superadmin->id,
                    'content' => $this->faker->realText(rand(200,600)),
                    'title' => $title,
                    'status' => (rand(0, 1) ? PUBLISHED : UNPUBLISHED),
                    'comment_status' => (rand(0, 1) ? ENABLED : DISABLED),
                    'title' => $title,
                    'slug' => $this->faker->slug,
                    'comment_count' => rand(0, 50),
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                );

                $this->post->save($post);
            }

            echo PHP_EOL;
        }

        private function _truncate_db(){

            foreach ($this->db->list_tables() as $table) {
                $this->db->truncate($table);
            }

        }

}