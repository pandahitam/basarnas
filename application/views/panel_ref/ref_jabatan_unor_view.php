<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_JabUnor = '', Cur_Form_Caller_JabUnor = '', fmode = '';
var vaktif = 1, vjab_unor = '<?php echo $this->input->post('VKEY'); ?>';

// POPUP REFERENSI JABATAN UNOR ---------------------------------------------------- START
Ext.define('MSearch_RefJabUnor', {extend: 'Ext.data.Model',
   fields: ['ID_Unor', 'kode_unor', 'kode_jab', 'jabatan_unor', 'kode_eselon', 'nama_unor', 'nama_unker']
});
var Reader_Search_RefJabUnor = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefJabUnor', root: 'results', totalProperty: 'total', idProperty: 'ID_Unor'  	
});
var Proxy_Search_RefJabUnor = new Ext.create('Ext.data.AjaxProxy', {
   url: BASE_URL + 'browse_ref/ext_get_all_unor', actionMethods: {read:'POST'},  extraParams :{id_open: 1, aktif: vaktif, eselon: 1, jab_unor:vjab_unor}, reader: Reader_Search_RefJabUnor
});
var Data_Search_RefJabUnor = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefJabUnor', model: 'MSearch_RefJabUnor', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefJabUnor
});

var Search_RefJabUnor = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefJabUnor', store: Data_Search_RefJabUnor, emptyText: 'Ketik di sini untuk pencarian', width: 270});
var tbSearch_RefJabUnor = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefJabUnor',
	items:[
		Search_RefJabUnor, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_JabUnor',
		 handler: function(){SetTo_Form_Caller_JabUnor();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefJabUnor.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefJabUnor = new Ext.create('Ext.ux.grid.filter.Filter', {
	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefJabUnor,
  filters: [
   	{type: 'string', dataIndex: 'jabatan_unor'},
   	{type: 'string', dataIndex: 'nama_unor'},
   	{type: 'string', dataIndex: 'nama_unker'}
  ]
});

var cbGrid_Search_RefJabUnor = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefJabUnor = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefJabUnor', store: Data_Search_RefJabUnor, frame: true, noCache: false, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefJabUnor, columnLines: true,
	columns: [
 		{header: "Jabatan", dataIndex: 'jabatan_unor', width: 200},
 		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 220},
 		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 220}
 	], bbar: tbSearch_RefJabUnor, features: [filters_Search_RefJabUnor],
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefJabUnor, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_JabUnor').handler.call(Ext.getCmp("PILIH_JabUnor").scope);
 		}
 	}  	
});

var win_popup_RefJabUnor = new Ext.create('widget.window', {
 	id: 'win_popup_RefJabUnor', title: 'Referensi Unit Organisasi', iconCls: 'icon-spell',
 	modal:true, plain:true, closable: true, width: 600, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefJabUnor]
});

var new_popup_ref = win_popup_RefJabUnor;

// POPUP REFERENSI JABATAN UNOR ---------------------------------------------------- END

// FUNCTION REF JABATAN UNOR ------------------------------------------------------- START 
function Funct_win_popup_RefJabUnor(form_name, p_fmode){
	Str_Cur_Form_Caller_JabUnor = form_name;
	Cur_Form_Caller_JabUnor = window[form_name];
	fmode = p_fmode;
	win_popup_RefJabUnor.show();
}

function SetTo_Form_Caller_JabUnor(){
	var sm = grid_Search_RefJabUnor.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
  				kode_unor_baru: sel[0].get('kode_unor'),
  				kode_jab_baru: sel[0].get('kode_jab'),
  				nama_jab_baru: sel[0].get('jabatan_unor'),
  				kode_eselon_baru: sel[0].get('kode_eselon'),
  				nama_unor_baru: sel[0].get('nama_unor'),
  				nama_unker_baru: sel[0].get('nama_unker')
			  };
			  break;
			default:
		}
	  Cur_Form_Caller_JabUnor.getForm().setValues(value_form);
	  win_popup_RefJabUnor.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefJabUnor(p_aktif, p_non_eselon){
	Search_RefJabUnor.onTrigger1Click();
	Data_Search_RefJabUnor.changeParams({params :{id_open: 1, aktif: p_aktif, non_eselon: p_non_eselon}});
}

// FUNCTION REF JABATAN UNOR ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>