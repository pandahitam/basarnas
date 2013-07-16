<?php
class UploadFILE_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

  // Set Upload	PHOTO
  function upload_set_photo($Path, $fieldname, $NIP=''){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'jpg|jpeg';
  	$config['max_size'] = '2024';
  	
  	//$this->load->library('upload', $config);
  	$this->upload->initialize($config);
  	
  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  		  
    		/* PATH */
    		$source = $files_info['file_path'].$files_info['file_name'];
    		$destination_thumb = $Path;
    		
    		// Permission Configuration
    		chmod($source, 0777) ;
    		
    		/* Resizing Processing */
    		// Configuration Of Image Manipulation :: Static
    		$this->load->library('image_lib') ;
    		$img['image_library'] = 'GD2';
    		$img['create_thumb']  = TRUE;
    		$img['maintain_ratio']= TRUE;
    		
    		// Limit Width Resize
    		$limit_thumb    = 110 ;
    		
    		// Size Image Limit was using (LIMIT TOP)
    		$limit_use  = $files_info['image_width'] > $files_info['image_height'] ? $files_info['image_width'] : $files_info['image_height'] ;
    		
    		// Percentase Resize
    		if ($limit_use > $limit_thumb) {
    			$percent_thumb  = $limit_thumb/$limit_use ;
    		}    
    		
    		//// Making THUMBNAIL ///////
    		$img['width']  = $limit_use > $limit_thumb ?  $files_info['image_width'] * $percent_thumb : $files_info['image_width'] ;
    		$img['height'] = $limit_use > $limit_thumb ?  $files_info['image_height'] * $percent_thumb : $files_info['image_height'] ;
    		
    		// Configuration Of Image Manipulation :: Dynamic
    		$img['thumb_marker'] = $NIP;
    		$img['quality']      = '100%' ;
    		$img['source_image'] = $source ;
    		$img['new_image']    = $destination_thumb ;
    		
    		// Do Resizing
    		$this->image_lib->initialize($img);
    		//$this->image_lib->resize();
    		
    		$resize = false;
    		if($this->image_lib->resize()){
    			// Remove Source File
	    		if(!is_dir($source) && file_exists($source)){
	    			unlink($source);
	    		}
	    		$resize = true;
	    	}
				
    		// Change ThumbName To NIP
    		if($resize == true){
		    	$source_thumb = $files_info['file_path'].$files_info['raw_name'].$img['thumb_marker'].$files_info['file_ext'];
	    	}else{
		    	$source_thumb = $files_info['file_path'].$files_info['raw_name'].$files_info['file_ext'];
	    	}	    		
		    $destination = $files_info['file_path'].$img['thumb_marker'].$files_info['file_ext'];
	    	if(!is_dir($source_thumb) && file_exists($source_thumb)){
			   	rename($source_thumb, $destination);
	    	}

    		$this->image_lib->clear();

		    return "SUKSES";
  	  }else{
  		  return "GAGAL";
  	  }
  	  return "GAGAL";
    }else{
    	return "Field tidak ditemukan";
    }
  }

  // START - ARSIP DIGITAL
	function check_folder_arsip($kode_arsip=null, $NIP=null){
		if($kode_arsip && $NIP){
			// Check Root Folder
			$RootPath = './assets/arsip/';	
			if(!is_dir($RootPath)){
				mkdir($RootPath, 0700);
			}

			// Check Folder Kode Arsip
			$Path_L1 = $RootPath.$kode_arsip.'/';	
			if(!is_dir($Path_L1)){
				mkdir($Path_L1, 0700);
			}
			
			// Check Folder Group
			if(strlen($NIP) == 18){
				$folder_group = substr($NIP,8,6);	
			}elseif(strlen($NIP) == 9){
				$folder_group = "nip_lama";	
			}else{
				$folder_group = "tnipolri";					
			}
			$Path_L2 = $Path_L1.$folder_group.'/';	
			if(!is_dir($Path_L2)){
				mkdir($Path_L2, 0700);
			}

			// Check Folder NIP
			$FullPath = $Path_L2.$NIP.'/';	
			if(!is_dir($FullPath)){
				mkdir($FullPath, 0700);
			}
			
			return $FullPath;
		}else{
			return false;
		}
	}

  function upload_set_arsip($Path, $fieldname, $FileName=''){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'jpg|jpeg|pdf|doc|docx|rar|zip|7z|tar';
  	$config['max_size'] = '5024';
  	
  	$this->load->library('upload', $config);
	  $this->upload->initialize($config);

  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  		  
    		/* PATH */
    		$source = $files_info['file_path'].$files_info['file_name'];
    		$destination_thumb = $Path;
    		
    		// Permission Configuration
    		chmod($source, 0777);
  		  
  		  // Ganti nama file dengan nama yang sudah ditentukan
  		  if($files_info['file_ext'] != '.jpg' && $files_info['file_ext'] != '.jpeg'){
		    	if(!is_dir($source) && file_exists($source)){
		    		$destination = $files_info['file_path'].$FileName.$files_info['file_ext'];
				   	rename($source, $destination);
		    	}
		    	// Menghapus file sebelumnya jika ada
		    	$last_file = $files_info['file_path'].$FileName.'.jpg';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.jpeg';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.pdf';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.doc';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.docx';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.rar';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.zip';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.7z';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
		    	$last_file = $files_info['file_path'].$FileName.'.tar';
		    	if($last_file != $destination){
		    		if(!is_dir($last_file) && file_exists($last_file)){
		    			unlink($last_file);
		    		}
		    	}
  		  	return $files_info;
  		  	
  		  }else{
		    	// Menghapus file sebelumnya jika ada
		    	$last_file = $files_info['file_path'].$FileName.'.pdf';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.doc';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.docx';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.rar';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.zip';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.7z';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
		    	$last_file = $files_info['file_path'].$FileName.'.tar';
	    		if(!is_dir($last_file) && file_exists($last_file)){
	    			unlink($last_file);
	    		}
  		  }
    		
    		/* Resizing Processing */
    		// Configuration Of Image Manipulation :: Static
    		$this->load->library('image_lib') ;
    		$img['image_library'] = 'GD2';
    		$img['create_thumb']  = TRUE;
    		$img['maintain_ratio']= TRUE;
    		
    		// Limit Width Resize
    		$limit_thumb    = 680;
    		
    		// Size Image Limit was using (LIMIT TOP)
    		$limit_use  = $files_info['image_width'] > $files_info['image_height'] ? $files_info['image_width'] : $files_info['image_height'] ;
    		
    		// Percentase Resize
    		if ($limit_use > $limit_thumb) {
    			$percent_thumb  = $limit_thumb/$limit_use ;
    		}
    		
    		//// Making THUMBNAIL ///////
    		$img['width']  = $limit_use > $limit_thumb ?  $files_info['image_width'] * $percent_thumb : $files_info['image_width'] ;
    		$img['height'] = $limit_use > $limit_thumb ?  $files_info['image_height'] * $percent_thumb : $files_info['image_height'] ;
    		
    		// Configuration Of Image Manipulation :: Dynamic
    		$img['thumb_marker'] = $FileName;
    		$img['quality']      = '100%' ;
    		$img['source_image'] = $source ;
    		$img['new_image']    = $destination_thumb ;
    		
    		// Do Resizing
    		$this->image_lib->initialize($img);
    		
    		$resize = false;
    		if($this->image_lib->resize()){
    			// Remove Source File
	    		if(!is_dir($source) && file_exists($source)){
	    			unlink($source);
	    		}
	    		$resize = true;
	    	}
				
    		// Change ThumbName
    		if($resize == true){
		    	$source_thumb = $files_info['file_path'].$files_info['raw_name'].$img['thumb_marker'].$files_info['file_ext'];
	    	}else{
		    	$source_thumb = $files_info['file_path'].$files_info['raw_name'].$files_info['file_ext'];
	    	}	    		
		    $destination = $files_info['file_path'].$img['thumb_marker'].$files_info['file_ext'];
	    	if(!is_dir($source_thumb) && file_exists($source_thumb)){
			   	rename($source_thumb, $destination);
	    	}

    		$this->image_lib->clear();

		    return $files_info;
  	  }else{
  		  return "GAGAL";
  	  }
    }else{
    	return "Field tidak ditemukan";
    }
  }  	
  // END - ARSIP DIGITAL
	
  // Set Upload	IMAGE
  function upload_set_img($Path, $fieldname){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'jpg|jpeg|png|gif';
  	$config['max_size'] = '2024';
  	
  	//$this->load->library('upload', $config);
  	$this->upload->initialize($config);
  	
  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  	  }else{
  		  //$files_info = $this->upload->display_errors();
  		  $files_info = "GAGAL";
  	  }
  	  return $files_info;
    }
  }  	

  // Set Upload	IMAGE with THUMBNAIL
  function upload_set_img_withthumb($Path,$fieldname){
  	$config['upload_path'] = $Path.'fullscreen/';
  	$config['allowed_types'] = 'jpg|jpeg';
  	$config['max_size'] = '2024';
  	
  	$this->upload->initialize($config);
  	
  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();

    		/* PATH */
    		$source = $files_info['file_path'].$files_info['file_name'];
    		$destination_thumb = $Path."thumbnails/";
    		$destination_medium	= $Path."mediums/" ;
    
    		// Permission Configuration
    		chmod($source, 0777) ;
    
    		/* Resizing Processing */
    		// Configuration Of Image Manipulation :: Static
    		$this->load->library('image_lib') ;
    		$img['image_library'] = 'GD2';
    		$img['create_thumb']  = TRUE;
    		$img['maintain_ratio']= TRUE;
    
    		// Limit Width Resize
    		$limit_medium   = 200 ;
    		$limit_thumb    = 120 ;
    
    		// Size Image Limit was using (LIMIT TOP)
    		$limit_use  = $files_info['image_width'] > $files_info['image_height'] ? $files_info['image_width'] : $files_info['image_height'] ;
    
    		// Percentase Resize
    		if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
    			$percent_medium = $limit_medium/$limit_use ;
    			$percent_thumb  = $limit_thumb/$limit_use ;
    		}    
    
    		//// Making THUMBNAIL ///////
    		$img['width']  = $limit_use > $limit_thumb ?  $files_info['image_width'] * $percent_thumb : $files_info['image_width'] ;
    		$img['height'] = $limit_use > $limit_thumb ?  $files_info['image_height'] * $percent_thumb : $files_info['image_height'] ;
    
    		// Configuration Of Image Manipulation :: Dynamic
    		$img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
    		$img['quality']      = '100%' ;
    		$img['source_image'] = $source ;
    		$img['new_image']    = $destination_thumb ;
    
    		// Do Resizing
    		$this->image_lib->initialize($img);
    		$this->image_lib->resize();
    		$this->image_lib->clear();
    		
    		$files_info = array('pict_name' => $files_info['file_name'],'thumb_name' => $files_info['raw_name'].$img['thumb_marker'].$files_info['file_ext']);
    		
    		//$ThumbName = $files_info['raw_name'].$img['thumb_marker'].$files_info['file_ext'];

    		/*
    		////// Making MEDIUM /////////////
    		$img['width']   = $limit_use > $limit_medium ?  $files_info['image_width'] * $percent_medium : $files_info['image_width'] ;
    		$img['height']  = $limit_use > $limit_medium ?  $files_info['image_height'] * $percent_medium : $files_info['image_height'] ;
    
    		// Configuration Of Image Manipulation :: Dynamic
    		$img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']) ;
    		$img['quality']      = '100%' ;
    		$img['source_image'] = $source ;
    		$img['new_image']    = $destination_medium ;
    
    		// Do Resizing
    		$this->image_lib->initialize($img);
    		$this->image_lib->resize();
    		$this->image_lib->clear() ;
    		*/
    		
  	  }else{
  		  $this->session->set_flashdata('uploadmsg',$this->upload->display_errors());
  		  $files_info = "";
  	  }
  	  return $files_info;
    }
  }  	
	
  // Set Upload	PDF
  function upload_set_pdf($Path,$fieldname){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'pdf';
  	$config['max_size'] = '50024';
  	
  	$this->upload->initialize($config);
  	
  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  	  }else{
  		  $this->session->set_flashdata('uploadmsg',$this->upload->display_errors());
  		  $files_info = "";
  	  }
  	  return $files_info;
    }
  }  	

  // Set Upload	DOKUMEN
  function upload_set_doc($Path,$fieldname){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar|7z|tar';
  	$config['max_size'] = '50024';
  	
  	$this->upload->initialize($config);
  	
    if(isset($fieldname)){
	  	if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  	  }else{
  		  $this->session->set_flashdata('uploadmsg',$this->upload->display_errors());
  		  $files_info = "";
  	  }
  	  return $files_info;
  	}
  }  	

  // Set Upload	EXCEL
  function upload_set_xls($Path,$fieldname){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'xls';
  	$config['max_size'] = '50024';
  	
  	$this->upload->initialize($config);
  	
    if(isset($fieldname)){
	  	if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  	  }else{
  		  $this->session->set_flashdata('uploadmsg',$this->upload->display_errors());
  		  $files_info = "";
  	  }
  	  return $files_info;
  	}
  }  	

  // Set Upload	VIDEO
  function upload_set_video($Path,$fieldname){
  	$config['upload_path'] = $Path;
  	$config['allowed_types'] = 'swf|flv';
  	$config['max_size'] = '50024';
  	
  	$this->upload->initialize($config);
  	
  	if(isset($fieldname)){
  	  if($this->upload->do_upload($fieldname)){
  		  $files_info = $this->upload->data();
  	  }else{
  		  $this->session->set_flashdata('uploadmsg',$this->upload->display_errors());
  		  $files_info = "";
  	  }
  	  return $files_info;
  	}
  }  	
}
?>