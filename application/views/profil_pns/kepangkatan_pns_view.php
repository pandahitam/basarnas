<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_KP_last_record, vcbp_kp_jns_kpkt, vcbp_kp_kode_golru;

// TABEL KEPANGKATAN PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Kpkt', {extend: 'Ext.data.Model',
  	fields: ['IDP_Kpkt', 'NIP', 'kode_golru', 'nama_pangkat', 'nama_golru', 'no_sk_kpkt', 'tgl_sk_kpkt', 'TMT_kpkt', 'mk_bl_kpkt', 'mk_th_kpkt', 'gapok_kpkt', 'jns_kpkt', 'dasar_pp', 'NIP_pejabat', 'nama_pejabat']
});

var Reader_Profil_PNS_Kpkt = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Kpkt', root: 'results', totalProperty: 'total', idProperty: 'IDP_Kpkt'  	
});

var Proxy_Profil_PNS_Kpkt = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_kepangkatan', actionMethods: {read:'POST'},
    reader: Reader_Profil_PNS_Kpkt
});

var Data_Profil_PNS_Kpkt = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Kpkt', model: 'MProfil_PNS_Kpkt', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Kpkt
});

var tbProfil_PNS_Kpkt = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Kpkt},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Kpkt', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Kpkt.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Kpkt();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Kpkt},
		{xtype: 'label', text: 'TMT PMK : ', id:'info_PMK', style: 'color: #FF0000;', margins: '3 15 0 20', hidden: true}
  ]
});

var cbGrid_Profil_PNS_Kpkt = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_Kpkt = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Kpkt', store: Data_Profil_PNS_Kpkt, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_Kpkt, columnLines: true, loadMask: true,
	columns: [
  	{header: "Jenis", dataIndex: 'jns_kpkt', width: 120},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 140},
  	{header: "Gol.Ruang", dataIndex: 'nama_golru', width: 70},
  	{header: "No. SK", dataIndex: 'no_sk_kpkt', width: 180},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_kpkt', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "TMT Pangkat", dataIndex: 'TMT_kpkt', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "MKG Thn", dataIndex: 'mk_th_kpkt', width: 60},
  	{header: "MKG Bln", dataIndex: 'mk_bl_kpkt', width: 60},
  	{header: "Gaji Pokok", dataIndex: 'gapok_kpkt',
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {return Ext.util.Format.currency(value, 'Rp. ');},
  	 width: 100
  	},
  	{header: "Dasar Peraturan", dataIndex: 'dasar_pp', width: 180},
  	{header: "NIP Pejabat", dataIndex: 'NIP_pejabat', width: 120},
  	{header: "Nama Pejabat", dataIndex: 'nama_pejabat', width: 180},
  ],
  tbar: tbProfil_PNS_Kpkt,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_Kpkt, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Kepangkatan_PNS.getForm().loadRecord(records[0]);
      	Form_Arsip_Kpkt.getForm().loadRecord(records[0]);
      	Set_Arsip_Kpkt();
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('kepangkatan_page').setActiveTab('Tab2_Kepangkatan_PNS');
  	}
  }
});
// TABEL KEPANGKATAN PNS  ------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Kpkt = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Kpkt', url: BASE_URL + 'upload_arsip/insert_arsip/kepangkatan', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Kpkt'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Kpkt', value: 3},
		{xtype: 'hidden', name: 'IDP_Kpkt', id: 'IDP_Kpkt_Arsip_Kpkt'},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Kpkt', emptyText: 'Upload Files', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Kpkt.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						var p_IDP_Kpkt = Form_Kepangkatan_PNS.getForm().findField('IDP_Kpkt').getValue();
						Form_Arsip_Kpkt.getForm().setValues({NIP: p_NIP, IDP_Kpkt: p_IDP_Kpkt});
			 			Form_Arsip_Kpkt.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Set_Arsip_Kpkt(); Deactive_Form_Kepangkatan_PNS();
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
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Kpkt', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Kpkt();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Kpkt', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Kpkt();}},
		 ]
		}
	]
});

