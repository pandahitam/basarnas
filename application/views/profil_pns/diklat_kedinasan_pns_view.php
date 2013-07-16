<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_DIKLAT_last_record, vcbp_dik_kode_jns_diklat, vcbp_dik_kode_sumber_dana, vcbp_dik_angkatan;

// TABEL DIKLAT KEDINASAN PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Diklat', {extend: 'Ext.data.Model',
  	fields: ['IDP_Diklat', 'NIP', 'kode_diklat', 'kode_jns_diklat', 'jns_diklat', 'nama_diklat', 'penyelenggara', 'lokasi', 'kode_sumber_dana', 'nama_sumber_dana', 'tgl_mulai', 'tgl_selesai', 'lama_diklat', 'angkatan', 'no_sttpp', 'tgl_sttpp']
});

var Reader_Profil_PNS_Diklat = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Diklat', root: 'results', totalProperty: 'total', idProperty: 'IDP_Diklat'  	
});

var Proxy_Profil_PNS_Diklat = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_diklat_kedinasan', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_Diklat
});

var Data_Profil_PNS_Diklat = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Diklat', model: 'MProfil_PNS_Diklat', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Diklat, groupField: 'jns_diklat'
});

var Grouping_Profil_PNS_Diklat = Ext.create('Ext.grid.feature.Grouping',{
		id: 'Grouping_Profil_PNS_Diklat', groupHeaderTpl: 'Jenis Diklat : {name} ({rows.length} Item{[values.rows.length > 1 ? "s on this page" : " on this page"]})'
});

var tbProfil_PNS_Diklat = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Diklat},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Diklat', disabled: ppns_update,
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Diklat.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Diklat();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Diklat}
  ]
});

var cbGrid_Profil_PNS_Diklat = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Diklat = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Diklat', store: Data_Profil_PNS_Diklat,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Diklat, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Diklat", dataIndex: 'nama_diklat', groupable: false, width: 150},
  	{header: "Penyelenggara", dataIndex: 'penyelenggara', groupable: false, width: 150},
  	{header: "Lokasi", dataIndex: 'lokasi', groupable: false, width: 180},
  	{header: "Lama", dataIndex: 'lama_diklat', groupable: false, width: 75},
  	{header: "Tgl. Mulai", dataIndex: 'tgl_mulai', groupable: false, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tgl. Selesai", dataIndex: 'tgl_selesai', groupable: false, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
  ],
  features: [Grouping_Profil_PNS_Diklat],
  tbar: tbProfil_PNS_Diklat,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Profil_PNS_Diklat, dock: 'bottom', displayInfo: true}],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Diklat_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_Diklat').handler.call(Ext.getCmp("Btn_Ubah_Diklat").scope);}
  		Ext.getCmp('diklat_kedinasan_page').setActiveTab('Tab2_Diklat_PNS');
  	}    
  }
});

// TABEL DIKLAT KEDINASAN PNS  ------------------------------------------------- END

