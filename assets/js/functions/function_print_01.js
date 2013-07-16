// FUNCTION PRINT 01 -------------------------------------------------------------------- START
function showForm_Print(url_print,title_print,selected_val){
	var form_print = new Ext.create('Ext.form.Panel', {
  	id: 'frmprint_01', url: BASE_URL + 'print_checkselected', frame: true, bodyStyle: 'padding: 5px 5px 0 0;', width: '100%', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
    defaults: {hideEmptyLabel: false, allowBlank: false},
    items: [{
    	xtype: 'fieldset',flex: 1,title:'Pilihan Cetak',defaultType:'radio',layout:'anchor',
      items: [
      	{boxLabel: 'Semua', name: 'pilihan_cetak', inputValue: 'semua', checked: true},
        {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', inputValue: 'terpilih'},
        {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', inputValue: 'perbaris', id: 'perbaris'},
        {
        	xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, 
					defaults: {hideLabel: 'true', width: 70},
					items: [
						{
							xtype: 'numberfield',
            	name: 'dari', emptyText: 'Dari', margins: '0 0 0 15', minValue: 1,
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('perbaris').setValue(true);},
            		change: function(selectedField){Ext.getCmp('perbaris').setValue(true);}
							}
          	},{
            	xtype: 'numberfield',
            	name: 'sampai', emptyText: 'Sampai', margins: '0 0 0 5', minValue: 1,
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('perbaris').setValue(true);},
            		change: function(selectedField){Ext.getCmp('perbaris').setValue(true);}
							}
            }
          ]
        }
      ]
   	}],
    buttons: [{
    	text: 'Preview',
      handler: function() {
				Ext.getCmp('frmprint_01').on({
    			beforeaction: function() {Ext.getCmp('winPrint').body.mask();Ext.getCmp('sbwinPrint').showBusy();}
    		});

        form_print.getForm().submit({            			
        	success: function(form, action){          					
          	obj = Ext.decode(action.response.responseText); 
            win_popup_print.close();
            var dari,sampai;
            if(obj.record){
            	dari = obj.record.dari; sampai = obj.record.sampai;
            }
            showForm_preview(url_print,title_print,obj.mode_cetak,dari,sampai,selected_val);
          },
          failure: function(form, action){
          	Ext.getCmp('winPrint').body.unmask();
          	if (action.failureType == 'server') {
          		obj = Ext.decode(action.response.responseText);
          		Ext.getCmp('sbwinPrint').setStatus({text: obj.errors.reason, iconCls: 'x-status-error'});
          	}else{
          		if (typeof(action.response) == 'undefined') {
          			Ext.getCmp('sbwinPrint').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
          		}else{
          			Ext.getCmp('sbwinPrint').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
          		}
          	}
          }
        });
      }
    },{
    	text: 'Batal', handler: function() {win_popup_print.close();}
    }]				
	});
		
	var win_popup_print = new Ext.create('Ext.window.Window', {
		id: 'winPrint', title: title_print, iconCls: 'icon-printer', constrainHeader : true, closable: true,
		width: 280, height: 240, bodyStyle: 'padding: 5px;', modal : true, items: [form_print],
		bbar: new Ext.ux.StatusBar({
    	text: 'Ready', id: 'sbwinPrint', iconCls: 'x-status-valid'
    })
	}).show();		
}

function showForm_preview(url_print,title_print,mode_cetak,dari,sampai,selected_val){		
	var stat_cetak, xdari, xsampai, xterpilih;
	if(mode_cetak == 'semua'){		
		stat_cetak = "OK";
	}else if(mode_cetak == 'terpilih'){
		var selected_val = selected_val;
		if(selected_val == ''){
			Ext.MessageBox.show({title:'Peringatan !', msg:'Pilih data yang ingin Anda cetak !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		}else{
			stat_cetak = "OK"; xterpilih = selected_val;
		}			
	}else if(mode_cetak == 'perbaris'){
		stat_cetak = "OK"; xdari = dari; xsampai = sampai;
	}
		
	if(stat_cetak == "OK"){
		show_pdf_print(url_print, title_print, mode_cetak, xdari, xsampai, xterpilih);
	}
}	

function show_pdf_print(url_print, title_print, mode_cetak, dari, sampai, terpilih){
	var docprint = new Ext.create('Ext.window.Window', {
		title: title_print, iconCls: 'icon-printer',
		constrainHeader : true, closable: true, maximizable: true,
		width: '80%', height: '80%', bodyStyle: 'padding: 5px;', modal : true,
		items: [{
			xtype:'tabpanel', activeTab : 0,width: '100%', height: '100%',
      items: [{
      	title: 'Preview', frame: false, collapsible: true, autoScroll: true,
      	iconCls: 'icon-pdf',
      	items: [{
      		xtype : 'miframe', frame: false, height: '100%',
        	src : url_print + '/1/' + mode_cetak + '/' + dari + '/' + sampai + '/' + terpilih
        }]
      }]         
		}]		
	}).show();
}

// FUNCTION PRINT 01 -------------------------------------------------------------------- END