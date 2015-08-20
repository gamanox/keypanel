<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para funciones relacionadas al Controlador name
 */

class Blog extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model','post');
        $this->load->model('Comment_model','comments');
        $this->load->model('Entity_model','entity');
    }

    /**
     * [index description]
     * @return posts view
     */
    public function index(){
        if(!$this->permiso->is_auth('P-posts', R)){
            redirect("errores/no_authorized");
        }

        if ( $this->session->type == 'superadmin' ){
            redirect('dashboard');
        }

        $param_header['the_title'] = lang('menu_foro');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu_'. $this->session->type);
        $footer_scripts = array('datatables/jquery.dataTables.js','number/jquery.counterup.min.js','circle-progress/jquery.circliful.js');

        $param['breadcrumb'] = array(
                lang('menu_dashboard') => base_url(),
                lang('menu_foro')      => '',
            );

        $info_entity = $this->entity->find_me();
        $colonia_cve  = $info_entity->colonia_cve;

        $param['total_posts'] = $this->post->find_by_neighborhood( $colonia_cve );
        $param['posts']       = $this->post->find_by_neighborhood( $colonia_cve );

        $this->load->view('blog/posts', $param);

        $param_footer['scripts'] = $footer_scripts;
        $this->load->view('includes/footer', $param_footer);
    }

    /**
     * [single]
     * @param  int $ID
     * @return single view
     */
    public function article($ID){
        if(!$this->permiso->is_auth('P-posts', R)){
            redirect("errores/no_authorized");
        }

        if ( $this->session->type == 'superadmin' ){
            redirect('dashboard');
        }

        $info_entity = $this->entity->find_me();
        $colonia_cve  = $info_entity->colonia_cve;
        $post         = $this->post->find( $ID );

        if( count($post) > 0 ){
            // Validamos si pertenece a la misma colonia
            if( $post->cve_colonia != $colonia_cve ){
                redirect('blog');
            }

            $param_header['the_title'] = lang('menu_foro');
            $this->load->view('includes/header', $param_header);

            $this->load->view('includes/menu_'. $this->session->type);
            $footer_scripts = array(
                    'datatables/jquery.dataTables.js','number/jquery.counterup.min.js','circle-progress/jquery.circliful.js',
                    'footable/js/footable.js?v=2-0-1','footable/js/footable.sort.js?v=2-0-1','footable/js/footable.filter.js?v=2-0-1',
                    'footable/js/footable.paginate.js?v=2-0-1','footable/js/footable.paginate.js?v=2-0-1'
                );

            $param['breadcrumb'] = array(
                    lang('menu_dashboard') => base_url(),
                    lang('menu_foro')      => base_url('blog'),
                );

            $param['post']     = $post;
            $param['comments'] = $this->comments->find_by_post_id( $ID );

            $this->load->view('blog/single', $param);

            $param_footer['scripts'] = $footer_scripts;
            $this->load->view('includes/footer', $param_footer);
        }
        else {
            redirect('dashboard');
        }
    }
}