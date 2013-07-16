<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_RS = '', Cur_Form_Caller_RS = '', fmode = '';

// POPUP REFERENSI UNIT RUMAH SAKIT ---------------------------------------------------- START
Ext.define('MSearch_RefRS', {extend: 'Ext.data.Model',
   fields: ['ID_UK', 'kode_unker', 'nama_unker', 'alamat_unker', 'nama_uki']
});
var Reader_Search_RefRS = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefRS', root: 'results', totalProperty: 'total', idProperty: 'ID_UK'  	
});
var Proxy_Search_RefRS = new Ext.create('Ext.data.AjaxProxy', {
   url: BASE_URL + 'browse_ref/ext_get_all_rs', actionMethods: {read:'POST'},  extraParams :{id_open: 1}, reader: Reader_Search_RefRS
});
var Data_Search_RefRS = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefRS', model: 'MSearch_RefRS', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefRS
});

var Search_RefRS = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefRS', store: Data_Search_RefRS, emptyText: 'Ketik di sini untuk pencarian', width: 480});
var tbSearch_RefRS = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefRS',
	items:[
		Search_RefRS, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_RS',
		 handler: function(){SetTo_Form_Caller_RS();}
		}
  ]
});

var cbGrid_Search_RefRS = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefRS = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefRS', store: Data_Search_RefRS, frame: true, noCache: false, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefRS, columnLines: true,
	columns: [
 		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 220},
 		{header: "Alamat", dataIndex: 'alamat_unker', width: 220},
 	], bbar: tbSearch_RefRS,
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefRS, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_RS').handler.call(Ext.getCmp("PILIH_RS").scope);
 		}
 	}  	
});

var win_popup_RefRS = new Ext.create('widget.window', {
 	id: 'win_popup_RefRS', title: 'Referensi Rumah Sakit', iconCls: 'icon-gears',
 	modal:true, plain:true, closable: true, width: 600, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefRS]
});

var new_popup_ref = win_popup_RefRS;

// POPUP REFERENSI UNIT RUMAH SAKIT ---------------------------------------------------- END

// FUNCTION REF UNIT RUMAH SAKIT ------------------------------------------------------- START 
function Funct_win_popup_RefRS(form_name, p_fmode){
	Str_Cur_Form_Caller_RS = form_name;
	Cur_Form_Caller_RS = window[form_name];
	fmode = p_fmode;
	win_popup_RefRS.show();
}

function SetTo_Form_Caller_RS(){
	var sm = grid_Search_RefRS.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
  				kode_lokasi: sel[0].get('kode_unker'),
  				nama_lokasi: sel[0].get('nama_unker')
			  };
			  break;
			default:
		}
	  Cur_Form_Caller_RS.getForm().setValues(value_form);
	  
	  win_popup_RefRS.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefRS(p_non_aktif, p_non_eselon){
	Data_Search_RefRS.changeParams({params :{id_open: 1, aktif: p_non_aktif, non_eselon: p_non_eselon}});
}
// FUNCTION REF UNIT RUMAH SAKIT ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>