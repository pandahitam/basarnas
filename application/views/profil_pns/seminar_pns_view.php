<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Seminar_last_record, vcbp_snmr_sebagai;

// TABEL SEMINAR PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Seminar', {extend: 'Ext.data.Model',
  	fields: ['IDP_Seminar', 'NIP', 'nama_seminar', 'topik', 'penyelenggara', 'lokasi', 'sebagai', 'tgl_seminar_d', 'tgl_seminar_s', 'lama_seminar', 'angkatan', 'no_piagam', 'tgl_piagam']
});

var Reader_Profil_PNS_Seminar = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Seminar', root: 'results', totalProperty: 'total', idProperty: 'IDP_Seminar'  	
});

var Proxy_Profil_PNS_Seminar = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_seminar', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_Seminar
});

var Data_Profil_PNS_Seminar = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Seminar', model: 'MProfil_PNS_Seminar', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Seminar
});

var tbProfil_PNS_Seminar = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Seminar},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Seminar', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Seminar.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Seminar();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Seminar}
  ]
});

var cbGrid_Profil_PNS_Seminar = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Seminar = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Seminar', store: Data_Profil_PNS_Seminar,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Seminar, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Seminar", dataIndex: 'nama_seminar', width: 200},
  	{header: "Topik", dataIndex: 'topik', width: 200},
  	{header: "Penyelenggara", dataIndex: 'penyelenggara', width: 150},
  	{header: "Lokasi", dataIndex: 'lokasi', width: 150},
  	{header: "Tgl. Mulai", dataIndex: 'tgl_seminar_d', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tgl. Selesai", dataIndex: 'tgl_seminar_s', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Lama Seminar", dataIndex: 'lama_seminar', width: 100},
  	{header: "Angkatan", dataIndex: 'angkatan', width: 75},
  	{header: "No. Piagam", dataIndex: 'angkatan', width: 150},
  	{header: "Tgl. Piagam", dataIndex: 'tgl_piagam', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
  ],
  tbar: tbProfil_PNS_Seminar,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_Seminar, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Seminar_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_Seminar').handler.call(Ext.getCmp("Btn_Ubah_Seminar").scope);}
  		Ext.getCmp('seminar_page').setActiveTab('Tab2_Seminar_PNS');
  	}    
  }
});

// TABEL SEMINAR PNS  ------------------------------------------------- END

// FORM SEMINAR PNS  --------------------------------------------------------- START
var Form_Seminar_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Seminar_PNS', url: BASE_URL + 'profil_pns/ext_insert_seminar',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_Seminar', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Pddk', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
      {fieldLabel: 'Nama Seminar', name: 'nama_seminar', id: 'nama_seminar', width: 350},
      {fieldLabel: 'Topik', name: 'topik', id: 'topik', allowBlank: true, width: 350},
      {fieldLabel: 'Penyelenggara', name: 'penyelenggara', id: 'penyelenggara_seminar', allowBlank: true, width: 350},
      {fieldLabel: 'Lokasi', name: 'lokasi', id: 'lokasi_seminar', width: 350},
     	{xtype: 'combobox', fieldLabel: 'Kedudukan Sebagai', name: 'sebagai', width: 250,
       store: new Ext.data.SimpleStore({data: [['Narasumber'],['Panitia'],['Peserta']], fields: ['sebagai']}),
       valueField: 'sebagai', displayField: 'sebagai', emptyText: 'Kedudukan',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }
      },
      {xtype: 'datefield', fieldLabel: 'Tgl. Mulai', name: 'tgl_seminar_d', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 225},
      {xtype: 'datefield', fieldLabel: 'Tgl. Selesai', name: 'tgl_seminar_s', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 225},
      {fieldLabel: 'Lama Seminar', name: 'lama_seminar', id: 'lama_seminar', allowBlank: true, width: 250},
      {fieldLabel: 'Angkatan', name: 'angkatan', id: 'angkatan', allowBlank: true, width: 250},
      {fieldLabel: 'No. Piagam', name: 'no_piagam', id: 'no_piagam', allowBlank: true, width: 300},
      {xtype: 'datefield', fieldLabel: 'Tgl. Piagam', name: 'tgl_piagam', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, width: 225}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Seminar', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Seminar();}},
  	{text: 'Ubah', id: 'Ubah_Seminar', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Seminar();}},
  	{text: 'Simpan', id: 'Simpan_Seminar', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Seminar();}},
  	{text: 'Batal', id: 'Batal_Seminar', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Seminar();}}
  ]
});
// FORM SEMINAR PNS  --------------------------------------------------------- END

