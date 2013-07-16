<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_TR_last_record, vcbp_tingkat_tr;

// TABEL TUNJANGAN RESIKO PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_TR', {extend: 'Ext.data.Model',
	fields: ['IDP_TR', 'NIP', 'nilai_kumulatif', 'tingkat_tr', 'tunj_tr', 'TMT_tr', 'no_sk_tr', 'tgl_sk_tr', 'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_jab', 'nama_jab', 'klp_jab', 'kode_unor', 'nama_unor', 'nama_unker']
});

var Reader_Profil_PNS_TR = new Ext.create('Ext.data.JsonReader', {
	id: 'Reader_Profil_PNS_TR', root: 'results', totalProperty: 'total', idProperty: 'IDP_TR'  	
});

var Proxy_Profil_PNS_TR = new Ext.create('Ext.data.AjaxProxy', {
	url: BASE_URL + 'profil_pns/ext_get_all_tunjangan_resiko', actionMethods: {read:'POST'},
  reader: Reader_Profil_PNS_TR
});

var Data_Profil_PNS_TR = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS_TR', model: 'MProfil_PNS_TR', 
	pageSize: 20,	noCache: false, autoLoad: false,
  proxy: Proxy_Profil_PNS_TR
});

var tbProfil_PNS_TR = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_TR},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Jab', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_TR.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){ Profil_PNS_Ubah_TR(); }
  	 }
  	},'-',
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_TR}
  ]
});

var cbGrid_Profil_PNS_TR = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_TR = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_TR', store: Data_Profil_PNS_TR, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_TR, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nilai Kumulatif", dataIndex: 'nilai_kumulatif', width: 80},
  	{header: "Tingkat", dataIndex: 'tingkat_tr', width: 70},
  	{header: "No. SK", dataIndex: 'no_sk_tr', width: 70},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_tr', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT", dataIndex: 'TMT_tr', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tunjangan", dataIndex: 'tunj_tr', width: 100,
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {return Ext.util.Format.currency(value, 'Rp. ');}  	 
  	},
  	{header: "Nama Jabatan", dataIndex: 'nama_jab', width: 200},
  	{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 300},
  	{header: "Unit Kerja", dataIndex: 'nama_unker', width: 300},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 140},
  	{header: "Gol.Ruang", dataIndex: 'nama_golru', width: 70},
  ],
  tbar: tbProfil_PNS_TR,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_TR, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_TR_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('tunjangan_resiko_page').setActiveTab('Tab2_TR_PNS');
  	}    
  }
});
// TABEL TUNJANGAN RESIKO PNS  ------------------------------------------------- END

