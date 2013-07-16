<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_Reward_last_record;

// TABEL PENGHARGAAN PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_Reward', {extend: 'Ext.data.Model',
  	fields: ['IDP_Reward', 'NIP', 'kode_reward', 'nama_reward', 'no_sk_reward', 'tgl_sk_reward', 'pemberi_reward', 'asal_perolehan', 'mk_th', 'mk_bl', 'TMT_reward', 'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_unor']
});

var Reader_Profil_PNS_Reward = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_Reward', root: 'results', totalProperty: 'total', idProperty: 'IDP_Reward'  	
});

var Proxy_Profil_PNS_Reward = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_penghargaan', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_Reward
});

var Data_Profil_PNS_Reward = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_Reward', model: 'MProfil_PNS_Reward', 
		pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_Reward
});

var tbProfil_PNS_Reward = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_Reward},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_Reward', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_Reward.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_Reward();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_Reward}
  ]
});

var cbGrid_Profil_PNS_Reward = new Ext.create('Ext.selection.CheckboxModel');

var grid_Profil_PNS_Reward = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_Reward', store: Data_Profil_PNS_Reward,
  frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Profil_PNS_Reward, columnLines: true, loadMask: true,
	columns: [
  	{header: "Nama Penghargaan", dataIndex: 'nama_reward', width: 300},
  	{header: "No. SK", dataIndex: 'no_sk_reward', width: 200},
  	{header: "Tgl. SK", dataIndex: 'tgl_sk_reward', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Asal Perolehan", dataIndex: 'asal_perolehan', width: 200},
  	{header: "Pemberi Penghargaan", dataIndex: 'pemberi_reward', width: 200}
  ],
  tbar: tbProfil_PNS_Reward,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Profil_PNS_Reward, dock: 'bottom', displayInfo: true}],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_Reward_PNS.getForm().loadRecord(records[0]);
      	Form_Arsip_Reward.getForm().loadRecord(records[0]);
      	Set_Arsip_Reward();
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('penghargaan_page').setActiveTab('Tab2_Reward_PNS');
  	}    
  }  
});

// TABEL PENGHARGAAN PNS  ------------------------------------------------- END

