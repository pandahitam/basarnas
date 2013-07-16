<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Biodata_last_record, P_Posisi_d_Jab_last_record, P_Data_Lainnya_last_record;
var vcbp_jns_pgw_last;
var vcbp_bio_jk_last, vcbp_bio_gd_last, vcbp_bio_agama_last, vcbp_bio_wn_last, vcbp_bio_skawin_last;
var vcbp_kode_prov = 0, vcbp_kode_kabkota = 0, vcbp_kode_kec = 0;
var vcbp_kode_prov_last, vcbp_kode_kabkota_last, vcbp_kode_kec_last;
var vcbp_rambut_last, vcbp_bentuk_muka_last, vcbp_warna_kulit_last;
var title_active_tab_profil = 'Data Pribadi';

// FORM HEAD PROFIL PNS  --------------------------------------------------------- START
var Form_Head_PPNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Head_PPNS', frame: true, bodyStyle: 'padding: 0 0 0 0;', height: 125,
 	defaultType: 'textfield', fieldDefaults: {labelAlign: 'left', msgTarget: 'side'},
 	defaults: {anchor: '100%', fieldStyle: 'height: 18px;'}, 
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', height: 120,
  	 items: [
  	 	{xtype: 'fieldset', defaults: {labelWidth: 118, readOnly: true}, height: 118, margins: '0 5 0 0', style: 'padding: 0; border-width: 0px;', flex:2,
  	 	 items: [
    		{xtype: 'textfield', fieldLabel: 'Nama Lengkap', name: 'nama_lengkap_v', fieldStyle: 'border-width: 0px;', anchor: '99%'},   			   	
    		{xtype: 'fieldcontainer', layout: 'hbox', id: 'FieldC_NIP', fieldLabel: 'NIP', defaults: {hideLabel: true, readOnly: true, margins: '0 5 0 0', fieldStyle: 'border-width: 0px;'}, combineErrors: false,
     		 defaultType: 'textfield',
     		 items: [
     				{fieldLabel: 'NIP', name: 'NIP_v', id: 'NIP_v', flex:1},
      			{fieldLabel: 'NIP Lama', name: 'NIP_Lama_v', id: 'NIP_Lama_v', labelWidth: 70, labelAlign: 'right', hideLabel: false, flex:1}
     		 ]
    		},    		
    		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Pangkat, Gol.Ruang', defaults: {hideLabel: true, readOnly: true, margins: '0 5 0 0', fieldStyle: 'border-width: 0px;'}, combineErrors: false,
     		 defaultType: 'textfield',
     		 items: [
     				{fieldLabel: 'Gol.Ruang, Pangkat', name: 'pangkat_golru_v', flex:1},
     				{fieldLabel: 'TMT BUP', labelAlign: 'right', labelWidth: 70, hideLabel: false, xtype: 'datefield', name: 'TMT_BUP_v', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', allowBlank: true, maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', fieldStyle: 'color: #FF0000;', flex:1}
     		 ]
    		},
    		{xtype: 'textfield', fieldLabel: 'Jabatan', name: 'nama_jab_v', fieldStyle: 'border-width: 0px;', anchor: '99%'}    		
  	 	 ]
  	 	},
  	 	{xtype: 'fieldset', defaults: {labelAlign: 'top', anchor: '100%'}, height: 118, margins: '0 5 0 0', style: 'padding: 0; border-width: 0px;', flex:1,
  	 	 items: [
  	 	 	{xtype: 'textareafield', fieldLabel: 'Unit Organisasi', name: 'nama_unor_v', height: 53, readOnly: true, fieldStyle: 'border-width: 0px;'},
  	 	 	{xtype: 'textareafield', fieldLabel: 'Unit Kerja', name: 'nama_unker_v', height: 53, readOnly: true, fieldStyle: 'border-width: 0px;'}
  	 	 ]
  	 	}
  	 ]
  	}  
  ]
});

// IMAGES PROCESS ------------------------------------------------------------ START
var logo_pemda = new Ext.Component({autoEl: {tag: 'img', src: BASE_URL + 'assets/images/logo_pemda_100.png', id: 'logo_pemda'}});
var photo_pns = new Ext.Component({autoEl: {tag: 'img', src: photo_pgw, id: 'photo_pns'}});

var Form_Upload_Photo = new Ext.create('Ext.form.Panel', {
	id: 'Form_Upload_Photo', url: BASE_URL + 'profil_pns/upload_photo', fileUpload: true, 
	frame: true, title: 'Up-Photo', width: 70, margins: '0 5 0 0', hidden: true,
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_photo'},
		{xtype: 'fileuploadfield', name: 'filephoto', id:'filephoto', buttonOnly: true, buttonText: '.Browse.', hideLabel: true,
		 listeners: {
		 	'change': function(){
		 		if(Form_Upload_Photo.getForm().isValid()){
		 			var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
		 			Form_Upload_Photo.getForm().setValues({NIP: vNIP});
		 			Form_Upload_Photo.getForm().submit({
		 				waitMsg: 'Sedang meng-upload photo...',
		 				success: function(form, action) {
		 					obj = Ext.decode(action.response.responseText);
		 					if(obj.errors.reason == 'SUKSES'){
		 						set_photo_frame(vNIP);
		 					}
		 				},
    				failure: function(form, action){
      				obj = Ext.decode(action.response.responseText);
      				Ext.MessageBox.show({title:'Gagal Upload !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
    				}, scope: this
		 			});
		 		}
		 	}
		 }
		},
		{xtype: 'button', text: '..Hapus..', handler: function() {
			reset_photo_frame(Form_Biodata_PNS.getForm().findField('NIP').getValue());
		}}
	]
});

function set_photo_frame(photo_nip){
	var NIP_File = replaceAll(photo_nip,' ','');
	NIP_File = replaceAll(NIP_File,'/','_');
	if(String(NIP_File).length == 18){
		var photo_folder = Mid(NIP_File,9,6);
		var photo_name = NIP_File + '.jpg';
		photo_pgw = BASE_URL + 'assets/photo/' + photo_folder + '/' + photo_name;
	}else if(String(NIP_File).length == 9){
		var photo_folder = 'nip_lama';
		var photo_name = NIP_File + '.jpg';
		photo_pgw = BASE_URL + 'assets/photo/' + photo_folder + '/' + photo_name;
	}else if(String(NIP_File).length > 4){
		var photo_folder = 'tnipolri';
		var photo_name = NIP_File + '.jpg';
		photo_pgw = BASE_URL + 'assets/photo/' + photo_folder + '/' + photo_name;
	}else{
		photo_pgw = photo_default;
	}
	photo_pns.el.dom.src = photo_pgw + '?dc=' + new Date().getTime();
	Deactive_Form_Biodata_PNS();
}

function reset_photo_frame(vphoto_nip){
	Ext.Msg.show({
  	title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus photo ?',
   	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
   	fn: function(btn) {
   		if (btn == 'yes') {
				Ext.Ajax.request({
  				url: BASE_URL + 'profil_pns/delete_photo',
   				method: 'POST', params: {photo_nip:vphoto_nip}, renderer: 'data'
				});
				photo_pns.el.dom.src = photo_default + '?dc=' + new Date().getTime();
				Deactive_Form_Biodata_PNS();
     	}
   	}
  });
}
// IMAGES PROCESS ------------------------------------------------------------ END

var Header_Profil_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Header_Profil_PNS',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%',
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox',
  	 items: [
  	 	{xtype: 'fieldset', height: 120, margins: '0 5 0 5', style: 'padding: 5px; text-align: center;', flex:1,
  	 	 items: [photo_pns]
  	 	},
  	 	Form_Upload_Photo,
  	 	{xtype: 'fieldset', margins: '0 5 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:6,
  	 	 items: [Form_Head_PPNS]
  	 	},
  	 	{xtype: 'fieldset', height: 120, margins: '0 5 0 0', style: 'align: center; padding: 5px; text-align: center;', flex:1,
  	 	 items: [logo_pemda]
  	 	}
  	 ]
  	}
	]
});
// FORM HEAD PROFIL PNS  --------------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Bio = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Bio', url: BASE_URL + 'upload_arsip/insert_arsip/biodata', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Bio'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Bio', value: 1},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Bio', emptyText: 'Upload file KTP/SIM', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Bio.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						Form_Arsip_Bio.getForm().setValues({NIP: p_NIP});
			 			Form_Arsip_Bio.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Deactive_Form_Biodata_PNS();
			 					}
			 				},
	    				failure: function(form, action){
	      				obj = Ext.decode(action.response.responseText);
	      				Ext.MessageBox.show({title:'Gagal Upload !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	    				}, scope: this
			 			});
			 		}
			 	}
			 }
			},
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Bio', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Bio();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Bio', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Bio();}},
		 ]
		}
	]
});

