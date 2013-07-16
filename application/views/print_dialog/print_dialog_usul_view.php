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
Ext.define('MP_TTD_usul', {extend: 'Ext.data.Model',
  fields: ['NIP', 'nama_lengkap', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_jab', 'nama_jab', 'kode_golru', 'nama_pangkat', 'nama_golru']
});

var Reader_P_TTD_usul = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_P_TTD_usul', root: 'results', totalProperty: 'total', idProperty: 'NIP'  	
});

var Proxy_P_TTD_usul = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_P_TTD_usul', url: BASE_URL + 'browse_ref/ext_get_all_p_ttd', actionMethods: {read:'POST'}, extraParams: {id_open:1},
  reader: Reader_P_TTD_usul
});

var Data_P_TTD_usul = new Ext.create('Ext.data.Store', {
	id: 'Data_P_TTD_usul', model: 'MP_TTD_usul', pageSize: 20, noCache: false, autoLoad: true,
  proxy: Proxy_P_TTD_usul
});

var cbGrid_P_TTD_usul = new Ext.create('Ext.selection.CheckboxModel');

var Grid_P_TTD_usul = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_P_TTD_usul', store: Data_P_TTD_usul, frame: true, border: true, loadMask: true, noCache: false,
  style: 'margin:0 auto;', autoHeight: true, columnLines: true, selModel: cbGrid_P_TTD_usul, height: '90%', width: '100%',
	columns: [
  	{header: "Nama Lengkap", dataIndex: 'nama_lengkap', width: 200},
  	{header: "Jabatan", dataIndex: 'nama_jab', width: 200}
  ]
});
// END - GRID PENANDA TANGAN

