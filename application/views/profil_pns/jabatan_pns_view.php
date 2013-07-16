<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Jab_last_record, vcbp_jab_jenis_jab;

// TABEL JABATAN PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Jabatan', {extend: 'Ext.data.Model',
  	fields: ['IDP_Jab', 'NIP', 'jenis_jab', 'no_sk_jab', 'tgl_sk_jab', 'no_spmt', 'tgl_spmt', 'no_spp', 'tgl_spp', 'TMT_jab', 'tunj_jab', 'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_eselon', 'nama_eselon', 'kode_jab', 'nama_jab', 'klp_jab', 'ket_jab', 'jns_fung', 'nama_fung', 'nama_fung_tertentu', 'NIP_pejabat', 'nama_pejabat']
});

var Reader_Profil_PNS_Jabatan = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Jabatan', root: 'results', totalProperty: 'total', idProperty: 'IDP_Jab'  	
});

var Proxy_Profil_PNS_Jabatan = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_jabatan', actionMethods: {read:'POST'},
    reader: Reader_Profil_PNS_Jabatan
});

var Data_Profil_PNS_Jabatan = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Jabatan', model: 'MProfil_PNS_Jabatan', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Jabatan
});

var tbProfil_PNS_Jabatan = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Jabatan},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Jab', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Jabatan.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Jabatan();
  	 		}
  	 }
  	},'-',
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Jabatan},
		{xtype: 'label', text: 'Pindahan dari : - , TMT :', id:'info_Mutasi', style: 'color: #FF0000;', margins: '3 15 0 20', hidden: true}		
  ]
});

var cbGrid_Profil_PNS_Jabatan = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_Jabatan = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Jabatan', store: Data_Profil_PNS_Jabatan, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_Jabatan, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Jabatan", dataIndex: 'nama_jab', width: 200},
  	{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 300},
  	{header: "Unit Kerja", dataIndex: 'nama_unker', width: 300},
  	{header: "Eselon", dataIndex: 'nama_eselon', width: 70},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 140},
  	{header: "Gol.Ruang", dataIndex: 'nama_golru', width: 70},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_jab', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT Jabatan", dataIndex: 'TMT_jab', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Tunjangan", dataIndex: 'tunj_jab', width: 100,
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {return Ext.util.Format.currency(value, 'Rp. ');}  	 
  	},
  	{header: "NIP Pejabat", dataIndex: 'NIP_pejabat', width: 120},
  	{header: "Nama Pejabat", dataIndex: 'nama_pejabat', width: 180},
  ],
  tbar: tbProfil_PNS_Jabatan,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_Jabatan, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Jabatan_PNS.getForm().loadRecord(records[0]);
      	Form_Arsip_Jab.getForm().loadRecord(records[0]);
      	Set_Arsip_Jab();
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('jabatan_page').setActiveTab('Tab2_Jabatan_PNS');
  	}    
  }
});
// TABEL JABATAN PNS  ------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Jab = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Jab', url: BASE_URL + 'upload_arsip/insert_arsip/jabatan', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Jab'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Jab', value: 4},
		{xtype: 'hidden', name: 'IDP_Jab', id: 'IDP_Jab_Arsip_Jab'},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Jab', emptyText: 'Upload Files', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Jab.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						var p_IDP_Jab = Form_Jabatan_PNS.getForm().findField('IDP_Jab').getValue();
						Form_Arsip_Jab.getForm().setValues({NIP: p_NIP, IDP_Jab: p_IDP_Jab});
			 			Form_Arsip_Jab.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Set_Arsip_Jab(); Deactive_Form_Jabatan_PNS();
			 					}
			 				},
	    				failure: function(form, action){
	      				obj = Ext.decode(action.response.responseText);
	      				Ext.MessageBox.show({title:'Gagal Upload !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	    				}, scope: this
			 			});
			 		}
			 	}
			 }
			},
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Jab', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Jab();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Jab', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Jab();}},
		 ]
		}
	]
});

