<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Params_M_Unor = null;

// TABEL UNIT ORGANISASI  --------------------------------------------------------- START

Ext.define('MUnor', {extend: 'Ext.data.Model',
  	fields: ['ID_Unor','kode_unor','nama_unor','jabatan_unor','kode_unker','nama_unker','kode_jab','nama_jab','jenis_jab','klp_jab','kode_eselon','nama_eselon','status_data']
});
var Reader_Unor = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Unor', root: 'results', totalProperty: 'total', idProperty: 'ID_Unor'  	
});
var Proxy_Unor = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'master_data/ext_get_all_unit_organisasi', actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: Reader_Unor,
  	afterRequest: function(request, success) {
   		Params_M_Unor = request.operation.params;
  	}
});
var Data_Unor = new Ext.create('Ext.data.Store', {
		id: 'Data_Unor', model: 'MUnor', pageSize: 20,	noCache: false, autoLoad: true,
    proxy: Proxy_Unor, groupField: 'nama_unker'
});

var grouping_Unor = Ext.create('Ext.grid.feature.Grouping',{
		groupHeaderTpl: 'GroupBy : {name} ({rows.length} Item{[values.rows.length > 1 ? "s on this page" : " on this page"]})'
});
var searchUnor = new Ext.create('Ext.ux.form.SearchField', {
    id: 'searchUnor', store: Data_Unor, width: 180    
});
	
var tbUnor = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[{
  	text: 'Tambah', iconCls: 'icon-add', disabled: unor_insert, handler: Master_Data_Tambah_Unor
  },'-', {
  	text: 'Ubah', id: 'Btn_Ubah_M_Unor', iconCls: 'icon-edit', disabled: unor_update, handler: Master_Data_Ubah_Unor
  },'-', {
  	text: 'Hapus', iconCls: 'icon-delete', disabled: unor_delete, handler: Master_Data_Hapus_Unor
  },'-', {
  	text: 'Cetak', iconCls: 'icon-printer', handler: print_Unor
  },'->', {
  	text: 'Clear Filter', iconCls: 'icon-cross', 
    handler: function () {
    	grid_Unor.filters.clearFilters();
    }
  }, searchUnor
  ]
});
	
var filters_Unor = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: Data_Unor,
    filters: [
    	{type: 'numeric', dataIndex: 'kode_unor'},
    	{type: 'string', dataIndex: 'nama_unor'},
    	{type: 'string', dataIndex: 'nama_unker'},
    	{type: 'string', dataIndex: 'jabatan_unor'},
    	{type: 'string', dataIndex: 'nama_eselon'},
    	{type: 'list', dataIndex: 'status_data', options: ['Aktif', 'Non Aktif'], phpMode: true}
    ]
});

var cbGrid_Unor = new Ext.create('Ext.selection.CheckboxModel');
	
var grid_Unor = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Unor', store: Data_Unor, title: 'DAFTAR UNIT ORGANISASI', 
  frame: true, border: true, loadMask: true,
  style: 'margin:0 auto;', height: '100%', width: '100%',
  selModel: cbGrid_Unor, columnLines: true,
	columns: [
  	{header: "Kode", dataIndex: 'kode_unor', groupable: false, width: 80},
  	{header: "Nama Jabatan", dataIndex: 'jabatan_unor', groupable: false, width: 200},
  	{header: "Nama Unit Organisasi", dataIndex: 'nama_unor', groupable: false, width: 200},
  	{header: "Nama Unit Kerja", dataIndex: 'nama_unker', width: 200},
  	{header: "Eselon", dataIndex: 'nama_eselon', width: 50},
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
  features: [filters_Unor, grouping_Unor],
  tbar: tbUnor,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Unor, dock: 'bottom', displayInfo: true}],
  listeners: {
  	selectionchange: function(model, records) {
    	if (records[0]) {
    		//Deactive_Form_KP();
      	Form_Unor.getForm().loadRecord(records[0]);
      }
    },
  	itemdblclick: function(dataview, record, item, index, e) {
  		if(unor_update == false){Ext.getCmp('Btn_Ubah_M_Unor').handler.call(Ext.getCmp("Btn_Ubah_M_Unor").scope);}
  	}
  }    
});