// ARSIP DIGITAL ------------------------------------------------------- START
var Form_Arsip_Reward = new Ext.create('Ext.form.Panel', {
	id: 'Form_Arsip_Reward', url: BASE_URL + 'upload_arsip/insert_arsip/reward', fileUpload: true, 
	frame: true, width: '100%', height: 33, margins: '0 5 0 0', defaults: {anchor: '100%', allowBlank: true, msgTarget: 'side',labelWidth: 50},
	items: [
		{xtype: 'hidden', name: 'NIP', id: 'NIP_Arsip_Reward'},
		{xtype: 'hidden', name: 'kode_arsip', id: 'kode_arsip_Arsip_Reward', value: 6},
		{xtype: 'hidden', name: 'IDP_Reward', id: 'IDP_Reward_Arsip_Reward'},
    {xtype: 'fieldcontainer', layout: 'hbox', defaults: {hideLabel: true}, combineErrors: false,
     items: [
			{xtype: 'fileuploadfield', name: 'filearsip', id:'filearsip_Reward', emptyText: 'Upload Files', buttonText: '', buttonConfig: {iconCls: 'icon-image_add'}, margins: '0 5 0 0', width: 225,
			 listeners: {
			 	'change': function(){
			 		if(Form_Arsip_Reward.getForm().isValid()){
						var p_NIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
						var p_IDP_Reward = Form_Reward_PNS.getForm().findField('IDP_Reward').getValue();
						Form_Arsip_Reward.getForm().setValues({NIP: p_NIP, IDP_Reward: p_IDP_Reward});
			 			Form_Arsip_Reward.getForm().submit({
			 				waitMsg: 'Sedang meng-upload ...',
			 				success: function(form, action) {
			 					obj = Ext.decode(action.response.responseText);
			 					if(obj.errors.reason == 'SUKSES'){
			 						Set_Arsip_Reward(); Deactive_Form_Reward_PNS();
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
			{xtype: 'button', text: 'Hapus', id:'Btn_Hapus_Arsip_Reward', tooltip: {text: 'Hapus Arsip Digital'}, handler: function() {Reset_Arsip_Reward();}, margins: '0 5 0 0'},
			{xtype: 'button', text: 'Download', id:'Btn_Download_Arsip_Reward', target: '_blank', tooltip: {text: 'Download Arsip Digital'}, handler: function() {Download_Arsip_Reward();}},
		 ]
		}
	]
});

function Set_Arsip_Reward(){Set_Arsip_Digital('Form_Reward_PNS', 'Btn_Download_Arsip_Reward', 'IDP_Reward', 6, 'reward');}
function Reset_Arsip_Reward(){Reset_Arsip_Digital('Form_Reward_PNS', 'Btn_Download_Arsip_Reward', 'IDP_Reward', 6, 'reward'); Deactive_Form_Reward_PNS();}
function Download_Arsip_Reward(){Download_Arsip_Digital('Form_Reward_PNS', 'IDP_Reward', 6, 'reward');}
// ARSIP DIGITAL ------------------------------------------------------- END

// FORM PENGHARGAAN PNS  --------------------------------------------------------- START
var Form_Reward_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_Reward_PNS', url: BASE_URL + 'profil_pns/ext_insert_penghargaan',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 150},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
  	{xtype: 'fieldcontainer', layout: 'hbox', 
  	 items: [
    	{xtype: 'fieldset', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Data Penghargaan', defaultType: 'textfield', defaults: {labelWidth: 130, labelAlign: 'left'}, margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
	  	 	 	{name: 'IDP_Reward', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_Pddk', xtype: 'hidden'},
		    	{xtype: 'fieldcontainer', fieldLabel: 'Nama Penghargaan', combineErrors: false,
		    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', anchor: '100%', 
		    	 items: [
		      	{name: 'kode_reward', xtype: 'hidden'},
		      	{xtype: 'textfield', name: 'nama_reward', id: 'nama_reward', margin: '0 2 0 0', allowBlank: false, readOnly: true, width: 200},
		      	{xtype: 'button', name: 'search_reward', id: 'search_reward', text: '...',
		      		handler: function(){Load_Panel_Ref('win_popup_RefReward', 'ref_reward', 'Form_Reward_PNS', 1);}
		        }
		       ]
		    	},
		    	{xtype: 'fieldcontainer', layout: 'hbox', fieldLabel: 'Masa Kerja Gol.', defaults: {hideLabel: true}, combineErrors: false,
		     	 defaultType: 'numberfield', width: 340,
		     	 items: [
		      	{fieldLabel: 'MK Th', name: 'mk_th', id: 'mk_th_reward', value: 0, minValue: 0, maxValue: 60, margins: '0 5 0 0', width:50},
		      	{xtype: 'label', forId: 'mk_th_reward', text: 'Thn.', margins: '3 15 0 0'},
		      	{fieldLabel: 'MK Bl', name: 'mk_bl', id: 'mk_bl_reward', value: 0, minValue: 0, maxValue: 12, width:50},
		      	{xtype: 'label', forId: 'mk_bl_reward', text: 'Bln.', margins: '3 15 0 5'}
		     	 ]
		    	},
		      {fieldLabel: 'No. SK', name: 'no_sk_reward', id: 'no_sk_reward', anchor: '85%'},
		      {xtype: 'datefield', fieldLabel: 'Tgl. SK', name: 'tgl_sk_reward', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 250},
		      {fieldLabel: 'Asal Perolehan', name: 'asal_perolehan', id: 'asal_perolehan', anchor: '90%'},
		      {fieldLabel: 'Pemberi Penghargaan', name: 'pemberi_reward', id: 'pemberi_reward', anchor: '90%'}
	  	 	 ]
	  	 	},
    	 ]
    	},
    	{xtype: 'fieldset', margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex: 1,
    	 items: [
	  		{xtype: 'fieldset', title: 'Arsip Penghargaan', defaultType: 'textfield', margins: '0 5 0 0', style: 'padding: 0 5px 0 5px;',
	  	 	 items: [
			  	{xtype: 'fieldset', margins: '0 0 0 0', style: 'padding: 0; border-width: 0px; text-align: center;',
			  	 items: [Form_Arsip_Reward]
			  	}
			   ]
			  }
    	 ]
    	},
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_Reward', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_Reward();}},
  	{text: 'Ubah', id: 'Ubah_Reward', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_Reward();}},
  	{text: 'Simpan', id: 'Simpan_Reward', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_Reward();}},
  	{text: 'Batal', id: 'Batal_Reward', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_Reward();}}
  ]
});
// FORM PENGHARGAAN PNS  --------------------------------------------------------- END

// FUNCTIONS PENGHARGAAN PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_Reward(){
	Ext.getCmp('penghargaan_page').setActiveTab('Tab2_Reward_PNS');
	Form_Reward_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Reward_PNS.getForm().setValues({NIP:vNIP});
	Form_Arsip_Reward.getForm().setValues({NIP:vNIP});
	Active_Form_Reward_PNS();	

	Form_Arsip_Reward.getForm().findField('filearsip').setDisabled(true);
	Ext.getCmp('Btn_Hapus_Arsip_Reward').setDisabled(true);	
	Ext.getCmp('Btn_Download_Arsip_Reward').setIconCls('');	
	Ext.getCmp('Btn_Download_Arsip_Reward').setDisabled(true);	
}

function Profil_PNS_Ubah_Reward(){
	var IDP_Reward = Form_Reward_PNS.getForm().findField('IDP_Reward').getValue();
	if(IDP_Reward){
		P_Reward_last_record = Form_Reward_PNS.getForm().getValues();
		Ext.getCmp('penghargaan_page').setActiveTab('Tab2_Reward_PNS');
		Active_Form_Reward_PNS();
	}
}

function Profil_PNS_Simpan_Reward(){
	Ext.getCmp('Form_Reward_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_Reward_PNS').body.mask();}
  });

  Form_Reward_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_Reward = obj.info.reason;
  			Form_Reward_PNS.getForm().setValues({IDP_Reward:IDP_Reward});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_Reward_PNS').body.unmask(); Data_Profil_PNS_Reward.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_Reward_PNS();	
  		All_Button_Enabled(); Ext.getCmp('penghargaan_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_Reward_PNS').body.unmask();
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