function Set_Arsip_Jab(){Set_Arsip_Digital('Form_Jabatan_PNS', 'Btn_Download_Arsip_Jab', 'IDP_Jab', 4, 'jabatan');}
function Reset_Arsip_Jab(){Reset_Arsip_Digital('Form_Jabatan_PNS', 'Btn_Download_Arsip_Jab', 'IDP_Jab', 4, 'jabatan'); Deactive_Form_Jabatan_PNS();}
function Download_Arsip_Jab(){Download_Arsip_Digital('Form_Jabatan_PNS', 'IDP_Jab', 4, 'jabatan');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM JABATAN PNS  --------------------------------------------------------- START
var Form_Jabatan_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Jabatan_PNS', url: BASE_URL + 'profil_pns/ext_insert_jabatan',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Jabatan', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
	  	 	 items: [
	    		{name: 'IDP_Jab', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Jabatan', xtype: 'hidden'},
	     		{xtype: 'combobox', fieldLabel: 'Jenis Jabatan', name: 'jenis_jab', id: 'jenis_jab_jab',
	       	 store: new Ext.data.SimpleStore({data: [['Jabatan Struktural'],['Jabatan Fungsional Umum'],['Jabatan Fungsional Tertentu']], fields: ['jenis_jab']}),
	       	 valueField: 'jenis_jab', displayField: 'jenis_jab', emptyText: 'Pilih Jenis',
	       	 queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	       	 listeners: {
	       			'focus': {fn: function (comboField) {comboField.expand();}, scope: this},
	       			'change': {fn: function (comboField) {
	       				Form_Jabatan_PNS.getForm().setValues({
	       					kode_unor:'',nama_unor:'',nama_unker:'',kode_jab:'',nama_jab:'',nama_eselon:'',tunj_jab:''
	       				});
	       				if(comboField.getRawValue() == 'Jabatan Fungsional Tertentu'){
	       					Ext.getCmp('fieldset_tfung').setDisabled(false);
	       				}else{
	       					Form_Jabatan_PNS.getForm().setValues({
	       						kode_fung_tertentu:'',nama_fung_tertentu:'',nama_fung:'',jns_fung:''
	       					});
	       					Ext.getCmp('fieldset_tfung').setDisabled(true);
	       				}
	       			}, scope: this}
	       	 }, width: 320
	      	},
	    		{xtype: 'fieldcontainer', fieldLabel: 'Unit Organisasi', combineErrors: false,
	    	 	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
	    	 	 items: [
	      		{name: 'kode_unor', id: 'kode_unor_jab', xtype: 'hidden'},
	      		{xtype: 'textfield', name: 'nama_unor', id: 'nama_unor_ProfilJAB', readOnly: true, margin: '0 2 0 0', flex: 2},
	      		{xtype: 'button', name: 'search_unor', text: '...', id: 'search_unor_ProfilJAB',
	      			handler: function(){Load_Panel_Ref('win_popup_RefUnor', 'ref_unor', 'Form_Jabatan_PNS', 1);}
	         	}
	       	 ], anchor: '100%'
	    		},
	      	{fieldLabel: 'Unit Kerja', name: 'nama_unker', id: 'nama_unker_jab', allowBlank: true, readOnly: true, anchor: '100%'},
	    		{xtype: 'fieldcontainer', fieldLabel: 'Nama Jabatan', combineErrors: false,
	    	 	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side',  
	    	 	 items: [
	      		{name: 'kode_jab', id: 'kode_jab_jab', xtype: 'hidden',
		      	 listeners: {
		      		'change': {fn: function (obj,newValue) {setValue_Non_Eselon();}, scope: this}
		      	 }
	      		},
	      		{xtype: 'textfield', name: 'nama_jab', id: 'nama_jab', readOnly: true, margin: '0 2 0 0', flex: 2},
	      		{xtype: 'button', name: 'search_jab', id: 'search_jab_ProfilJAB', text: '...', 
	      		 handler: function(){Load_Panel_Ref('win_popup_RefJabatan', 'ref_jabatan', 'Form_Jabatan_PNS', 5, Form_Jabatan_PNS.getForm().findField('jenis_jab').getValue());}
	         	}
	       	 ], anchor: '100%'
	    		},
	      	{name: 'kode_eselon', xtype: 'hidden'},
	      	{fieldLabel: 'Eselon', name: 'nama_eselon', id: 'nama_eselon', allowBlank: true, readOnly: true,width: 180,
	      	 listeners: {
	      		'change': {fn: function (obj,newValue) {setValue_Non_Eselon();}, scope: this}
	      	 }
	      	},
	      	{name: 'tunj_jab', xtype: 'hidden', 
	       	 listeners: {change: function(obj, val){
					 		Form_Jabatan_PNS.getForm().setValues({tunj_jab_view_1: Ext.util.Format.currency(val, 'Rp. '), tunj_jab_view_2: Ext.util.Format.number(val, '0')});
	       	 }}
	      	},
	      	{fieldLabel: 'Tunjangan', name: 'tunj_jab_view_1', id: 'tunj_jab_view_1', allowBlank: true, 
	       	 listeners: {focus: function(obj){ this.hide(); Ext.getCmp('tunj_jab_view_2').show(); Ext.getCmp('tunj_jab_view_2').focus();}},
	       	 width: 240
	      	},
	      	{fieldLabel: 'Tunjangan', name: 'tunj_jab_view_2', id: 'tunj_jab_view_2', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, allowBlank: true, hidden: true,
	       	 listeners: {
	      			blur: function(obj){this.hide(); Ext.getCmp('tunj_jab_view_1').show();},
	      			change : function(obj, val){Form_Jabatan_PNS.getForm().setValues({tunj_jab: val});}
	       	 },
	       	 width: 240
	      	},
		    	{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Golru', combineErrors: false,
		    	 defaults: {hideLabel: true, allowBlank: true}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
		    	 items: [
		      		{name: 'kode_golru', xtype: 'hidden', id: 'kode_golru_jab'},
		      		{fieldLabel: 'Pangkat', xtype: 'textfield', name: 'nama_pangkat', id: 'nama_pangkat_jab', readOnly: true, height: 22, margin: '0 2 0 0', width: 175},
	      			{fieldLabel: 'Golru', xtype: 'textfield', name: 'nama_golru', id: 'nama_golru_jab', height: 22, margin: '0 2 0 0', readOnly: true, width: 50},
		      		{xtype: 'button', name: 'search_pangkat', id: 'search_pangkat_ProfilJAB', text: '...',
		      		 handler: function(){Load_Panel_Ref('win_popup_RefPgwPangkat', 'ref_pegawai_pangkat', 'Form_Jabatan_PNS', 2, Ext.getCmp('NIP_Jabatan').getValue())}
		         	}
		       ], anchor: '100%'
		    	},
	    	 ]
	     	},
	  	 	{xtype: 'fieldset', id: 'fieldset_tfung', title: 'Tugas Fungsional Tertentu', defaultType: 'textfield', defaults: {anchor: '100%', labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
	    		{xtype: 'fieldcontainer', fieldLabel: 'Jenis Fungsional', combineErrors: false,
	    	 	 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
	    	 	 items: [
	      		{name: 'kode_fung_tertentu', id: 'kode_fung_tertentu', xtype: 'hidden'},
	      		{fieldLabel: 'Jenis Fungsional', name: 'jns_fung', id: 'jns_fung', allowBlank: true, readOnly: true, margin: '0 2 0 0', flex:2},
	      		{xtype: 'button', name: 'search_fung', text: '...', id: 'search_fung_ProfilJAB',
	      			handler: function(){Load_Panel_Ref('win_popup_RefFung', 'ref_tugas_fung', 'Form_Jabatan_PNS', 1);}
	         	}
	       	 ], width: 320
	    		},
	      	{fieldLabel: 'Fungsional', name: 'nama_fung', id: 'nama_fung', allowBlank: true, readOnly: true},
	      	{fieldLabel: 'Fungsional Tertentu', name: 'nama_fung_tertentu', id: 'nama_fung_tertentu', allowBlank: true, readOnly: true}
	  	 	 ]
	     	},     	
    	 ]
     	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Keputusan', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
	  	 	 items: [
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No & Tgl. SK', combineErrors: false, defaults: {hideLabel: true},
		     	 items: [
		      	{xtype: 'textfield', fieldLabel: 'Nomor SK Jabatan', name: 'no_sk_jab', id: 'no_sk_jab', margins: '0 5 0 0', flex:2},
		      	{xtype: 'datefield', fieldLabel: 'Tanggal SK Jabatan', name: 'tgl_sk_jab', id: 'tgl_sk_jab', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
		     	 ]
		    	},
	      	{xtype: 'datefield', fieldLabel: 'TMT Jabatan', name: 'TMT_jab', id: 'TMT_jab', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: false, width: 210},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No & Tgl. SPMT', combineErrors: false, defaults: {hideLabel: true},
		     	 items: [
		      	{xtype: 'textfield', fieldLabel: 'Nomor SMPT', name: 'no_spmt', id: 'no_spmt', margins: '0 5 0 0', flex:2},
		      	{xtype: 'datefield', fieldLabel: 'Tanggal SPMT', name: 'tgl_spmt', id: 'tgl_spmt', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
		     	 ]
		    	},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No & Tgl. SPP', combineErrors: false, defaults: {hideLabel: true},
		     	 items: [
		      	{xtype: 'textfield', fieldLabel: 'Nomor SPP', name: 'no_spp', id: 'no_spp', margins: '0 5 0 0', flex:2},
		      	{xtype: 'datefield', fieldLabel: 'Tanggal SPP', name: 'tgl_spp', id: 'tgl_spp', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
		     	 ]
		    	},
		    	{fieldLabel: 'NIP Pejabat', name: 'NIP_pejabat', id: 'NIP_pejabat_p_jab', maxLength: 21, maskRe: /[\d\ \.\;]/, regex: /^[0-9]|\;*$/, allowBlank: true, width: 300},
		    	{fieldLabel: 'Nama Pejabat', name: 'nama_pejabat', id: 'nama_pejabat_p_jab', allowBlank: true, width: 350},
	      	{fieldLabel: 'Keterangan Lain', name: 'ket_jab', id: 'ket_jab', allowBlank: true, width: 350}
	  	 	 ]
	  	 	},     	
	  		{xtype: 'fieldset', title: 'Arsip Jabatan', defaultType: 'textfield', margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			  	{xtype: 'fieldset', margins: '0 0 0 0', style: 'padding: 0; border-width: 0px; text-align: center;',
			  	 items: [Form_Arsip_Jab]
			  	}
			   ]
			  }
    	 ]
    	},
    ]
   }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Jabatan', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Jabatan();}},
  	{text: 'Ubah', id: 'Ubah_Jabatan', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Jabatan();}},
  	{text: 'Simpan', id: 'Simpan_Jabatan', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Jabatan();}},
  	{text: 'Batal', id: 'Batal_Jabatan', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Jabatan();}}
  ]
});
// FORM JABATAN PNS  --------------------------------------------------------- END

