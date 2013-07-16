<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Pddk_last_record, vcbp_pddk_status_institusi;

// TABEL PENDIDIKAN PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Pddk', {extend: 'Ext.data.Model',
  	fields: ['IDP_Pddk', 'NIP', 'kode_pddk', 'nama_pddk', 'jurusan', 'nama_institusi', 'akreditas_institusi', 'status_institusi', 'alamat_institusi', 'tahun_masuk', 'tahun_lulus', 'no_ijazah', 'tgl_ijazah', 'rata2_ijazah', 'kepala_institusi', 'ket_pend', 'gelar_d', 'gelar_b']
});

var Reader_Profil_PNS_Pddk = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Pddk', root: 'results', totalProperty: 'total', idProperty: 'IDP_Pddk'  	
});

var Proxy_Profil_PNS_Pddk = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_pendidikan', actionMethods: {read:'POST'},
    reader: Reader_Profil_PNS_Pddk
});

var Data_Profil_PNS_Pddk = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Pddk', model: 'MProfil_PNS_Pddk', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Pddk
});

var tbProfil_PNS_Pddk = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Pddk},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Pddk', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Pddk.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Pddk();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Pddk}
  ]
});

var cbGrid_Profil_PNS_Pddk = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Pddk = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Pddk', store: Data_Profil_PNS_Pddk,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Pddk, columnLines: true, loadMask: true,
	columns: [
  	{header: "Pendidikan", dataIndex: 'nama_pddk', width: 150},
  	{header: "Bidan / Jurusan", dataIndex: 'jurusan', width: 150},
  	{header: "Sekolah / Kampus", dataIndex: 'nama_institusi', width: 180},
  	{header: "Status", dataIndex: 'status_institusi', width: 75},
  	{header: "Akreditas", dataIndex: 'akreditas_institusi', width: 75},
  	{header: "Alamat Sekolah", dataIndex: 'alamat_institusi', width: 200},
  	{header: "Tgl. STTB", dataIndex: 'tgl_ijazah', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tahun Masuk", dataIndex: 'tahun_masuk', width: 80},
  	{header: "Tahun Lulus", dataIndex: 'tahun_lulus', width: 80},
  	{header: "IPK / NEM", dataIndex: 'rata2_ijazah', width: 80},
  	{header: "Nama Kepala", dataIndex: 'kepala_institusi', width: 80},
  	{header: "Gelar Depan", dataIndex: 'gelar_d', width: 80},
  	{header: "Gelar Belakang", dataIndex: 'gelar_b', width: 100}
  ],
  tbar: tbProfil_PNS_Pddk,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_Pddk, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Pendidikan_PNS.getForm().loadRecord(records[0]);
      	Form_Arsip_Pddk.getForm().loadRecord(records[0]);
      	Set_Arsip_Pddk();
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('pendidikan_page').setActiveTab('Tab2_Pendidikan_PNS');
  		Set_Arsip_Pddk();
  	}    
  }
});
// TABEL PENDIDIKAN PNS  ------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Pddk = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Pddk', url: BASE_URL + 'upload_arsip/insert_arsip/pendidikan', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Pddk'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Pddk', value: 2},
		{xtype: 'hidden', name: 'IDP_Pddk', id: 'IDP_Pddk_Arsip_Pddk'},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Pddk', emptyText: 'Upload Files', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Pddk.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						var p_IDP_Pddk = Form_Pendidikan_PNS.getForm().findField('IDP_Pddk').getValue();
						Form_Arsip_Pddk.getForm().setValues({NIP: p_NIP, IDP_Pddk: p_IDP_Pddk});
			 			Form_Arsip_Pddk.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Set_Arsip_Pddk(); Deactive_Form_Pendidikan_PNS();
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
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Pddk', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Pddk();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Pddk', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Pddk();}},
		 ]
		}
	]
});

