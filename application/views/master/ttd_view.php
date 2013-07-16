<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// TABEL TTD  --------------------------------------------------------- START

var Params_M_TTD = null;

Ext.define('MTTD', {extend: 'Ext.data.Model',
  	fields: ['IDT_TTD', 'NIP', 'nama_lengkap', 'kode_unor', 'nama_unor', 'kode_unker', 'nama_unker', 'kode_jab', 'nama_jab', 'kode_golru', 'nama_pangkat', 'nama_golru', 'no_urut', 'status_data']
});

var Reader_TTD = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_TTD', root: 'results', totalProperty: 'total', idProperty: 'IDT_TTD'  	
});
	
var Proxy_TTD = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'master_data/ext_get_all_ttd', actionMethods: {read:'POST'},  extraParams :{id_open: '1'},      
    reader: Reader_TTD
});

var Data_TTD = new Ext.create('Ext.data.Store', {
		id: 'Data_TTD', model: 'MTTD', pageSize: 20, noCache: false, autoLoad: true,
    proxy: Proxy_TTD
});

var search_TTD = new Ext.create('Ext.ux.form.SearchField', {
    id: 'search_TTD', store: Data_TTD, width: 180, emptyText: 'Pencarian NIP / Nama ...'
});
	
var tb_TTD = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: ttd_insert, handler: Master_Data_Tambah_TTD
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_M_TTD', disabled: ttd_update, iconCls: 'icon-edit', handler: Master_Data_Ubah_TTD
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: ttd_delete, handler: Master_Data_Hapus_TTD
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: print_TTD
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	grid_TTD.filters.clearFilters();
    }
  }, search_TTD
  ]
});
	
var filters_TTD = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_TTD,
    filters: [
    	{type: 'numeric', dataIndex: 'NIP'},
    	{type: 'string', dataIndex: 'nama_lengkap'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_TTD = new Ext.create('Ext.selection.CheckboxModel');
	
var grid_TTD = new Ext.create('Ext.grid.Panel', {
	id:'grid_TTD', store: Data_TTD, title: 'DAFTAR NAMA PEJABAT PENANDATANGAN', 
  frame: true, border: true, loadMask: true,     
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_TTD, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "NIP", dataIndex: 'NIP', width: 140}, 
  	{header: "Nama Pejabat", dataIndex: 'nama_lengkap', width: 300},
  	{header: "Jabatan", dataIndex: 'nama_jab', width: 300},
  	{header: "Status", dataIndex: 'status_data', 
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {
  	 	if(record.data.status_data == 1){
  	 		return "Aktif";
  	 	}else{
  	 		return "Non Aktif";
  	 	}  	 	
  	 }, width: 70
  	}
  ],
  features: [filters_TTD],
  tbar: tb_TTD,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_TTD, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(ttd_update == false){Ext.getCmp('Btn_Ubah_M_TTD').handler.call(Ext.getCmp("Btn_Ubah_M_TTD").scope);}
  	}
  }
});

// TABEL MASTER TTD  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_ttd(){
  var sm = grid_TTD.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('IDT_TTD') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER TTD ----------------------------------------- START