// FUNCTIONS JABATAN PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Jabatan(){
	Ext.getCmp('jabatan_page').setActiveTab('Tab2_Jabatan_PNS');
	Form_Jabatan_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Jabatan_PNS.getForm().setValues({NIP:vNIP});
	Form_Arsip_Jab.getForm().setValues({NIP:vNIP});
	Active_Form_Jabatan_PNS();

	Form_Jabatan_PNS.getForm().findField('filearsip').setDisabled(true);
	Ext.getCmp('Btn_Hapus_Arsip_Jab').setDisabled(true);	
	Ext.getCmp('Btn_Download_Arsip_Jab').setIconCls('');	
	Ext.getCmp('Btn_Download_Arsip_Jab').setDisabled(true);	
}

function Profil_PNS_Ubah_Jabatan(){
	var IDP_Jab = Form_Jabatan_PNS.getForm().findField('IDP_Jab').getValue();
	if(IDP_Jab){
		vcbp_jab_jenis_jab = Form_Jabatan_PNS.getForm().findField('jenis_jab').getValue();
		P_Jab_last_record = Form_Jabatan_PNS.getForm().getValues();
		Ext.getCmp('jabatan_page').setActiveTab('Tab2_Jabatan_PNS');
		Active_Form_Jabatan_PNS();
	}
}

