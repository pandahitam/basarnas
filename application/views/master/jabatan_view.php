<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// TABEL JABATAN  --------------------------------------------------------- START

var Params_M_Jab = null;

Ext.define('MJabatan', {extend: 'Ext.data.Model',
  	fields: ['ID_Jab', 'kode_jab', 'nama_jab', 'nama_jab_singkatan', 'kode_jenis_jab', 'jenis_jab', 'kode_klp_jab', 'klp_jab', 'kode_eselon', 'nama_eselon', 'status_data']
});

var Reader_JAB = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_JAB', root: 'results', totalProperty: 'total', idProperty: 'ID_Jab'  	
});
	
var Proxy_JAB = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'master_data/ext_get_all_jabatan', actionMethods: {read:'POST'},  extraParams :{id_open: '1'},      
  reader: Reader_JAB,
  afterRequest: function(request, success) {
   	Params_M_Jab = request.operation.params;
  }
});

var Data_Jabatan = new Ext.create('Ext.data.Store', {
		id: 'Data_Jabatan', model: 'MJabatan', 
		pageSize: 20,	noCache: false, autoLoad: true,
    proxy: Proxy_JAB, groupField: 'jenis_jab'
});

var grouping_Jabatan = Ext.create('Ext.grid.feature.Grouping',{
		groupHeaderTpl: 'GroupBy : {name} ({rows.length} Item{[values.rows.length > 1 ? "s on this page" : " on this page"]})'
});

var searchJabatan = new Ext.create('Ext.ux.form.SearchField', {
    store: Data_Jabatan, id: 'fieldJabatanSearch', width: 180    
});
	
var tbJabatan = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: jab_insert, handler: Master_Data_Tambah_Jabatan
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_M_Jab', iconCls: 'icon-edit', disabled: jab_update, handler: Master_Data_Ubah_Jabatan
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: jab_delete, handler: Master_Data_Hapus_Jabatan
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: print_Jabatan
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	grid_Jabatan.filters.clearFilters();
    }
  }, searchJabatan
  ]
});
	
var filters_Jabatan = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_Jabatan,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_jab'},
    	{type: 'string', dataIndex: 'nama_jab'},
    	{type: 'string', dataIndex: 'nama_jab_singkatan'},
    	{type: 'string', dataIndex: 'jenis_jab'},
    	{type: 'string', dataIndex: 'klp_jab'},
    	{type: 'string', dataIndex: 'nama_eselon'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_Jabatan = new Ext.create('Ext.selection.CheckboxModel');
	
var grid_Jabatan = new Ext.create('Ext.grid.Panel', {
	id:'grid_Jabatan', store: Data_Jabatan, title: 'DAFTAR NAMA JABATAN', 
  frame: true, border: true, loadMask: true,     
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Jabatan, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "Kode", dataIndex: 'kode_jab', groupable: false, width: 80}, 
  	{header: "Nama Jabatan", dataIndex: 'nama_jab', groupable: false, width: 350}, 
  	{header: "Singkatan", dataIndex: 'nama_jab_singkatan', groupable: false, width: 120}, 
  	{header: "Jenis", dataIndex: 'jenis_jab', width: 120}, 
  	{header: "Kelompok", dataIndex: 'klp_jab', width: 120}, 
  	{header: "Eselon", dataIndex: 'nama_eselon', width: 80},
  	{header: "Status", dataIndex: 'status_data', groupable: false, 
  	 renderer: function(value, metaData, record, rowIndex, colIndex, store) {
  	 	if(record.data.status_data == 1){
  	 		return "Aktif";
  	 	}else{
  	 		return "Non Aktif";
  	 	}  	 	
  	 }, width: 70
  	}
  ],
  features: [filters_Jabatan, grouping_Jabatan],
  tbar: tbJabatan,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Jabatan, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(jab_update == false){Ext.getCmp('Btn_Ubah_M_Jab').handler.call(Ext.getCmp("Btn_Ubah_M_Jab").scope);}
  	}    
  }    
});