function Set_Arsip_Kpkt(){Set_Arsip_Digital('Form_Kepangkatan_PNS', 'Btn_Download_Arsip_Kpkt', 'IDP_Kpkt', 3, 'kepangkatan');}
function Reset_Arsip_Kpkt(){Reset_Arsip_Digital('Form_Kepangkatan_PNS', 'Btn_Download_Arsip_Kpkt', 'IDP_Kpkt', 3, 'kepangkatan'); Deactive_Form_Kepangkatan_PNS();}
function Download_Arsip_Kpkt(){Download_Arsip_Digital('Form_Kepangkatan_PNS', 'IDP_Kpkt', 3, 'kepangkatan');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM KEPANGKATAN PNS  --------------------------------------------------------- START
var Form_Kepangkatan_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Kepangkatan_PNS', url: BASE_URL + 'profil_pns/ext_insert_kepangkatan',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Kepangkatan', defaultType: 'textfield', defaults: {labelWidth: 120, labelAlign: 'left'}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
	  	 	 	{name: 'IDP_Kpkt', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Kpkt', xtype: 'hidden'},
		     	{xtype: 'combobox', fieldLabel: 'Jenis Kepangkatan', name: 'jns_kpkt',
		       store: new Ext.data.SimpleStore({data: [['CPNS'],['PNS'],['KP Pilihan'],['KP Reguler'],['KP Pengabdian'],['KP Anumerta']], fields: ['jns_kpkt']}),
		       valueField: 'jns_kpkt', displayField: 'jns_kpkt', emptyText: 'Pilih Jenis',
		       queryMode: 'local', typeAhead: true, forceSelection: true, allowBlank: false,
		       listeners: {
		       		'focus': {fn: function (comboField) {comboField.expand();}, scope: this}
		       }
		      },
		    	{xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
		    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 400, 
		    	 items: [
		     		{xtype: 'combobox', name: 'kode_golru', id: 'kode_golru_kpkt', hiddenName: 'kode_golru',
		       	 store: Data_CB_Golru,
		       	 valueField: 'kode_golru', displayField: 'nama_pangkat', emptyText: 'Pilih Pangkat',
		       	 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Pangkat',
		       	 listeners: {
		       			'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
		        		'change': {fn: function (comboField, newValue) {
		        				Get_Gapok_Profil_Kptk();
		        				Set_Nama_Golru('Form_Kepangkatan_PNS', 'kode_golru', 'nama_golru', kode_jpeg_profil);
		        		}, scope: this}
		       	 }, width: 200, margins: '0 5 0 0'
		      	},
		      	{xtype: 'textfield', fieldLabel: 'Gol. Ruang', name: 'nama_golru', id: 'nama_golru_kpkt', readOnly: true, allowBlank: true, width: 40}    	 
		       ]
		    	},
		    	{fieldLabel: 'NIP Pejabat', name: 'NIP_pejabat', id: 'NIP_pejabat_p_kpkt', maxLength: 21, maskRe: /[\d\ \.\;]/, regex: /^[0-9]|\;*$/, allowBlank: true, width: 300},
		    	{fieldLabel: 'Nama Pejabat', name: 'nama_pejabat', id: 'nama_pejabat_p_kpkt', allowBlank: true, width: 350},
		      {fieldLabel: 'Nomor SK', name: 'no_sk_kpkt', id: 'no_sk_kpkt', width: 350},
		      {xtype: 'datefield', fieldLabel: 'Tanggal SK', name: 'tgl_sk_kpkt', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Masa Kerja Gol.', defaults: {hideLabel: true}, combineErrors: false,
		     	 defaultType: 'numberfield', width: 320,
		     	 items: [
		      	{fieldLabel: 'MK Th', name: 'mk_th_kpkt', id: 'mk_th_kpkt', value: 0, minValue: 0, maxValue: 60, margins: '0 5 0 0', width:50,
		      	 listeners : {'change': {fn: function () {Get_Gapok_Profil_Kptk();}, scope: this}}
		      	},
		      	{xtype: 'label', forId: 'mk_th_kpkt', text: 'Thn.', margins: '3 15 0 0'},
		      	{fieldLabel: 'MK Bl', name: 'mk_bl_kpkt', id: 'mk_bl_kpkt', value: 0, minValue: 0, maxValue: 12, width:50},
		      	{xtype: 'label', forId: 'mk_bl_kpkt', text: 'Bln.', margins: '3 15 0 5'}
		     	 ]
		    	},
		    	{xtype: 'fieldcontainer', fieldLabel: 'Gaji Pokok', combineErrors: false,
		    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 270, 
		    	 items: [
		      		{name: 'gapok_kpkt', xtype: 'hidden', 
		      		 listeners: {change: function(obj, val){
								Form_Kepangkatan_PNS.getForm().setValues({gapok_view_1: Ext.util.Format.currency(val, 'Rp. '), gapok_view_2: Ext.util.Format.number(val, '0')});
		      		 }}
		      		},
		      		{xtype: 'textfield', name: 'gapok_view_1', id: 'gapok_view_1', margin: '0 2 0 0', flex:2, 
		      		 listeners: {focus: function(obj){ this.hide(); Ext.getCmp('gapok_view_2').show(); Ext.getCmp('gapok_view_2').focus();}}
		      		},
		      		{xtype: 'textfield', name: 'gapok_view_2', id: 'gapok_view_2', maskRe: /[\d\;]/, regex: /^[0-9]|\;*$/, margin: '0 2 0 0', hidden: true,
		      		 listeners: {
		      		 	blur: function(obj){this.hide(); Ext.getCmp('gapok_view_1').show();},
		      		 	change : function(obj, val){Form_Kepangkatan_PNS.getForm().setValues({gapok_kpkt: val});}
		      		 }, flex:2
		      		},
		      		{xtype: 'button', name: 'search_gapok', id: 'search_gapok_ProfilKpkt', text: '...', 
		      			handler: function(){Load_Panel_Ref('win_popup_RefGapok', 'ref_gapok', 'Form_Kepangkatan_PNS', 6, Form_Biodata_PNS.getForm().findField('kode_jpeg').getValue());}
		          }
		       ]
		    	},
		      {xtype: 'datefield', fieldLabel: 'TMT Pangkat', name: 'TMT_kpkt', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 220},
		      {fieldLabel: 'Dasar Peraturan', name: 'dasar_pp', id: 'dasar_pp', allowBlank: true, width: 350},	  	 	 	
	  	 	 ]
	  	 	},    	 
    	 ]
    	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Arsip Kepangkatan', defaultType: 'textfield', margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			  	{xtype: 'fieldset', margins: '0 0 0 0', style: 'padding: 0; border-width: 0px; text-align: center;',
			  	 items: [Form_Arsip_Kpkt]
			  	}
			   ]
			  }
    	 ]
    	},
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Kpkt', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Kpkt();}},
  	{text: 'Ubah', id: 'Ubah_Kpkt', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Kpkt();}},
  	{text: 'Simpan', id: 'Simpan_Kpkt', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Kpkt();}},
  	{text: 'Batal', id: 'Batal_Kpkt', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Kpkt();}}
  ]
});
// FORM KEPANGKATAN PNS  --------------------------------------------------------- END