function Set_Arsip_Bio(){Set_Arsip_Digital('Form_Biodata_PNS', 'Btn_Download_Arsip_Bio', null, 1, 'biodata');}
function Reset_Arsip_Bio(){Reset_Arsip_Digital('Form_Biodata_PNS', 'Btn_Download_Arsip_Bio', null, 1, 'biodata'); Deactive_Form_Biodata_PNS();}
function Download_Arsip_Bio(){Download_Arsip_Digital('Form_Biodata_PNS', null, 1, 'biodata');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM BIODATA PNS  --------------------------------------------------------- START
var Data_CB_KabKota = new Ext.create('Ext.data.Store', {
	fields: ['kode_kabkota','nama_kabkota'], idProperty: 'ID_KK',
	proxy: new Ext.data.AjaxProxy({
		url: BASE_URL + 'combo_ref/combo_kabkota', actionMethods: {read:'POST'}, extraParams :{id_open: 1, kode_prov: vcbp_kode_prov}
	}), autoLoad: true
});

var Data_CB_Kecamatan = new Ext.create('Ext.data.Store', {
	fields: ['kode_kec','nama_kec'], idProperty: 'ID_Kec',
	proxy: new Ext.data.AjaxProxy({
		url: BASE_URL + 'combo_ref/combo_kec', actionMethods: {read:'POST'}, extraParams :{id_open: 1, kode_kabkota: vcbp_kode_kabkota}
	}), autoLoad: true
});

var Form_Biodata_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Biodata_PNS', url: BASE_URL + 'profil_pns/ext_insert_biodata',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', layout: 'hbox',
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 5px 0 0; border-width: 0px;', flex:1,
  	 	 items: [
	  		{xtype: 'fieldset', title: 'Data Pribadi', defaultType: 'textfield', defaults: {anchor: '100%', labelWidth: 93, fieldStyle: 'height: 20px;'}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{name: 'ID_Pegawai', xtype: 'hidden', id: 'ID_Pegawai'}, {name: 'NIP', xtype: 'hidden', id: 'NIP'}, {name: 'NIP_Lama', xtype: 'hidden', id: 'NIP_Lama'},
	    	 	{fieldLabel: 'Nama Lengkap (tanpa gelar)', name: 'nama_lengkap', id: 'nama_lengkap', allowBlank: false,
	    	 	 listeners: {
	    	 	 	'change': {
	    	 	 		fn: function (check, newValue) {
	    	 	 			var Gelar_D_ok = '', Gelar_B_ok = '';
	    	 	 			var vGelar_D = Form_Biodata_PNS.getForm().findField('gelar_d').getValue();
	    	 	 			var vGelar_B = Form_Biodata_PNS.getForm().findField('gelar_b').getValue();
	    	 	 			var vNama_Lengkap = newValue;
	    	 	 			if(vGelar_D != '')  Gelar_D_ok = vGelar_D + '. ';
	    	 	 			if(vGelar_B != '')  Gelar_B_ok = ', ' + vGelar_B;
	    	 	 			var Nama_Lengkap_ok = Gelar_D_ok + vNama_Lengkap + Gelar_B_ok;
	    	 	 			Form_Head_PPNS.getForm().setValues({nama_lengkap_v : Nama_Lengkap_ok});
	    	 	 		}
	    	 	 	}
	    	 	 }
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tmp., Tgl. Lahir',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tempat_lahir', margins: '0 5 0 0', allowBlank: false, flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tanggal_lahir', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', allowBlank: false, maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Jenis Kelamin',
	     	   items: [
	     	 	 	{xtype: 'combobox', fieldLabel: 'Jenis Kelamin', name: 'jenis_kelamin', hideLabel: true, margins: '0 10 0 0', flex:1,
	           store: new Ext.data.SimpleStore({data: [['L'],['P']], fields: ['jenis_kelamin']}),
	           valueField: 'jenis_kelamin', displayField: 'jenis_kelamin', emptyText: 'Jenis Kelamin',
	           queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	           listeners: {
	        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	         	},
	     	 	 	{xtype: 'combobox', fieldLabel: 'Gol. Darah', name: 'gol_darah', labelWidth: 150, labelAlign: 'right', flex:3,
	           store: new Ext.data.SimpleStore({data: [['-'],['A'],['B'],['AB'],['O'],['A+'],['A-'],['B+'],['B-'],['AB+'],['AB-'],['O+'],['O-']], fields: ['gol_darah']}),
	           valueField: 'gol_darah', displayField: 'gol_darah', emptyText: 'Gol.Darah',
	           queryMode: 'local', typeAhead: true, forceSelection: true, 
	           listeners: {
	         	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	          }
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Marga / Suku',
	     	   items: [
	     	 	 	{xtype: 'textfield', fieldLabel: 'Marga / Suku', name: 'suku', hideLabel: true, margins: '0 5 0 0', flex:1},
	     	 	 	{xtype: 'combobox', fieldLabel: 'Agama', name: 'agama', labelWidth: 45, labelAlign: 'right', flex:1,
	           store: new Ext.data.SimpleStore({data: [['Islam'],['Katolik'],['Protestan'],['Hindu'],['Budha']], fields: ['agama']}),
	           valueField: 'agama', displayField: 'agama', emptyText: 'Pilih Agama',
	           queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	           listeners: {
	         	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	          }
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Warga Negara',
	     	   items: [
	     	 	 	{xtype: 'combobox', fieldLabel: 'Warga Negara', name: 'warga_negara', hideLabel: true, margins: '0 10 0 0', flex:1,
	           store: new Ext.data.SimpleStore({data: [['WNI'],['WNA']], fields: ['warga_negara']}),
	           valueField: 'warga_negara', displayField: 'warga_negara', emptyText: 'Warga Negara',
	           queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	           listeners: {
	        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	         	},
	     	 	 	{xtype: 'combobox', fieldLabel: 'Status Kawin', name: 'status_kawin', labelWidth: 80, labelAlign: 'right', flex:2,
	           store: new Ext.data.SimpleStore({data: [['Belum Kawin'],['Kawin'],['Janda'],['Duda']], fields: ['status_kawin']}),
	           valueField: 'status_kawin', displayField: 'status_kawin', emptyText: 'Status',
	           queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	           listeners: {
	         	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	          }
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Provinsi', defaults: {hideLabel: true}, combineErrors: false,
	     	   defaultType: 'textfield',
	     	   items: [
		     		{fieldLabel: 'Provinsi', xtype: 'combobox', name: 'kode_prov', id: 'kode_prov_p_bio', hiddenName: 'kode_prov',
		       	 store: new Ext.data.Store({
		       			fields: ['kode_prov','nama_prov'], idProperty: 'ID_Prov',
		       			proxy: new Ext.data.AjaxProxy({
		    					url: BASE_URL + 'combo_ref/combo_prov', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}
		    	 			}), autoLoad: true
		       	 }),
		       	 valueField: 'kode_prov', displayField: 'nama_prov', emptyText: 'Pilih Provinsi',
		       	 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Provinsi',
		       	 listeners: {
		       			'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
		        		'change': {
		        			fn: function (comboField, newValue) {
		        				vcbp_kode_prov = newValue;
		        				Form_Biodata_PNS.getForm().setValues({kode_kabkota:0});
		        				Data_CB_KabKota.changeParams({params: {id_open:1, kode_prov: vcbp_kode_prov}});
		        			}, scope: this
		        		}       	
		       	 }, flex:1
		      	},
		     		{fieldLabel: 'Kab./Kota', xtype: 'combobox', name: 'kode_kabkota', id: 'kode_kabkota_p_bio', hiddenName: 'kode_kabkota',
		       	 store: Data_CB_KabKota,
		       	 valueField: 'kode_kabkota', displayField: 'nama_kabkota', emptyText: 'Pilih Kabupaten',
		       	 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kabupaten',
		       	 listeners: {
		       			'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
		        		'change': {
		        			fn: function (comboField, newValue) {
		        				vcbp_kode_kabkota = newValue;
		        				Form_Biodata_PNS.getForm().setValues({kode_kec:0});
		        				Data_CB_Kecamatan.changeParams({params: {id_open:1, kode_kabkota: vcbp_kode_kabkota}});		        				
		        			}, scope: this
		        		}       	
		       	 }, margins: '0 0 0 0', labelWidth: 65, labelAlign: 'right', hideLabel: false, flex:2
		      	},

	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Kecamatan', defaults: {hideLabel: true}, combineErrors: false,
	     	   defaultType: 'textfield',
	     	   items: [
		     		{fieldLabel: 'Kecamatan', xtype: 'combobox', name: 'kode_kec', id: 'kode_kec_p_bio', hiddenName: 'kode_kec',
		       	 store: Data_CB_Kecamatan,
		       	 valueField: 'kode_kec', displayField: 'nama_kec', emptyText: 'Pilih Kecamatan',
		       	 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kecamatan',
		       	 listeners: {'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}}, flex:1
		      	},
	      		{fieldLabel: 'Desa', name: 'desa', labelWidth: 70, labelAlign: 'right', hideLabel: false, flex:2},
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Telepon / Fax',
	     	   combineErrors: false, defaultType: 'textfield', defaults: {hideLabel: true},
	     	   items: [
	      	 	{fieldLabel: 'Telepon', name: 'telp', maskRe: /[\d\ \-\;]/, regex: /^[0-9]|\;*$/, margins: '0 5 0 0', flex:1},
	      	 	{fieldLabel: 'Fax', name: 'fax', maskRe: /[\d\ \-\;]/, regex: /^[0-9]|\;*$/, flex:1}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'HP / Kode Pos',
	     	   combineErrors: false, defaultType: 'textfield', defaults: {hideLabel: true},
	     	   items: [
	      	 	{fieldLabel: 'HP', name: 'hp', maskRe: /[\d\ \-\;]/, regex: /^[0-9]|\;*$/, margins: '0 5 0 0', flex:1},
	      	 	{fieldLabel: 'Kode Pos', name: 'kodepos', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, flex:1}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'E-Mail', name: 'email', vtype: 'email', anchor: '80%'}    	
	       ]
	    	},	    	
	    	
	     ]
	    },	    	
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
  	 	 items: [  	 	 	
  	 		{xtype: 'fieldset', title: 'Gelar & Pendidikan Terakhir', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80, fieldStyle: 'height: 20px;'}, 
  	 	 	 items : [
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Gelar Depan', combineErrors: false,
     	   	 defaultType: 'textfield', defaults: {hideLabel: true, labelWidth: 70},
     	   	 items: [
      	 		{fieldLabel: 'Di Depan', name: 'gelar_d', margins: '0 5 0 0', flex:1,
    	 	 		 listeners: {
    	 	 			'change': {fn: function (check, newValue) {
    	 	 					var Gelar_D_ok = '', Gelar_B_ok = '';
    	 	 					var vGelar_D = newValue;
    	 	 					var vGelar_B = Form_Biodata_PNS.getForm().findField('gelar_b').getValue();
    	 	 					var vNama_Lengkap = Form_Biodata_PNS.getForm().findField('nama_lengkap').getValue();
    	 	 					if(vGelar_D != '')  Gelar_D_ok = vGelar_D + '. ';
    	 	 					if(vGelar_B != '')  Gelar_B_ok = ', ' + vGelar_B;
    	 	 					var Nama_Lengkap_ok = Gelar_D_ok + vNama_Lengkap + Gelar_B_ok;
    	 	 					Form_Head_PPNS.getForm().setValues({nama_lengkap_v : Nama_Lengkap_ok});
    	 	 			}}
    	 	 		 }      	 		
      	 		},
      	 		{fieldLabel: 'Gelar Belakang', name: 'gelar_b', labelAlign: 'right', labelWidth: 100, hideLabel: false, flex:2,
    	 	 		 listeners: {
    	 	 			'change': {fn: function (check, newValue) {
    	 	 					var Gelar_D_ok = '', Gelar_B_ok = '';
    	 	 					var vGelar_D = Form_Biodata_PNS.getForm().findField('gelar_d').getValue();
    	 	 					var vGelar_B = newValue;
    	 	 					var vNama_Lengkap = Form_Biodata_PNS.getForm().findField('nama_lengkap').getValue();
    	 	 					if(vGelar_D != '')  Gelar_D_ok = vGelar_D + '. ';
    	 	 					if(vGelar_B != '')  Gelar_B_ok = ', ' + vGelar_B;
    	 	 					var Nama_Lengkap_ok = Gelar_D_ok + vNama_Lengkap + Gelar_B_ok;
    	 	 					Form_Head_PPNS.getForm().setValues({nama_lengkap_v : Nama_Lengkap_ok});
    	 	 			}}
    	 	 		 }      	 		
      	 		}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Jenjang', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{name: 'jenjang_pddk', id: 'jenjang_pddk_bio', disabled: true, margins: '0 5 0 0', flex:1}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Pendidikan', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{name: 'nama_pddk', id: 'nama_pddk_bio', disabled: true, margins: '0 5 0 0', flex:1}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tahun Lulus', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{name: 'tahun_lulus', id: 'tahun_lulus_bio', disabled: true, margins: '0 5 0 0', width:60}
     	   	 ]
    	 		},

  	 	 	 ]
  	 	 	},
  	 		{xtype: 'fieldset', title: 'Status Kepegawaian', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80},
  	 	 	 items : [
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TMT CPNS', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield',
     	   	 items: [
      	 		{fieldLabel: 'TMT CPNS', name: 'TMT_CPNS', disabled: true, margins: '0 5 0 0', width: 90},
      	 		{fieldLabel: 'Masa Kerja', name: 'masa_kerja', labelWidth: 80, labelAlign: 'right', hideLabel: false, disabled: true, width: 140}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Jenis Pegawai', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
			     	{fieldLabel: 'Jenis Pegawai', xtype: 'combobox', name: 'kode_jpeg', id: 'kode_jpeg_p_bio', hiddenName: 'kode_jpeg',
			       store: new Ext.create('Ext.data.Store', {
							fields: ['kode_jpeg','jenis_pegawai'], idProperty: 'ID_JPEG',
								proxy: new Ext.data.AjaxProxy({
									url: BASE_URL + 'combo_ref/combo_jns_pgw', actionMethods: {read:'POST'}, extraParams :{id_open: 1}
								}), autoLoad: true
							}),
			       valueField: 'kode_jpeg', displayField: 'jenis_pegawai', emptyText: 'Pilih Jenis Pegawai',
			       typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis Pegawai',
			       listeners: {
			       	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
			       	'change': {fn: function (obj, newValue) {
			       		switch(newValue){
			       			case '1': case '6':
			       				Ext.getCmp('FieldC_NIP').setFieldLabel('NIP'); Ext.getCmp('NIP_Lama_v').setFieldLabel('NIP Lama'); 
			       				Form_Posisi_d_Jab.getForm().findField('asal_instansi').hide(); break;			       				
			       			case '2': case '3': case '4': case '5':
			       				Ext.getCmp('FieldC_NIP').setFieldLabel('NIRP'); Ext.getCmp('NIP_Lama_v').setFieldLabel('NIRP Lama'); 
			       				Form_Posisi_d_Jab.getForm().findField('asal_instansi').hide(); break;
			       			case '7':			       				
			       				Ext.getCmp('FieldC_NIP').setFieldLabel('NIP'); Ext.getCmp('NIP_Lama_v').setFieldLabel('NIP Lama'); 
			       				Form_Posisi_d_Jab.getForm().findField('asal_instansi').show(); break;
			       			case '8':
			       				Ext.getCmp('FieldC_NIP').setFieldLabel('NIK'); Ext.getCmp('NIP_Lama_v').setFieldLabel('NIK Lama'); 
			       				Form_Posisi_d_Jab.getForm().findField('asal_instansi').hide(); break;
			       			default:
			       		}
			       	}, scope: this}
			       }, margins: '0 5 0 0', flex: 1
			      },
			     	{fieldLabel: 'Dupeg', xtype: 'combobox', name: 'kode_dupeg', id: 'kode_dupeg_p_bio', hiddenName: 'kode_dupeg', labelWidth: 70, labelAlign: 'right', hideLabel: false, margins: '0 5 0 0', flex: 2,
			       store: new Ext.create('Ext.data.Store', {
							fields: ['kode_dupeg','nama_dupeg'], idProperty: 'ID_Dupeg',
								proxy: new Ext.data.AjaxProxy({
									url: BASE_URL + 'combo_ref/combo_dupeg_2', actionMethods: {read:'POST'}, extraParams :{id_open: 1}
								}), autoLoad: true
							}),
			       valueField: 'kode_dupeg', displayField: 'nama_dupeg', emptyText: 'Pilih Dupeg',
			       typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Dupeg',
			       listeners: {
			       	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
			       }
			      },
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No. KarPeg', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield',
     	   	 items: [
      	 		{fieldLabel: 'No. KarPeg', name: 'no_KARPEG', margins: '0 5 0 0', flex:1},
      	 		{fieldLabel: 'No. KTP', name: 'no_KTP', labelWidth: 70, labelAlign: 'right', hideLabel: false, flex:2}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No. Askes', defaults: {hideLabel: true, labelWidth: 70}, combineErrors: false,
     	   	 defaultType: 'textfield',
     	   	 items: [
      	 		{fieldLabel: 'No. Askes', name: 'no_ASKES', margins: '0 5 0 0', flex:1},
      	 		{fieldLabel: 'No. Taspen', name: 'no_TASPEN', labelWidth: 70, labelAlign: 'right', hideLabel: false, flex:2}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'NPWP', defaults: {hideLabel: true, labelWidth: 70}, combineErrors: false,
     	   	 defaultType: 'textfield',
     	   	 items: [
      	 		{fieldLabel: 'NPWP', name: 'no_NPWP', margins: '0 5 0 0', flex:1},
      	 		{fieldLabel: 'No. KARIS', name: 'no_KARIS', id:'no_KARIS', labelWidth: 70, labelAlign: 'right', hideLabel: false, flex:2}
     	   	 ]
    	 		},
  	 	 	 ],
  	 		},
  	 		{xtype: 'fieldset', style: 'padding: 0 5px 0 5px; border-width: 0px;', defaults: {labelWidth: 80},
  	 	 	 items : [Form_Arsip_Bio]
  	 	 	}
  	 	 ]
  		}
    ]}
  ],
});

var Form_Posisi_d_Jab = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Posisi_d_Jab', url: BASE_URL + 'profil_pns/ext_insert_posisi_d_jab',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {name: 'NIP', id: 'NIP_posisi_d_jab', xtype: 'hidden'},
   {xtype: 'fieldcontainer', layout: 'hbox',
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 5px 0 0; border-width: 0px;', flex:1,
  	 	 items: [
  	 		{xtype: 'fieldset', title: 'Posisi', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 90, margins: '0 5 0 0'}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'Instansi Induk', name: 'unker_induk', value:'BADAN SAR NASIONAL', disabled: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Unit Kerja', name: 'unit_kerja', disabled: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Unit Organisasi', name: 'unit_org', disabled: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Lokasi Kerja', name: 'lokasi_kerja', readOnly: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Asal Instansi', name: 'asal_instansi', readOnly: true, anchor: '100%'},
  	 	 	 ]
  	 	 	},
  			{xtype: 'fieldset', title: 'Data Kepangkatan', style: 'padding: 0 5px 3px 5px;', defaults: {labelWidth: 120}, defaultType: 'textfield',
  	 	 	 items : [
    			{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
    	 	 	 defaultType: 'textfield', defaults: {hideLabel: true, disabled: true}, layout: 'hbox', msgTarget: 'side', anchor: '100%', 
    	 	 	 items: [
    	 			{fieldLabel: 'Pangkat', name: 'nama_pangkat_terakhir', id: 'nama_pangkat_terakhir_PJ', readOnly: true, margins: '0 5px 0 0', width: 150},
    	 			{fieldLabel: 'GolRu', name: 'nama_golru_terakhir', id: 'nama_golru_terakhir_PJ', readOnly: true, width: 50}
    	 	 	 ]
    			},
    			{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TMT & MKG', defaults: {hideLabel: true, disabled: true}, combineErrors: false,
     	 		 defaultType: 'numberfield', width: 420,
     	 		 items: [
      			{xtype: 'datefield', name: 'TMT_kpkt_terakhir', id: 'TMT_kpkt_terakhir_PJ', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, readOnly: true,  margins: '0 5 0 0', width: 90},
      			{xtype: 'label', forId: 'TMT_kpkt_terakhir_PJ', text: ',', margins: '3 15 0 0'},
      			{fieldLabel: 'MK Th', name: 'mk_th_kpkt_terakhir', id: 'mk_th_kpkt_terakhir_PJ', value: 0, minValue: 0, maxValue: 60, readOnly: true, margins: '0 3 0 0', width:35},
      			{xtype: 'label', forId: 'mk_th_kpkt_terakhir_PJ', text: 'Thn.', margins: '3 10 0 0'},
      			{fieldLabel: 'MK Bl', name: 'mk_bl_kpkt_terakhir', id: 'mk_bl_kpkt_terakhir_PJ', value: 0, minValue: 0, maxValue: 12, readOnly: true, width:35},
      			{xtype: 'label', forId: 'mk_bl_kpkt_terakhir_PJ', text: 'Bln.', margins: '3 15 0 3'}
     	 		 ]
    			},    			
    			{xtype: 'fieldcontainer', fieldLabel: 'Gaji Pokok', combineErrors: false,
    	 		 defaults: {hideLabel: true, disabled: true}, layout: 'hbox', msgTarget: 'side', width: 270, 
    	 		 items: [
      			{name: 'gapok_kpkt_terakhir', xtype: 'hidden', id: 'gapok_kpkt_terakhir_PJ',
      		 	 listeners: {change: function(obj, val){
								Form_Posisi_d_Jab.getForm().setValues({gapok_kpkt_terakhir_v1_PJ: Ext.util.Format.currency(val, 'Rp. '), gapok_kpkt_terakhir_v2_PJ: Ext.util.Format.number(val, '0')});
      		 	 }}
      			},
      			{xtype: 'textfield', name: 'gapok_kpkt_terakhir_v1_PJ', id: 'gapok_kpkt_terakhir_v1_PJ', margin: '0 2 0 0', allowBlank: true, width: 115},
       		 ]
    			},    			
  	 	 	 ]
  			},
  			{xtype: 'fieldset', title: 'Data CPNS dan PMK', style: 'padding: 0 5px 3px 5px;', defaults: {labelWidth: 120}, defaultType: 'textfield',
  	 	 	 items : [
    			{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
    	 	 	 defaultType: 'textfield', defaults: {hideLabel: true, disabled: true}, layout: 'hbox', msgTarget: 'side', anchor: '100%', 
    	 	 	 items: [
    	 			{fieldLabel: 'Pangkat', name: 'nama_pangkat_cpns', id: 'nama_pangkat_cpns_PJ', readOnly: true, margins: '0 5px 0 0', width: 150},
    	 			{fieldLabel: 'GolRu', name: 'nama_golru_cpns', id: 'nama_golru_cpns_PJ', readOnly: true, width: 50}
    	 	 	 ]
    			},
    			{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TMT & MKG CPNS', defaults: {hideLabel: true, disabled: true}, combineErrors: false,
     	 		 defaultType: 'numberfield', width: 420,
     	 		 items: [
      			{xtype: 'datefield', name: 'TMT_CPNS', id: 'TMT_CPNS_PJ', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, readOnly: true,  margins: '0 5 0 0', width: 90},
      			{xtype: 'label', forId: 'TMT_CPNS_PJ', text: ',', margins: '3 15 0 0'},
      			{fieldLabel: 'MK Th', name: 'mk_th_cpns', id: 'mk_th_cpns_PJ', value: 0, minValue: 0, maxValue: 60, margins: '0 3 0 0', readOnly: true, width:35},
      			{xtype: 'label', forId: 'mk_th_cpns_PJ', text: 'Thn.', margins: '3 10 0 0'},
      			{fieldLabel: 'MK Bl', name: 'mk_bl_cpns', id: 'mk_bl_cpns_PJ', value: 0, minValue: 0, maxValue: 12, readOnly: true, width:35},
      			{xtype: 'label', forId: 'mk_bl_cpns_PJ', text: 'Bln.', margins: '3 15 0 3'}
     	 		 ]
    			},
    			{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TMT & MK PMK', defaults: {hideLabel: true, disabled: true}, combineErrors: false,
     	 		 defaultType: 'numberfield', width: 420,
     	 		 items: [
      			{xtype: 'datefield', name: 'TMT_pmkg', id: 'TMT_pmkg_PJ', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, readOnly: true,  margins: '0 5 0 0', width: 90},
      			{xtype: 'label', forId: 'TMT_pmkg_PJ', text: ',', margins: '3 15 0 0'},
      			{fieldLabel: 'MK Th', name: 'mk_th_pmkg', id: 'mk_th_pmkg_PJ', value: 0, minValue: 0, maxValue: 60, margins: '0 3 0 0', readOnly: true, width:35},
      			{xtype: 'label', forId: 'mk_th_pmkg_PJ', text: 'Thn.', margins: '3 10 0 0'},
      			{fieldLabel: 'MK Bl', name: 'mk_bl_pmkg', id: 'mk_bl_pmkg_PJ', value: 0, minValue: 0, maxValue: 12, readOnly: true, width:35},
      			{xtype: 'label', forId: 'mk_bl_pmkg_PJ', text: 'Bln.', margins: '3 15 0 3'}
     	 		 ]
    			},
  	 	 	 ]
  			},

  	 	 ]
  	 	},
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
  	 	 items: [  	 	 	
  	 		{xtype: 'fieldset', title: 'Jabatan', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 90, margins: '0 5 0 0'}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'Jenis Jabatan', name: 'jenis_jab', disabled: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Jabatan', name: 'jab', disabled: true, anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Eselon', name: 'eselon', disabled: true, width: 175},
	    		{xtype: 'datefield', fieldLabel: 'TMT Jabatan', name: 'TMT_jab', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', disabled: true, readOnly: true, width: 185},
	    		{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Golru', combineErrors: false,
	    	 	 defaultType: 'textfield', defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', anchor: '100%', 
	    	 	 items: [
	    	 		{fieldLabel: 'Pangkat', name: 'nama_pangkat', id: 'nama_pangkat_PJ', disabled: true,  margins: '0 5px 0 0', width: 150},
	    	 		{fieldLabel: 'GolRu', name: 'nama_golru', id: 'nama_golru_PJ', disabled: true, width: 50}
	    	 	 ]
	    		},    	
    	 		{xtype: 'textfield', fieldLabel: 'Nomor SPMT', name: 'no_SPMT', anchor: '100%'},
	    		{xtype: 'datefield', fieldLabel: 'Tanggal SPMT', name: 'tgl_SPMT', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 190},
    	 		{xtype: 'textfield', fieldLabel: 'KPKN', name: 'no_KPKN', anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'KTUA', name: 'no_KTUA', anchor: '100%'},
  	 	 	 ]
  	 	 	},
  	 		{xtype: 'fieldset', title: '[Tugas Fungsional / Fungsional Tertentu]', style: 'padding: 0 5px 0 5px;', defaultType: 'textfield', defaults: {anchor: '100%', labelWidth: 130},
  	 		 items: [
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Jenis Fungsional', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{fieldLabel: 'Jenis Fungsional', name: 'jns_fung', id: 'jns_fung_biodata', disabled: true, margins: '0 5 0 0', flex:1}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Fungsional', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{fieldLabel: 'Nama Fungsional', name: 'nama_fung', id: 'nama_fung_biodata', disabled: true, margins: '0 5 0 0', flex:1}
     	   	 ]
    	 		},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Fungsional Tertentu', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield', anchor: '100%',
     	   	 items: [
      	 		{fieldLabel: 'Nama Fungsional Tertentu', name: 'nama_fung_tertentu', id: 'nama_fung_tertentu_biodata', disabled: true, margins: '0 5 0 0', flex:1}
     	   	 ]
    	 		}
    	 	 ]
  	 		},
  	 	 ]
  	 	},
  	]
   }
  ]
});

