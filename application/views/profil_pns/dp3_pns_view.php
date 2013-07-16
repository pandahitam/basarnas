<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var P_DP3_last_record;

// TABEL DP3 PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS_DP3', {extend: 'Ext.data.Model',
  	fields: ['IDP_DP3', 'NIP', 'tgl_dp3', 'kesetiaan', 'prestasi', 'tanggung_jwb', 'ketaatan', 'kejujuran', 'kerjasama', 'prakarsa', 'kepemimpinan', 'jumlah', 'nilai_dp3', 'penilai_dp3', 'catatan_dp3', 'kode_golru', 'nama_pangkat', 'nama_golru']
});

var Reader_Profil_PNS_DP3 = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Profil_PNS_DP3', root: 'results', totalProperty: 'total', idProperty: 'IDP_DP3'  	
});

var Proxy_Profil_PNS_DP3 = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'profil_pns/ext_get_all_dp3', actionMethods: {read:'POST'}, 
    reader: Reader_Profil_PNS_DP3
});

var Data_Profil_PNS_DP3 = new Ext.create('Ext.data.Store', {
		id: 'Data_Profil_PNS_DP3', model: 'MProfil_PNS_DP3', pageSize: 20,	noCache: false, autoLoad: false,
    proxy: Proxy_Profil_PNS_DP3
});

var tbProfil_PNS_DP3 = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', disabled: ppns_insert, handler: Profil_PNS_Tambah_DP3},'-',
  	{text: 'Ubah', iconCls: 'icon-edit', id: 'Btn_Ubah_DP3', disabled: ppns_update, 
  	 handler: function() {
  	 		var sm = grid_Profil_PNS_DP3.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  	 			Profil_PNS_Ubah_DP3();
  	 		}
  	 }
  	},'-',			
		{text: 'Hapus', iconCls: 'icon-delete', disabled: ppns_delete, handler: Profil_PNS_Hapus_DP3}
  ]
});

var cbGrid_Profil_PNS_DP3 = new Ext.create('Ext.selection.CheckboxModel');
var grid_Profil_PNS_DP3 = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Profil_PNS_DP3', store: Data_Profil_PNS_DP3, frame: true, border: true, style: 'margin:0 auto;', height: '100%', width: '100%', 
	selModel: cbGrid_Profil_PNS_DP3, columnLines: true, loadMask: true,
	columns: [
  	{header: "Tanggal", dataIndex: 'tgl_dp3', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', width: 130},
  	{header: "Gol. Ruang", dataIndex: 'nama_golru', width: 70},
  	{header: "Kesetiaan", dataIndex: 'kesetiaan', width: 60},
  	{header: "Prestasi", dataIndex: 'prestasi', width: 60},
  	{header: "Tanggung Jwb", dataIndex: 'tanggung_jwb', width: 90},
  	{header: "Ketaatan", dataIndex: 'ketaatan', width: 60},
  	{header: "Kejujuran", dataIndex: 'kejujuran', width: 60},
  	{header: "Kerjasama", dataIndex: 'kerjasama', width: 60},
  	{header: "Prakarsa", dataIndex: 'prakarsa', width: 60},
  	{header: "Kepemimpinan", dataIndex: 'kepemimpinan', width: 80},
  	{header: "Jumlah", dataIndex: 'jumlah', width: 60},
  	{header: "Nilai DP3", dataIndex: 'nilai_dp3', width: 60},
  	{header: "Penilai", dataIndex: 'penilai_dp3', width: 200}
  ],
  tbar: tbProfil_PNS_DP3,
  dockedItems: [{
  	xtype: 'pagingtoolbar', store: Data_Profil_PNS_DP3, dock: 'bottom', displayInfo: true
  }],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
      	Form_DP3_PNS.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		//if(ppns_update == false){Ext.getCmp('Btn_Ubah_DP3').handler.call(Ext.getCmp("Btn_Ubah_DP3").scope);}
  		Ext.getCmp('dp3_page').setActiveTab('Tab2_DP3_PNS');
  	}    
  }
});
// TABEL DP3 PNS  ------------------------------------------------- END