// FORM TUNJANGAN RESIKO PNS  --------------------------------------------------------- START
var Form_TR_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_TR_PNS', url: BASE_URL + 'profil_pns/ext_insert_tunjangan_resiko',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Tunjangan Resiko', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
	  	 	 items: [
	    		{name: 'IDP_TR', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_TR', xtype: 'hidden'},
	    		{xtype: 'fieldcontainer', fieldLabel: 'Unit Organisasi', combineErrors: false,
	    	 	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
	    	 	 items: [
	      		{xtype: 'hidden', name: 'kode_unor', id: 'kode_unor_TE'},
	      		{xtype: 'textfield', name: 'nama_unor', id: 'nama_unor_ProfilTR', readOnly: true, margin: '0 2 0 0', width: 220},
	      		{xtype: 'button', name: 'search_unor', text: '...', id: 'search_unor_ProfilTR',
	      			handler: function(){Load_Panel_Ref('win_popup_RefPgwUnor', 'ref_pegawai_unor', 'Form_TR_PNS', 6, Form_Biodata_PNS.getForm().findField('NIP').getValue());}
	         	}
	       	 ], anchor: '100%'
	    		},
	      	{fieldLabel: 'Unit Kerja', name: 'nama_unker', id: 'nama_unker_TR', allowBlank: true, readOnly: true, anchor: '100%'},
	      	{xtype: 'hidden', name: 'kode_jab', id: 'kode_jab_TR'},
	      	{fieldLabel: 'Nama Jabatan', name: 'nama_jab', id: 'nama_jab_TR', allowBlank: true, readOnly: true, anchor: '100%'},
	      	{fieldLabel: 'Kelompok Jabatan', name: 'klp_jab', id: 'klp_jab_TR', allowBlank: true, readOnly: true, anchor: '100%'},
		    	{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Golru', combineErrors: false,
		    	 defaults: {hideLabel: true, allowBlank: true}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
		    	 items: [
		      		{name: 'kode_golru', xtype: 'hidden', id: 'kode_golru_TR'},
		      		{fieldLabel: 'Pangkat', xtype: 'textfield', name: 'nama_pangkat', id: 'nama_pangkat_TR', readOnly: true, height: 22, margin: '0 2 0 0', width: 175},
	      			{fieldLabel: 'Golru', xtype: 'textfield', name: 'nama_golru', id: 'nama_golru_TR', height: 22, margin: '0 2 0 0', readOnly: true, width: 50},
		      		{xtype: 'button', name: 'search_pangkat', id: 'search_pangkat_ProfilTR', text: '...',
		      		 handler: function(){Load_Panel_Ref('win_popup_RefPgwPangkat', 'ref_pegawai_pangkat', 'Form_TR_PNS', 2, Ext.getCmp('NIP_TR').getValue())}
		         	}
		       ], anchor: '100%'
		    	},
		    	{fieldLabel: 'Nilai Kumulatif', name: 'nilai_kumulatif', id: 'nilai_kumulatif', maxLength: 5, maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/, allowBlank: true, width: 160},
     			{xtype: 'combobox', fieldLabel: 'Tingkat', name: 'tingkat_tr',
       		 store: new Ext.data.SimpleStore({data: [['I'],['II'],['III'],['IV'],['V'],['VI'],['VII'],['VIII'],['IX'],['X']], fields: ['tingkat_tr']}),
       		 valueField: 'tingkat_tr', displayField: 'tingkat_tr',
       		 queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: true,
       		 listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}}, width:160
      		},
	      	{name: 'tunj_tr', xtype: 'hidden', 
	       	 listeners: {change: function(obj, val){
					 		Form_TR_PNS.getForm().setValues({tunj_tr_view_1: Ext.util.Format.currency(val, 'Rp. '), tunj_tr_view_2: Ext.util.Format.number(val, '0')});
	       	 }}
	      	},
	      	{fieldLabel: 'Tunjangan', name: 'tunj_tr_view_1', id: 'tunj_tr_view_1', allowBlank: true, 
	       	 listeners: {focus: function(obj){ this.hide(); Ext.getCmp('tunj_tr_view_2').show(); Ext.getCmp('tunj_tr_view_2').focus();}},
	       	 width: 240
	      	},
	      	{fieldLabel: 'Tunjangan', name: 'tunj_tr_view_2', id: 'tunj_tr_view_2', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, allowBlank: true, hidden: true,
	       	 listeners: {
	      			blur: function(obj){this.hide(); Ext.getCmp('tunj_tr_view_1').show();},
	      			change : function(obj, val){Form_TR_PNS.getForm().setValues({tunj_tr: val});}
	       	 },
	       	 width: 240
	      	},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No & Tgl. SK', combineErrors: false, defaults: {hideLabel: true},
		     	 items: [
		      	{xtype: 'textfield', fieldLabel: 'Nomor SK TR', name: 'no_sk_tr', id: 'no_sk_tr', margins: '0 5 0 0', flex:2},
		      	{xtype: 'datefield', fieldLabel: 'Tanggal SK TR', name: 'tgl_sk_tr', id: 'tgl_sk_tr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
		     	 ]
		    	},
	      	{xtype: 'datefield', fieldLabel: 'TMT', name: 'TMT_tr', id: 'TMT_tr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: false, width: 210},
	    	 ]
	     	}
    	 ]
     	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
    	 ]
    	},
    ]
   }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_TR', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_TR();}},
  	{text: 'Ubah', id: 'Ubah_TR', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_TR();}},
  	{text: 'Simpan', id: 'Simpan_TR', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_TR();}},
  	{text: 'Batal', id: 'Batal_TR', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_TR();}}
  ]
});
// FORM TUNJANGAN RESIKO PNS  --------------------------------------------------------- END

// FUNCTIONS TUNJANGAN RESIKO PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_TR(){
	Ext.getCmp('tunjangan_resiko_page').setActiveTab('Tab2_TR_PNS');
	Form_TR_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_TR_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_TR_PNS();
	Ext.getCmp('search_unor_ProfilTR').handler.call(Ext.getCmp("search_unor_ProfilTR").scope);
}

function Profil_PNS_Ubah_TR(){
	var IDP_TR = Form_TR_PNS.getForm().findField('IDP_TR').getValue();
	if(IDP_TR){
		vcbp_tingkat_tr = Form_TR_PNS.getForm().findField('tingkat_tr').getValue();
		P_TR_last_record = Form_TR_PNS.getForm().getValues();
		Ext.getCmp('tunjangan_resiko_page').setActiveTab('Tab2_TR_PNS');
		Active_Form_TR_PNS();
	}
}

