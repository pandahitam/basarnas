<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: application/x-javascript");
	
if(isset($jsscript) && $jsscript == TRUE){ ?>

var popup_title = '<?php echo $this->input->post('popup_title'); ?>';

var form_print_dnp = new Ext.create('Ext.form.Panel', {
	id: 'form_print_dnp', url: null, frame: true, bodyStyle: 'padding: 5px 5px 0 0;', width: '100%', height: '100%',
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
  defaults: {hideEmptyLabel: false, allowBlank: false},
  items: [{
  	xtype: 'fieldset',flex: 1,title:'Pilihan Cetak',defaultType:'radio',layout:'anchor',
    items: [
    	{boxLabel: 'Semua', name: 'pilihan_cetak', id: 'semua_dnp', inputValue: 'semua', checked: true,
    	 listeners: {
    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_dnp').reset(); Ext.getCmp('sampai_dnp').reset();}}
    	 }
    	},
      {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', id: 'terpilih_dnp', inputValue: 'terpilih',
    	 listeners: {
    	 	change: function (ctl, val) {if(val == true){Ext.getCmp('dari_dnp').reset(); Ext.getCmp('sampai_dnp').reset();}}
    	 }
      },
      {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', id: 'perbaris_dnp', inputValue: 'perbaris_dnp'},
      {xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, defaults: {hideLabel: 'true', width: 70},
			 items: [
			 	{xtype: 'numberfield', name: 'dari', id: 'dari_dnp', emptyText: 'Dari', margins: '0 0 0 15', minValue: 1,
         listeners:{
         	focus: function(selectedField){Ext.getCmp('perbaris_dnp').setValue(true);},
          change: function(selectedField){Ext.getCmp('perbaris_dnp').setValue(true);}
				 }
        },
        {xtype: 'numberfield', name: 'sampai', id: 'sampai_dnp', emptyText: 'Sampai', margins: '0 0 0 5', minValue: 1,
         listeners:{
         	focus: function(selectedField){Ext.getCmp('perbaris_dnp').setValue(true);},
          change: function(selectedField){Ext.getCmp('perbaris_dnp').setValue(true);}
				 }
        }
       ]
      }
    ]
	}],
  buttons: [
  	{text: 'Preview', id: 'Preview_dnp', handler: function() {submit_cetak_dnp();}},
    {text: 'Batal', handler: function() {new_popup.close();}}
  ]
});

function submit_cetak_dnp(){
	if(Ext.getCmp('semua_dnp').getValue() == true){
		Ext.getCmp('sbwin_print_dnp').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
		Ext.Ajax.request({
    	url: BASE_URL + 'profil_pns/cetak_dnp_all', method: 'POST',
      params: Params_PPNS,
      success: function(response){preview_cetak_dnp(response);},
      scope: this
    });
	}else if(Ext.getCmp('terpilih_dnp').getValue() == true){
		var sm = Grid_Profil_PNS.getSelectionModel(), sel = sm.getSelection(), data = '';
  	if(sel.length > 0){
  		Ext.getCmp('sbwin_print_dnp').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
     	for (i = 0; i < sel.length; i++) {
      	data = data + sel[i].get('ID_Pegawai') + '-';
			}
			Ext.Ajax.request({
    		url: BASE_URL + 'profil_pns/cetak_dnp_selected', method: 'POST',
      	params: {id_open: 1, postdata: data},
      	success: function(response){preview_cetak_dnp(response);},
      	scope: this
    	});
  	}else{
			Ext.MessageBox.show({title:'Peringatan !', msg:'Silahkan pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
			Ext.getCmp('win_print_dnp').close();
		}
	}else{
		var dari = Ext.getCmp('dari_dnp').getValue();
		var sampai = Ext.getCmp('sampai_dnp').getValue();
		if(dari == null || sampai == null){
			Ext.MessageBox.show({title:'Peringatan !', msg:'Tentukan batasan baris yang akan dicetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		}else if(dari > sampai){
			Ext.MessageBox.show({title:'Peringatan !', msg:'Kesalahan penentuan batasan baris !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		}else{
			Ext.getCmp('sbwin_print_dnp').showBusy({text:'Silahkan tunggu! Sedang melakukan cetak ke PDF ...'});
			Ext.Ajax.request({
    		url: BASE_URL + 'profil_pns/cetak_dnp_by_rows/' + Ext.getCmp('dari_dnp').getValue() + '/' + Ext.getCmp('sampai_dnp').getValue(), method: 'POST',
      	params: Params_PPNS,
      	success: function(response){preview_cetak_dnp(response);},
      	scope: this
    	});
		}
	}
}

function preview_cetak_dnp(response, new_popup){
	if(isURL(response.responseText)){
		Ext.getCmp('win_print_dnp').close();
		var docprint = new Ext.create('Ext.window.Window', {
			title: popup_title, iconCls: 'icon-printer',
			constrainHeader : true, closable: true, maximizable: true,
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
	}
}

var win_print_dnp = new Ext.create('Ext.window.Window', {
	id: 'win_print_dnp', title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true,
	width: 300, height: 250, bodyStyle: 'padding: 5px;', modal : true, items: [form_print_dnp],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_print_dnp', iconCls: 'x-status-valid'
  })
});

var new_popup = win_print_dnp;

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


