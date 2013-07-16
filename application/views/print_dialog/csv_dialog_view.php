<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: application/x-javascript");
	
if(isset($jsscript) && $jsscript == TRUE){ ?>

var popup_title = '<?php echo $this->input->post('popup_title'); ?>';
var uri_all = '<?php echo $uri_all; ?>';
var uri_selected = '<?php echo $uri_selected; ?>';
var uri_by_rows = '<?php echo $uri_by_rows; ?>';
var Grid_ID = Ext.getCmp('<?php echo $Grid_ID; ?>');
var Params_Print = <?php echo $Params_Print; ?>;

var form_csv_pd = new Ext.create('Ext.form.Panel', {
	id: 'form_csv_pd', url: null, frame: true, bodyStyle: 'padding: 5px 5px 0 0;', width: '100%', height: '100%',
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
  defaults: {hideEmptyLabel: false, allowBlank: false},
  items: [{
  	xtype: 'fieldset',flex: 1,title:'Pilihan Cetak',defaultType:'radio',layout:'anchor',
    items: [
    	{boxLabel: 'Semua', name: 'pilihan_cetak', id: 'semua_pd', inputValue: 'semua', checked: true,
    	 listeners: {
    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd_csv').reset(); Ext.getCmp('sampai_pd').reset();}}
    	 }
    	},
      {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', id: 'terpilih_pd_csv', inputValue: 'terpilih',
    	 listeners: {
    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_pd_csv').reset(); Ext.getCmp('sampai_pd').reset();}}
    	 }
      },
      {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', id: 'perbaris_pd_csv', inputValue: 'perbaris_pd_csv'},
      {xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, defaults: {hideLabel: 'true', width: 70},
			 items: [
			 	{xtype: 'numberfield', name: 'dari', id: 'dari_pd_csv', emptyText: 'Dari', margins: '0 0 0 15', minValue: 1,
         listeners:{
         	focus: function(selectedField){Ext.getCmp('perbaris_pd_csv').setValue(true);},
          change: function(selectedField){Ext.getCmp('perbaris_pd_csv').setValue(true);}
				 }
        },
        {xtype: 'numberfield', name: 'sampai', id: 'sampai_pd', emptyText: 'Sampai', margins: '0 0 0 5', minValue: 1,
         listeners:{
         	focus: function(selectedField){Ext.getCmp('perbaris_pd_csv').setValue(true);},
          change: function(selectedField){Ext.getCmp('perbaris_pd_csv').setValue(true);}
				 }
        }
       ]
      }
    ]
	}],
  buttons: [
  	{text: 'Export', handler: function() {submit_export_pd();}},
    {text: 'Batal', handler: function() {new_popup.close();}}
  ]
});

function submit_export_pd(){
	if(Ext.getCmp('semua_pd').getValue() == true){
		Ext.getCmp('sbwin_csv_pd').showBusy();
		Ext.Ajax.request({
    	url: BASE_URL + uri_all, method: 'POST',
      params: Params_Print,
      success: function(response){preview_cetak_pd(response);},
      scope: this
    });
	}else if(Ext.getCmp('terpilih_pd_csv').getValue() == true){
		var sm = Grid_ID.getSelectionModel(), sel = sm.getSelection(), data = '';
  	if(sel.length > 0){
  		Ext.getCmp('sbwin_csv_pd').showBusy();
     	for (i = 0; i < sel.length; i++) {
      	data = data + sel[i].get('<?php echo $Data_ID; ?>') + '-';
			}
			Ext.Ajax.request({
    		url: BASE_URL + uri_selected, method: 'POST',
      	params: {id_open: 1, postdata: data},
      	success: function(response){preview_cetak_pd(response);},
      	scope: this
    	});
  	}else{
			Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda export !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
			win_csv_pd.close();
		}
	}else{
		var dari = Ext.getCmp('dari_pd_csv').getValue();
		var sampai = Ext.getCmp('sampai_pd').getValue();
		if(dari == null || sampai == null){
			Ext.MessageBox.show({title:'Peringatan !', msg:'Tentukan batasan baris yang akan diexport !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		}else if(dari > sampai){
			Ext.MessageBox.show({title:'Peringatan !', msg:'Kesalahan penentuan batasan baris !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		}else{
			Ext.getCmp('sbwin_csv_pd').showBusy();
			Ext.Ajax.request({
    		url: BASE_URL + uri_by_rows + Ext.getCmp('dari_pd_csv').getValue() + '/' + Ext.getCmp('sampai_pd').getValue(), method: 'POST',
      	params: Params_Print,
      	success: function(response){preview_cetak_pd(response);},
      	scope: this
    	});
		}
	}
}

function preview_cetak_pd(response){
	if(isURL(response.responseText)){
		win_csv_pd.close();		
		var docprint = new Ext.create('Ext.window.Window', {
			title: popup_title, iconCls: 'icon-printer',
			constrainHeader : true, closable: true, maximizable: true,
			width: '80%', height: '80%', bodyStyle: 'padding: 5px;', modal : true,
			items: [{
				xtype:'tabpanel', activeTab : 0, width: '100%', height: '100%',
      	items: [{
      		title: 'Preview', frame: false, collapsible: true, autoScroll: true, iconCls: 'icon-xls',
      		items: [{
      			xtype : 'miframe', frame: false, height: '100%',
        		src : response.responseText
        	}]
      	}]
			}]
		}).show();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg:'Proses cetak gagal !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}	
}

var win_csv_pd = new Ext.create('Ext.window.Window', {
	id: 'win_csv_pd', title: popup_title, iconCls: 'icon-xls', constrainHeader : true, closable: true,
	width: 300, height: 250, bodyStyle: 'padding: 5px;', modal : true, items: [form_csv_pd],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_csv_pd', iconCls: 'x-status-valid'
  })
});

var new_popup = win_csv_pd;

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


