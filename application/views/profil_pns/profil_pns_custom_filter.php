<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Form_Custom_Filter = new Ext.create('Ext.form.Panel', {
 		id: 'Form_Custom_Filter',
  	frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  	fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 150},
  	defaultType: 'textfield', defaults: {allowBlank: true}, buttonAlign:'left',
  	items: [
    	{xtype: 'fieldcontainer', fieldLabel: 'Cari NIP / Nama Pegawai', combineErrors: false,
    	 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 items: [
      	{xtype: 'textfield', name: 'cari_nip_nama', id: 'cari_nip_nama', margin: '0 2 0 0', flex:2,
      		listeners: {
      			specialkey: function(f,e){
      				if (e.getKey() == e.ENTER) {
      					Ext.getCmp('filter_nip_nama').handler.call(Ext.getCmp("filter_nip_nama").scope);
      				}
      			}
      		}
      	},
      	{xtype: 'button', name: 'filter_nip_nama', id: 'filter_nip_nama', text: 'Cari ...', 
      		handler: function(){process_Custom_Filter(Form_Custom_Filter, 'NIP_NAMA');}
       	}
       ], width: 430
    	},
			{xtype: 'fieldcontainer', layout: 'hbox', 
  	 	 items: [
  			{xtype: 'fieldset', title: '[Filter Berdasarkan]', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
  	 	 	 items: [
  	 	 	 	// START - FIELD FILTER UNIT KERJA
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [      			
      			{xtype: 'checkbox', boxLabel: 'Unit Kerja', id: 'check_unker',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('nama_unker_filter').setDisabled(false);
   	 								Ext.getCmp('search_ref_unker').setDisabled(false);
   	 								Ext.getCmp('search_ref_unker').handler.call(Ext.getCmp("search_ref_unker").scope);
   	 							}else{
   	 								Ext.getCmp('nama_unker_filter').setDisabled(true);
   	 								Ext.getCmp('search_ref_unker').setDisabled(true);
   	 								Form_Custom_Filter.getForm().setValues({kode_unker_filter:'',nama_unker_filter:''});
   	 							}
   	 						}
						 }
      			},
      			{name: 'kode_unker_filter', id: 'kode_unker_filter', xtype: 'hidden'},
      			{xtype: 'textfield', name: 'nama_unker_filter', id: 'nama_unker_filter', disabled: true, readOnly: true, margin: '0 2 0 18', flex:1},
      			{xtype: 'button', name: 'search_ref_unker', id: 'search_ref_unker', text: '...', disabled: true,  
      				handler: function(){Show_Popup_Ref_Unker_Profil(Form_Custom_Filter);}
       			}      			
       		 ]
    			},
    			// END - FIELD FILTER UNIT KERJA
  	 	 	 	// START - FIELD FILTER UNIT ORGANISASI
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [      			
      			{xtype: 'checkbox', boxLabel: 'Unit Organisasi', id: 'check_unor',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('nama_unor_filter').setDisabled(false);
   	 								Ext.getCmp('search_ref_unor').setDisabled(false);
   	 								Ext.getCmp('search_ref_unor').handler.call(Ext.getCmp("search_ref_unor").scope);
   	 							}else{
   	 								Ext.getCmp('nama_unor_filter').setDisabled(true);
   	 								Ext.getCmp('search_ref_unor').setDisabled(true);
   	 								Form_Custom_Filter.getForm().setValues({kode_unor_filter:'',nama_unor_filter:''});
   	 							}
   	 						}
						 }
      			},
      			{name: 'kode_unor_filter', id: 'kode_unor_filter', xtype: 'hidden'},
      			{xtype: 'textfield', name: 'nama_unor_filter', id: 'nama_unor_filter', disabled: true, readOnly: true, margin: '0 2 0 5', flex:1},
      			{xtype: 'button', name: 'search_ref_unor', id: 'search_ref_unor', text: '...', disabled: true,  
      				handler: function(){Show_Popup_Ref_Unor_Profil(Form_Custom_Filter);}
       			}
       		 ]
    			},
    			// END - FIELD FILTER UNIT ORGANISASI
    			
  	 	 	 	// START - FIELD FILTER JABATAN
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [
      			{xtype: 'checkbox', boxLabel: 'Jabatan', id: 'check_jab',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('nama_jab_filter').setDisabled(false);
   	 								Ext.getCmp('search_ref_jab').setDisabled(false);
   	 								Ext.getCmp('search_ref_jab').handler.call(Ext.getCmp("search_ref_jab").scope);
   	 							}else{
   	 								Ext.getCmp('nama_jab_filter').setDisabled(true);
   	 								Ext.getCmp('search_ref_jab').setDisabled(true);
   	 								Form_Custom_Filter.getForm().setValues({kode_jab_filter:'',nama_jab_filter:''});
   	 							}
   	 						}
						 }
      			},
      			{name: 'kode_jab_filter', id: 'kode_jab_filter', xtype: 'hidden'},
      			{xtype: 'textfield', name: 'nama_jab_filter', id: 'nama_jab_filter', disabled: true, readOnly: true, margin: '0 2 0 23', flex:1},
      			{xtype: 'button', name: 'search_ref_jab', id: 'search_ref_jab', text: '...', disabled: true,  
      				handler: function(){Show_Popup_Ref_Jab_Profil(Form_Custom_Filter);}
       			}
       		 ]
    			},
  	 	 	 	// END - FIELD FILTER JABATAN

  	 	 	 	// START - FIELD FILTER ESELON
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [
      			{xtype: 'checkbox', boxLabel: 'Eselon', id: 'check_eselon',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('kode_eselon_filter').setDisabled(false);
   	 								Ext.getCmp('kode_eselon_filter').reset();
   	 							}else{
   	 								Ext.getCmp('kode_eselon_filter').setDisabled(true);
   	 								Ext.getCmp('kode_eselon_filter').reset();
   	 							}
   	 						}
						 }
      			},
     				{xtype: 'combobox', name: 'kode_eselon', id: 'kode_eselon_filter', hiddenName: 'kode_eselon', disabled: true,
       	 		 store: new Ext.data.Store({
       			 		fields: ['kode_eselon','nama_eselon'], idProperty: 'ID_Dupeg',
       				 	proxy: new Ext.data.AjaxProxy({
    							url: BASE_URL + 'combo_ref/combo_eselon', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}
    	 						}), autoLoad: true
       	 		 }),
       	 		 valueField: 'kode_eselon', displayField: 'nama_eselon', emptyText: 'Pilih Dupeg',
       	 		 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Dupeg',
       	 		 listeners: {
       					'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       	 		 }, margins: '0 5 0 53', width: 125
      			}
       		 ]
    			},
  	 	 	 	// END - FIELD FILTER ESELON

  	 	 	 	// START - FIELD FILTER PANGKAT GOLRU
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [
      			{xtype: 'checkbox', boxLabel: 'Pangkat/Golru', id: 'check_golru',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('kode_golru_filter').setDisabled(false);
   	 								Ext.getCmp('kode_golru_filter').reset();
   	 								Ext.getCmp('nama_golru_filter').setDisabled(false);
   	 								Ext.getCmp('nama_golru_filter').reset();
   	 							}else{
   	 								Ext.getCmp('kode_golru_filter').setDisabled(true);
   	 								Ext.getCmp('kode_golru_filter').reset();
   	 								Ext.getCmp('nama_golru_filter').setDisabled(true);
   	 								Ext.getCmp('nama_golru_filter').reset();
   	 							}
   	 						}
						 }
      			},
    				{xtype: 'fieldcontainer', combineErrors: false,
    	 			 defaults: {hideLabel: true}, layout: 'hbox', msgTarget: 'side', width: 289, margin: '0 2 0 6',
    	 			 items: [
     					{xtype: 'combobox', name: 'kode_golru', id: 'kode_golru_filter', hiddenName: 'kode_golru', disabled: true,
       	 			 store: new Ext.data.Store({
       				 	fields: ['kode_golru','nama_pangkat','nama_golru'], idProperty: 'ID_Golru',
       				 	proxy: new Ext.data.AjaxProxy({
    							url: BASE_URL + 'combo_ref/combo_golru', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}
    	 						}), autoLoad: true
       	 			 }),
       	 			 valueField: 'kode_golru', displayField: 'nama_pangkat', emptyText: 'Pilih Pangkat',
       	 			 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Pangkat',
       	 			 listeners: {
       						'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this},
        					'change': {
        						fn: function (comboField, newValue) {
        							Ext.Ajax.request({
        								url: BASE_URL + 'combo_ref/get_nama_golru', method: 'POST', params: {id_open: 1,kode_golru: newValue}, scripts: true, 
        								success: function(response){
        									Form_Custom_Filter.getForm().setValues({nama_golru_filter: response.responseText});
        								}
        							});
        						}, scope: this
        					}       	
       	 			 }, margins: '0 5 0 0', width: 180
      				},
      				{xtype: 'textfield', fieldLabel: 'Gol. Ruang', name: 'nama_golru_filter', id: 'nama_golru_filter', readOnly: true, allowBlank: true, width: 50, disabled: true}    	 
       			 ]
    				}
       		 ]
    			},
  	 	 	 	// END - FIELD FILTER PANGKAT GOLRU
  	 	 	 	
  	 	 	 	// START - FIELD FILTER DUPEG
    			{xtype: 'fieldcontainer', combineErrors: false,
    	 		 defaults: {hideLabel: true, allowBlank: true}, layout: 'hbox', msgTarget: 'side', defaultType: 'textfield',
    	 		 items: [
      			{xtype: 'checkbox', boxLabel: 'Dupeg', id: 'check_dupeg',
   	 				 listeners: {
   	 						change : function(checkbox, checked) {
   	 							if(checked == true){
   	 								Ext.getCmp('kode_dupeg_filter').setDisabled(false);
   	 								Ext.getCmp('kode_dupeg_filter').reset();
   	 							}else{
   	 								Ext.getCmp('kode_dupeg_filter').setDisabled(true);
   	 								Ext.getCmp('kode_dupeg_filter').reset();
   	 							}
   	 						}
						 }
      			},
     				{xtype: 'combobox', name: 'kode_dupeg', id: 'kode_dupeg_filter', hiddenName: 'kode_dupeg', disabled: true,
       	 		 store: new Ext.data.Store({
       			 		fields: ['kode_dupeg','nama_dupeg'], idProperty: 'ID_Dupeg',
       				 	proxy: new Ext.data.AjaxProxy({
    							url: BASE_URL + 'combo_ref/combo_dupeg', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}
    	 						}), autoLoad: true
       	 		 }),
       	 		 valueField: 'kode_dupeg', displayField: 'nama_dupeg', emptyText: 'Pilih Dupeg',
       	 		 typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Dupeg',
       	 		 listeners: {
       					'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       	 		 }, margins: '0 5 0 53', width: 250
      			}
       		 ]
    			}
  	 	 	 	// END - FIELD FILTER DUPEG
  	 	 	 ],flex: 2
  			},
  			{xtype: 'fieldset', title: '[Pengurutan Data]', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
  	 	 	 items: [
  	 	 	 		{xtype: 'radio', boxLabel: 'Urutkan Sesuai Kepangkatan', name: 'radio_filter', id: 'radio_kpkt',
   	 				 listeners: {
   	 						change : function(checkbox, newValue) {Ext.getCmp('radio_asc').setValue(true);}
						 }
  	 	 	 		},
  	 	 	 		{xtype: 'radio', boxLabel: 'Urutkan Sesuai Jabatan', name: 'radio_filter', id: 'radio_jab',
   	 				 listeners: {
   	 						change : function(checkbox, newValue) {Ext.getCmp('radio_asc').setValue(true);}
						 }
  	 	 	 		},
  	 	 	 		{xtype: 'radio', boxLabel: 'Urutkan Sesuai Eselon', name: 'radio_filter', id: 'radio_eselon',
   	 				 listeners: {
   	 						change : function(checkbox, newValue) {Ext.getCmp('radio_asc').setValue(true);}
						 }
  	 	 	 		},
  	 	 	 ], flex: 1
  			},
  			{xtype: 'fieldset', title: '[Asc / Desc]', defaultType: 'textfield', defaults: {labelWidth: 105}, margins: '0 5 0 0', style: 'padding: 0 5px 10px 5px;',
  	 	 	 items: [
  	 	 	 		{xtype: 'radio', boxLabel: 'Ascending', name: 'radio_sort', id: 'radio_asc'},
  	 	 	 		{xtype: 'radio', boxLabel: 'Descending', name: 'radio_sort', id: 'radio_desc'}
  	 	 	 ]
  	 	 	}
  		 ]
  		}
  	],
  	buttons: [
  		'->',
  		{text: 'Proses Filter', id: 'Btn_Proses_Filter', iconCls: 'icon-filter', handler: function() {process_Custom_Filter(Form_Custom_Filter, 'ADV_FILTER');}},
  		{text: 'Hapus Filter', id: 'Btn_Hapus_Custom_Filter', iconCls: 'icon-filter_clear', handler: function() {clear_Custom_Filter();}},'-',
  		{text: 'Tutup', id: 'Btn_Tutup_Custom_Filter', iconCls: 'icon-cross', handler: function() {Ext.getCmp('win_popup_Custom_Filter').close();}}
  	]
});

