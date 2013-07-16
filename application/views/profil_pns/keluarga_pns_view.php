<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Klrg_last_record, P_SI_last_record, P_Anak_last_record, P_BIK_last_record, P_BIM_last_record, P_Sdr_last_record;
var vcb_status_anak, vcb_agama_anak, vcb_status_kawin_anak, vcb_status_hidup_anak;
var vcb_agama_si, vcb_status_kawin_si, vcb_status_hidup_si;
var title_active_tab_klrg = 'Suami/Istri';

// DATA STORE COMBO  --------------------------------------------------------- START
var Store_Cb_Pddk = new Ext.data.Store({
	fields: ['kode_pddk','nama_pddk'], idProperty: 'ID_PJG',
  proxy: new Ext.data.AjaxProxy({
  	url: BASE_URL + 'combo_ref/combo_pendidikan', 
    actionMethods: {read:'POST'}, extraParams :{id_open: 1}
  }), autoLoad: true
});

var Store_Cb_Pekerjaan = new Ext.data.Store({
	fields: ['kode_pekerjaan','nama_pekerjaan'], idProperty: 'ID_Kerja',
  proxy: new Ext.data.AjaxProxy({
  	url: BASE_URL + 'combo_ref/combo_pekerjaan', 
    actionMethods: {read:'POST'}, extraParams :{id_open: 1}
  }), autoLoad: true
});

var Store_Cb_Status_Kawin = new Ext.data.SimpleStore({
	fields: ['status_kawin'], data: [['Belum Kawin'],['Kawin'],['Janda'],['Duda']]
});
// DATA STORE COMBO  --------------------------------------------------------- END

// GRID SUAMI ISTRI PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_SI', {extend: 'Ext.data.Model',
  fields: ['IDP_SI', 'NIP', 'nama_si', 'tmpt_lahir_si', 'tgl_lahir_si', 'alamat_si', 'telp_si', 'agama_si', 'kode_pddk_si', 'nama_pddk', 'pekerjaan_si', 'no_KARIS', 'no_NPWP_si', 'tgl_NPWP_si', 'status_kawin_si', 'akta_nikah_si', 'tgl_nikah_si', 'akta_cerai_si', 'tgl_cerai_si', 'status_hidup_si', 'akta_meninggal_si', 'tgl_meninggal_si', 'ket_si']
});

var Reader_Profil_PNS_SI = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Profil_PNS_SI', root: 'results', totalProperty: 'total', idProperty: 'IDP_SI'  	
});

var Proxy_Profil_PNS_SI = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'profil_pns/ext_get_all_suami_istri', actionMethods: {read:'POST'},
  reader: Reader_Profil_PNS_SI
});

var Data_Profil_PNS_SI = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS_SI', model: 'MProfil_PNS_SI', pageSize: 20,	noCache: false, autoLoad: false,
  proxy: Proxy_Profil_PNS_SI
});

var tbProfil_PNS_SI = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{text: 'Hapus', iconCls: 'icon-delete', handler: function () {Profil_PNS_Hapus_Keluarga();}},'-',]
});

var cbGrid_Profil_PNS_SI = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_SI = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_SI', store: Data_Profil_PNS_SI, frame: false, border: true, 
  height: 175, width: '100%', columnLines: true,
  selModel: cbGrid_Profil_PNS_SI, loadMask: true,
	columns: [
  	{header: "Nama Lengkap", dataIndex: 'nama_si', width: 120}, 
  	{header: "Tempat Lahir", dataIndex: 'tmpt_lahir_si', width: 100},
  	{header: "Tgl. Lahir", dataIndex: 'tgl_lahir_si', renderer : Ext.util.Format.dateRenderer('d/m/Y'), width: 85}, 
  	{header: "Pendidikan", dataIndex: 'nama_pddk',width: 120},
  	{header: "Pekerjaan", dataIndex: 'pekerjaan_si', width: 120},
  	{header: "Status", dataIndex: 'status_kawin_si', width: 120}
  ],
  tbar: tbProfil_PNS_SI,
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
    		Deactive_Form_Keluarga_PNS();
      	Form_Suami_Istri.getForm().loadRecord(records[0]);
      }
    },
  }
});
// GRID SUAMI ISTRI PNS  --------------------------------------------------------- END

// GRID ANAK PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Anak', {extend: 'Ext.data.Model',
  fields: ['IDP_Anak', 'NIP', 'nama_anak', 'tmpt_lahir_anak', 'tgl_lahir_anak', 'jk_anak', 'akta_lahir_anak', 'anak_ke', 'status_anak', 'alamat_anak', 'telp_anak', 'agama_anak', 'kode_pddk_anak', 'nama_pddk', 'pekerjaan_anak', 'status_kawin_anak', 'akta_nikah_anak', 'tgl_nikah_anak', 'akta_cerai_anak', 'tgl_cerai_anak', 'status_hidup_anak', 'akta_meninggal_anak', 'tgl_meninggal_anak', 'ket_anak']
});

var Reader_Profil_PNS_Anak = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Profil_PNS_Anak', root: 'results', totalProperty: 'total', idProperty: 'IDP_Anak'  	
});

var Proxy_Profil_PNS_Anak = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'profil_pns/ext_get_all_anak', actionMethods: {read:'POST'},
  reader: Reader_Profil_PNS_Anak
});

var Data_Profil_PNS_Anak = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS_Anak', model: 'MProfil_PNS_Anak', pageSize: 20,	noCache: false, autoLoad: false,
  proxy: Proxy_Profil_PNS_Anak
});

var tbProfil_PNS_Anak = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{text: 'Hapus', iconCls: 'icon-delete', handler: function () {Profil_PNS_Hapus_Keluarga();}},'-',]
});

var cbGrid_Profil_PNS_Anak = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_Anak = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Anak', store: Data_Profil_PNS_Anak, frame: false, border: true, 
  height: 175, width: '100%', columnLines: true,
  selModel: cbGrid_Profil_PNS_Anak, loadMask: true,
	columns: [
  	{header: "Anak Ke", dataIndex: 'anak_ke', width: 55},
  	{header: "Nama Lengkap", dataIndex: 'nama_anak', width: 120}, 
  	{header: "Tempat Lahir", dataIndex: 'tmpt_lahir_anak', width: 100},
  	{header: "Tgl. Lahir", dataIndex: 'tgl_lahir_anak', renderer : Ext.util.Format.dateRenderer('d/m/Y'), width: 85}, 
  	{header: "JK", dataIndex: 'jk_anak', width: 30},
  	{header: "Pendidikan", dataIndex: 'nama_pddk',width: 120},
  	{header: "Pekerjaan", dataIndex: 'pekerjaan_anak', width: 120},
  	{header: "Status", dataIndex: 'status_kawin_anak', width: 120}
  ],
  tbar: tbProfil_PNS_Anak,
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
    		Deactive_Form_Keluarga_PNS();
      	Form_Anak.getForm().loadRecord(records[0]);
      }
    },
  }
});
// GRID ANAK PNS  --------------------------------------------------------- END

// GRID AYAH DAN IBU MERTUA PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_BIM', {extend: 'Ext.data.Model',
  fields: ['IDP_BIM', 'NIP', 'nama_ayah_mertua', 'tmpt_lahir_ayah_mertua', 'tgl_lahir_ayah_mertua', 'alamat_ayah_mertua', 'telp_ayah_mertua', 'pekerjaan_ayah_mertua', 'status_kawin_ayah_mertua', 'akta_nikah_ayah_mertua', 'tgl_nikah_ayah_mertua', 'akta_cerai_ayah_mertua', 'tgl_cerai_ayah_mertua', 'status_hidup_ayah_mertua', 'akta_meninggal_ayah_mertua', 'tgl_meninggal_ayah_mertua', 'ket_ayah_mertua', 'nama_ibu_mertua', 'tmpt_lahir_ibu_mertua', 'tgl_lahir_ibu_mertua', 'alamat_ibu_mertua', 'telp_ibu_mertua', 'pekerjaan_ibu_mertua', 'status_kawin_ibu_mertua', 'akta_nikah_ibu_mertua', 'tgl_nikah_ibu_mertua', 'akta_cerai_ibu_mertua', 'tgl_cerai_ibu_mertua', 'status_hidup_ibu_mertua', 'akta_meninggal_ibu_mertua', 'tgl_meninggal_ibu_mertua', 'ket_ibu_mertua']
});

