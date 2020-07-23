<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Conversation extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('DataModel');
       
        // $this->methods['komentar_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['komentar_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['komentar_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function conversation_get()
    {
        $id = $this->get('id');
        if ($id === NULL)
        {
            $data = $this->DataModel->select('s.id_user AS sender_id,
                                                s.nama AS sender_nama,
                                                 s.media_user AS sender_media,
                                                 s.alamat AS sender_alamat,
                                                 s.username AS sender_username,
                                                 s.level As sender_level,
                                                 r.id_user AS receiver_id,
                                                 r.nama AS receiver_nama,
                                                 r.media_user AS receiver_media,
                                                 r.alamat AS receiver_alamat,
                                                 r.username AS receiver_username,
                                                 r.level As receiver_level,
                                                 c.id_detail_chat,
                                                 c.id_chat,
                                                 c.status_detail,
                                                 c.body,
                                                 c.media,
                                                 c.type,
                                                 c.created_at,
                                                 c.updated_at
                                                 ');
                $data = $this->DataModel->getJoin('user AS s','s.id_user = c.from_sender','INNER');
                $data = $this->DataModel->getJoin('user AS r','r.id_user = c.to_receiver','INNER');
                $data = $this->DataModel->order_by("c.created_at","ASC");
                $data = $this->DataModel->getData('detail_chat AS c');
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
            $data = $this->DataModel->select('s.id_user AS sender_id,
            s.nama AS sender_nama,
             s.media_user AS sender_media,
             s.alamat AS sender_alamat,
             s.username AS sender_username,
             s.level As sender_level,
             r.id_user AS receiver_id,
             r.nama AS receiver_nama,
             r.media_user AS receiver_media,
             r.alamat AS receiver_alamat,
             r.username AS receiver_username,
             r.level As receiver_level,
             c.id_detail_chat,
             c.id_chat,
             c.status_detail,
             c.body,
             c.media,
             c.type,
             c.created_at,
             c.updated_at
             ');
$data = $this->DataModel->getJoin('user AS s','s.id_user = c.from_sender','INNER');
$data = $this->DataModel->getJoin('user AS r','r.id_user = c.to_receiver','INNER');
$data = $this->db->where("c.id_chat ",$id);
$data = $this->DataModel->order_by("c.created_at","ASC");
$data = $this->DataModel->getData('detail_chat AS c');
            
            
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

    public function conversation_post()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->insert('detail_chat',$jsonArray);
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
    public function conversation_put()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $simpan = $this->DataModel->update('id_chat',$jsonArray['id_chat'],'detail_chat',$jsonArray);
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

    public function conversation_delete()
    {
        $id =  $this->delete('id');
        $hapus = $this->DataModel->delete('id_chat', $id,'detail_chat');
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
