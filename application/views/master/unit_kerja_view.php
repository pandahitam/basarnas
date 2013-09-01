<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
var Params_M_UK = null;

// TABEL UNIT KERJA  --------------------------------------------------------- START
Ext.namespace('Reader_UK', 'Proxy_UK', 'Data_UK', 'grouping_UK', 'search_UK', 'Grid_UK');

Ext.define('MUnitKerja', {extend: 'Ext.data.Model',
  	fields: ['ID_UK', 'kode_unker', 'nama_unker', 'alamat_unker', 'telp_unker', 'email_unker', 'kode_kec', 'nama_kec', 'kode_uki', 'nama_uki', 'kode_jns_unker', 'jns_unker', 'status_data']
});

var Reader_UK = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_UK', root: 'results', totalProperty: 'total', idProperty: 'ID_UK'  	
});
	
var Proxy_UK = new Ext.create('Ext.data.AjaxProxy', {
	id: 'Proxy_UK', url: BASE_URL + 'master_data/ext_get_all_unit_kerja', actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
  reader: Reader_UK,
  afterRequest: function(request, success) {
   	Params_M_UK = request.operation.params;
  }
});

var Data_UK = new Ext.create('Ext.data.Store', {
	id: 'Data_UK', model: 'MUnitKerja', pageSize: 20,	noCache: false, autoLoad: true,
  proxy: Proxy_UK, groupField: 'nama_uki'
});

var grouping_UK = Ext.create('Ext.grid.feature.Grouping',{
	id: 'grouping_UK', groupHeaderTpl: 'GroupBy : {name} ({rows.length} Item{[values.rows.length > 1 ? "s on this page" : " on this page"]})'
});

var search_UK = new Ext.create('Ext.ux.form.SearchField', {
	id: 'search_UK', store: Data_UK, width: 180    
});

var tb_UK = new Ext.create('Ext.toolbar.Toolbar', { id: 'tb_UK',
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: false, handler: Master_Data_Tambah_UnitKerja
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_M_UK', iconCls: 'icon-edit', disabled: false, handler: Master_Data_Ubah_UnitKerja
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: false, handler: Master_Data_Hapus_UnitKerja
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: print_UnitKerja
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-filter_clear', 
    handler: function () {
    	Grid_UK.filters.clearFilters();
    }
  }, search_UK
  ]
});
	
var filters_UK = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, local: false, store: Data_UK,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_unker'},
    	{type: 'string', dataIndex: 'nama_unker'},
    	{type: 'string', dataIndex: 'alamat_unker'},
    	{type: 'string', dataIndex: 'telp_unker'},
    	{type: 'string', dataIndex: 'email_unker'},
    	{type: 'string', dataIndex: 'nama_kec'},
    	{type: 'string', dataIndex: 'nama_uki'},
    	{type: 'list', dataIndex: 'jns_unker', options: ['Sekretariat', 'Badan', 'Dinas', 'Kantor', 'UPT', 'Sekolah'], phpMode: true},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_UK = new Ext.create('Ext.selection.CheckboxModel');
	
var Grid_UK = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_UK', store: Data_UK, title: 'DAFTAR UNIT KERJA', 
  frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_UK, columnLines: true,
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "Kode", dataIndex: 'kode_unker', width: 80, groupable: false}, 
  	{header: "Nama Unit Kerja", dataIndex: 'nama_unker', width: 300, groupable: false}, 
  	{header: "Alamat", dataIndex: 'alamat_unker', width: 200, groupable: false}, 
  	{header: "Telp", dataIndex: 'telp_unker', width: 120, hidden: true, groupable: false}, 
  	{header: "E-Mail", dataIndex: 'email_unker', width: 150, hidden: true, groupable: false}, 
  	{header: "Kecamatan", dataIndex: 'nama_kec', width: 150, hidden: true},
  	{header: "Induk", dataIndex: 'nama_uki', width: 300}, 
  	{header: "Jenis", dataIndex: 'jns_unker', width: 100},
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
  features: [filters_UK, grouping_UK],
  tbar: tb_UK,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_UK, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(uk_update == false){
			Ext.getCmp('Btn_Ubah_M_UK').handler.call(Ext.getCmp("Btn_Ubah_M_UK").scope);
		}
  	}    
  }  
});