var Form_Data_Lainnya = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Data_Lainnya', url: BASE_URL + 'profil_pns/ext_insert_data_lainnya',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {name: 'NIP', id: 'NIP_data_lainnya', xtype: 'hidden'},
   {xtype: 'fieldcontainer', layout: 'hbox',
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 5px 0 0; border-width: 0px;', flex:1,
  	 	 items: [
  	 		{xtype: 'fieldset', title: 'Keterangan Badan', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80, fieldStyle: 'height: 20px;'}, 
  	 	 	 items : [
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tinggi, Berat', defaults: {hideLabel: true}, combineErrors: false,
		     	 defaultType: 'numberfield', width: 420,
		     	 items: [
		      	{fieldLabel: 'Tinggi', name: 'tinggi', id: 'tinggi', value: 0, minValue: 0, margins: '0 5 0 0', width:50},
		      	{xtype: 'label', forId: 'tinggi', text: 'cm', margins: '3 15 0 0'},
		      	{fieldLabel: 'Berat', name: 'berat', id: 'berat', value: 0, minValue: 0, width:50},
		      	{xtype: 'label', forId: 'berat', text: 'kg', margins: '3 10 0 5'},
	     	 	 	{xtype: 'combobox', fieldLabel: 'Rambut', name: 'rambut', labelWidth: 40, labelAlign: 'right', hideLabel: false, width:120,
	           store: new Ext.data.SimpleStore({data: [['Hitam'],['Putih'],['Coklat'],['Lurus'],['Ikal']], fields: ['rambut']}),
	           valueField: 'rambut', displayField: 'rambut', emptyText: 'Jenis',
	           queryMode: 'local', typeAhead: true, forceSelection: true,
	           listeners: {
	        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	         	},
		     	 ]
		    	},		    	
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Bentuk Muka',
	     	   items: [
	     	 	 	{xtype: 'combobox', fieldLabel: 'Bentuk Muka', name: 'bentuk_muka', hideLabel: true, width: 100,
	           store: new Ext.data.SimpleStore({data: [['Persegi'],['Memanjang'],['Hati'],['Bulat'],['Oval']], fields: ['bentuk_muka']}),
	           valueField: 'bentuk_muka', displayField: 'bentuk_muka', emptyText: 'Bentuk Muka',
	           queryMode: 'local', typeAhead: true, forceSelection: true, 
	           listeners: {
	         	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	           }
	          },
		     	 	{xtype: 'combobox', fieldLabel: 'Warna Kulit', name: 'warna_kulit', hideLabel: false, labelWidth: 80, labelAlign: 'right', width: 185,
		         store: new Ext.data.SimpleStore({data: [['Hitam'],['Putih'],['Sawo Matang']], fields: ['warna_kulit']}),
		         valueField: 'warna_kulit', displayField: 'warna_kulit', emptyText: 'Warna Kulit',
		         queryMode: 'local', typeAhead: true, forceSelection: true,
		         listeners: {
		        	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
		         }
		        },
	     	   ]
	    	 	},
    	 		{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Ciri-ciri Khas', defaults: {hideLabel: true}, combineErrors: false,
     	   	 defaultType: 'textfield',
     	   	 items: [
      	 		{fieldLabel: 'Ciri-ciri Khas', name: 'ciri2_khas', margins: '0 5 0 0', flex:1},
      	 		{fieldLabel: 'Cacat Tubuh', name: 'cacat_tubuh', labelWidth: 90, labelAlign: 'right', hideLabel: false, flex:2}
     	   	 ]
    	 		},
  	 	 	 ]
  	 	 	},
  	 		{xtype: 'fieldset', title: 'Kegemaran (Hobby)', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80, fieldStyle: 'height: 20px;'}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'Hobby', name: 'hobby', margins: '0 5 0 0', anchor: '100%'},
  	 	 	 ]
  	 	 	},
  	 	 ]
  	 	},
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
  	 	 items: [  	 	 	
  	 		{xtype: 'fieldset', title: 'Surat Keterangan Dokter', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'No. Surat', name: 'no_skd', anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Pejabat', name: 'pejabat_skd', anchor: '100%'},
	    		{xtype: 'datefield', fieldLabel: 'Tanggal', name: 'tgl_skd', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, width: 185},
  	 	 	 ]
  	 	 	},
  	 		{xtype: 'fieldset', title: 'Surat Bebas Narkoba', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'No. Surat', name: 'no_sbn', anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Pejabat', name: 'pejabat_sbn', anchor: '100%'},
	    		{xtype: 'datefield', fieldLabel: 'Tanggal', name: 'tgl_sbn', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, width: 185},
  	 	 	 ]
  	 	 	},
  	 		{xtype: 'fieldset', title: 'Surat Keterangan Catatan Kepolisian (SKCK)', style: 'padding: 0 5px 0 5px;', defaults: {labelWidth: 80}, 
  	 	 	 items : [
    	 		{xtype: 'textfield', fieldLabel: 'No. Surat', name: 'no_skck', anchor: '100%'},
    	 		{xtype: 'textfield', fieldLabel: 'Pejabat', name: 'pejabat_skck', anchor: '100%'},
	    		{xtype: 'datefield', fieldLabel: 'Tanggal', name: 'tgl_skck', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, width: 185},
  	 	 	 ]
  	 	 	},
  	 	 ]
  	 	},
  	]
   }
  ]
});

