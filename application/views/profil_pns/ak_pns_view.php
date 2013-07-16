<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_AK_last_record;

// TABEL ANGKA KREDIT PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_AK', {extend: 'Ext.data.Model',
  	fields: ['IDP_AK', 'NIP', 'no_sk_ak', 'tgl_sk_ak', 'TMT_ak', 'mk_th_lama', 'mk_bl_lama', 'ak_utama_lama', 'ak_penunjang_lama', 'total_ak_lama', 'mk_th_baru', 'mk_bl_baru', 'ak_utama_baru', 'ak_penunjang_baru', 'total_ak_baru', 'kode_golru', 'kode_unor', 'nama_pangkat', 'nama_golru']
});

var Reader_Profil_PNS_AK = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_AK', root: 'results', totalProperty: 'total', idProperty: 'IDP_AK'  	
});

var Proxy_Profil_PNS_AK = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_ak', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_AK
});

var Data_Profil_PNS_AK = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_AK', model: 'MProfil_PNS_AK', pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_AK
});

var tbProfil_PNS_AK = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_AK},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_AK', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_AK.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_AK();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_AK}
  ]
});

var cbGrid_Profil_PNS_AK = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_AK = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_AK', store: Data_Profil_PNS_AK, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_AK, columnLines: true, loadMask: true,
	columns: [
  	{header: "No. SK", dataIndex: 'no_sk_ak', width: 130},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_ak', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT", dataIndex: 'TMT_ak', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 130},
  	{header: "Gol. Ruang", dataIndex: 'nama_golru', width: 70},
  	{header: "MKG Lama (Thn)", dataIndex: 'mk_th_lama', width: 95},
  	{header: "MKG Lama (Bln)", dataIndex: 'mk_bl_lama', width: 95},
  	{header: "Nilai Utama Lama", dataIndex: 'ak_utama_lama', width: 130},
  	{header: "Nilai Penunjang Lama", dataIndex: 'ak_penunjang_lama', width: 130},
  	{header: "Total Lama", dataIndex: 'total_ak_lama', width: 130},
  	{header: "MKG Baru (Thn)", dataIndex: 'mk_th_baru', width: 95},
  	{header: "MKG Baru (Bln)", dataIndex: 'mk_bl_baru', width: 95},
  	{header: "Nilai Utama Baru", dataIndex: 'ak_utama_baru', width: 130},
  	{header: "Nilai Penunjang Baru", dataIndex: 'ak_penunjang_baru', width: 130},
  	{header: "Total Baru", dataIndex: 'total_ak_baru', width: 130}
  ],
  tbar: tbProfil_PNS_AK,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_AK, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_AK_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('ak_page').setActiveTab('Tab2_AK_PNS');
  	}    
  }
});
// TABEL ANGKA KREDIT PNS  ------------------------------------------------- END

