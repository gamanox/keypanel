<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para funciones relacionadas al Controlador name
 */

class Post extends CI_Controller {

    //Constructor del Controlador
    function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model','post');
        $this->load->model('Usuario_model','entity');
        $this->load->model('Comment_model','comments');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index(){
        redirect('blog');
    }

    /**
     * [create_post]
     * @return json
     */
    public function create(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $info_entity = $this->entity->find_me();
            $colonia_cve  = $info_entity->colonia_cve;

            $the_post                 = $this->input->post('post');
            $the_post['post_content'] = $this->input->post('post_content');
            $the_post['post_date']    = date('Y-m-d H:i:s');
            $the_post['cve_colonia']  = $colonia_cve;
            $the_post['cve_user']     = $this->session->cve;

            if( $this->session->type == NORMAL ){
                $the_post['post_status'] = 'draft';
            }

            $succedd = $this->post->save($the_post);
            if( $succedd ){
                $data['status'] = true;
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * [delete]
     * @return json
     */
    public function delete(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $cve_post     = $this->input->post('cve_post');
            $info_post    = $this->post->find( $cve_post );
            $info_entity = $this->entity->find_me();

            if( count($info_post) > 0 and ( $info_post->cve_user == $info_entity->cve or in_array($this->session->type, array(ADMIN, VOCAL))) ){
                $succedd = $this->post->delete( $cve_post );
                if( $succedd ){
                    $data['status'] = true;
                }
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * [publish]
     * @return json
     */
    public function publish(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $cve_post     = $this->input->post('cve_post');
            $info_post    = $this->post->find( $cve_post );
            $info_entity = $this->entity->find_me();

            if( count($info_post) > 0 and $info_post->cve_colonia == $info_entity->colonia_cve ){
                $update_post = array('ID' => $cve_post, 'post_status' => 'publish');
                $succedd = $this->post->update( $update_post );
                if( $succedd ){
                    $data['status'] = true;
                }
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * [comment]
     * @return void
     */
    public function comment(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $the_post = $this->input->post('post');

            $info_post    = $this->post->find( $the_post['ID'] );
            $info_entity = $this->entity->find_me();

            if( count($info_post) > 0 and $info_post->cve_colonia == $info_entity->colonia_cve ){
                $comment = array(
                        'id_post'   => $the_post['ID'],
                        'cve_user'  => $this->session->cve,
                        'content'   => $this->input->post('post_content'),
                        'approved'  => 1,
                        'create_at' => date('Y-m-d H:i:s')
                    );

                $succedd = $this->comments->save($comment);
                if( $succedd ){
                    $data['status'] = true;

                    $post_update = array(
                            'ID'            => $info_post->ID,
                            'comment_count' => $info_post->comment_count + 1
                        );

                    $this->post->update($post_update);
                }
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }
}