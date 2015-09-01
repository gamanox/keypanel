<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
class Faq extends CI_Controller {

    /**
     * [__construct]
     * @ignore
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Faq_model','faq');
    }

    /**
     * index
     * Muestra el listado de los faqs creados
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function index(){
        $this->show_list();
    }

    /**
     * [function_name description]
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return [type] [description]
     */
    public function show_list(){
        if( !$this->auth->is_auth($this->router->class, READ) ){
            redirect('account');
        }

        $param_header['title'] = lang('help-title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN));

        // Cargamos la lista de miembros
        $param['faqs'] = $this->faq->find_all();
        $this->load->view('faq/list', $param);

        $this->load->view('includes/footer');
    }

    /**
     * add
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function add(){
        if( !$this->auth->is_auth( $this->router->class, CREATE) ){
            redirect("errores/no_authorized");
        }

        if( $_POST ){
            echo '<pre>'. print_r($_POST, true) .'</pre>';
        }

        $this->load->library('form_validation');
        $param_view = array();
        $errors     = array();

        $param_header['title'] = lang('faq_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/member");
        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $this->load->view('faq/new', $param_view);

        $this->load->view('includes/footer');
    }
}
/* End of file Faq.php */
/* Location: ./application/controllers/admin/Faq.php */