// TABEL MASTER UNIT ORGANISASI  ------------------------------------------------- END

// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_Unor(){
  var sm = grid_Unor.getSelectionModel(), sel = sm.getSelection(), data = '';      		
  if(sel.length > 0){
    for (i = 0; i < sel.length; i++) {
     	data = data + sel[i].get('ID_Unor') + '-';
		}
  }
  return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END

// FUNCTION FORM MASTER UNIT ORGANISASI ----------------------------------------- START
//function showForm_Unor(mode,value_form) {
//	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
	
	var Form_Unor = new Ext.create('Ext.form.Panel', {
  	id: 'Form_Unor', url: BASE_URL + 'master_data/ext_insert_unit_organisasi',
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 135},
    defaultType: 'textfield', defaults: {allowBlank: false},
    items: [
    	{name: 'ID_Unor', xtype: 'hidden'},
      { xtype: 'combobox', fieldLabel: 'Nama Unit Kerja', name: 'kode_unker', hiddenName: 'kode_unker', id: 'kode_unker_unor', anchor: '100%',
        store: new Ext.data.Store({
        	fields: ['kode_unker','nama_unker'], idProperty: 'ID_UK',
        	proxy: new Ext.data.AjaxProxy({
    				url: BASE_URL + 'combo_ref/combo_unit_kerja', 
      			actionMethods: {read:'POST'}, extraParams :{id_open: 1}
    			}), autoLoad: true
        }),
        valueField: 'kode_unker', displayField: 'nama_unker', emptyText: 'Pilih Unit Kerja',
        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',         
        listeners: {
        	'focus': {fn: function (comboField) {comboField.expand();}, scope: this},
        	'change': {fn: function () {}, scope: this}
        }
      },
    	{xtype: 'fieldcontainer', fieldLabel: 'Nama Jabatan', combineErrors: false,
    	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', 
    	 items: [
      		{name: 'kode_jab', id: 'kode_jab_ref_unor', xtype: 'hidden'},
      		{xtype: 'textfield', name: 'nama_jab', id: 'nama_jab_ref_unor', readOnly: true, margin: '0 2 0 0', flex:2,
      		 listeners: {
      		 		'change': function(obj, valText){
        				var hasilnya = '', unit_kerja = Ext.getCmp('kode_unker_unor').getRawValue(), jabatan = valText;
        				if((Left(jabatan,12) == 'Kepala Badan') || (Left(jabatan,12) == 'Kepala Dinas') || (Left(jabatan,10) == 'Kepala UPT') || (Left(jabatan,11) == 'Kepala UPTD') || (Left(jabatan,13) == 'Kepala Kantor') || (Left(jabatan,13) == 'Kepala Satuan') || (Left(jabatan,13) == 'Kepala Cabang')){
        					hasilnya = 'Kepala ' + unit_kerja;
        				}else if ((Left(jabatan,9) == 'Inspektur') || (Left(jabatan,17) == 'Sekretaris Daerah')){
        					hasilnya = jabatan;
        				}else if (jabatan == 'Camat'){
        					hasilnya = 'Camat ' + unit_kerja.replace('Kecamatan ', '');
        				}else if (jabatan == 'Sekretaris Kecamatan'){
        					hasilnya = 'Sekretaris Kecamatan ' + unit_kerja.replace('Kecamatan ', '');
        				}else if ((jabatan == 'Lurah') || (jabatan == 'Kepala Kelurahan')){
        					hasilnya = 'Lurah ' + unit_kerja.replace('Kelurahan ', '');
        				}else if (jabatan == 'Sekretaris Kelurahan'){
        					hasilnya = 'Sekretaris Lurah ' + unit_kerja.replace('Kelurahan ', '');
        				}else{
        					hasilnya = jabatan + ' ' + unit_kerja;
        				}
        				if(!Form_Unor.getForm().findField('ID_Unor').getValue()){
        					Form_Unor.getForm().setValues({nama_unor:unit_kerja, jabatan_unor:hasilnya});      	
        				}
      		 		}
      		 }
      		},
      		{xtype: 'button', name: 'search_jab_for_unor', text: '...', 
      			handler: function(){
      				if(Ext.getCmp('kode_unker_unor').getRawValue()){      					
      					Show_Form_Ref_Jab_For_Unor(Form_Unor);
      				}else{
      					Ext.getCmp('sbWin_Unor').setStatus({text: 'Silahkan tentukan Unit Kerja',iconCls: 'x-status-error'});
      				}
      			}
          }
       ], anchor: '100%'
    	},      
    	{fieldLabel: 'Nama Unit Organisasi', name: 'nama_unor', id: 'nama_unor', anchor: '100%'},
    	{fieldLabel: 'Jabatan Unit Organisasi', name: 'jabatan_unor', id: 'jabatan_unor', anchor: '100%'},
      {xtype: 'combobox', fieldLabel: 'Eselon', name: 'kode_eselon', hiddenName: 'kode_eselon',
       store: new Ext.data.Store({
        		fields: ['kode_eselon','nama_eselon'], idProperty: 'ID_Eselon',
        		proxy: new Ext.data.AjaxProxy({url: BASE_URL + 'combo_ref/combo_eselon', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}}), 
        		autoLoad: true
       }),
       valueField: 'kode_eselon', displayField: 'nama_eselon', emptyText: 'Pilih Eselon',
       typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Eselon',
       listeners: {'focus': {fn: function (comboField) {comboField.expand();}, scope: this}},
       anchor: '50%'
      },
    	{xtype: 'checkbox', fieldLabel: 'Status Data', boxLabel: 'Aktif', name: 'status_data', id: 'status_data_unor', checked: true, anchor: '70%',
    	 listeners: {
        	'change': {
        		fn: function (check, newValue) {
        			if(newValue == true){
        				Ext.getCmp('status_data_unor').setBoxLabel('Aktif');
        			}else{
        				Ext.getCmp('status_data_unor').setBoxLabel('Non Aktif');
        			}
        		}, scope: this
        	}
    	 }
    	}       	    
    ],
    buttons: [
    	{text: 'Tambah', name: 'Tambah_M_Unor', id: 'Tambah_M_Unor', iconCls: 'icon-add',
       handler: function() {Form_Unor.getForm().reset(); Ext.getCmp('Tambah_M_Unor').setDisabled(true); Ext.getCmp('Ubah_M_Unor').setDisabled(true); Ext.getCmp('Simpan_M_Unor').setDisabled(false); Ext.getCmp('Batal_M_Unor').setDisabled(false); Ext.getCmp('nama_unor').focus(false, 200); Ext.getCmp('sbWin_Unor').setStatus({text:'Ready',iconCls:'x-status-valid'});}
    	},
  		{text: 'Ubah', id: 'Ubah_M_Unor', iconCls: 'icon-edit', 
  		 handler: function() {
  			var ID_Unor = Form_Unor.getForm().findField('ID_Unor').getValue();
  			if(ID_Unor){
  				Ext.getCmp('Tambah_M_Unor').setDisabled(true); Ext.getCmp('Ubah_M_Unor').setDisabled(true); Ext.getCmp('Simpan_M_Unor').setDisabled(false); Ext.getCmp('Batal_M_Unor').setDisabled(false);
  			}
  		 }
  		},
    	{text: 'Simpan', id: 'Simpan_M_Unor', iconCls: 'icon-save', handler: function() {    	
				Ext.getCmp('Form_Unor').on({
  				beforeaction: function() {Ext.getCmp('sbWin_Unor').showBusy();}
  			});
  			Form_Unor.getForm().submit({            			
  				success: function(form, action){
  					Data_Unor.load();
  					Ext.getCmp('Tambah_M_Unor').setDisabled(false);
  					Ext.getCmp('Ubah_M_Unor').setDisabled(false);
  					Ext.getCmp('Simpan_M_Unor').setDisabled(true);
  					Ext.getCmp('Batal_M_Unor').setDisabled(true);
  					Ext.getCmp('nama_unor').focus(false, 200);
  					obj = Ext.decode(action.response.responseText);
  					if(IsNumeric(obj.info.reason)){
  						var ID_Unor = obj.info.reason;
  						Form_Unor.getForm().setValues({ID_Unor:ID_Unor});
  						Ext.getCmp('sbWin_Unor').setStatus({text: 'Sukses menambah data !',iconCls: 'x-status-valid'});
  					}else{
  						Ext.getCmp('sbWin_Unor').setStatus({text: obj.info.reason,iconCls: 'x-status-valid'});
  					}
  				},
    			failure: function(form, action){
    				Ext.getCmp('Form_Unor').body.unmask();
      			if (action.failureType == 'server') {
      				obj = Ext.decode(action.response.responseText);
      				Ext.getCmp('sbWin_Unor').setStatus({text: obj.info.reason,iconCls: 'x-status-error'});
      			}else{
      				if (typeof(action.response) == 'undefined') {
      					Ext.getCmp('sbWin_Unor').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
        			}else{
      					Ext.getCmp('sbWin_Unor').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
        			}
      			}
    			}
  			});    	
    	}},
    	{text: 'Batal', id: 'Batal_M_Unor', iconCls: 'icon-undo',
       handler: function() {
				var ID_Unor = Form_Unor.getForm().findField('ID_Unor').getValue();
				if(!ID_Unor){Form_Unor.getForm().reset();}
       	Ext.getCmp('Tambah_M_Unor').setDisabled(false); Ext.getCmp('Ubah_M_Unor').setDisabled(false); Ext.getCmp('Simpan_M_Unor').setDisabled(true); Ext.getCmp('Batal_M_Unor').setDisabled(true); Form_Unor.getForm().setValues({kode_jns_unker:val_kode_jns_unker}); Ext.getCmp('nama_unker').focus(false, 200); Ext.getCmp('sbWin_Unor').setStatus({text:'Ready',iconCls:'x-status-valid'});
       }
    	},
    	{text: 'Tutup', id: 'Tutup_M_Unor', iconCls: 'icon-cross', handler: function() {win_popup_Unor.hide();}}    
    ]
	});
			
	var win_popup_Unor = new Ext.create('Ext.Window', {
		id: 'win_popup_Unor', title: 'Form Unit Organisasi', iconCls: 'icon-spell',
		modal : true, constrainHeader : true, closable: true,
		width: 500, height: 310, bodyStyle: 'padding: 5px;',		
		items: [Form_Unor],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_Unor', iconCls: 'x-status-valid'})
	});
		
	//if(mode == 'Ubah'){			
	//	Form_Unor.getForm().setValues(value_form);
	//}		

	//Ext.getCmp('Tambah_M_Unor').setDisabled(true);
	//Ext.getCmp('Ubah_M_Unor').setDisabled(true);	
	//Ext.getCmp('nama_unor').focus(false, 200);
	//Ext.getCmp('items-body').body.unmask();
