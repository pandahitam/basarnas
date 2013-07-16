<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// TABEL PROVINSI  --------------------------------------------------------- START

var Params_MProv = null;

Ext.define('MProv', {extend: 'Ext.data.Model',
  	fields: ['ID_Prov', 'kode_prov', 'nama_prov', 'status_data']
});

var Reader_MProv = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_MProv', root: 'results', totalProperty: 'total', idProperty: 'ID_Prov'  	
});
	
var Proxy_MProv = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'master_data/ext_get_all_prov', actionMethods: {read:'POST'},  extraParams :{id_open: 1},      
  reader: Reader_MProv,
  afterRequest: function(request, success) {
   	Params_MProv = request.operation.params;
  }
});

var Data_MProv = new Ext.create('Ext.data.Store', {
	id: 'Data_MProv', model: 'MProv', pageSize: 20,	noCache: false, autoLoad: true,
  proxy: Proxy_MProv
});

var Search_MProv = new Ext.create('Ext.ux.form.SearchField', {
  id: 'Search_MProv', store: Data_MProv, width: 180    
});

var Tb_MProv = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: prov_insert, handler: Master_Data_Tambah_Prov
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_MProv', disabled: prov_update, iconCls: 'icon-edit', handler: Master_Data_Ubah_Prov
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: prov_delete, handler: Master_Data_Hapus_Prov
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: Master_Data_Print_Prov
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	Grid_MProv.filters.clearFilters();
    }
  }, Search_MProv
  ]
});
	
var Filters_MProv = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_MProv,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_prov'},
    	{type: 'string', dataIndex: 'nama_prov'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_Prov = new Ext.create('Ext.selection.CheckboxModel');
	
var Grid_MProv = new Ext.create('Ext.grid.Panel', {
	id:'Grid_MProv', store: Data_MProv, title: 'DAFTAR NAMA PROVINSI', 
  frame: true, border: true, loadMask: true,     
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Prov, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "Kode", dataIndex: 'kode_prov', width: 50}, 
  	{header: "Nama Provinsi", dataIndex: 'nama_prov', width: 500},
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
  features: [Filters_MProv], tbar: Tb_MProv,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_MProv, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(prov_update == false){Ext.getCmp('Btn_Ubah_MProv').handler.call(Ext.getCmp("Btn_Ubah_MProv").scope);}
  	}
  }
});

// TABEL MASTER PROVINSI  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_prov(){
  var sm = Grid_MProv.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('ID_Prov') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER PROVINSI ----------------------------------------- START