var new_popup = new Ext.create('widget.window', {
   	id: 'win_popup_Custom_Filter', title: 'Custom Filter', iconCls: 'icon-filter',
   	modal:true, plain:true, closable: true, width: 700, height: 350, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [Form_Custom_Filter]
});

function process_Custom_Filter(vForm,vMode){	
	Ext.getCmp('HCF_PPNS').setDisabled(false);
	Grid_Profil_PNS.filters.clearFilters();
	if(vMode == 'NIP_NAMA'){
		if(vForm.getForm().findField('cari_nip_nama').getValue()){
			Data_Profil_PNS.changeParams({params :{id_open: 1, NIP_NAMA: vForm.getForm().findField('cari_nip_nama').getValue()}});
		}
	}else if(vMode == 'ADV_FILTER'){
		if(Ext.getCmp('radio_kpkt').getValue() == true){
			Vfield_order = 'kode_golru';
		}else if(Ext.getCmp('radio_jab').getValue() == true){
			Vfield_order = 'kode_jab';
		}else if(Ext.getCmp('radio_eselon').getValue() == true){
			Vfield_order = 'kode_eselon';
		}else{
			Vfield_order = '';
		}

		if(Ext.getCmp('radio_asc').getValue() == true){
			Vasc_desc = 'ASC';
		}else{
			Vasc_desc = 'DESC';
		}
		
		Vkode_unker = vForm.getForm().findField('kode_unker_filter').getValue();
		Vkode_unor = vForm.getForm().findField('kode_unor_filter').getValue();
		Vkode_jab = vForm.getForm().findField('kode_jab_filter').getValue();
		Vkode_eselon = vForm.getForm().findField('kode_eselon_filter').getValue();
		Vkode_golru = vForm.getForm().findField('kode_golru_filter').getValue();
		Vkode_dupeg = vForm.getForm().findField('kode_dupeg_filter').getValue();
		if(Vkode_dupeg == 0){Vkode_dupeg = 99}
		Data_Profil_PNS.changeParams({
			params :{
				id_open: 1, ADV_FILTER: 1, field_order:Vfield_order, asc_desc:Vasc_desc,
				NIP_NAMA: vForm.getForm().findField('cari_nip_nama').getValue(), 
				kode_unker: Vkode_unker, kode_unor: Vkode_unor, kode_jab: Vkode_jab, kode_eselon: Vkode_eselon,
				kode_golru: Vkode_golru, kode_dupeg: Vkode_dupeg
			}
		});
	}
}