var Reader_Profil_PNS_BIM = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Profil_PNS_BIM', root: 'results', totalProperty: 'total', idProperty: 'IDP_BIM'  	
});

var Proxy_Profil_PNS_BIM = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'profil_pns/ext_get_all_bpk_ibu_mertua', actionMethods: {read:'POST'},
  reader: Reader_Profil_PNS_BIM
});

var Data_Profil_PNS_BIM = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS_BIM', model: 'MProfil_PNS_BIM', pageSize: 20,	noCache: false, autoLoad: false,
  proxy: Proxy_Profil_PNS_BIM
});

var tbProfil_PNS_BIM = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{text: 'Hapus', iconCls: 'icon-delete', handler: function () {Profil_PNS_Hapus_Keluarga();}},'-',]
});

var cbGrid_Profil_PNS_BIM = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_BIM = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_BIM', store: Data_Profil_PNS_BIM, frame: false, border: true, 
  height: 175, width: '100%', columnLines: true,
  selModel: cbGrid_Profil_PNS_BIM, loadMask: true,
	columns: [
  	{header: "Nama Bapak Mertua", dataIndex: 'nama_ayah_mertua', width: 150}, 
  	{header: "Nama Ibu Mertua", dataIndex: 'nama_ibu_mertua', width: 150}, 
  	{header: "Pekerjaan Bapak Mertua", dataIndex: 'pekerjaan_ayah_mertua', width: 150},
  	{header: "Pekerjaan Ibu Mertua", dataIndex: 'pekerjaan_ibu_mertua', width: 150},
  ],
  tbar: tbProfil_PNS_BIM,
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
    		Deactive_Form_Keluarga_PNS();
      	Form_Bpk_Ibu_Mertua.getForm().loadRecord(records[0]);
      }
    },
  }
});
// GRID AYAH DAN IBU MERTUA PNS  --------------------------------------------------------- END

// GRID SAUDARA KANDUNG PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Sdr', {extend: 'Ext.data.Model',
  fields: ['IDP_Sdr', 'NIP', 'nama_sdr', 'tmpt_lahir_sdr', 'tgl_lahir_sdr', 'jk_sdr', 'alamat_sdr', 'telp_sdr', 'agama_sdr', 'kode_pddk_sdr', 'nama_pddk', 'pekerjaan_sdr', 'status_kawin_sdr', 'akta_nikah_sdr', 'tgl_nikah_sdr', 'akta_cerai_sdr', 'tgl_cerai_sdr', 'status_hidup_sdr', 'akta_meninggal_sdr', 'tgl_meninggal_sdr', 'ket_sdr']
});

var Reader_Profil_PNS_Sdr = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Profil_PNS_Sdr', root: 'results', totalProperty: 'total', idProperty: 'IDP_Sdr'  	
});

var Proxy_Profil_PNS_Sdr = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'profil_pns/ext_get_all_saudara', actionMethods: {read:'POST'},
  reader: Reader_Profil_PNS_Sdr
});

var Data_Profil_PNS_Sdr = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS_Sdr', model: 'MProfil_PNS_Sdr', pageSize: 20,	noCache: false, autoLoad: false,
  proxy: Proxy_Profil_PNS_Sdr
});

var tbProfil_PNS_Sdr = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{text: 'Hapus', iconCls: 'icon-delete', handler: function () {Profil_PNS_Hapus_Keluarga();}},'-',]
});

var cbGrid_Profil_PNS_Sdr = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_Sdr = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Sdr', store: Data_Profil_PNS_Sdr, frame: false, border: true, 
  height: 175, width: '100%', columnLines: true,
  selModel: cbGrid_Profil_PNS_Sdr, loadMask: true,
	columns: [
  	{header: "Nama Lengkap", dataIndex: 'nama_sdr', width: 120}, 
  	{header: "Tempat Lahir", dataIndex: 'tmpt_lahir_sdr', width: 100},
  	{header: "Tgl. Lahir", dataIndex: 'tgl_lahir_sdr', renderer : Ext.util.Format.dateRenderer('d/m/Y'), width: 85}, 
  	{header: "JK", dataIndex: 'jk_sdr', width: 30},
  	{header: "Pekerjaan", dataIndex: 'pekerjaan_sdr', width: 120},
  	{header: "Status", dataIndex: 'status_kawin_sdr', width: 120}
  ],
  tbar: tbProfil_PNS_Sdr,
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
    		Deactive_Form_Keluarga_PNS();
      	Form_Saudara.getForm().loadRecord(records[0]);
      }
    },
  }
});
// GRID SAUDARA KANDUNG PNS  --------------------------------------------------------- END

// FORM KELUARGA PNS  --------------------------------------------------------- START
var Form_Suami_Istri = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Suami_Istri', url: BASE_URL + 'profil_pns/ext_insert_suami_istri',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', 
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	    	{name: 'IDP_SI', xtype: 'hidden'}, {name: 'NIP', xtype: 'hidden', id: 'NIP_SI'},
	  		{xtype: 'fieldset', id: 'frame_form_si', title: 'Data Suami/Istri', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_si', id: 'nama_si', allowBlank: false, anchor: '100%'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_si', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_si', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_si', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_si', width: 250},
		     	{xtype: 'combobox', fieldLabel: 'Agama', name: 'agama_si', width: 220,
		       store: new Ext.data.SimpleStore({data: [['Islam'],['Katolik'],['Protestan'],['Hindu'],['Budha']], fields: ['agama_si']}),
		       valueField: 'agama_si', displayField: 'agama_si', emptyText: 'Agama',
		       queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
		       listeners: {
		       	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
		       }
		      },
			    {xtype: 'fieldcontainer', fieldLabel: 'Pendidikan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', allowBlank: true,
			     items: [
			     		{name: 'kode_pddk_si', xtype: 'hidden'},
			     		{xtype: 'textfield', name: 'nama_pddk', id: 'nama_pddk_si', margin: '0 2 0 0', flex:2},
			     		{xtype: 'button', name: 'search_pendidikan', id: 'search_pendidikan_si', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPddk', 'ref_pddk', 'Form_Suami_Istri', 3);}
			        }
			     ]
			    },
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', allowBlank: true,
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_si', id: 'pekerjaan_si', margin: '0 2 0 0', allowBlank: false, flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_si', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Suami_Istri', 4);}
			        }
			     ]
			    },
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_si', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Kawin'],['Cerai']], fields: ['status_kawin_si']}),
	         valueField: 'status_kawin_si', displayField: 'status_kawin_si', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Cerai'){
	        				Ext.getCmp('akta_tgl_cerai_si').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_cerai_si').hide();
	        				Form_Suami_Istri.getForm().setValues({akta_cerai_si:'', tgl_cerai_si: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', id: 'akta_tgl_nikah_si', fieldLabel: 'Akta & Tgl. Menikah', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Menikah', name: 'akta_nikah_si', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Menikah', name: 'tgl_nikah_si', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', id: 'akta_tgl_cerai_si', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_si', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_si', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_si', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_si']}),
	         valueField: 'status_hidup_si', displayField: 'status_hidup_si', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_si').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_si').hide();
	        				Form_Suami_Istri.getForm().setValues({akta_meninggal_si:'', tgl_meninggal_si: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', id: 'akta_tgl_meninggal_si', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_si', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_si', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'No. & Tgl. NPWP',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'No. NPWP', name: 'no_NPWP_si', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tgl. NPWP', name: 'tgl_NPWP_si', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Nomor KARIS', name: 'no_KARIS', width: 300},
			    {fieldLabel: 'Keterangan', name: 'ket_si', allowBlank: true, anchor: '100%'},
	  	   ]
	  	  }
    	 ]
    	},
    	{xtype: 'fieldset', id: 'frame_grid_si', defaults: {anchor: '100%'}, margins: '8px 0 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [grid_Profil_PNS_SI]
    	},
    ]
   }
  ]
});