function ShowForm_Prov(mode,value_form) {		
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
						
	var Form_Prov = new Ext.create('Ext.form.Panel', {
  	id: 'Form_Prov', url: BASE_URL + 'master_data/ext_insert_prov',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 120},
    defaultType: 'textfield', defaults: {allowBlank: false},
    items: [
    	{name: 'ID_Prov', xtype: 'hidden'},
    	{fieldLabel: 'Kode', name: 'kode_prov', id: 'kode_prov', allowBlank: true, width: 175},
    	{fieldLabel: 'Nama Provinsi', name: 'nama_prov', id: 'nama_prov', anchor: '100%'},
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_prov', checked: true, anchor: '70%',
    	 listeners: {
				'change': {fn: function (check, newValue) {
						if(newValue == true){
        			Ext.getCmp('status_data_prov').setBoxLabel('Aktif');
        		}else{
        			Ext.getCmp('status_data_prov').setBoxLabel('Non Aktif');
        		}
        }, scope: this}
    	 }
    	}    	
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_Prov', id: 'Tambah_M_Prov', iconCls: 'icon-add',
       handler: function() {Form_Prov.getForm().reset(); Ext.getCmp('Tambah_M_Prov').setDisabled(true); Ext.getCmp('Ubah_M_Prov').setDisabled(true); Ext.getCmp('Simpan_M_Prov').setDisabled(false); Ext.getCmp('Batal_M_Prov').setDisabled(false); Ext.getCmp('sbWin_Prov').setStatus({text:'Ready',iconCls:'x-status-valid'}); Ext.getCmp('kode_prov').focus(false, 200);}
    	},
  		{text: 'Ubah', id: 'Ubah_M_Prov', iconCls: 'icon-edit', 
  		 handler: function() {
  			var ID_Prov = Form_Prov.getForm().findField('ID_Prov').getValue();
  			if(ID_Prov){
  				Ext.getCmp('Tambah_M_Prov').setDisabled(true); Ext.getCmp('Ubah_M_Prov').setDisabled(true); Ext.getCmp('Simpan_M_Prov').setDisabled(false); Ext.getCmp('Batal_M_Prov').setDisabled(false); Ext.getCmp('nama_prov').focus(false, 200);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_Prov', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_Prov').on({
  				beforeaction: function() {Ext.getCmp('sbWin_Prov').showBusy();}
  			});
  			Form_Prov.getForm().submit({            			
  				success: function(form, action){
  					Data_MProv.load();
  					Ext.getCmp('Tambah_M_Prov').setDisabled(false);
  					Ext.getCmp('Ubah_M_Prov').setDisabled(false);
  					Ext.getCmp('Simpan_M_Prov').setDisabled(true);
  					Ext.getCmp('Batal_M_Prov').setDisabled(true);
  					Ext.getCmp('nama_prov').focus(false, 200);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var ID_Prov = obj.info.reason;
  						var kode_prov = obj.info.kode;
  						Form_Prov.getForm().setValues({ID_Prov:ID_Prov, kode_prov:kode_prov});
  						Ext.getCmp('sbWin_Prov').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_Prov').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_Prov').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_Prov').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_Prov').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_Prov').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_Prov', iconCls: 'icon-undo',
       handler: function() {
				var ID_Prov = Form_Prov.getForm().findField('ID_Prov').getValue();
				if(!ID_Prov){Form_Prov.getForm().reset();}
       	Ext.getCmp('Tambah_M_Prov').setDisabled(false); Ext.getCmp('Ubah_M_Prov').setDisabled(false); Ext.getCmp('Simpan_M_Prov').setDisabled(true); Ext.getCmp('Batal_M_Prov').setDisabled(true); Ext.getCmp('nama_prov').focus(false, 200); Ext.getCmp('sbWin_Prov').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_Prov', iconCls: 'icon-cross', handler: function() {win_popup_Prov.close();}}
    ]
	});

	var win_popup_Prov = new Ext.create('Ext.Window', {
		id: 'win_popup_Prov', title: 'Form Nama Provinsi', iconCls: 'icon-templates',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 200, bodyStyle: 'padding: 5px;',		
		items: [Form_Prov],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_Prov', iconCls: 'x-status-valid'})
	}).show();
		
	if(mode == 'Ubah'){			
		Form_Prov.getForm().setValues(value_form);
		Ext.getCmp('nama_prov').focus(false, 200);
	}else{
		Ext.getCmp('kode_prov').focus(false, 200);
	}

	Ext.getCmp('Tambah_M_Prov').setDisabled(true);
	Ext.getCmp('Ubah_M_Prov').setDisabled(true);	
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER PROVINSI ------------------------------------------- END

// FUNCTION TAMBAH PROVINSI ----------------------------------------- START
function Master_Data_Tambah_Prov() {		
	ShowForm_Prov('Tambah','');
}
// FUNCTION TAMBAH PROVINSI ----------------------------------------- END

// FUNCTION UBAH PROVINSI ------------------------------------------- START
function Master_Data_Ubah_Prov() {	
	var sm = Grid_MProv.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = { 
    	ID_Prov: sel[0].get('ID_Prov'), 
    	kode_prov: sel[0].get('kode_prov'),
    	nama_prov: sel[0].get('nama_prov'),
    	status_data: sel[0].get('status_data')
    };
    ShowForm_Prov('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH PROVINSI ------------------------------------------ END

// FUNCTION HAPUS PROVINSI ----------------------------------------- START
function Master_Data_Hapus_Prov() {	
  var sm = Grid_MProv.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?', buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_Prov') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_prov', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_MProv.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS PROVINSI ----------------------------------------- END

function Master_Data_Print_Prov(){Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_prov', 'Cetak Daftar Nama Provinsi');}
	
var new_tabpanel_MD = {
	id: 'master_prov', title: 'Provinsi', iconCls: 'icon-templates', closable: true, border: false,
	items: [Grid_MProv]
}

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>