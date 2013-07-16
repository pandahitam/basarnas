<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

function Set_Arsip_Digital(form_name, p_btn_download_id, field_idform, p_kode_arsip, p_jns_arsip){
	var Cur_Form_Caller = window[form_name];
	var strNIP = Cur_Form_Caller.getForm().findField('NIP').getValue();	
	var aNIP = strNIP.split(",");
	var vNIP = aNIP[0];
	if(field_idform){
		var strID_Field = Cur_Form_Caller.getForm().findField(field_idform).getValue();
		var aID_Field = strID_Field.split(",");
		var vID_Field = aID_Field[0];
	}else{
		var vID_Field = null;
	}
	
	Ext.Ajax.request({
	 	url: BASE_URL + 'upload_arsip/get_arsip/' + p_jns_arsip, method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data',
	 	success: function(response){
			if(response.responseText){
				Ext.getCmp(p_btn_download_id).setDisabled(false);
	 			if(Right(response.responseText,4) == 'jpeg'){
	 				Ext.getCmp(p_btn_download_id).setIconCls('icon-jpeg');
	 			}else if(Right(response.responseText,4) == 'docx'){
	 				Ext.getCmp(p_btn_download_id).setIconCls('icon-doc');
	 			}else{
					switch(Right(response.responseText,3)){
						case 'jpg':
							Ext.getCmp(p_btn_download_id).setIconCls('icon-jpeg');
							break;
						case 'pdf':
							Ext.getCmp(p_btn_download_id).setIconCls('icon-pdf');
							break;
						case 'doc':
							Ext.getCmp(p_btn_download_id).setIconCls('icon-doc');
							break;
						case 'rar': case 'zip': case '7z': case 'tar':
							Ext.getCmp(p_btn_download_id).setIconCls('icon-zip');
							break;
						default:
							Ext.getCmp(p_btn_download_id).setIconCls('');							
					}
	 			}
	   	}else{
	   		Ext.getCmp(p_btn_download_id).setIconCls('');	
	   		Ext.getCmp(p_btn_download_id).setDisabled(true);
	   	}
	  },
	  failure: function(response){
	   	Ext.getCmp(p_btn_download_id).setIconCls('');	
	   	Ext.getCmp(p_btn_download_id).setDisabled(true);
	  },
	  scope : this
	});
}

function Reset_Arsip_Digital(form_name, p_btn_download_id, field_idform, p_kode_arsip, p_jns_arsip){
	var Cur_Form_Caller = window[form_name];	
	var strNIP = Cur_Form_Caller.getForm().findField('NIP').getValue();	
	var aNIP = strNIP.split(",");
	var vNIP = aNIP[0];
	if(field_idform){
		var strID_Field = Cur_Form_Caller.getForm().findField(field_idform).getValue();
		var aID_Field = strID_Field.split(",");
		var vID_Field = aID_Field[0];
	}else{
		var vID_Field = null;
	}

	Ext.Msg.show({
	  title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
	  buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
	  fn: function(btn) {
	   	if (btn == 'yes') {
				Ext.Ajax.request({
	  			url: BASE_URL + 'upload_arsip/delete_arsip/' + p_jns_arsip,
	   			method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data'
				});
		   	Ext.getCmp(p_btn_download_id).setIconCls('');	
		   	Ext.getCmp(p_btn_download_id).setDisabled(true);
	   	}
	  }
	});
}

function Download_Arsip_Digital(form_name, field_idform, p_kode_arsip, p_jns_arsip){
	var Cur_Form_Caller = window[form_name];
	var strNIP = Cur_Form_Caller.getForm().findField('NIP').getValue();	
	var aNIP = strNIP.split(",");
	var vNIP = aNIP[0];
	if(field_idform){
		var strID_Field = Cur_Form_Caller.getForm().findField(field_idform).getValue();
		var aID_Field = strID_Field.split(",");
		var vID_Field = aID_Field[0];
	}else{
		var vID_Field = null;
	}

	Ext.Ajax.request({
		url: BASE_URL + 'upload_arsip/prepare_download/' + p_jns_arsip, method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data',
	  success: function(response){
	  	if(response.responseText != 'GAGAL'){
	  		var body = Ext.getBody();
				var frame = body.createChild({tag:'iframe',cls:'x-hidden',id:'iframe',name:'iframe'});
				var form = body.createChild({
					tag:'form',cls:'x-hidden',id:'form',target:'iframe',
					action: BASE_URL + 'upload_arsip/download_arsip/' + response.responseText
				});
				form.dom.submit();
			}
	  },
	  scope : this
	});
}

<?php }else{ echo "var Funct_Arsip = 'GAGAL';"; } ?>