// FORM DP3 PNS  --------------------------------------------------------- START
var Form_DP3_PNS = new Ext.create('Ext.form.Panel', {
 	id: 'Form_DP3_PNS', url: BASE_URL + 'profil_pns/ext_insert_dp3',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: false}, buttonAlign:'left', autoScroll:true,
  items: [
    {name: 'IDP_DP3', xtype: 'hidden'}, {name: 'NIP', id: 'NIP_dp3', xtype: 'hidden'}, {name: 'kode_unor', id: 'kode_unor_dp3', xtype: 'hidden'},
    {xtype: 'fieldset', defaultType: 'textfield', defaults: {allowBlank: false}, fieldDefaults: {labelAlign: 'left', labelWidth: 100}, margins: '0 0 0 0', style: 'padding: 5px 5px 5px 15px; border-width: 0px;',
     items: [
	    {xtype: 'fieldcontainer', fieldLabel: 'Pangkat, Gol. Ruang', combineErrors: false,
	     defaults: {hideLabel: true, allowBlank: false}, defaultType: 'textfield', layout: 'hbox', msgTarget: 'side', 
	     items: [
	     		{name: 'kode_golru', xtype: 'hidden', id: 'kode_golru_dp3'},
	     		{fieldLabel: 'Pangkat', xtype: 'textfield', name: 'nama_pangkat', id: 'nama_pangkat_dp3', readOnly: true, height: 22, margin: '0 2 0 0', width: 175},
      		{fieldLabel: 'Golru', xtype: 'textfield', name: 'nama_golru', id: 'nama_golru_dp3', height: 22, margin: '0 2 0 0', readOnly: true, width: 50},
	     		{xtype: 'button', name: 'search_pangkat', id: 'search_pangkat_ProfilDP3', text: '...',
	     		 handler: function(){Load_Panel_Ref('win_popup_RefPgwPangkat', 'ref_pegawai_pangkat', 'Form_DP3_PNS', 1, Ext.getCmp('NIP_dp3').getValue());}
	       	}
	     ], width: 400
	    },
      {xtype: 'datefield', fieldLabel: 'Tanggal DP3', name: 'tgl_dp3', format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', width: 230},
  	 	{xtype: 'fieldset', width: 300, title: 'N i l a i', margins: '0 5 0 5', style: 'padding: 5px; text-align: left;',
  	 	 items: [
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'Kesetiaan', name: 'kesetiaan', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Prestasi', name: 'prestasi', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Tgg. Jawab', name: 'tanggung_jwb', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}}
     	   ]
    	 	},
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'Ketaatan', name: 'ketaatan', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Kejujuran', name: 'kejujuran', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Kerjasama', name: 'kerjasama', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}}
     	   ]
    	 	},
    	 	{xtype: 'fieldcontainer', layout: 'hbox', combineErrors: false,
     	   defaultType: 'textfield', fieldDefaults: {labelAlign: 'top', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/}, defaults :{margins: '0 10 0 10'},
     	   items: [
      	 		{fieldLabel: 'Prakarsa', name: 'prakarsa', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Kepemimpinan', name: 'kepemimpinan', flex:1, listeners: {'change': {fn: function (){Hitung_DP3();},scope:this}}},
      	 		{fieldLabel: 'Jumlah', name: 'jumlah', flex:1}
     	   ]
    	 	}
  	 	 ]
  	 	},
      {fieldLabel: 'Nilai DP3', name: 'nilai_dp3', id: 'nilai_dp3', maskRe: /[\d\,\;]/, regex: /^[0-9]|\;*$/, width: 200},
    	{xtype: 'fieldcontainer', fieldLabel: 'Penilai', combineErrors: false,
    	 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 370, 
    	 items: [
      		{xtype: 'textfield', name: 'penilai_dp3', id: 'penilai_dp3', margin: '0 2 0 0', flex:2},
      		{xtype: 'button', name: 'search_penilai', id: 'search_penilai_DP3', text: '...',
      			handler: function(){Load_Panel_Ref('win_popup_RefPenilai', 'ref_penilai', 'Form_DP3_PNS', 1);}
          }
       ]
    	}
     ]
    }
  ],
  buttons: [
  	{text: 'Tambah', id: 'Tambah_DP3', iconCls: 'icon-add', disabled: ppns_insert, handler: function() {Profil_PNS_Tambah_DP3();}},
  	{text: 'Ubah', id: 'Ubah_DP3', iconCls: 'icon-edit', disabled: ppns_update, handler: function() {Profil_PNS_Ubah_DP3();}},
  	{text: 'Simpan', id: 'Simpan_DP3', iconCls: 'icon-save', disabled: true, handler: function() {Profil_PNS_Simpan_DP3();}},
  	{text: 'Batal', id: 'Batal_DP3', iconCls: 'icon-undo', disabled: true, handler: function() {Profil_PNS_Batal_DP3();}}
  ]
});
// FORM DP3 PNS  --------------------------------------------------------- END