function Set_Arsip_Pddk(){Set_Arsip_Digital('Form_Pendidikan_PNS', 'Btn_Download_Arsip_Pddk', 'IDP_Pddk', 2, 'pendidikan');}
function Reset_Arsip_Pddk(){Reset_Arsip_Digital('Form_Pendidikan_PNS', 'Btn_Download_Arsip_Pddk', 'IDP_Pddk', 2, 'pendidikan'); Deactive_Form_Pendidikan_PNS();}
function Download_Arsip_Pddk(){Download_Arsip_Digital('Form_Pendidikan_PNS', 'IDP_Pddk', 2, 'pendidikan');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM PENDIDIKAN PNS  --------------------------------------------------------- START
var Form_Pendidikan_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Pendidikan_PNS', url: BASE_URL + 'profil_pns/ext_insert_pendidikan',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 150},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Pendidikan', defaultType: 'textfield', defaults: {labelWidth: 120, labelAlign: 'left'}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			    {name: 'IDP_Pddk', xtype: 'hidden'}, 
			    {name: 'NIP', id: 'NIP_Pddk', xtype: 'hidden'},
			    {xtype: 'fieldcontainer', fieldLabel: 'Nama Pendidikan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', anchor: '100%', 
			     items: [
			     		{name: 'kode_pddk', xtype: 'hidden'},
			     		{xtype: 'textfield', name: 'nama_pddk', id: 'nama_pddk', margin: '0 2 0 0', allowBlank: false, readOnly: true, width: 200},
			     		{xtype: 'button', name: 'search_pddk', id: 'search_pddk_ProfilPddk', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPddk', 'ref_pddk', 'Form_Pendidikan_PNS', 1);}
			        }
			     ]
			    },
			    {fieldLabel: 'Bidang / Jurusan', name: 'jurusan', id: 'jurusan', anchor: '100%'},
			    {fieldLabel: 'Nama Sekolah / Kampus', name: 'nama_institusi', id: 'nama_institusi', allowBlank: false, anchor: '100%'},
			    {fieldLabel: 'Alamat', name: 'alamat_institusi', id: 'alamat_institusi', anchor: '100%'},
			    {fieldLabel: 'Nama Kepala Sekolah / Direktur / Dekan / Promotor', name: 'kepala_institusi', id: 'kepala_institusi', anchor: '100%'},
			    {xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Status, Akreditas', defaults: {hideLabel: true}, combineErrors: false,
			     defaultType: 'textfield', anchor: '100%',
			     items: [
				    {xtype: 'combobox', fieldLabel: 'Status', name: 'status_institusi', margin: '0 5 0 0', width: 85,
				     store: new Ext.data.SimpleStore({data: [['Negeri'],['Swasta']], fields: ['status_institusi']}),
				     valueField: 'status_institusi', displayField: 'status_institusi', emptyText: 'Pilih Status',
				     queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
				     listeners: {
				    	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
				     }
				    },
				    {fieldLabel: 'Akreditas', name: 'akreditas_institusi', id: 'akreditas_institusi', allowBlank: true, width: 50},
			     ]
			    },
			    {xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tahun Masuk', defaults: {hideLabel: true}, combineErrors: false,
			     defaultType: 'numberfield', anchor: '100%',
			     items: [
			    	{fieldLabel: 'Tahun Masuk', name: 'tahun_masuk', minValue: 1900, maxLength: 4, margins: '0 5 0 0', width: 65},
			     	{fieldLabel: 'Tahun Lulus', name: 'tahun_lulus', minValue: 1900, maxLength: 4, hideLabel: false, labelWidth: 100, labelAlign: 'right', width:170},
			     ]
			    },
			    {xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No. & Tgl Ijazah', defaults: {hideLabel: true}, combineErrors: false,
			     defaultType: 'textfield', anchor: '100%',
			     items: [
				    {fieldLabel: 'No. Ijazah', name: 'no_ijazah', id: 'no_ijazah', margins: '0 5 0 0', anchor: '100%'},
				    {xtype: 'datefield', fieldLabel: 'Tgl. Ijazah', name: 'tgl_ijazah', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 92},
			     ]
			    },
			    {fieldLabel: 'IPK / NEM',name: 'rata2_ijazah', id: 'rata2_ijazah', maskRe: /[\d\.\;]/, regex: /^[0-9]|\;*$/, width: 180},
			    {xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Gelar Depan', defaults: {hideLabel: true, allowBlank: true}, combineErrors: false,
			     defaultType: 'textfield', anchor: '100%',
			     items: [
				    {fieldLabel: 'Gelar Depan',name: 'gelar_d', id: 'gelar_d_pddk', width: 60},
				    {fieldLabel: 'Gelar Belakang',name: 'gelar_b', id: 'gelar_b_pddk', hideLabel: false, labelWidth: 100, labelAlign: 'right', width: 160},
			     ]
			    },
	  	 	 ]
	  	 	},    	 
    	 ]
    	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Arsip Pendidikan', defaultType: 'textfield', margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			  	{xtype: 'fieldset', margins: '0 0 0 0', style: 'padding: 0; border-width: 0px; text-align: center;',
			  	 items: [Form_Arsip_Pddk]
			  	}
			   ]
			  }
    	 ]
    	},
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Pddk', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Pddk();}},
  	{text: 'Ubah', id: 'Ubah_Pddk', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Pddk();}},
  	{text: 'Simpan', id: 'Simpan_Pddk', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Pddk();}},
  	{text: 'Batal', id: 'Batal_Pddk', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Pddk();}}
  ]
});
// FORM PENDIDIKAN PNS  --------------------------------------------------------- END