var form_print_pd_usul = new Ext.create('Ext.form.Panel', {
	id: 'form_print_pd_usul', url: null, frame: true, bodyStyle: 'padding: 1px 5px 0 0;', width: '100%', height: '100%',
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
		    	{boxLabel: 'Semua', name: 'pilihan_cetak', id: 'semua_pd_usul', inputValue: 'semua', 
		    	 listeners: {
		    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd_usul').reset(); Ext.getCmp('sampai_pd_usul').reset();}}
		    	 }
		    	},
		      {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', id: 'terpilih_pd_usul', inputValue: 'terpilih', checked: true,
		    	 listeners: {
		    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd_usul').reset(); Ext.getCmp('sampai_pd_usul').reset();}}
		    	 }
		      }
	    	 ]
	    	},
	    	{xtype: 'fieldset', defaultType:'radio', defaults: {anchor: '100%'}, margins: '0 5px 0 0', style: 'padding: 0 0 0 0; border-width: 0px;', flex:1,
	    	 items: [
		      {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', id: 'perbaris_pd_usul', inputValue: 'perbaris_pd_usul'},
		      {xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, defaults: {hideLabel: 'true', width: 70},
					 items: [
					 	{xtype: 'numberfield', name: 'dari', id: 'dari_pd_usul', emptyText: 'Dari', margins: '0 0 0 15', minValue: 1,
		         listeners:{
		         	focus: function(selectedField){Ext.getCmp('perbaris_pd_usul').setValue(true);},
		          change: function(selectedField){Ext.getCmp('perbaris_pd_usul').setValue(true);}
						 }
		        },
		        {xtype: 'numberfield', name: 'sampai', id: 'sampai_pd_usul', emptyText: 'Sampai', margins: '0 0 0 5', minValue: 1,
		         listeners:{
		         	focus: function(selectedField){Ext.getCmp('perbaris_pd_usul').setValue(true);},
		          change: function(selectedField){Ext.getCmp('perbaris_pd_usul').setValue(true);}
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

   // START - DATA USUL
   {xtype: 'fieldset', flex: 1, title:'Update Data Usul', layout:'anchor', defaults: {labelWidth: 80}, height: 70,
    items: [
    	{xtype: 'textfield', fieldLabel: 'Nomor Usul', name: 'no_usul', id: 'no_usul_print', value: '-', allowBlank: false, width: 300},
    	{xtype: 'datefield', fieldLabel: 'Tgl. Usul', name: 'tgl_usul', id: 'tgl_usul_print', value: Tgl_Skrg,format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d', allowBlank: false, width: 185},
    ]
   },
   // END - DATA USUL

   // START - PENDANDA TANGAN
   {xtype: 'fieldset', flex: 1, title: 'Penanda Tangan', layout: 'anchor', style: 'padding: 0 1px 2px 1px;', height: 155,
    items: [Grid_P_TTD_usul]
   }
   // END - PENDANDA TANGAN
	],
  buttons: [
  	{text: 'Preview', id: 'Preview_pd_usul', handler: function() {submit_cetak_pd_usul();}},
    {text: 'Batal', handler: function() {new_popup.close();}}
  ]
});

function submit_cetak_pd_usul(){
	var sm = Grid_P_TTD_usul.getSelectionModel(), sel = sm.getSelection();
  if(sel.length == 1){
  	Ext.getCmp('Preview_pd_usul').setDisabled(true);
		var no_usul = form_print_pd_usul.getForm().findField('no_usul').getValue();
		var tgl_usul = form_print_pd_usul.getForm().findField('tgl_usul').getValue();
		if(no_usul == null || tgl_usul == null){
			Ext.getCmp('Preview_pd_usul').setDisabled(false);
			Ext.Msg.show({
	   		title: 'Peringatan !', msg: 'Silahkan isi Nomor Usul dan Tanggal Usul !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR,
	     	fn: function(btn) {
	     		Ext.getCmp('no_usul_print').focus(false, 200);
	     	}
	   	});
			return;
		}
  	var params_pttd_usul = {};
  	if(sel.length == 1){
  		var pttd_NIP = sel[0].get('NIP');
  		var pttd_nama = sel[0].get('nama_lengkap');
  		var pttd_pangkat = sel[0].get('nama_pangkat');
  		var pttd_golru = sel[0].get('nama_golru');
  		var pttd_jab = sel[0].get('nama_jab');
  		var pttd_unker = sel[0].get('nama_unker');
  		params_pttd_usul = {pttd_NIP:pttd_NIP, pttd_nama:pttd_nama, pttd_pangkat:pttd_pangkat, pttd_golru:pttd_golru, pttd_jab:pttd_jab, pttd_unker:pttd_unker, no_usul:no_usul, tgl_usul:tgl_usul};
  	}
		if(Ext.getCmp('semua_pd_usul').getValue() == true){
			Ext.getCmp('sbwin_print_pd_usul').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
			Ext.Ajax.timeout = Time_Out;
			Ext.Ajax.request({
	    	url: BASE_URL + uri_all, method: 'POST',
	      params: objectMerge(Params_Print, params_pttd_usul),
	      success: function(response){preview_cetak_pd(response);},
	      scope: this
	    });
		}else if(Ext.getCmp('terpilih_pd_usul').getValue() == true){
			var sm = Grid_ID.getSelectionModel(), sel = sm.getSelection(), data = '';
	  	if(sel.length > 0){
	  		Ext.getCmp('sbwin_print_pd_usul').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
	     	for (i = 0; i < sel.length; i++) {
	      	data = data + sel[i].get('<?php echo $Data_ID; ?>') + '-';
				}
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
	    		url: BASE_URL + uri_selected, method: 'POST',
	      	params: objectMerge({id_open: 1, postdata: data}, Params_Print, params_pttd_usul),
	      	success: function(response){preview_cetak_pd(response);},
	      	scope: this
	    	});
	  	}else{
				Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				win_print_pd_usul.close();
			}
		}else{
			var dari = Ext.getCmp('dari_pd_usul').getValue();
			var sampai = Ext.getCmp('sampai_pd_usul').getValue();
			if(dari == null || sampai == null){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Tentukan batasan baris yang akan dicetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				Ext.getCmp('Preview_pd_usul').setDisabled(false);
			}else if(dari > sampai){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Kesalahan penentuan batasan baris !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
				Ext.getCmp('Preview_pd_usul').setDisabled(false);
			}else{
				Ext.getCmp('sbwin_print_pd_usul').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
	    		url: BASE_URL + uri_by_rows + Ext.getCmp('dari_pd_usul').getValue() + '/' + Ext.getCmp('sampai_pd_usul').getValue(), method: 'POST',
	      	params: objectMerge({id_open: 1}, Params_Print, params_pttd_usul),
	      	success: function(response){preview_cetak_pd(response);},
	      	scope: this
	    	});
			}
		}
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg:'Pilih salah satu penanda tangan !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		Ext.getCmp('Preview_pd_usul').setDisabled(false);
	}
}

function preview_cetak_pd(response){
	if(isURL(response.responseText)){
		win_print_pd_usul.close();		
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
		win_print_pd_usul.close();
	}	
}

var win_print_pd_usul = new Ext.create('Ext.window.Window', {
	id: 'win_print_pd_usul', title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true,
	width: 500, height: 430, bodyStyle: 'padding: 5px;', modal : true, items: [form_print_pd_usul],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_print_pd_usul', iconCls: 'x-status-valid'
  })
});

var new_popup = win_print_pd_usul;

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


