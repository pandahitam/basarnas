<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Pddk_NF_last_record, vcbp_dik_kode_jns_diklat, vcbp_dik_kode_sumber_dana, vcbp_dik_angkatan;

// TABEL PENDIDIKAN NON FORMAL PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Pddk_NF', {extend: 'Ext.data.Model',
  	fields: ['IDP_Pddk_NF', 'NIP', 'nama_pddk_nf', 'lama', 'tgl_m', 'tgl_s', 'no_ijazah', 'tempat', 'ket']
});

var Reader_Profil_PNS_Pddk_NF = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Pddk_NF', root: 'results', totalProperty: 'total', idProperty: 'IDP_Pddk_NF'  	
});

var Proxy_Profil_PNS_Pddk_NF = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_pddk_nf', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_Pddk_NF
});

var Data_Profil_PNS_Pddk_NF = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Pddk_NF', model: 'MProfil_PNS_Pddk_NF', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Pddk_NF
});

var tbProfil_PNS_Pddk_NF = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Pddk_NF},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Pddk_NF', disabled: ppns_update,
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Pddk_NF.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Pddk_NF();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Pddk_NF}
  ]
});

var cbGrid_Profil_PNS_Pddk_NF = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Pddk_NF = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Pddk_NF', store: Data_Profil_PNS_Pddk_NF,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Pddk_NF, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Kursus/Latihan", dataIndex: 'nama_pddk_nf', groupable: false, width: 150},
  	{header: "Tempat", dataIndex: 'tempat', groupable: false, width: 180},
  	{header: "Lama", dataIndex: 'lama', groupable: false, width: 75},
  	{header: "Tgl. Mulai", dataIndex: 'tgl_m', groupable: false, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tgl. Selesai", dataIndex: 'tgl_s', groupable: false, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "No. Ijazah", dataIndex: 'no_ijazah', groupable: false, width: 180},
  	{header: "Keterangan", dataIndex: 'ket', groupable: false, width: 180},
  ],
  tbar: tbProfil_PNS_Pddk_NF,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Profil_PNS_Pddk_NF, dock: 'bottom', displayInfo: true}],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Pddk_NF_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_Pddk_NF').handler.call(Ext.getCmp("Btn_Ubah_Pddk_NF").scope);}
  		Ext.getCmp('pddk_nf_page').setActiveTab('Tab2_Pddk_NF_PNS');
  	}    
  }
});

// TABEL PENDIDIKAN NON FORMAL PNS  ------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Pddk_NF = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Pddk_NF', url: BASE_URL + 'upload_arsip/insert_arsip/pendidikan_nf', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Pddk_NF'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Pddk_NF', value: 5},
		{xtype: 'hidden', name: 'IDP_Pddk_NF', id: 'IDP_Pddk_NF_Arsip_Pddk_NF'},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Pddk_NF', emptyText: 'Upload Files', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Pddk_NF.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						var p_IDP_Pddk_NF = Form_Pddk_NF_PNS.getForm().findField('IDP_Pddk_NF').getValue();
						Form_Arsip_Pddk_NF.getForm().setValues({NIP: p_NIP, IDP_Pddk_NF: p_IDP_Pddk_NF});
			 			Form_Arsip_Pddk_NF.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Set_Arsip_Pddk_NF(); Deactive_Form_Pddk_NF_PNS();
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
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Pddk_NF', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Pddk_NF();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Pddk_NF', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Pddk_NF();}},
		 ]
		}
	]
});

