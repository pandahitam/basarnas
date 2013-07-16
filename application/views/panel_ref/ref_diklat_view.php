<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Diklat = '', Cur_Form_Caller_Diklat = '', fmode = '';
var vaktif = 1;
var sJns_Diklat = "<?php echo $this->input->post("VKEY"); ?>";

// POPUP REFERENSI DIKLAT ---------------------------------------------------- START
	Ext.define('MSearch_RefDiklat', {extend: 'Ext.data.Model',
    fields: ['ID_Diklat', 'kode_diklat', 'nama_diklat', 'kode_jns_diklat', 'jns_diklat']
	});
	var Reader_Search_RefDiklat = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefDiklat', root: 'results', totalProperty: 'total', idProperty: 'ID_Diklat'  	
	});	
	var Proxy_Search_RefDiklat = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Search_RefDiklat', url: BASE_URL + 'browse_ref/ext_get_all_diklat', actionMethods: {read:'POST'},  extraParams :{id_open: '1', aktif: vaktif, Jns_Diklat: sJns_Diklat}, reader: Reader_Search_RefDiklat
	});
	var Data_Search_RefDiklat = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefDiklat', model: 'MSearch_RefDiklat', pageSize: 10, noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefDiklat
	});

	var search_RefDiklat = new Ext.create('Ext.ux.form.SearchField', {id: 'search_RefDiklat', store: Data_Search_RefDiklat, emptyText: 'Ketik di sini untuk pencarian', width: 330});
	var tbSearch_RefDiklat = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefDiklat',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_diklat', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefDiklat(vaktif);
   	 	}
		 }
    },		
		search_RefDiklat, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Diklat',
		 handler: function(){SetTo_Form_Caller_Diklat();}
		}
  ]
	});

	var cbGrid_Search_RefDiklat = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefDiklat = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefDiklat', store: Data_Search_RefDiklat, frame: true, border: true, loadMask: true,
  	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefDiklat, columnLines: true,
  	invalidateScrollerOnRefresh: false, 
		columns: [
  		{header: "Nama Diklat", dataIndex: 'nama_diklat', width: 340},
  		{header: "Jenis Diklat", dataIndex: 'jns_diklat', width: 100}
  	], bbar: tbSearch_RefDiklat,
  	dockedItems: [{
  		xtype: 'pagingtoolbar', store: Data_Search_RefDiklat, dock: 'bottom', displayInfo: true
  	}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_Diklat').handler.call(Ext.getCmp("PILIH_Diklat").scope);
  		}
  	}  	
	});

	var win_popup_RefDiklat = new Ext.create('widget.window', {
   	id: 'win_popup_RefDiklat', title: 'Referensi Diklat', iconCls: 'icon-toga',
   	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefDiklat]
	});

var new_popup_ref = win_popup_RefDiklat;

// POPUP REFERENSI DIKLAT ---------------------------------------------------- END

// FUNCTION REF DIKLAT ------------------------------------------------------- START 
function Funct_win_popup_RefDiklat(form_name, vfmode){
	Str_Cur_Form_Caller_Diklat = form_name;
	Cur_Form_Caller_Diklat = window[form_name];
	fmode = vfmode;
	win_popup_RefDiklat.show();
}

function SetTo_Form_Caller_Diklat(){
	var sm = grid_Search_RefDiklat.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_diklat:sel[0].get('kode_diklat'), nama_diklat:sel[0].get('nama_diklat')};
				break;
			case 2:
				var value_form = {kode_diklat:sel[0].get('kode_diklat'), nama_diklat:sel[0].get('nama_diklat')};
				break;
			default:
				var value_form = {kode_diklat:sel[0].get('kode_diklat'), nama_diklat:sel[0].get('nama_diklat')};
		}
	  Cur_Form_Caller_Diklat.getForm().setValues(value_form);
	  
	  win_popup_RefDiklat.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefDiklat(p_aktif, p_Jns_Diklat){
	Data_Search_RefDiklat.changeParams({params :{id_open: 1, aktif: p_aktif, Jns_Diklat: sJns_Diklat}});
}

// FUNCTION REF DIKLAT ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>