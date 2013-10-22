<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>

// TABEL PENGGUNA LOGIN  --------------------------------------------------------- START
var win_popup, newpanel;
var Params_User = null;

Ext.define('MUser', {
  extend: 'Ext.data.Model',
  fields: ['ID_User', 'NIP', 'user', 'fullname', 'temp_kode_unker', 'temp_kode_unor', 'group', 'general_group_name', 'email', 'registerDate', 'lastvisitDate', 'type', 'status', 'nama_unor', 'nama_unker']
});

var dataReader = new Ext.create('Ext.data.JsonReader', {
 	id: 'dataReader', root: 'results', totalProperty: 'total', idProperty: 'ID_User'
});
	
var dataProxy = new Ext.create('Ext.data.AjaxProxy', {
 	id: 'dataProxy', url: BASE_URL + 'pengguna_login/ext_get_all', actionMethods: {read:'POST'}, extraParams :{id_open: '1'},
  reader: dataReader,
  afterRequest: function(request, success) {
   	Params_User = request.operation.params;
  }
});

var DataUsers = new Ext.create('Ext.data.Store', {
	id: 'DataUsers', model: 'MUser', pageSize: 20, autoLoad: true, proxy: dataProxy
});

var searchUsers = new Ext.create('Ext.ux.form.SearchField', {
  id: 'searchUsers', store: DataUsers, width: 180
});
	
var tbUsers = new Ext.create('Ext.toolbar.Toolbar', { 
  	items:[
  		{text: 'Tambah', id: 'tambah_user', iconCls: 'icon-useradd', handler: addUsers, disabled: pl_insert},'-', 
  		{text: 'Ubah', id: 'ubah_user', iconCls: 'icon-useredit', handler: updateUsers, disabled: pl_update},'-', 
  		{text: 'Hapus', iconCls: 'icon-userdel', handler: deleteUsers, disabled: pl_delete},'-', 
  		{text: 'Ubah Kata Sandi', iconCls: 'icon-key', handler: changePass, disabled: pl_update},'-', 
  		//{text: 'Akses Menu', id: 'Btn_Akses_Menu', iconCls: 'icon-gears', handler: show_form_Akses_Menu, disabled: pl_update},'-', 
  		{tooltip: 'Cetak', iconCls: 'icon-printer', handler: function(){Load_Popup('win_print_pd_no_ttd', BASE_URL + 'pengguna_login/print_dialog_dnp', 'Cetak Pengguna Login');}},'->', 
  		{text: 'Clear Filter', iconCls: 'icon-cross', handler: function () {gridUsers.filters.clearFilters();}}, 
  		searchUsers
    ]
});
	
var filtersCfg = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, 
    local: false, store: DataUsers,
    filters: [
    	{type: 'string', dataIndex: 'NIP'},
    	{type: 'string', dataIndex: 'user'},
    	{type: 'string', dataIndex: 'fullname'},
    	{type: 'string', dataIndex: 'email'},
    	//{type: 'list', dataIndex: 'type', options: ['SUPER ADMIN', 'ADMIN', 'PENGELOLA SIMPEG', 'OPD', 'PEGAWAI'], phpMode: true},
    	{type: 'string', dataIndex: 'registerDate'},
    	{type: 'string', dataIndex: 'lastvisitDate'},
    	{type: 'list', dataIndex: 'status', options: ['Active', 'Inactive']}
    ]
});

var cbGrid = new Ext.create('Ext.selection.CheckboxModel');
	