function Profil_PNS_Simpan_TR(){
	Ext.getCmp('Form_TR_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_TR_PNS').body.mask();}
  });

  Form_TR_PNS.getForm().submit({            			
  	success: function(form, action){
  		Data_Profil_PNS_TR.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}}); 
  		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
			Deactive_Form_TR_PNS();
  		All_Button_Enabled(); Ext.getCmp('tunjangan_resiko_menu').setDisabled(true);
  		Ext.getCmp('Form_TR_PNS').body.unmask(); 
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_TR = obj.info.reason;
  			Form_TR_PNS.getForm().setValues({IDP_TR:IDP_TR});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_TR_PNS').body.unmask();
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

function Profil_PNS_Hapus_TR(){
  var sm = grid_Profil_PNS_TR.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_TR') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_tunjangan_resiko', method: 'POST',
         		params: { postdata: data},
          	success: function(response){
          		Data_Profil_PNS_TR.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
          		Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());
          		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
          	},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     			Form_TR_PNS.getForm().reset();
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_TR(){
	var IDP_TR = Form_TR_PNS.getForm().findField('IDP_TR').getValue();
	if(!IDP_TR){
		Form_TR_PNS.getForm().reset();
	}else{
		Form_TR_PNS.getForm().setValues({tingkat_tr:vcbp_tingkat_tr});
		Form_TR_PNS.getForm().setValues(P_TR_last_record);
	}
	Deactive_Form_TR_PNS();
}

function setValue_Form_TR_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_TR_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_TR.changeParams({params :{id_open: '1', NIP: vNIP}});
}

function Active_Form_TR_PNS(){
	Ext.getCmp('Tambah_TR').setDisabled(true);
	Ext.getCmp('Ubah_TR').setDisabled(true);
	Ext.getCmp('Simpan_TR').setDisabled(false);
	Ext.getCmp('Batal_TR').setDisabled(false);	
	
	Ext.getCmp('search_unor_ProfilTR').setDisabled(false);
	Form_TR_PNS.getForm().findField('tunj_tr_view_1').setReadOnly(false);
	Form_TR_PNS.getForm().findField('tunj_tr_view_2').setReadOnly(false);
	Ext.getCmp('search_pangkat_ProfilTR').setDisabled(false);
	Form_TR_PNS.getForm().findField('nilai_kumulatif').setReadOnly(false);
	Form_TR_PNS.getForm().findField('tingkat_tr').setDisabled(false);
	Form_TR_PNS.getForm().findField('no_sk_tr').setReadOnly(false);
	Form_TR_PNS.getForm().findField('tgl_sk_tr').setReadOnly(false);
	Form_TR_PNS.getForm().findField('TMT_tr').setReadOnly(false);
}

function Deactive_Form_TR_PNS(){
	Ext.getCmp('Tambah_TR').setDisabled(false);
	Ext.getCmp('Ubah_TR').setDisabled(false);
	Ext.getCmp('Simpan_TR').setDisabled(true);	
	Ext.getCmp('Batal_TR').setDisabled(true);

	Ext.getCmp('search_unor_ProfilTR').setDisabled(true);
	Form_TR_PNS.getForm().findField('tunj_tr_view_1').setReadOnly(true);
	Form_TR_PNS.getForm().findField('tunj_tr_view_2').setReadOnly(true);
	Ext.getCmp('search_pangkat_ProfilTR').setDisabled(true);
	Form_TR_PNS.getForm().findField('nilai_kumulatif').setReadOnly(true);
	Form_TR_PNS.getForm().findField('tingkat_tr').setDisabled(true);
	Form_TR_PNS.getForm().findField('no_sk_tr').setReadOnly(true);
	Form_TR_PNS.getForm().findField('tgl_sk_tr').setReadOnly(true);
	Form_TR_PNS.getForm().findField('TMT_tr').setReadOnly(true);
}
// FUNCTIONS TUNJANGAN RESIKO PNS  ---------------------------------------------------- END

// PANEL TUNJANGAN RESIKO PNS  -------------------------------------------------------- START
var Tab1_TR_PNS = {
	id: 'Tab1_TR_PNS', title: 'Riwayat Tunjangan Resiko', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_TR]
};

var Tab2_TR_PNS = {
	id: 'Tab2_TR_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_TR_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'tunjangan_resiko_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_TR_PNS, Tab2_TR_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Jabatan'){
  			Data_Profil_PNS_TR.load(); 
  			Deactive_Form_TR_PNS(); 
  			Form_TR_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL TUNJANGAN RESIKO PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>