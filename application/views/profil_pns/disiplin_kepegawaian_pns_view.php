<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_HukDis_last_record;

// TABEL DISIPLIN PEGAWAI PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_HukDis', {extend: 'Ext.data.Model',
  	fields: ['IDP_HukDis', 'NIP', 'kode_hukdis', 'nama_hukdis', 'no_sk_hukdis', 'tgl_sk_hukdis', 'TMT_hukdis', 'TMT_daluarsa', 'catatan_hukdis', 'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_unor', 'nama_unor', 'nama_unker', 'nama_jab']
});

var Reader_Profil_PNS_HukDis = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_HukDis', root: 'results', totalProperty: 'total', idProperty: 'IDP_HukDis'  	
});

var Proxy_Profil_PNS_HukDis = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_disiplin_kepegawaian', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_HukDis
});

var Data_Profil_PNS_HukDis = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_HukDis', model: 'MProfil_PNS_HukDis', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_HukDis
});

var tbProfil_PNS_HukDis = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_HukDis},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_HukDis', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_HukDis.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_HukDis();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_HukDis}
  ]
});

var cbGrid_Profil_PNS_HukDis = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_HukDis = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_HukDis', store: Data_Profil_PNS_HukDis,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_HukDis, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Jabatan", dataIndex: 'nama_jab', width: 200},
  	{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 300},
  	{header: "Unit Kerja", dataIndex: 'nama_unker', width: 300},
  	{header: "Nama Disiplin", dataIndex: 'nama_hukdis', width: 300},
  	{header: "No. SK", dataIndex: 'no_sk_hukdis', width: 200},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_hukdis', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT Disiplin", dataIndex: 'TMT_hukdis', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT Daluarsa", dataIndex: 'TMT_daluarsa', width: 78, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Catatan", dataIndex: 'catatan_hukdis', width: 250}
  ],
  tbar: tbProfil_PNS_HukDis,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_HukDis, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_HukDis_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_HukDis').handler.call(Ext.getCmp("Btn_Ubah_HukDis").scope);}
  		Ext.getCmp('disiplin_kepegawaian_page').setActiveTab('Tab2_HukDis_PNS');
  	}    
  }
});
// TABEL DISIPLIN PEGAWAI PNS  ------------------------------------------------- END

// FORM DISIPLIN PEGAWAI PNS  --------------------------------------------------------- START
var Form_HukDis_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_HukDis_PNS', url: BASE_URL + 'profil_pns/ext_insert_disiplin_kepegawaian',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_HukDis', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_HukDis', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
	    {xtype: 'fieldcontainer', fieldLabel: 'Unit Organisasi', combineErrors: false,
	     defaults: {hideLabel: true, allowBlank: false}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
	     items: [
	     	{xtype: 'hidden', name: 'kode_unor'},
	      {xtype: 'hidden', name: 'kode_jab'},
	      {xtype: 'textfield', name: 'nama_unor', id: 'nama_unor_hukdis', readOnly: true, height: 22, margin: '0 2 0 0', flex: 2},
	      {xtype: 'button', name: 'search_unor', id: 'search_unor_Hukdis', text: '...',
	      	handler: function(){Load_Panel_Ref('win_popup_RefPgwUnor', 'ref_pegawai_unor', 'Form_HukDis_PNS', 1, Ext.getCmp('NIP_HukDis').getValue());}
	      }
	     ], anchor: '50%'
	    },
	    {xtype: 'textareafield', fieldLabel: 'Unit Kerja', name: 'nama_unker', id: 'nama_unker_hukdis', readOnly: true, height: 40, anchor: '50%'},
	    {fieldLabel: 'Jabatan', name: 'nama_jab', id: 'nama_jab_hukdis', readOnly: true, anchor: '50%'},

    	{xtype: 'fieldcontainer', fieldLabel: 'Nama Disiplin', combineErrors: false,
    	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', width: 400, 
    	 items: [
      		{name: 'kode_hukdis', xtype: 'hidden'},
      		{xtype: 'textfield', name: 'nama_hukdis', id: 'nama_hukdis', margin: '0 2 0 0', readOnly: true, flex:2},
      		{xtype: 'button', name: 'search_ref_hukdis', id: 'search_ref_Hukdis', text: '...', 
      			handler: function(){Load_Panel_Ref('win_popup_RefHukDis', 'ref_hukdis', 'Form_HukDis_PNS', 1);}
          }
       ]
    	},
      {fieldLabel: 'No. SK', name: 'no_sk_hukdis', id: 'no_sk_hukdis', width: 350},
      {xtype: 'datefield', fieldLabel: 'Tgl. SK', name: 'tgl_sk_hukdis', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {xtype: 'datefield', fieldLabel: 'TMT Disiplin', name: 'TMT_hukdis', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {xtype: 'datefield', fieldLabel: 'TMT Daluarsa', name: 'TMT_daluarsa', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: true, width: 220},
      {xtype: 'textareafield', fieldLabel: 'Catatan', name: 'catatan_hukdis', id: 'catatan_hukdis', allowBlank: true, width: 400}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_HukDis', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_HukDis();}},
  	{text: 'Ubah', id: 'Ubah_HukDis', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_HukDis();}},
  	{text: 'Simpan', id: 'Simpan_HukDis', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_HukDis();}},
  	{text: 'Batal', id: 'Batal_HukDis', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_HukDis();}}
  ]
});
// FORM DISIPLIN PEGAWAI PNS  --------------------------------------------------------- END