var gridUsers = new Ext.create('Ext.grid.Panel', {
  	id: 'gridUsers', store: DataUsers, title: 'DAFTAR PENGGUNA LOGIN', 
  	frame: true, border: true, loadMask: true,     
  	style: 'margin:0 auto;', height: '100%', width: '100%',
    selModel: cbGrid, columnLines: true,
    invalidateScrollerOnRefresh: false,
		columns: [
  		{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  		{header: "NIP", dataIndex: 'NIP', sortable: true,	width: 140}, 
    	{header: "Pengguna", dataIndex: 'user', sortable: true,	width: 100}, 
    	{header: "Nama Lengkap", dataIndex: 'fullname', sortable: true, width: 180}, 
	  	{header: "Unit-Kerja", dataIndex: 'nama_unor', width: 200}, 
	  	{header: "Unit-Organisasi", dataIndex: 'nama_unker', width: 200}, 
    	{header: "E-Mail", dataIndex: 'email', sortable: true, width: 150}, 
    	//{header: "Tipe", dataIndex: 'type', sortable: true, width: 85}, 
    	{header: "Group", dataIndex: 'general_group_name', sortable: true, width: 85}, 
    	{header: "Tanggal Terdaftar", dataIndex: 'registerDate', sortable: true, width: 120}, 
    	{header: "Kunjungan Terakhir", dataIndex: 'lastvisitDate', sortable: true, width: 120}, 
    	{header: "Status", dataIndex: 'status', sortable: true, width: 50}
    ],
    features: [filtersCfg],
    tbar: tbUsers,
    dockedItems: [{xtype: 'pagingtoolbar', store: DataUsers, dock: 'bottom', displayInfo: true}],
	  listeners: {
	  	itemdblclick: function(dataview, record, item, index, e) {
	  		Ext.getCmp('ubah_user').handler.call(Ext.getCmp("ubah_user").scope);
	  	}
	  }    
});
// TABEL PENGGUNA LOGIN  ------------------------------------------------- END
  
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- START
function get_selected_value(){
    var sm = gridUsers.getSelectionModel();
    var sel = sm.getSelection();
    var data = '';      		
    if(sel.length > 0){
      for (i = 0; i < sel.length; i++) {
      	data = data + sel[i].get('ID_User') + '-';
			}
    }
    return data;
}
// FUNCTION GET SELECTED VALUE GRID -------------------------------------- END
	
// FUNCTION FORM PENGGUNA LOGIN ----------------------------------------- START
function show_formUsers(mode,value_form) {		
	Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
	if(mode == 'Ubah'){
		var seg = 'ext_update';
		var xtype_pass = 'hidden';
		var disabled_pengguna = true;
	}else{
		var seg = 'ext_insert';
		var xtype_pass = 'textfield';
		var disabled_pengguna = false;
	}
					
	var form_user = new Ext.create('Ext.form.Panel', {
  	id: 'form_user', url: BASE_URL + 'pengguna_login/' + seg,
    frame: true, bodyStyle: 'padding: 5px 5px 0 0;', width: '100%', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 90},
    defaultType: 'textfield', defaults: {anchor: '100%', allowBlank: false},
    items: [
    	{name: 'ID_User', xtype: 'hidden'},
    	{fieldLabel: 'Pengguna', name: 'user', disabled: disabled_pengguna, anchor: '80%'},
    	{fieldLabel: 'Kata Sandi', name: 'pass', xtype: xtype_pass, anchor: '80%'},
    	{xtype: 'fieldcontainer', fieldLabel: 'N I P', combineErrors: false,
    	 defaults: {hideLabel: true, allowBlank: false}, layout: 'hbox', msgTarget: 'side', 
    	 items: [
      		{xtype: 'textfield', name: 'NIP', id: 'NIP_User', maxLength: 21, maskRe: /[\d\ \.\;]/, regex: /^[0-9]|\;*$/, margin: '0 0 0 0', flex:2,
	      	 listeners: {
	      			specialkey: function(f,e){
	      				if (e.getKey() == e.ENTER) {
	      					//User_Cari_Pgw(Ext.getCmp('NIP_User').getValue(), form_user);
	      				}
	      			}
	      	 }
      		}/*,
      		{xtype: 'button', name: 'search_pegawai', text: '...', 
      			handler: function(){
      				Show_Popup_RefPegawai_User(form_user);
      			}
          }*/
       ], anchor: '100%'
    	},
    	{fieldLabel: 'Nama Lengkap', name: 'fullname', id: 'fullname', allowBlank: false},
	    //{xtype: 'textfield', fieldLabel: 'Unit-Kerja', name: 'nama_unor', id: 'nama_unor_user', readOnly: false, height: 22, allowBlank: true, anchor: '100%'},
            
            {
                xtype:'combo',
                fieldLabel: 'Unit Kerja',
                name: 'nama_unker',
                id: 'nama_unker_user',
                itemId: 'unker',
                allowBlank: true,
                store: new Ext.create('Ext.data.Store', {
                    fields: ['kdlok', 'ur_upb'], idProperty: 'ID_UK', storeId: 'DataUnker',
                    proxy: new Ext.data.AjaxProxy({
                        url: BASE_URL + "combo_ref/combo_simak_unker", actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
                    }),
                    autoLoad: true
                }),
                valueField: 'kdlok',
                displayField: 'ur_upb',
                emptyText: 'Pilih Unit Kerja',
                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                listeners: {
                    'focus': {
                        fn: function(comboField) {
                            comboField.expand();
                        },
                        scope: this
                    },
                    'change': {
                        fn: function(obj, value) {
                            Ext.getCmp('nama_unor_user').setValue()
                            /*if (value !== null)
                            {
                                var kodeUnkerField = Ext.getCmp('kd_lokasi');
                                if (kodeUnkerField !== null) {
                                    if (value.length > 0) {
                                        kodeUnkerField.setValue(value);
                                    }
                                }
                            }*/

                        },
                        scope: this
                    }
                }
            },
            
            {
                xtype:'combo',
                fieldLabel: ' Unit Organisasi',
                name: 'nama_unor',
                id: 'nama_unor_user',
                disabled: false,
                allowBlank: true,
                store: new Ext.create('Ext.data.Store', {
                    fields: ['kode_unor', 'nama_unor', 'kd_lokasi'], storeId: 'DataUnor',
                    proxy: new Ext.data.AjaxProxy({
                        url: BASE_URL + "combo_ref/combo_unor", actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_lokasi: 0}
                    }),
                    autoLoad: true
                }),
                valueField: 'kode_unor',
                displayField: 'nama_unor', emptyText: 'Pilih Unit Organisasi',
                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                listeners: {
                    'focus': {
                        fn: function(comboField) {

                            var dataStore = comboField.getStore();
                            var kd_lokasi = Ext.getCmp('nama_unker_user').getValue();
                            if (kd_lokasi !== null)
                            {
                                dataStore.clearFilter();
                                dataStore.filter({property:"kd_lokasi", value:kd_lokasi});
                            }
                            comboField.expand();
                            
                        },
                        scope: this
                    },
                    'change': {
                        fn: function(obj, value) {
                            /*var kodeUnorField = form.getForm().findField('kode_unor');
                            if (kodeUnorField !== null && !isNaN(value)) {
                                kodeUnorField.setValue(value);
                                console.log(kodeUnorField.getValue());
                            }*/
                        }
                    }
                }
            },
            
	    //{xtype: 'textareafield', fieldLabel: 'Unit-Organisasi', name: 'nama_unker', id: 'nama_unker_user', readOnly: false, allowBlank: true, height: 40, anchor: '100%'},
    	{fieldLabel: 'E-Mail', name: 'email', id: 'email_user', vtype:'email', allowBlank: true}, 
    	/*{xtype: 'combobox', fieldLabel: 'Tipe', name: 'type', value: 'OPD',
    	 store: new Ext.data.SimpleStore({
       		data: [['SUPER ADMIN'],['ADMIN'],['PENGELOLA SIMPEG'],['OPD'], ['PEGAWAI'] ], fields: ['type']
			 }),
       valueField: 'type', displayField: 'type', emptyText: 'Pilih Tipe',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }, anchor: '70%'
      }, */
        {
                        fieldLabel: 'Group',
                        name: 'group',
                        xtype:'combobox',
                        valueField: 'id_groupcollections',
                        value:0,
                        displayField: 'general_group_name',
                        emptyText: 'Pilih Group',
                        typeAhead: true,
                        forceSelection: false,
                        selectOnFocus: true,
                        valueNotFoundText: 'Pilih Group',
                        queryMode: 'local',
                        store:new Ext.data.Store({
                            noCache: false,
                            autoLoad: true,
                            proxy: {
                                type: 'ajax',
                                actionMethods: {read:'POST'},
                                extraParams :{id_open: '1'},
                                url: BASE_URL + 'pengguna_login/ext_get_all_groupcollections',
                                reader: {
                                    type: 'json',
                                    root: 'results',
                                    totalProperty: 'total',
                                    idProperty: 'id_groupcollections' 
                                }
                            },
                            fields: ['id_groupcollections', 'general_group_name']
                        }),
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            },
                            'change': {
                                fn: function (comboField, newValue) {
                                }, scope: this
                            }
                        }
                    },
      {xtype: 'combobox', fieldLabel: 'Status', name: 'status', value: 'Active',
       store: new Ext.data.SimpleStore({
       		data: [['Active'],['Inactive']], fields: ['status']
			 }),
       valueField: 'status', displayField: 'status', emptyText: 'Pilih Status',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true); comboField.expand();}, scope: this}
       }, anchor: '70%'
      }
		],
    buttons: [
    	{text: 'Simpan',
       handler: function() {
  			// this function before action
    		Ext.getCmp('form_user').on({
    			beforeaction: function() {Ext.getCmp('winUser').body.mask(); Ext.getCmp('sbWin').showBusy();}
    		});

        form_user.getForm().submit({            			
        	success: function(){          					
          	form_user.getForm().reset(); win_popup.close(); DataUsers.load();
          },
          failure: function(form, action){
          	Ext.getCmp('winUser').body.unmask();
          	if (action.failureType == 'server') {
          		obj = Ext.decode(action.response.responseText);
          		Ext.getCmp('sbWin').setStatus({text: obj.errors.reason, iconCls: 'x-status-error'});
          	}else{
          		if (typeof(action.response) == 'undefined') {
          			Ext.getCmp('sbWin').setStatus({text: 'Silahkan isi dengan benar !', iconCls: 'x-status-error'});
          		}else{
          			Ext.getCmp('sbWin').setStatus({text: 'Server tidak dapat dihubungi !', iconCls: 'x-status-error'});
          		}
          	}
          }
  			});
       }
      },
      {text: 'Batal', handler: function() {form_user.getForm().reset(); win_popup.close();}}
    ]
	});
			
	var win_popup = new Ext.create('Ext.Window', {
		id: 'winUser', title: 'FORM PENGGUNA LOGIN', iconCls: 'icon-user',
		modal : true, constrainHeader : true, closable: true,
		width: 400, height: 380, bodyStyle: 'padding: 5px;',				
		items: [form_user],
		bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin', iconCls: 'x-status-valid'})
	}).show();
		
	if(mode == 'Ubah'){			
		form_user.getForm().setValues(value_form);
	}		

	Ext.getCmp('items-body').body.unmask();
}
// FUNCTION FORM PENGGUNA LOGIN ------------------------------------------- END

