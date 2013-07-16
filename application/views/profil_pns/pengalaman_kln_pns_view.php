<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_PKLN_last_record;

// TABEL PENGALAMAN KE LUAR NEGERI PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_PKLN', {extend: 'Ext.data.Model',
  	fields: ['IDP_PKLN', 'NIP', 'negara', 'tujuan_kunjungan', 'lamanya', 'yang_membiayai']
});

var Reader_Profil_PNS_PKLN = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_PKLN', root: 'results', totalProperty: 'total', idProperty: 'IDP_PKLN'  	
});

var Proxy_Profil_PNS_PKLN = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_pengalaman_kln', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_PKLN
});

var Data_Profil_PNS_PKLN = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_PKLN', model: 'MProfil_PNS_PKLN', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_PKLN
});

var tbProfil_PNS_PKLN = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_PKLN},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_PKLN', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_PKLN.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_PKLN();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_PKLN}
  ]
});

var cbGrid_Profil_PNS_PKLN = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_PKLN = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_PKLN', store: Data_Profil_PNS_PKLN,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_PKLN, columnLines: true, loadMask: true,
	columns: [
  	{header: "Negara", dataIndex: 'negara', width: 250},
  	{header: "Tujuan Kunjungan", dataIndex: 'tujuan_kunjungan', width: 100},
  	{header: "Lamanya", dataIndex: 'lamanya', width: 150},
  	{header: "Yang Membiayai", dataIndex: 'yang_membiayai', width: 200}
  ],
  tbar: tbProfil_PNS_PKLN,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_PKLN, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_PKLN_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('pengalaman_kln_page').setActiveTab('Tab2_PKLN_PNS');
  	}    
  }
});
// TABEL PENGALAMAN KE LUAR NEGERI PNS  ------------------------------------------------- END

// FORM PENGALAMAN KE LUAR NEGERI PNS  --------------------------------------------------------- START
var Form_PKLN_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_PKLN_PNS', url: BASE_URL + 'profil_pns/ext_insert_pengalaman_kln',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 100},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_PKLN', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_PKLN', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
      {fieldLabel: 'Negara', name: 'negara', id: 'negara', width: 350},
      {fieldLabel: 'Tujuan Kunjungan', name: 'tujuan_kunjungan', id: 'tujuan_kunjungan', width: 350},
      {fieldLabel: 'Lamanya', name: 'lamanya', id: 'lamanya', width: 200},
      {fieldLabel: 'Yang Membiayai', name: 'yang_membiayai', id: 'yang_membiayai', width: 350}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_PKLN', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_PKLN();}},
  	{text: 'Ubah', id: 'Ubah_PKLN', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_PKLN();}},
  	{text: 'Simpan', id: 'Simpan_PKLN', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_PKLN();}},
  	{text: 'Batal', id: 'Batal_PKLN', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_PKLN();}}
  ]
});
// FORM PENGALAMAN KE LUAR NEGERI PNS  --------------------------------------------------------- END

// FUNCTIONS PENGALAMAN KE LUAR NEGERI PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_PKLN(){
	Ext.getCmp('pengalaman_kln_page').setActiveTab('Tab2_PKLN_PNS');
	Form_PKLN_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_PKLN_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_PKLN_PNS();	
}

function Profil_PNS_Ubah_PKLN(){
	var IDP_PKLN = Form_PKLN_PNS.getForm().findField('IDP_PKLN').getValue();
	if(IDP_PKLN){
		P_PKLN_last_record = Form_PKLN_PNS.getForm().getValues();
		Ext.getCmp('pengalaman_kln_page').setActiveTab('Tab2_PKLN_PNS');
		Active_Form_PKLN_PNS();
	}
}

function Profil_PNS_Simpan_PKLN(){
	Ext.getCmp('Form_PKLN_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_PKLN_PNS').body.mask();}
  });

  Form_PKLN_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_PKLN = obj.info.reason;
  			Form_PKLN_PNS.getForm().setValues({IDP_PKLN:IDP_PKLN});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_PKLN_PNS').body.unmask(); Data_Profil_PNS_PKLN.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_PKLN_PNS();
  		All_Button_Enabled(); Ext.getCmp('pengalaman_kln_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_PKLN_PNS').body.unmask();
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

function Profil_PNS_Hapus_PKLN(){
  var sm = grid_Profil_PNS_PKLN.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_PKLN') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_pengalaman_kln', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_PKLN.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_PKLN(){
	var IDP_PKLN = Form_PKLN_PNS.getForm().findField('IDP_PKLN').getValue();
	if(!IDP_PKLN){
		Form_PKLN_PNS.getForm().reset();
	}else{
		Form_PKLN_PNS.getForm().setValues(P_PKLN_last_record);
	}
	Deactive_Form_PKLN_PNS();
}

function setValue_Form_PKLN_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_PKLN_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_PKLN.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_PKLN_PNS(){
	Ext.getCmp('Tambah_PKLN').setDisabled(true);
	Ext.getCmp('Ubah_PKLN').setDisabled(true);
	Ext.getCmp('Simpan_PKLN').setDisabled(false);
	Ext.getCmp('Batal_PKLN').setDisabled(false);
	
	Form_PKLN_PNS.getForm().findField('negara').setReadOnly(false);
	Form_PKLN_PNS.getForm().findField('tujuan_kunjungan').setReadOnly(false);
	Form_PKLN_PNS.getForm().findField('lamanya').setReadOnly(false);
	Form_PKLN_PNS.getForm().findField('yang_membiayai').setReadOnly(false);
}

function Deactive_Form_PKLN_PNS(){
	Ext.getCmp('Tambah_PKLN').setDisabled(false);
	Ext.getCmp('Ubah_PKLN').setDisabled(false);
	Ext.getCmp('Simpan_PKLN').setDisabled(true);
	Ext.getCmp('Batal_PKLN').setDisabled(true);
	
	Form_PKLN_PNS.getForm().findField('negara').setReadOnly(true);
	Form_PKLN_PNS.getForm().findField('tujuan_kunjungan').setReadOnly(true);
	Form_PKLN_PNS.getForm().findField('lamanya').setReadOnly(true);
	Form_PKLN_PNS.getForm().findField('yang_membiayai').setReadOnly(true);
}
// FUNCTIONS PENGALAMAN KE LUAR NEGERI PNS  ---------------------------------------------------- END

// PANEL PENGALAMAN KE LUAR NEGERI PNS  -------------------------------------------------------- START
var Tab1_PKLN_PNS = {
	id: 'Tab1_PKLN_PNS', title: 'Pengalaman Ke Luar Negeri', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_PKLN]
};

var Tab2_PKLN_PNS = {
	id: 'Tab2_PKLN_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_PKLN_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'pengalaman_kln_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_PKLN_PNS, Tab2_PKLN_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Karir Sebelum PNS'){
  			Data_Profil_PNS_PKLN.load();
  			Deactive_Form_PKLN_PNS(); 
  			Form_PKLN_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL PENGALAMAN KE LUAR NEGERI PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>