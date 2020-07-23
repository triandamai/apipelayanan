<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Komentar extends REST_Controller {

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
            $data = $this->DataModel->select('*');
            $data = $this->DataModel->getJoin('laporan','laporan.id_laporan = komentar.id_laporan','INNER');
            $data = $this->DataModel->getJoin('user','user.id_user = laporan.created_by','INNER');
            $data = $this->DataModel->order_by("komentar.created_at","ASC");
            $data = $this->DataModel->getData('komentar');
            if($data && $data->num_rows() >= 1){
                return $this->response(array(
                    "status"                => true,
                    "response_code"         => REST_Controller::HTTP_OK,
                    "response_message"      => "Berhasil",
                    "data"                  => $data->result(),
                ), REST_Controller::HTTP_OK);
            }else{
                return $this->response(array(
                    "status"                => true,
                    "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                    "response_message"      => "Gagal Mendapatkan Data",
                    "data"                  => null,
                ), REST_Controller::HTTP_OK);
            }
    
        }else {
            $data = $this->DataModel->select('*');
            $data = $this->DataModel->getJoin('laporan','laporan.id_laporan = komentar.id_laporan','INNER');
            $data = $this->DataModel->getJoin('user','user.id_user = laporan.created_by','INNER');
            $data = $this->DataModel->order_by("komentar.created_at","ASC");
            $data = $this->DataModel->getWhere('laporan.id_laporan',$id);
            $data = $this->DataModel->getData('komentar');
            
            if($data && $data->num_rows() >= 1){
                return $this->response(array(
                    "status"                => true,
                    "response_code"         => REST_Controller::HTTP_OK,
                    "response_message"      => "Berhasil",
                    "data"                  => $data->result(),
                ), REST_Controller::HTTP_OK);
            }else{
                return $this->response(array(
                    "status"                => true,
                    "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                    "response_message"      => "Gagal Mendapatkan Data",
                    "data"                  => null,
                ), REST_Controller::HTTP_OK);
            }
    
        }
    }

    public function komentar_post()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->insert('komentar',$jsonArray);
        if($simpan){
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_OK,
                "response_message"      => "Berhasil",
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        }else{
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                "response_message"      => "Gagal : ". db_error(),
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        }  
      
    }
    public function komentar_put()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->update('id_komentar',$jsonArray['id_komentar'],'komentar',$jsonArray);
        if($simpan){
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_OK,
                "response_message"      => "Berhasil",
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        }else{
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                "response_message"      => "Gagal : ". db_error(),
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        } 
      
    }

    public function komentar_delete()
    {
        $id =  $this->delete('id');
        $hapus = $this->DataModel->delete('id_komentar', $id,'komentar');
        if($hapus){
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_OK,
                "response_message"      => "Berhasil",
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        }else{
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                "response_message"      => "Gagal : ". db_error(),
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
        } 
        

        
    }

}