function Profil_PNS_Hapus_Reward(){
  var sm = grid_Profil_PNS_Reward.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_Reward') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_penghargaan', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_Reward.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_Reward(){
	var IDP_Reward = Form_Reward_PNS.getForm().findField('IDP_Reward').getValue();
	if(!IDP_Reward){
		Form_Reward_PNS.getForm().reset();
	}else{
		Form_Reward_PNS.getForm().setValues(P_Reward_last_record);
	}
	Deactive_Form_Reward_PNS();	
}

function setValue_Form_Reward_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_Reward_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_Reward.changeParams({params :{id_open: '1', NIP: vNIP}});
}

function Active_Form_Reward_PNS(){
	Ext.getCmp('Tambah_Reward').setDisabled(true);
	Ext.getCmp('Ubah_Reward').setDisabled(true);
	Ext.getCmp('Simpan_Reward').setDisabled(false);
	Ext.getCmp('Batal_Reward').setDisabled(false);
	
	Ext.getCmp('search_reward').setDisabled(false);	
	Form_Reward_PNS.getForm().findField('mk_th').setReadOnly(false);
	Form_Reward_PNS.getForm().findField('mk_bl').setReadOnly(false);
	Form_Reward_PNS.getForm().findField('no_sk_reward').setReadOnly(false);
	Form_Reward_PNS.getForm().findField('tgl_sk_reward').setReadOnly(false);
	Form_Reward_PNS.getForm().findField('asal_perolehan').setReadOnly(false);
	Form_Reward_PNS.getForm().findField('pemberi_reward').setReadOnly(false);

	Form_Reward_PNS.getForm().findField('filearsip').setDisabled(false);
	if(Ext.getCmp('Btn_Download_Arsip_Reward').disabled == false){
		Ext.getCmp('Btn_Hapus_Arsip_Reward').setDisabled(false);
	}
}

function Deactive_Form_Reward_PNS(){
	Ext.getCmp('Tambah_Reward').setDisabled(false);
	Ext.getCmp('Ubah_Reward').setDisabled(false);
	Ext.getCmp('Simpan_Reward').setDisabled(true);
	Ext.getCmp('Batal_Reward').setDisabled(true);
	
	Ext.getCmp('search_reward').setDisabled(true);	
	Form_Reward_PNS.getForm().findField('mk_th').setReadOnly(true);
	Form_Reward_PNS.getForm().findField('mk_bl').setReadOnly(true);
	Form_Reward_PNS.getForm().findField('no_sk_reward').setReadOnly(true);
	Form_Reward_PNS.getForm().findField('tgl_sk_reward').setReadOnly(true);
	Form_Reward_PNS.getForm().findField('asal_perolehan').setReadOnly(true);
	Form_Reward_PNS.getForm().findField('pemberi_reward').setReadOnly(true);

	Form_Reward_PNS.getForm().findField('filearsip').setDisabled(true);	
	Ext.getCmp('Btn_Hapus_Arsip_Reward').setDisabled(true);
}

// FUNCTIONS PENGHARGAAN PNS  ---------------------------------------------------- END

// PANEL PENGHARGAAN PNS  -------------------------------------------------------- START
var Tab1_Reward_PNS = {
	id: 'Tab1_Reward_PNS', title: 'Riwayat Penghargaan', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_Reward]
};

var Tab2_Reward_PNS = {
	id: 'Tab2_Reward_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_Reward_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'penghargaan_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_Reward_PNS, Tab2_Reward_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat Penghargaan'){
  			Data_Profil_PNS_Reward.load();
  			Deactive_Form_Reward_PNS(); 
  			Form_Reward_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL PENGHARGAAN PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>