var Btn_Biodata = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
  	{text: 'Tambah', id: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Biodata();}, tooltip: {text: 'Tambah Pegawai'}},
  	{text: 'Ubah', id: 'Ubah', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Biodata();}},
  	{text: 'Simpan', id: 'Simpan', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Biodata();}},
  	{text: 'Batal', id: 'Batal', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Biodata();}}
	]
});

// TAB DATA UTAMA ------------------------------------------------------------ START
var Tab1_Data_Pribadi = {
	id: 'Tab1_Data_Pribadi', title: 'Data Pribadi', border: false, collapsible: false,
	layout: 'fit', items: [Form_Biodata_PNS]
};

var Tab2_Posisi_d_Jab = {
	id: 'Tab2_Posisi_d_Jab', title: 'Posisi & Jabatan', border: false, collapsible: false,
	layout: 'fit', items: [Form_Posisi_d_Jab]
};

var Tab3_Data_Lainnya = {
	id: 'Tab3_Data_Lainnya', title: 'Data Lainnya', border: false, collapsible: false,
	layout: 'fit', items: [Form_Data_Lainnya]
};

var MainTab_Biodata = new Ext.createWidget('tabpanel', {
	id: 'MainTab_Biodata', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false, defaults: {autoScroll:true},
  items: [Tab1_Data_Pribadi, Tab2_Posisi_d_Jab, Tab3_Data_Lainnya],
  bbar: Btn_Biodata,
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		title_active_tab_profil = tab.title;
  	}
  }
});
// TAB DATA UTAMA ------------------------------------------------------------ END

