<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Base extends CI_Controller {

    /**
     * __construct
     * @ignore
     * @copyright KeyPanel - 2015
     *
     */
    function __construct()
    {
        parent::__construct();

        if( $this->session->type != SUPERADMIN ){
            show_404();
        }
    }

     public function upload_profile() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            if($_FILES){
                /* Subimos el archivo */
                $config['upload_path'] = './assets/images/profiles';
                $config['allowed_types'] = 'jpeg|jpg';
                $config['file_name']= time();

                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('file')){
                    //$this->lang->load('upload');
                    $response['msg']= $this->upload->display_errors('<p>','</p>');
                }else{
                    $response['status']=true;
                    $response['msg']=lang('msg_operacion_exitosa');
                    $response['file_name']=$config['file_name'].$this->upload->file_ext;
                }
            }

//            print_r_pre_d($_FILES);
	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    public function remove_profile() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            $file= $this->input->post('file');
            $id_entity= $this->input->post('id_entity');
            $path_to_file= './assets/images/profiles/'.$file;
            if(file_exists($path_to_file)){
                if(unlink($path_to_file)){

                    if($id_entity){
                        $this->entity->update(array("id"=>$id_entity,"avatar"=>null));
                    }

                    $response['status']=true;
                    $response['file_name']= $file;
                    $response['msg']= lang('msg_operacion_exitosa');
                }
            }

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    public function upload_attach() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            if($_FILES){
                /* Subimos el archivo */
                $config['upload_path'] = './assets/images/attachment';
                $config['allowed_types'] = '*';
                $config['file_name']= time();

                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('attach')){
                    //$this->lang->load('upload');
                    $response['msg']= $this->upload->display_errors('<p>','</p>');
                }else{
                    $response['status']=true;
                    $response['msg']=lang('msg_operacion_exitosa');
                    $response['file_name']=$config['file_name'].$this->upload->file_ext;
                }
            }

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    public function remove_attach() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            $file= $this->input->post('file');
            $id_contact= $this->input->post('id_contact');
            $path_to_file= './assets/images/attachment/'.$file;
            if(file_exists($path_to_file)){
                if(unlink($path_to_file)){

                    if($id_contact){
                        $this->contact->update(array("id"=>$id_contact,"attachment"=>null));
                    }

                    $response['status']=true;
                    $response['file_name']= $file;
                    $response['msg']= lang('msg_operacion_exitosa');
                }
            }

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }
}
/* End of file Base.php */
/* Location: ./application/controllers/admin/Base.php */