// POPUP REFERENSI UNIT KERJA PNS  ---------------------------------------------------- START
var vaktif_unker = 1;
function Show_Popup_Ref_Unker_Profil(vForm){	
	Ext.define('MSearch_RefUnKer', {extend: 'Ext.data.Model',
    fields: ['ID_UK', 'kode_unker', 'nama_unker']
	});
	var Reader_Search_RefUnKer = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefUnKer', root: 'results', totalProperty: 'total', idProperty: 'ID_UK'  	
	});
	var Proxy_Search_RefUnKer = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_unker', actionMethods: {read:'POST'}, extraParams :{id_open: 1, aktif: vaktif_unker}, reader: Reader_Search_RefUnKer
	});
	var Data_Search_RefUnKer = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefUnKer', model: 'MSearch_RefUnKer', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefUnKer
	});

	var Search_RefUnKer = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefUnKer', store: Data_Search_RefUnKer, emptyText: 'Ketik di sini untuk pencarian', width: 270});
	var tbSearch_RefUnKer = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefUnKer',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_unor', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif_unker = 1;
   	 		}else{
   	 			vaktif_unker = 0;
   	 		}
				Search_RefUnKer.onTrigger1Click();
				Data_Search_RefUnKer.changeParams({params :{id_open: 1, aktif: vaktif_unker}});
   	 	}
		 }
    },		
		Search_RefUnKer, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Unker',
		 handler: function(){
		 		var sm = grid_Search_RefUnKer.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  				vForm.getForm().setValues({
  					kode_unker_filter: sel[0].get('kode_unker'),
  					nama_unker_filter: sel[0].get('nama_unker')
  				});
  				win_popup_Ref_Unker.close();
  			}else{
  				Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
  			}
		 }
		}
  ]
	});
	
	var cbGrid_Search_RefUnKer = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefUnKer = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefUnKer', store: Data_Search_RefUnKer, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefUnKer, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "Nama Unit Kerja", dataIndex: 'nama_unker', width: 540}
  	], bbar: tbSearch_RefUnKer,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefUnKer, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_Unker').handler.call(Ext.getCmp("PILIH_Unker").scope);
  		}
  	}  	
	});

	var win_popup_Ref_Unker = new Ext.create('widget.window', {
   	id: 'win_popup_Ref_Unker', title: 'Referensi Unit Kerja', iconCls: 'icon-course',
   	modal:true, plain:true, closable: true, width: 440, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefUnKer]
	}).show();
}

