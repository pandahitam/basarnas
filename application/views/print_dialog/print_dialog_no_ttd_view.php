<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: application/x-javascript");
	
if(isset($jsscript) && $jsscript == TRUE){ ?>
var popup_title = '<?php echo $this->input->post('popup_title'); ?>';
var uri_all = '<?php echo $uri_all; ?>';
var uri_selected = '<?php echo $uri_selected; ?>';
var uri_by_rows = '<?php echo $uri_by_rows; ?>';
var Grid_ID = Ext.getCmp('<?php echo $Grid_ID; ?>');
var Params_Print = <?php echo $Params_Print; ?>;

var form_print_pd_no_ttd = new Ext.create('Ext.form.Panel', {
	id: 'form_print_pd_no_ttd', url: null, frame: true, bodyStyle: 'padding: 1px 5px 0 0;', width: '100%', height: '100%',
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
  defaults: {hideEmptyLabel: false, allowBlank: false},
  items: [
   // START - PILIHAN CETAK
   {xtype: 'fieldset', flex: 1, title:'Pilihan Cetak', layout:'anchor', height: 80,
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
	 }
   // END - PILIHAN CETAK
	],
  buttons: [
  	{text: 'Preview', handler: function() {submit_cetak_pd();}},
    {text: 'Batal', handler: function() {new_popup.close();}}
  ]
});

function submit_cetak_pd(){
		if(Ext.getCmp('semua_pd').getValue() == true){
				Ext.getCmp('sbwin_print_pd_no_ttd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
		    	url: BASE_URL + uri_all, method: 'POST',
		    	params: objectMerge({id_open: 1}, Params_Print),
		      	success: function(response){preview_cetak_pd(response);},
		      	scope: this
		    	});
		}
		else if(Ext.getCmp('terpilih_pd').getValue() == true){
			var sm = Grid_ID.getSelectionModel(), sel = sm.getSelection(), data = '';
			if (Grid_ID.getId() == 'grid_tb')
			{
				var idTanahs = '';
				var idBangunans = '';
				if(sel.length > 0){
			  		Ext.getCmp('sbwin_print_pd_no_ttd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
			     	for (i = 0; i < sel.length; i++) {
						var tb = sel[i];
						if (tb.data.tipe == 1)
						{
							idTanahs = idTanahs + tb.data.id + '-';
						}
						else
						{
							idBangunans = idBangunans + tb.data.id + '-';
						}
					}
					idTanahs = idTanahs.substring(0,idTanahs.length-1);
					idBangunans = idBangunans.substring(0,idBangunans.length-1);
					debugger;
					Ext.Ajax.timeout = Time_Out;
					Ext.Ajax.request({
			    	url: BASE_URL + uri_selected, method: 'POST',
			      	params: objectMerge({id_open: 1, idTanah: idTanahs, idBangunan:idBangunans}, Params_Print),
			      	success: function(response){preview_cetak_pd(response);},
			      	scope: this
			    	});
			  	}
				else{
					Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
					win_print_pd_no_ttd.close();
				}
			}	
			else
			{
			  	if(sel.length > 0){
			  		Ext.getCmp('sbwin_print_pd_no_ttd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
			     	for (i = 0; i < sel.length; i++) {
			      	data = data + sel[i].get('<?php echo $Data_ID; ?>') + '-';
						}
						Ext.Ajax.timeout = Time_Out;
						Ext.Ajax.request({
			    		url: BASE_URL + uri_selected, method: 'POST',
			      	params: objectMerge({id_open: 1, postdata: data}, Params_Print),
			      	success: function(response){preview_cetak_pd(response);},
			      	scope: this
			    	});
			  	}
				else{
					Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
					win_print_pd_no_ttd.close();
				}
			}
		}else{
			var dari = Ext.getCmp('dari_pd').getValue();
			var sampai = Ext.getCmp('sampai_pd').getValue();
			if(dari == null || sampai == null){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Tentukan batasan baris yang akan dicetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
			}else if(dari > sampai){
				Ext.MessageBox.show({title:'Peringatan !', msg:'Kesalahan penentuan batasan baris !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
			}else{
				Ext.getCmp('sbwin_print_pd_no_ttd').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
				Ext.Ajax.timeout = Time_Out;
				Ext.Ajax.request({
	    		url: BASE_URL + uri_by_rows + Ext.getCmp('dari_pd').getValue() + '/' + Ext.getCmp('sampai_pd').getValue(), method: 'POST',
	      	params: objectMerge({id_open: 1}, Params_Print),
	      	success: function(response){preview_cetak_pd(response);},
	      	scope: this
	    	});
			}
		}
}

function preview_cetak_pd(response){
	if(isURL(response.responseText)){
		win_print_pd_no_ttd.close();		
		var docprint = new Ext.create('Ext.window.Window', {
			title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true, maximizable: true,
			width: '80%', height: '80%', bodyStyle: 'padding: 5px;', modal : true,
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
		win_print_pd_no_ttd.close();
	}	
}

var win_print_pd_no_ttd = new Ext.create('Ext.window.Window', {
	id: 'win_print_pd_no_ttd', title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true,
	width: 400, height: 200, bodyStyle: 'padding: 5px;', modal : true, items: [form_print_pd_no_ttd],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_print_pd_no_ttd', iconCls: 'x-status-valid'
  })
});

var new_popup = win_print_pd_no_ttd;

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


