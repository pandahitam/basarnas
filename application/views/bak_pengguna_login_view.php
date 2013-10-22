<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
///////////
// TABEL PENGGUNA LOGIN  --------------------------------------------------------- START
var win_popup, newpanel;
var Params_User = null;

Ext.define('MUser', {
  extend: 'Ext.data.Model',
  fields: ['ID_User', 'NIP', 'user', 'fullname', 'email', 'registerDate', 'lastvisitDate', 'type', 'status', 'nama_unor', 'nama_unker']
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
  		{text: 'Tambah', id: 'tambah_user', iconCls: 'icon-useradd', handler: addUsers, disabled: false},'-', 
  		{text: 'Ubah', id: 'ubah_user', iconCls: 'icon-useredit', handler: updateUsers, disabled: false},'-', 
  		{text: 'Hapus', iconCls: 'icon-userdel', handler: deleteUsers, disabled: false},'-', 
  		{text: 'Ubah Kata Sandi', iconCls: 'icon-key', handler: changePass, disabled: false},'-', 
  		{text: 'Akses Menu', id: 'Btn_Akses_Menu', iconCls: 'icon-gears', handler: show_form_Akses_Menu, disabled: false},'-', 
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
    	{type: 'list', dataIndex: 'type', options: ['SUPER ADMIN', 'ADMIN', 'PENGELOLA ASSET', 'UNIT KERJA'], phpMode: true},
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
	  	{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 200}, 
	  	{header: "Unit Kerja", dataIndex: 'nama_unker', width: 200}, 
    	{header: "E-Mail", dataIndex: 'email', sortable: true, width: 150}, 
    	{header: "Tipe", dataIndex: 'type', sortable: true, width: 85}, 
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
      		{xtype: 'textfield', name: 'NIP', id: 'NIP_User', maxLength: 21, maskRe: /[\d\ \.\;]/, regex: /^[0-9]|\;*$/, margin: '0 2 0 0', flex:2,
	      	 listeners: {
	      			specialkey: function(f,e){
	      				if (e.getKey() == e.ENTER) {
	      					User_Cari_Pgw(Ext.getCmp('NIP_User').getValue(), form_user);
	      				}
	      			}
	      	 }
      		},
      		{xtype: 'button', name: 'search_pegawai', text: '...', 
      			handler: function(){
      				Show_Popup_RefPegawai_User(form_user);
      			}
          }
       ], anchor: '100%'
    	},
    	{fieldLabel: 'Nama Lengkap', name: 'fullname', id: 'fullname', allowBlank: false},
	    {xtype: 'textfield', fieldLabel: 'Unit Organisasi', name: 'nama_unor', id: 'nama_unor_user', readOnly: true, height: 22, anchor: '100%'},
	    {xtype: 'textareafield', fieldLabel: 'Unit Kerja', name: 'nama_unker', id: 'nama_unker_user', readOnly: true, height: 40, anchor: '100%'},
    	{fieldLabel: 'E-Mail', name: 'email', id: 'email_user', vtype:'email', allowBlank: true}, 
    	{xtype: 'combobox', fieldLabel: 'Tipe', name: 'type', value: 'OPD',
    	 store: new Ext.data.SimpleStore({
       		data: [['SUPER ADMIN'],['ADMIN'],['PENGELOLA ASSET'],['UNIT KERJA']], fields: ['type']
			 }),
       valueField: 'type', displayField: 'type', emptyText: 'Pilih Tipe',
       queryMode: 'local', typeAhead: true, forceSelection: true,
       listeners: {
       		'focus': {fn: function (comboField) {comboField.doQuery(comboField.allQuery, true);comboField.expand();}, scope: this}
       }, anchor: '70%'
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
  		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 150},
  		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 150}
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
    	nama_unor: sel[0].get('nama_unor'),
    	nama_unker: sel[0].get('nama_unker'),
    	email: sel[0].get('email'),
    	type: sel[0].get('type'),
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
        	
	// PANEL UTAMA PENGGUNA LOGIN  -------------------------------------------- START
	var box_border = {
  	id: 'border-panel', layout: 'border', border: false, bodyBorder: false,
    defaults: {
    	collapsible: true, split: true, animFloat: false, autoHide: false,
      useSplitTips: true, bodyStyle: 'padding: 0px;'
    },
    items:
    	[{
    		title: 'PETUNJUK !',
      	region:'west', floatable: false, margins: '0 0 0 0', cmargins: '5 5 0 0',
      	width: '25%', minSize: 100, maxSize: 250, iconCls: 'icon-information',
      	items:[{
      		xtype : 'miframe', frame: false, height: '100%',
      		src : BASE_URL + 'pengguna_login/petunjuk'
      	}]
    	},{
      	region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '75%', border: false,
      	items:[gridUsers]
    	}]
	};

	var newpanel = new Ext.create('Ext.panel.Panel',{
		id: 'pengguna_login', region: 'center', layout: 'card', title: 'PENGGUNA LOGIN', 
		border: true, iconCls: 'icon-user', closable: true,
  	items:[box_border], renderTo: 'items-body'
	});	
	// PANEL UTAMA PENGGUNA LOGIN  --------------------------------------------- END
	
<?php }else{ echo "var newpanel = 'GAGAL';"; } ?>