function Set_Arsip_Pddk_NF(){Set_Arsip_Digital('Form_Pddk_NF_PNS', 'Btn_Download_Arsip_Pddk_NF', 'IDP_Pddk_NF', 5, 'pendidikan_nf');}
function Reset_Arsip_Pddk_NF(){Reset_Arsip_Digital('Form_Pddk_NF_PNS', 'Btn_Download_Arsip_Pddk_NF', 'IDP_Pddk_NF', 5, 'pendidikan_nf'); Deactive_Form_Pddk_NF_PNS();}
function Download_Arsip_Pddk_NF(){Download_Arsip_Digital('Form_Pddk_NF_PNS', 'IDP_Pddk_NF', 5, 'pendidikan_nf');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM PENDIDIKAN NON FORMAL PNS  --------------------------------------------------------- START
var Form_Pddk_NF_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Pddk_NF_PNS', url: BASE_URL + 'profil_pns/ext_insert_pddk_nf',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 130},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Kursus/Latihan', defaultType: 'textfield', defaults: {labelWidth: 120, labelAlign: 'left'}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
	  	 	 	{name: 'IDP_Pddk_NF', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Pddk_NF', xtype: 'hidden'},
		      {fieldLabel: 'Nama Kursus/Latihan', name: 'nama_pddk_nf', id: 'nama_pddk_nf', anchor: '90%'},
		      {fieldLabel: 'Tempat', name: 'tempat', id: 'tempat', anchor: '85%'},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tgl. Mulai - Selesai', defaults: {hideLabel: true}, combineErrors: false,
		     	 defaultType: 'datefield', width: 355,
		     	 items: [
		      		{fieldLabel: 'Tgl. Mulai', name: 'tgl_m', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', margins: '0 5 0 0', flex:1,
		      		 listeners: {
		      		 	'change': {fn: function (df, newValue, oldValue){Form_Pddk_NF_PNS.getForm().findField('tgl_s').setValue(newValue);}, scope: this}
		      		 }
		      		},
		      		{fieldLabel: 'Tgl. Selesai', name: 'tgl_s', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', margins: '0 5 0 0', flex:1}
		     	 ]
		    	},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Lama Latihan', defaults: {hideLabel: true}, combineErrors: false,
		     	 defaultType: 'textfield', anchor: '100%',
		     	 items: [
		      		{fieldLabel: 'Lama Latihan', name: 'lama', id: 'lama_pddk_nf', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, margins: '0 5 0 0', width : 50},
		      		{xtype: 'label', forId: 'lama_pddk_nf', text: 'Jam', margins: '3 15 0 0'},
		     	 ]
		    	},
		      {fieldLabel: 'No. Ijazah / Tanda Lulus', name: 'no_ijazah', id: 'no_ijazah_pddk_nf', anchor: '85%'},
		      {fieldLabel: 'Keterangan', name: 'ket', id: 'ket_pddk_nf', anchor: '90%'},	  	 	 	
	  	 	 ]
	  	 	},    	 
    	 ]
    	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Arsip Kursus', defaultType: 'textfield', margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			  	{xtype: 'fieldset', margins: '0 0 0 0', style: 'padding: 0; border-width: 0px; text-align: center;',
			  	 items: [Form_Arsip_Pddk_NF]
			  	}
			   ]
			  }
    	 ]
    	},
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Pddk_NF', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Pddk_NF();}},
  	{text: 'Ubah', id: 'Ubah_Pddk_NF', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Pddk_NF();}},
  	{text: 'Simpan', id: 'Simpan_Pddk_NF', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Pddk_NF();}},
  	{text: 'Batal', id: 'Batal_Pddk_NF', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Pddk_NF();}}
  ]
});
// FORM PENDIDIKAN NON FORMAL PNS  --------------------------------------------------------- END

// FUNCTIONS PENDIDIKAN NON FORMAL PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Pddk_NF(){
	Ext.getCmp('pddk_nf_page').setActiveTab('Tab2_Pddk_NF_PNS');
	Form_Pddk_NF_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Pddk_NF_PNS.getForm().setValues({NIP:vNIP});
	Form_Arsip_Pddk_NF.getForm().setValues({NIP:vNIP});
	Active_Form_Pddk_NF_PNS();

	Form_Pddk_NF_PNS.getForm().findField('filearsip').setDisabled(true);
	Ext.getCmp('Btn_Hapus_Arsip_Pddk_NF').setDisabled(true);	
	Ext.getCmp('Btn_Download_Arsip_Pddk_NF').setIconCls('');	
	Ext.getCmp('Btn_Download_Arsip_Pddk_NF').setDisabled(true);	
}

