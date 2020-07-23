<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('DataModel');
       
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function login_post(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $login =  $this->DataModel->get_whereArr('user',$jsonArray);
        if($login){
            if($login->num_rows() >=1){
                if($login->row()->password === $jsonArray['password']){
                    return $this->response(array(
                        "status"                => true,
                        "response_code"         => REST_Controller::HTTP_OK,
                        "response_message"      => "Login Berhasil",
                        "data"                  => $login->row()
                    ), REST_Controller::HTTP_OK);
            
                }else{
                    return $this->response(array(
                        "status"                => true,
                        "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                        "response_message"      => "User Tidak Ditemukan!",
                        "data"                  => null
                    ), REST_Controller::HTTP_OK);
            
                }
    
            }else{
                return $this->response(array(
                    "status"                => true,
                    "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                    "response_message"      => "User Tidak Ditemukan!",
                    "data"                  => null
                ), REST_Controller::HTTP_OK);
    
            }
        }else{
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                "response_message"      => "User Tidak Ditemukan!",
                "data"                  => null
            ), REST_Controller::HTTP_OK);
        }
    }
    public function users_get()
    {
        $id = $this->get('id');
        if ($id === NULL)
        {
            $data = $this->DataModel->getData('user');
            if($data && $data->num_rows() >= 1){
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_OK,
                "response_message"      => "Login Berhasil",
                "data"                  => $data->result(),
            ), REST_Controller::HTTP_OK);
            }else{
            return $this->response(array(
                "status"                => true,
                "response_code"         => REST_Controller::HTTP_EXPECTATION_FAILED,
                "response_message"      => "Gagal Mendapatkan data",
                "data"                  => null,
            ), REST_Controller::HTTP_OK);
            }
    
        }else {
            $data = $this->DataModel->getWhere('id_user',$id);
            $data = $this->DataModel->getData('user');
            
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

    public function users_post()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $bukti = "";
        $date = new DateTime();
        if(!empty($jsonArray['media_user'])){
            

            $image = base64_decode($jsonArray['media_user']);
            $bukti = $date->getTimestamp().".jpg";
            file_put_contents("assets/pengaduan/$bukti",$image);
        }
        $data = array(
            "id_user"=> $date->getTimestamp(),
            "nama"=> $jsonArray['nama'],
            "alamat"=> $jsonArray['alamat'],
            "tempat_lahir"=> $jsonArray['tempat_lahir'],
            "tanggal_lahir"=> $jsonArray['tanggal_lahir'],
            "username" => $jsonArray['username'],
            "password" => $jsonArray['nik'],
            "nik" => $jsonArray['nik'],
            "level"=> $jsonArray['level'],
            "status_user"=> $jsonArray['status_user'],
            "media_user" => $bukti,
            "created_at"=> $jsonArray['created_at'],
            "updated_at" => $jsonArray['updated_at']);

        $simpan = $this->DataModel->insert('user',$data);
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
    public function users_put()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $bukti = "";
        if(!empty($jsonArray['media_user'])){
            $date = new DateTime();

            $image = base64_decode($jsonArray['media_user']);
            $bukti = $date->getTimestamp().".jpg";
            file_put_contents("assets/pengaduan/$bukti",$image);
            $data = array(
                "id_user"=>uniqid(),
                "nama"=> $jsonArray['nama'],
                "alamat"=> $jsonArray['alamat'],
                "tempat_lahir"=> $jsonArray['tempat_lahir'],
                "tanggal_lahir"=> $jsonArray['tanggal_lahir'],
                "password" => $jsonArray['nik'],
                "nik" => $jsonArray['nik'],
                "level"=> $jsonArray['level'],
                "status_user"=> $jsonArray['status'],
                "media_user" => $bukti,
                "created_at"=> $jsonArray['created_at'],
                "üpdated_at" => $jsonArray['updated_at']);
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
                "nama"=> $jsonArray['nama'],
                "alamat"=> $jsonArray['alamat'],
                "tempat_lahir"=> $jsonArray['tempat_lahir'],
                "tanggal_lahir"=> $jsonArray['tanggal_lahir'],
                "password" => $jsonArray['nik'],
                "nik" => $jsonArray['nik'],
                "level"=> $jsonArray['level'],
                "status_user"=> $jsonArray['status'],
                "created_at"=> $jsonArray['created_at'],
                "üpdated_at" => $jsonArray['updated_at']);
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

    public function users_delete()
    {
        $id =  $this->delete('id');
        $hapus = $this->DataModel->delete('id_user', $id,'user');
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