// TABEL MASTER UNIT KERJA  ------------------------------------------------- END

// FUNCTION FORM MASTER UNIT KERJA ----------------------------------------- START

var val_kode_jns_unker, val_kode_kec = 1;

function showForm_UnitKerja(mode,value_form) {
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");

	var Data_Combo_Induk = new Ext.create('Ext.data.Store', {
  	id: 'Data_Combo_Induk', fields: ['kode_uki','nama_uki'], idProperty: 'ID_UKI',
    proxy: new Ext.data.AjaxProxy({url: BASE_URL + 'combo_ref/combo_induk_unit_kerja', method: 'POST', extraParams :{id_open: '1'}}), 
    autoLoad: true
  });
  
	var form_UK = new Ext.create('Ext.form.Panel', {
  	id: 'form_UK', url: BASE_URL + 'master_data/ext_insert_unit_kerja',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 110},
    defaultType: 'textfield', defaults: {allowBlank: true},
    items: [
    	{name: 'ID_UK', xtype: 'hidden'},
      { xtype: 'combobox', fieldLabel: 'Jenis', name: 'kode_jns_unker', hiddenName: 'kode_jns_unker',
        store: new Ext.data.Store({
        		fields: ['kode_jns_unker','jns_unker'], idProperty: 'ID_UKJ',
        		proxy: new Ext.data.AjaxProxy({url: BASE_URL + 'combo_ref/combo_jns_unit_kerja', method: 'POST', extraParams :{id_open: '1'}}), 
        		autoLoad: true
        }),
        valueField: 'kode_jns_unker', displayField: 'jns_unker', emptyText: 'Pilih Jenis',
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',         
        listeners: {
        	'focus': {fn: function (comboField) {comboField.expand();}, scope: this},
        	'change': {
        		fn: function (check, newValue) {
        			if (newValue) {val_kode_jns_unker = newValue};
        			if (newValue == 0 || newValue == 1 || newValue == 2 || newValue == 3 || newValue == 4){
        				form_UK.getForm().setValues({kode_uki:0});
        				form_UK.getForm().findField('kode_uki').setDisabled(true);
        			}else{
        				form_UK.getForm().findField('kode_uki').setDisabled(false);
        			}
        		}, scope: this
        	}
        }
      },
    	{fieldLabel: 'Nama Unit Kerja', name: 'nama_unker', id: 'nama_unker', allowBlank: false, anchor: '100%'},
      { xtype: 'combo', fieldLabel: 'Induk', name: 'kode_uki', hiddenName: 'kode_uki', allowBlank: true,
        store: Data_Combo_Induk,
        valueField: 'kode_uki', displayField: 'nama_uki', anchor: '100%', 
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kecamatan',         
        listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}}
    	},
    	{xtype: 'textareafield', fieldLabel: 'Alamat', name: 'alamat_unker', height: 40, anchor: '100%'},
    	{fieldLabel: 'Telepon', name: 'telp_unker', maskRe: /[\d\+]/, regexText: 'Hanya tanda plus (+) dan Angka', anchor: '70%'},
    	{fieldLabel: 'E-Mail', name: 'email_unker', vtype:'email', value: 'somone@example.com', anchor: '70%'}, 
    	{
      	xtype: 'combo', fieldLabel: 'Kecamatan', name: 'kode_kec', hiddenName: 'kode_kec',
        store: new Ext.data.Store({
        		fields: ['kode_kec','nama_kec'], idProperty: 'ID_Kec',
        		proxy: new Ext.data.AjaxProxy({
    				url: BASE_URL + 'combo_ref/combo_kec', 
      			method: 'POST', extraParams :{id_open: '1'}
    				}), autoLoad: true
        }),
        valueField: 'kode_kec', displayField: 'nama_kec', emptyText: 'Pilih Kecamatan',
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kecamatan',         
        listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}}
    	},
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_uk', checked: true, anchor: '70%',
    	 listeners: {
        	'change': {
        		fn: function (check, newValue) {
        			if(newValue == true){
        				Ext.getCmp('status_data_uk').setBoxLabel('Aktif');
        			}else{
        				Ext.getCmp('status_data_uk').setBoxLabel('Non Aktif');
        			}
        		}, scope: this
        	}
    	 }
    	}
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_UK', id: 'Tambah_M_UK', iconCls: 'icon-add',
       		handler: function() {
	   			form_UK.getForm().reset(); 
				Ext.getCmp('Tambah_M_UK').setDisabled(true); 
				Ext.getCmp('Ubah_M_UK').setDisabled(true); 
				Ext.getCmp('Simpan_M_UK').setDisabled(false); 
				Ext.getCmp('Batal_M_UK').setDisabled(false); 
				form_UK.getForm().setValues({kode_jns_unker:val_kode_jns_unker}); 
				Ext.getCmp('nama_unker').focus(false, 200); 
				Ext.getCmp('sbWin_UK').setStatus({text:'Ready',iconCls:'x-status-valid'});
			}
    	},
  		{text: 'Ubah', id: 'Ubah_M_UK', iconCls: 'icon-edit', 
  		 	handler: function() {
	  			var ID_UK = form_UK.getForm().findField('ID_UK').getValue();
	  			if(ID_UK){
	  				Ext.getCmp('Tambah_M_UK').setDisabled(true); 
					Ext.getCmp('Ubah_M_UK').setDisabled(true); 
					Ext.getCmp('Simpan_M_UK').setDisabled(false); 
					Ext.getCmp('Batal_M_UK').setDisabled(false);
	  			}
  		 	}
  		},
    	{text: 'Simpan', id: 'Simpan_M_UK', iconCls: 'icon-save', 
			handler: function() {    	
				Ext.getCmp('form_UK').on({
  				beforeaction: function() {
					Ext.getCmp('sbWin_UK').showBusy();
					}
  				});
				
	  			form_UK.getForm().submit({            			
	  				success: function(form, action){
	  					Data_UK.load(); Data_Combo_Induk.load();
	  					Ext.getCmp('Tambah_M_UK').setDisabled(false);
	  					Ext.getCmp('Ubah_M_UK').setDisabled(false);
	  					Ext.getCmp('Simpan_M_UK').setDisabled(true);
	  					Ext.getCmp('Batal_M_UK').setDisabled(true);
	  					Ext.getCmp('nama_unker').focus(false, 200);
	  					obj = Ext.decode(action.response.responseText);
	  					if(IsNumeric(obj.info.reason)){
	  						var ID_UK = obj.info.reason;
	  						form_UK.getForm().setValues({ID_UK:ID_UK});
	  						Ext.getCmp('sbWin_UK').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
	  					}else{
	  						Ext.getCmp('sbWin_UK').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
	  					}
	  				},
	    			failure: function(form, action){
	    				Ext.getCmp('form_UK').body.unmask();
	      			if (action.failureType == 'server') {
	      				obj = Ext.decode(action.response.responseText);
	      				Ext.getCmp('sbWin_UK').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
	      			}else{
	      				if (typeof(action.response) == 'undefined') {
	      					Ext.getCmp('sbWin_UK').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
	        			}else{
	      					Ext.getCmp('sbWin_UK').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
	        			}
	      			}
	    			}
	  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_UK', iconCls: 'icon-undo',
       handler: function() {
				var ID_UK = form_UK.getForm().findField('ID_UK').getValue();
				if(!ID_UK){form_UK.getForm().reset();}
       	Ext.getCmp('Tambah_M_UK').setDisabled(false); Ext.getCmp('Ubah_M_UK').setDisabled(false); Ext.getCmp('Simpan_M_UK').setDisabled(true); Ext.getCmp('Batal_M_UK').setDisabled(true); form_UK.getForm().setValues({kode_jns_unker:val_kode_jns_unker}); Ext.getCmp('nama_unker').focus(false, 200); Ext.getCmp('sbWin_UK').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_UK', iconCls: 'icon-cross', handler: function() {popup_UK.close();}}
    ]
	});

	var popup_UK = new Ext.create('Ext.Window', {
		id: 'popup_UK', title: 'Form Unit Kerja', iconCls: 'icon-course', modal : true, constrainHeader : true, closable: true,
		width: 450, height: 400, bodyStyle: 'padding: 5px;', items: [form_UK],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_UK', iconCls: 'x-status-valid'})
	}).show();

	if(mode == 'Ubah'){
		form_UK.getForm().setValues(value_form);
	}
	
	Ext.getCmp('Tambah_M_UK').setDisabled(true);
	Ext.getCmp('Ubah_M_UK').setDisabled(true);	
	Ext.getCmp('nama_unker').focus(false, 200);
	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM MASTER UNIT KERJA ------------------------------------------- END

// FUNCTION TAMBAH UNIT KERJA ----------------------------------------- START
function Master_Data_Tambah_UnitKerja() {		
	showForm_UnitKerja('Tambah','');
}
// FUNCTION TAMBAH UNIT KERJA ----------------------------------------- END

// FUNCTION UBAH UNIT KERJA ------------------------------------------- START
function Master_Data_Ubah_UnitKerja() {	
	var sm = Grid_UK.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	var value_form = {
    	ID_UK: sel[0].get('ID_UK'),
    	nama_unker: sel[0].get('nama_unker'),
    	alamat_unker: sel[0].get('alamat_unker'),
    	telp_unker: sel[0].get('telp_unker'),
    	email_unker: sel[0].get('email_unker'),
    	kode_kec: sel[0].get('kode_kec'),
    	kode_uki: sel[0].get('kode_uki'),
    	kode_jns_unker: sel[0].get('kode_jns_unker'),
    	status_data: sel[0].get('status_data')
    };
    showForm_UnitKerja('Ubah',value_form);   
  }		
}
// FUNCTION UBAH UNIT KERJA ------------------------------------------ END

// FUNCTION SIMPAN UNIT KERJA ----------------------------------------- START
function Master_Data_Simpan_UnitKerja(){
}
// FUNCTION SIMPAN UNIT KERJA ----------------------------------------- END

// FUNCTION HAPUS UNIT KERJA ----------------------------------------- START
function Master_Data_Hapus_UnitKerja() {	
  var sm = Grid_UK.getSelectionModel(), sel = sm.getSelection(), data = '';
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_UK') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_unit_kerja', method: 'POST', scripts: true,
         		params: { postdata: data },
          	success: function(response){Data_UK.load();},
    				failure: function(response){Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS UNIT KERJA ----------------------------------------- END

// FUNCTION CETAK UNIT KERJA ----------------------------------------- START
function print_UnitKerja(){
	Load_Popup('win_print_pd_no_ttd', BASE_URL + 'master_data/print_dialog_unker', 'Cetak Daftar Unit Kerja');
}
// FUNCTION CETAK UNIT KERJA ----------------------------------------- END

// TAB MASTER UNIT KERJA  ------------------------------------------------- START
var new_tabpanel_MD = {
	id: 'master_unit_kerja', title: 'Unit Kerja ', iconCls: 'icon-course', closable: true, border: false,
	items: [Grid_UK]
}
// TAB MASTER UNIT KERJA  ------------------------------------------------- END

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>