// FUNCTIONS PENDIDIKAN PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Pddk(){
	Ext.getCmp('pendidikan_page').setActiveTab('Tab2_Pendidikan_PNS');
	Form_Pendidikan_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Pendidikan_PNS.getForm().setValues({NIP:vNIP});
	Form_Arsip_Pddk.getForm().setValues({NIP:vNIP});
	Active_Form_Pendidikan_PNS();
	Ext.getCmp('search_pddk_ProfilPddk').handler.call(Ext.getCmp("search_pddk_ProfilPddk").scope);

	Form_Pendidikan_PNS.getForm().findField('filearsip').setDisabled(true);
	Ext.getCmp('Btn_Hapus_Arsip_Pddk').setDisabled(true);	
	Ext.getCmp('Btn_Download_Arsip_Pddk').setIconCls('');	
	Ext.getCmp('Btn_Download_Arsip_Pddk').setDisabled(true);	
}

function Profil_PNS_Ubah_Pddk(){
	var IDP_Pddk = Form_Pendidikan_PNS.getForm().findField('IDP_Pddk').getValue();
	if(IDP_Pddk){
		vcbp_pddk_status_institusi = Form_Pendidikan_PNS.getForm().findField('status_institusi').getValue();
		P_Pddk_last_record = Form_Pendidikan_PNS.getForm().getValues();
		Ext.getCmp('pendidikan_page').setActiveTab('Tab2_Pendidikan_PNS');
		Active_Form_Pendidikan_PNS();
	}
}

