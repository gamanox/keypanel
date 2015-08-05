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
    }

    /**
     * index
     *
     * Esta función carga todas las categorias de organigramas publicos y/o privados
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return void
     */
    public function index(){

    }

    /**
     * explorar
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return void
     */
    public function explorar( $slug = NULL ){
        echo $slug;
    }
}
/* End of file Organigrama.php */
/* Location: ./application/controllers/Organigrama.php */