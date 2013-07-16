<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// START - TABEL LOG
Ext.define('MLogs_User', {extend: 'Ext.data.Model',
  fields: ['ID_Log', 'logIP', 'logDateTime', 'logUser', 'Description']
});

var Reader_Logs_User = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Logs_User', root: 'results', totalProperty: 'total', idProperty: 'ID_Log'  	
});

var Proxy_Logs_User = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_Logs_User', url: BASE_URL + 'utility_simpeg/logs_user_data', actionMethods: {read:'POST'}, extraParams: {id_open:1},
  reader: Reader_Logs_User
});

var Data_Logs_User = new Ext.create('Ext.data.Store', {
	id: 'Data_Logs_User', model: 'MLogs_User', pageSize: 20, noCache: false, autoLoad: true,
  proxy: Proxy_Logs_User
});

var cbGrid_Logs_User = new Ext.create('Ext.selection.CheckboxModel');
var Grid_Logs_User = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_Logs_User', store: Data_Logs_User, frame: true, border: true, loadMask: true, noCache: false,
  style: 'margin:0 auto;', autoHeight: true, columnLines: true, selModel: cbGrid_Logs_User,
	columns: [
  	{header: "IP", dataIndex: 'logIP', width: 80}, 
  	{header: "Datetime", dataIndex: 'logDateTime', width: 120},
  	{header: "User", dataIndex: 'logUser', width: 100},
 		{header: "Description", dataIndex: 'Description', width: 350}
  ],
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Logs_User, dock: 'bottom', displayInfo: true}]
});
// END - TABEL LOG

// PANEL LOGS USER  -------------------------------------------- START
var Box_Logs_User = new Ext.create('Ext.panel.Panel', {
   id: 'Box_Logs_User', layout: 'border', width: '100%', height: '100%', bodyStyle: 'padding: 0px;', border: false,
   items: [
   	{id: 'East_Logs_User', title:'Life Logs', region: 'east', minWidth: 315, split: true, collapsible: true, collapseMode: 'mini',
   	 items: []
	  },
	  {id: 'Center_Logs_User', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '80%', border: false, bodyStyle: 'background-color:#DFE8F6',
	   items: [Grid_Logs_User]
	  }
   ]
});

var boxborder_Logs_User = new Ext.create('Ext.panel.Panel', {
   id: 'boxborder_Logs_User', title: 'LOG PENGGUNA', layout: 'border',
   width: '100%', height: '100%', bodyStyle: 'padding: 0px;',
   items: [
		{region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: false,
	   items: [Box_Logs_User]
		}
   ]
});

var new_tabpanel = {
	id: 'logs_user', title: 'Logs', iconCls: 'icon-menu_log_pengguna',  border: false, closable: true,  
	layout: 'fit', items: [boxborder_Logs_User]
}
// PANEL LOGS USER  -------------------------------------------- END


<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>