// FORM ANGKA KREDIT PNS  --------------------------------------------------------- START
var Form_AK_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_AK_PNS', url: BASE_URL + 'profil_pns/ext_insert_ak',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_AK', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_ak', xtype: 'hidden'}, {name: 'kode_unor', id: 'kode_unor_ak', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 1px;',
     items: [
	    {xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
	     defaults: {hideLabel: true, allowBlank: false}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
	     items: [
	     		{name: 'kode_golru', xtype: 'hidden', id: 'kode_golru_ak'},
	     		{fieldLabel: 'Pangkat', xtype: 'textfield', name: 'nama_pangkat', id: 'nama_pangkat_ak', readOnly: true, height: 22, margin: '0 2 0 0', width: 175},
      		{fieldLabel: 'Golru', xtype: 'textfield', name: 'nama_golru', id: 'nama_golru_ak', height: 22, margin: '0 2 0 0', readOnly: true, width: 50},
	     		{xtype: 'button', name: 'search_pangkat', id: 'search_pangkat_ProfilAK', text: '...',
	     		 handler: function(){Load_Panel_Ref('win_popup_RefPgwPangkat', 'ref_pegawai_pangkat', 'Form_AK_PNS', 1, Ext.getCmp('NIP_ak').getValue());}
	       	}
	     ], width: 400
	    },
    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Masa Kerja Gol. Lama', defaults: {hideLabel: true}, combineErrors: false,
     	 defaultType: 'numberfield', width: 320,
     	 items: [
      	{fieldLabel: 'MK Th', name: 'mk_th_lama', id: 'mk_th_lama', value: 0, minValue: 0, maxValue: 60, margins: '0 5 0 0', width:50},
      	{xtype: 'label', forId: 'mk_th_lama', text: 'Thn.', margins: '3 15 0 0'},
      	{fieldLabel: 'MK Bl', name: 'mk_bl_lama', id: 'mk_bl_lama', value: 0, minValue: 0, maxValue: 12, width:50},
      	{xtype: 'label', forId: 'mk_bl_lama', text: 'Bln.', margins: '3 15 0 5'}
     	 ]
    	},
    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Masa Kerja Gol. Baru', defaults: {hideLabel: true}, combineErrors: false,
     	 defaultType: 'numberfield', width: 320,
     	 items: [
      	{fieldLabel: 'MK Th', name: 'mk_th_baru', id: 'mk_th_baru', value: 0, minValue: 0, maxValue: 60, margins: '0 5 0 0', width:50},
      	{xtype: 'label', forId: 'mk_th_baru', text: 'Thn.', margins: '3 15 0 0'},
      	{fieldLabel: 'MK Bl', name: 'mk_bl_baru', id: 'mk_bl_baru', value: 0, minValue: 0, maxValue: 12, width:50},
      	{xtype: 'label', forId: 'mk_bl_baru', text: 'Bln.', margins: '3 15 0 5'}
     	 ]
    	},
      {fieldLabel: 'Nomor SK', name: 'no_sk_ak', id: 'no_sk_ak', width: 400},
      {xtype: 'datefield', fieldLabel: 'Tanggal SK', name: 'tgl_sk_ak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230},
      {xtype: 'datefield', fieldLabel: 'TMT PAK', name: 'TMT_ak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230},
  	 	{xtype: 'fieldset', width: 450, title: 'N i l a i', margins: '0 5 0 5', style: 'padding: 5px; text-align: left;',
  	 	 items: [
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'PAK Utama Lama', name: 'ak_utama_lama', flex:1, listeners: {'change': {fn: function (){Hitung_AK();},scope:this}}},
      	 		{fieldLabel: 'PAK Penunjang Lama', name: 'ak_penunjang_lama', flex:1, listeners: {'change': {fn: function (){Hitung_AK();},scope:this}}},
      	 		{fieldLabel: 'Total PAK Lama', name: 'total_ak_lama', flex:1}
     	   ]
    	 	},
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'PAK Utama Baru', name: 'ak_utama_baru', flex:1, listeners: {'change': {fn: function (){Hitung_AK();},scope:this}}},
      	 		{fieldLabel: 'PAK Penunjang Baru', name: 'ak_penunjang_baru', flex:1, listeners: {'change': {fn: function (){Hitung_AK();},scope:this}}},
      	 		{fieldLabel: 'Total PAK Baru', name: 'total_ak_baru', flex:1}
     	   ]
    	 	},
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'Total PAK (Lama + Baru)', name: 'total_ak_lb'}
     	   ]
    	 	}
  	 	 ]
  	 	}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_AK', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_AK();}},
  	{text: 'Ubah', id: 'Ubah_AK', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_AK();}},
  	{text: 'Simpan', id: 'Simpan_AK', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_AK();}},
  	{text: 'Batal', id: 'Batal_AK', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_AK();}}
  ]
});
// FORM ANGKA KREDIT PNS  --------------------------------------------------------- END

// FUNCTIONS ANGKA KREDIT PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_AK(){
	Ext.getCmp('ak_page').setActiveTab('Tab2_AK_PNS');
	Form_AK_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_AK_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_AK_PNS();	
}

function Profil_PNS_Ubah_AK(){
	var IDP_AK = Form_AK_PNS.getForm().findField('IDP_AK').getValue();
	if(IDP_AK){
		P_AK_last_record = Form_AK_PNS.getForm().getValues();
		Ext.getCmp('ak_page').setActiveTab('Tab2_AK_PNS');
		Active_Form_AK_PNS();	
	}
}

function Profil_PNS_Simpan_AK(){
	Ext.getCmp('Form_AK_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_AK_PNS').body.mask();}
  });
	
  Form_AK_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_AK = obj.info.reason;
  			Form_AK_PNS.getForm().setValues({IDP_AK:IDP_AK});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_AK_PNS').body.unmask(); Data_Profil_PNS_AK.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_AK_PNS();	
  		All_Button_Enabled(); Ext.getCmp('ak_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_AK_PNS').body.unmask();
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