// TABEL MASTER JABATAN  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_jabatan(){
  var sm = grid_Jabatan.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('ID_Jab') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER JABATAN ----------------------------------------- START
function showForm_Jabatan(mode,value_form) {		
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
						
	var Form_Jabatan = new Ext.create('Ext.form.Panel', {
  	id: 'Form_Jabatan', url: BASE_URL + 'master_data/ext_insert_jabatan',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 110},
    defaultType: 'textfield',
    defaults: {allowBlank: false},
    items: [
    	{name: 'ID_Jab', xtype: 'hidden'},
			{ xtype: 'combobox', fieldLabel: 'Kelompok', name: 'kode_klp_jab', hiddenName: 'kode_klp_jab',
        store: new Ext.data.Store({
        		fields: ['kode_klp_jab','klp_jab'], idProperty: 'ID_KlpJab',
        		proxy: new Ext.data.AjaxProxy({url: BASE_URL + 'combo_ref/combo_klp_jabatan', method: 'POST', extraParams :{id_open: '1'}}), 
        		autoLoad: true
        }),
        valueField: 'kode_klp_jab', displayField: 'klp_jab', emptyText: 'Pilih Kelompok',
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kelompok',
        listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}}
      },
    	{fieldLabel: 'Nama Jabatan', name: 'nama_jab', id: 'nama_jab', anchor: '100%'},
    	{fieldLabel: 'Singkatan Jabatan', name: 'nama_jab_singkatan', allowBlank: true, width: 300},
      { xtype: 'combobox', fieldLabel: 'Eselon', name: 'kode_eselon', hiddenName: 'kode_eselon',
        store: new Ext.data.Store({
        		fields: ['kode_eselon','nama_eselon'], idProperty: 'ID_Eselon',
        		proxy: new Ext.data.AjaxProxy({url: BASE_URL + 'combo_ref/combo_eselon', method: 'POST', extraParams :{id_open: '1'}}), 
        		autoLoad: true
        }),
        valueField: 'kode_eselon', displayField: 'nama_eselon', emptyText: 'Pilih Eselon',
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Eselon',
        listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}}
      },
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_jab', checked: true, anchor: '70%',
    	 listeners: {
        	'change': {
        		fn: function (check, newValue) {
        			if(newValue == true){
        				Ext.getCmp('status_data_jab').setBoxLabel('Aktif');
        			}else{
        				Ext.getCmp('status_data_jab').setBoxLabel('Non Aktif');
        			}
        		}, scope: this
        	}
    	 }
    	}
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_Jab', id: 'Tambah_M_Jab', iconCls: 'icon-add',
       handler: function() {Form_Jabatan.getForm().reset(); Ext.getCmp('Tambah_M_Jab').setDisabled(true); Ext.getCmp('Ubah_M_Jab').setDisabled(true); Ext.getCmp('Simpan_M_Jab').setDisabled(false); Ext.getCmp('Batal_M_Jab').setDisabled(false); Ext.getCmp('nama_jab').focus(false, 200); Ext.getCmp('sbWin_Jabatan').setStatus({text:'Ready',iconCls:'x-status-valid'});}
    	},
  		{text: 'Ubah', id: 'Ubah_M_Jab', iconCls: 'icon-edit', 
  		 handler: function() {
  			var ID_Jab = Form_Jabatan.getForm().findField('ID_Jab').getValue();
  			if(ID_Jab){
  				Ext.getCmp('Tambah_M_Jab').setDisabled(true); Ext.getCmp('Ubah_M_Jab').setDisabled(true); Ext.getCmp('Simpan_M_Jab').setDisabled(false); Ext.getCmp('Batal_M_Jab').setDisabled(false);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_Jab', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_Jabatan').on({
  				beforeaction: function() {Ext.getCmp('sbWin_Jabatan').showBusy();}
  			});
  			Form_Jabatan.getForm().submit({            			
  				success: function(form, action){
  					Data_Jabatan.load();
  					Ext.getCmp('Tambah_M_Jab').setDisabled(false);
  					Ext.getCmp('Ubah_M_Jab').setDisabled(false);
  					Ext.getCmp('Simpan_M_Jab').setDisabled(true);
  					Ext.getCmp('Batal_M_Jab').setDisabled(true);
  					Ext.getCmp('nama_jab').focus(false, 200);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var ID_Jab = obj.info.reason;
  						Form_Jabatan.getForm().setValues({ID_Jab:ID_Jab});
  						Ext.getCmp('sbWin_Jabatan').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_Jabatan').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_Jabatan').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_Jabatan').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_Jabatan').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_Jabatan').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_Jab', iconCls: 'icon-undo',
       handler: function() {
				var ID_Jab = Form_Jabatan.getForm().findField('ID_Jab').getValue();
				if(!ID_Jab){Form_Jabatan.getForm().reset();}
       	Ext.getCmp('Tambah_M_Jab').setDisabled(false); Ext.getCmp('Ubah_M_Jab').setDisabled(false); Ext.getCmp('Simpan_M_Jab').setDisabled(true); Ext.getCmp('Batal_M_Jab').setDisabled(true); Ext.getCmp('nama_jab').focus(false, 200); Ext.getCmp('sbWin_Jabatan').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_Jab', iconCls: 'icon-cross', handler: function() {win_popup_Jabatan.close();}}
    ]
	});
			
	var win_popup_Jabatan = new Ext.create('Ext.Window', {
		id: 'win_popup_Jabatan', title: 'Form Nama Jabatan', iconCls: 'icon-plugin',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 250, bodyStyle: 'padding: 5px;',		
		items: [Form_Jabatan],
		bbar: new Ext.ux.StatusBar({
    	text: 'Ready', id: 'sbWin_Jabatan', iconCls: 'x-status-valid'
    })
	}).show();
		
	if(mode == 'Ubah'){			
		Form_Jabatan.getForm().setValues(value_form);
	}		

	Ext.getCmp('Tambah_M_Jab').setDisabled(true);
	Ext.getCmp('Ubah_M_Jab').setDisabled(true);
	Ext.getCmp('nama_jab').focus(false, 200);
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER JABATAN ------------------------------------------- END
	
// FUNCTION TAMBAH JABATAN ----------------------------------------- START
function Master_Data_Tambah_Jabatan() {		
	showForm_Jabatan('Tambah','');
}
// FUNCTION TAMBAH JABATAN ----------------------------------------- END

// FUNCTION UBAH JABATAN ------------------------------------------- START
function Master_Data_Ubah_Jabatan() {	
	var sm = grid_Jabatan.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = { 
    	ID_Jab: sel[0].get('ID_Jab'), 
    	kode_klp_jab: sel[0].get('kode_klp_jab'),
    	nama_jab: sel[0].get('nama_jab'),
    	nama_jab_singkatan: sel[0].get('nama_jab_singkatan'),
    	kode_eselon: sel[0].get('kode_eselon'),
    	status_data: sel[0].get('status_data')
    };
    showForm_Jabatan('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH JABATAN ------------------------------------------ END

// FUNCTION HAPUS JABATAN ----------------------------------------- START
function Master_Data_Hapus_Jabatan() {	
  var sm = grid_Jabatan.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_Jab') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_jabatan', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Jabatan.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS JABATAN ----------------------------------------- END

// FUNCTION CETAK JABATAN ----------------------------------------- START
function print_Jabatan(){
	Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_jab', 'Cetak Daftar Jabatan');
}
// FUNCTION CETAK JABATAN ----------------------------------------- END
	
// TAB MASTER JABATAN  ------------------------------------------------- START
var new_tabpanel_MD = {
	id: 'master_jabatan', title: 'Jabatan', iconCls: 'icon-spam', closable: true, border: false,
	items: [grid_Jabatan]
}
// TAB MASTER JABATAN  ------------------------------------------------- END

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>