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

    /**
     * [function_name description]
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return [type] [description]
     */
    public function getTreeJSON(){
        if( $this->input->is_ajax_request() ){
            $response = array();

            $id_category    = $this->input->get_post('id_category');
            $info_categoria = $this->category->find($id_category);
            if( isset($info_categoria) and count($info_categoria) > 0 ){
                $response = array('name' => $info_categoria->name, 'children' => $this->category->find_children_json($info_categoria->id) );
            }

            //Regresamos el status del evento
            $json = json_encode($response, JSON_UNESCAPED_UNICODE);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
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
    public function nivel( $slug = NULL ){

    }
}
/* End of file Organigrama.php */
/* Location: ./application/controllers/Organigrama.php */