// FUNCTIONS KEPANGKATAN PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Kpkt(){
	Ext.getCmp('kepangkatan_page').setActiveTab('Tab2_Kepangkatan_PNS');
	Form_Kepangkatan_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Kepangkatan_PNS.getForm().setValues({NIP:vNIP});
	Form_Arsip_Kpkt.getForm().setValues({NIP:vNIP});
	Active_Form_Kepangkatan_PNS();

	Form_Kepangkatan_PNS.getForm().findField('filearsip').setDisabled(true);
	Ext.getCmp('Btn_Hapus_Arsip_Kpkt').setDisabled(true);	
	Ext.getCmp('Btn_Download_Arsip_Kpkt').setIconCls('');	
	Ext.getCmp('Btn_Download_Arsip_Kpkt').setDisabled(true);	
}

function Profil_PNS_Ubah_Kpkt(){
	var IDP_Kpkt = Form_Kepangkatan_PNS.getForm().findField('IDP_Kpkt').getValue();
	if(IDP_Kpkt){
		vcbp_kp_jns_kpkt = Form_Kepangkatan_PNS.getForm().findField('jns_kpkt').getValue();
		vcbp_kp_kode_golru = Form_Kepangkatan_PNS.getForm().findField('kode_golru').getValue();
		P_KP_last_record = Form_Kepangkatan_PNS.getForm().getValues();
		Ext.getCmp('kepangkatan_page').setActiveTab('Tab2_Kepangkatan_PNS');
		Active_Form_Kepangkatan_PNS();
	}
}

