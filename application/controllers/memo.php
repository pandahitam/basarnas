<?php
class memo extends MY_Controller {
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('memo_view',$data);
		}else{
			$this->load->view('memo_view');
		}
	}
        
        function add(){
            $data = array();
            $dataFields = array('kd_lokasi','kd_brg','no_aset','kode_unor','isi');
            
            foreach ($dataFields as $field) {
			$data[$field] = $this->input->post($field);
            }
            
            $data['date_created'] = date('Y-m-d H:i:s');
            $user_name = $this->session->userdata('fullname_zs_simpeg');
            $nip = $this->session->userdata('nip_zs_simpeg');
            $data['created_by'] = $user_name.'['.$nip.']';
            
            $this->db->insert('memo',$data);
            echo "{success:true}";
        }
        
        function isRead()
        {
            $user_name = $this->session->userdata('fullname_zs_simpeg');
            $nip = $this->session->userdata('nip_zs_simpeg');
            $this->db->where('id',$_POST['id']);
            $updateData = array(
                'is_read'=>1,
                'date_read'=>date('Y-m-d H:i:s'),
                'read_by'=>$user_name.'['.$nip.']',
            );
            $this->db->update('memo',$updateData);
        }
	
}
?>