function Profil_PNS_Ubah_Pddk_NF(){
	var IDP_Pddk_NF = Form_Pddk_NF_PNS.getForm().findField('IDP_Pddk_NF').getValue();
	if(IDP_Pddk_NF){
		P_Pddk_NF_last_record = Form_Pddk_NF_PNS.getForm().getValues();
		Ext.getCmp('pddk_nf_page').setActiveTab('Tab2_Pddk_NF_PNS');
		Active_Form_Pddk_NF_PNS();
	}
}

function Profil_PNS_Simpan_Pddk_NF(){
	Ext.getCmp('Form_Pddk_NF_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Pddk_NF_PNS').body.mask();}
  });

  Form_Pddk_NF_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Pddk_NF = obj.info.reason;
  			Form_Pddk_NF_PNS.getForm().setValues({IDP_Pddk_NF:IDP_Pddk_NF});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Pddk_NF_PNS').body.unmask(); Data_Profil_PNS_Pddk_NF.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Pddk_NF_PNS();
  		All_Button_Enabled(); Ext.getCmp('pddk_nf_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Pddk_NF_PNS').body.unmask();
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

function Profil_PNS_Hapus_Pddk_NF(){
  var sm = grid_Profil_PNS_Pddk_NF.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Pddk_NF') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_pddk_nf', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Pddk_NF.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Pddk_NF(){
	var IDP_Pddk_NF = Form_Pddk_NF_PNS.getForm().findField('IDP_Pddk_NF').getValue();
	if(!IDP_Pddk_NF){
		Form_Pddk_NF_PNS.getForm().reset();
	}else{
		Form_Pddk_NF_PNS.getForm().setValues(P_Pddk_NF_last_record);
	}
	Deactive_Form_Pddk_NF_PNS();
}

function setValue_Form_Pddk_NF_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Pddk_NF_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Pddk_NF.changeParams({params :{id_open: '1', NIP: vNIP}});
}

function Active_Form_Pddk_NF_PNS(){
	Ext.getCmp('Tambah_Pddk_NF').setDisabled(true);
	Ext.getCmp('Ubah_Pddk_NF').setDisabled(true);
	Ext.getCmp('Simpan_Pddk_NF').setDisabled(false);
	Ext.getCmp('Batal_Pddk_NF').setDisabled(false);
	
	Form_Pddk_NF_PNS.getForm().findField('nama_pddk_nf').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('lama').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('tgl_m').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('tgl_s').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('no_ijazah').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('tempat').setReadOnly(false);
	Form_Pddk_NF_PNS.getForm().findField('ket').setReadOnly(false);

	Form_Pddk_NF_PNS.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Pddk_NF').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Pddk_NF').setDisabled(false);
	}
}

function Deactive_Form_Pddk_NF_PNS(){
	Ext.getCmp('Tambah_Pddk_NF').setDisabled(false);
	Ext.getCmp('Ubah_Pddk_NF').setDisabled(false);
	Ext.getCmp('Simpan_Pddk_NF').setDisabled(true);
	Ext.getCmp('Batal_Pddk_NF').setDisabled(true);
	
	Form_Pddk_NF_PNS.getForm().findField('nama_pddk_nf').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('lama').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('tgl_m').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('tgl_s').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('no_ijazah').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('tempat').setReadOnly(true);
	Form_Pddk_NF_PNS.getForm().findField('ket').setReadOnly(true);

	Form_Pddk_NF_PNS.getForm().findField('filearsip').setDisabled(true);	
	Ext.getCmp('Btn_Hapus_Arsip_Pddk_NF').setDisabled(true);
}

// FUNCTIONS PENDIDIKAN NON FORMAL PNS  ---------------------------------------------------- END

// PANEL PENDIDIKAN NON FORMAL PNS  -------------------------------------------------------- START
var Tab1_Pddk_NF_PNS = {
	id: 'Tab1_Pddk_NF_PNS', title: 'Riwayat Kursus', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Pddk_NF]
};

var Tab2_Pddk_NF_PNS = {
	id: 'Tab2_Pddk_NF_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Pddk_NF_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'pddk_nf_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Pddk_NF_PNS, Tab2_Pddk_NF_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Kursus'){
  			Data_Profil_PNS_Pddk_NF.load();
  			Deactive_Form_Pddk_NF_PNS();
  			Form_Pddk_NF_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL PENDIDIKAN NON FORMAL PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>