// POPUP REFERENSI PEGAWAI ---------------------------------------------------- START
function Show_Popup_RefPegawai_User(form_parent){
	Ext.define('MSearch_RefPegawai_User', {extend: 'Ext.data.Model',
    fields: ['ID_Pegawai', 'NIP', 'f_namalengkap', 'nama_jab', 'nama_unor', 'nama_unker']
	});
	var Reader_Search_RefPegawai_User = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefPegawai_User', root: 'results', totalProperty: 'total', idProperty: 'ID_Pegawai'  	
	});
	var Proxy_Search_RefPegawai_User = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_pegawai', actionMethods: {read:'POST'}, extraParams :{id_open:1, sPgwPilih: 'Struktural, Fungsional Umum'}, reader: Reader_Search_RefPegawai_User
	});
	var Data_Search_RefPegawai_User = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefPegawai_User', model: 'MSearch_RefPegawai_User', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefPegawai_User
	});

	var Search_RefPegawai_User = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPegawai_User', store: Data_Search_RefPegawai_User, emptyText: 'Ketik di sini untuk pencarian NIP atau Nama', width: 550});
	var tbSearch_RefPegawai_User = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPegawai_User',
	items:[
		Search_RefPegawai_User, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_pegawai',
		 handler: function(){
		 		var sm = grid_Search_RefPegawai_User.getSelectionModel(), sel = sm.getSelection();
  			if(sel.length == 1){
  				form_parent.getForm().setValues({
  					NIP: sel[0].get('NIP'), fullname: sel[0].get('f_namalengkap'), nama_unor: sel[0].get('nama_unor'), nama_unker: sel[0].get('nama_unker')
  				});
  				win_popup_RefPegawai_User.close();
  			}else{
  				Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
  			}
		 }
		}
  ]
	});
	
	var filters_Search_RefPegawai_User = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefPegawai_User,
    filters: [
    	{type: 'string', dataIndex: 'NIP'},
    	{type: 'string', dataIndex: 'f_namalengkap'},
    	{type: 'string', dataIndex: 'nama_jab'},
    	{type: 'string', dataIndex: 'nama_unor'},
    	{type: 'string', dataIndex: 'nama_unker'}
    ]
	});
	
	var cbGrid_Search_RefPegawai_User = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefPegawai_User = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefPegawai_User', store: Data_Search_RefPegawai_User, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPegawai_User, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "NIP", dataIndex: 'NIP', width: 135}, 
  		{header: "Nama Lengkap", dataIndex: 'f_namalengkap', width: 150},
  		{header: "Jabatan", dataIndex: 'nama_jab', width: 125},
  		{header: "Unit-Kerja", dataIndex: 'nama_unor', width: 150},
  		{header: "Unit-Organisasi", dataIndex: 'nama_unker', width: 150}
  	], 
	  features: [filters_Search_RefPegawai_User],
  	bbar: tbSearch_RefPegawai_User,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPegawai_User, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_pegawai').handler.call(Ext.getCmp("PILIH_pegawai").scope);
  		}
  	}
	});

	var win_popup_RefPegawai_User = new Ext.create('widget.window', {
   	id: 'win_popup_RefPegawai_User', title: 'Referensi Pegawai', iconCls: 'icon-human',
   	modal:true, plain:true, closable: true, width: 650, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefPegawai_User]
	}).show();
}
// POPUP REFERENSI PEGAWAI ---------------------------------------------------- END

function User_Cari_Pgw(NIP_z, form_parent){
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
    				fullname: obj.results.f_namalengkap,
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

// FUNCTION TAMBAH PENGGUNA LOGIN ----------------------------------------- START
function addUsers() {		
	show_formUsers('Tambah','');
}
// FUNCTION TAMBAH PENGGUNA LOGIN ----------------------------------------- END
	
// FUNCTION UBAH PENGGUNA LOGIN ------------------------------------------- START
function updateUsers() {	
	var sm = gridUsers.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
    
  	var value_form = { 
    	ID_User: sel[0].get('ID_User'), 
    	NIP: sel[0].get('NIP'), 
    	user: sel[0].get('user'),
    	fullname: sel[0].get('fullname'),
    	nama_unor: (sel[0].get('nama_unor')!==null ? sel[0].get('nama_unor') : sel[0].get('temp_kode_unor')),
    	nama_unker: (sel[0].get('nama_unker')!==null ? sel[0].get('nama_unker') : sel[0].get('temp_kode_unor')),
    	email: sel[0].get('email'),
    	type: sel[0].get('type'),
    	group: sel[0].get('group'),
    	status: sel[0].get('status')
   };
   show_formUsers('Ubah',value_form);    	
	}		
}
// FUNCTION UBAH PENGGUNA LOGIN ------------------------------------------ END
	
// FUNCTION HAPUS PENGGUNA LOGIN ----------------------------------------- START
function deleteUsers() {	
	var sm = gridUsers.getSelectionModel(), sel = sm.getSelection(), data = '';
        if(sel.length > 0){
            Ext.Msg.show({
                title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
                fn: function(btn) {
                  if (btn == 'yes') {
                          for (i = 0; i < sel.length; i++) {
                          data = data + sel[i].get('ID_User') + '-';
                                                  }
                                                  Ext.Ajax.request({
                          url: BASE_URL + 'pengguna_login/ext_delete', method: 'POST',
                          params: { postdata: data }, scripts: true, renderer: 'data',
                          success: function(response){
                                          DataUsers.load();
                          },
                          failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal Menghapus Data !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); },
                          scope : this
                    });      			
                  }
                }
            });
        }
}
// FUNCTION HAPUS PENGGUNA LOGIN ----------------------------------------- END
	