function Profil_PNS_Simpan_Kpkt(){
	Ext.getCmp('Form_Kepangkatan_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Kepangkatan_PNS').body.mask();}
  });

  Form_Kepangkatan_PNS.getForm().submit({            			
  	success: function(form, action){
  		var vJns_Kpkt = Form_Kepangkatan_PNS.getForm().findField('jns_kpkt').getValue();
  		var vTMT_kpkt = Form_Kepangkatan_PNS.getForm().findField('TMT_kpkt').getValue();
  		if(vJns_Kpkt == 'CPNS'){
  			Form_Biodata_PNS.getForm().setValues({TMT_CPNS: Ext.util.Format.date(vTMT_kpkt,'d/m/Y')});
  		}
  		Data_Profil_PNS_Kpkt.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}}); 
  		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
  		Deactive_Form_Kepangkatan_PNS();
  		All_Button_Enabled(); Ext.getCmp('kepangkatan_menu').setDisabled(true);
  		obj = Ext.decode(action.response.responseText);
  		Ext.getCmp('Form_Kepangkatan_PNS').body.unmask();
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Kpkt = obj.info.reason;
  			Form_Kepangkatan_PNS.getForm().setValues({IDP_Kpkt:IDP_Kpkt});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Kepangkatan_PNS').body.unmask();
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

function Profil_PNS_Hapus_Kpkt(){
  var sm = grid_Profil_PNS_Kpkt.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Kpkt') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_kepangkatan', method: 'POST',
         		params: { postdata: data },
          	success: function(response){
          		Data_Profil_PNS_Kpkt.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
          		Set_Form_Biodata(Form_Biodata_PNS.getForm().findField('NIP').getValue());
          		if(typeof(Data_Profil_PNS) != "undefined"){Data_Profil_PNS.load();}
          	},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Kpkt(){
	var IDP_Kpkt = Form_Kepangkatan_PNS.getForm().findField('IDP_Kpkt').getValue();
	if(!IDP_Kpkt){
		Form_Kepangkatan_PNS.getForm().reset();
	}else{
		Form_Kepangkatan_PNS.getForm().setValues({jns_kpkt:vcbp_kp_jns_kpkt, kode_golru:vcbp_kp_kode_golru});
		Form_Kepangkatan_PNS.getForm().setValues(P_KP_last_record);
	}
	Deactive_Form_Kepangkatan_PNS()
}

function Check_PMK(vNIP){
	Ext.Ajax.request({
  	url: BASE_URL + 'profil_pns/ext_check_pmk', method: 'POST', params: { NIP: vNIP },
    success: function(response){
    	obj = Ext.decode(response.responseText);
    	Ext.getCmp('info_PMK').show();
    	Ext.getCmp('info_PMK').setText(obj.info.reason);
    },
    failure: function(response){
    	Ext.getCmp('info_PMK').hide();
    }
  });
}

function Get_Gapok_Profil_Kptk(){
	var vkode_jpeg = Form_Biodata_PNS.getForm().findField('kode_jpeg').getValue();
	Set_Gaji_Pokok('Form_Kepangkatan_PNS', vkode_jpeg, 'kode_golru', 'mk_th_kpkt', 'gapok_kpkt', 'baru');
}

function setValue_Form_Kepangkatan_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Kepangkatan_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Kpkt.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
	Check_PMK(vNIP);
}