function Profil_PNS_Tambah_Biodata(){
	Ext.MessageBox.prompt('NIP/NIRP/NIK', 'Masukkan NIP/NIRP/NIK:', function(btn, text){
  	if (btn == 'ok'){
			Ext.Ajax.request({
  			url: BASE_URL + 'profil_pns/check_nip',
    		method: 'POST', params: {id_open: 1, NIP_Cari:text}, scripts: true, renderer: 'data',
    		success: function(response){
    			if(response.responseText == 'ADA'){
    				Ext.MessageBox.show({title:'Peringatan !', msg:'NIP/NIRP/NIK yang Anda masukkan sudah terdaftar !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
    			}else{
						Ext.MessageBox.prompt('NIP Lama', 'Masukkan NIP Lama:', function(btn, text_lama){							
    					Active_Form_Biodata_PNS();
						Profil_PNS_Reset_Biodata();
    					Form_Biodata_PNS.getForm().setValues({NIP:text, NIP_Lama:text_lama, gol_darah:'-', kode_jpeg: 1, kode_dupeg:1});
    					Form_Head_PPNS.getForm().setValues({NIP_v:text, NIP_Lama_v:text_lama}); 
    					Ext.getCmp('nama_lengkap').focus(false, 200);
						});
    			}
    		},
    		failure: function(response){Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});}, 
    		scope : this
			});
  	}
	});	
}

function Profil_PNS_Ubah_Biodata(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();	
	if(vNIP){
		vcbp_bio_jk_last = Form_Biodata_PNS.getForm().findField('jenis_kelamin').getValue();
		vcbp_bio_gd_last = Form_Biodata_PNS.getForm().findField('gol_darah').getValue();
		vcbp_bio_agama_last = Form_Biodata_PNS.getForm().findField('agama').getValue();
		vcbp_bio_wn_last = Form_Biodata_PNS.getForm().findField('warga_negara').getValue();
		vcbp_bio_skawin_last = Form_Biodata_PNS.getForm().findField('status_kawin').getValue();
		
		vcbp_kode_prov_last = Form_Biodata_PNS.getForm().findField('kode_prov').getValue();
		vcbp_kode_kabkota_last = Form_Biodata_PNS.getForm().findField('kode_kabkota').getValue();
		vcbp_kode_kec_last = Form_Biodata_PNS.getForm().findField('kode_kec').getValue();
		vcbp_jns_pgw_last = Form_Biodata_PNS.getForm().findField('kode_jpeg').getValue();
		
		P_Biodata_last_record = Form_Biodata_PNS.getForm().getValues();
		P_Posisi_d_Jab_last_record = Form_Posisi_d_Jab.getForm().getValues();
		P_Data_Lainnya_last_record = Form_Data_Lainnya.getForm().getValues();

		vcbp_rambut_last = Form_Data_Lainnya.getForm().findField('rambut').getValue();
		vcbp_bentuk_muka_last = Form_Data_Lainnya.getForm().findField('bentuk_muka').getValue();
		vcbp_warna_kulit_last = Form_Data_Lainnya.getForm().findField('warna_kulit').getValue();

		Active_Form_Biodata_PNS();
		Active_Form_Posisi_d_Jab();
		Active_Form_Data_Lainnya();
	}
}