// POPUP REFERENSI UNIT KERJA PNS  ---------------------------------------------------- END

// POPUP REFERENSI UNOR PNS  ---------------------------------------------------- START
var vaktif_unor = 1;
function Show_Popup_Ref_Unor_Profil(vForm){
	vkode_unker_unor = vForm.getForm().findField('kode_unker_filter').getValue();
	Ext.define('MSearch_RefUnor', {extend: 'Ext.data.Model',
    fields: ['ID_Unor', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_jab', 'nama_jab', 'nama_eselon', 'tunj_jab']
	});
	var Reader_Search_RefUnor = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefUnor', root: 'results', totalProperty: 'total', idProperty: 'ID_Unor'  	
	});
	var Proxy_Search_RefUnor = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_unor', actionMethods: {read:'POST'}, extraParams :{id_open: 1, aktif:vaktif_unor, kode_unker:vkode_unker_unor}, reader: Reader_Search_RefUnor
	});
	var Data_Search_RefUnor = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefUnor', model: 'MSearch_RefUnor', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefUnor
	});

	var Search_RefUnor = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefUnor', store: Data_Search_RefUnor, emptyText: 'Ketik di sini untuk pencarian', width: 400});
	var tbSearch_RefUnor = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefUnor',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_unor', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif_unor = 1;
   	 		}else{
   	 			vaktif_unor = 0;
   	 		}
				Search_RefUnor.onTrigger1Click();
				Data_Search_RefUnor.changeParams({params :{id_open: 1, aktif: vaktif_unor}});
   	 	}
		 }
    },		
		Search_RefUnor, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Unor',
		 handler: function(){
		 		var sm = grid_Search_RefUnor.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  				vForm.getForm().setValues({
  					kode_unor_filter: sel[0].get('kode_unor'),
  					nama_unor_filter: sel[0].get('nama_unor')
  				});
  				win_popup_Ref_Unor.close();
  			}else{
  				Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
  			}
		 }
		}
  ]
	});
	
	var cbGrid_Search_RefUnor = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefUnor = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefUnor', store: Data_Search_RefUnor, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefUnor, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "Nama Unit Organisasi", dataIndex: 'nama_unor', width: 300},
  		{header: "Nama Unit Kerja", dataIndex: 'nama_unker', width: 240}
  	], bbar: tbSearch_RefUnor,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefUnor, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_Unor').handler.call(Ext.getCmp("PILIH_Unor").scope);
  		}
  	}  	
	});

	var win_popup_Ref_Unor = new Ext.create('widget.window', {
   	id: 'win_popup_Ref_Unor', title: 'Referensi Unit Organisasi', iconCls: 'icon-spell',
   	modal:true, plain:true, closable: true, width: 600, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefUnor]
	}).show();
}
// POPUP REFERENSI UNOR PNS  ---------------------------------------------------- END

