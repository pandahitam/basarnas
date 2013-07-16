<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: application/x-javascript");
	
if(isset($jsscript) && $jsscript == TRUE){ ?>

var popup_title = '<?php echo $this->input->post('popup_title'); ?>';
var uri_all = '<?php echo $uri_all; ?>';
var uri_selected = '<?php echo $uri_selected; ?>';
var uri_by_rows = '<?php echo $uri_by_rows; ?>';
var Grid_ID = Ext.getCmp('<?php echo $Grid_ID; ?>');
var Params_Print = <?php echo $Params_Print; ?>;

// START - GRID PENANDA TANGAN
Ext.define('MP_TTD', {extend: 'Ext.data.Model',
  fields: ['NIP', 'nama_lengkap', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_jab', 'nama_jab', 'kode_golru', 'nama_pangkat', 'nama_golru']
});

var Reader_P_TTD = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_P_TTD', root: 'results', totalProperty: 'total', idProperty: 'NIP'  	
});

var Proxy_P_TTD = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_P_TTD', url: BASE_URL + 'browse_ref/ext_get_all_p_ttd', actionMethods: {read:'POST'}, extraParams: {id_open:1},
  reader: Reader_P_TTD
});

var Data_P_TTD = new Ext.create('Ext.data.Store', {
	id: 'Data_P_TTD', model: 'MP_TTD', pageSize: 20, noCache: false, autoLoad: true,
  proxy: Proxy_P_TTD
});

var cbGrid_P_TTD = new Ext.create('Ext.selection.CheckboxModel');

var Grid_P_TTD = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_P_TTD', store: Data_P_TTD, frame: true, border: true, loadMask: true, noCache: false,
  style: 'margin:0 auto;', autoHeight: true, columnLines: true, selModel: cbGrid_P_TTD, height: '90%', width: '100%',
	columns: [
  	{header: "Nama Lengkap", dataIndex: 'nama_lengkap', width: 200},
  	{header: "Jabatan", dataIndex: 'nama_jab', width: 200}
  ]
});
// END - GRID PENANDA TANGAN