// FUNCTIONS SEMINAR PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Seminar(){
	Ext.getCmp('seminar_page').setActiveTab('Tab2_Seminar_PNS');
	Form_Seminar_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Seminar_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_Seminar_PNS();	
}

function Profil_PNS_Ubah_Seminar(){
	var IDP_Seminar = Form_Seminar_PNS.getForm().findField('IDP_Seminar').getValue();
	if(IDP_Seminar){
		vcbp_snmr_sebagai = Form_Seminar_PNS.getForm().findField('sebagai').getValue();
		P_Seminar_last_record = Form_Seminar_PNS.getForm().getValues();
		Ext.getCmp('seminar_page').setActiveTab('Tab2_Seminar_PNS');
		Active_Form_Seminar_PNS();
	}
}

function Profil_PNS_Simpan_Seminar(){
	Ext.getCmp('Form_Seminar_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Seminar_PNS').body.mask();}
  });

  Form_Seminar_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Seminar = obj.info.reason;
  			Form_Seminar_PNS.getForm().setValues({IDP_Seminar:IDP_Seminar});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Seminar_PNS').body.unmask(); Data_Profil_PNS_Seminar.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Seminar_PNS();	
  		All_Button_Enabled(); Ext.getCmp('seminar_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Seminar_PNS').body.unmask();
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

function Profil_PNS_Hapus_Seminar(){
  var sm = grid_Profil_PNS_Seminar.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Seminar') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_seminar', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Seminar.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Seminar(){
	var IDP_Seminar = Form_Seminar_PNS.getForm().findField('IDP_Seminar').getValue();
	if(!IDP_Seminar){
		Form_Seminar_PNS.getForm().reset();
	}else{
		Form_Seminar_PNS.getForm().setValues({sebagai:vcbp_snmr_sebagai});
		Form_Seminar_PNS.getForm().setValues(P_Seminar_last_record);
	}
	Deactive_Form_Seminar_PNS();
}

function setValue_Form_Seminar_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Seminar_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Seminar.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_Seminar_PNS(){
	Ext.getCmp('Tambah_Seminar').setDisabled(true);
	Ext.getCmp('Ubah_Seminar').setDisabled(true);
	Ext.getCmp('Simpan_Seminar').setDisabled(false);
	Ext.getCmp('Batal_Seminar').setDisabled(false);
	
	Form_Seminar_PNS.getForm().findField('nama_seminar').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('topik').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('penyelenggara').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('lokasi').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('sebagai').setDisabled(false);
	Form_Seminar_PNS.getForm().findField('tgl_seminar_d').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('tgl_seminar_s').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('lama_seminar').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('angkatan').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('no_piagam').setReadOnly(false);
	Form_Seminar_PNS.getForm().findField('tgl_piagam').setReadOnly(false);
}

function Deactive_Form_Seminar_PNS(){
	Ext.getCmp('Tambah_Seminar').setDisabled(false);
	Ext.getCmp('Ubah_Seminar').setDisabled(false);
	Ext.getCmp('Simpan_Seminar').setDisabled(true);
	Ext.getCmp('Batal_Seminar').setDisabled(true);
	
	Form_Seminar_PNS.getForm().findField('nama_seminar').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('topik').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('penyelenggara').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('lokasi').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('sebagai').setDisabled(true);
	Form_Seminar_PNS.getForm().findField('tgl_seminar_d').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('tgl_seminar_s').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('lama_seminar').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('angkatan').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('no_piagam').setReadOnly(true);
	Form_Seminar_PNS.getForm().findField('tgl_piagam').setReadOnly(true);
}
// FUNCTIONS SEMINAR PNS  ---------------------------------------------------- END

// PANEL SEMINAR PNS  -------------------------------------------------------- START
var Tab1_Seminar_PNS = {
	id: 'Tab1_Seminar_PNS', title: 'Seminar', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Seminar]
};

var Tab2_Seminar_PNS = {
	id: 'Tab2_Seminar_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Seminar_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'seminar_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Seminar_PNS, Tab2_Seminar_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Seminar'){
  			Data_Profil_PNS_Seminar.load();
  			Deactive_Form_Seminar_PNS(); 
  			Form_Seminar_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL SEMINAR PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>