function Profil_PNS_Hapus_AK(){
  var sm = grid_Profil_PNS_AK.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_AK') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_ak', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_AK.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_AK(){
	var IDP_AK = Form_AK_PNS.getForm().findField('IDP_AK').getValue();
	if(!IDP_AK){
		Form_AK_PNS.getForm().reset();
	}else{
		Form_AK_PNS.getForm().setValues(P_AK_last_record);
	}
	Deactive_Form_AK_PNS();	
}

function setValue_Form_AK_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_AK_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_AK.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_AK_PNS(){
	Ext.getCmp('Tambah_AK').setDisabled(true);
	Ext.getCmp('Ubah_AK').setDisabled(true);
	Ext.getCmp('Simpan_AK').setDisabled(false);
	Ext.getCmp('Batal_AK').setDisabled(false);
	
	Ext.getCmp('search_pangkat_ProfilAK').setDisabled(false);
	Form_AK_PNS.getForm().findField('mk_th_lama').setReadOnly(false);
	Form_AK_PNS.getForm().findField('mk_bl_lama').setReadOnly(false);
	Form_AK_PNS.getForm().findField('mk_th_baru').setReadOnly(false);
	Form_AK_PNS.getForm().findField('mk_bl_baru').setReadOnly(false);
	Form_AK_PNS.getForm().findField('no_sk_ak').setReadOnly(false);
	Form_AK_PNS.getForm().findField('tgl_sk_ak').setReadOnly(false);
	Form_AK_PNS.getForm().findField('TMT_ak').setReadOnly(false);
	Form_AK_PNS.getForm().findField('ak_utama_lama').setReadOnly(false);
	Form_AK_PNS.getForm().findField('ak_penunjang_lama').setReadOnly(false);
	Form_AK_PNS.getForm().findField('total_ak_lama').setReadOnly(false);
	Form_AK_PNS.getForm().findField('ak_utama_baru').setReadOnly(false);
	Form_AK_PNS.getForm().findField('ak_penunjang_baru').setReadOnly(false);
	Form_AK_PNS.getForm().findField('total_ak_baru').setReadOnly(false);
	Form_AK_PNS.getForm().findField('total_ak_lb').setReadOnly(false);
}

function Deactive_Form_AK_PNS(){
	Ext.getCmp('Tambah_AK').setDisabled(false);
	Ext.getCmp('Ubah_AK').setDisabled(false);
	Ext.getCmp('Simpan_AK').setDisabled(true);
	Ext.getCmp('Batal_AK').setDisabled(true);
	
	Ext.getCmp('search_pangkat_ProfilAK').setDisabled(true);
	Form_AK_PNS.getForm().findField('mk_th_lama').setReadOnly(true);
	Form_AK_PNS.getForm().findField('mk_bl_lama').setReadOnly(true);
	Form_AK_PNS.getForm().findField('mk_th_baru').setReadOnly(true);
	Form_AK_PNS.getForm().findField('mk_bl_baru').setReadOnly(true);
	Form_AK_PNS.getForm().findField('no_sk_ak').setReadOnly(true);
	Form_AK_PNS.getForm().findField('tgl_sk_ak').setReadOnly(true);
	Form_AK_PNS.getForm().findField('TMT_ak').setReadOnly(true);
	Form_AK_PNS.getForm().findField('ak_utama_lama').setReadOnly(true);
	Form_AK_PNS.getForm().findField('ak_penunjang_lama').setReadOnly(true);
	Form_AK_PNS.getForm().findField('total_ak_lama').setReadOnly(true);
	Form_AK_PNS.getForm().findField('ak_utama_baru').setReadOnly(true);
	Form_AK_PNS.getForm().findField('ak_penunjang_baru').setReadOnly(true);
	Form_AK_PNS.getForm().findField('total_ak_baru').setReadOnly(true);
	Form_AK_PNS.getForm().findField('total_ak_lb').setReadOnly(true);
}

function Hitung_AK(){
	var ak_utama_lama = parseInt(Form_AK_PNS.getForm().findField('ak_utama_lama').getValue());
	var ak_penunjang_lama = parseInt(Form_AK_PNS.getForm().findField('ak_penunjang_lama').getValue());
	if(isNaN(ak_utama_lama)){ak_utama_lama=0;}
	if(isNaN(ak_penunjang_lama)){ak_penunjang_lama=0;}
	var total_ak_lama = ak_utama_lama + ak_penunjang_lama;
	Form_AK_PNS.getForm().findField('total_ak_lama').setValue(total_ak_lama);

	var ak_utama_baru = parseInt(Form_AK_PNS.getForm().findField('ak_utama_baru').getValue());
	var ak_penunjang_baru = parseInt(Form_AK_PNS.getForm().findField('ak_penunjang_baru').getValue());
	if(isNaN(ak_utama_baru)){ak_utama_baru=0;}
	if(isNaN(ak_penunjang_baru)){ak_penunjang_baru=0;}
	var total_ak_baru = ak_utama_baru + ak_penunjang_baru;
	Form_AK_PNS.getForm().findField('total_ak_baru').setValue(total_ak_baru);

	if(isNaN(total_ak_lama)){total_ak_lama=0;}
	if(isNaN(total_ak_baru)){total_ak_baru=0;}
	var total_ak_lb = total_ak_lama + total_ak_baru;
	Form_AK_PNS.getForm().findField('total_ak_lb').setValue(total_ak_lb);
}
// FUNCTIONS ANGKA KREDIT PNS  ---------------------------------------------------- END

// PANEL ANGKA KREDIT PNS  -------------------------------------------------------- START
var Tab1_AK_PNS = {
	id: 'Tab1_AK_PNS', title: 'Riwayat Penetapan Angka Kredit', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_AK]
};

var Tab2_AK_PNS = {
	id: 'Tab2_AK_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_AK_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'ak_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_AK_PNS, Tab2_AK_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Penetapan Angka Kredit'){
  			Data_Profil_PNS_AK.load(); Deactive_Form_AK_PNS(); Form_AK_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL ANGKA KREDIT PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>