// FUNCTION UBAH KATA SANDI ---------------------------------------------- START
function changePass() {			
    var sm = gridUsers.getSelectionModel();
    var sel = sm.getSelection();
    if(sel.length == 1){
			
			Ext.getCmp('items-body').body.mask("Loading...", "x-mask-loading");	
			
    	// Add the additional 'advanced' VTypes
    	Ext.apply(Ext.form.field.VTypes, {
        password: function(val, field) {
            if (field.initialPassField) {
                var pwd = field.up('form').down('#' + field.initialPassField);
                return (val == pwd.getValue());
            }
            return true;
        },

        passwordText: 'Konfirmasi Kata Sandi tidak sesuai'
    	});

			var form_changepass = new Ext.create('Ext.form.Panel', {
       	id: 'frmchangepass', url: BASE_URL + 'pengguna_login/ext_changepass',
        frame: true, bodyStyle: 'padding: 5px 5px 0 0',
        width: '100%', height: '100%',
        fieldDefaults: {
        		labelAlign: 'right',
            msgTarget: 'side',
            labelWidth: 120
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%',
            allowBlank: false
        },

        items: [{
            name: 'ID_User',
            xtype: 'hidden'
        },{
            fieldLabel: 'Kata Sandi Baru',
            name: 'pass', id: 'pass',
            inputType: 'password'
        },{
            fieldLabel: 'Konfirmasi Kata Sandi',
            name: 'pass-cfrm',
            inputType: 'password',
            vtype: 'password',
            initialPassField: 'pass'
        }],
        buttons: [{
            text: 'Simpan',
            handler: function() {
  						// this function before action
    					Ext.getCmp('frmchangepass').on({
    						beforeaction: function() {
      						Ext.getCmp('winchangepass').body.mask();
        					Ext.getCmp('sbWinchangepass').showBusy();
      					}
    					});

            	form_changepass.getForm().submit({            			
          				success: function(){          					
            				form_changepass.getForm().reset(); win_popup_changepass.close(); DataUsers.load();
          				},
          				failure: function(form, action){
          					Ext.getCmp('winchangepass').body.unmask();
          					if (action.failureType == 'server') {
          						obj = Ext.decode(action.response.responseText);
          						Ext.getCmp('sbWinchangepass').setStatus({
          							text: obj.errors.reason,
          							iconCls: 'x-status-error'
          						});
          					}else{
          						if (typeof(action.response) == 'undefined') {
          							Ext.getCmp('sbWinchangepass').setStatus({
          								text: 'Silahkan isi dengan benar !',
          								iconCls: 'x-status-error'
          							});
          						}else{
          							Ext.getCmp('sbWinchangepass').setStatus({
          								text: 'Server tidak dapat dihubungi !',
          								iconCls: 'x-status-error'
          							});
          						}
          					}
          				}
          		});
            }
        },{
            text: 'Batal',
            handler: function() {
            	form_changepass.getForm().reset(); 
            	win_popup_changepass.close();
            }
        }]				
			});
			
			var win_popup_changepass = new Ext.create('Ext.Window', {
				id: 'winchangepass', title: 'UBAH KATA SANDI', iconCls: 'icon-key',
				constrainHeader : true,
				closable: true,
				width: 350,
				height: 180,
				bodyStyle: 'padding: 5px;',
				modal : true,
				items: [form_changepass],
				bbar: new Ext.ux.StatusBar({
    			text: 'Ready',
      		id: 'sbWinchangepass',
      		iconCls: 'x-status-valid'
    		})
			});
		
			win_popup_changepass.show();

    	var id_val = {ID_User: sel[0].get('ID_User')};    	
			form_changepass.getForm().setValues(id_val);
			
			Ext.getCmp('items-body').body.unmask();			
    }		    
}
	// FUNCTION UBAH KATA SANDI ----------------------------------------------- END

// FORM AKSES MENU ---------------------------------------------------------- START
function show_form_Akses_Menu(){
  var sm = gridUsers.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){  
  	Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
		var new_page_id = Ext.getCmp('akses_menu_popup');
		var ID_User = sel[0].get('ID_User');
		var NIP = sel[0].get('NIP');
		var fullname = sel[0].get('fullname');
		if(new_page_id){
			Ext.getCmp('layout-body').body.unmask();
		}else{
			Ext.Ajax.request({
  			url: BASE_URL + 'pengguna_login/akses_menu_popup',
    		method: 'POST', params: {id_open: 1, ID_User:ID_User, NIP:NIP, fullname:fullname},
    		scripts: true, renderer: 'data',
    		success: function(response){    	
    			var jsonData = response.responseText; var aHeadNode = document.getElementsByTagName('head')[0]; var aScript = document.createElement('script'); aScript.text = jsonData; aHeadNode.appendChild(aScript);
    			if(win_popup_Akses_Menu != "GAGAL"){
    				win_popup_Akses_Menu.show();
    			}else{
    				Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
    			}
   			},
    		failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    		callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
    		scope : this
			});
		}
	}
}
// FORM AKSES MENU ---------------------------------------------------------- END

//MENU

function showMenuForm(mode,value_form) {
    var formManipulasiMenu = Ext.create('Ext.form.Panel',{
            id:'formManipulasiMenu',
            bodyPadding: 5,
            flex:1,
            url: BASE_URL + 'pengguna_login/ext_insert_menu',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            defaultType: 'textfield',
            labelAlign:'top',
            items: [
                    {
                        fieldLabel: 'Parent',
                        name: 'parent_idmenu',
                        xtype:'combobox',
                        valueField: 'idmenu',
                        value:0,
                        displayField: 'general_text',
                        emptyText: 'Pilih Induk Menu',
                        typeAhead: true,
                        forceSelection: false,
                        selectOnFocus: true,
                        valueNotFoundText: 'Pilih Induk Menu',
                        queryMode: 'local',
                        store:new Ext.data.Store({
                            noCache: false,
                            autoLoad: true,
                            proxy: {
                                type: 'ajax',
                                actionMethods: {read:'POST'},
                                extraParams :{id_open: '1', combox:'1'},
                                url: BASE_URL + 'pengguna_login/ext_get_all_menu',
                                reader: {
                                    type: 'json',
                                    root: 'results',
                                    totalProperty: 'total',
                                    idProperty: 'idmenu' 
                                }
                            },
                            fields: ['idmenu', 'general_text']
                        }),
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            },
                            'change': {
                                fn: function (comboField, newValue) {
                                }, scope: this
                            }
                        }
                    },{
                        fieldLabel: 'ID Menu',
                        name: 'idmenu',
                        value:0,
                        readOnly:true,
                        allowBlank: true
                    },{
                        fieldLabel: 'Text',
                        name: 'general_text',
                        allowBlank: false
                    },{
                        fieldLabel: 'Icon Class',
                        name: 'general_iconclass',
                        allowBlank: false
                    },{
                        fieldLabel: 'ID Button',
                        name: 'general_idbutton',
                        allowBlank: false
                    },{
                        fieldLabel: 'ID New Tab / PopUp',
                        name: 'general_idnewtab_popup',
                        allowBlank: true
                    },{
                        fieldLabel: 'URL',
                        name: 'general_url',
                        allowBlank: true
                    },{
                        fieldLabel: 'Type',
                        xtype: 'combobox',
                        value: 'TabPage',
                        store: new Ext.data.SimpleStore({
                            data: [['MainMenu'],['TabPage'],['Page'],['PopUp']], fields: ['type']
                        }),
                        typeAhead: true,
                        forceSelection: true,
                        valueField: 'type',
                        displayField: 'type',
                        name: 'general_type',
                        allowBlank: false,
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            }
                        }
                    },{
                        fieldLabel: 'Bottom Break',
                        name: 'general_bottombreak',
                        xtype:'checkbox'
                    },{
                        fieldLabel: 'Is Menu',
                        name: 'general_ismenu',
                        xtype:'checkbox'
                    },{
                        fieldLabel: 'Variable Prefix',
                        name: 'general_variableprefix',
                        allowBlank: true
                    },{
                        fieldLabel: 'Status',
                        xtype: 'combobox',
                        value: 'Active',
                        store: new Ext.data.SimpleStore({
                            data: [['Active'],['Inactive']], fields: ['status']
                        }),
                        typeAhead: true,
                        forceSelection: true,
                        valueField: 'status',
                        displayField: 'status',
                        name: 'general_status',
                        allowBlank: false,
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            }
                        }
                    },{
                        xtype:'fieldcontainer',
                        fieldLabel:'Proses',
                        layout:'hbox',
                        defaults:{
                            margins:4,
                            flex:1,
                            xtype:'checkbox',
                            labelAlign:'top'
                        },
                        items:[
                            {
                                fieldLabel:'View',
                                name:'process_view'
                            },{
                                fieldLabel:'Tambah',
                                name:'process_tambah'
                            },{
                                fieldLabel:'Ubah',
                                name:'process_ubah'
                            },{
                                fieldLabel:'Hapus',
                                name:'process_hapus'
                            },{
                                fieldLabel:'Proses',
                                name:'process_proses'
                            },{
                                fieldLabel:'Cetak',
                                name:'process_cetak'
                            },{
                                fieldLabel:'Cetak SK',
                                name:'process_cetaksk'
                            }
                        ]
                    }
            ],
            buttons:[
                {
                    text:'Simpan',
                    formBind: true,
                    disabled: true,
                    handler:function(){
                        var form = this.up('form').getForm();
                        if (form.isValid()) {
                            Ext.getCmp('windowManipulasiFormMenu').body.mask('Loading...');
                            form.submit({
                                success: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormMenu').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    if(obj.success==true){
                                        Ext.Msg.alert('Success', 'Berhasil Memanipulasi Menu');
                                    }else{
                                         Ext.Msg.alert('Failed', obj.errors.reason);   
                                    }
                                     Ext.getCmp('windowManipulasiFormMenu').destroy();
                                     DataMenu.load();
                                },
                                failure: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormMenu').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    Ext.Msg.alert('Failed', obj.errors.reason);
                                    Ext.getCmp('windowManipulasiFormMenu').destroy();
                                    DataMenu.load();
                                }
                            });
                        }
                    }
                }
            ]
    });

    var windowManipulasiFormMenu = new Ext.create('Ext.window.Window', {
        id:'windowManipulasiFormMenu',
        title:'Manipulasi Menu',
        iconCls: 'icon-user',
        modal : true,
        constrainHeader : true,
        closable: true,
        width: 600,
        height: 490,
        bodyStyle: 'padding: 5px;',
        items: [formManipulasiMenu],
        bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_windowManipulasiFormMenu', iconCls: 'x-status-valid'})
    }).show();
    
    if(mode == 'Ubah'){
        formManipulasiMenu.getForm().setValues(value_form);
    }
}

