<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

<?php 
echo "var ID_User =".$this->input->post('ID_User').";"; 
echo "var NIP ='".$this->input->post('NIP')."';"; 
echo "var fullname ='".$this->input->post('fullname')."';"; 
?>

// GRID AKSES MENU -------------------------------------------- START
Ext.define('MAkses_Menu', {extend: 'Ext.data.Model',
  fields: ['ID_User','ID_Menu','menu','parent_id','u_access','u_insert','u_update','u_delete','u_proses','u_print','u_print_sk']
});

var Reader_Akses_Menu = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Akses_Menu', root: 'children', idProperty: 'ID_User'
});

var Proxy_Akses_Menu = new Ext.create('Ext.data.AjaxProxy', {
	id: 'Proxy_Akses_Menu', url: BASE_URL + 'pengguna_login/ext_get_all_akses_menu', actionMethods: {read:'POST'}, extraParams :{id_open: '1', ID_User:ID_User},
  reader: Reader_Akses_Menu
});

var Store_Akses_Menu = Ext.create('Ext.data.TreeStore', {	
	id: 'Store_Akses_Menu', model: 'MAkses_Menu',
	proxy: Proxy_Akses_Menu, autoDestroy: true
});

var Select_Akses_Menu = new Ext.create('Ext.selection.TreeModel');

var Tree_Akses_Menu = Ext.create('Ext.tree.Panel', {
	id: 'Tree_Akses_Menu', title: 'MENU SIMPEG', width: 585, height: 350,
  useArrows: true, rootVisible: false, store: Store_Akses_Menu, cls: 'x-grid-cell',
	multiSelect: true, singleExpand: true, selModel: Select_Akses_Menu,
	columns: [
   	{xtype: 'treecolumn', text: 'MENU', width: 215, dataIndex: 'menu', sortable: true },
   	{xtype: 'checkcolumn', text: 'VIEW', width: 50, dataIndex: 'u_access', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}
   	 }
   	},
   	{xtype: 'checkcolumn', text: 'TAMBAH', width: 50, dataIndex: 'u_insert', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}   	 		
   	 }
   	},
   	{xtype: 'checkcolumn', text: 'UBAH', width: 50, dataIndex: 'u_update', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}
   	 }
   	},
   	{xtype: 'checkcolumn', text: 'HAPUS', width: 50, dataIndex: 'u_delete', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}
   	 }
   	},	
   	{xtype: 'checkcolumn', text: 'PROSES', width: 50, dataIndex: 'u_proses', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}   	 		
   	 }
   	},
   	{xtype: 'checkcolumn', text: 'CETAK', width: 50, dataIndex: 'u_print', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}   	 		
   	 }
   	},
   	{xtype: 'checkcolumn', text: 'CETAK SK', width: 60, dataIndex: 'u_print_sk', align: 'center', sortable: true,
   	 listeners: {
   	 		checkchange : function(column, recordIndex, checked) {
   	 			Simpan_Akses_Menu(column, recordIndex, checked);
   	 		}   	 		
   	 }
   	}
	],
	listeners: {
		containerclick: function(model, records) {
			Store_Akses_Menu.update();
		}
	}
});
// GRID AKSES MENU -------------------------------------------- END

// FUNCTION AKSES MENU ----------------------------------------------- START
function Simpan_Akses_Menu(column, recordIndex, checked){
	var record = Tree_Akses_Menu.getView().store.getAt(recordIndex);
	var ID_Menu = record.get('ID_Menu');
	var u_access = record.get('u_access');
	var u_insert = record.get('u_insert');
	var u_update = record.get('u_update');
	var u_delete = record.get('u_delete');
	var u_proses = record.get('u_proses');
	var u_print = record.get('u_print');
	var u_print_sk = record.get('u_print_sk');
  var m_ID_User = ID_User;
  
	Ext.Ajax.request({
  	url: BASE_URL + 'pengguna_login/ext_change_akses_menu',
    method: 'POST', params: {ID_User:m_ID_User, ID_Menu:ID_Menu, u_access:u_access, u_insert:u_insert, u_update:u_update, u_delete:u_delete, u_proses:u_proses, u_print:u_print, u_print_sk:u_print_sk},
    scripts: true, renderer: 'data',
    success: function(response){
    	Store_Akses_Menu.update();
   	},
    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); },
    scope : this
	});
}
// FUNCTION AKSES MENU ----------------------------------------------- END
    
// PANEL POPUP AKSES MENU -------------------------------------------- START
var win_popup_Akses_Menu = new Ext.create('widget.window', {
   id: 'akses_menu_popup', title: 'AKSES MENU (' + NIP + ' | ' + fullname + ')', iconCls: 'icon-gears',
   closable: true, width: 605, height: 400, modal:true,
   layout: 'fit', bodyStyle: 'padding: 5px;',
   items: [Tree_Akses_Menu]
});
// PANEL POPUP AKSES MENU -------------------------------------------- END

<?php }else{ echo "var win_popup_Akses_Menu = 'GAGAL';"; } ?>