// FUNCTIONS DP3 PNS  ---------------------------------------------------- START
function Profil_PNS_Tambah_DP3(){
	Ext.getCmp('dp3_page').setActiveTab('Tab2_DP3_PNS');
	Form_DP3_PNS.getForm().reset();
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_DP3_PNS.getForm().setValues({NIP:vNIP});
	Active_Form_DP3_PNS();
}

function Profil_PNS_Ubah_DP3(){
	var IDP_DP3 = Form_DP3_PNS.getForm().findField('IDP_DP3').getValue();
	if(IDP_DP3){
		P_DP3_last_record = Form_DP3_PNS.getForm().getValues();
		Ext.getCmp('dp3_page').setActiveTab('Tab2_DP3_PNS');
		Active_Form_DP3_PNS();	
	}
}

function Profil_PNS_Simpan_DP3(){
	Ext.getCmp('Form_DP3_PNS').on({
  	beforeaction: function() {Ext.getCmp('Form_DP3_PNS').body.mask();}
  });

  Form_DP3_PNS.getForm().submit({            			
  	success: function(form, action){
  		obj = Ext.decode(action.response.responseText);
  		if(IsNumeric(obj.info.reason)){
  			var IDP_DP3 = obj.info.reason;
  			Form_DP3_PNS.getForm().setValues({IDP_DP3:IDP_DP3});
  			Ext.MessageBox.show({title:'Informasi !', msg: 'Sukses menambah data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}else{
  			Ext.MessageBox.show({title:'Informasi !', msg: obj.info.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
  		}
  		Ext.getCmp('Form_DP3_PNS').body.unmask(); Data_Profil_PNS_DP3.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
			Deactive_Form_DP3_PNS();
  		All_Button_Enabled(); Ext.getCmp('dp3_menu').setDisabled(true);
  	},
    failure: function(form, action){
    	Ext.getCmp('Form_DP3_PNS').body.unmask();
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

function Profil_PNS_Hapus_DP3(){
  var sm = grid_Profil_PNS_DP3.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDP_DP3') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_dp3', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS_DP3.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function Profil_PNS_Batal_DP3(){
	var IDP_DP3 = Form_DP3_PNS.getForm().findField('IDP_DP3').getValue();
	if(!IDP_DP3){
		Form_DP3_PNS.getForm().reset();
	}else{
		Form_DP3_PNS.getForm().setValues(P_DP3_last_record);
	}
	Deactive_Form_DP3_PNS();
}

function setValue_Form_DP3_PNS(){
	var vNIP = Form_Biodata_PNS.getForm().findField('NIP').getValue();
	Form_DP3_PNS.getForm().setValues({NIP:vNIP});
	Data_Profil_PNS_DP3.changeParams({params :{id_open: '1', NIP: Form_Biodata_PNS.getForm().findField('NIP').getValue()}});
}

function Active_Form_DP3_PNS(){
	Ext.getCmp('Tambah_DP3').setDisabled(true);
	Ext.getCmp('Ubah_DP3').setDisabled(true);
	Ext.getCmp('Simpan_DP3').setDisabled(false);
	Ext.getCmp('Batal_DP3').setDisabled(false);
	
	Ext.getCmp('search_pangkat_ProfilDP3').setDisabled(false);	
	Form_DP3_PNS.getForm().findField('tgl_dp3').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('kesetiaan').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('prestasi').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('tanggung_jwb').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('ketaatan').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('kejujuran').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('kerjasama').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('prakarsa').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('kepemimpinan').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('jumlah').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('nilai_dp3').setReadOnly(false);
	Form_DP3_PNS.getForm().findField('penilai_dp3').setReadOnly(false);
	Ext.getCmp('search_penilai_DP3').setDisabled(false);
}

function Deactive_Form_DP3_PNS(){
	Ext.getCmp('Tambah_DP3').setDisabled(false);
	Ext.getCmp('Ubah_DP3').setDisabled(false);
	Ext.getCmp('Simpan_DP3').setDisabled(true);
	Ext.getCmp('Batal_DP3').setDisabled(true);
	
	Ext.getCmp('search_pangkat_ProfilDP3').setDisabled(true);	
	Form_DP3_PNS.getForm().findField('tgl_dp3').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('kesetiaan').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('prestasi').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('tanggung_jwb').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('ketaatan').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('kejujuran').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('kerjasama').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('prakarsa').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('kepemimpinan').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('jumlah').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('nilai_dp3').setReadOnly(true);
	Form_DP3_PNS.getForm().findField('penilai_dp3').setReadOnly(true);
	Ext.getCmp('search_penilai_DP3').setDisabled(true);	
}

function Hitung_DP3(){
	var kesetiaan = parseInt(Form_DP3_PNS.getForm().findField('kesetiaan').getValue());
	var prestasi = parseInt(Form_DP3_PNS.getForm().findField('prestasi').getValue());
	var tanggung_jwb = parseInt(Form_DP3_PNS.getForm().findField('tanggung_jwb').getValue());
	var ketaatan = parseInt(Form_DP3_PNS.getForm().findField('ketaatan').getValue());
	var kejujuran = parseInt(Form_DP3_PNS.getForm().findField('kejujuran').getValue());
	var kerjasama = parseInt(Form_DP3_PNS.getForm().findField('kerjasama').getValue());
	var prakarsa = parseInt(Form_DP3_PNS.getForm().findField('prakarsa').getValue());
	var kepemimpinan = parseInt(Form_DP3_PNS.getForm().findField('kepemimpinan').getValue());
	
	if(isNaN(kesetiaan)){kesetiaan=0;}
	if(isNaN(prestasi)){prestasi=0;}
	if(isNaN(tanggung_jwb)){tanggung_jwb=0;}
	if(isNaN(ketaatan)){ketaatan=0;}
	if(isNaN(kejujuran)){kejujuran=0;}
	if(isNaN(kerjasama)){kerjasama=0;}
	if(isNaN(prakarsa)){prakarsa=0;}
	if(isNaN(kepemimpinan)){kepemimpinan=0;}
	
	var jumlah = kesetiaan + prestasi + tanggung_jwb + ketaatan + kejujuran + kerjasama + prakarsa + kepemimpinan;
	var nilai_dp3 = jumlah / 8;
	
	Form_DP3_PNS.getForm().findField('jumlah').setValue(jumlah);
	Form_DP3_PNS.getForm().findField('nilai_dp3').setValue(nilai_dp3);
}
// FUNCTIONS DP3 PNS  ---------------------------------------------------- END

// PANEL DP3 PNS  -------------------------------------------------------- START
var Tab1_DP3_PNS = {
	id: 'Tab1_DP3_PNS', title: 'Riwayat DP3', border: false, collapsible: false,
	layout: 'fit', items: [grid_Profil_PNS_DP3]
};

var Tab2_DP3_PNS = {
	id: 'Tab2_DP3_PNS', title: 'Detail', border: false, collapsible: false,
	layout: 'fit', items: [Form_DP3_PNS]
};

var new_panel_PPNS = new Ext.createWidget('tabpanel', {
	id: 'dp3_page', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [Tab1_DP3_PNS, Tab2_DP3_PNS],
  listeners: {
  	'tabchange': function(tabPanel, tab){
  		if(tab.title == 'Riwayat DP3'){
  			Data_Profil_PNS_DP3.load();
  			Deactive_Form_DP3_PNS();
  			Form_DP3_PNS.getForm().reset();
  		}
  	}
  }
});
// PANEL DP3 PNS  -------------------------------------------------------- END

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>