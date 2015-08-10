<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
class Organigrama extends CI_Controller {

    /**
     * __construct
     *
     * @ignore
     * @copyright KeyPanel - 2015
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Organization_model','organization');
        $this->load->model('Category_model','category');
    }

    /**
     * index
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return void
     */
    public function index(){
        redirect('panel');
    }

    /**
     * explorar
     *
     * Esta función carga todas las sub-categorias de una categoria dada
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return void
     */
    public function explorar( $slug = NULL ){
        if( !isset($slug) ){
            redirect('panel');
        }

        $param_header['title'] = 'KeyPanel';
        $this->load->view('includes/header', $param_header);

        $param_menu['breadcrumb'] = array();
        $this->load->view('includes/menu-extended-'. strtolower($this->session->type));

        // Buscamos la categoria enviada
        $info_categoria = $this->category->find_by_slug( $slug );
        if( isset($info_categoria) ){
            $param_view['categoria']      = $info_categoria;
            $param_view['organizations']  = $this->entity_category->find_entities_by_category( $info_categoria->id );
            $param_view['sub_categorias'] = $this->category->find_children( $info_categoria->id );
            $this->load->view('panel/categories', $param_view);
        }
        else {
            // No se encontro la categoria, mandar vista de error
        }

        $this->load->view('includes/footer');
    }
}
/* End of file Organigrama.php */
/* Location: ./application/controllers/Organigrama.php */