function Profil_PNS_Simpan_Biodata(){
	if(title_active_tab_profil == 'Data Pribadi'){
		ID_Form_Profil_Pegawai = 'Form_Biodata_PNS';
	}else if(title_active_tab_profil == 'Posisi & Jabatan'){
		ID_Form_Profil_Pegawai = 'Form_Posisi_d_Jab';
	}else{
		ID_Form_Profil_Pegawai = 'Form_Data_Lainnya';
	}
	Cur_Form_Profil_Pegawai = window[ID_Form_Profil_Pegawai];

	Ext.getCmp(ID_Form_Profil_Pegawai).on({
  	beforeaction: function() {Ext.getCmp(ID_Form_Profil_Pegawai).body.mask();}
  });

  Cur_Form_Profil_Pegawai.getForm().submit({            			
  	success: function(){
  		Ext.getCmp(ID_Form_Profil_Pegawai).body.unmask(); 
  		Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menyimpan data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		
  		Deactive_Form_Biodata_PNS();
	    Deactive_Form_Posisi_d_Jab();
	    Deactive_Form_Data_Lainnya();
  		
  		All_Button_Enabled();
  		Ext.getCmp('biodata_menu').setDisabled(true);
  		if(Data_Profil_PNS){Data_Profil_PNS.load();}
  		
  		if(title_active_tab_profil == 'Data Pribadi'){
				kode_jpeg_profil = Form_Biodata_PNS.getForm().findField('kode_jpeg').getValue();
				Data_CB_Golru.changeParams({params: {id_open:1, kode_jpeg: kode_jpeg_profil}});
				var ID_Pegawai = Form_Biodata_PNS.getForm().findField('ID_Pegawai').getValue();
				if(ID_Pegawai){Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());}
			}
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Biodata_PNS').body.unmask();
      if (action.failureType == 'server') {
      	obj = Ext.decode(action.response.responseText);
        Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
      }else{
      	if (typeof(action.response) == 'undefined') {
        	Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan isi dengan benar !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
        }else{
        	Ext.MessageBox.show({title:'Peringatan !', msg: 'Server tidak dapat dihubungi !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
        }
      }
    }
  });
}

function Profil_PNS_Cetak(vID_PGW){
	if(vID_PGW){
    var data = vID_PGW + ';';
		var docprint = new Ext.create('Ext.window.Window', {
			title: 'Cetak Profil Pegawai', iconCls: 'icon-printer', constrainHeader : true, closable: true, maximizable: true, width: '98%', height: '98%', bodyStyle: 'padding: 5px;', modal : true,
			items: [{
				xtype:'tabpanel', activeTab : 0,width: '100%', height: '100%',
      	items: [{
      		title: 'Preview', frame: false, collapsible: true, autoScroll: true, iconCls: 'icon-pdf',
      		items: [{
      			xtype : 'miframe', frame: false, height: '100%', noCache: true,
      			src : BASE_URL + 'profil_pns/cetak_profil/' + data
        	}]
      	}]
			}]
		}).show();
  }
}

function Profil_PNS_Batal_Biodata(){
	if(Form_Biodata_PNS.getForm().findField('ID_Pegawai').getValue()){
		Form_Biodata_PNS.getForm().setValues(P_Biodata_last_record);
		Form_Biodata_PNS.getForm().setValues({
			jenis_kelamin:vcbp_bio_jk_last,
			gol_darah:vcbp_bio_gd_last,
			agama:vcbp_bio_agama_last,
			warga_negara:vcbp_bio_wn_last,
			status_kawin:vcbp_bio_skawin_last,
			kode_prov:vcbp_kode_prov_last,
			kode_kabkota:vcbp_kode_kabkota_last,
			kode_kec:vcbp_kode_kec_last,
			kode_jpeg:vcbp_jns_pgw_last
		});
		Form_Posisi_d_Jab.getForm().setValues(P_Posisi_d_Jab_last_record);
		Form_Data_Lainnya.getForm().setValues(P_Data_Lainnya_last_record);

		Form_Data_Lainnya.getForm().setValues({
			rambut:vcbp_rambut_last,
			bentuk_muka:vcbp_bentuk_muka_last,
			warna_kulit:vcbp_warna_kulit_last
		});

		Deactive_Form_Biodata_PNS();
    Deactive_Form_Posisi_d_Jab();
    Deactive_Form_Data_Lainnya();
		Form_Upload_Photo.hide();
	}else{
		win_popup_Profil_PNS.close();
	}
}

function Profil_PNS_Reset_Biodata(){
	Active_Form_Biodata_PNS();
	Form_Head_PPNS.getForm().reset();
	Form_Biodata_PNS.getForm().reset();
	Form_Posisi_d_Jab.getForm().reset();
  Form_Data_Lainnya.getForm().reset();
	photo_pns.el.dom.src = photo_default + '?dc=' + new Date().getTime();
	Form_Upload_Photo.hide();
	All_Button_Disabled();
}

function Active_Form_Biodata_PNS(){
	Ext.getCmp('Tambah').setDisabled(true);
	Ext.getCmp('Ubah').setDisabled(true);
	Ext.getCmp('Simpan').setDisabled(false);
	Ext.getCmp('Batal').setDisabled(false);

	Form_Biodata_PNS.getForm().findField('nama_lengkap').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('gelar_d').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('gelar_b').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('tempat_lahir').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('tanggal_lahir').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('jenis_kelamin').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('gol_darah').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('suku').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('agama').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('warga_negara').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('status_kawin').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('no_KTP').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('no_NPWP').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('no_KARIS').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('no_KARPEG').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('no_ASKES').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('no_TASPEN').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('kode_jpeg').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('kode_dupeg').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('alamat').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('desa').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('kode_kec').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('kode_kabkota').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('kode_prov').setDisabled(false);
	Form_Biodata_PNS.getForm().findField('kodepos').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('telp').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('fax').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('hp').setReadOnly(false);
	Form_Biodata_PNS.getForm().findField('email').setReadOnly(false);
	
	Special_Locked_Biodata();
	Form_Upload_Photo.show();	
	Form_Arsip_Bio.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Bio').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Bio').setDisabled(false);
	}
}

function Deactive_Form_Biodata_PNS(){
	Ext.getCmp('Tambah').setDisabled(false);
	Ext.getCmp('Ubah').setDisabled(false);
	Ext.getCmp('Simpan').setDisabled(true);
	Ext.getCmp('Batal').setDisabled(true);

	Form_Biodata_PNS.getForm().findField('nama_lengkap').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('gelar_d').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('gelar_b').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('tempat_lahir').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('tanggal_lahir').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('jenis_kelamin').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('gol_darah').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('suku').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('agama').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('warga_negara').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('status_kawin').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('no_KTP').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('no_NPWP').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('no_KARIS').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('no_KARPEG').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('no_ASKES').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('no_TASPEN').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('kode_jpeg').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('kode_dupeg').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('alamat').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('desa').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('kode_kec').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('kode_kabkota').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('kode_prov').setDisabled(true);
	Form_Biodata_PNS.getForm().findField('kodepos').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('telp').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('fax').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('hp').setReadOnly(true);
	Form_Biodata_PNS.getForm().findField('email').setReadOnly(true);	
	
	Form_Upload_Photo.hide();
	Form_Arsip_Bio.getForm().findField('filearsip').setDisabled(true);
	Set_Arsip_Bio();
	Ext.getCmp('Btn_Hapus_Arsip_Bio').setDisabled(true);
}

function Active_Form_Posisi_d_Jab(){
	Form_Posisi_d_Jab.getForm().findField('lokasi_kerja').setReadOnly(false);
	Form_Posisi_d_Jab.getForm().findField('asal_instansi').setReadOnly(false);
	Form_Posisi_d_Jab.getForm().findField('no_SPMT').setReadOnly(false);
	Form_Posisi_d_Jab.getForm().findField('tgl_SPMT').setReadOnly(false);
	Form_Posisi_d_Jab.getForm().findField('no_KPKN').setReadOnly(false);
	Form_Posisi_d_Jab.getForm().findField('no_KTUA').setReadOnly(false);
}

function Deactive_Form_Posisi_d_Jab(){
	Form_Posisi_d_Jab.getForm().findField('lokasi_kerja').setReadOnly(true);
	Form_Posisi_d_Jab.getForm().findField('asal_instansi').setReadOnly(true);
	Form_Posisi_d_Jab.getForm().findField('no_SPMT').setReadOnly(true);
	Form_Posisi_d_Jab.getForm().findField('tgl_SPMT').setReadOnly(true);
	Form_Posisi_d_Jab.getForm().findField('no_KPKN').setReadOnly(true);
	Form_Posisi_d_Jab.getForm().findField('no_KTUA').setReadOnly(true);
}

