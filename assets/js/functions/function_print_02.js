// FUNCTION PRINT 02 --------------------------------------------------------------- START
Ext.apply(Ext.form.field.VTypes, {
	daterange: function(val, field) {
  	var date = field.parseDate(val);
    if (!date) {return false;}
		if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
    	var start = field.up('form').down('#' + field.startDateField);start.setMaxValue(date);start.validate();this.dateRangeMax = date;
    }
    else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
    	var end = field.up('form').down('#' + field.endDateField);end.setMinValue(date);end.validate();this.dateRangeMin = date;
    } return true;
  },
  daterangeText: 'Tanggal Dari harus lebih kecil dari Tanggal Sampai'
});

function show_form_print_02(url_print,title_print,selected_val){
	var form_print_02 = new Ext.create('Ext.form.Panel', {
  	id: 'frmprint', url: BASE_URL + 'print_checkselected', frame: true, bodyStyle: 'padding: 5px 5px 0 0;', width: '100%', height: '100%',
    fieldDefaults: {labelAlign: 'right', msgTarget: 'side'},
    defaults: {hideEmptyLabel: false, allowBlank: false},
    items: [{
    	xtype: 'fieldset', flex: 1, title: 'Pilihan Cetak', defaultType: 'radio', layout: 'anchor',
      items: [
      	{boxLabel: 'Semua', name: 'pilihan_cetak', inputValue: 'semua', checked: true},
        {boxLabel: 'Yang Dipilih', name: 'pilihan_cetak', inputValue: 'terpilih'},
        {boxLabel: 'Berdasarkan Baris', name: 'pilihan_cetak', inputValue: 'perbaris', id: 'perbaris'},
        { xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'textfield', combineErrors: true, 
					defaults: {hideLabel: 'true', width: 70},
					items: [
						{
							xtype:'numberfield',name:'dari',emptyText:'Dari',margins:'0 0 0 15',minValue:1,
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('perbaris').setValue(true);},
            		change: function(selectedField){Ext.getCmp('perbaris').setValue(true);}
							}
          	},{
							xtype:'numberfield',name:'sampai',emptyText:'Dari',margins:'0 0 0 5',minValue:1,
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('perbaris').setValue(true);},
            		change: function(selectedField){Ext.getCmp('perbaris').setValue(true);}
							}
            }
          ]
        },
        {boxLabel: 'Berdasarkan Tanggal', name: 'pilihan_cetak', inputValue: 'pertanggal', id: 'pertanggal'},
        { xtype: 'fieldcontainer', layout: 'hbox', defaultType: 'datefield', combineErrors: true,
					defaults: {hideLabel: 'true', width: 100},
					fieldDefaults: {autoFitErrors: false},
					items: [
						{
            	name: 'tgl_dari', id: 'tgl_dari', emptyText: 'Dari', margins: '0 0 0 15', endDateField: 'tgl_sampai', vtype: 'daterange',
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('pertanggal').setValue(true);},
            		change: function(selectedField){Ext.getCmp('pertanggal').setValue(true);}
							}
          	},{
            	name: 'tgl_sampai', id: 'tgl_sampai', emptyText: 'Sampai', margins: '0 0 0 5', startDateField: 'tgl_dari', vtype: 'daterange',
            	listeners:{
            		focus: function(selectedField){Ext.getCmp('pertanggal').setValue(true);},
            		change: function(selectedField){Ext.getCmp('pertanggal').setValue(true);}
							}
            }
          ]
        }
      ]
   	}],
    buttons: [{
    	text: 'Preview',
      handler: function() {
				Ext.getCmp('frmprint').on({
    			beforeaction: function() {Ext.getCmp('win_popup_print_02').body.mask();Ext.getCmp('sbwinPrint_02').showBusy();}
    		});

        form_print_02.getForm().submit({            			
        	success: function(form, action){          					
          	obj = Ext.decode(action.response.responseText); 
            win_popup_print_02.close();
            var dari,sampai;
            var tgl_dari,tgl_sampai;
            if(obj.record){
            	dari = obj.record.dari; sampai = obj.record.sampai;
            	tgl_dari = obj.record.tgl_dari; tgl_sampai = obj.record.tgl_sampai;
            }
            showForm_preview_02(url_print,title_print,obj.mode_cetak,dari,sampai,tgl_dari,tgl_sampai,selected_val);
          },
          failure: function(form, action){
          	Ext.getCmp('win_popup_print_02').body.unmask();
          	if (action.failureType == 'server') {
          		obj = Ext.decode(action.response.responseText);
          		Ext.getCmp('sbwinPrint_02').setStatus({text: obj.errors.reason, iconCls: 'x-status-error'});
          	}else{
          		if (typeof(action.response) == 'undefined') {
          			Ext.getCmp('sbwinPrint_02').setStatus({text: 'Silahkan isi dengan benar !',iconCls: 'x-status-error'});
          		}else{
          			Ext.getCmp('sbwinPrint_02').setStatus({text: 'Server tidak dapat dihubungi !',iconCls: 'x-status-error'});
          		}
          	}
          }
        });
      }
    },{
    	text: 'Batal', handler: function() {win_popup_print_02.close();}
    }]				
	});
		
	var win_popup_print_02 = new Ext.create('Ext.window.Window', {
		id: 'win_popup_print_02', title: title_print, iconCls: 'icon-printer',
		constrainHeader : true, closable: true,
		width: 280, height: 300, bodyStyle: 'padding: 5px;',
		modal : true,
		items: [form_print_02],
		bbar: new Ext.ux.StatusBar({
    	text: 'Ready', id: 'sbwinPrint_02', iconCls: 'x-status-valid'
    })
	}).show();		
}

function showForm_preview_02(url_print,title_print,mode_cetak,dari,sampai,tgl_dari,tgl_sampai,selected_val){		
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
		stat_cetak = "OK";
	}else if(mode_cetak == 'pertanggal'){
		stat_cetak = "OK";
	}
	
	if(stat_cetak == "OK"){
		var docprint_02 = new Ext.create('Ext.window.Window', {
			id: 'docprint_02', title: title_print, iconCls: 'icon-printer', constrainHeader : true, closable: true, maximizable: true,
			width: '80%', height: '80%', bodyStyle: 'padding: 5px;', modal : true,
			items: [{
				xtype:'tabpanel', activeTab : 0, width: '100%', height: '100%',
      	items: [{
      		title: 'Preview', frame: false, collapsible: true, autoScroll: true, iconCls: 'icon-pdf',
      		items: [{
      			xtype : 'miframe', frame: false, height: '100%',
        		src : url_print + '/1/' + mode_cetak + '/' + dari + '/' + sampai + '/' +  tgl_dari + '/' + tgl_sampai + '/' + xterpilih
        	}]
      	}]
			}]		
		}).show();
	}
}	

// FUNCTION PRINT 02 ----------------------------------------------------------------- END