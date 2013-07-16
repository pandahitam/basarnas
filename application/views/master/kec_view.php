<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// TABEL KECAMATAN  --------------------------------------------------------- START

var Params_MKec = null;

Ext.define('MKec', {extend: 'Ext.data.Model',
	fields: ['ID_Kec', 'kode_kec', 'kode_prov', 'nama_prov', 'kode_kabkota', 'nama_kabkota', 'nama_kec', 'status_data']
});

var Reader_MKec = new Ext.create('Ext.data.JsonReader', {
	id: 'Reader_MKec', root: 'results', totalProperty: 'total', idProperty: 'ID_Kec'  	
});
	
var Proxy_MKec = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'master_data/ext_get_all_kec', actionMethods: {read:'POST'},  extraParams :{id_open: 1},      
  reader: Reader_MKec,
  afterRequest: function(request, success) {
   	Params_MKec = request.operation.params;
  }
});

var Data_MKec = new Ext.create('Ext.data.Store', {
	id: 'Data_MKec', model: 'MKec', pageSize: 20,	noCache: false, autoLoad: true,
  proxy: Proxy_MKec
});

var Search_MKec = new Ext.create('Ext.ux.form.SearchField', {
  id: 'Search_MKec', store: Data_MKec, width: 180    
});

var Tb_MKec = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: kabkota_insert, handler: Master_Data_Tambah_Kec
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_MKec', disabled: kabkota_update, iconCls: 'icon-edit', handler: Master_Data_Ubah_Kec
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: kabkota_delete, handler: Master_Data_Hapus_Kec
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: Master_Data_Print_Kec
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	Grid_MKec.filters.clearFilters();
    }
  }, Search_MKec
  ]
});
	
var Filters_MKec = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_MKec,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_kec'},
    	{type: 'string', dataIndex: 'nama_prov'},
    	{type: 'string', dataIndex: 'nama_kabkota'},
    	{type: 'string', dataIndex: 'nama_kec'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_Kec = new Ext.create('Ext.selection.CheckboxModel');
	
var Grid_MKec = new Ext.create('Ext.grid.Panel', {
	id:'Grid_MKec', store: Data_MKec, title: 'DAFTAR NAMA KECAMATAN', 
  frame: true, border: true, loadMask: true,     
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Kec, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "Kode", dataIndex: 'kode_kec', width: 50}, 
  	{header: "Provinsi", dataIndex: 'nama_prov', width: 200},
  	{header: "Kabupaten/Kota", dataIndex: 'nama_kabkota', width: 200},
  	{header: "Nama Kecamatan", dataIndex: 'nama_kec', width: 200},
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
  features: [Filters_MKec], tbar: Tb_MKec,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_MKec, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(kabkota_update == false){Ext.getCmp('Btn_Ubah_MKec').handler.call(Ext.getCmp("Btn_Ubah_MKec").scope);}
  	}
  }
});

// TABEL MASTER KECAMATAN  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_kec(){
  var sm = Grid_MKec.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('ID_Kec') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER KECAMATAN ----------------------------------------- START
var vcbm_kode_prov = 0;
var Data_CB_MKabKota = new Ext.create('Ext.data.Store', {
	fields: ['kode_kabkota','nama_kabkota'], idProperty: 'ID_KK',
	proxy: new Ext.data.AjaxProxy({
		url: BASE_URL + 'combo_ref/combo_kabkota', actionMethods: {read:'POST'}, extraParams :{id_open: 1, kode_prov: vcbm_kode_prov}
	}), autoLoad: true
});