function Profil_PNS_Simpan_Pddk(){
	Ext.getCmp('Form_Pendidikan_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Pendidikan_PNS').body.mask();}
  });

  Form_Pendidikan_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Pddk = obj.info.reason;
  			Form_Pendidikan_PNS.getForm().setValues({IDP_Pddk:IDP_Pddk});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Pendidikan_PNS').body.unmask(); Data_Profil_PNS_Pddk.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Pendidikan_PNS();
  		All_Button_Enabled(); Ext.getCmp('pendidikan_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Pendidikan_PNS').body.unmask();
      if (action.failureType == 'server') {
      	obj = Ext.decode(action.response.responseText);
        Ext.MessageBox.show({title:'Peringatan !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
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

function Profil_PNS_Hapus_Pddk(){
  var sm = grid_Profil_PNS_Pddk.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Pddk') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_pendidikan', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Pddk.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     			Form_Pendidikan_PNS.getForm().reset();
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Pddk(){
	var IDP_Pddk = Form_Pendidikan_PNS.getForm().findField('IDP_Pddk').getValue();
	if(!IDP_Pddk){
		Form_Pendidikan_PNS.getForm().reset();
	}else{
		Set_Arsip_Pddk();
		Form_Pendidikan_PNS.getForm().setValues({status_institusi:vcbp_pddk_status_institusi});
		Form_Pendidikan_PNS.getForm().setValues(P_Pddk_last_record);
	}
	Deactive_Form_Pendidikan_PNS();
}

function setValue_Form_Pendidikan_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Pendidikan_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Pddk.changeParams({params :{id_open: '1', NIP: vNIP}});
}

function Active_Form_Pendidikan_PNS(){
	Ext.getCmp('Tambah_Pddk').setDisabled(true);
	Ext.getCmp('Ubah_Pddk').setDisabled(true);
	Ext.getCmp('Simpan_Pddk').setDisabled(false);
	Ext.getCmp('Batal_Pddk').setDisabled(false);
	
	Ext.getCmp('search_pddk_ProfilPddk').setDisabled(false);	
	Form_Pendidikan_PNS.getForm().findField('jurusan').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('nama_institusi').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('alamat_institusi').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('status_institusi').setDisabled(false);
	Form_Pendidikan_PNS.getForm().findField('akreditas_institusi').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('tahun_masuk').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('tahun_lulus').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('no_ijazah').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('tgl_ijazah').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('rata2_ijazah').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('kepala_institusi').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('gelar_d').setReadOnly(false);
	Form_Pendidikan_PNS.getForm().findField('gelar_b').setReadOnly(false);
	
	Form_Pendidikan_PNS.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Pddk').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Pddk').setDisabled(false);
	}
}

function Deactive_Form_Pendidikan_PNS(){
	Ext.getCmp('Tambah_Pddk').setDisabled(false);
	Ext.getCmp('Ubah_Pddk').setDisabled(false);
	Ext.getCmp('Simpan_Pddk').setDisabled(true);
	Ext.getCmp('Batal_Pddk').setDisabled(true);
	
	Ext.getCmp('search_pddk_ProfilPddk').setDisabled(true);	
	Form_Pendidikan_PNS.getForm().findField('jurusan').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('nama_institusi').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('alamat_institusi').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('status_institusi').setDisabled(true);
	Form_Pendidikan_PNS.getForm().findField('akreditas_institusi').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('tahun_masuk').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('tahun_lulus').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('no_ijazah').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('tgl_ijazah').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('rata2_ijazah').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('kepala_institusi').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('gelar_d').setReadOnly(true);
	Form_Pendidikan_PNS.getForm().findField('gelar_b').setReadOnly(true);
	
	Form_Pendidikan_PNS.getForm().findField('filearsip').setDisabled(true);	
	Ext.getCmp('Btn_Hapus_Arsip_Pddk').setDisabled(true);
}
// FUNCTIONS PENDIDIKAN PNS  ---------------------------------------------------- END

// PANEL PENDIDIKAN PNS  -------------------------------------------------------- START
var Tab1_Pendidikan_PNS = {
	id: 'Tab1_Pendidikan_PNS', title: 'Riwayat Pendidikan', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Pddk]
};

var Tab2_Pendidikan_PNS = {
	id: 'Tab2_Pendidikan_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Pendidikan_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'pendidikan_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Pendidikan_PNS, Tab2_Pendidikan_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Pendidikan'){
  			Data_Profil_PNS_Pddk.load();
  			Deactive_Form_Pendidikan_PNS();
  			Form_Pendidikan_PNS.getForm().reset();
  		}
  	}
  }  
});
// PANEL PENDIDIKAN PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>