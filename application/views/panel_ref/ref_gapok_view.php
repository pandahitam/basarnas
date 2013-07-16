<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Gapok = '', Cur_Form_Caller_Gapok = '', fmode = '';
var vaktif = 1;
var skode_jpeg = "<?php echo $this->input->post("VKEY"); ?>";

// POPUP REFERENSI GAPOK ---------------------------------------------------- START
Ext.define('MSearch_RefGapok', {extend: 'Ext.data.Model',
	fields: ['ID_Gapok', 'kode_gapok', 'nama_pangkat', 'nama_golru', 'nama_golru', 'masa_kerja', 'gapok']
});
var Reader_Search_RefGapok = new Ext.create('Ext.data.JsonReader', {
	id: 'Reader_Search_RefGapok', root: 'results', totalProperty: 'total', idProperty: 'ID_Gapok'  	
});
var Proxy_Search_RefGapok = new Ext.create('Ext.data.AjaxProxy', {
	url: BASE_URL + 'browse_ref/ext_get_all_gapok', actionMethods: {read:'POST'},  extraParams :{id_open: '1', aktif: vaktif, kode_jpeg: skode_jpeg}, reader: Reader_Search_RefGapok
});
var Data_Search_RefGapok = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefGapok', model: 'MSearch_RefGapok', pageSize: 10,	noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefGapok
});

var Search_RefGapok = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefGapok', store: Data_Search_RefGapok, emptyText: 'Ketik di sini untuk pencarian', width: 270});
var tbSearch_RefGapok = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefGapok',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_gapok', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefGapok(vaktif);
   	 	}
		 }
    },		
		Search_RefGapok, '->', 
		{text: 'PILIH', id: 'PILIH_Gapok', iconCls: 'icon-check', 
		 handler: function(){SetTo_Form_Caller_Gapok();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefGapok.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefGapok = new Ext.create('Ext.ux.grid.filter.Filter', {
  ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefGapok,
  filters: [
   	{type: 'list', dataIndex: 'nama_pangkat', options: ['Juru Muda', 'Juru Muda Tk.I', 'Juru', 'Juru Tk.I', 'Pengatur Muda', 'Pengatur Muda TK.I', 'Pengatur', 'Pengatur Tk.I', 'Penata Muda', 'Penata Muda Tk.I', 'Penata', 'Penata Tk.I', 'Pembina Muda', 'Pembina Tk.I', 'Pembina Utama Muda', 'Pembina Utama Madya', 'Pembina Utama'], phpMode: true},
   	{type: 'list', dataIndex: 'nama_golru', options: ['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'], phpMode: true},
   	{type: 'numeric', dataIndex: 'masa_kerja'},
   	{type: 'numeric', dataIndex: 'gapok'}
  ]
});

var cbGrid_Search_RefGapok = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefGapok = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefGapok', store: Data_Search_RefGapok, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefGapok, columnLines: true, invalidateScrollerOnRefresh: false,
	columns: [
 		{header: "Pangkat", dataIndex: 'nama_pangkat', width: 130},
 		{header: "Gol.Ruang", dataIndex: 'nama_golru', width: 70},
 		{header: "Masa Kerja", dataIndex: 'masa_kerja', width: 80},
 		{header: "Gaji Pokok", dataIndex: 'gapok', 
 		 renderer: function(value, metaData, record, rowIndex, colIndex, store) {
 		 	return Ext.util.Format.currency(value, 'Rp. ');}, width: 120
 		}
 	], 
 	bbar: tbSearch_RefGapok,
 	features: [filters_Search_RefGapok],
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefGapok, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Gapok').handler.call(Ext.getCmp("PILIH_Gapok").scope);
 		}
 	}  	
});

var win_popup_RefGapok = new Ext.create('widget.window', {
 	id: 'win_popup_RefGapok', title: 'Referensi Gaji Pokok', iconCls: 'icon-money_add',
 	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefGapok]
});

var new_popup_ref = win_popup_RefGapok;

// POPUP REFERENSI GAPOK ---------------------------------------------------- END

// FUNCTION REF GAPOK ------------------------------------------------------- START 
function Funct_win_popup_RefGapok(form_name, vfmode){
	Str_Cur_Form_Caller_Gapok = form_name;
	Cur_Form_Caller_Gapok = window[form_name];
	fmode = vfmode;
	win_popup_RefGapok.show();
}

function SetTo_Form_Caller_Gapok(){
	var sm = grid_Search_RefGapok.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
		  		gapok: sel[0].get('gapok')
			  };
			  break;
			case 2:
				var value_form = {
		  		gapok_baru: sel[0].get('gapok')
			  };
			  break;
			case 3:
				var value_form = {
		  		gapok_lama: sel[0].get('gapok')
			  };
			  break;
			case 4:
				var value_form = {
		  		gapok_pmkg: sel[0].get('gapok')
			  };
			  break;
			case 5:
				var value_form = {
		  		gapok_usul: sel[0].get('gapok')
			  };
			  break;
			case 6:
				var value_form = {
		  		gapok_kpkt: sel[0].get('gapok')
			  };
			  break;
			case 7:
				var value_form = {
		  		gapok_terakhir: sel[0].get('gapok')
			  };
			  break;
			case 8:
				var value_form = {
		  		gapok_pns: sel[0].get('gapok')
			  };
			  break;
			case 9:
				var value_form = {
		  		gapok_cpns: sel[0].get('gapok')
			  };
			  break;
			default:
				var value_form = {
		  		gapok: sel[0].get('gapok')
			  };
		}
	  Cur_Form_Caller_Gapok.getForm().setValues(value_form);
	  
	  win_popup_RefGapok.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefGapok(p_aktif){
	Search_RefGapok.onTrigger1Click();
	Data_Search_RefGapok.changeParams({params :{id_open: 1, aktif: p_aktif, kode_jpeg: skode_jpeg}});
}

// FUNCTION REF GAPOK ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>