function ShowForm_Kec(mode,value_form) {		
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
						
	var Form_MKec = new Ext.create('Ext.form.Panel', {
  	id: 'Form_MKec', url: BASE_URL + 'master_data/ext_insert_kec',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 150},
    defaultType: 'textfield', defaults: {allowBlank: false},
    items: [
    	{name: 'ID_Kec', xtype: 'hidden'},
    	{fieldLabel: 'Kode', name: 'kode_kec', id: 'kode_kec', allowBlank: true, width: 200},
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
		    'change': {
		    	fn: function (comboField, newValue) {
		      	vcbm_kode_prov = newValue;
		        Form_MKec.getForm().setValues({kode_kabkota:0});
		        Data_CB_MKabKota.changeParams({params: {id_open:1, kode_prov: vcbm_kode_prov}});		        				
		      }, scope: this
		    },
		   }, width: 350
		  },

		  {fieldLabel: 'Kabupaten/Kota', xtype: 'combobox', name: 'kode_kabkota', id: 'kode_kabkota', hiddenName: 'kode_kabkota',
		   store: Data_CB_MKabKota,
		   valueField: 'kode_kabkota', displayField: 'nama_kabkota', emptyText: 'Pilih Kabupaten',
		   typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kabupaten',
		   listeners: {
		   		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
		   }, width: 300
		  },

    	{fieldLabel: 'Nama Kecamatan', name: 'nama_kec', id: 'nama_kec', anchor: '100%'},
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
    	{text: 'Tambah', name: 'Tambah_M_Kec', id: 'Tambah_M_Kec', iconCls: 'icon-add',
       handler: function() {Form_MKec.getForm().reset(); Ext.getCmp('Tambah_M_Kec').setDisabled(true); Ext.getCmp('Ubah_M_Kec').setDisabled(true); Ext.getCmp('Simpan_M_Kec').setDisabled(false); Ext.getCmp('Batal_M_Kec').setDisabled(false); Ext.getCmp('sbWin_Kec').setStatus({text:'Ready',iconCls:'x-status-valid'}); Ext.getCmp('kode_kabkota').focus(false, 200);}
    	},
  		{text: 'Ubah', id: 'Ubah_M_Kec', iconCls: 'icon-edit', 
  		 handler: function() {
  			var ID_Kec = Form_MKec.getForm().findField('ID_Kec').getValue();
  			if(ID_Kec){
  				Ext.getCmp('Tambah_M_Kec').setDisabled(true); Ext.getCmp('Ubah_M_Kec').setDisabled(true); Ext.getCmp('Simpan_M_Kec').setDisabled(false); Ext.getCmp('Batal_M_Kec').setDisabled(false); Ext.getCmp('nama_kec').focus(false, 200);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_Kec', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_MKec').on({
  				beforeaction: function() {Ext.getCmp('sbWin_Kec').showBusy();}
  			});
  			Form_MKec.getForm().submit({            			
  				success: function(form, action){
  					Data_MKec.load();
  					Ext.getCmp('Tambah_M_Kec').setDisabled(false);
  					Ext.getCmp('Ubah_M_Kec').setDisabled(false);
  					Ext.getCmp('Simpan_M_Kec').setDisabled(true);
  					Ext.getCmp('Batal_M_Kec').setDisabled(true);
  					Ext.getCmp('nama_kec').focus(false, 200);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var ID_Kec = obj.info.reason;
  						var kode_kec = obj.info.kode;
  						Form_MKec.getForm().setValues({ID_Kec:ID_Kec, kode_kec:kode_kec});
  						Ext.getCmp('sbWin_Kec').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_Kec').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_MKec').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_Kec').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_Kec').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_Kec').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_Kec', iconCls: 'icon-undo',
       handler: function() {
				var ID_Kec = Form_MKec.getForm().findField('ID_Kec').getValue();
				if(!ID_Kec){Form_MKec.getForm().reset();}
       	Ext.getCmp('Tambah_M_Kec').setDisabled(false); Ext.getCmp('Ubah_M_Kec').setDisabled(false); Ext.getCmp('Simpan_M_Kec').setDisabled(true); Ext.getCmp('Batal_M_Kec').setDisabled(true); Ext.getCmp('nama_kec').focus(false, 200); Ext.getCmp('sbWin_Kec').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_Kec', iconCls: 'icon-cross', handler: function() {win_popup_Kec.close();}}
    ]
	});

	var win_popup_Kec = new Ext.create('Ext.Window', {
		id: 'win_popup_Kec', title: 'Form Nama Kabupaten/Kota', iconCls: 'icon-templates',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 250, bodyStyle: 'padding: 5px;',		
		items: [Form_MKec],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_Kec', iconCls: 'x-status-valid'})
	}).show();
		
	if(mode == 'Ubah'){			
		Form_MKec.getForm().setValues(value_form);
		Ext.getCmp('nama_kec').focus(false, 200);
	}else{
		Ext.getCmp('kode_kec').focus(false, 200);
	}

	Ext.getCmp('Tambah_M_Kec').setDisabled(true);
	Ext.getCmp('Ubah_M_Kec').setDisabled(true);	
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER KECAMATAN ------------------------------------------- END

// FUNCTION TAMBAH KECAMATAN ----------------------------------------- START
function Master_Data_Tambah_Kec() {		
	ShowForm_Kec('Tambah','');
}
// FUNCTION TAMBAH KECAMATAN ----------------------------------------- END

// FUNCTION UBAH KECAMATAN ------------------------------------------- START
function Master_Data_Ubah_Kec() {	
	var sm = Grid_MKec.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = { 
    	ID_Kec: sel[0].get('ID_Kec'), 
    	kode_prov: sel[0].get('kode_prov'),
    	kode_kabkota: sel[0].get('kode_kabkota'),
    	kode_kec: sel[0].get('kode_kec'),
    	nama_kec: sel[0].get('nama_kec'),
    	status_data: sel[0].get('status_data')
    };
    ShowForm_Kec('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH KECAMATAN ------------------------------------------ END

// FUNCTION HAPUS KECAMATAN ----------------------------------------- START
function Master_Data_Hapus_Kec() {	
  var sm = Grid_MKec.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?', buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_Kec') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_kec', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_MKec.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS KECAMATAN ----------------------------------------- END

function Master_Data_Print_Kec(){Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_kec', 'Cetak Daftar Nama Kecamatan');}
	
var new_tabpanel_MD = {
	id: 'master_kec', title: 'Kecamatan', iconCls: 'icon-templates', closable: true, border: false,
	items: [Grid_MKec]
}

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>