function Active_Form_Data_Lainnya(){
	Form_Data_Lainnya.getForm().findField('tinggi').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('berat').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('rambut').setDisabled(false);
	Form_Data_Lainnya.getForm().findField('bentuk_muka').setDisabled(false);
	Form_Data_Lainnya.getForm().findField('warna_kulit').setDisabled(false);
	Form_Data_Lainnya.getForm().findField('ciri2_khas').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('cacat_tubuh').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('hobby').setReadOnly(false);

	Form_Data_Lainnya.getForm().findField('no_skd').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('pejabat_skd').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('tgl_skd').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('no_sbn').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('pejabat_sbn').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('tgl_sbn').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('no_skck').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('pejabat_skck').setReadOnly(false);
	Form_Data_Lainnya.getForm().findField('tgl_skck').setReadOnly(false);
}

function Deactive_Form_Data_Lainnya(){
	Form_Data_Lainnya.getForm().findField('tinggi').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('berat').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('rambut').setDisabled(true);
	Form_Data_Lainnya.getForm().findField('bentuk_muka').setDisabled(true);
	Form_Data_Lainnya.getForm().findField('warna_kulit').setDisabled(true);
	Form_Data_Lainnya.getForm().findField('ciri2_khas').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('cacat_tubuh').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('hobby').setReadOnly(true);

	Form_Data_Lainnya.getForm().findField('no_skd').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('pejabat_skd').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('tgl_skd').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('no_sbn').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('pejabat_sbn').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('tgl_sbn').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('no_skck').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('pejabat_skck').setReadOnly(true);
	Form_Data_Lainnya.getForm().findField('tgl_skck').setReadOnly(true);
}

function Special_Locked_Biodata(){
	if(sesi_type == 'OPD'){
		Form_Biodata_PNS.getForm().findField('nama_lengkap').setReadOnly(true);
		Form_Biodata_PNS.getForm().findField('gelar_d').setReadOnly(true);
		Form_Biodata_PNS.getForm().findField('gelar_b').setReadOnly(true);
		Form_Biodata_PNS.getForm().findField('tanggal_lahir').setReadOnly(true);		
	}
}

function Profil_PNS_CariNIP (NIP_Cari){
	if(NIP_Cari){
		Ext.Ajax.request({
  		url: BASE_URL + 'profil_pns/check_nip',
    	method: 'POST', params: {id_open: 1, NIP_Cari:NIP_Cari}, renderer: 'data',
    	success: function(response){return true;},
    	failure: function(response){return false;},
    	callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
    	scope : this
		});
	}
}

function set_head_info(vNIP){
  if(vNIP){
		Ext.Ajax.request({
  		url: BASE_URL + 'profil_pns/head_data',
    	method: 'POST', params: {id_open: 1,NIP:vNIP}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
    			var value_form_head = {
    				NIP_v: obj.results.NIP,
    				NIP_Lama_v: obj.results.NIP_Lama,
    				nama_lengkap_v: obj.results.f_namalengkap,
    				pangkat_golru_v: obj.results.nama_pangkat + ', ' + obj.results.nama_golru,
    				nama_jab_v: obj.results.nama_jab,
    				nama_unker_v: obj.results.nama_unker,
    				nama_unor_v: obj.results.nama_unor
    			};
    			Form_Head_PPNS.getForm().setValues(value_form_head);
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	scope : this
		});		
	}
}

// FORM BIODATA PNS  --------------------------------------------------------- END