var Form_Anak = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Anak', url: BASE_URL + 'profil_pns/ext_insert_anak',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', 
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	    	{name: 'IDP_Anak', xtype: 'hidden'}, {name: 'NIP', xtype: 'hidden', id: 'NIP_Anak'},
	  		{xtype: 'fieldset', id: 'frame_form_anak', title: 'Data Anak', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_anak', id: 'nama_anak', allowBlank: false, anchor: '100%'},
	     	 	{xtype: 'combobox', fieldLabel: 'Jenis Kelamin', name: 'jk_anak', margins: '0 10 0 0', width: 190,
	         store: new Ext.data.SimpleStore({data: [['L'],['P']], fields: ['jk_anak']}),
	         valueField: 'jk_anak', displayField: 'jk_anak', emptyText: 'Jenis',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_anak', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_anak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Akta Kelahiran', name: 'akta_lahir_anak', width: 280},
		     	{xtype: 'combobox', fieldLabel: 'Status Anak', name: 'status_anak', width: 220,
		       store: new Ext.data.SimpleStore({data: [['Kandung'],['Tiri'],['Angkat']], fields: ['status_anak']}),
		       valueField: 'status_anak', displayField: 'status_anak', emptyText: 'Status',
		       queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
		       listeners: {
		       	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
		       }
		      },
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Anak Ke', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Anak Ke', name: 'anak_ke', margins: '0 10 0 0', width: 50},
		     	 	{xtype: 'combobox', fieldLabel: 'Agama', name: 'agama_anak', hideLabel: false, labelAlign: 'right', labelWidth: 80, width: 180,
		         store: new Ext.data.SimpleStore({data: [['Islam'],['Katolik'],['Protestan'],['Hindu'],['Budha']], fields: ['agama_anak']}),
		         valueField: 'agama_anak', displayField: 'agama_anak', emptyText: 'Agama',
		         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
		         listeners: {
		        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
		         }
		        },
	     	   ]
	    	 	},	    	 
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_anak', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_anak', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pendidikan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', allowBlank: true,
			     items: [
			     		{name: 'kode_pddk_anak', xtype: 'hidden'},
			     		{xtype: 'textfield', name: 'nama_pddk', id: 'nama_pddk_anak', margin: '0 2 0 0', flex:2},
			     		{xtype: 'button', name: 'search_pendidikan', id: 'search_pendidikan_anak', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPddk', 'ref_pddk', 'Form_Anak', 4);}
			        }
			     ]
			    },
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', allowBlank: true,
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_anak', id: 'pekerjaan_anak', margin: '0 2 0 0', flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_anak', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Anak', 5);}
			        }
			     ]
			    },
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_anak', margins: '0 10 0 0', width: 230,
	         store: new Ext.data.SimpleStore({data: [['Belum Kawin'],['Kawin'],['Janda'],['Duda']], fields: ['status_kawin_anak']}),
	         valueField: 'status_kawin_anak', displayField: 'status_kawin_anak', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Kawin'){
	        				Ext.getCmp('akta_tgl_nikah_anak').show();
	        				Ext.getCmp('akta_tgl_cerai_anak').hide();
	        				Form_Anak.getForm().setValues({akta_cerai_anak:'', tgl_cerai_anak: ''});
	        			}else if(newValue == 'Janda' || newValue == 'Duda'){
	        				Ext.getCmp('akta_tgl_cerai_anak').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_nikah_anak').hide();
	        				Ext.getCmp('akta_tgl_cerai_anak').hide();
	        				Form_Anak.getForm().setValues({akta_nikah_anak:'', tgl_nikah_anak: '', akta_cerai_anak:'', tgl_cerai_anak: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_nikah_anak', layout: 'hbox', fieldLabel: 'Akta & Tgl. Menikah',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Menikah', name: 'akta_nikah_anak', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Menikah', name: 'tgl_nikah_anak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_anak', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_anak', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_anak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_anak', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_anak']}),
	         valueField: 'status_hidup_anak', displayField: 'status_hidup_anak', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_anak').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_anak').hide();
	        				Form_Anak.getForm().setValues({akta_meninggal_anak:'', tgl_meninggal_anak: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_anak', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_anak', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_anak', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_anak', allowBlank: true, anchor: '100%'},
	  	   ]
	  	  }
    	 ]
    	},
    	{xtype: 'fieldset', id: 'frame_grid_anak', defaults: {anchor: '100%'}, margins: '8px 0 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [grid_Profil_PNS_Anak]
    	},
    ]
   }
  ]
});

var Form_Bpk_Ibu_Kandung = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Bpk_Ibu_Kandung', url: BASE_URL + 'profil_pns/ext_insert_bpk_ibu_kandung',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', 
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	    	{name: 'IDP_BIK', xtype: 'hidden'}, {name: 'NIP', xtype: 'hidden', id: 'NIP_BIK'},
	  		{xtype: 'fieldset', title: 'Data Bapak Kandung', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_ayah', id: 'nama_ayah', allowBlank: false, anchor: '100%'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_ayah', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_ayah', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_ayah', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_ayah', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', 
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_ayah', id: 'pekerjaan_ayah', margin: '0 2 0 0', allowBlank: false, flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_ayah', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Bpk_Ibu_Kandung', 2);}
			        }
			     ]
			    },			    
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_ayah', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Kawin'],['Duda']], fields: ['status_kawin_ayah']}),
	         valueField: 'status_kawin_ayah', displayField: 'status_kawin_ayah', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Duda'){
	        				Ext.getCmp('akta_tgl_cerai_ayah').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_cerai_ayah').hide();
	        				Form_Bpk_Ibu_Kandung.getForm().setValues({akta_cerai_ayah:'', tgl_cerai_ayah: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_ayah', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_ayah', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_ayah', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_ayah', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_ayah']}),
	         valueField: 'status_hidup_ayah', displayField: 'status_hidup_ayah', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_ayah').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_ayah').hide();
	        				Form_Bpk_Ibu_Kandung.getForm().setValues({akta_meninggal_ayah:'', tgl_meninggal_ayah: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_ayah', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_ayah', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_ayah', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_ayah', allowBlank: true, anchor: '100%'},
	       ]
	    	},	    	
    	 ]
    	},
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Ibu Kandung', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_ibu', id: 'nama_ibu', allowBlank: false, anchor: '100%'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_ibu', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_ibu', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_ibu', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_ibu', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', 
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_ibu', id: 'pekerjaan_ibu', margin: '0 2 0 0', allowBlank: false, flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_ibu', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Bpk_Ibu_Kandung', 3);}
			        }
			     ]
			    },
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_ibu', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Kawin'],['Janda']], fields: ['status_kawin_ibu']}),
	         valueField: 'status_kawin_ibu', displayField: 'status_kawin_ibu', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Janda'){
	        				Ext.getCmp('akta_tgl_cerai_ibu').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_cerai_ibu').hide();
	        				Form_Bpk_Ibu_Kandung.getForm().setValues({akta_cerai_ibu:'', tgl_cerai_ibu: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_ibu', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_ibu', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_ibu', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_ibu', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_ibu']}),
	         valueField: 'status_hidup_ibu', displayField: 'status_hidup_ibu', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_ibu').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_ibu').hide();
	        				Form_Bpk_Ibu_Kandung.getForm().setValues({akta_meninggal_ibu:'', tgl_meninggal_ibu: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_ibu', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_ibu', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_ibu', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_ibu', allowBlank: true, anchor: '100%'},
	       ]
	    	},	    	
    	 ]
    	},
    ]
   }
  ]
});