// FORM DIKLAT KEDINASAN PNS  --------------------------------------------------------- START
var Form_Diklat_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Diklat_PNS', url: BASE_URL + 'profil_pns/ext_insert_diklat_kedinasan',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 130},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_Diklat', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Diklat', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
     	{xtype: 'combobox', fieldLabel: 'Jenis Diklat', name: 'kode_jns_diklat', id: 'kode_jns_diklat', hiddenName: 'kode_jns_diklat',
       store: new Ext.data.Store({
       	fields: ['kode_jns_diklat','jns_diklat'], idProperty: 'ID_Diklat',
       	proxy: new Ext.data.AjaxProxy({
    			url: BASE_URL + 'combo_ref/combo_jenis_diklat', method: 'POST', extraParams :{id_open: '1'}
    	 	}), autoLoad: true
       }),
       valueField: 'kode_jns_diklat', displayField: 'jns_diklat', typeAhead: true, forceSelection: false, selectOnFocus: true,
       listeners: {
       	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }, width: 300
      },
    	{xtype: 'fieldcontainer', fieldLabel: 'Nama Diklat', combineErrors: false,
    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 400, 
    	 items: [
      		{name: 'kode_diklat', xtype: 'hidden'},
      		{xtype: 'textfield', name: 'nama_diklat', id: 'nama_diklat', margin: '0 2 0 0', readOnly: true, flex:2},
      		{xtype: 'button', name: 'search_diklat', id: 'search_diklat_ProfilDiklat', text: '...', 
      			handler: function(){Load_Panel_Ref('win_popup_RefDiklat', 'ref_diklat', 'Form_Diklat_PNS', 1);}
          }
       ]
    	},
      {fieldLabel: 'Penyelenggara', name: 'penyelenggara', id: 'penyelenggara', width: 400},
      {fieldLabel: 'Lokasi', name: 'lokasi', id: 'lokasi', width: 400},
     	{xtype: 'combobox', fieldLabel: 'Sumber Dana', name: 'kode_sumber_dana', id: 'kode_sumber_dana', hiddenName: 'kode_sumber_dana',
       store: new Ext.data.Store({
       	fields: ['kode_sumber_dana','nama_sumber_dana'], idProperty: 'ID_SD',
       	proxy: new Ext.data.AjaxProxy({
    			url: BASE_URL + 'combo_ref/combo_sumber_dana', method: 'POST', extraParams :{id_open: '1'}
    	 	}), autoLoad: true
       }),
       valueField: 'kode_sumber_dana', displayField: 'nama_sumber_dana',
       typeAhead: true, forceSelection: false, selectOnFocus: true,
       listeners: {
       	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }, width: 300
      },
    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Tgl. Mulai - Selesai', defaults: {hideLabel: true}, combineErrors: false,
     	 defaultType: 'datefield', width: 355,
     	 items: [
      		{fieldLabel: 'Tgl. Mulai', name: 'tgl_mulai', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', margins: '0 5 0 0', flex:1,
      		 listeners: {
      		 	'change': {fn: function (df, newValue, oldValue){Form_Diklat_PNS.getForm().findField('tgl_selesai').setValue(newValue);}, scope: this}
      		 }
      		},
      		{fieldLabel: 'Tgl. Selesai', name: 'tgl_selesai', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', margins: '0 5 0 0', flex:1,
      		 listeners: {
      		 	'change': {fn: function (df, newValue, oldValue){Form_Diklat_PNS.getForm().findField('tgl_sttpp').setValue(newValue);}, scope: this}
      		 }
      		}
     	 ]
    	},
    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Lama Diklat', defaults: {hideLabel: true}, combineErrors: false,
     	 defaultType: 'textfield', width: 400,
     	 items: [
      		{fieldLabel: 'Lama Diklat', name: 'lama_diklat', id: 'lama_diklat', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, margins: '0 5 0 0', flex:1},
      		{xtype: 'label', forId: 'lama_diklat', text: 'Jam', margins: '3 15 0 0'},
     			{xtype: 'combobox', fieldLabel: 'Angkatan', name: 'angkatan', labelWidth: 80,
       		 store: new Ext.data.SimpleStore({data: [['I'],['II'],['III'],['IV'],['V'],['VI'],['VII'],['VIII'],['IX'],['X'],['XI'],['XII'],['XIII'],['XIV'],['XV'],['XVI'],['XVII'],['XVIII'],['XIX'],['XX'],['XXI'],['XXII'],['XXIII'],['XXIV'],['XXV'],['XXVI'],['XXVII'],['XXVIII'],['XXIX'],['XXX']], fields: ['angkatan']}),
       		 valueField: 'angkatan', displayField: 'angkatan', hideLabel: false, labelAlign: 'right',
       		 queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
       		 listeners: {
       				'focus': {fn: function (comboField) {comboField.expand();}, scope: this}
       		 }, flex:2
      		}      		
     	 ]
    	},
      {fieldLabel: 'No. STTPP', name: 'no_sttpp', id: 'no_sttpp', width: 400},
      {xtype: 'datefield', fieldLabel: 'Tgl. STTPP', name: 'tgl_sttpp', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 240}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Diklat', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Diklat();}},
  	{text: 'Ubah', id: 'Ubah_Diklat', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Diklat();}},
  	{text: 'Simpan', id: 'Simpan_Diklat', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Diklat();}},
  	{text: 'Batal', id: 'Batal_Diklat', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Diklat();}}
  ]
});
// FORM DIKLAT KEDINASAN PNS  --------------------------------------------------------- END

// FUNCTIONS DIKLAT KEDINASAN PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Diklat(){
	Ext.getCmp('diklat_kedinasan_page').setActiveTab('Tab2_Diklat_PNS');
	Form_Diklat_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Diklat_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_Diklat_PNS();
}

function Profil_PNS_Ubah_Diklat(){
	var IDP_Diklat = Form_Diklat_PNS.getForm().findField('IDP_Diklat').getValue();
	if(IDP_Diklat){
		vcbp_dik_kode_jns_diklat = Form_Diklat_PNS.getForm().findField('kode_jns_diklat').getValue();
		vcbp_dik_kode_sumber_dana = Form_Diklat_PNS.getForm().findField('kode_sumber_dana').getValue();
		vcbp_dik_angkatan = Form_Diklat_PNS.getForm().findField('angkatan').getValue();
		P_DIKLAT_last_record = Form_Diklat_PNS.getForm().getValues();
		Ext.getCmp('diklat_kedinasan_page').setActiveTab('Tab2_Diklat_PNS');
		Active_Form_Diklat_PNS();
	}
}

