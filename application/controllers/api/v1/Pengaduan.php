<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Pengaduan extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('DataModel');
       
        // $this->methods['laporan_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['laporan_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['laporan_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function laporan_get()
    {
        $id = $this->get('id');
        if ($id === NULL)
        {
            
            $data = $this->DataModel->getJoin('user','user.id_user = laporan.created_by','INNER');
            $data = $this->DataModel->order_by("laporan.created_at","ASC");
            $data = $this->DataModel->getData('laporan');
            

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
            
            
            $data = $this->DataModel->getJoin('user','user.id_user = laporan.created_by','INNER');
            $data = $this->DataModel->getWhere('laporan.id_laporan',$id);
            $data = $this->DataModel->order_by("laporan.created_at","ASC");
            $data = $this->DataModel->getData('laporan');
            
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

    public function laporan_post()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $bukti = "";
        if(!empty($jsonArray['media_laporan'])){
            $date = new DateTime();

            $image = base64_decode($jsonArray['media_laporan']);
            $bukti = $date->getTimestamp().".jpg";
            file_put_contents("assets/pengaduan/$bukti",$image);
        }

        $data = array(
            "id_laporan" => uniqid(),
            "created_by" => $jsonArray['created_by'],
            "judul" => $jsonArray['judul'],
            "body" => $jsonArray['body'],
            "media_laporan" => $bukti,
            "status_laporan" => $jsonArray['status_laporan'],
            "created_at" => $jsonArray['created_at'],
            "updated_at"=> $jsonArray['updated_at']
        );
        $simpan = $this->DataModel->insert('laporan',$data);
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
    public function laporan_put()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $bukti = "";
        if(!empty($jsonArray->image)){
            $image = base64_decode($jsonArray['media']);
            $bukti = now().".jpg";
            file_put_contents("assets/pengaduan/$bukti",$image);
            $data = array(
                "created_by" => $jsonArray['created_by'],
                "judul" => $jsonArray['judul'],
                "body" => $jsonArray['body'],
                "media_laporan" => $bukti,
                "status_laporan" => $jsonArray['status_laporan'],
                "created_at" => $jsonArray['created_at'],
                "updated_at"=> $jsonArray['updated_at']
            );
            $simpan = $this->DataModel->update('id_laporan',$jsonArray['id_laporan'],'laporan',$data);
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
        }else{
        $data = array(
            "id_laporan" =>"UUID()",
            "created_by" => $jsonArray->creatd_by,
            "judul" => $jsonArray->judul,
            "deskripsi"=> $jsonArray->deskripsi,
            "body" => $jsonArray->body,
            "media_laporan" => $bukti,
            "status_laporan" => "tersedia",
            "created_at" => $jsonArray->created_at,
            "updated_at"=> $jsonArray->updated_at
        );
        $simpan = $this->DataModel->update('id_laporan',$jsonArray['id_laporan'],'laporan',$data);
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
    }

    public function laporan_delete()
    {
        $id =  $this->delete('id');
        $hapus = $this->DataModel->delete('id_laporan', $id,'laporan');
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