function Profil_PNS_Simpan_Jabatan(){
	Ext.getCmp('Form_Jabatan_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Jabatan_PNS').body.mask();}
  });

  Form_Jabatan_PNS.getForm().submit({            			
  	success: function(form, action){
  		Data_Profil_PNS_Jabatan.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}}); 
  		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
			Deactive_Form_Jabatan_PNS();
  		All_Button_Enabled(); Ext.getCmp('jabatan_menu').setDisabled(true);
  		Ext.getCmp('Form_Jabatan_PNS').body.unmask(); 
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Jab = obj.info.reason;
  			Form_Jabatan_PNS.getForm().setValues({IDP_Jab:IDP_Jab});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Jabatan_PNS').body.unmask();
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

function Profil_PNS_Hapus_Jabatan(){
  var sm = grid_Profil_PNS_Jabatan.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Jab') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_jabatan', method: 'POST',
         		params: { postdata: data},
          	success: function(response){
          		Data_Profil_PNS_Jabatan.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
          		Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());
          		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
          	},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     			Form_Jabatan_PNS.getForm().reset();
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Jabatan(){
	var IDP_Jab = Form_Jabatan_PNS.getForm().findField('IDP_Jab').getValue();
	if(!IDP_Jab){
		Form_Jabatan_PNS.getForm().reset();
	}else{
		Form_Jabatan_PNS.getForm().setValues({jenis_jab:vcbp_jab_jenis_jab});
		Form_Jabatan_PNS.getForm().setValues(P_Jab_last_record);
	}
	Deactive_Form_Jabatan_PNS();
}

