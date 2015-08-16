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
            // $param_view['organizations']  = $this->entity_category->find_entities_by_category( $info_categoria->id );
            // $param_view['sub_categorias'] = $this->category->find_children( $info_categoria->id );
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
        $this->output->enable_profiler(FALSE);
        $response = array();

        $id_category    = $this->input->get_post('id_category');
        $info_categoria = $this->category->find($id_category);
        if( isset($info_categoria) and count($info_categoria) > 0 ){
            $children = $this->category->find_children_json($info_categoria->id);
            $response = array(
                    'name'     => $info_categoria->name,
                    'children' => $children
                );
        }

        // echo '<pre>'. print_r($response, true) .'</pre>';
        // die();

        //Regresamos el status del evento
        $json = json_encode($response, JSON_UNESCAPED_UNICODE);

        @ob_end_clean();
        header('Content-Type: "application/json"');
        header('Content-Disposition: attachment; filename="data.json"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: ". strlen($json));
        exit($json);
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
        if( !isset($slug) ){
            redirect('panel');
        }

        $param_header['title'] = 'KeyPanel';
        $this->load->view('includes/header', $param_header);

        $param_menu['breadcrumb'] = array();
        $this->load->view('includes/menu-extended-'. strtolower($this->session->type));

        $info_organigrama = $this->organization->find( $slug );
        if( isset($info_organigrama) ){
            $param_view['organigrama'] = $info_organigrama;
            $this->load->view('panel/finder', $param_view);
        }
        else {

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
    public function find_nodes( ){
        if( $this->input->is_ajax_request() ){
            $id_organigrama = $this->input->get_post('id_organigrama');
            $entidades      = $this->organization->find_children( $id_organigrama );

            $response = array();
            if( $entidades->num_rows() > 0){
                $navigation = array();
                foreach ($entidades->result() as $entidad) {
                    $navigation[0][] = (Object) array('id' => $entidad->id, 'label' => $entidad->first_name, 'type' => "folder");
                }

                $navigation = $this->getTREE( $navigation );
            }

            // echo '<pre>'. print_r($navigation, true) .'</pre>';

            //Regresamos el status del evento
            $json = json_encode($navigation, JSON_UNESCAPED_UNICODE);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
        else {
            show_404();
        }
    }

    /**
     * getTREE
     *
     * @access private
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return [type] [description]
     */
    private function getTREE( $navigation, $parent = 0 ){
        foreach ($navigation[$parent] as $entidad) {
            // Buscamos si tiene hijos
            $children = $this->organization->find_children($entidad->id);
            if( $children->num_rows() > 0 ){
                foreach ($children->result() as $node) {
                    $navigation[$entidad->id][] = (Object) array(
                            'id'    => $node->id,
                            'label' => $node->name,
                            'type'  => ($node->type == AREA ? 'folder' : 'direct_link')
                        );
                }

                $children = $this->organization->find_children($entidad->id);
                if( $children->num_rows() > 0 ){
                    $navigation = $this->getTREE( $navigation, $entidad->id );
                }
            }
        }

        return $navigation;
    }
}
/* End of file Organigrama.php */
/* Location: ./application/controllers/Organigrama.php */