Ext.define('MMenu', {
    extend: 'Ext.data.Model',
    fields: [
        'idmenu', 'parent_text', 'parent_idmenu', 'general_ismenu', 'general_text', 'general_iconclass', 'general_idbutton', 'general_idnewtab_popup',
        'general_url', 'general_type', 'general_bottombreak', 'general_variableprefix', 'general_status', 'process_view', 'process_tambah', 'process_ubah', 'process_hapus', 'process_proses', 'process_cetak', 'process_cetaksk'
    ]
});

var dataReader = new Ext.create('Ext.data.JsonReader', {
    id: 'dataReaderMenu', root: 'results', totalProperty: 'total', idProperty: 'idmenu'
});
	
var dataProxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'dataProxyMenu', url: BASE_URL + 'pengguna_login/ext_get_all_menu', actionMethods: {read:'POST'}, extraParams :{id_open: '1'},
    reader: dataReader,
    afterRequest: function(request, success) {
    }
});

var DataMenu = new Ext.create('Ext.data.Store', {
        groupField: 'parent_idmenu',
	id: 'DataMenu', model: 'MMenu', pageSize: 100000000000000000000, autoLoad: true, proxy: dataProxy
});

var groupingFeatureMenu = Ext.create('Ext.grid.feature.Grouping',{
    groupHeaderTpl: 'Parent Menu : <span style="color:red !important;">{[values.rows[0].parent_text_idcolomns]}</span> ({rows.length} Item{[values.rows.length > 1 ? "s" : ""]})'
});

