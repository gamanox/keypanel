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
     * show
     *
     * Carga la vista html del perfil
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @param int $id_organization Id del organigrama
     * @return void
     */
    public function show($id_organization){

        $organization= $this->organization->find($id_organization);

        if(!isset($organization->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('org_show');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower($this->session->type));

        $param['organization']= $organization;
        $this->load->view("organization/show", $param);

        $this->load->view('includes/footer');

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
        if( isset($info_categoria)){
            $param_view['categoria']      = $info_categoria;
            $this->load->view('panel/categories', $param_view);
        }
        else {
            // No se encontro la categoria, mandar vista de error
        }

        $this->load->view('includes/footer');
    }

    /**
     * getTreeJSON
     * Esta funcion arma el json requerido para la vista de boxes de las categorias
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
        //JSON_UNESCAPED_UNICODE = 256 constante definida en php > 5.4
        $json = json_encode($response, 256);

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
     * nivel
     * Esta funcion manda a la vista del finder
     *
     * @access public
     * @param int $id Id del organigrama
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return [type] [description]
     */
    public function nivel( $id = NULL ){
        if( !isset($id) ){
            redirect('panel');
        }

        $param_header['title'] = 'KeyPanel';
        $this->load->view('includes/header', $param_header);

        $param_menu['breadcrumb'] = array();
        $this->load->view('includes/menu-extended-'. strtolower($this->session->type));

        $info_organigrama = $this->organization->find( $id );
        if( isset($info_organigrama) ){
            $param_view['organigrama'] = $info_organigrama;
            $this->load->view('panel/finder', $param_view);
        }
        else {

        }

        $this->load->view('includes/footer');
    }

    /**
     * find_nodes
     * Esta funcion se encarga de armar el json requerido para la vista del finder
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
            //JSON_UNESCAPED_UNICODE = 256 constante definida en php > 5.4
            $json = json_encode($navigation, 256);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
        else {
            show_404();
        }
    }

    /**
     * getTREE
     * Funcion recursiva para armar el arbol de un organigrama
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
                            'label' => $node->name .($node->type == PROFILE ? ' '. $node->last_name : ''),
                            'type'  => ($node->type == AREA ? 'folder' : 'link')
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