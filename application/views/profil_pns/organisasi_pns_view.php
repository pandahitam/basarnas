<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Org_last_record, vcbp_org_jenis_org;

// TABEL ORGANISASI PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Org', {extend: 'Ext.data.Model',
  	fields: ['IDP_Org', 'NIP', 'nama_org', 'jenis_org', 'lokasi_org', 'jabatan_org', 'tgl_m_org', 'tgl_s_org', 'nama_pimp_org']
});

var Reader_Profil_PNS_Org = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Org', root: 'results', totalProperty: 'total', idProperty: 'IDP_Org'  	
});

var Proxy_Profil_PNS_Org = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_organisasi', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_Org
});

var Data_Profil_PNS_Org = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Org', model: 'MProfil_PNS_Org', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Org
});

var tbProfil_PNS_Org = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Org},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Org', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Org.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Org();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Org}
  ]
});

var cbGrid_Profil_PNS_Org = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Org = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Org', store: Data_Profil_PNS_Org,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Org, columnLines: true, loadMask: true,
	columns: [
  	{header: "Jenis", dataIndex: 'jenis_org', width: 100},
  	{header: "Nama Organisasi", dataIndex: 'nama_org', width: 250},
  	{header: "Jabatan", dataIndex: 'jabatan_org', width: 150},
  	{header: "Tgl. Mulai", dataIndex: 'tgl_m_org', width: 80, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tgl. Berakhir", dataIndex: 'tgl_s_org', width: 80, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Nama Pimpinan", dataIndex: 'nama_pimp_org', width: 200}
  ],
  tbar: tbProfil_PNS_Org,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_Org, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Org_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_Org').handler.call(Ext.getCmp("Btn_Ubah_Org").scope);}
  		Ext.getCmp('organisasi_page').setActiveTab('Tab2_Org_PNS');
  	}    
  }
});
// TABEL ORGANISASI PNS  ------------------------------------------------- END

// FORM ORGANISASI PNS  --------------------------------------------------------- START
var Form_Org_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Org_PNS', url: BASE_URL + 'profil_pns/ext_insert_organisasi',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 100},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_Org', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Org', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
     	{xtype: 'combobox', fieldLabel: 'Jenis', name: 'jenis_org', width: 250,
       store: new Ext.data.SimpleStore({data: [['Org. Politik'],['Org. Sosial'],['Org. Masyarakat'],['Org. Mahasiswa'],['Org. Sekolah'],['Org. Olahraga'],['Org. Negara']], fields: ['jenis_org']}),
       valueField: 'jenis_org', displayField: 'jenis_org', emptyText: 'Jenis',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }
      },
      {fieldLabel: 'Nama Organisasi', name: 'nama_org', id: 'nama_org', width: 350},
      {fieldLabel: 'Jabatan', name: 'jabatan_org', id: 'jabatan_org', width: 350},
      {xtype: 'datefield', fieldLabel: 'Tgl. Mulai', name: 'tgl_m_org', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {xtype: 'datefield', fieldLabel: 'Tgl. Berakhir', name: 'tgl_s_org', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {fieldLabel: 'Nama Pimpinan', name: 'nama_pimp_org', id: 'nama_pimp_org', width: 300}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Org', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Org();}},
  	{text: 'Ubah', id: 'Ubah_Org', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Org();}},
  	{text: 'Simpan', id: 'Simpan_Org', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Org();}},
  	{text: 'Batal', id: 'Batal_Org', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Org();}}
  ]
});
// FORM ORGANISASI PNS  --------------------------------------------------------- END

// FUNCTIONS ORGANISASI PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Org(){
	Ext.getCmp('organisasi_page').setActiveTab('Tab2_Org_PNS');
	Form_Org_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Org_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_Org_PNS();	
}

function Profil_PNS_Ubah_Org(){
	var IDP_Org = Form_Org_PNS.getForm().findField('IDP_Org').getValue();
	if(IDP_Org){
		vcbp_org_jenis_org = Form_Org_PNS.getForm().findField('jenis_org').getValue();
		P_Org_last_record = Form_Org_PNS.getForm().getValues();
		Ext.getCmp('organisasi_page').setActiveTab('Tab2_Org_PNS');
		Active_Form_Org_PNS();
	}
}

function Profil_PNS_Simpan_Org(){
	Ext.getCmp('Form_Org_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Org_PNS').body.mask();}
  });

  Form_Org_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Org = obj.info.reason;
  			Form_Org_PNS.getForm().setValues({IDP_Org:IDP_Org});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Org_PNS').body.unmask(); Data_Profil_PNS_Org.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Org_PNS();
  		All_Button_Enabled(); Ext.getCmp('organisasi_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Org_PNS').body.unmask();
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

function Profil_PNS_Hapus_Org(){
  var sm = grid_Profil_PNS_Org.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Org') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_organisasi', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Org.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Org(){
	var IDP_Org = Form_Org_PNS.getForm().findField('IDP_Org').getValue();
	if(!IDP_Org){
		Form_Org_PNS.getForm().reset();
	}else{
		Form_Org_PNS.getForm().setValues({jenis_org:vcbp_org_jenis_org});
		Form_Org_PNS.getForm().setValues(P_Org_last_record);
	}
	Deactive_Form_Org_PNS();
}

function setValue_Form_Organisasi_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Org_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Org.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_Org_PNS(){
	Ext.getCmp('Tambah_Org').setDisabled(true);
	Ext.getCmp('Ubah_Org').setDisabled(true);
	Ext.getCmp('Simpan_Org').setDisabled(false);
	Ext.getCmp('Batal_Org').setDisabled(false);
	
	Form_Org_PNS.getForm().findField('jenis_org').setDisabled(false);
	Form_Org_PNS.getForm().findField('nama_org').setReadOnly(false);
	Form_Org_PNS.getForm().findField('jabatan_org').setReadOnly(false);
	Form_Org_PNS.getForm().findField('tgl_m_org').setReadOnly(false);
	Form_Org_PNS.getForm().findField('tgl_s_org').setReadOnly(false);
	Form_Org_PNS.getForm().findField('nama_pimp_org').setReadOnly(false);
}

function Deactive_Form_Org_PNS(){
	Ext.getCmp('Tambah_Org').setDisabled(false);
	Ext.getCmp('Ubah_Org').setDisabled(false);
	Ext.getCmp('Simpan_Org').setDisabled(true);
	Ext.getCmp('Batal_Org').setDisabled(true);
	
	Form_Org_PNS.getForm().findField('jenis_org').setDisabled(true);
	Form_Org_PNS.getForm().findField('nama_org').setReadOnly(true);
	Form_Org_PNS.getForm().findField('jabatan_org').setReadOnly(true);
	Form_Org_PNS.getForm().findField('tgl_m_org').setReadOnly(true);
	Form_Org_PNS.getForm().findField('tgl_s_org').setReadOnly(true);
	Form_Org_PNS.getForm().findField('nama_pimp_org').setReadOnly(true);
}
// FUNCTIONS ORGANISASI PNS  ---------------------------------------------------- END

// PANEL ORGANISASI PNS  -------------------------------------------------------- START
var Tab1_Org_PNS = {
	id: 'Tab1_Org_PNS', title: 'Organisasi', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Org]
};

var Tab2_Org_PNS = {
	id: 'Tab2_Org_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Org_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'organisasi_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Org_PNS, Tab2_Org_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Organisasi'){
  			Data_Profil_PNS_Org.load();
  			Deactive_Form_Org_PNS(); 
  			Form_Org_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL ORGANISASI PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>