function Check_Mutasi(vNIP){
	Ext.Ajax.request({
  	url: BASE_URL + 'profil_pns/ext_check_mutasi', method: 'POST', params: { NIP: vNIP },
    success: function(response){
    	obj = Ext.decode(response.responseText);
    	Ext.getCmp('info_Mutasi').show();
    	Ext.getCmp('info_Mutasi').setText(obj.info.reason);
    },
    failure: function(response){
    	Ext.getCmp('info_Mutasi').hide();
    }
  });
}

function setValue_Form_Jabatan_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Jabatan_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Jabatan.changeParams({params :{id_open: '1', NIP: vNIP}});
	Check_Mutasi(vNIP);
}

function setValue_Non_Eselon(){
	var jns_jab = Form_Jabatan_PNS.getForm().findField('jenis_jab').getValue();
	if(jns_jab != 'Jabatan Struktural'){
		Form_Jabatan_PNS.getForm().setValues({kode_eselon:99, nama_eselon:'NON'});
	}
}

function Active_Form_Jabatan_PNS(){
	Ext.getCmp('Tambah_Jabatan').setDisabled(true);
	Ext.getCmp('Ubah_Jabatan').setDisabled(true);
	Ext.getCmp('Simpan_Jabatan').setDisabled(false);
	Ext.getCmp('Batal_Jabatan').setDisabled(false);	
	
	Ext.getCmp('jenis_jab_jab').setDisabled(false);
	Ext.getCmp('search_unor_ProfilJAB').setDisabled(false);
	Ext.getCmp('search_jab_ProfilJAB').setDisabled(false);
	Ext.getCmp('tunj_jab_view_1').setReadOnly(false);
	Ext.getCmp('tunj_jab_view_2').setReadOnly(false);
	Ext.getCmp('search_pangkat_ProfilJAB').setDisabled(false);
	Form_Jabatan_PNS.getForm().findField('NIP_pejabat').setReadOnly(false);
	Form_Jabatan_PNS.getForm().findField('nama_pejabat').setReadOnly(false);
	Ext.getCmp('no_sk_jab').setReadOnly(false);
	Ext.getCmp('tgl_sk_jab').setReadOnly(false);
	Ext.getCmp('TMT_jab').setReadOnly(false);
	Ext.getCmp('no_spmt').setReadOnly(false);
	Ext.getCmp('tgl_spmt').setReadOnly(false);
	Ext.getCmp('no_spp').setReadOnly(false);
	Ext.getCmp('tgl_spp').setReadOnly(false);
	Ext.getCmp('ket_jab').setReadOnly(false);
	Ext.getCmp('search_fung_ProfilJAB').setDisabled(false);

	Form_Jabatan_PNS.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Jab').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Jab').setDisabled(false);
	}
}