var cbGridMenu = new Ext.create('Ext.selection.CheckboxModel');
var gridMENU = new Ext.create('Ext.grid.Panel', {
    id: 'gridMENU', store: DataMenu, title: 'DAFTAR MENU', 
    frame: true, border: true, loadMask: true,     
    style: 'margin:0 auto;', height: '100%', width: '100%',
    selModel: cbGridMenu, columnLines: true,
    invalidateScrollerOnRefresh: false,
    columns: [
        {header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{
            header: "Parent", columns:[
                {header: "ID Menu", dataIndex: 'parent_idmenu', width:80},
                {header: "Text", dataIndex: 'parent_text', width:80, id:'parent_text_idcolomns'}
            ]
        },
        {
            header:'General', columns:[
                {header: "ID Menu", dataIndex: 'idmenu', width:80},
                {header: "Text", dataIndex: 'general_text', width:80},
                {header: "Icon Class", dataIndex: 'general_iconclass', width:80},
                {header: "Id Button", dataIndex: 'general_idbutton', width:80},
                {header: "Id New Tab / PopUp", dataIndex: 'general_idnewtab_popup', width:80},
                {header: "URL", dataIndex: 'general_url', width:80},
                {header: "Type", dataIndex: 'general_type', width:80},
                {header: "Bottom Break", dataIndex: 'general_bottombreak', width:80, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Status", dataIndex: 'general_status', width:80},
                {header: "Variable Prefix", dataIndex: 'general_variableprefix', width:80},
                {header: "Is Menu", dataIndex: 'general_ismenu', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
            ]  
        },
  	{
            header: "Process", columns:[
                {header: "View", dataIndex: 'process_view', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Tambah", dataIndex: 'process_tambah', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Ubah", dataIndex: 'process_ubah', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Hapus", dataIndex: 'process_hapus', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Proses", dataIndex: 'process_proses', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Cetak", dataIndex: 'process_cetak', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
                {header: "Cetak SK", dataIndex: 'process_cetaksk', width:50, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }}
            ]
        }
    ],
    tbar: [
        {
            text: 'Tambah', id: 'tambah_menu', iconCls: 'icon-add', handler: function(){
                showMenuForm('Tambah','');
            }, disabled: pl_insert
        },'-', 
  	{
            text: 'Ubah', id: 'ubah_menu', iconCls: 'icon-edit', handler: function(){
                var sm = gridMENU.getSelectionModel(), sel = sm.getSelection();
                if(sel.length == 1){
                    var value_form = { 
                          parent_idmenu: sel[0].get('parent_idmenu'), 
                          idmenu: sel[0].get('idmenu'),
                          general_text: sel[0].get('general_text'),
                          general_iconclass: sel[0].get('general_iconclass'),
                          general_idbutton: sel[0].get('general_idbutton'),
                          general_idnewtab_popup: sel[0].get('general_idnewtab_popup'),
                          general_url: sel[0].get('general_url'),
                          general_type: sel[0].get('general_type'),
                          general_bottombreak: sel[0].get('general_bottombreak'),
                          general_status: sel[0].get('general_status'),
                          general_variableprefix: sel[0].get('general_variableprefix'),
                          general_ismenu: sel[0].get('general_ismenu'),
                          process_view: sel[0].get('process_view'),
                          process_tambah: sel[0].get('process_tambah'),
                          process_ubah: sel[0].get('process_ubah'),
                          process_hapus: sel[0].get('process_hapus'),
                          process_proses: sel[0].get('process_proses'),
                          process_cetak: sel[0].get('process_cetak'),
                          process_cetaksk: sel[0].get('process_cetaksk')
                    };
                    showMenuForm('Ubah',value_form);
                }
            }, disabled: pl_update
        },'-', 
  	{
            text: 'Hapus', iconCls: 'icon-delete', handler: function(){
        
            }, disabled: pl_delete
        }
    ],
    viewConfig: { 
        stripeRows: false, 
        getRowClass: function(record) { 
            return record.get('general_status').toLowerCase()=='inactive' ? 'child-row' : ''; 
        } 
    },
    features: [groupingFeatureMenu],
    dockedItems: [{xtype: 'pagingtoolbar', store: DataMenu, dock: 'bottom', displayInfo: true}],
    listeners: {
        itemdblclick: function(dataview, record, item, index, e) {
            Ext.getCmp('ubah_menu').handler.call(Ext.getCmp("ubah_menu").scope);
	}
    }    
});
//end MENU

//GROUP
function showGroupForm(mode,value_form) {
    var formManipulasiGroup = Ext.create('Ext.form.Panel',{
            id:'formManipulasiGroup',
            bodyPadding: 5,
            flex:1,
            url: BASE_URL + 'pengguna_login/ext_insert_group',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            defaultType: 'textfield',
            labelAlign:'top',
            items: [
                    {
                        fieldLabel: 'ID Pemetaan Group',
                        name: 'ID_Group_Menu',
                        allowBlank: true,
                        value:0,
                        readOnly:true
                    },{
                        fieldLabel: 'Group',
                        name: 'ID_Group_Menu_ID_Group',
                        xtype:'combobox',
                        valueField: 'id_groupcollections',
                        displayField: 'general_group_name',
                        emptyText: 'Pilih Group',
                        typeAhead: true,
                        forceSelection: false,
                        selectOnFocus: true,
                        valueNotFoundText: 'Pilih Group',
                        queryMode: 'local',
                        store:new Ext.data.Store({
                            noCache: false,
                            autoLoad: true,
                            proxy: {
                                type: 'ajax',
                                actionMethods: {read:'POST'},
                                extraParams :{id_open: '1'},
                                url: BASE_URL + 'pengguna_login/ext_get_all_groupcollections',
                                reader: {
                                    type: 'json',
                                    root: 'results',
                                    totalProperty: 'total',
                                    idProperty: 'id_groupcollections' 
                                }
                            },
                            fields: ['id_groupcollections', 'general_group_name']
                        }),
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            },
                            'change': {
                                fn: function (comboField, newValue) {
                                }, scope: this
                            }
                        }
                    },{
                        fieldLabel: 'Menu',
                        name: 'ID_Group_Menu_ID_Menu',
                        xtype:'combobox',
                        valueField: 'idmenu',
                        displayField: 'general_text',
                        emptyText: 'Pilih Menu',
                        typeAhead: true,
                        forceSelection: false,
                        selectOnFocus: true,
                        valueNotFoundText: 'Pilih Menu',
                        queryMode: 'local',
                        store:new Ext.data.Store({
                            noCache: false,
                            autoLoad: true,
                            proxy: {
                                type: 'ajax',
                                actionMethods: {read:'POST'},
                                extraParams :{id_open: '1'},
                                url: BASE_URL + 'pengguna_login/ext_get_all_menu',
                                reader: {
                                    type: 'json',
                                    root: 'results',
                                    totalProperty: 'total',
                                    idProperty: 'idmenu' 
                                }
                            },
                            fields: [
                                'idmenu', 'parent_text', 'parent_idmenu', 'general_ismenu', 'general_text', 'general_iconclass', 'general_idbutton', 'general_idnewtab_popup',
                                'general_url', 'general_type', 'general_bottombreak', 'general_variableprefix', 'general_status', 'process_view', 'process_tambah', 'process_ubah', 'process_hapus', 'process_proses', 'process_cetak', 'process_cetaksk'
                            ]
                        }),
                        listeners: {
                            'focus': {
                                fn: function (comboField) {
                                    comboField.doQuery(comboField.allQuery, true);
                                    comboField.expand();
                                }, scope: this
                            },
                            'change': {
                                fn: function (comboField, newValue) {
                                    var tempData = comboField.findRecordByValue(newValue).data;
                                    if (tempData) {
                                        var temp_formManipulasiGroup = Ext.getCmp('formManipulasiGroup').getForm();
                                        temp_formManipulasiGroup.findField('u_access').setVisible(parseInt(tempData.process_view));
                                        temp_formManipulasiGroup.findField('u_insert').setVisible(parseInt(tempData.process_tambah));
                                        temp_formManipulasiGroup.findField('u_update').setVisible(parseInt(tempData.process_ubah));
                                        temp_formManipulasiGroup.findField('u_delete').setVisible(parseInt(tempData.process_hapus));
                                        temp_formManipulasiGroup.findField('u_proses').setVisible(parseInt(tempData.process_proses));
                                        temp_formManipulasiGroup.findField('u_print').setVisible(parseInt(tempData.process_cetak));
                                        temp_formManipulasiGroup.findField('u_print_sk').setVisible(parseInt(tempData.process_cetaksk));
                                    }
                                }, scope: this
                            }
                        }
                    },{
                        xtype:'fieldcontainer',
                        fieldLabel:'Proses',
                        layout:'hbox',
                        defaults:{
                            margins:4,
                            flex:1,
                            xtype:'checkbox',
                            labelAlign:'top'
                        },
                        items:[
                            {
                                fieldLabel:'View',
                                name:'u_access'
                            },{
                                fieldLabel:'Tambah',
                                name:'u_insert'
                            },{
                                fieldLabel:'Ubah',
                                name:'u_update'
                            },{
                                fieldLabel:'Hapus',
                                name:'u_delete'
                            },{
                                fieldLabel:'Proses',
                                name:'u_proses'
                            },{
                                fieldLabel:'Cetak',
                                name:'u_print'
                            },{
                                fieldLabel:'Cetak SK',
                                name:'u_print_sk'
                            }
                        ]
                    }
            ],
            buttons:[
                {
                    text:'Simpan',
                    formBind: true,
                    disabled: true,
                    handler:function(){
                        var form = this.up('form').getForm();
                        if (form.isValid()) {
                            Ext.getCmp('windowManipulasiFormGroup').body.mask('Loading...');
                            form.submit({
                                success: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormGroup').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    if(obj.success==true){
                                        Ext.Msg.alert('Success', 'Berhasil Memanipulasi Group');
                                    }else{
                                         Ext.Msg.alert('Failed', obj.errors.reason);   
                                    }
                                     Ext.getCmp('windowManipulasiFormGroup').destroy();
                                     DataGroup.load();
                                     Load_Variabel(BASE_URL + 'user/set_var_access');
                                },
                                failure: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormGroup').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    Ext.Msg.alert('Failed', obj.errors.reason);
                                    Ext.getCmp('windowManipulasiFormGroup').destroy();
                                    DataGroup.load();
                                }
                            });
                        }
                    }
                }
            ]
    });

    var windowManipulasiFormGroup = new Ext.create('Ext.window.Window', {
        id:'windowManipulasiFormGroup',
        title:'Manipulasi Pementaan Group & Menu',
        iconCls: 'icon-user',
        modal : true,
        constrainHeader : true,
        closable: true,
        width: 600,
        height: 250,
        bodyStyle: 'padding: 5px;',
        items: [formManipulasiGroup],
        bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_windowManipulasiFormGroup', iconCls: 'x-status-valid'})
    }).show();
    
    if(mode == 'Ubah'){
        formManipulasiGroup.getForm().setValues(value_form);
    }
}

