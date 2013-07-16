<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// TABEL KABUPATEN/KOTA  --------------------------------------------------------- START

var Params_MKabKota = null;

Ext.define('MKabKota', {extend: 'Ext.data.Model',
	fields: ['ID_KK', 'kode_prov', 'nama_prov', 'kode_kabkota', 'nama_kabkota', 'status_data']
});

var Reader_MKabKota = new Ext.create('Ext.data.JsonReader', {
	id: 'Reader_MKabKota', root: 'results', totalProperty: 'total', idProperty: 'ID_KK'  	
});
	
var Proxy_MKabKota = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'master_data/ext_get_all_kabkota', actionMethods: {read:'POST'},  extraParams :{id_open: 1},      
  reader: Reader_MKabKota,
  afterRequest: function(request, success) {
   	Params_MKabKota = request.operation.params;
  }
});

var Data_MKabKota = new Ext.create('Ext.data.Store', {
	id: 'Data_MKabKota', model: 'MKabKota', pageSize: 20,	noCache: false, autoLoad: true,
  proxy: Proxy_MKabKota
});

var Search_MKabKota = new Ext.create('Ext.ux.form.SearchField', {
  id: 'Search_MKabKota', store: Data_MKabKota, width: 180    
});

var Tb_MKabKota = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: kabkota_insert, handler: Master_Data_Tambah_KabKota
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_MKabKota', disabled: kabkota_update, iconCls: 'icon-edit', handler: Master_Data_Ubah_KabKota
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: kabkota_delete, handler: Master_Data_Hapus_KabKota
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: Master_Data_Print_KabKota
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	Grid_MKabKota.filters.clearFilters();
    }
  }, Search_MKabKota
  ]
});
	
var Filters_MKabKota = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_MKabKota,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_kabkota'},
    	{type: 'string', dataIndex: 'nama_kabkota'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_KabKota = new Ext.create('Ext.selection.CheckboxModel');
	
var Grid_MKabKota = new Ext.create('Ext.grid.Panel', {
	id:'Grid_MKabKota', store: Data_MKabKota, title: 'DAFTAR NAMA KABUPATEN/KOTA', 
  frame: true, border: true, loadMask: true,     
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_KabKota, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "Kode", dataIndex: 'kode_kabkota', width: 50}, 
  	{header: "Provinsi", dataIndex: 'nama_prov', width: 200},
  	{header: "Nama Kabupaten/Kota", dataIndex: 'nama_kabkota', width: 300},
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
  features: [Filters_MKabKota], tbar: Tb_MKabKota,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_MKabKota, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(kabkota_update == false){Ext.getCmp('Btn_Ubah_MKabKota').handler.call(Ext.getCmp("Btn_Ubah_MKabKota").scope);}
  	}
  }
});

// TABEL MASTER KABUPATEN/KOTA  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_kabkota(){
  var sm = Grid_MKabKota.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('ID_KK') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER KABUPATEN/KOTA ----------------------------------------- START