// POPUP REFERENSI NAMA JABATAN PNS  ---------------------------------------------------- START
var vaktif_jab = 1;
function Show_Popup_Ref_Jab_Profil(vForm){
	Ext.define('MSearch_RefJabatan', {extend: 'Ext.data.Model',
    fields: ['ID_Jab', 'kode_jab', 'nama_jab', 'tunj_jab', 'nama_eselon', 'jenis_jab']
	});
	var Reader_Search_RefJabatan = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefJabatan', root: 'results', totalProperty: 'total', idProperty: 'ID_Jab'  	
	});
	var Proxy_Search_RefJabatan = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_jabatan', actionMethods: {read:'POST'}, extraParams :{id_open: 1, aktif:vaktif_jab}, reader: Reader_Search_RefJabatan
	});
	var Data_Search_RefJabatan = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefJabatan', model: 'MSearch_RefJabatan', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefJabatan
	});

	var Search_RefJabatan = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefJabatan', store: Data_Search_RefJabatan, emptyText: 'Ketik di sini untuk pencarian', width: 245});
	var tbSearch_RefJabatan = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefJabatan',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_jab', checked:true, margins: '0 10px 5px 5px', width: 45,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif_jab = 1;
   	 		}else{
   	 			vaktif_jab = 0;
   	 		}
				Search_RefJabatan.onTrigger1Click();
				Data_Search_RefJabatan.changeParams({params :{id_open: 1, aktif: vaktif_jab}});
   	 	}
		 }
    },
		Search_RefJabatan, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Jab',
		 handler: function(){
		 		var sm = grid_Search_RefJabatan.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  				vForm.getForm().setValues({
  					kode_jab_filter: sel[0].get('kode_jab'),
  					nama_jab_filter: sel[0].get('nama_jab')
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
  		{header: "Eselon", dataIndex: 'nama_eselon'}
  	], bbar: tbSearch_RefJabatan,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefJabatan, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_Jab').handler.call(Ext.getCmp("PILIH_Jab").scope);
  		}
  	}  	
	});

	var win_popup_Ref_Jabatan = new Ext.create('widget.window', {
   	id: 'win_popup_Ref_Jabatan', title: 'Referensi Jabatan', iconCls: 'icon-spam',
   	modal:true, plain:true, closable: true, width: 430, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefJabatan]
	}).show();
}
// POPUP REFERENSI NAMA JABATAN PNS  ---------------------------------------------------- END

<?php }else{ echo "var custom_filter_PPNS = 'GAGAL';"; } ?>