var Form_Bpk_Ibu_Mertua = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Bpk_Ibu_Mertua', url: BASE_URL + 'profil_pns/ext_insert_bpk_ibu_mertua',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', margins: '0 5px 0 0',
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	    	{name: 'IDP_BIM', xtype: 'hidden'}, {name: 'NIP', xtype: 'hidden', id: 'NIP_BIM'},
	  		{xtype: 'fieldset', id: 'frame_form_bpk_mertua', title: 'Data Bapak Mertua', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_ayah_mertua', id: 'nama_ayah_mertua', allowBlank: false, anchor: '100%'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_ayah_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_ayah_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_ayah_mertua', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_ayah_mertua', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', 
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_ayah_mertua', id: 'pekerjaan_ayah_mertua', margin: '0 2 0 0', allowBlank: false, flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_ayah_mertua', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Bpk_Ibu_Mertua', 6);}
			        }
			     ]
			    },			    
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_ayah_mertua', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Kawin'],['Duda']], fields: ['status_kawin_ayah_mertua']}),
	         valueField: 'status_kawin_ayah_mertua', displayField: 'status_kawin_ayah_mertua', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Duda'){
	        				Ext.getCmp('akta_tgl_cerai_ayah_mertua').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_cerai_ayah_mertua').hide();
	        				Form_Bpk_Ibu_Mertua.getForm().setValues({akta_cerai_ayah_mertua:'', tgl_cerai_ayah_mertua: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_ayah_mertua', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_ayah_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_ayah_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_ayah_mertua', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_ayah_mertua']}),
	         valueField: 'status_hidup_ayah_mertua', displayField: 'status_hidup_ayah_mertua', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_ayah_mertua').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_ayah_mertua').hide();
	        				Form_Bpk_Ibu_Mertua.getForm().setValues({akta_meninggal_ayah_mertua:'', tgl_meninggal_ayah_mertua: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_ayah_mertua', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_ayah_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_ayah_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_ayah_mertua', allowBlank: true, anchor: '100%'},
	       ]
	    	},	    	
    	 ]
    	},
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', id: 'frame_form_ibu_mertua', title: 'Data Ibu Mertua', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_ibu_mertua', id: 'nama_ibu_mertua', allowBlank: false, anchor: '100%'},
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_ibu_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_ibu_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_ibu_mertua', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_ibu_mertua', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', 
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_ibu_mertua', id: 'pekerjaan_ibu_mertua', margin: '0 2 0 0', allowBlank: false, flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_ibu_mertua', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Bpk_Ibu_Mertua', 7);}
			        }
			     ]
			    },
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_ibu_mertua', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Kawin'],['Janda']], fields: ['status_kawin_ibu_mertua']}),
	         valueField: 'status_kawin_ibu_mertua', displayField: 'status_kawin_ibu_mertua', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Janda'){
	        				Ext.getCmp('akta_tgl_cerai_ibu_mertua').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_cerai_ibu_mertua').hide();
	        				Form_Bpk_Ibu_Mertua.getForm().setValues({akta_cerai_ibu_mertua:'', tgl_cerai_ibu_mertua: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_ibu_mertua', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_ibu_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_ibu_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_ibu_mertua', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_ibu_mertua']}),
	         valueField: 'status_hidup_ibu_mertua', displayField: 'status_hidup_ibu_mertua', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_ibu_mertua').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_ibu_mertua').hide();
	        				Form_Bpk_Ibu_Mertua.getForm().setValues({akta_meninggal_ibu_mertua:'', tgl_meninggal_ibu_mertua: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_ibu_mertua', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_ibu_mertua', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_ibu_mertua', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_ibu_mertua', allowBlank: true, anchor: '100%'},
	       ]
	    	},	    	
    	 ]
    	},
    ]
   },
	 {xtype: 'fieldset', id: 'frame_grid_mertua', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
	 	items: [grid_Profil_PNS_BIM]
	 }   
  ]
});

var Form_Saudara = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Saudara', url: BASE_URL + 'profil_pns/ext_insert_saudara',
  frame: true, bodyStyle: 'padding: 0 0 0 0;', height: '100%', width: '100%', defaultType: 'textfield', 
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'}, buttonAlign:'left', autoScroll:true,
  items: [
   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', 
    items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	    	{name: 'IDP_Sdr', xtype: 'hidden'}, {name: 'NIP', xtype: 'hidden', id: 'NIP_Saudara'},
	  		{xtype: 'fieldset', id: 'frame_form_sdr', title: 'Data Saudara Kandung', defaultType: 'textfield', defaults: {labelWidth: 115}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',flex:1,
	  	   items: [
	    	 	{fieldLabel: 'Nama Lengkap', name: 'nama_sdr', id: 'nama_sdr', allowBlank: false, anchor: '100%'},
	     	 	{xtype: 'combobox', fieldLabel: 'Jenis Kelamin', name: 'jk_sdr', margins: '0 10 0 0', width: 190,
	         store: new Ext.data.SimpleStore({data: [['L'],['P']], fields: ['jk_sdr']}),
	         valueField: 'jk_sdr', displayField: 'jk_sdr', emptyText: 'Jenis',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        	 	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'TTL',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Tempat Lahir', name: 'tmpt_lahir_sdr', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Lahir', name: 'tgl_lahir_sdr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
		     	{xtype: 'combobox', fieldLabel: 'Agama', name: 'agama_sdr', width: 220,
		       store: new Ext.data.SimpleStore({data: [['Islam'],['Katolik'],['Protestan'],['Hindu'],['Budha']], fields: ['agama_sdr']}),
		       valueField: 'agama_sdr', displayField: 'agama_sdr', emptyText: 'Agama',
		       queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
		       listeners: {
		       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
		       }
		      },    	 
	    	 	{fieldLabel: 'Alamat Tinggal', name: 'alamat_sdr', anchor: '100%'},
	    	 	{fieldLabel: 'Telepon', name: 'telp_sdr', width: 250},
			    {xtype: 'fieldcontainer', fieldLabel: 'Pekerjaan', combineErrors: false,
			     defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', allowBlank: true,
			     items: [
			     		{xtype: 'textfield', name: 'pekerjaan_sdr', id: 'pekerjaan_sdr', margin: '0 2 0 0', flex:2},
			     		{xtype: 'button', name: 'search_pekerjaan', id: 'search_pekerjaan_sdr', text: '...', 
			     			handler: function(){Load_Panel_Ref('win_popup_RefPekerjaan', 'ref_pekerjaan', 'Form_Saudara', 8);}
			        }
			     ]
			    },
	     	 	{xtype: 'combobox', fieldLabel: 'Status Perkawinan', name: 'status_kawin_sdr', margins: '0 10 0 0', width: 230,
	         store: new Ext.data.SimpleStore({data: [['Belum Kawin'],['Kawin'],['Janda'],['Duda']], fields: ['status_kawin_sdr']}),
	         valueField: 'status_kawin_sdr', displayField: 'status_kawin_sdr', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Kawin'){
	        				Ext.getCmp('akta_tgl_nikah_sdr').show();
	        				Ext.getCmp('akta_tgl_cerai_sdr').hide();
	        				Form_Saudara.getForm().setValues({akta_cerai_sdr:'', tgl_cerai_sdr: ''});
	        			}else if(newValue == 'Janda' || newValue == 'Duda'){
	        				Ext.getCmp('akta_tgl_cerai_sdr').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_nikah_sdr').hide();
	        				Ext.getCmp('akta_tgl_cerai_sdr').hide();
	        				Form_Saudara.getForm().setValues({akta_nikah_sdr:'', tgl_nikah_sdr: '', akta_cerai_sdr:'', tgl_cerai_sdr: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_nikah_sdr', layout: 'hbox', fieldLabel: 'Akta & Tgl. Menikah',
	     	   combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Menikah', name: 'akta_nikah_sdr', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Menikah', name: 'tgl_nikah_sdr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_cerai_sdr', layout: 'hbox', fieldLabel: 'Akta & Tgl. Cerai', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Cerai', name: 'akta_cerai_sdr', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Cerai', name: 'tgl_cerai_sdr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
	     	 	{xtype: 'combobox', fieldLabel: 'Status Hidup', name: 'status_hidup_sdr', margins: '0 10 0 0', width: 210,
	         store: new Ext.data.SimpleStore({data: [['Hidup'],['Meninggal']], fields: ['status_hidup_sdr']}),
	         valueField: 'status_hidup_sdr', displayField: 'status_hidup_sdr', emptyText: 'Status',
	         queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
	         listeners: {
	        		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
	        		'change': {fn: function (obj, newValue) {
	        			if(newValue == 'Meninggal'){
	        				Ext.getCmp('akta_tgl_meninggal_sdr').show();
	        			}else{
	        				Ext.getCmp('akta_tgl_meninggal_sdr').hide();
	        				Form_Saudara.getForm().setValues({akta_meninggal_sdr:'', tgl_meninggal_sdr: ''});
	        			}
	        		}, scope: this}
	         }
	        },
	    	 	{xtype: 'fieldcontainer', id: 'akta_tgl_meninggal_sdr', layout: 'hbox', fieldLabel: 'Akta & Tgl. Meninggal', combineErrors: false, defaults: {hideLabel: true},
	     	   items: [
	      	 	{xtype: 'textfield', fieldLabel: 'Akta Meninggal', name: 'akta_meninggal_sdr', margins: '0 5 0 0', flex:2},
	      	 	{xtype: 'datefield', fieldLabel: 'Tanggal Meninggal', name: 'tgl_meninggal_sdr', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 95}
	     	   ]
	    	 	},
			    {fieldLabel: 'Keterangan', name: 'ket_sdr', allowBlank: true, anchor: '100%'},
	  	   ]
	  	  }
    	 ]
    	},
    	{xtype: 'fieldset', id: 'frame_grid_sdr', defaults: {anchor: '100%'}, margins: '8px 0 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [grid_Profil_PNS_Sdr]
    	},
    ]
   }
  ]
});