function Active_Form_Kepangkatan_PNS(){
	Ext.getCmp('Tambah_Kpkt').setDisabled(true);
	Ext.getCmp('Ubah_Kpkt').setDisabled(true);
	Ext.getCmp('Simpan_Kpkt').setDisabled(false);
	Ext.getCmp('Batal_Kpkt').setDisabled(false);
	
	Form_Kepangkatan_PNS.getForm().findField('jns_kpkt').setDisabled(false);
	Form_Kepangkatan_PNS.getForm().findField('kode_golru').setDisabled(false);
	Form_Kepangkatan_PNS.getForm().findField('NIP_pejabat').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('nama_pejabat').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('no_sk_kpkt').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('tgl_sk_kpkt').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('mk_th_kpkt').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('mk_bl_kpkt').setReadOnly(false);
	Ext.getCmp('search_gapok_ProfilKpkt').setDisabled(false);	
	Form_Kepangkatan_PNS.getForm().findField('gapok_view_1').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('gapok_view_2').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('TMT_kpkt').setReadOnly(false);
	Form_Kepangkatan_PNS.getForm().findField('dasar_pp').setReadOnly(false);

	Form_Kepangkatan_PNS.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Kpkt').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Kpkt').setDisabled(false);
	}
}

function Deactive_Form_Kepangkatan_PNS(){
	Ext.getCmp('Tambah_Kpkt').setDisabled(false);
	Ext.getCmp('Ubah_Kpkt').setDisabled(false);
	Ext.getCmp('Simpan_Kpkt').setDisabled(true);
	Ext.getCmp('Batal_Kpkt').setDisabled(true);
	
	Form_Kepangkatan_PNS.getForm().findField('jns_kpkt').setDisabled(true);
	Form_Kepangkatan_PNS.getForm().findField('kode_golru').setDisabled(true);
	Form_Kepangkatan_PNS.getForm().findField('NIP_pejabat').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('nama_pejabat').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('no_sk_kpkt').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('tgl_sk_kpkt').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('mk_th_kpkt').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('mk_bl_kpkt').setReadOnly(true);
	Ext.getCmp('search_gapok_ProfilKpkt').setDisabled(true);	
	Form_Kepangkatan_PNS.getForm().findField('gapok_view_1').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('gapok_view_2').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('TMT_kpkt').setReadOnly(true);
	Form_Kepangkatan_PNS.getForm().findField('dasar_pp').setReadOnly(true);

	Form_Kepangkatan_PNS.getForm().findField('filearsip').setDisabled(true);	
	Ext.getCmp('Btn_Hapus_Arsip_Kpkt').setDisabled(true);
}

// FUNCTIONS KEPANGKATAN PNS  ---------------------------------------------------- END

// SHOW INFORMASI PMK ------------------------------------------------------------ START
var Form_Info_PMK = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Info_PMK', frame: true, bodyStyle: 'padding: 0 0 0 0;', height: 30,
 	defaultType: 'textfield', fieldDefaults: {labelAlign: 'left', msgTarget: 'side'},
 	defaults: {anchor: '100%', fieldStyle: 'height: 18px;'},
  items: [
  ]
});
// SHOW INFORMASI PMK ------------------------------------------------------------ END

// PANEL KEPANGKATAN PNS  -------------------------------------------------------- START
var Tab1_Kepangkatan_PNS = {
	id: 'Tab1_Kepangkatan_PNS', title: 'Riwayat Kepangkatan', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Kpkt]
};

var Tab2_Kepangkatan_PNS = {
	id: 'Tab2_Kepangkatan_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Kepangkatan_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'kepangkatan_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Kepangkatan_PNS, Tab2_Kepangkatan_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Kepangkatan'){
  			Data_Profil_PNS_Kpkt.load();
  			Deactive_Form_Kepangkatan_PNS();
  			Form_Kepangkatan_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL KEPANGKATAN PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>