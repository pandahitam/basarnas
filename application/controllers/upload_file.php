<?php

class upload_file extends CI_Controller {

    function imageUpload() {
        $file = $_FILES;
        $config['upload_path'] = './uploads/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        /* $config['max_size']	= '100';
          $config['max_width']  = '1024';
          $config['max_height']  = '768';
         */

        $this->upload->initialize($config);

        $this->load->library('upload', $config);

        header("Content-Type: text/html");

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors('',''),
                'success' => false);
            echo json_encode($error);
        } else {
            $data = array('upload_data' => $this->upload->data(),
                'success' => true);
            echo json_encode($data);
        }
    }

    public function imageDelete() {
        $file = $this->input->post('file');

        $success = false;
        if (unlink(FCPATH . 'uploads/images/' . $file)) {
            $success = true;
        }

        $info = array('success' => $success,
            'path' => base_url() . 'uploads/images/' . $file,
            'file' => is_file(FCPATH . 'uploads/images/' . $file));

        echo json_encode($info);
    }

    public function documentUpload() {
        $file = $_FILES;
        $config['upload_path'] = './uploads/documents/';
        $config['allowed_types'] = 'jpeg|jpg|pdf|doc|docx|xls|xlsx';

        $this->upload->initialize($config);

        $this->load->library('upload', $config);

        header("Content-Type: text/html");

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors('',''),
                'success' => false);
            echo json_encode($error);
        } else {
            $data = array('upload_data' => $this->upload->data(),
                'success' => true);
            echo json_encode($data);
        }
    }

    public function documentDelete() {
        $file = $this->input->post('file');

        $success = false;
        if (unlink(FCPATH . 'uploads/documents/' . $file)) {
            $success = true;
        }

        $info = array('success' => $success,
            'path' => base_url() . 'uploads/documents/' . $file,
            'file' => is_file(FCPATH . 'uploads/documents/' . $file));

        echo json_encode($info);
    }

}

?>