// FORM KELUARGA PNS  --------------------------------------------------------- END

var Btn_Keluarga = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
  	{text: 'Tambah', id: 'Tambah_Klrg', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Keluarga();}, tooltip: {text: 'Tambah Pegawai'}},
  	{text: 'Ubah', id: 'Ubah_Klrg', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Keluarga();}},
  	{text: 'Simpan', id: 'Simpan_Klrg', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Keluarga();}, tooltip: {text: 'Simpan Informasi Orang Tua dan Istri'}},
  	{text: 'Batal', id: 'Batal_Klrg', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Keluarga();}}
	]
});

// TAB KELUARGA ------------------------------------------------------------ START
var Tab1_Suami_Istri = {
	id: 'Tab1_Suami_Istri', title: 'Suami/Istri', border: false, collapsible: false,
	layout: 'fit', items: [Form_Suami_Istri]
};

var Tab2_Anak = {
	id: 'Tab2_Anak', title: 'Anak', border: false, collapsible: false,
	layout: 'fit', items: [Form_Anak]
};

var Tab3_Bpk_Ibu_Kandung = {
	id: 'Tab3_Bpk_Ibu_Kandung', title: 'Bapak & Ibu Kandung', border: false, collapsible: false,
	layout: 'fit', items: [Form_Bpk_Ibu_Kandung]
};

var Tab3_Bpk_Ibu_Mertua = {
	id: 'Tab3_Bpk_Ibu_Mertua', title: 'Bapak & Ibu Mertua', border: false, collapsible: false,
	layout: 'fit', items: [Form_Bpk_Ibu_Mertua]
};

var Tab4_Saudara = {
	id: 'Tab4_Saudara', title: 'Saudara Kandung', border: false, collapsible: false,
	layout: 'fit', items: [Form_Saudara]
};

var MainTab_Keluarga = new Ext.createWidget('tabpanel', {
	id: 'MainTab_Keluarga', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false, defaults: {autoScroll:true},
  items: [Tab1_Suami_Istri, Tab2_Anak, Tab3_Bpk_Ibu_Kandung, Tab3_Bpk_Ibu_Mertua, Tab4_Saudara],
  bbar: Btn_Keluarga,
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		title_active_tab_klrg = tab.title; Deactive_Form_Keluarga_PNS();
  		if(tab.title == 'Bapak & Ibu Kandung'){ setValue_Form_Bpk_Ibu_Kandung(); }
  	}
  }
});
// TAB KELUARGA ------------------------------------------------------------ END

function Profil_PNS_Tambah_Keluarga(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	var vAlamat = Form_Biodata_PNS.getForm().findField('alamat').getValue();
	switch(title_active_tab_klrg){
		case 'Suami/Istri':
			ID_Form_Keluarga = 'Form_Suami_Istri'; break;
		case 'Anak':
			ID_Form_Keluarga = 'Form_Anak'; break;
		case 'Bapak & Ibu Kandung':
			ID_Form_Keluarga = 'Form_Bpk_Ibu_Kandung'; break;
		case 'Bapak & Ibu Mertua':
			ID_Form_Keluarga = 'Form_Bpk_Ibu_Mertua'; break;
		default:
			ID_Form_Keluarga = 'Form_Saudara';
	}

	Cur_Form_Keluarga = window[ID_Form_Keluarga];	
	Cur_Form_Keluarga.getForm().reset();
	
	if(title_active_tab_klrg == 'Suami/Istri'){
		Cur_Form_Keluarga.getForm().setValues({NIP:vNIP, alamat_si: vAlamat, status_kawin_si: 'Kawin', status_hidup_si: 'Hidup'});
	}else if(title_active_tab_klrg == 'Anak'){
		Cur_Form_Keluarga.getForm().setValues({NIP:vNIP, alamat_anak: vAlamat, status_anak: 'Kandung', status_kawin_anak: 'Belum Kawin', status_hidup_anak: 'Hidup'});
	}else{
		Cur_Form_Keluarga.getForm().setValues({NIP:vNIP});
	}
	Active_Form_Keluarga_PNS();
}

function Profil_PNS_Ubah_Keluarga(){
	if(title_active_tab_klrg == 'Suami/Istri'){
		ID_Form_Keluarga = 'Form_Suami_Istri';
		ID_Field_Keluarga = 'IDP_SI';
		vcb_agama_si = Form_Suami_Istri.getForm().findField('agama_si').getValue();
		vcb_status_kawin_si = Form_Suami_Istri.getForm().findField('status_kawin_si').getValue();
		vcb_status_hidup_si = Form_Suami_Istri.getForm().findField('status_hidup_si').getValue();
	}else if(title_active_tab_klrg == 'Anak'){
		ID_Form_Keluarga = 'Form_Anak';
		ID_Field_Keluarga = 'IDP_Anak';
		vcb_status_anak = Form_Anak.getForm().findField('status_anak').getValue();
		vcb_agama_anak = Form_Anak.getForm().findField('agama_anak').getValue();
		vcb_status_kawin_anak = Form_Anak.getForm().findField('status_kawin_anak').getValue();
		vcb_status_hidup_anak = Form_Anak.getForm().findField('status_hidup_anak').getValue();
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Kandung';
		ID_Field_Keluarga = 'IDP_BIK';
		Active_Form_Keluarga_PNS();
		var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
		Form_Bpk_Ibu_Kandung.getForm().setValues({NIP: vNIP});
	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Mertua';
		ID_Field_Keluarga = 'IDP_BIM';
	}else{
		ID_Form_Keluarga = 'Form_Saudara';
		ID_Field_Keluarga = 'IDP_Sdr';
	}
	Cur_Form_Keluarga = window[ID_Form_Keluarga];

	var ID_Field = Cur_Form_Keluarga.getForm().findField(ID_Field_Keluarga).getValue();
	if(ID_Field){
		P_Klrg_last_record = Cur_Form_Keluarga.getForm().getValues();
		Active_Form_Keluarga_PNS();
	}
}