//}
// FUNCTION FORM MASTER UNIT ORGANISASI ------------------------------------------- END

function Show_Form_Ref_Jab_For_Unor(Form_Unor){
	Ext.define('MSearch_RefJabatan', {extend: 'Ext.data.Model',
  	fields: ['ID_Jab', 'kode_jab', 'nama_jab', 'kode_eselon', 'nama_eselon', 'jenis_jab']
	});
	var Reader_Search_RefJabatan = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefJabatan', root: 'results', totalProperty: 'total', idProperty: 'ID_Jab'  	
	});
	var Proxy_Search_RefJabatan = new Ext.create('Ext.data.AjaxProxy', {
  	url: BASE_URL + 'browse_ref/ext_get_all_jabatan', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefJabatan
	});
	var Data_Search_RefJabatan = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefJabatan', model: 'MSearch_RefJabatan', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefJabatan
	});

	var Search_RefJabatan = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefJabatan', store: Data_Search_RefJabatan, emptyText: 'Ketik di sini untuk pencarian', width: 380});
	var tbSearch_RefJabatan = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefJabatan',
		items:[
			Search_RefJabatan, '->', 
			{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Ref_Jab_Unor',
		 	 handler: function(){
		 			var sm = grid_Search_RefJabatan.getSelectionModel(), sel = sm.getSelection();
  				if(sel.length == 1){
  					Form_Unor.getForm().setValues({
  						kode_jab: sel[0].get('kode_jab'),
  						nama_jab: sel[0].get('nama_jab'),
  						kode_eselon: sel[0].get('kode_eselon')
  					});
  					win_popup_Ref_Jabatan.close();
  				}else{
  					Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
  				}
		 	 }
			}
  	]
	});
	
	var cbGrid_Search_RefJabatan = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefJabatan = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefJabatan', store: Data_Search_RefJabatan, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefJabatan, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "Nama Jabatan", dataIndex: 'nama_jab', width: 400},
  		{header: "Eselon", dataIndex: 'nama_eselon', width: 80}
  	], bbar: tbSearch_RefJabatan,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefJabatan, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_Ref_Jab_Unor').handler.call(Ext.getCmp("PILIH_Ref_Jab_Unor").scope);
  		}  
  	}
	});

	var win_popup_Ref_Jabatan = new Ext.create('widget.window', {
  	id: 'win_popup_Ref_Jabatan', title: 'Referensi Jabatan', iconCls: 'icon-money_add',
   	modal:true, plain:true, closable: true, width: 500, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefJabatan]
	}).show();
}	
// FUNCTION TAMBAH UNIT ORGANISASI ----------------------------------------- START
function Master_Data_Tambah_Unor() {		
	//showForm_Unor('Tambah','');
	win_popup_Unor.show();
}
// FUNCTION TAMBAH UNIT ORGANISASI ----------------------------------------- END

