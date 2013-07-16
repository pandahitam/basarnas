<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_KGB_last_record;

// TABEL GAJI BERKALA PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_KGB', {extend: 'Ext.data.Model',
  	fields: ['IDP_KGB', 'NIP', 'no_sk_lama', 'tgl_sk_lama', 'gapok_lama', 'mk_bl_kgb', 'mk_th_kgb', 'no_sk_kgb', 'tgl_sk_kgb', 'mk_baru', 'TMT_kgb', 'TMT_berikutnya', 'gapok_baru', 'kode_golru', 'kode_unor', 'nama_unor', 'nama_eselon', 'nama_pangkat', 'nama_golru']
});

var Reader_Profil_PNS_KGB = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_KGB', root: 'results', totalProperty: 'total', idProperty: 'IDP_KGB'  	
});

var Proxy_Profil_PNS_KGB = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_gaji_berkala', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_KGB
});

var Data_Profil_PNS_KGB = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_KGB', model: 'MProfil_PNS_KGB', pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_KGB
});

var tbProfil_PNS_KGB = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_KGB},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_KGB', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_KGB.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_KGB();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_KGB}
  ]
});

var cbGrid_Profil_PNS_KGB = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_KGB = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_KGB', store: Data_Profil_PNS_KGB, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_KGB, columnLines: true, loadMask: true,
	columns: [
  	{header: "No. SK KGB", dataIndex: 'no_sk_kgb', width: 150},
  	{header: "Tgl. SK KGB", dataIndex: 'tgl_sk_kgb', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 130},
  	{header: "Gol. Ruang", dataIndex: 'nama_golru', width: 70},
  	{header: "MKG Th", dataIndex: 'mk_th_kgb', width: 60, hidden: true},
  	{header: "MKG Bl", dataIndex: 'mk_bl_kgb', width: 60, hidden: true},
  	{header: "Gaji Pokok", dataIndex: 'gapok_baru',
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {return Ext.util.Format.currency(value, 'Rp. ');},
  	 width: 100
  	},
  	{header: "TMT KGB", dataIndex: 'TMT_kgb', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT Y.a.d", dataIndex: 'TMT_berikutnya', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
  ],
  tbar: tbProfil_PNS_KGB,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_KGB, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_KGB_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_KGB').handler.call(Ext.getCmp("Btn_Ubah_KGB").scope);}
  		Ext.getCmp('gaji_berkala_page').setActiveTab('Tab2_KGB_PNS');
  	}    
  }
});
// TABEL GAJI BERKALA PNS  ------------------------------------------------- END