function Profil_PNS_Batal_Keluarga(){
	if(title_active_tab_klrg == 'Suami/Istri'){
		ID_Form_Keluarga = 'Form_Suami_Istri';
		ID_Field_Keluarga = 'IDP_SI';
		Form_Suami_Istri.getForm().setValues({agama_si: vcb_agama_si, status_kawin_si: vcb_status_kawin_si, status_hidup_si: vcb_status_hidup_si});
	}else if(title_active_tab_klrg == 'Anak'){
		ID_Form_Keluarga = 'Form_Anak';
		ID_Field_Keluarga = 'IDP_Anak';
		Form_Anak.getForm().setValues({status_anak:vcb_status_anak, agama_anak: vcb_agama_anak, status_kawin_anak: vcb_status_kawin_anak, status_hidup_anak: vcb_status_hidup_anak });
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Kandung';
		ID_Field_Keluarga = 'IDP_BIK';
	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Mertua';
		ID_Field_Keluarga = 'IDP_BIM';
	}else{
		ID_Form_Keluarga = 'Form_Saudara';
		ID_Field_Keluarga = 'IDP_Sdr';
	}
	Cur_Form_Keluarga = window[ID_Form_Keluarga];

	var ID_Field = Cur_Form_Keluarga.getForm().findField(ID_Field_Keluarga).getValue();
	if(!ID_Field){
		Cur_Form_Keluarga.getForm().reset();
	}else{
		Cur_Form_Keluarga.getForm().setValues(P_Klrg_last_record);
	}
	Deactive_Form_Keluarga_PNS();
}

function Profil_PNS_Simpan_Keluarga(){
	if(title_active_tab_klrg == 'Suami/Istri'){
		ID_Form_Keluarga = 'Form_Suami_Istri';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_SI';
	}else if(title_active_tab_klrg == 'Anak'){
		ID_Form_Keluarga = 'Form_Anak';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_Anak';
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Kandung';
		ID_Data_Proxy_Keluarga = null;
	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Mertua';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_BIM';
	}else{
		ID_Form_Keluarga = 'Form_Saudara';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_Sdr';
	}
	Cur_Form_Keluarga = window[ID_Form_Keluarga];
	Cur_Data_Proxy_Keluarga = window[ID_Data_Proxy_Keluarga];

	Ext.getCmp(ID_Form_Keluarga).on({
  	beforeaction: function() {Ext.getCmp(ID_Form_Keluarga).body.mask();}
  });

  Cur_Form_Keluarga.getForm().submit({
  	success: function(form, action){
  		Ext.getCmp(ID_Form_Keluarga).body.unmask();
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Return = obj.info.reason;
				if(title_active_tab_klrg == 'Suami/Istri'){
					Cur_Form_Keluarga.getForm().setValues({IDP_SI:IDP_Return});
				}else if(title_active_tab_klrg == 'Anak'){
					Cur_Form_Keluarga.getForm().setValues({IDP_Anak:IDP_Return});
				}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
					Cur_Form_Keluarga.getForm().setValues({IDP_BIK:IDP_Return});
				}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
					Cur_Form_Keluarga.getForm().setValues({IDP_BIM:IDP_Return});
				}else{
					Cur_Form_Keluarga.getForm().setValues({IDP_Sdr:IDP_Return});
				}
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});  			
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}

  		if(ID_Data_Proxy_Keluarga){
  			Cur_Data_Proxy_Keluarga.load();
  		}
  		Deactive_Form_Keluarga_PNS();
  		All_Button_Enabled(); Ext.getCmp('keluarga_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp(ID_Form_Keluarga).body.unmask();
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

function Profil_PNS_Hapus_Keluarga(){
	if(title_active_tab_klrg == 'Suami/Istri'){
		URI_Del_Keluarga = 'ext_delete_suami_istri';
		ID_Form_Keluarga = 'Form_Suami_Istri';
		ID_Field_Keluarga = 'IDP_SI';
		ID_Grid_Keluarga = 'grid_Profil_PNS_SI';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_SI';
	}else if(title_active_tab_klrg == 'Anak'){
		URI_Del_Keluarga = 'ext_delete_anak';
		ID_Form_Keluarga = 'Form_Anak';
		ID_Field_Keluarga = 'IDP_Anak';
		ID_Grid_Keluarga = 'grid_Profil_PNS_Anak';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_Anak';
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		URI_Del_Keluarga = null;
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Kandung';
		ID_Field_Keluarga = 'IDP_BIK';
		ID_Grid_Keluarga = null;
		ID_Data_Proxy_Keluarga = null;
	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		URI_Del_Keluarga = 'ext_delete_bpk_ibu_mertua';
		ID_Form_Keluarga = 'Form_Bpk_Ibu_Mertua';
		ID_Field_Keluarga = 'IDP_BIM';
		ID_Grid_Keluarga = 'grid_Profil_PNS_BIM';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_BIM';
	}else{
		URI_Del_Keluarga = 'ext_delete_saudara';
		ID_Form_Keluarga = 'Form_Saudara';
		ID_Field_Keluarga = 'IDP_Sdr';
		ID_Grid_Keluarga = 'grid_Profil_PNS_Sdr';
		ID_Data_Proxy_Keluarga = 'Data_Profil_PNS_Sdr';
	}
	Cur_Form_Keluarga = window[ID_Form_Keluarga];
	Cur_Grid_Keluarga = window[ID_Grid_Keluarga];
	Cur_Data_Proxy_Keluarga = window[ID_Data_Proxy_Keluarga];
	
	if(ID_Grid_Keluarga){
	  var sm = Cur_Grid_Keluarga.getSelectionModel(), sel = sm.getSelection();
	  if(sel.length > 0){
			Ext.Msg.show({
	   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
	     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
	     	fn: function(btn) {
	     		if (btn == 'yes') {
	     			var data = '';
	     			for (i = 0; i < sel.length; i++) {
	         		data = data + sel[i].get(ID_Field_Keluarga) + '-';
						}
						Ext.Ajax.request({
	         		url: BASE_URL + 'profil_pns/' + URI_Del_Keluarga, method: 'POST',
	         		params: { id_open: 1, postdata: data },
	          	success: function(response){Cur_Data_Proxy_Keluarga.load(); Cur_Form_Keluarga.getForm().reset();},
	    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
	         	});
	     		}
	     	}
	   	});
	  }
	}
}

function setValue_Form_Bpk_Ibu_Kandung(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Ext.Ajax.timeout = Time_Out;
	Ext.Ajax.request({
  	url: BASE_URL + 'profil_pns/ext_get_all_bpk_ibu_kandung',
   	method: 'POST', params: {id_open:1, NIP:vNIP}, renderer: 'data',
   	success: function(response){
    	if(response.responseText != "GAGAL"){
  			obj = Ext.decode(response.responseText);
  			var value_BIK = {
    			IDP_BIK: obj.results.IDP_BIK,
    			NIP: obj.results.NIP,
    			nama_ayah: obj.results.nama_ayah,
    			tmpt_lahir_ayah: obj.results.tmpt_lahir_ayah,
    			tgl_lahir_ayah: obj.results.tgl_lahir_ayah,
    			alamat_ayah: obj.results.alamat_ayah,
    			telp_ayah: obj.results.telp_ayah,
    			pekerjaan_ayah: obj.results.pekerjaan_ayah,
    			status_kawin_ayah: obj.results.status_kawin_ayah,
    			akta_cerai_ayah: obj.results.akta_cerai_ayah,
    			tgl_cerai_ayah: obj.results.tgl_cerai_ayah,
    			status_hidup_ayah: obj.results.status_hidup_ayah,
    			akta_meninggal_ayah: obj.results.akta_meninggal_ayah,
    			tgl_meninggal_ayah: obj.results.tgl_meninggal_ayah,
    			ket_ayah: obj.results.ket_ayah,
    			nama_ibu: obj.results.nama_ibu,
    			tmpt_lahir_ibu: obj.results.tmpt_lahir_ibu,
    			tgl_lahir_ibu: obj.results.tgl_lahir_ibu,
    			alamat_ibu: obj.results.alamat_ibu,
    			telp_ibu: obj.results.telp_ibu,
    			pekerjaan_ibu: obj.results.pekerjaan_ibu,
    			status_kawin_ibu: obj.results.status_kawin_ibu,
    			akta_cerai_ibu: obj.results.akta_cerai_ibu,
    			tgl_cerai_ibu: obj.results.tgl_cerai_ibu,
    			status_hidup_ibu: obj.results.status_hidup_ibu,
    			akta_meninggal_ibu: obj.results.akta_meninggal_ibu,
    			tgl_meninggal_ibu: obj.results.tgl_meninggal_ibu,
    			ket_ibu: obj.results.ket_ibu
    		};
				Form_Bpk_Ibu_Kandung.getForm().setValues(value_BIK);
    	}else{
    		Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
    	}
  	},
   	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); },
   	callback: function(response){ Ext.getCmp('Center_Popup_PPNS').body.unmask(); },
   	scope : this
	});
};