// FUNCTIONS DISIPLIN PEGAWAI PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_HukDis(){
	Ext.getCmp('disiplin_kepegawaian_page').setActiveTab('Tab2_HukDis_PNS');
	Form_HukDis_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_HukDis_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_HukDis_PNS();	
}

function Profil_PNS_Ubah_HukDis(){
	var IDP_HukDis = Form_HukDis_PNS.getForm().findField('IDP_HukDis').getValue();
	if(IDP_HukDis){
		P_HukDis_last_record = Form_HukDis_PNS.getForm().getValues();
		Ext.getCmp('disiplin_kepegawaian_page').setActiveTab('Tab2_HukDis_PNS');
		Active_Form_HukDis_PNS();
	}
}

function Profil_PNS_Simpan_HukDis(){
	Ext.getCmp('Form_HukDis_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_HukDis_PNS').body.mask();}
  });

  Form_HukDis_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_HukDis = obj.info.reason;
  			Form_HukDis_PNS.getForm().setValues({IDP_HukDis:IDP_HukDis});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_HukDis_PNS').body.unmask(); Data_Profil_PNS_HukDis.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_HukDis_PNS();	
  		All_Button_Enabled(); Ext.getCmp('disiplin_kepegawaian_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_HukDis_PNS').body.unmask();
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

function Profil_PNS_Hapus_HukDis(){
  var sm = grid_Profil_PNS_HukDis.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_HukDis') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_disiplin_kepegawaian', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_HukDis.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_HukDis(){
	var IDP_HukDis = Form_HukDis_PNS.getForm().findField('IDP_HukDis').getValue();
	if(!IDP_HukDis){
		Form_HukDis_PNS.getForm().reset();
	}else{
		Form_HukDis_PNS.getForm().setValues(P_HukDis_last_record);
	}
	Deactive_Form_HukDis_PNS();	
}

function setValue_Form_HukDis_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_HukDis_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_HukDis.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_HukDis_PNS(){
	Ext.getCmp('Tambah_HukDis').setDisabled(true);
	Ext.getCmp('Ubah_HukDis').setDisabled(true);
	Ext.getCmp('Simpan_HukDis').setDisabled(false);
	Ext.getCmp('Batal_HukDis').setDisabled(false);
	
	Ext.getCmp('search_unor_Hukdis').setDisabled(false);	
	Ext.getCmp('search_ref_Hukdis').setDisabled(false);	
	Form_HukDis_PNS.getForm().findField('no_sk_hukdis').setReadOnly(false);
	Form_HukDis_PNS.getForm().findField('tgl_sk_hukdis').setReadOnly(false);
	Form_HukDis_PNS.getForm().findField('TMT_hukdis').setReadOnly(false);
	Form_HukDis_PNS.getForm().findField('TMT_daluarsa').setReadOnly(false);
	Form_HukDis_PNS.getForm().findField('catatan_hukdis').setReadOnly(false);
}

function Deactive_Form_HukDis_PNS(){
	Ext.getCmp('Tambah_HukDis').setDisabled(false);
	Ext.getCmp('Ubah_HukDis').setDisabled(false);
	Ext.getCmp('Simpan_HukDis').setDisabled(true);
	Ext.getCmp('Batal_HukDis').setDisabled(true);
	
	Ext.getCmp('search_unor_Hukdis').setDisabled(true);	
	Ext.getCmp('search_ref_Hukdis').setDisabled(true);	
	Form_HukDis_PNS.getForm().findField('no_sk_hukdis').setReadOnly(true);
	Form_HukDis_PNS.getForm().findField('tgl_sk_hukdis').setReadOnly(true);
	Form_HukDis_PNS.getForm().findField('TMT_hukdis').setReadOnly(true);
	Form_HukDis_PNS.getForm().findField('TMT_daluarsa').setReadOnly(true);
	Form_HukDis_PNS.getForm().findField('catatan_hukdis').setReadOnly(true);
}
// FUNCTIONS DISIPLIN PEGAWAI PNS  ---------------------------------------------------- END

// PANEL DISIPLIN PEGAWAI PNS  -------------------------------------------------------- START
var Tab1_HukDis_PNS = {
	id: 'Tab1_HukDis_PNS', title: 'Riwayat Disiplin Pegawai', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_HukDis]
};

var Tab2_HukDis_PNS = {
	id: 'Tab2_HukDis_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_HukDis_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'disiplin_kepegawaian_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_HukDis_PNS, Tab2_HukDis_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Disiplin Pegawai'){
  			Data_Profil_PNS_HukDis.load();
  			Deactive_Form_HukDis_PNS(); 
  			Form_HukDis_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL DISIPLIN PEGAWAI PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>