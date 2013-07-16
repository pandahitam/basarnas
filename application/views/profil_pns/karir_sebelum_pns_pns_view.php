<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_KSPNS_last_record;

// TABEL KARIR SEBELUM PNS PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_KSPNS', {extend: 'Ext.data.Model',
  	fields: ['IDP_PK', 'NIP', 'nama_prshn', 'lokasi_prshn', 'jabatan_prshn', 'tgl_m_kerja', 'tgl_s_kerja', 'alasan_pindah']
});

var Reader_Profil_PNS_KSPNS = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_KSPNS', root: 'results', totalProperty: 'total', idProperty: 'IDP_PK'  	
});

var Proxy_Profil_PNS_KSPNS = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_karir_sebelum_pns', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_KSPNS
});

var Data_Profil_PNS_KSPNS = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_KSPNS', model: 'MProfil_PNS_KSPNS', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_KSPNS
});

var tbProfil_PNS_KSPNS = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_KSPNS},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_KSPNS', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_KSPNS.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_KSPNS();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_KSPNS}
  ]
});

var cbGrid_Profil_PNS_KSPNS = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_KSPNS = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_KSPNS', store: Data_Profil_PNS_KSPNS,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_KSPNS, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Perusahaan", dataIndex: 'nama_prshn', width: 250},
  	{header: "Lokasi", dataIndex: 'lokasi_prshn', width: 100},
  	{header: "Jabatan", dataIndex: 'jabatan_prshn', width: 150},
  	{header: "Tgl. Mulai", dataIndex: 'tgl_m_kerja', width: 80, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tgl. Berakhir", dataIndex: 'tgl_s_kerja', width: 80, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Alasan Pindah", dataIndex: 'alasan_pindah', width: 200}
  ],
  tbar: tbProfil_PNS_KSPNS,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_KSPNS, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_KSPNS_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_KSPNS').handler.call(Ext.getCmp("Btn_Ubah_KSPNS").scope);}
  		Ext.getCmp('karir_sebelum_pns_page').setActiveTab('Tab2_KSPNS_PNS');
  	}    
  }
});
// TABEL KARIR SEBELUM PNS PNS  ------------------------------------------------- END

// FORM KARIR SEBELUM PNS PNS  --------------------------------------------------------- START
var Form_KSPNS_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_KSPNS_PNS', url: BASE_URL + 'profil_pns/ext_insert_karir_sebelum_pns',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 100},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_PK', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_KSPNS', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
      {fieldLabel: 'Nama Perusahaan', name: 'nama_prshn', id: 'nama_prshn', width: 350},
      {fieldLabel: 'Lokasi', name: 'lokasi_prshn', id: 'lokasi_prshn', width: 350},
      {fieldLabel: 'Jabatan', name: 'jabatan_prshn', id: 'jabatan_prshn', width: 350},
      {xtype: 'datefield', fieldLabel: 'Tgl. Mulai', name: 'tgl_m_kerja', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {xtype: 'datefield', fieldLabel: 'Tgl. Berakhir', name: 'tgl_s_kerja', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {fieldLabel: 'Alasan Pindah', name: 'alasan_pindah', id: 'alasan_pindah', width: 350}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_KSPNS', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_KSPNS();}},
  	{text: 'Ubah', id: 'Ubah_KSPNS', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_KSPNS();}},
  	{text: 'Simpan', id: 'Simpan_KSPNS', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_KSPNS();}},
  	{text: 'Batal', id: 'Batal_KSPNS', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_KSPNS();}}
  ]
});
// FORM KARIR SEBELUM PNS PNS  --------------------------------------------------------- END

// FUNCTIONS KARIR SEBELUM PNS PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_KSPNS(){
	Ext.getCmp('karir_sebelum_pns_page').setActiveTab('Tab2_KSPNS_PNS');
	Form_KSPNS_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KSPNS_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_KSPNS_PNS();	
}