// FORM GAJI BERKALA PNS  --------------------------------------------------------- START
var Form_KGB_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_KGB_PNS', url: BASE_URL + 'profil_pns/ext_insert_gaji_berkala',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_KGB', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_kgb', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left'}, margins: '0 0 0 0', style: 'padding: 10px 5px 5px 15px; border-width: 0px;',
     items: [
	    {xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
	     defaults: {hideLabel: true, allowBlank: false}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
	     items: [
	     		{name: 'kode_golru', xtype: 'hidden', id: 'kode_golru_kgb',
	     		 listeners: {'change': {fn: function () {Get_Gapok_KGB();}}}
	     		},
	     		{fieldLabel: 'Pangkat', xtype: 'textfield', name: 'nama_pangkat', id: 'nama_pangkat_kgb', readOnly: true, height: 22, margin: '0 2 0 0', width: 175},
      		{fieldLabel: 'Golru', xtype: 'textfield', name: 'nama_golru', id: 'nama_golru_kgb', height: 22, margin: '0 2 0 0', readOnly: true, width: 50},
	     		{xtype: 'button', name: 'search_pangkat', id: 'search_pangkat_ProfilKGB', text: '...',
	     		 handler: function(){Load_Panel_Ref('win_popup_RefPgwPangkat', 'ref_pegawai_pangkat', 'Form_KGB_PNS', 1, Ext.getCmp('NIP_kgb').getValue());}
	       	}
	     ], width: 400
	    },
    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Masa Kerja Gol.', defaults: {hideLabel: true}, combineErrors: false,
     	 defaultType: 'numberfield', width: 320,
     	 items: [
      	{name: 'mk_th_kgb', id: 'mk_th_kgb', value: 0, minValue: 0, maxValue: 60, margins: '0 5 0 0', width:50,
      	 listeners: {'change': {fn: function () {Get_Gapok_KGB();}}}
      	},
      	{xtype: 'label', forId: 'mk_th_kgb', text: 'Thn.', margins: '3 15 0 0'},
      	{name: 'mk_bl_kgb', id: 'mk_bl_kgb', value: 0, minValue: 0, maxValue: 12, width:50},
      	{xtype: 'label', forId: 'mk_bl_kgb', text: 'Bln.', margins: '3 15 0 5'}
     	 ]
    	},
      {fieldLabel: 'No. SK KGB', name: 'no_sk_kgb', id: 'no_sk_kgb', width: 300},
      {xtype: 'datefield', fieldLabel: 'Tgl. SK KGB', name: 'tgl_sk_kgb', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230},
    	{xtype: 'fieldcontainer', fieldLabel: 'Gaji Pokok Baru', combineErrors: false,
    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 270, 
    	 items: [
      		{name: 'gapok_baru', xtype: 'hidden', 
      		 listeners: {change: function(obj, val){
						Form_KGB_PNS.getForm().setValues({gapok_baru_view_1: Ext.util.Format.currency(val, 'Rp. '), gapok_baru_view_2: Ext.util.Format.number(val, '0')});
      		 }}
      		},
      		{xtype: 'textfield', name: 'gapok_baru_view_1', id: 'gapok_baru_view_1', margin: '0 2 0 0', allowBlank: true,
       		 listeners: {focus: function(obj){ this.hide(); Ext.getCmp('gapok_baru_view_2').show(); Ext.getCmp('gapok_baru_view_2').focus();}},
      		 flex:2
      		},
      		{xtype: 'textfield', name: 'gapok_baru_view_2', id: 'gapok_baru_view_2', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, margin: '0 2 0 0', allowBlank: true, hidden: true,
       		 listeners: {
      				blur: function(obj){this.hide(); Ext.getCmp('gapok_baru_view_1').show();},
      				change : function(obj, val){Form_KGB_PNS.getForm().setValues({gapok_baru: val});}
       		 },
      		 flex:2
      		},
      		{xtype: 'button', name: 'search_gapok', text: '...', id: 'search_gapok_ProfilKGB',
      			handler: function(){Load_Panel_Ref('win_popup_RefGapok', 'ref_gapok', 'Form_KGB_PNS', 2);}
          }
       ]
    	},      
      {xtype: 'datefield', fieldLabel: 'TMT Gaji Berkala', name: 'TMT_kgb', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230,
       listeners: {
      		'change': {fn: function (df, newValue, oldValue){
      			if(newValue){
      				Form_KGB_PNS.getForm().findField('TMT_berikutnya').setValue(Ext.Date.add(newValue, Ext.Date.YEAR, 2));
      			}
      		}, scope: this}
       }
      },
      {xtype: 'datefield', fieldLabel: 'TMT Y.a.d', name: 'TMT_berikutnya', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_KGB', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_KGB();}},
  	{text: 'Ubah', id: 'Ubah_KGB', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_KGB();}},
  	{text: 'Simpan', id: 'Simpan_KGB', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_KGB();}},
  	{text: 'Batal', id: 'Batal_KGB', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_KGB();}}
  ]
});
// FORM GAJI BERKALA PNS  --------------------------------------------------------- END

// FUNCTIONS GAJI BERKALA PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_KGB(){
	Ext.getCmp('gaji_berkala_page').setActiveTab('Tab2_KGB_PNS');
	Form_KGB_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KGB_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_KGB_PNS();	
}

function Profil_PNS_Ubah_KGB(){
	var IDP_KGB = Form_KGB_PNS.getForm().findField('IDP_KGB').getValue();
	if(IDP_KGB){
		P_KGB_last_record = Form_KGB_PNS.getForm().getValues();
		Ext.getCmp('gaji_berkala_page').setActiveTab('Tab2_KGB_PNS');
		Active_Form_KGB_PNS();
	}
}

function Profil_PNS_Simpan_KGB(){
	Ext.getCmp('Form_KGB_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_KGB_PNS').body.mask();}
  });

  Form_KGB_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_KGB = obj.info.reason;
  			Form_KGB_PNS.getForm().setValues({IDP_KGB:IDP_KGB});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_KGB_PNS').body.unmask(); Data_Profil_PNS_KGB.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_KGB_PNS();	
  		All_Button_Enabled(); Ext.getCmp('gaji_berkala_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_KGB_PNS').body.unmask();
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