// FUNCTION UBAH UNIT ORGANISASI ------------------------------------------- START
function Master_Data_Ubah_Unor() {	
	var sm = grid_Unor.getSelectionModel();
  var sel = sm.getSelection();
  if(sel.length == 1){
  	win_popup_Unor.show();
  	var value_form = { 
    	ID_Unor: sel[0].get('ID_Unor'), 
    	kode_unker: sel[0].get('kode_unker'),
    	kode_jab: sel[0].get('kode_jab'),
    	nama_jab: sel[0].get('nama_jab'),
    	nama_unor: sel[0].get('nama_unor'),
    	jabatan_unor: sel[0].get('jabatan_unor'),
    	kode_eselon: sel[0].get('kode_eselon'),
    	status_data: sel[0].get('status_data')
    };
   // showForm_Unor('Ubah',value_form);    	
  }		
}
// FUNCTION UBAH UNIT ORGANISASI ------------------------------------------ END

// FUNCTION HAPUS UNIT ORGANISASI ----------------------------------------- START
function Master_Data_Hapus_Unor() {	
  var sm = grid_Unor.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';      		
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_Unor') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'master_data/ext_delete_unit_organisasi', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Unor.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}
// FUNCTION HAPUS UNIT ORGANISASI ----------------------------------------- END

// FUNCTION CETAK UNIT ORGANISASI ----------------------------------------- START
function print_Unor(){
	Load_Popup('win_print_pd', BASE_URL + 'master_data/print_dialog_unor', 'Cetak Daftar Unit Organisasi');
}
// FUNCTION CETAK UNIT ORGANISASI ----------------------------------------- END
	
// TAB MASTER UNIT ORGANISASI  ------------------------------------------------- START
var new_tabpanel_MD = {
	id: 'master_unit_organisasi', title: 'Unit Organisasi', iconCls: 'icon-spell', border: false,
  closable: true, items: [grid_Unor]
}
// TAB MASTER UNIT ORGANISASI  ------------------------------------------------- END

<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>