function Profil_PNS_Ubah_KSPNS(){
	var IDP_PK = Form_KSPNS_PNS.getForm().findField('IDP_PK').getValue();
	if(IDP_PK){
		P_KSPNS_last_record = Form_KSPNS_PNS.getForm().getValues();
		Ext.getCmp('karir_sebelum_pns_page').setActiveTab('Tab2_KSPNS_PNS');
		Active_Form_KSPNS_PNS();
	}
}

function Profil_PNS_Simpan_KSPNS(){
	Ext.getCmp('Form_KSPNS_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_KSPNS_PNS').body.mask();}
  });

  Form_KSPNS_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_PK = obj.info.reason;
  			Form_KSPNS_PNS.getForm().setValues({IDP_PK:IDP_PK});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_KSPNS_PNS').body.unmask(); Data_Profil_PNS_KSPNS.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_KSPNS_PNS();
  		All_Button_Enabled(); Ext.getCmp('karir_sebelum_pns_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_KSPNS_PNS').body.unmask();
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

function Profil_PNS_Hapus_KSPNS(){
  var sm = grid_Profil_PNS_KSPNS.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_PK') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_karir_sebelum_pns', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_KSPNS.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_KSPNS(){
	var IDP_PK = Form_KSPNS_PNS.getForm().findField('IDP_PK').getValue();
	if(!IDP_PK){
		Form_KSPNS_PNS.getForm().reset();
	}else{
		Form_KSPNS_PNS.getForm().setValues(P_KSPNS_last_record);
	}
	Deactive_Form_KSPNS_PNS();
}

function setValue_Form_KSPNS_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KSPNS_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_KSPNS.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_KSPNS_PNS(){
	Ext.getCmp('Tambah_KSPNS').setDisabled(true);
	Ext.getCmp('Ubah_KSPNS').setDisabled(true);
	Ext.getCmp('Simpan_KSPNS').setDisabled(false);
	Ext.getCmp('Batal_KSPNS').setDisabled(false);
	
	Form_KSPNS_PNS.getForm().findField('nama_prshn').setReadOnly(false);
	Form_KSPNS_PNS.getForm().findField('lokasi_prshn').setReadOnly(false);
	Form_KSPNS_PNS.getForm().findField('jabatan_prshn').setReadOnly(false);
	Form_KSPNS_PNS.getForm().findField('tgl_m_kerja').setReadOnly(false);
	Form_KSPNS_PNS.getForm().findField('tgl_s_kerja').setReadOnly(false);
	Form_KSPNS_PNS.getForm().findField('alasan_pindah').setReadOnly(false);
}

function Deactive_Form_KSPNS_PNS(){
	Ext.getCmp('Tambah_KSPNS').setDisabled(false);
	Ext.getCmp('Ubah_KSPNS').setDisabled(false);
	Ext.getCmp('Simpan_KSPNS').setDisabled(true);
	Ext.getCmp('Batal_KSPNS').setDisabled(true);
	
	Form_KSPNS_PNS.getForm().findField('nama_prshn').setReadOnly(true);
	Form_KSPNS_PNS.getForm().findField('lokasi_prshn').setReadOnly(true);
	Form_KSPNS_PNS.getForm().findField('jabatan_prshn').setReadOnly(true);
	Form_KSPNS_PNS.getForm().findField('tgl_m_kerja').setReadOnly(true);
	Form_KSPNS_PNS.getForm().findField('tgl_s_kerja').setReadOnly(true);
	Form_KSPNS_PNS.getForm().findField('alasan_pindah').setReadOnly(true);
}
// FUNCTIONS KARIR SEBELUM PNS PNS  ---------------------------------------------------- END

// PANEL KARIR SEBELUM PNS PNS  -------------------------------------------------------- START
var Tab1_KSPNS_PNS = {
	id: 'Tab1_KSPNS_PNS', title: 'Karir Sebelum PNS', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_KSPNS]
};

var Tab2_KSPNS_PNS = {
	id: 'Tab2_KSPNS_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_KSPNS_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'karir_sebelum_pns_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_KSPNS_PNS, Tab2_KSPNS_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Karir Sebelum PNS'){
  			Data_Profil_PNS_KSPNS.load();
  			Deactive_Form_KSPNS_PNS(); 
  			Form_KSPNS_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL KARIR SEBELUM PNS PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>