Ext.define('MGroup', {
    extend: 'Ext.data.Model',
    fields: [
        'ID_Group_Menu', 'general_group_name', 'general_group_active', 'u_access', 'u_insert', 'u_update', 'u_delete', 'u_proses',
        'u_print', 'u_print_sk', 'ID_Group_Menu_ID_Menu', 'parent_text', 'parent_idmenu', 'ID_Group_Menu_ID_Group', 'ID_Group_Menu_ID_Group', 'general_text'
    ]
});

var dataReaderGroup = new Ext.create('Ext.data.JsonReader', {
    id: 'dataReaderGroupGroup', root: 'results', totalProperty: 'total', idProperty: 'ID_Group_Menu'
});
	
var dataProxyGroup = new Ext.create('Ext.data.AjaxProxy', {
    id: 'dataProxyGroupGroup', url: BASE_URL + 'pengguna_login/ext_get_all_group', actionMethods: {read:'POST'}, extraParams :{id_open: '1'},
    reader: dataReaderGroup,
    afterRequest: function(request, success) {
    }
});

var groupingFeatureGroup = Ext.create('Ext.grid.feature.Grouping',{
    groupHeaderTpl: 'Parent Menu : <span style="color:red !important;">{[values.rows[0].parent_text_idcolomns_group]}</span> ({rows.length} Item{[values.rows.length > 1 ? "s" : ""]})'
});

var DataGroup = new Ext.create('Ext.data.Store', {
    groupField: 'parent_idmenu',
    id: 'DataGroup', model: 'MGroup', pageSize: 100000000000000000000, autoLoad: true, proxy: dataProxyGroup
});

var cbGridGroup = new Ext.create('Ext.selection.CheckboxModel');
var gridGROUP = new Ext.create('Ext.grid.Panel', {
    id: 'gridGROUP', store: DataGroup, title: 'DAFTAR PEMETAAN GROUP & MENU', 
    frame: true, border: true, loadMask: true,     
    style: 'margin:0 auto;', height: '100%', width: '100%',
    selModel: cbGridGroup, columnLines: true,
    invalidateScrollerOnRefresh: false,
    columns: [
        {header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "ID Group", dataIndex: 'ID_Group_Menu_ID_Group', flex:1},
  	{header: "Group Name", dataIndex: 'general_group_name', flex:1},
  	{header: "ID Menu", dataIndex: 'ID_Group_Menu_ID_Menu', flex:1},
        {header: "Parent Menu Name", dataIndex: 'parent_text', flex:1, id:'parent_text_idcolomns_group'},
  	{header: "Menu Name", dataIndex: 'general_text', flex:1},
  	{header: "View", dataIndex: 'u_access', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Tambah", dataIndex: 'u_insert', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Ubah", dataIndex: 'u_update', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Hapus", dataIndex: 'u_delete', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Proses", dataIndex: 'u_proses', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Cetak", dataIndex: 'u_print', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
  	{header: "Cetak SK", dataIndex: 'u_print_sk', width:60, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }},
    ],
    tbar: [
        {
            fieldLabel: 'Group', hideLabel:true, name: 'group_select_combobox', xtype:'combobox', id: 'group_select_combobox',
            valueField: 'id_groupcollections', displayField: 'general_group_name',emptyText: 'Pilih Group', value:0,
            typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Group',
            queryMode: 'local',
                store:new Ext.data.Store({
                        noCache: false, autoLoad: true,
                        proxy: {
                                type: 'ajax',
                                actionMethods: {read:'POST'},
                                extraParams :{id_open: '1', combox:'1'},
                                url: BASE_URL + 'pengguna_login/ext_get_all_groupcollections',
                                reader: {
                                        type: 'json',
                                        root: 'results',
                                        totalProperty: 'total', 
                                        idProperty: 'id_groupcollections' 
                                }
                        },
                        fields: ['id_groupcollections', 'general_group_name']
                }),
                listeners: {
                        'focus': {
                                fn: function (comboField) {
                                        comboField.doQuery(comboField.allQuery, true);
                                        comboField.expand();
                                }, scope: this
                        },
                        'change': {
                                fn: function (comboField, newValue) {
                                    DataGroup.getProxy().extraParams.id_groupcollections = newValue;
                                    DataGroup.load();
                                }, scope: this
                        }
                }
        },'-', {
            text: 'Tambah', id: 'tambah_group', iconCls: 'icon-add', handler: function(){
                showGroupForm('Tambah','');
            }, disabled: pl_insert
        },'-', 
  	{
            text: 'Ubah', id: 'ubah_group', iconCls: 'icon-edit', handler: function(){
                var sm = gridGROUP.getSelectionModel(), sel = sm.getSelection();
                if(sel.length == 1){
                    var value_form = { 
                          ID_Group_Menu: sel[0].get('ID_Group_Menu'), 
                          u_access: sel[0].get('u_access'), 
                          u_insert: sel[0].get('u_insert'), 
                          u_update: sel[0].get('u_update'), 
                          u_delete: sel[0].get('u_delete'), 
                          u_proses: sel[0].get('u_proses'), 
                          u_print: sel[0].get('u_print'), 
                          u_print_sk: sel[0].get('u_print_sk'), 
                          ID_Group_Menu_ID_Menu: sel[0].get('ID_Group_Menu_ID_Menu'), 
                          ID_Group_Menu_ID_Group: sel[0].get('ID_Group_Menu_ID_Group'), 
                    };
                    showGroupForm('Ubah',value_form);
                }
            }, disabled: pl_update
        },'-', 
  	{
            text: 'Hapus', iconCls: 'icon-delete', handler: function(){
        
            }, disabled: pl_delete
        },'-',{
            text:'Auto Sync Data', iconCls:'x-tbar-loading', handler: function(){
                Ext.Msg.show({
                    title: 'Konfirmasi', msg: 'Timpah Data Yang Sudah Ada?',
                    buttons: Ext.Msg.YESNO, icon: Ext.Msg.WARNING,
                    fn: function(btn) {
                        var timpah = 0;
                        if (btn == 'yes') {
                            timpah = 1;
                        }
                        
                        Ext.getBody().mask('Loading...');
                        
                        Ext.Ajax.request({
                            url: BASE_URL + 'pengguna_login/ext_sync_group', method: 'POST',
                            params: { id_open: 1, timpah:timpah }, scripts: true, renderer: 'data',
                            success: function(response){
                                 Ext.getBody().unmask();
                                DataGroup.load();
                            },
                            failure: function(response){
                                Ext.getBody().unmask();
                                Ext.MessageBox.show({
                                    title:'Peringatan !',
                                    msg:'Gagal Menghapus Data !',
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.ERROR
                                });
                            },
                            scope : this
                        });      
                    }
                });
            }, disabled: pl_insert
        }
    ],
    features: [groupingFeatureGroup],
    viewConfig: { 
        stripeRows: false, 
        getRowClass: function(record) { 
            return record.get('general_group_active')==0 ? 'child-row' : ''; 
        } 
    },
    dockedItems: [{xtype: 'pagingtoolbar', store: DataGroup, dock: 'bottom', displayInfo: true}],
    listeners: {
        itemdblclick: function(dataview, record, item, index, e) {
            Ext.getCmp('ubah_group').handler.call(Ext.getCmp("ubah_group").scope);
	}
    }    
});
//end GROUP

//GROUP COLLECTIONS