function setValue_Form_Keluarga_PNS(){
	Ext.getCmp('Center_Popup_PPNS').body.mask("Loading...", "x-mask-loading");
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	var vstatus_kawin = Form_Biodata_PNS.getForm().findField('status_kawin').getValue();
	Data_Profil_PNS_Anak.changeParams({params :{id_open: 1, NIP: vNIP}});
	Data_Profil_PNS_SI.changeParams({params :{id_open: 1, NIP: vNIP}});
	Data_Profil_PNS_BIM.changeParams({params :{id_open: 1, NIP: vNIP}});	
	Data_Profil_PNS_Sdr.changeParams({params :{id_open: 1, NIP: vNIP}});	
}

function Active_Form_Keluarga_PNS(){
	Ext.getCmp('Tambah_Klrg').setDisabled(true);
	Ext.getCmp('Ubah_Klrg').setDisabled(true);
	Ext.getCmp('Simpan_Klrg').setDisabled(false);
	Ext.getCmp('Batal_Klrg').setDisabled(false);
	
	if(title_active_tab_klrg == 'Suami/Istri'){
		Form_Suami_Istri.getForm().findField('nama_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('tmpt_lahir_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('tgl_lahir_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('alamat_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('telp_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('agama_si').setDisabled(false);
		Form_Suami_Istri.getForm().findField('nama_pddk').setReadOnly(false);
		Ext.getCmp('search_pendidikan_si').setDisabled(false);
		Form_Suami_Istri.getForm().findField('pekerjaan_si').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_si').setDisabled(false);
		Form_Suami_Istri.getForm().findField('status_kawin_si').setDisabled(false);
		Form_Suami_Istri.getForm().findField('akta_nikah_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('tgl_nikah_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('akta_cerai_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('tgl_cerai_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('status_hidup_si').setDisabled(false);
		Form_Suami_Istri.getForm().findField('akta_meninggal_si').setReadOnly(false);
		Form_Suami_Istri.getForm().findField('tgl_meninggal_si').setReadOnly(false);	
	}else if(title_active_tab_klrg == 'Anak'){
		Form_Anak.getForm().findField('nama_anak').setReadOnly(false);
		Form_Anak.getForm().findField('jk_anak').setDisabled(false);
		Form_Anak.getForm().findField('tmpt_lahir_anak').setReadOnly(false);
		Form_Anak.getForm().findField('tgl_lahir_anak').setReadOnly(false);
		Form_Anak.getForm().findField('akta_lahir_anak').setReadOnly(false);
		Form_Anak.getForm().findField('status_anak').setDisabled(false);
		Form_Anak.getForm().findField('anak_ke').setReadOnly(false);
		Form_Anak.getForm().findField('agama_anak').setDisabled(false);
		Form_Anak.getForm().findField('alamat_anak').setReadOnly(false);
		Form_Anak.getForm().findField('telp_anak').setReadOnly(false);
		Form_Anak.getForm().findField('nama_pddk').setReadOnly(false);
		Ext.getCmp('search_pendidikan_anak').setDisabled(false);
		Form_Anak.getForm().findField('pekerjaan_anak').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_anak').setDisabled(false);
		Form_Anak.getForm().findField('status_kawin_anak').setDisabled(false);
		Form_Anak.getForm().findField('akta_nikah_anak').setReadOnly(false);
		Form_Anak.getForm().findField('tgl_nikah_anak').setReadOnly(false);
		Form_Anak.getForm().findField('akta_cerai_anak').setReadOnly(false);
		Form_Anak.getForm().findField('tgl_cerai_anak').setReadOnly(false);
		Form_Anak.getForm().findField('status_hidup_anak').setDisabled(false);
		Form_Anak.getForm().findField('akta_meninggal_anak').setReadOnly(false);
		Form_Anak.getForm().findField('tgl_meninggal_anak').setReadOnly(false);	
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		Form_Bpk_Ibu_Kandung.getForm().findField('nama_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tmpt_lahir_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_lahir_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('alamat_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('telp_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('pekerjaan_ayah').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_ayah').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_kawin_ayah').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_cerai_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_cerai_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_hidup_ayah').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_meninggal_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_meninggal_ayah').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('ket_ayah').setReadOnly(false);
		
		Form_Bpk_Ibu_Kandung.getForm().findField('nama_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tmpt_lahir_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_lahir_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('alamat_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('telp_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('pekerjaan_ibu').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_ibu').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_kawin_ibu').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_cerai_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_cerai_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_hidup_ibu').setDisabled(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_meninggal_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_meninggal_ibu').setReadOnly(false);
		Form_Bpk_Ibu_Kandung.getForm().findField('ket_ibu').setReadOnly(false);

	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		Form_Bpk_Ibu_Mertua.getForm().findField('nama_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tmpt_lahir_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_lahir_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('alamat_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('telp_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('pekerjaan_ayah_mertua').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_ayah_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_kawin_ayah_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_cerai_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_cerai_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_hidup_ayah_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_meninggal_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_meninggal_ayah_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('ket_ayah_mertua').setReadOnly(false);
		
		Form_Bpk_Ibu_Mertua.getForm().findField('nama_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tmpt_lahir_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_lahir_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('alamat_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('telp_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('pekerjaan_ibu_mertua').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_ibu_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_kawin_ibu_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_cerai_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_cerai_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_hidup_ibu_mertua').setDisabled(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_meninggal_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_meninggal_ibu_mertua').setReadOnly(false);
		Form_Bpk_Ibu_Mertua.getForm().findField('ket_ibu_mertua').setReadOnly(false);

	}else if(title_active_tab_klrg == 'Saudara Kandung'){
		Form_Saudara.getForm().findField('nama_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('jk_sdr').setDisabled(false);
		Form_Saudara.getForm().findField('tmpt_lahir_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('tgl_lahir_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('agama_sdr').setDisabled(false);
		Form_Saudara.getForm().findField('alamat_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('telp_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('pekerjaan_sdr').setReadOnly(false);
		Ext.getCmp('search_pekerjaan_sdr').setDisabled(false);
		Form_Saudara.getForm().findField('status_kawin_sdr').setDisabled(false);
		Form_Saudara.getForm().findField('akta_nikah_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('tgl_nikah_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('akta_cerai_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('tgl_cerai_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('status_hidup_sdr').setDisabled(false);
		Form_Saudara.getForm().findField('akta_meninggal_sdr').setReadOnly(false);
		Form_Saudara.getForm().findField('tgl_meninggal_sdr').setReadOnly(false);	
	}
}

function Deactive_Form_Keluarga_PNS(){
	Ext.getCmp('Tambah_Klrg').setDisabled(false);
	Ext.getCmp('Ubah_Klrg').setDisabled(false);
	Ext.getCmp('Simpan_Klrg').setDisabled(true);
	Ext.getCmp('Batal_Klrg').setDisabled(true);
	
	var vstatus_kawin = Form_Biodata_PNS.getForm().findField('status_kawin').getValue();
	if(title_active_tab_klrg == 'Suami/Istri'){
		if(vstatus_kawin == 'Belum Kawin'){
			Ext.getCmp('Tambah_Klrg').setDisabled(true);
			Ext.getCmp('Ubah_Klrg').setDisabled(true);
			Ext.getCmp('frame_form_si').setDisabled(true);
			Ext.getCmp('frame_grid_si').setDisabled(true);
		}else{
			Ext.getCmp('frame_form_si').setDisabled(false);
			Ext.getCmp('frame_grid_si').setDisabled(false);
		}

		Form_Suami_Istri.getForm().findField('nama_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('tmpt_lahir_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('tgl_lahir_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('alamat_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('telp_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('agama_si').setDisabled(true);
		Form_Suami_Istri.getForm().findField('nama_pddk').setReadOnly(true);
		Ext.getCmp('search_pendidikan_si').setDisabled(true);
		Form_Suami_Istri.getForm().findField('pekerjaan_si').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_si').setDisabled(true);
		Form_Suami_Istri.getForm().findField('status_kawin_si').setDisabled(true);
		Form_Suami_Istri.getForm().findField('akta_nikah_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('tgl_nikah_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('akta_cerai_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('tgl_cerai_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('status_hidup_si').setDisabled(true);
		Form_Suami_Istri.getForm().findField('akta_meninggal_si').setReadOnly(true);
		Form_Suami_Istri.getForm().findField('tgl_meninggal_si').setReadOnly(true);	
	}else if(title_active_tab_klrg == 'Anak'){
		if(vstatus_kawin == 'Belum Kawin'){
			Ext.getCmp('Tambah_Klrg').setDisabled(true);
			Ext.getCmp('Ubah_Klrg').setDisabled(true);
			Ext.getCmp('frame_form_anak').setDisabled(true);
			Ext.getCmp('frame_grid_anak').setDisabled(true);
		}else{
			Ext.getCmp('frame_form_anak').setDisabled(false);
			Ext.getCmp('frame_grid_anak').setDisabled(false);
		}

		Form_Anak.getForm().findField('nama_anak').setReadOnly(true);
		Form_Anak.getForm().findField('jk_anak').setDisabled(true);
		Form_Anak.getForm().findField('tmpt_lahir_anak').setReadOnly(true);
		Form_Anak.getForm().findField('tgl_lahir_anak').setReadOnly(true);
		Form_Anak.getForm().findField('akta_lahir_anak').setReadOnly(true);
		Form_Anak.getForm().findField('status_anak').setDisabled(true);
		Form_Anak.getForm().findField('anak_ke').setReadOnly(true);
		Form_Anak.getForm().findField('agama_anak').setDisabled(true);
		Form_Anak.getForm().findField('alamat_anak').setReadOnly(true);
		Form_Anak.getForm().findField('telp_anak').setReadOnly(true);
		Form_Anak.getForm().findField('nama_pddk').setReadOnly(true);
		Ext.getCmp('search_pendidikan_anak').setDisabled(true);
		Form_Anak.getForm().findField('pekerjaan_anak').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_anak').setDisabled(true);
		Form_Anak.getForm().findField('status_kawin_anak').setDisabled(true);
		Form_Anak.getForm().findField('akta_nikah_anak').setReadOnly(true);
		Form_Anak.getForm().findField('tgl_nikah_anak').setReadOnly(true);
		Form_Anak.getForm().findField('akta_cerai_anak').setReadOnly(true);
		Form_Anak.getForm().findField('tgl_cerai_anak').setReadOnly(true);
		Form_Anak.getForm().findField('status_hidup_anak').setDisabled(true);
		Form_Anak.getForm().findField('akta_meninggal_anak').setReadOnly(true);
		Form_Anak.getForm().findField('tgl_meninggal_anak').setReadOnly(true);	
	}else if(title_active_tab_klrg == 'Bapak & Ibu Kandung'){
		Ext.getCmp('Tambah_Klrg').setDisabled(true);
		
		Form_Bpk_Ibu_Kandung.getForm().findField('nama_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tmpt_lahir_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_lahir_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('alamat_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('telp_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('pekerjaan_ayah').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_ayah').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_kawin_ayah').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_cerai_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_cerai_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_hidup_ayah').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_meninggal_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_meninggal_ayah').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('ket_ayah').setReadOnly(true);
		
		Form_Bpk_Ibu_Kandung.getForm().findField('nama_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tmpt_lahir_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_lahir_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('alamat_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('telp_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('pekerjaan_ibu').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_ibu').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_kawin_ibu').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_cerai_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_cerai_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('status_hidup_ibu').setDisabled(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('akta_meninggal_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('tgl_meninggal_ibu').setReadOnly(true);
		Form_Bpk_Ibu_Kandung.getForm().findField('ket_ibu').setReadOnly(true);

	}else if(title_active_tab_klrg == 'Bapak & Ibu Mertua'){
		if(vstatus_kawin == 'Belum Kawin'){
			Ext.getCmp('Tambah_Klrg').setDisabled(true);
			Ext.getCmp('Ubah_Klrg').setDisabled(true);
			Ext.getCmp('frame_form_bpk_mertua').setDisabled(true);
			Ext.getCmp('frame_form_ibu_mertua').setDisabled(true);
		}else{
			Ext.getCmp('frame_form_bpk_mertua').setDisabled(false);
			Ext.getCmp('frame_form_ibu_mertua').setDisabled(false);
		}
		Form_Bpk_Ibu_Mertua.getForm().findField('nama_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tmpt_lahir_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_lahir_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('alamat_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('telp_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('pekerjaan_ayah_mertua').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_ayah_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_kawin_ayah_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_cerai_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_cerai_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_hidup_ayah_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_meninggal_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_meninggal_ayah_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('ket_ayah_mertua').setReadOnly(true);
		
		Form_Bpk_Ibu_Mertua.getForm().findField('nama_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tmpt_lahir_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_lahir_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('alamat_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('telp_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('pekerjaan_ibu_mertua').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_ibu_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_kawin_ibu_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_cerai_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_cerai_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('status_hidup_ibu_mertua').setDisabled(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('akta_meninggal_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('tgl_meninggal_ibu_mertua').setReadOnly(true);
		Form_Bpk_Ibu_Mertua.getForm().findField('ket_ibu_mertua').setReadOnly(true);

	}else if(title_active_tab_klrg == 'Saudara Kandung'){
		Form_Saudara.getForm().findField('nama_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('jk_sdr').setDisabled(true);
		Form_Saudara.getForm().findField('tmpt_lahir_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('tgl_lahir_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('agama_sdr').setDisabled(true);
		Form_Saudara.getForm().findField('alamat_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('telp_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('pekerjaan_sdr').setReadOnly(true);
		Ext.getCmp('search_pekerjaan_sdr').setDisabled(true);
		Form_Saudara.getForm().findField('status_kawin_sdr').setDisabled(true);
		Form_Saudara.getForm().findField('akta_nikah_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('tgl_nikah_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('akta_cerai_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('tgl_cerai_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('status_hidup_sdr').setDisabled(true);
		Form_Saudara.getForm().findField('akta_meninggal_sdr').setReadOnly(true);
		Form_Saudara.getForm().findField('tgl_meninggal_sdr').setReadOnly(true);	
	}
}

var new_panel_PPNS = new Ext.create('Ext.panel.Panel',{
	id: 'keluarga_page', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '84%', border: false,
  items:[MainTab_Keluarga]
});	

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>