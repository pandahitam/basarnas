<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Reward = '', Cur_Form_Caller_Reward = '', fmode = '';
var vaktif = 1;

// POPUP REFERENSI PENGHARGAAN ---------------------------------------------------- START
Ext.define('MSearch_RefReward', {extend: 'Ext.data.Model',
  fields: ['ID_Reward', 'kode_reward', 'nama_reward']
});
var Reader_Search_RefReward = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefReward', root: 'results', totalProperty: 'total', idProperty: 'ID_Reward'  	
});	
var Proxy_Search_RefReward = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_Search_RefReward', url: BASE_URL + 'browse_ref/ext_get_all_reward', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefReward
});
var Data_Search_RefReward = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefReward', model: 'MSearch_RefReward', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefReward
});

var Search_RefReward = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefReward', store: Data_Search_RefReward, emptyText: 'Ketik di sini untuk pencarian', width: 270});
var tbSearch_RefReward = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefReward',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_reward', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefReward(vaktif);
   	 	}
		 }
    }, 
    Search_RefReward, '->', 
    {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Reward',
		 handler: function(){SetTo_Form_Caller_Reward();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefReward.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefReward = new Ext.create('Ext.ux.grid.filter.Filter', {
  ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefReward,
  filters: [
   	{type: 'string', dataIndex: 'nama_reward'}
  ]
});

var cbGrid_Search_RefReward = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefReward = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefReward', store: Data_Search_RefReward, frame: true, border: true, loadMask: true,
 	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefReward, columnLines: true,
 	invalidateScrollerOnRefresh: false, 
	columns: [
 		{header: "Nama Penghargaan", dataIndex: 'nama_reward', width: 400}
 	], bbar: tbSearch_RefReward, features: [filters_Search_RefReward],
 	dockedItems: [{
 		xtype: 'pagingtoolbar', store: Data_Search_RefReward, dock: 'bottom', displayInfo: true
 	}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Reward').handler.call(Ext.getCmp("PILIH_Reward").scope);
 		}
 	}  	
});

var win_popup_RefReward = new Ext.create('widget.window', {
 	id: 'win_popup_RefReward', title: 'Referensi Penghargaan', iconCls: 'icon-star',
 	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefReward]
});
	
var new_popup_ref = win_popup_RefReward;

// POPUP REFERENSI PENGHARGAAN ---------------------------------------------------- END

// FUNCTION REF PENGHARGAAN ------------------------------------------------------- START 
function Funct_win_popup_RefReward(form_name, vfmode){
	Str_Cur_Form_Caller_Reward = form_name;
	Cur_Form_Caller_Reward = window[form_name];
	fmode = vfmode;
	win_popup_RefReward.show();
}

function SetTo_Form_Caller_Reward(){
	var sm = grid_Search_RefReward.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_reward:sel[0].get('kode_reward'), nama_reward:sel[0].get('nama_reward')};
				break;
			default:
				var value_form = {kode_reward:sel[0].get('kode_reward'), nama_reward:sel[0].get('nama_reward')};
		}
	  Cur_Form_Caller_Reward.getForm().setValues(value_form);
	  
	  win_popup_RefReward.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefReward(p_aktif){
	Search_RefReward.onTrigger1Click();
	Data_Search_RefReward.changeParams({params :{id_open: 1, aktif: p_aktif}});
}

// FUNCTION REF PENGHARGAAN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>