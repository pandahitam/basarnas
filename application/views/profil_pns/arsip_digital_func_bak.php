<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

function Set_Arsip_Digital(form_name, image_arsip, field_idform, p_kode_arsip, p_jns_arsip){
	var Cur_Form_Caller = window[form_name];
	var Cur_Image_Arsip = window[image_arsip];
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
	
	if(Cur_Image_Arsip.el){
		Ext.Ajax.request({
	  	url: BASE_URL + 'upload_arsip/get_arsip/' + p_jns_arsip, method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data',
	   	success: function(response){
	   		if(response.responseText){
	   			if(Right(response.responseText,3) == 'jpg' || Right(response.responseText,4) == 'jpeg'){
	   				Cur_Image_Arsip.el.dom.src = response.responseText + '?dc=' + new Date().getTime();
	   			}else{
	   				Cur_Image_Arsip.el.dom.src = './assets/images/preview.png' + '?dc=' + new Date().getTime();
	   				switch(p_jns_arsip){
	   					case 'pendidikan':
	   						Ext.getCmp('Frame_Cetak_Arsip_Pddk').hide();
	   						Ext.getCmp('Frame_Download_Arsip_Pddk').show();
	   						break;
	   				}
	   			}
	   		}else{
					Cur_Image_Arsip.el.dom.src = './assets/images/preview.png' + '?dc=' + new Date().getTime();
	   		}
	  	},
	  	failure: function(response){
	  		Cur_Image_Arsip.el.dom.src = './assets/images/preview.png' + '?dc=' + new Date().getTime();
	   		switch(p_jns_arsip){
	   			case 'pendidikan':
	   				Ext.getCmp('Frame_Cetak_Arsip_Pddk').hide();
	   				Ext.getCmp('Frame_Download_Arsip_Pddk').hide();
	   				break;
	   		}
	  	},
	   	scope : this
		});
	}
}

function Reset_Arsip_Digital(form_name, image_arsip, field_idform, p_kode_arsip, p_jns_arsip){
	var Cur_Form_Caller = window[form_name];	
	var Cur_Image_Arsip = (image_arsip) ? window[image_arsip] : null;	
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
				if(Cur_Image_Arsip){
					Cur_Image_Arsip.el.dom.src = './assets/images/preview.png' + '?dc=' + new Date().getTime();
				}
	   	}
	  }
	});
}

function Cetak_Arsip_Digital(form_name, field_idform, p_kode_arsip, p_jns_arsip){
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
		url: BASE_URL + 'upload_arsip/cetak_arsip/' + p_jns_arsip, method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data',
	  success: function(response){
	  	if(response.responseText != 'GAGAL'){
				var docprint_arsip = new Ext.create('Ext.window.Window', {
					title: 'Arsip Digital', iconCls: 'icon-printer', constrainHeader : true, closable: true, maximizable: true, width: '95%', height: '95%', bodyStyle: 'padding: 5px;', modal : true,
					items: [{
						xtype:'tabpanel', activeTab : 0, width: '100%', height: '100%',
			      items: [{
			      	title: 'Preview', frame: false, collapsible: true, autoScroll: true, iconCls: 'icon-pdf',
			      	items: [{
			      		xtype : 'miframe', frame: false, height: '100%', noCache: true,
			      		src : response.responseText
			       	}]
			      }]
					}]
				}).show();
			}
	  },
	  scope : this
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
		url: BASE_URL + 'upload_arsip/download_arsip/' + p_jns_arsip, method: 'POST', params: {id_open: 1, NIP:vNIP, kode_arsip:p_kode_arsip, ID_Field:vID_Field}, renderer: 'data',
	  success: function(response){
	  	if(response.responseText != 'GAGAL'){
	  		//window.open(response.responseText,"mywindow","location=1,status=1,scrollbars=1,width=100,height=100");
	  		//return false;
	  		//window.location.href = response.responseText;
	  		Ext.DomHelper.useDom = true;
				try {
        	Ext.destroy(Ext.get('downloadIframe'));
        }
        catch(e) {}
        Ext.DomHelper.append(document.body, {
        	tag: 'iframe',
          id:'downloadIframe',
          frameBorder: 0,
          width: 0,
          height: 0,
          target: '_blank',
          css: 'display:none;visibility:hidden;height:0px;',
          href: BASE_URL + response.responseText
        });
			}
	  },
	  scope : this
	});
}

<?php }else{ echo "var Funct_Arsip = 'GAGAL';"; } ?>