// PANEL POPUP PROFIL PNS  --------------------------------------------------------- START
var Vert_Menu_Profil_PNS = [
	{text : 'Data Utama', id: 'biodata_menu', iconCls: 'icon-user', disabled: true,
		handler: function(){Load_Page_PPNS('biodata_menu','biodata_page', BASE_URL + 'profil_pns/biodata_page');}},
	{text : 'Pendidikan Formal', id: 'pendidikan_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('pendidikan_menu','pendidikan_page', BASE_URL + 'profil_pns/pendidikan_page');}},
	{text : 'Kepangkatan', id: 'kepangkatan_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('kepangkatan_menu','kepangkatan_page', BASE_URL + 'profil_pns/kepangkatan_page');}},
	{text : 'Jabatan', id: 'jabatan_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('jabatan_menu','jabatan_page', BASE_URL + 'profil_pns/jabatan_page');}},'-',
	{text : 'Keluarga', id: 'keluarga_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('keluarga_menu','keluarga_page', BASE_URL + 'profil_pns/keluarga_page', 'setValue_Form_Keluarga_PNS');}},
	{text : 'Kursus', id: 'pddk_nf_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('pddk_nf_menu','pddk_nf_page', BASE_URL + 'profil_pns/pddk_nf_page');}},
	{text : 'Organisasi', id: 'organisasi_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('organisasi_menu','organisasi_page', BASE_URL + 'profil_pns/organisasi_page');}},
	{text : 'Diklat Kedinasan', id: 'diklat_kedinasan_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('diklat_kedinasan_menu','diklat_kedinasan_page', BASE_URL + 'profil_pns/diklat_kedinasan_page');}},
	{text : 'DP3', id: 'dp3_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('dp3_menu','dp3_page', BASE_URL + 'profil_pns/dp3_page');}},
	{text : 'Angka Kredit', id: 'ak_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('ak_menu','ak_page', BASE_URL + 'profil_pns/ak_page');}},
	{text : 'Gaji Berkala', id: 'gaji_berkala_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('gaji_berkala_menu','gaji_berkala_page', BASE_URL + 'profil_pns/gaji_berkala_page');}},
	{text : 'Tunjangan Resiko', id: 'tunjangan_resiko_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('tunjangan_resiko_menu','tunjangan_resiko_page', BASE_URL + 'profil_pns/tunjangan_resiko_page');}},
	{text : 'Penghargaan', id: 'penghargaan_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('penghargaan_menu','penghargaan_page', BASE_URL + 'profil_pns/penghargaan_page');}},
	{text : 'Disiplin Pegawai', id: 'disiplin_kepegawaian_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('disiplin_kepegawaian_menu','disiplin_kepegawaian_page', BASE_URL + 'profil_pns/disiplin_kepegawaian_page');}},
	{text : 'Pengalaman Luar Negeri', id: 'pengalaman_kln_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('pengalaman_kln_menu','pengalaman_kln_page', BASE_URL + 'profil_pns/pengalaman_kln_page');}},
	{text : 'Seminar', id: 'seminar_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('seminar_menu','seminar_page', BASE_URL + 'profil_pns/seminar_page');}},
	{text : 'Karya Tulis', id: 'karya_tulis_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('karya_tulis_menu','karya_tulis_page', BASE_URL + 'profil_pns/karya_tulis_page');}},
	{text : 'Karir Sebelum PNS', id: 'karir_sebelum_pns_menu', iconCls: 'icon-user',
		handler: function(){Load_Page_PPNS('karir_sebelum_pns_menu','karir_sebelum_pns_page', BASE_URL + 'profil_pns/karir_sebelum_pns_page');}},
	{text : 'Cetak Profil', id: 'cetak_profil_pns_menu', disabled: ppns_print, iconCls: 'icon-printer',
		handler: function(){Profil_PNS_Cetak(Form_Biodata_PNS.getForm().findField('ID_Pegawai').getValue());}},
	{text : 'Tutup', id: 'tutup_profil_pns_menu', iconCls: 'icon-cross',
		handler: function(){win_popup_Profil_PNS.close();}}
];

var panel_popup_PPNS = [
	{region: 'north', height: 135, split: false, collapsible: false, floatable: false, border: false,
   items: [Header_Profil_PNS]
  },{
   id: 'West_Popup_PPNS', region: 'west', title: 'DATA PROFIL', width: '16%', minWidth: 100, height: 400, split: true, collapsible: true, animCollapse: true, autoScroll: true,
   dockedItems: [{
  	xtype: 'toolbar', dock: 'left', width: '99.3%', height: 380, defaults: {textAlign: 'left', toggle: true}, enableOverflow: false, style: 'padding: 0 0 0 0; border-width: 1px;',
  	items: Vert_Menu_Profil_PNS
   }]
  },{
   id: 'Center_Popup_PPNS', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '84%', border: false,
   items: [MainTab_Biodata]
  }
];

var win_popup_Profil_PNS = new Ext.create('widget.window', {
   id: 'profil_pns_popup', title: 'Profil Pegawai', iconCls: 'icon-human',
   closable: true, width: '95%', height: '99%', modal:true,
   layout: 'border', bodyStyle: 'padding: 5px;',
   items: panel_popup_PPNS
});
// PANEL POPUP PROFIL PNS  -------------------------------------------- END

function All_Button_Disabled(){
	Ext.getCmp('biodata_menu').setDisabled(false);
	Ext.getCmp('keluarga_menu').setDisabled(true);
	Ext.getCmp('pendidikan_menu').setDisabled(true);
	Ext.getCmp('pddk_nf_menu').setDisabled(true);
	Ext.getCmp('kepangkatan_menu').setDisabled(true);
	Ext.getCmp('jabatan_menu').setDisabled(true);
	Ext.getCmp('diklat_kedinasan_menu').setDisabled(true);
	Ext.getCmp('dp3_menu').setDisabled(true);
	Ext.getCmp('ak_menu').setDisabled(true);
	Ext.getCmp('gaji_berkala_menu').setDisabled(true);
	Ext.getCmp('tunjangan_resiko_menu').setDisabled(true);	
	Ext.getCmp('penghargaan_menu').setDisabled(true);
	Ext.getCmp('disiplin_kepegawaian_menu').setDisabled(true);
	Ext.getCmp('pengalaman_kln_menu').setDisabled(true);
	Ext.getCmp('seminar_menu').setDisabled(true);
	Ext.getCmp('karya_tulis_menu').setDisabled(true);
	Ext.getCmp('organisasi_menu').setDisabled(true);
	Ext.getCmp('karir_sebelum_pns_menu').setDisabled(true);
	Ext.getCmp('cetak_profil_pns_menu').setDisabled(true);
}

function All_Button_Enabled(){
	Ext.getCmp('biodata_menu').setDisabled(false);
	Ext.getCmp('keluarga_menu').setDisabled(false);
	Ext.getCmp('pendidikan_menu').setDisabled(false);
	Ext.getCmp('pddk_nf_menu').setDisabled(false);
	Ext.getCmp('kepangkatan_menu').setDisabled(false);
	Ext.getCmp('jabatan_menu').setDisabled(false);
	Ext.getCmp('diklat_kedinasan_menu').setDisabled(false);
	Ext.getCmp('dp3_menu').setDisabled(false);
	Ext.getCmp('ak_menu').setDisabled(false);
	Ext.getCmp('gaji_berkala_menu').setDisabled(false);
	Ext.getCmp('tunjangan_resiko_menu').setDisabled(false);
	Ext.getCmp('penghargaan_menu').setDisabled(false);
	Ext.getCmp('disiplin_kepegawaian_menu').setDisabled(false);
	Ext.getCmp('pengalaman_kln_menu').setDisabled(false);
	Ext.getCmp('seminar_menu').setDisabled(false);
	Ext.getCmp('karya_tulis_menu').setDisabled(false);
	Ext.getCmp('organisasi_menu').setDisabled(false);
	Ext.getCmp('karir_sebelum_pns_menu').setDisabled(false);
	Ext.getCmp('cetak_profil_pns_menu').setDisabled(false);
}

function setValue_Form_PPNS(profil_id){
	switch(profil_id){
		case 'keluarga_page':
  		Deactive_Form_Keluarga_PNS();
  		setValue_Form_Keluarga_PNS();
  		break;
		case 'pendidikan_page':
  		Deactive_Form_Pendidikan_PNS();
  		setValue_Form_Pendidikan_PNS();
  		break;
		case 'pddk_nf_page':
  		Deactive_Form_Pddk_NF_PNS();
  		setValue_Form_Pddk_NF_PNS();
  		break;
		case 'kepangkatan_page':
  		Deactive_Form_Kepangkatan_PNS();
  		setValue_Form_Kepangkatan_PNS();
  		break;
		case 'jabatan_page':
  		Deactive_Form_Jabatan_PNS();
  		setValue_Form_Jabatan_PNS();
  		break;
		case 'diklat_kedinasan_page':
  		Deactive_Form_Diklat_PNS();
  		setValue_Form_Diklat_Kedinasan_PNS();
  		break;
		case 'dp3_page':
  		Deactive_Form_DP3_PNS();
  		setValue_Form_DP3_PNS();
  		break;
		case 'ak_page':
  		Deactive_Form_AK_PNS();
  		setValue_Form_AK_PNS();
  		break;
		case 'gaji_berkala_page':
  		Deactive_Form_KGB_PNS();
  		setValue_Form_KGB_PNS();
  		break;
		case 'tunjangan_resiko_page':
  		Deactive_Form_TR_PNS();
  		setValue_Form_TR_PNS();
  		break;
		case 'penghargaan_page':
  		Deactive_Form_Reward_PNS();
  		setValue_Form_Reward_PNS();
  		break;
		case 'disiplin_kepegawaian_page':
  		Deactive_Form_HukDis_PNS();
  		setValue_Form_HukDis_PNS();
  		break;
		case 'pengalaman_kln_page':
  		Deactive_Form_PKLN_PNS();
  		setValue_Form_PKLN_PNS();
  		break;
		case 'seminar_page':
  		Deactive_Form_Seminar_PNS();
  		setValue_Form_Seminar_PNS();
  		break;
		case 'karya_tulis_page':
  		Deactive_Form_KT_PNS();
  		setValue_Form_Karya_Tulis_PNS();
  		break;
		case 'organisasi_page':
  		Deactive_Form_Org_PNS();
  		setValue_Form_Organisasi_PNS();
  		break;
		case 'karir_sebelum_pns_page':
  		Deactive_Form_KSPNS_PNS();
  		setValue_Form_KSPNS_PNS();
  		break;
		default:
			Deactive_Form_Biodata_PNS();	
			Deactive_Form_Posisi_d_Jab();
			Deactive_Form_Data_Lainnya();	
	}
}

function Load_Page_PPNS(menu_id, profil_id, profil_url){
	Ext.getCmp('Center_Popup_PPNS').body.mask("Loading...", "x-mask-loading");	
	var new_profil_id = Ext.getCmp(profil_id);
	if(new_profil_id){
		All_Button_Enabled(); Ext.getCmp(menu_id).setDisabled(true);
  	Ext.getCmp('Center_Popup_PPNS').getLayout().setActiveItem(new_profil_id);
  	Ext.getCmp('Center_Popup_PPNS').doLayout();	
  	setValue_Form_PPNS(profil_id);
		Ext.getCmp('Center_Popup_PPNS').body.unmask();
	}else{
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: profil_url, method: 'POST', params: {id_open: 1}, scripts: true, 
    	success: function(response){
    		var jsonData = response.responseText; var aHeadNode = document.getElementsByTagName('head')[0]; var aScript = document.createElement('script'); aScript.text = jsonData; aHeadNode.appendChild(aScript);
    		if(new_panel_PPNS != "GAGAL"){
    			All_Button_Enabled(); Ext.getCmp(menu_id).setDisabled(true);
    			Ext.getCmp('Center_Popup_PPNS').add(new_panel_PPNS);
    			Ext.getCmp('Center_Popup_PPNS').getLayout().setActiveItem(new_panel_PPNS);
    			Ext.getCmp('Center_Popup_PPNS').doLayout();
    			setValue_Form_PPNS(profil_id);    			
    		}else{
    			Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
    		}
   		},
    	failure: function(response){Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	callback: function(response){ Ext.getCmp('Center_Popup_PPNS').body.unmask(); },
    	scope : this
		});		
	}
}

win_popup_Profil_PNS.on('close', function() {
  switch(Txt_Form_Caller_Pegawai){
  	// START - LAYANAN
  	case 'Form_IMPG': Cari_Pegawai('Form_IMPG', 3); break;
  	case 'Form_T_KGB': Cari_Pegawai('Form_T_KGB', 4); break;
  	case 'Form_KP': Cari_Pegawai('Form_KP', 5); break;
  	case 'Form_SK_Pensiun': Cari_Pegawai('Form_SK_Pensiun', 6); break;
  	case 'Form_T_IB': Cari_Pegawai('Form_T_IB', 1); break;
  	case 'Form_T_UD': Cari_Pegawai('Form_T_UD', 1); break;
  	case 'Form_T_SL': Cari_Pegawai('Form_T_SL', 2); break;
  	case 'Form_T_Cuti': Cari_Pegawai('Form_T_Cuti', 1); break;
  	case 'Form_T_Taperum': Cari_Pegawai('Form_T_Taperum', 7); break;
  	case 'Form_T_SK_RIKES': Cari_Pegawai('Form_T_SK_RIKES', 1); break;
  	case 'Form_T_DC': Cari_Pegawai('Form_T_DC', 1); break;
  	case 'Form_T_KKK': Cari_Pegawai('Form_T_KKK', 1); break;
  	// END - LAYANAN

  	// START - KEPEGAWAIAN
  	case 'Form_T_SK_PNS': Cari_Pegawai('Form_T_SK_PNS', 8); break;
  	case 'Form_PMKG': Cari_Pegawai('Form_PMKG', 9); break;
  	case 'Form_T_SK_MPP': Cari_Pegawai('Form_T_SK_MPP', 1); break;
  	case 'Form_Mutasi_Keluar': Cari_Pegawai('Form_Mutasi_Keluar', 1); break;
  	case 'Form_Surat_Tugas': Cari_Pegawai('Form_Surat_Tugas', 1); break;
  	case 'Form_T_HukDis': Cari_Pegawai('Form_T_HukDis', 1); break;
  	case 'Form_T_DP3': Cari_Pegawai('Form_T_DP3', 1); break;
  	// END - KEPEGAWAIAN

  	// START - DIKLAT
  	case 'Form_T_PraJab': Cari_Pegawai('Form_T_PraJab', 1); break;
  	case 'Form_T_D_PIM': Cari_Pegawai('Form_T_D_PIM', 1); break;
  	case 'Form_T_TB': Cari_Pegawai('Form_T_TB', 1); break;
  	case 'Form_T_Pddk': Cari_Pegawai('Form_T_Pddk', 1); break;
  	// END - DIKLAT
  	default:
  }
});

<?php }else{ echo "var new_panel_popup_PPNS = 'GAGAL';"; } ?>