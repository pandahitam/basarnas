<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_KT_last_record, vcbp_kt_jenis_KT;

// TABEL KARYA TULIS PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_KT', {extend: 'Ext.data.Model',
  	fields: ['IDP_KT', 'NIP', 'judul_KT', 'jenis_KT', 'media_pub_KT', 'tgl_publ_KT', 'ringkasan_KT']
});

var Reader_Profil_PNS_KT = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_KT', root: 'results', totalProperty: 'total', idProperty: 'IDP_KT'  	
});

var Proxy_Profil_PNS_KT = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_karya_tulis', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_KT
});

var Data_Profil_PNS_KT = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_KT', model: 'MProfil_PNS_KT', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_KT
});

var tbProfil_PNS_KT = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_KT},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_KT', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_KT.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_KT();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_KT}
  ]
});

var cbGrid_Profil_PNS_KT = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_KT = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_KT', store: Data_Profil_PNS_KT,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_KT, columnLines: true, loadMask: true,
	columns: [
  	{header: "Jenis", dataIndex: 'jenis_KT', width: 100},
  	{header: "Judul Karya Tulis", dataIndex: 'judul_KT', width: 250},
  	{header: "Publikasi", dataIndex: 'media_pub_KT', width: 150},
  	{header: "Tgl. Publikasi", dataIndex: 'tgl_publ_KT', width: 80, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Ringkasan", dataIndex: 'ringkasan_KT', width: 300}
  ],
  tbar: tbProfil_PNS_KT,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_KT, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_KT_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_KT').handler.call(Ext.getCmp("Btn_Ubah_KT").scope);}
  		Ext.getCmp('karya_tulis_page').setActiveTab('Tab2_KT_PNS');
  	}    
  }
});
// TABEL KARYA TULIS PNS  ------------------------------------------------- END

// FORM KARYA TULIS PNS  --------------------------------------------------------- START
var Form_KT_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_KT_PNS', url: BASE_URL + 'profil_pns/ext_insert_karya_tulis',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 100},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_KT', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_KT', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
     	{xtype: 'combobox', fieldLabel: 'Jenis', name: 'jenis_KT', width: 250,
       store: new Ext.data.SimpleStore({data: [['Karya Tulis Ilmiah'],['Makalah'],['Karangan'],['Essay'],['Resume/Sinopsis'],['Jurnal'],['Skripsi'],['Tesis'],['Disertasi']], fields: ['jenis_KT']}),
       valueField: 'jenis_KT', displayField: 'jenis_KT', emptyText: 'Jenis',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }
      },
      {fieldLabel: 'Judul', name: 'judul_KT', id: 'judul_KT', width: 350},
      {fieldLabel: 'Publikasi', name: 'media_pub_KT', id: 'media_pub_KT', width: 350},
      {xtype: 'datefield', fieldLabel: 'Tgl. tgl_publ_KT', name: 'tgl_publ_KT', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
      {xtype: 'textareafield', fieldLabel: 'Ringkasan', name: 'ringkasan_KT', id: 'ringkasan_KT', width: 350}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_KT', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_KT();}},
  	{text: 'Ubah', id: 'Ubah_KT', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_KT();}},
  	{text: 'Simpan', id: 'Simpan_KT', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_KT();}},
  	{text: 'Batal', id: 'Batal_KT', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_KT();}}
  ]
});
// FORM KARYA TULIS PNS  --------------------------------------------------------- END

// FUNCTIONS KARYA TULIS PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_KT(){
	Ext.getCmp('karya_tulis_page').setActiveTab('Tab2_KT_PNS');
	Form_KT_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KT_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_KT_PNS();	
}

function Profil_PNS_Ubah_KT(){
	var IDP_KT = Form_KT_PNS.getForm().findField('IDP_KT').getValue();
	if(IDP_KT){
		vcbp_kt_jenis_KT = Form_KT_PNS.getForm().findField('jenis_KT').getValue();
		P_KT_last_record = Form_KT_PNS.getForm().getValues();
		Ext.getCmp('karya_tulis_page').setActiveTab('Tab2_KT_PNS');
		Active_Form_KT_PNS();
	}
}

function Profil_PNS_Simpan_KT(){
	Ext.getCmp('Form_KT_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_KT_PNS').body.mask();}
  });

  Form_KT_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_KT = obj.info.reason;
  			Form_KT_PNS.getForm().setValues({IDP_KT:IDP_KT});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_KT_PNS').body.unmask(); Data_Profil_PNS_KT.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_KT_PNS();
  		All_Button_Enabled(); Ext.getCmp('karya_tulis_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_KT_PNS').body.unmask();
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

function Profil_PNS_Hapus_KT(){
  var sm = grid_Profil_PNS_KT.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_KT') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_karya_tulis', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_KT.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_KT(){
	var IDP_KT = Form_KT_PNS.getForm().findField('IDP_KT').getValue();
	if(!IDP_KT){
		Form_KT_PNS.getForm().reset();
	}else{
		Form_KT_PNS.getForm().setValues({jenis_KT:vcbp_kt_jenis_KT});
		Form_KT_PNS.getForm().setValues(P_KT_last_record);
	}
	Deactive_Form_KT_PNS();
}

function setValue_Form_Karya_Tulis_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KT_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_KT.changeParams({params :{id_open: '1', NIP: vNIP}});
}

function Active_Form_KT_PNS(){
	Ext.getCmp('Tambah_KT').setDisabled(true);
	Ext.getCmp('Ubah_KT').setDisabled(true);
	Ext.getCmp('Simpan_KT').setDisabled(false);
	Ext.getCmp('Batal_KT').setDisabled(false);
	
	Form_KT_PNS.getForm().findField('jenis_KT').setDisabled(false);
	Form_KT_PNS.getForm().findField('judul_KT').setReadOnly(false);
	Form_KT_PNS.getForm().findField('media_pub_KT').setReadOnly(false);
	Form_KT_PNS.getForm().findField('tgl_publ_KT').setReadOnly(false);
	Form_KT_PNS.getForm().findField('ringkasan_KT').setReadOnly(false);
}

function Deactive_Form_KT_PNS(){
	Ext.getCmp('Tambah_KT').setDisabled(false);
	Ext.getCmp('Ubah_KT').setDisabled(false);
	Ext.getCmp('Simpan_KT').setDisabled(true);
	Ext.getCmp('Batal_KT').setDisabled(true);
	
	Form_KT_PNS.getForm().findField('jenis_KT').setDisabled(true);
	Form_KT_PNS.getForm().findField('judul_KT').setReadOnly(true);
	Form_KT_PNS.getForm().findField('media_pub_KT').setReadOnly(true);
	Form_KT_PNS.getForm().findField('tgl_publ_KT').setReadOnly(true);
	Form_KT_PNS.getForm().findField('ringkasan_KT').setReadOnly(true);
}
// FUNCTIONS KARYA TULIS PNS  ---------------------------------------------------- END

// PANEL KARYA TULIS PNS  -------------------------------------------------------- START
var Tab1_KT_PNS = {
	id: 'Tab1_KT_PNS', title: 'Riwayat Karya Tulis', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_KT]
};

var Tab2_KT_PNS = {
	id: 'Tab2_KT_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_KT_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'karya_tulis_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_KT_PNS, Tab2_KT_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Karya Tulis'){
  			Data_Profil_PNS_KT.load();
  			Deactive_Form_KT_PNS(); 
  			Form_KT_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL KARYA TULIS PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>