function Deactive_Form_Jabatan_PNS(){
	Ext.getCmp('Tambah_Jabatan').setDisabled(false);
	Ext.getCmp('Ubah_Jabatan').setDisabled(false);
	Ext.getCmp('Simpan_Jabatan').setDisabled(true);	
	Ext.getCmp('Batal_Jabatan').setDisabled(true);

	Ext.getCmp('jenis_jab_jab').setDisabled(true);
	Ext.getCmp('search_unor_ProfilJAB').setDisabled(true);
	Ext.getCmp('search_jab_ProfilJAB').setDisabled(true);
	Ext.getCmp('tunj_jab_view_1').setReadOnly(true);
	Ext.getCmp('tunj_jab_view_2').setReadOnly(true);
	Ext.getCmp('search_pangkat_ProfilJAB').setDisabled(true);
	Form_Jabatan_PNS.getForm().findField('NIP_pejabat').setReadOnly(true);
	Form_Jabatan_PNS.getForm().findField('nama_pejabat').setReadOnly(true);
	Ext.getCmp('no_sk_jab').setReadOnly(true);
	Ext.getCmp('tgl_sk_jab').setReadOnly(true);
	Ext.getCmp('TMT_jab').setReadOnly(true);
	Ext.getCmp('no_spmt').setReadOnly(true);
	Ext.getCmp('tgl_spmt').setReadOnly(true);
	Ext.getCmp('no_spp').setReadOnly(true);
	Ext.getCmp('tgl_spp').setReadOnly(true);
	Ext.getCmp('ket_jab').setReadOnly(true);
	Ext.getCmp('search_fung_ProfilJAB').setDisabled(true);

	Form_Jabatan_PNS.getForm().findField('filearsip').setDisabled(true);	
	Ext.getCmp('Btn_Hapus_Arsip_Jab').setDisabled(true);
}
// FUNCTIONS JABATAN PNS  ---------------------------------------------------- END

// PANEL JABATAN PNS  -------------------------------------------------------- START
var Tab1_Jabatan_PNS = {
	id: 'Tab1_Jabatan_PNS', title: 'Riwayat Jabatan', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Jabatan]
};

var Tab2_Jabatan_PNS = {
	id: 'Tab2_Jabatan_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Jabatan_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'jabatan_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Jabatan_PNS, Tab2_Jabatan_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Jabatan'){
  			Data_Profil_PNS_Jabatan.load(); 
  			Deactive_Form_Jabatan_PNS(); 
  			Form_Jabatan_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL JABATAN PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>