function ShowForm_KabKota(mode,value_form) {		
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
						
	var Form_KabKota = new Ext.create('Ext.form.Panel', {
  	id: 'Form_KabKota', url: BASE_URL + 'master_data/ext_insert_kabkota',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 150},
    defaultType: 'textfield', defaults: {allowBlank: false},
    items: [
    	{name: 'ID_KK', xtype: 'hidden'},
    	{fieldLabel: 'Kode', name: 'kode_kabkota', id: 'kode_kabkota', allowBlank: true, width: 200},

			{fieldLabel: 'Provinsi', xtype: 'combobox', name: 'kode_prov', id: 'kode_prov', hiddenName: 'kode_prov',
		   store: new Ext.data.Store({
		   	fields: ['kode_prov','nama_prov'], idProperty: 'ID_Prov',
		   	proxy: new Ext.data.AjaxProxy({
		   		url: BASE_URL + 'combo_ref/combo_prov', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}
		   	}), autoLoad: true
		   }),
		   valueField: 'kode_prov', displayField: 'nama_prov', emptyText: 'Pilih Provinsi',
		   typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Provinsi',
		   listeners: {
		   	'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
		   }, width: 350
		  },

    	{fieldLabel: 'Nama Kabupaten/Kota', name: 'nama_kabkota', id: 'nama_kabkota', anchor: '100%'},
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_kabkota', checked: true, anchor: '70%',
    	 listeners: {
				'change': {fn: function (check, newValue) {
						if(newValue == true){
        			Ext.getCmp('status_data_kabkota').setBoxLabel('Aktif');
        		}else{
        			Ext.getCmp('status_data_kabkota').setBoxLabel('Non Aktif');
        		}
        }, scope: this}
    	 }
    	}    	
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_KabKota', id: 'Tambah_M_KabKota', iconCls: 'icon-add',
       handler: function() {Form_KabKota.getForm().reset(); Ext.getCmp('Tambah_M_KabKota').setDisabled(true); Ext.getCmp('Ubah_M_KabKota').setDisabled(true); Ext.getCmp('Simpan_M_KabKota').setDisabled(false); Ext.getCmp('Batal_M_KabKota').setDisabled(false); Ext.getCmp('sbWin_KabKota').setStatus({text:'Ready',iconCls:'x-status-valid'}); Ext.getCmp('kode_kabkota').focus(false, 200);}
    	},
  		{text: 'Ubah', id: 'Ubah_M_KabKota', iconCls: 'icon-edit', 
  		 handler: function() {
  			var ID_KK = Form_KabKota.getForm().findField('ID_KK').getValue();
  			if(ID_KK){
  				Ext.getCmp('Tambah_M_KabKota').setDisabled(true); Ext.getCmp('Ubah_M_KabKota').setDisabled(true); Ext.getCmp('Simpan_M_KabKota').setDisabled(false); Ext.getCmp('Batal_M_KabKota').setDisabled(false); Ext.getCmp('nama_kabkota').focus(false, 200);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_KabKota', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_KabKota').on({
  				beforeaction: function() {Ext.getCmp('sbWin_KabKota').showBusy();}
  			});
  			Form_KabKota.getForm().submit({            			
  				success: function(form, action){
  					Data_MKabKota.load();
  					Ext.getCmp('Tambah_M_KabKota').setDisabled(false);
  					Ext.getCmp('Ubah_M_KabKota').setDisabled(false);
  					Ext.getCmp('Simpan_M_KabKota').setDisabled(true);
  					Ext.getCmp('Batal_M_KabKota').setDisabled(true);
  					Ext.getCmp('nama_kabkota').focus(false, 200);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var ID_KK = obj.info.reason;
  						var kode_kabkota = obj.info.kode;
  						Form_KabKota.getForm().setValues({ID_KK:ID_KK, kode_kabkota:kode_kabkota});
  						Ext.getCmp('sbWin_KabKota').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_KabKota').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_KabKota').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_KabKota').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_KabKota').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_KabKota').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_KabKota', iconCls: 'icon-undo',
       handler: function() {
				var ID_KK = Form_KabKota.getForm().findField('ID_KK').getValue();
				if(!ID_KK){Form_KabKota.getForm().reset();}
       	Ext.getCmp('Tambah_M_KabKota').setDisabled(false); Ext.getCmp('Ubah_M_KabKota').setDisabled(false); Ext.getCmp('Simpan_M_KabKota').setDisabled(true); Ext.getCmp('Batal_M_KabKota').setDisabled(true); Ext.getCmp('nama_kabkota').focus(false, 200); Ext.getCmp('sbWin_KabKota').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_KabKota', iconCls: 'icon-cross', handler: function() {win_popup_KabKota.close();}}
    ]
	});

	var win_popup_KabKota = new Ext.create('Ext.Window', {
		id: 'win_popup_KabKota', title: 'Form Nama Kabupaten/Kota', iconCls: 'icon-templates',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 250, bodyStyle: 'padding: 5px;',		
		items: [Form_KabKota],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_KabKota', iconCls: 'x-status-valid'})
	}).show();
		
	if(mode == 'Ubah'){			
		Form_KabKota.getForm().setValues(value_form);
		Ext.getCmp('nama_kabkota').focus(false, 200);
	}else{
		Ext.getCmp('kode_kabkota').focus(false, 200);
	}

	Ext.getCmp('Tambah_M_KabKota').setDisabled(true);
	Ext.getCmp('Ubah_M_KabKota').setDisabled(true);	
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER KABUPATEN/KOTA ------------------------------------------- END

// FUNCTION TAMBAH KABUPATEN/KOTA ----------------------------------------- START
function Master_Data_Tambah_KabKota() {		
	ShowForm_KabKota('Tambah','');
}
// FUNCTION TAMBAH KABUPATEN/KOTA ----------------------------------------- END

// FUNCTION UBAH KABUPATEN/KOTA ------------------------------------------- START
function Master_Data_Ubah_KabKota() {	
	var sm = Grid_MKabKota.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = { 
    	ID_KK: sel[0].get('ID_KK'), 
    	kode_prov: sel[0].get('kode_prov'),
    	kode_kabkota: sel[0].get('kode_kabkota'),
    	nama_kabkota: sel[0].get('nama_kabkota'),
    	status_data: sel[0].get('status_data')
    };
    ShowForm_KabKota('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH KABUPATEN/KOTA ------------------------------------------ END

// FUNCTION HAPUS KABUPATEN/KOTA ----------------------------------------- START
function Master_Data_Hapus_KabKota() {	
  var sm = Grid_MKabKota.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?', buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_KK') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_kabkota', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_MKabKota.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS KABUPATEN/KOTA ----------------------------------------- END

function Master_Data_Print_KabKota(){Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_kabkota', 'Cetak Daftar Nama Kabupaten/Kota');}
	
var new_tabpanel_MD = {
	id: 'master_kabkota', title: 'Kabupaten', iconCls: 'icon-templates', closable: true, border: false,
	items: [Grid_MKabKota]
}

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>