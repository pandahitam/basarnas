<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Jabatan = '', Cur_Form_Caller_Jabatan = '', fmode = '';
var vaktif = 1, veselon = 0;
var vjenis_jab = '<?php echo $this->input->post('VKEY'); ?>'; 
var kode_klp_jab = "<?php echo $this->input->post("VKEY1"); ?>";

// POPUP REFERENSI JABATAN ---------------------------------------------------- START
Ext.define('MSearch_RefJabatan', {extend: 'Ext.data.Model',
   fields: ['ID_Jab', 'kode_jab', 'nama_jab', 'tunj_jab', 'kode_eselon', 'nama_eselon', 'jenis_jab']
});
var Reader_Search_RefJabatan = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefJabatan', root: 'results', totalProperty: 'total', idProperty: 'ID_Jab'  	
});
var Proxy_Search_RefJabatan = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'browse_ref/ext_get_all_jabatan', actionMethods: {read:'POST'},  extraParams :{id_open: '1', aktif: vaktif, eselon: veselon, jenis_jab: vjenis_jab, kode_klp_jab:kode_klp_jab}, reader: Reader_Search_RefJabatan
});
var Data_Search_RefJabatan = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefJabatan', model: 'MSearch_RefJabatan', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefJabatan
});

var Search_RefJabatan = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefJabatan', store: Data_Search_RefJabatan, emptyText: 'Ketik di sini untuk pencarian', width: 185});
var tbSearch_RefJabatan = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefJabatan',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_jab', checked:true, margins: '0 10px 5px 5px', width: 45,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefJabatan(vaktif, veselon, vjenis_jab);
   	 	}
		 }
    },
    {xtype: 'checkbox', boxLabel: 'Eselon', id: 'cbeselon_jab', checked:false, margins: '0 5px 5px 5px', width: 70,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			veselon = 1;
   	 		}else{
   	 			veselon = 0;
   	 		}
   	 		setParams_Data_Search_RefJabatan(vaktif, veselon, vjenis_jab);
   	 	}
		 }
    },		
		Search_RefJabatan, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Jabatan',
		 handler: function(){SetTo_Form_Caller_Jabatan();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	Grid_Search_RefJabatan.filters.clearFilters();
     }
    }
	]
});

var filters_Search_RefJabatan = new Ext.create('Ext.ux.grid.filter.Filter', {
 	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefJabatan,
  filters: [
   	{type: 'string', dataIndex: 'nama_jab'},
   	{type: 'string', dataIndex: 'nama_eselon'}
  ]
});

var cbGrid_Search_RefJabatan = new Ext.create('Ext.selection.CheckboxModel');
var Grid_Search_RefJabatan = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_Search_RefJabatan', store: Data_Search_RefJabatan, frame: true, border: true, loadMask: true, noCache: false, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefJabatan, columnLines: true, invalidateScrollerOnRefresh: false,
	columns: [
 		{header: "Nama Jabatan", dataIndex: 'nama_jab', width: 350},
 		{header: "Eselon", dataIndex: 'nama_eselon', width: 75}
 	], bbar: tbSearch_RefJabatan, features: [filters_Search_RefJabatan],
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefJabatan, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Jabatan').handler.call(Ext.getCmp("PILIH_Jabatan").scope);
 		}
 	}    	
});

var win_popup_RefJabatan = new Ext.create('widget.window', {
 	id: 'win_popup_RefJabatan', title: 'Referensi Jabatan', iconCls: 'icon-spam',
 	modal:true, plain:true, closable: true, width: 500, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [Grid_Search_RefJabatan]
});

var new_popup_ref = win_popup_RefJabatan;

// POPUP REFERENSI JABATAN ---------------------------------------------------- END

// FUNCTION REF JABATAN ------------------------------------------------------- START 
function Funct_win_popup_RefJabatan(form_name, p_fmode){
	Str_Cur_Form_Caller_Jabatan = form_name;
	Cur_Form_Caller_Jabatan = window[form_name];
	fmode = p_fmode;
	win_popup_RefJabatan.show();
}

function SetTo_Form_Caller_Jabatan(){
	var sm = Grid_Search_RefJabatan.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 'usul':
				var value_form = {
		  		kode_jab_usul: sel[0].get('kode_jab'),
		  		nama_jab_usul: sel[0].get('nama_jab')
			  };
			  break;
			case 1:
				var value_form = {
		  		kode_jab: sel[0].get('kode_jab'),
		  		nama_jab: sel[0].get('nama_jab')
			  };
			  break;
			case 2:
				var value_form = {
		  		kode_jab_baru: sel[0].get('kode_jab'),
		  		nama_jab_baru: sel[0].get('nama_jab')
			  };
			  break;
			case 3:
				var value_form = {
		  		kode_jab_lama: sel[0].get('kode_jab'),
		  		nama_jab_lama: sel[0].get('nama_jab')
			  };
			  break;
			case 4:
				var value_form = {
		  		kode_jab_pmkg: sel[0].get('kode_jab'),
		  		nama_jab_pmkg: sel[0].get('nama_jab')
			  };
			  break;
			case 5:
				var value_form = {
		  		kode_jab: sel[0].get('kode_jab'),
		  		nama_jab: sel[0].get('nama_jab'),
		  		tunj_jab: sel[0].get('tunj_jab')		  		
			  };
			  break;
			default:
				var value_form = {
		  		kode_jab: sel[0].get('kode_jab'),
		  		nama_jab: sel[0].get('nama_jab')
			  };
		}
	  Cur_Form_Caller_Jabatan.getForm().setValues(value_form);
	  
	  win_popup_RefJabatan.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefJabatan(p_aktif, p_eselon, p_jenis_jab){
	Search_RefJabatan.onTrigger1Click();
	Data_Search_RefJabatan.changeParams({params :{id_open: 1, aktif: p_aktif, eselon: p_eselon, jenis_jab:vjenis_jab}});
}

// FUNCTION REF JABATAN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>