function Profil_PNS_Simpan_Diklat(){
	Ext.getCmp('Form_Diklat_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Diklat_PNS').body.mask();}
  });

  Form_Diklat_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Diklat = obj.info.reason;
  			Form_Diklat_PNS.getForm().setValues({IDP_Diklat:IDP_Diklat});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Diklat_PNS').body.unmask(); Data_Profil_PNS_Diklat.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Diklat_PNS();
  		All_Button_Enabled(); Ext.getCmp('diklat_kedinasan_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Diklat_PNS').body.unmask();
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

function Profil_PNS_Hapus_Diklat(){
  var sm = grid_Profil_PNS_Diklat.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Diklat') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_diklat_kedinasan', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Diklat.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Diklat(){
	var IDP_Diklat = Form_Diklat_PNS.getForm().findField('IDP_Diklat').getValue();
	if(!IDP_Diklat){
		Form_Diklat_PNS.getForm().reset();
	}else{
		Form_Diklat_PNS.getForm().setValues({kode_jns_diklat:vcbp_dik_kode_jns_diklat, kode_sumber_dana:vcbp_dik_kode_sumber_dana, angkatan:vcbp_dik_angkatan});
		Form_Diklat_PNS.getForm().setValues(P_DIKLAT_last_record);
	}
	Deactive_Form_Diklat_PNS();
}

function setValue_Form_Diklat_Kedinasan_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Diklat_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Diklat.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_Diklat_PNS(){
	Ext.getCmp('Tambah_Diklat').setDisabled(true);
	Ext.getCmp('Ubah_Diklat').setDisabled(true);
	Ext.getCmp('Simpan_Diklat').setDisabled(false);
	Ext.getCmp('Batal_Diklat').setDisabled(false);
	
	Form_Diklat_PNS.getForm().findField('kode_jns_diklat').setDisabled(false);
	Form_Diklat_PNS.getForm().findField('nama_diklat').setReadOnly(false);
	Ext.getCmp('search_diklat_ProfilDiklat').setDisabled(false);	
	Form_Diklat_PNS.getForm().findField('penyelenggara').setReadOnly(false);
	Form_Diklat_PNS.getForm().findField('kode_sumber_dana').setDisabled(false);
	Form_Diklat_PNS.getForm().findField('tgl_mulai').setReadOnly(false);
	Form_Diklat_PNS.getForm().findField('tgl_selesai').setReadOnly(false);
	Form_Diklat_PNS.getForm().findField('lama_diklat').setReadOnly(false);
	Form_Diklat_PNS.getForm().findField('angkatan').setDisabled(false);
	Form_Diklat_PNS.getForm().findField('no_sttpp').setReadOnly(false);
	Form_Diklat_PNS.getForm().findField('tgl_sttpp').setReadOnly(false);
}

function Deactive_Form_Diklat_PNS(){
	Ext.getCmp('Tambah_Diklat').setDisabled(false);
	Ext.getCmp('Ubah_Diklat').setDisabled(false);
	Ext.getCmp('Simpan_Diklat').setDisabled(true);
	Ext.getCmp('Batal_Diklat').setDisabled(true);
	
	Form_Diklat_PNS.getForm().findField('kode_jns_diklat').setDisabled(true);
	Form_Diklat_PNS.getForm().findField('nama_diklat').setReadOnly(true);
	Ext.getCmp('search_diklat_ProfilDiklat').setDisabled(true);	
	Form_Diklat_PNS.getForm().findField('penyelenggara').setReadOnly(true);
	Form_Diklat_PNS.getForm().findField('kode_sumber_dana').setDisabled(true);
	Form_Diklat_PNS.getForm().findField('tgl_mulai').setReadOnly(true);
	Form_Diklat_PNS.getForm().findField('tgl_selesai').setReadOnly(true);
	Form_Diklat_PNS.getForm().findField('lama_diklat').setReadOnly(true);
	Form_Diklat_PNS.getForm().findField('angkatan').setDisabled(true);
	Form_Diklat_PNS.getForm().findField('no_sttpp').setReadOnly(true);
	Form_Diklat_PNS.getForm().findField('tgl_sttpp').setReadOnly(true);
}

// FUNCTIONS DIKLAT KEDINASAN PNS  ---------------------------------------------------- END

// PANEL DIKLAT KEDINASAN PNS  -------------------------------------------------------- START
var Tab1_Diklat_PNS = {
	id: 'Tab1_Diklat_PNS', title: 'Riwayat Diklat', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Diklat]
};

var Tab2_Diklat_PNS = {
	id: 'Tab2_Diklat_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Diklat_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'diklat_kedinasan_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Diklat_PNS, Tab2_Diklat_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Diklat'){
  			Data_Profil_PNS_Diklat.load();
  			Deactive_Form_Diklat_PNS();
  			Form_Diklat_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL DIKLAT KEDINASAN PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>