var form_print_pd = new Ext.create('Ext.form.Panel', {
	id: 'form_print_pd', url: null, frame: true, bodyStyle: 'padding: 1px 5px 0 0;', width: '100%', height: '100%',
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
  defaults: {hideEmptyLabel: false, allowBlank: false},
  items: [
   // START - PILIHAN CETAK
   {xtype: 'fieldset', flex: 1, title:'Pilihan Cetak', layout:'anchor', height: 70,
    items: [
	   {xtype: 'fieldcontainer', combineErrors: false, layout: 'hbox', msgTarget: 'side', 
	    items: [
	    	{xtype: 'fieldset', defaultType:'radio', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
	    	 items: [
		    	{boxLabel: 'Semua', name: 'pilihan_cetak', id: 'semua_pd', inputValue: 'semua', 
		    	 listeners: {
		    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd').reset(); Ext.getCmp('sampai_pd').reset();}}
		    	 }
		    	},
		      {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', id: 'terpilih_pd', inputValue: 'terpilih', checked: true,
		    	 listeners: {
		    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd').reset(); Ext.getCmp('sampai_pd').reset();}}
		    	 }
		      }
	    	 ]
	    	},
	    	{xtype: 'fieldset', defaultType:'radio', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
	    	 items: [
		      {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', id: 'perbaris_pd', inputValue: 'perbaris_pd'},
		      {xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, defaults: {hideLabel: 'true', width: 70},
					 items: [
					 	{xtype: 'numberfield', name: 'dari', id: 'dari_pd', emptyText: 'Dari', margins: '0 0 0 15', minValue: 1,
		         listeners:{
		         	focus: function(selectedField){Ext.getCmp('perbaris_pd').setValue(true);},
		          change: function(selectedField){Ext.getCmp('perbaris_pd').setValue(true);}
						 }
		        },
		        {xtype: 'numberfield', name: 'sampai', id: 'sampai_pd', emptyText: 'Sampai', margins: '0 0 0 5', minValue: 1,
		         listeners:{
		         	focus: function(selectedField){Ext.getCmp('perbaris_pd').setValue(true);},
		          change: function(selectedField){Ext.getCmp('perbaris_pd').setValue(true);}
						 }
		        }
		       ]
		      }
	    	 ]
	    	}
	    ]
	   }
    ]
	 },
   // END - PILIHAN CETAK

   // START - PENDANDA TANGAN
   {xtype: 'fieldset', flex: 1, title: 'Penanda Tangan', layout: 'anchor', style: 'padding: 0 1px 2px 1px;', height: 155,
    items: [Grid_P_TTD]
   }
   // END - PENDANDA TANGAN
	],
  buttons: [
  	{text: 'Preview', id: 'Preview_pd', handler: function() {submit_cetak_pd();}},
    {text: 'Batal', handler: function() {new_popup.close();}}
  ]
});

function submit_cetak_pd(){
	var sm = Grid_P_TTD.getSelectionModel(), sel = sm.getSelection();
  if(sel.length <= 0 || sel.length == 1){
  	Ext.getCmp('Preview_pd').setDisabled(true);
  	var params_pttd = {};
  	if(sel.length == 1){
  		var pttd_NIP = sel[0].get('NIP');
  		var pttd_nama = sel[0].get('nama_lengkap');
  		var pttd_pangkat = sel[0].get('nama_pangkat');
  		var pttd_golru = sel[0].get('nama_golru');
  		var pttd_jab = sel[0].get('nama_jab');
  		var pttd_unker = sel[0].get('nama_unker');
  		params_pttd = {pttd_NIP:pttd_NIP, pttd_nama:pttd_nama, pttd_pangkat:pttd_pangkat, pttd_golru:pttd_golru, pttd_jab:pttd_jab, pttd_unker:pttd_unker};
  	}
		if(Ext.getCmp('semua_pd').getValue() == true){
			Ext.getCmp('sbwin_print_pd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
			Ext.Ajax.timeout = Time_Out;
			Ext.Ajax.request({
	    	url: BASE_URL + uri_all, method: 'POST',
	      params: objectMerge({id_open: 1}, Params_Print, params_pttd),
	      success: function(response){preview_cetak_pd(response);},
	      scope: this
	    });
		}else if(Ext.getCmp('terpilih_pd').getValue() == true){
			var sm = Grid_ID.getSelectionModel(), sel = sm.getSelection(), data = '';
	  	if(sel.length > 0){
	  		Ext.getCmp('sbwin_print_pd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
	     	for (i = 0; i < sel.length; i++) {
	      	data = data + sel[i].get('<?php echo $Data_ID; ?>') + '-';
				}
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
	    		url: BASE_URL + uri_selected, method: 'POST',
	      	params: objectMerge({id_open: 1, postdata: data}, Params_Print, params_pttd),
	      	success: function(response){preview_cetak_pd(response);},
	      	scope: this
	    	});
	  	}else{
				Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				win_print_pd.close();
			}
		}else{
			var dari = Ext.getCmp('dari_pd').getValue();
			var sampai = Ext.getCmp('sampai_pd').getValue();
			if(dari == null || sampai == null){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Tentukan batasan baris yang akan dicetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				Ext.getCmp('Preview_pd').setDisabled(false);
			}else if(dari > sampai){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Kesalahan penentuan batasan baris !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				Ext.getCmp('Preview_pd').setDisabled(false);
			}else{
				Ext.getCmp('sbwin_print_pd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
	    		url: BASE_URL + uri_by_rows + Ext.getCmp('dari_pd').getValue() + '/' + Ext.getCmp('sampai_pd').getValue(), method: 'POST',
	      	params: objectMerge(Params_Print, params_pttd),
	      	success: function(response){preview_cetak_pd(response);},
	      	scope: this
	    	});
			}
		}
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg:'Pilih salah satu penanda tangan !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		Ext.getCmp('Preview_pd').setDisabled(false);
	}
}

function preview_cetak_pd(response){
	if(isURL(response.responseText)){
		win_print_pd.close();		
		var docprint = new Ext.create('Ext.window.Window', {
			title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true, maximizable: true,
			width: '90%', height: '90%', bodyStyle: 'padding: 5px;', modal : true,
			items: [{
				xtype:'tabpanel', activeTab : 0, width: '100%', height: '100%',
      	items: [{
      		title: 'Preview', frame: false, collapsible: true, autoScroll: true, iconCls: 'icon-pdf',
      		items: [{
      			xtype : 'miframe', frame: false, height: '100%',
        		src : response.responseText
        	}]
      	}]
			}]
		}).show();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg:'Proses cetak gagal !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		win_print_pd.close();
	}	
}

var win_print_pd = new Ext.create('Ext.window.Window', {
	id: 'win_print_pd', title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true,
	width: 500, height: 350, bodyStyle: 'padding: 5px;', modal : true, items: [form_print_pd],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_print_pd', iconCls: 'x-status-valid'
  })
});

var new_popup = win_print_pd;

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