function showForm_TTD(mode,value_form) {		
	var Form_TTD = new Ext.create('Ext.form.Panel', {
  	id: 'Form_TTD', url: BASE_URL + 'master_data/ext_insert_ttd',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 150},
    defaultType: 'textfield', defaults: {allowBlank: false},
    items: [
    	{name: 'IDT_TTD', xtype: 'hidden'},
    	{xtype: 'fieldcontainer', fieldLabel: 'N I P', combineErrors: false,
    	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', 
    	 items: [
      		{xtype: 'textfield', name: 'NIP', id: 'NIP_TTD', maxLength: 21, maskRe: /[\d\ \.\;]/, regex: /^[0-9]|\;*$/, margin: '0 2 0 0', flex:2,
	      	 listeners: {
	      			specialkey: function(f,e){
	      				if (e.getKey() == e.ENTER) {
	      					TTD_Cari_Pgw(Ext.getCmp('NIP_TTD').getValue(), Form_TTD);
	      				}
	      			}
	      	 }
      		},
      		{xtype: 'button', name: 'search_pegawai', text: '...', 
      			handler: function(){
      				Show_Popup_RefPegawai_TTD(Form_TTD);
      			}
          }
       ], anchor: '100%'
    	},
    	{fieldLabel: 'Nama Lengkap', name: 'nama_lengkap', id: 'nama_lengkap_ttd', allowBlank: false, anchor: '100%'},
    	{name: 'kode_golru', xtype: 'hidden'},
    	{name: 'kode_jab', xtype: 'hidden'},
    	{fieldLabel: 'Jabatan', name: 'nama_jab', id: 'nama_jab_ttd', allowBlank: false, anchor: '100%'},
    	{name: 'kode_unor', xtype: 'hidden'},
	    {xtype: 'textfield', fieldLabel: 'Unit Organisasi', name: 'nama_unor', id: 'nama_unor_ttd', allowBlank: true, readOnly: true, height: 22, anchor: '100%'},
	    {xtype: 'textareafield', fieldLabel: 'Unit Kerja', name: 'nama_unker', id: 'nama_unker_ttd', allowBlank: true, readOnly: true, height: 40, anchor: '100%'},
    	{fieldLabel: 'No. Urut', name: 'no_urut', id: 'no_urut_ttd', allowBlank: false, width: 200},
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_fung_tertentu', checked: true, anchor: '70%',
    	 listeners: {
        	'change': {
        		fn: function (check, newValue) {
        			if(newValue == true){
        				Ext.getCmp('status_data_fung_tertentu').setBoxLabel('Aktif');
        			}else{
        				Ext.getCmp('status_data_fung_tertentu').setBoxLabel('Non Aktif');
        			}
        		}, scope: this
        	}
    	 }
    	}
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_TTD', id: 'Tambah_M_TTD', iconCls: 'icon-add',
       handler: function() {Form_TTD.getForm().reset(); Ext.getCmp('Tambah_M_TTD').setDisabled(true); Ext.getCmp('Ubah_M_TTD').setDisabled(true); Ext.getCmp('Simpan_M_TTD').setDisabled(false); Ext.getCmp('Batal_M_TTD').setDisabled(false); Ext.getCmp('nama_lengkap').focus(false, 200); Ext.getCmp('sbWin_TTD').setStatus({text:'Ready',iconCls:'x-status-valid'});}
    	},
  		{text: 'Ubah', id: 'Ubah_M_TTD', iconCls: 'icon-edit', 
  		 handler: function() {
  			var IDT_TTD = Form_TTD.getForm().findField('IDT_TTD').getValue();
  			if(IDT_TTD){
  				Ext.getCmp('Tambah_M_TTD').setDisabled(true); Ext.getCmp('Ubah_M_TTD').setDisabled(true); Ext.getCmp('Simpan_M_TTD').setDisabled(false); Ext.getCmp('Batal_M_TTD').setDisabled(false);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_TTD', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_TTD').on({
  				beforeaction: function() {Ext.getCmp('sbWin_TTD').showBusy();}
  			});
  			Form_TTD.getForm().submit({            			
  				success: function(form, action){
  					Ext.getCmp('Tambah_M_TTD').setDisabled(false);
  					Ext.getCmp('Ubah_M_TTD').setDisabled(false);
  					Ext.getCmp('Simpan_M_TTD').setDisabled(true);
  					Ext.getCmp('Batal_M_TTD').setDisabled(true);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var IDT_TTD = obj.info.reason;
  						Form_TTD.getForm().setValues({IDT_TTD:IDT_TTD});
  						Ext.getCmp('sbWin_TTD').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_TTD').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  					Data_TTD.load();
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_TTD').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_TTD').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_TTD').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_TTD').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_TTD', iconCls: 'icon-undo',
       handler: function() {
				var IDT_TTD = Form_TTD.getForm().findField('IDT_TTD').getValue();
				if(!IDT_TTD){Form_TTD.getForm().reset();}
       	Ext.getCmp('Tambah_M_TTD').setDisabled(false); Ext.getCmp('Ubah_M_TTD').setDisabled(false); Ext.getCmp('Simpan_M_TTD').setDisabled(true); Ext.getCmp('Batal_M_TTD').setDisabled(true); Ext.getCmp('nama_lengkap').focus(false, 200); Ext.getCmp('sbWin_TTD').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_TTD', iconCls: 'icon-cross', handler: function() {win_popup_TTD.close();}}
    ]
	});
			
	var win_popup_TTD = new Ext.create('Ext.Window', {
		id: 'win_popup_TTD', title: 'Form Pejabat Penandatangan', iconCls: 'icon-templates',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 325, bodyStyle: 'padding: 5px;',		
		items: [Form_TTD],
		bbar: new Ext.ux.StatusBar({
    	text: 'Ready', id: 'sbWin_TTD', iconCls: 'x-status-valid'
    })
	}).show();
		
	if(mode == 'Ubah'){			
		Form_TTD.getForm().setValues(value_form);
	}		

	Ext.getCmp('Tambah_M_TTD').setDisabled(true);
	Ext.getCmp('Ubah_M_TTD').setDisabled(true);
	Ext.getCmp('nama_lengkap').focus(false, 200);
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER TTD ------------------------------------------- END
	
// FUNCTION TAMBAH TTD ----------------------------------------- START
function Master_Data_Tambah_TTD() {		
	showForm_TTD('Tambah','');
}
// FUNCTION TAMBAH TTD ----------------------------------------- END

// FUNCTION UBAH TTD ------------------------------------------- START
function Master_Data_Ubah_TTD() {	
	var sm = grid_TTD.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = { 
    	IDT_TTD: sel[0].get('IDT_TTD'), 
    	NIP: sel[0].get('NIP'),
    	nama_lengkap: sel[0].get('nama_lengkap'),
    	kode_golru: sel[0].get('kode_golru'),
    	nama_pangkat: sel[0].get('nama_pangkat'),
    	nama_golru: sel[0].get('nama_golru'),
    	kode_jab: sel[0].get('kode_jab'),
    	nama_jab: sel[0].get('nama_jab'),
    	kode_unor: sel[0].get('kode_unor'),
    	nama_unor: sel[0].get('nama_unor'),
    	nama_unker: sel[0].get('nama_unker'),
    	no_urut: sel[0].get('no_urut'),
    	status_data: sel[0].get('status_data')
    };
    showForm_TTD('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH TTD ------------------------------------------ END

// FUNCTION HAPUS TTD ----------------------------------------- START
function Master_Data_Hapus_TTD() {	
  var sm = grid_TTD.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('IDT_TTD') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_ttd', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_TTD.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS TTD ----------------------------------------- END

// FUNCTION CETAK TTD ----------------------------------------- START
function print_TTD(){
	Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_ttd', 'Cetak Daftar Pejabat Penandatangan');
}
// FUNCTION CETAK TTD ----------------------------------------- END

// POPUP REFERENSI PEGAWAI ---------------------------------------------------- START
function Show_Popup_RefPegawai_TTD(form_parent){
	Ext.define('MSearch_RefPegawai_TTD', {extend: 'Ext.data.Model',
    fields: ['ID_Pegawai', 'NIP', 'f_namalengkap', 'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_unor', 'kode_jab', 'nama_jab', 'nama_unor', 'nama_unker']
	});
	var Reader_Search_RefPegawai_TTD = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefPegawai_TTD', root: 'results', totalProperty: 'total', idProperty: 'ID_Pegawai'  	
	});
	var Proxy_Search_RefPegawai_TTD = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_pegawai', actionMethods: {read:'POST'}, extraParams :{id_open:1, sPgwPilih: 'Struktural, Fungsional Umum'}, reader: Reader_Search_RefPegawai_TTD
	});
	var Data_Search_RefPegawai_TTD = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefPegawai_TTD', model: 'MSearch_RefPegawai_TTD', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefPegawai_TTD
	});

	var Search_RefPegawai_TTD = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPegawai_TTD', store: Data_Search_RefPegawai_TTD, emptyText: 'Ketik di sini untuk pencarian NIP atau Nama', width: 550});
	var tbSearch_RefPegawai_TTD = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPegawai_TTD',
	items:[
		Search_RefPegawai_TTD, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_pegawai_TTD',
		 handler: function(){
		 		var sm = grid_Search_RefPegawai_TTD.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  				form_parent.getForm().setValues({
  					NIP: sel[0].get('NIP'), 
  					nama_lengkap: sel[0].get('f_namalengkap'), 
  					kode_golru: sel[0].get('kode_golru'), 
  					nama_pangkat: sel[0].get('nama_pangkat'), 
  					nama_golru: sel[0].get('nama_golru'), 
  					kode_jab: sel[0].get('kode_jab'), 
  					nama_jab: sel[0].get('nama_jab'), 
  					kode_unor: sel[0].get('kode_unor'), 
  					nama_unor: sel[0].get('nama_unor'), 
  					nama_unker: sel[0].get('nama_unker')
  				});
  				win_popup_RefPegawai_TTD.close();
  			}else{
  				Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
  			}
		 }
		}
  ]
	});
	
	var filters_Search_RefPegawai_TTD = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefPegawai_TTD,
    filters: [
    	{type: 'string', dataIndex: 'NIP'},
    	{type: 'string', dataIndex: 'f_namalengkap'},
    	{type: 'string', dataIndex: 'nama_jab'},
    	{type: 'string', dataIndex: 'nama_unor'},
    	{type: 'string', dataIndex: 'nama_unker'}
    ]
	});
	
	var cbGrid_Search_RefPegawai_TTD = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefPegawai_TTD = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefPegawai_TTD', store: Data_Search_RefPegawai_TTD, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPegawai_TTD, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "NIP", dataIndex: 'NIP', width: 135}, 
  		{header: "Nama Lengkap", dataIndex: 'f_namalengkap', width: 150},
  		{header: "Jabatan", dataIndex: 'nama_jab', width: 125},
  		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 150},
  		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 150}
  	], 
	  features: [filters_Search_RefPegawai_TTD],
  	bbar: tbSearch_RefPegawai_TTD,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPegawai_TTD, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_pegawai_TTD').handler.call(Ext.getCmp("PILIH_pegawai_TTD").scope);
  		}
  	}
	});

	var win_popup_RefPegawai_TTD = new Ext.create('widget.window', {
   	id: 'win_popup_RefPegawai_TTD', title: 'Referensi Pegawai', iconCls: 'icon-human',
   	modal:true, plain:true, closable: true, width: 650, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefPegawai_TTD]
	}).show();
}
// POPUP REFERENSI PEGAWAI ---------------------------------------------------- END