function showGroupCollectionsForm(mode,value_form) {
    var formManipulasiGroupCollections = Ext.create('Ext.form.Panel',{
            id:'formManipulasiGroupCollections',
            bodyPadding: 5,
            flex:1,
            url: BASE_URL + 'pengguna_login/ext_insert_groupcollections',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            defaultType: 'textfield',
            labelAlign:'top',
            items: [
                    {
                        fieldLabel: 'ID Group',
                        name: 'id_groupcollections',
                        value:0,
                        readOnly:true,
                        allowBlank: true
                    },{
                        fieldLabel: 'Group Name',
                        name: 'general_group_name',
                        allowBlank: false
                    },{
                        fieldLabel: 'Status Active',
                        name: 'general_group_active',
                        xtype:'checkbox'
                    }
            ],
            buttons:[
                {
                    text:'Simpan',
                    formBind: true,
                    disabled: true,
                    handler:function(){
                        var form = this.up('form').getForm();
                        if (form.isValid()) {
                            Ext.getCmp('windowManipulasiFormGroupCollections').body.mask('Loading...');
                            form.submit({
                                success: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormGroupCollections').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    if(obj.success==true){
                                        Ext.Msg.alert('Success', 'Berhasil Memanipulasi Koleksi Group');
                                    }else{
                                         Ext.Msg.alert('Failed', obj.errors.reason);   
                                    }
                                     Ext.getCmp('windowManipulasiFormGroupCollections').destroy();
                                     DataGroupCollections.load();
                                },
                                failure: function(form, action) {
                                    Ext.getCmp('windowManipulasiFormGroupCollections').body.unmask();
                                    obj = Ext.decode(action.response.responseText);
                                    Ext.Msg.alert('Failed', obj.errors.reason);
                                    Ext.getCmp('windowManipulasiFormGroupCollections').destroy();
                                    DataGroupCollections.load();
                                }
                            });
                        }
                    }
                }
            ]
    });

    var windowManipulasiFormGroupCollections = new Ext.create('Ext.window.Window', {
        id:'windowManipulasiFormGroupCollections',
        title:'Manipulasi GroupCollections',
        iconCls: 'icon-user',
        modal : true,
        constrainHeader : true,
        closable: true,
        width: 600,
        height: 200,
        bodyStyle: 'padding: 5px;',
        items: [formManipulasiGroupCollections],
        bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin_windowManipulasiFormGroupCollections', iconCls: 'x-status-valid'})
    }).show();
    
    if(mode == 'Ubah'){
        formManipulasiGroupCollections.getForm().setValues(value_form);
    }
}

Ext.define('MGroupCollections', {
    extend: 'Ext.data.Model',
    fields: [
        'id_groupcollections', 'general_group_name', 'general_group_active'
    ]
});

var dataReaderGroupCollections = new Ext.create('Ext.data.JsonReader', {
    id: 'dataReaderGroupCollectionsGroupCollections', root: 'results', totalProperty: 'total', idProperty: 'id_groupcollections'
});
	
var dataProxyGroupCollections = new Ext.create('Ext.data.AjaxProxy', {
    id: 'dataProxyGroupCollectionsGroupCollections', url: BASE_URL + 'pengguna_login/ext_get_all_groupcollections', actionMethods: {read:'POST'}, extraParams :{id_open: '1'},
    reader: dataReaderGroupCollections,
    afterRequest: function(request, success) {
    }
});

var DataGroupCollections = new Ext.create('Ext.data.Store', {
	id: 'DataGroupCollections', model: 'MGroupCollections', pageSize: 100000000000000000000, autoLoad: true, proxy: dataProxyGroupCollections
});

var cbGridGroupCollections = new Ext.create('Ext.selection.CheckboxModel');
var gridGROUPCOLLECTIONS = new Ext.create('Ext.grid.Panel', {
    id: 'gridGROUPCOLLECTIONS', store: DataGroupCollections, title: 'DAFTAR KOLEKSI GROUP', 
    frame: true, border: true, loadMask: true,     
    style: 'margin:0 auto;', height: '100%', width: '100%',
    selModel: cbGridGroupCollections, columnLines: true,
    invalidateScrollerOnRefresh: false,
    columns: [
        {header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
        {header: "ID Group", dataIndex: 'id_groupcollections', flex:1},
        {header: "Group Name", dataIndex: 'general_group_name', flex:1},
        {header: "Active", dataIndex: 'general_group_active', flex:1, renderer:function(v){ return ( v==1 ? 'Yes' : 'No' ) }}
    ],
    tbar: [
        {
            text: 'Tambah', id: 'tambah_groupcollections', iconCls: 'icon-add', handler: function(){
                showGroupCollectionsForm('Tambah','');
            }, disabled: pl_insert
        },'-', 
  	{
            text: 'Ubah', id: 'ubah_groupcollections', iconCls: 'icon-edit', handler: function(){
                var sm = gridGROUPCOLLECTIONS.getSelectionModel(), sel = sm.getSelection();
                if(sel.length == 1){
                    var value_form = { 
                          id_groupcollections: sel[0].get('id_groupcollections'), 
                          general_group_name: sel[0].get('general_group_name'), 
                          general_group_active: sel[0].get('general_group_active'), 
                    };
                    showGroupCollectionsForm('Ubah',value_form);
                }
            }, disabled: pl_update
        },'-', 
  	{
            text: 'Hapus', iconCls: 'icon-delete', handler: function(){
        
            }, disabled: pl_delete
        }
    ],
    viewConfig: { 
        stripeRows: false, 
        getRowClass: function(record) { 
            return record.get('general_group_active')==0 ? 'child-row' : ''; 
        } 
    },
    dockedItems: [{xtype: 'pagingtoolbar', store: DataGroupCollections, dock: 'bottom', displayInfo: true}],
    listeners: {
        itemdblclick: function(dataview, record, item, index, e) {
            Ext.getCmp('ubah_groupcollections').handler.call(Ext.getCmp("ubah_groupcollections").scope);
	}
    }    
});
//end GROUP COLLECTIONS
        	
	// PANEL UTAMA PENGGUNA LOGIN  -------------------------------------------- START
    var box_border = {
  	id: 'border-panel', layout: 'border', border: false, bodyBorder: false,
        defaults: {
            collapsible: true, split: true, animFloat: false, autoHide: false,
          useSplitTips: true, bodyStyle: 'padding: 0px;'
        },
    items:
    	[
            {
    		title: 'PETUNJUK !',
                region:'west', floatable: false, margins: '0 0 0 0', cmargins: '5 5 0 0',
                width: '25%', minSize: 100, maxSize: 250, iconCls: 'icon-information',
                items:[{
                    xtype : 'miframe', frame: false, height: '100%',
                    src : BASE_URL + 'pengguna_login/petunjuk'
                }]
    	},{
            region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '75%', border: false,
            items:[
                {
                    xtype:'tabpanel',
                    border:false,
                    items:[
                            gridUsers,
                            gridGROUPCOLLECTIONS,
                            gridMENU,
                            gridGROUP
                    ]
                }
            ]
    	}]
    };

	var newpanel = new Ext.create('Ext.panel.Panel',{
		id: 'pengguna_login', region: 'center', layout: 'card', title: 'PENGGUNA LOGIN', 
		border: true, iconCls: 'icon-user', closable: true,
  	items:[box_border], renderTo: 'items-body'
	});	
	// PANEL UTAMA PENGGUNA LOGIN  --------------------------------------------- END
	
<?php }else{ echo "var newpanel = 'GAGAL';"; } ?>


