<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Media extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('DataModel');
       
        // $this->methods['komentar_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['komentar_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['komentar_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function komentar_get()
    {
        $id = $this->get('id');
        if ($id === NULL)
        {
            $data = $this->DataModel->getData('komentar');
            $this->set_response([
                'status' => TRUE,
                'success' => TRUE,
                'data' => $data->result(),
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_OK); 
    
        }else {
            $data = $this->DataModel->getWhere('id_komentar',$id);
            $data = $this->DataModel->getData('komentar');
            
            $this->set_response([
                'status' => TRUE,
                'success' => TRUE,
                'data' => $data->result(),
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_OK); 
    
        }
    }

    public function komentar_post()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->insert('komentar',$jsonArray);
     
            $this->set_response([
                'status' => TRUE,
                'success' => $simpan,
                'data' => $simpan,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_OK); 
      
    }
    public function komentar_put()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->update('id_komentar',$jsonArray['id_komentar'],'komentar',$jsonArray);
     
            $this->set_response([
                'status' => TRUE,
                'success' => $simpan,
                'data' => $jsonArray,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_OK); 
      
    }

    public function komentar_delete()
    {
        $id =  $this->delete('id');
        $hapus = $this->DataModel->delete('id_komentar', $id,'komentar');

            $this->set_response([
                'status' => TRUE,
                'success' => $hapus,
                'data' => $id,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_OK); 
        

        
    }

}