function TTD_Cari_Pgw(NIP_z, form_parent){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_pegawai',
    	method: 'POST', params: {id_open: 1, NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				NIP: obj.results.NIP,
    				nama_lengkap: obj.results.f_namalengkap,
    				kode_golru: obj.results.kode_golru,
    				kode_jab: obj.results.kode_jab,
    				nama_jab: obj.results.nama_jab,
    				kode_unor: obj.results.kode_unor,
    				nama_unor: obj.results.nama_unor,
    				nama_unker: obj.results.nama_unker
    			};
    			form_parent.getForm().setValues(value_form);
    			Ext.getCmp('email_user').focus(false, 200);
    		}else{
  				var value_form = {
    				NIP: '', fullname: '', nama_unor:'', nama_unker: ''
    			};
    			form_parent.getForm().setValues(value_form);    			
    			Ext.Msg.show({title:'Peringatan !', msg:'NIP tidak terdaftar !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR,
    				fn: function(btn) {
    					Ext.getCmp('NIP_User').reset(); Ext.getCmp('NIP_User').focus(false, 200);
    				}
    			});
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	scope : this
		});
	}
}
	
// TAB MASTER TTD  ------------------------------------------------- START
var new_tabpanel_MD = {
	id: 'master_ttd', title: 'TTD', iconCls: 'icon-templates', closable: true, border: false,
	items: [grid_TTD]
}
// TAB MASTER TTD  ------------------------------------------------- END

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>