function Profil_PNS_Hapus_KGB(){
  var sm = grid_Profil_PNS_KGB.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_KGB') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_gaji_berkala', method: 'POST', params: { postdata: data },
          	success: function(response){Data_Profil_PNS_KGB.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_KGB(){
	var IDP_KGB = Form_KGB_PNS.getForm().findField('IDP_KGB').getValue();
	if(!IDP_KGB){
		Form_KGB_PNS.getForm().reset();
	}else{
		Form_KGB_PNS.getForm().setValues(P_KGB_last_record);
	}
	Deactive_Form_KGB_PNS();	
}

function setValue_Form_KGB_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_KGB_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_KGB.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_KGB_PNS(){
	Ext.getCmp('Tambah_KGB').setDisabled(true);
	Ext.getCmp('Ubah_KGB').setDisabled(true);
	Ext.getCmp('Simpan_KGB').setDisabled(false);
	Ext.getCmp('Batal_KGB').setDisabled(false);
	
	Ext.getCmp('search_pangkat_ProfilKGB').setDisabled(false);	
	Form_KGB_PNS.getForm().findField('mk_th_kgb').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('mk_bl_kgb').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('no_sk_kgb').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('tgl_sk_kgb').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('gapok_baru_view_1').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('gapok_baru_view_2').setReadOnly(false);
	Ext.getCmp('search_gapok_ProfilKGB').setDisabled(false);
	Form_KGB_PNS.getForm().findField('TMT_kgb').setReadOnly(false);
	Form_KGB_PNS.getForm().findField('TMT_berikutnya').setReadOnly(false);
}

function Deactive_Form_KGB_PNS(){
	Ext.getCmp('Tambah_KGB').setDisabled(false);
	Ext.getCmp('Ubah_KGB').setDisabled(false);
	Ext.getCmp('Simpan_KGB').setDisabled(true);
	Ext.getCmp('Batal_KGB').setDisabled(true);
	
	Ext.getCmp('search_pangkat_ProfilKGB').setDisabled(true);	
	Form_KGB_PNS.getForm().findField('mk_th_kgb').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('mk_bl_kgb').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('no_sk_kgb').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('tgl_sk_kgb').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('gapok_baru_view_1').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('gapok_baru_view_2').setReadOnly(true);
	Ext.getCmp('search_gapok_ProfilKGB').setDisabled(true);
	Form_KGB_PNS.getForm().findField('TMT_kgb').setReadOnly(true);
	Form_KGB_PNS.getForm().findField('TMT_berikutnya').setReadOnly(true);
}

function Get_Gapok_KGB(){
	var vkode_golru = Form_KGB_PNS.getForm().findField('kode_golru').getValue();
	var vmk_th = Form_KGB_PNS.getForm().findField('mk_th_kgb').getValue();
	if (vkode_golru && vmk_th){
		Ext.Ajax.request({
	  	url: BASE_URL + 'master_data/ext_search_gapok', params: {id_open: 1, kode_golru:vkode_golru, masa_kerja: vmk_th}, method: 'POST', renderer: 'data',
	    success: function(response){
	    	Form_KGB_PNS.getForm().findField('gapok_baru').setValue(response.responseText);
	   	},
	    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal Check Sesi !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
	    scope : this
		});
	}else{
		Form_KGB_PNS.getForm().findField('gapok_baru').setValue(0);
	}
}
// FUNCTIONS GAJI BERKALA PNS  ---------------------------------------------------- END

// PANEL GAJI BERKALA PNS  -------------------------------------------------------- START
var Tab1_KGB_PNS = {
	id: 'Tab1_KGB_PNS', title: 'Riwayat Gaji Berkala', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_KGB]
};

var Tab2_KGB_PNS = {
	id: 'Tab2_KGB_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_KGB_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'gaji_berkala_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_KGB_PNS, Tab2_KGB_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Gaji Berkala'){
  			Data_Profil_PNS_KGB.load();
  			Deactive_Form_KGB_PNS();
  			Form_KGB_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL GAJI BERKALA PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>