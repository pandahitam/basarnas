<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Perlengkapan = null;

        Ext.namespace('Perlengkapan', 'Perlengkapan.reader', 'Perlengkapan.proxy', 'Perlengkapan.Data', 'Perlengkapan.Grid', 'Perlengkapan.Window', 'Perlengkapan.Form', 'Perlengkapan.Action',
                'Perlengkapan.URL','Perlengkapan.Component');
        
        Perlengkapan.Component.pemeliharaanPerlengkapanSubPart = function(edit) {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMELIHARAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [{
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                   xtype:'hidden',
                                   name:'id',
                                },
                                {
                                    xtype:'hidden',
                                    name:'id_sub_part',
                                    id:'pemeliharaan_sub_part_id_sub_part'
                                },
                                {
                                    xtype:'hidden',
                                    name:'nama',
                                    id:'pemeliharaan_sub_part_nama'
                                },
                                {
                                xtype: 'combo',
                                fieldLabel: 'Sub Part',
                                name: 'part_number',
                                allowBlank: false,
                                readOnly:edit,
                                editable:false,
                                store: Reference.Data.subPartPemeliharaan,
                                valueField: 'part_number',
                                displayField: 'nama', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(obj.valueModels.length > 0 && value != null)
                                            {
                                                if(edit == false)
                                                {
                                                    var nama  = Ext.getCmp('pemeliharaan_sub_part_nama');
                                                    var id_sub_part = Ext.getCmp('pemeliharaan_sub_part_id_sub_part')
                                                    if(nama !=  null)
                                                    {
                                                        nama.setValue(obj.valueModels[0].data.nama);
                                                    }
                                                    if(id_sub_part !=  null)
                                                    {
                                                        id_sub_part.setValue(obj.valueModels[0].data.id)

                                                    }
                                                }
//                                                
                                            }
                                        },
                                        scope: this
                                    }
                                }
                             },
                                    {
                                    xtype: 'combo',
                                    fieldLabel: 'Jenis',
                                    name: 'jenis',
                                    allowBlank: true,
                                    store: Reference.Data.jenisPemeliharaan,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Jenis',
                                    value: 3,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',

                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Pelaksana',
                                    name: 'pelaksana_tgl',
                                    id: 'pelaksana_tgl',
                                    format: 'Y-m-d',
                                }, {
                                    fieldLabel: 'Pelaksana',
                                    name: 'pelaksana_nama'
                                }, {
                                    fieldLabel: 'Kode Angaran',
                                    name: 'kode_angaran'
                                }, {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'tahun_angaran',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: '',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                                },
                                
                            ]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi',
                                    id : 'kondisi_perlengkapan',
                                    allowBlank: true,
                                    store: Reference.Data.kondisiPerlengkapan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Kondisi',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: ''
                                },{
                                    xtype: 'numberfield',
                                    fieldLabel: 'Harga',
                                    name: 'harga'
                                }, {
                                    fieldLabel: 'Status',
                                    name: 'status'
                                }, {
                                    fieldLabel: 'Durasi',
                                    name: 'durasi'
                                },
                                {
                                    xtype:'numberfield',
                                    fieldLabel: 'Penambahan Umur',
                                    name: 'umur',
                                    allowBlank:false,
                                    value:0,
                                    minValue:0,
                                    readOnly:edit
                                },
                                {
                                    xtype:'numberfield',
                                    fieldLabel: 'Penambahan Cycle',
                                    name: 'cycle',
                                    allowBlank:false,
                                    value:0,
                                    minValue:0,
                                    readOnly:edit
                                }]
                        },
                    {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                    xtype: 'textarea',
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi'
                                },
//                                {
//                                    xtype: 'checkboxfield',
//                                    inputValue: 1,
//                                    fieldLabel: 'Alert',
//                                    name: 'alert',
//                                    id: 'alert',
//                                    boxLabel: 'Yes',
//                                    disabled: true
//                                }
                            ]
                        }]
                }]

            return component;
    };
        
    Perlengkapan.Component.pemeliharaanPerlengkapanSubSubPart = function(edit) {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMELIHARAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [{
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                   xtype:'hidden',
                                   name:'id',
                                },
                                {
                                    xtype:'hidden',
                                    name:'id_sub_sub_part',
                                    id:'pemeliharaan_sub_sub_part_id_sub_sub_part'
                                },
                                {
                                    xtype:'hidden',
                                    name:'nama',
                                    id:'pemeliharaan_sub_sub_part_nama'
                                },
                                {
                                xtype: 'combo',
                                fieldLabel: 'Sub Part',
                                name: 'id_sub_part',
                                allowBlank: false,
                                readOnly:edit,
                                store: Reference.Data.subPartPemeliharaan,
                                valueField: 'id',
                                editable:false,
                                displayField: 'nama', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(value != null)
                                            {
                                                var combo_sub_sub_part = Ext.getCmp('pemeliharaaan_sub_sub_part_combo_part_number');
                                                if(edit==false)
                                                {
                                                    combo_sub_sub_part.setValue('');
                                                    Reference.Data.subSubPartPemeliharaan.changeParams({params:{id_open:1,id_sub_part:value}});
                                                }
                                                
                                                if(combo_sub_sub_part != null)
                                                {
                                                    combo_sub_sub_part.setDisabled(false);
                                                }
                                                
                                            }
                                        },
                                        scope: this
                                    }
                                }
                             },{
                                xtype: 'combo',
                                fieldLabel: 'Sub Sub Part',
                                name: 'part_number',
                                id:'pemeliharaaan_sub_sub_part_combo_part_number',
                                allowBlank: false,
                                readOnly:edit,
                                disabled:true,
                                store: Reference.Data.subSubPartPemeliharaan,
                                valueField: 'part_number',
                                editable:false,
                                displayField: 'nama', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(obj.valueModels.length > 0 && value != null)
                                            {
                                                if(edit == false)
                                                {
                                                    var nama  = Ext.getCmp('pemeliharaan_sub_sub_part_nama');
                                                    var id_sub_sub_part = Ext.getCmp('pemeliharaan_sub_sub_part_id_sub_sub_part')
                                                    if(nama !=  null)
                                                    {
                                                        nama.setValue(obj.valueModels[0].data.nama);
                                                    }
                                                    if(id_sub_sub_part !=  null)
                                                    {
                                                        id_sub_sub_part.setValue(obj.valueModels[0].data.id)

                                                    }
                                                }
//                                                
                                            }
                                        },
                                        scope: this
                                    }
                                }
                             },
                                    {
                                    xtype: 'combo',
                                    fieldLabel: 'Jenis',
                                    name: 'jenis',
                                    allowBlank: true,
                                    store: Reference.Data.jenisPemeliharaan,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Jenis',
                                    value: 3,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',

                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Pelaksana',
                                    name: 'pelaksana_tgl',
                                    id: 'pelaksana_tgl',
                                    format: 'Y-m-d',
                                }, {
                                    fieldLabel: 'Pelaksana',
                                    name: 'pelaksana_nama'
                                }, {
                                    fieldLabel: 'Kode Angaran',
                                    name: 'kode_angaran'
                                }, {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'tahun_angaran',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: '',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                                },
                                
                            ]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi',
                                    id : 'kondisi_perlengkapan',
                                    allowBlank: true,
                                    store: Reference.Data.kondisiPerlengkapan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Kondisi',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: ''
                                },{
                                    xtype: 'numberfield',
                                    fieldLabel: 'Harga',
                                    name: 'harga'
                                }, {
                                    fieldLabel: 'Status',
                                    name: 'status'
                                }, {
                                    fieldLabel: 'Durasi',
                                    name: 'durasi'
                                },
                                {
                                    xtype:'numberfield',
                                    fieldLabel: 'Penambahan Umur',
                                    name: 'umur',
                                    allowBlank:false,
                                    value:0,
                                    minValue:0,
                                    readOnly:edit
                                },
                                {
                                    xtype:'numberfield',
                                    fieldLabel: 'Penambahan Cycle',
                                    name: 'cycle',
                                    allowBlank:false,
                                    value:0,
                                    minValue:0,
                                    readOnly:edit
                                }]
                        },
                    {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                {
                                    xtype: 'textarea',
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi'
                                },
//                                {
//                                    xtype: 'checkboxfield',
//                                    inputValue: 1,
//                                    fieldLabel: 'Alert',
//                                    name: 'alert',
//                                    id: 'alert',
//                                    boxLabel: 'Yes',
//                                    disabled: true
//                                }
                            ]
                        }]
                }]

            return component;
        };
        
        Perlengkapan.Component.panelPerlengkapanSubPart = function(url, data, storeSubSubPart) {
            var _form = Ext.create('Ext.form.Panel', {
                frame: true,
                url: url,
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function(form, action) {
                                        var id = action.result.id;
                                        data.load();
                                       
                                            var gridStore = storeSubSubPart;
                                            var new_records = gridStore.getNewRecords();
    //                                        var updated_records = grid.getUpdatedRecords();
    //                                        var removed_records = grid.getRemovedRecords();
                                            Ext.each(new_records, function(obj){
                                                var index = gridStore.indexOf(obj);
                                                var record = gridStore.getAt(index);
                                                record.set('id_sub_part',id);
                                            });
                                              gridStore.sync();
                                           Ext.MessageBox.alert('Success', 'Changes saved successfully.');

                                            Modal.assetSecondaryWindow.close();
                                        
                                        
                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                    }
                                });
                            }
                        }
                    }]// BUTTONS END

            });

            return _form;
        };
        
        Perlengkapan.Component.dataTambahanPerlengkapanUdara = function(){
        var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'DATA PERLENGKAPAN KHUSUS ANGKUTAN UDARA',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [ 
                       {
                            columnWidth: .6,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                            {
                                xtype:'datefield',
                                fieldLabel:'Installation Date',
                                name:'installation_date',
                                format: 'Y-m-d'
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Installation A/C TSN *',
                                name:'installation_ac_tsn',
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Installation COMP TSN **',
                                name:'installation_comp_tsn',
                            },
                            {
                                xtype:'displayfield',
                                value:''
                            },
                            {
                                xtype:'displayfield',
                                value:'(*) Installation ENG HRS untuk sub part engine'
                            },
                            {
                                xtype:'displayfield',
                                value:'(**) Installation COMP HRS untuk sub part engine'
                            }
                            ]
                        },
                        {
                            columnWidth: .4,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                                            {
                                xtype: 'combo',
                                disabled: false,
                                fieldLabel: 'Task',
                                name: 'task',
                                store: Reference.Data.taskLaporanUdara,
                                editable:false,
                                valueField: 'value',
                                displayField: 'name', emptyText: 'Pilih Task',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                            },
                            {
                                xtype: 'checkboxfield',
                                inputValue: 1,
                                fieldLabel: 'OC',
                                name: 'is_oc',
                                boxLabel: 'Ya'
                            },
                            {
                                xtype: 'checkboxfield',
                                inputValue: 1,
                                fieldLabel: 'Part Dari Engine/Mesin',
                                name: 'is_engine',
                                boxLabel: 'Ya'
                            }
                            ]
                        }]
                }]
                           
                            
                return component;
        };
               
        Perlengkapan.Component.dataPerlengkapanSubPart= function(id_part,edit,storeSubSubPart)
        {
             var component = {
                 xtype: 'fieldset',
                 layout: 'anchor',
                 anchor: '100%',
                 title: 'SUB PART',
                 border: false,
                 frame: true,
                 defaultType: 'container',
                 defaults: {
                     layout: 'anchor'
                 },
                 items: [{
                         columnWidth: 1,
                         layout: 'anchor',
                         defaults: {
                             anchor: '95%'
                         },
                         defaultType: 'numberfield',
                         items: [
                             {
                                 xtype:'hidden',
                                 name:'id',
                             },
                             {
                                 xtype:'hidden',
                                 name:'id_part',
                                 id:'id_part',
                                 value:id_part,
                             },
                             {
                                 xtype:'hidden',
                                 name:'nama',
                                 id:'asset_perlengkapan_sub_part_nama',
                             },
                             {
                                xtype: 'combo',
                                fieldLabel: 'Part',
                                name: 'part_number',
                                id:'asset_perlengkapan_sub_part_id',
                                anchor: '100%',
                                allowBlank: false,
                                readOnly:edit,
                                store: Reference.Data.subPart,
                                valueField: 'part_number',
                                displayField: 'nama', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(obj.valueModels.length > 0 && value != null)
                                            {
                                                if(edit == false)
                                                {
                                                    storeSubSubPart.removeAll();
                                                    var umur_maks = Ext.getCmp('asset_perlengkapan_sub_part_umur_maks');
                                                    var cycle_maks = Ext.getCmp('asset_perlengkapan_sub_part_cycle_maks');
                                                    var nama  = Ext.getCmp('asset_perlengkapan_sub_part_nama');
                                                    if(umur_maks != null)
                                                    {
                                                        umur_maks.setValue(obj.valueModels[0].data.umur);
                                                    }

                                                    if(cycle_maks != null)
                                                    {
                                                        cycle_maks.setValue(obj.valueModels[0].data.cycle);
                                                    }

                                                    if(nama !=  null)
                                                    {
                                                        nama.setValue(obj.valueModels[0].data.nama);
                                                    }
                                                }
                                                
                                                var fieldset_sub_sub_part = Ext.getCmp('fieldset_sub_sub_part');
                                                if(fieldset_sub_sub_part != null)
                                                {
                                                    fieldset_sub_sub_part.setDisabled(false);
                                                }
                                                
                                                
                                                
                                            }
                                        },
                                        scope: this
                                    }
                                }
                             },
                             {
                                xtype:'textfield',
                                fieldLabel:'Serial Number',
                                name:'serial_number',
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Umur Maks',
                                name:'umur_maks',
                                id:'asset_perlengkapan_sub_part_umur_maks'
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Umur',
                                name:'umur',
                            },
                            {
                                xtype: 'checkboxfield',
                                inputValue: 1,
                                fieldLabel: ' Memiliki Cycle',
                                name: 'is_cycle',
                                boxLabel: 'Ya',
                                listeners:{
                                        'change':{
                                            fn:function(obj,value)
                                            {
                                                var cycle_field =Ext.getCmp('asset_perlengkapan_sub_part_cycle');
                                                var cycle_maks_field = Ext.getCmp('asset_perlengkapan_sub_part_cycle_maks');
                                                if(value == true)
                                                {    
                                                    if(cycle_field != null)
                                                    {
                                                        cycle_field.setDisabled(false);
                                                    }
                                                    
                                                    if(cycle_maks_field != null)
                                                    {
                                                        cycle_maks_field.setDisabled(false);
                                                    }
                                                }
                                                else
                                                {
                                                    if(cycle_field != null)
                                                    {
                                                        cycle_field.setDisabled(true);
                                                    }
                                                    
                                                    if(cycle_maks_field != null)
                                                    {
                                                        cycle_maks_field.setDisabled(true);
                                                    }
                                                }
                                            }
                                        }
                                    }
                            },
                            {
                                disabled:true,
                                xtype:'numberfield',
                                fieldLabel:'Cycle Maks',
                                name:'cycle_maks',
                                id:'asset_perlengkapan_sub_part_cycle_maks'
                            },
                            {
                                disabled:true,
                                xtype:'numberfield',
                                fieldLabel:'Cycle',
                                name:'cycle',
                                id:'asset_perlengkapan_sub_part_cycle'
                            },
                            ]
                     }]
             };

             return component;

        };
        
        Perlengkapan.Component.dataPerlengkapanSubSubPart= function(id_sub_part,edit)
        {
             var component = {
                 xtype: 'fieldset',
                 layout: 'anchor',
                 anchor: '100%',
                 title: 'SUB SUB PART',
                 border: false,
                 frame: true,
                 defaultType: 'container',
                 defaults: {
                     layout: 'anchor'
                 },
                 items: [{
                         columnWidth: 1,
                         layout: 'anchor',
                         defaults: {
                             anchor: '95%'
                         },
                         defaultType: 'numberfield',
                         items: [
                             {
                                 xtype:'hidden',
                                 name:'id',
                             },
                             {
                                 xtype:'hidden',
                                 name:'id_sub_part',
                                 id:'id_sub_part',
                                 value:id_sub_part,
                             },
                             {
                                 xtype:'hidden',
                                 name:'nama',
                                 id:'asset_perlengkapan_sub_sub_part_nama',
                             },
                             {
                                xtype: 'combo',
                                fieldLabel: 'Part',
                                name: 'part_number',
                                anchor: '100%',
                                allowBlank: false,
                                readOnly:edit,
                                store: Reference.Data.subSubPart,
                                valueField: 'part_number',
                                displayField: 'nama', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(obj.valueModels.length > 0 && value != null)
                                            {
                                                if(edit == false)
                                                {
                                                    var umur_maks = Ext.getCmp('asset_perlengkapan_sub_sub_part_umur_maks');
                                                    var cycle_maks = Ext.getCmp('asset_perlengkapan_sub_sub_part_cycle_maks');
                                                    var nama  = Ext.getCmp('asset_perlengkapan_sub_sub_part_nama');
                                                    if(umur_maks != null)
                                                    {
                                                        umur_maks.setValue(obj.valueModels[0].data.umur);
                                                    }

                                                    if(cycle_maks != null)
                                                    {
                                                        cycle_maks.setValue(obj.valueModels[0].data.cycle);
                                                    }

                                                    if(nama !=  null)
                                                    {
                                                        nama.setValue(obj.valueModels[0].data.nama);
                                                    }
                                                }
                                               
                                            }
                                        },
                                        scope: this
                                    }
                                }
                             },
                             {
                                xtype:'textfield',
                                fieldLabel:'Serial Number',
                                name:'serial_number',
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Umur Maks',
                                name:'umur_maks',
                                id:'asset_perlengkapan_sub_sub_part_umur_maks'
                            },
                            {
                                xtype:'numberfield',
                                fieldLabel:'Umur',
                                name:'umur',
                            },
                            {
                                xtype: 'checkboxfield',
                                inputValue: 1,
                                fieldLabel: ' Memiliki Cycle',
                                name: 'is_cycle',
                                boxLabel: 'Ya',
                                listeners:{
                                        'change':{
                                            fn:function(obj,value)
                                            {
                                                var cycle_field =Ext.getCmp('asset_perlengkapan_sub_sub_part_cycle');
                                                var cycle_maks_field = Ext.getCmp('asset_perlengkapan_sub_sub_part_cycle_maks');
                                                if(value == true)
                                                {    
                                                    if(cycle_field != null)
                                                    {
                                                        cycle_field.setDisabled(false);
                                                    }
                                                    
                                                    if(cycle_maks_field != null)
                                                    {
                                                        cycle_maks_field.setDisabled(false);
                                                    }
                                                }
                                                else
                                                {
                                                    if(cycle_field != null)
                                                    {
                                                        cycle_field.setDisabled(true);
                                                    }
                                                    
                                                    if(cycle_maks_field != null)
                                                    {
                                                        cycle_maks_field.setDisabled(true);
                                                    }
                                                }
                                            }
                                        }
                                    }
                            },
                            {
                                disabled:true,
                                xtype:'numberfield',
                                fieldLabel:'Cycle Maks',
                                name:'cycle_maks',
                                id:'asset_perlengkapan_sub_sub_part_cycle_maks'
                            },
                            {
                                disabled:true,
                                xtype:'numberfield',
                                fieldLabel:'Cycle',
                                name:'cycle',
                                id:'asset_perlengkapan_sub_sub_part_cycle'
                            },
                            ]
                     }]
             };

             return component;

        };
        
        Perlengkapan.Component.gridSubPart = function(setting,edit){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                height: (edit==true)?325:150,
                title: 'SUB PART',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.perlengkapanSubPart(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]};
                
            return subcomponent;
        };
        
        
        Perlengkapan.Component.gridSubSubPart = function(setting){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                height: 325,
                title: 'SUB SUB PART',
                border: false,
                frame: true,
                disabled:true,
                id:'fieldset_sub_sub_part',
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{xtype:'container',height:300,items:[Grid.perlengkapanSubSubPart(setting)]}]
        };
                
            return subcomponent;
        };
        
        
        Perlengkapan.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPerlengkapan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Perlengkapan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        Perlengkapan.URL = {
            read: BASE_URL + 'asset_perlengkapan/getAllData',
            createUpdate: BASE_URL + 'asset_perlengkapan/modifyPerlengkapan',
            remove: BASE_URL + 'asset_perlengkapan/deletePerlengkapan',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan_Perlengkapan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan_Perlengkapan/deletePemeliharaan',
            createUpdatePemeliharaanSubPart: BASE_URL + 'Pemeliharaan_Perlengkapan/modifyPemeliharaanSubPart',
            removePemeliharaanSubPart: BASE_URL + 'Pemeliharaan_Perlengkapan/deletePemeliharaanSubPart',
            createUpdatePemeliharaanSubSubPart: BASE_URL + 'Pemeliharaan_Perlengkapan/modifyPemeliharaanSubSubPart',
            removePemeliharaanSubSubPart: BASE_URL + 'Pemeliharaan_Perlengkapan/deletePemeliharaanSubSubPart',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan',
            createUpdateSubPart: BASE_URL +'asset_perlengkapan/modifySubPart',
            removeSubPart: BASE_URL +'asset_perlengkapan/deleteSubPart'
        };

        Perlengkapan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Perlengkapan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Perlengkapan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Perlengkapan',
            url: Perlengkapan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Perlengkapan.reader,
            timeout:600000,
            afterRequest: function(request, success) {
                Params_M_Perlengkapan = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    Perlengkapan.Data.clearFilter();
//                    Perlengkapan.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                      var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    Perlengkapan.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                }
            }
        });

        Perlengkapan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Perlengkapan', storeId: 'DataPerlengkapan', model: 'MPerlengkapan', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Perlengkapan.proxy, groupField: 'tipe'
        });
        
        Ext.define('MSubPart', {extend: 'Ext.data.Model',
            fields: ['id','id_part','nama','part_number','serial_number','umur_maks',
                    'umur','is_cycle','cycle_maks','cycle','is_oc','installation_date',
                    'installation_ac_tsn','installation_comp_tsn','task','is_engine'
            ]
        });
        
        Ext.define('MSubSubPart', {extend: 'Ext.data.Model',
            fields: ['id','id_sub_part','nama','part_number','serial_number','umur_maks',
                    'umur','is_cycle','cycle_maks','cycle','is_oc','installation_date',
                    'installation_ac_tsn','installation_comp_tsn','task','is_engine'
            ]
        });
        
        Ext.define('MPemeliharaanPerlengkapanSubPart', {extend: 'Ext.data.Model',
            fields: ['id', 'id_sub_part', 'umur','cycle',
                'jenis', 'nama', 'part_number',
                'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi', 
                'deskripsi', 'harga', 'kode_angaran', 'unit_waktu', 'unit_pengunaan', 'freq_waktu', 
                'freq_pengunaan', 'status', 'durasi', 'rencana_waktu', 
                'rencana_pengunaan', 'rencana_keterangan', 'alert','image_url','document_url']
        });
        
        Ext.define('MPemeliharaanPerlengkapanSubSubPart', {extend: 'Ext.data.Model',
            fields: ['id', 'id_sub_sub_part', 'umur','id_sub_part','cycle',
                'jenis', 'nama', 'part_number',
                'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi', 
                'deskripsi', 'harga', 'kode_angaran', 'unit_waktu', 'unit_pengunaan', 'freq_waktu', 
                'freq_pengunaan', 'status', 'durasi', 'rencana_waktu', 
                'rencana_pengunaan', 'rencana_keterangan', 'alert','image_url','document_url']
        });
        
        Perlengkapan.dataStorePemeliharaanSubPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPerlengkapanSubPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Perlengkapan/getSpecificPemeliharaanSubPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStorePemeliharaanSubSubPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPerlengkapanSubSubPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Perlengkapan/getSpecificPemeliharaanSubSubPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        
        
        Perlengkapan.dataStoreSubPart = new Ext.create('Ext.data.Store', {
            model: MSubPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_perlengkapan/getSpecificSubPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStoreSubSubPart = new Ext.create('Ext.data.Store', {
            model: MSubSubPart, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'asset_perlengkapan/getSpecificSubSubPart',
                create: BASE_URL + 'asset_perlengkapan/createSubSubPart',
                update: BASE_URL + 'asset_perlengkapan/updateSubSubPart',
                destroy: BASE_URL + 'asset_perlengkapan/destroySubSubPart'
                },
                writer: {
                type: 'json',
                writeAllFields: true,
                root: 'data',
                encode:true,
                },
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'}),
                extraParams:{open:'0'}
            }),
        });

        Perlengkapan.addSubSubPart = function()
        {
                if (Modal.assetTertiaryWindow.items.length === 0)
                {
                    Modal.assetTertiaryWindow.setTitle('Tambah Sub Sub Part');
                }
                    var sub_part = Ext.getCmp('asset_perlengkapan_sub_part_id').value;
                    Reference.Data.subSubPart.changeParams({params:{id_open:1, part_number:sub_part}});
                    var form = Form.tertiaryWindowAsset(Perlengkapan.dataStoreSubSubPart,'add');
                    form.insert(0,Perlengkapan.Component.dataPerlengkapanSubSubPart('',false));
                    form.insert(1, Perlengkapan.Component.dataTambahanPerlengkapanUdara());
                    Modal.assetTertiaryWindow.add(form);
                    Modal.assetTertiaryWindow.show();
        };

        Perlengkapan.editSubSubPart = function()
        {
            var grid = Ext.getCmp('grid_sub_sub_part');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);

                if (Modal.assetTertiaryWindow.items.length === 0)
                {
                    Modal.assetTertiaryWindow.setTitle('Edit Sub Sub Part');
                }
                    var sub_part = Ext.getCmp('asset_perlengkapan_sub_part_id').value;
                    Reference.Data.subSubPart.changeParams({params:{id_open:2}});
                    
                    var form = Form.tertiaryWindowAsset(Perlengkapan.dataStoreSubSubPart,'edit',storeIndex);
                    form.insert(0,Perlengkapan.Component.dataPerlengkapanSubSubPart(sub_part,true));
                    form.insert(1, Perlengkapan.Component.dataTambahanPerlengkapanUdara());

                    if (data !== null)
                    {
                        Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                         form.getForm().setValues(data);
                    }
                    
                    Modal.assetTertiaryWindow.add(form);
                    Modal.assetTertiaryWindow.show();

            }
        };

        Perlengkapan.removeSubSubPart = function()
        {
            var grid = Ext.getCmp('grid_sub_sub_part');
            var selected = grid.getSelectionModel().getSelection();
            if(selected.length > 0)
            {
                Ext.Msg.show({
                    title: 'Konfirmasi',
                    msg: 'Apakah Anda yakin untuk menghapus ?',
                    buttons: Ext.Msg.YESNO,
                    icon: Ext.Msg.Question,
                    fn: function(btn) {
                        if (btn === 'yes')
                        {
                            Ext.each(selected, function(obj){
                                var storeIndex = grid.store.indexOf(obj);
                                var record = grid.store.getAt(storeIndex);
                                grid.store.remove(record);
                            });
                        }
                    }
                });
            }
        };
        
        Perlengkapan.addSubPart = function()
        {
            var setting_grid_sub_sub_part = {
                id:'grid_sub_sub_part',
                toolbar:{
                    add: Perlengkapan.addSubSubPart,
                    edit: Perlengkapan.editSubSubPart,
                    remove: Perlengkapan.removeSubSubPart
                },
                dataStore:Perlengkapan.dataStoreSubSubPart,
            };
            
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Sub Part');
                }
                    var form = Perlengkapan.Component.panelPerlengkapanSubPart(Perlengkapan.URL.createUpdateSubPart, Perlengkapan.dataStoreSubPart, Perlengkapan.dataStoreSubSubPart);
                    form.insert(0, Perlengkapan.Component.dataPerlengkapanSubPart(data.id,false,Perlengkapan.dataStoreSubSubPart));
                    form.insert(1, Perlengkapan.Component.dataTambahanPerlengkapanUdara());
                    form.insert(2, Perlengkapan.Component.gridSubSubPart(setting_grid_sub_sub_part));
                    Reference.Data.subPart.changeParams({params:{id_open:1,part_number:data.part_number}});
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
            }
        };
        
        Perlengkapan.editSubPart= function()
        {
            var setting_grid_sub_sub_part = {
                id:'grid_sub_sub_part',
                toolbar:{
                    add: Perlengkapan.addSubSubPart,
                    edit: Perlengkapan.editSubSubPart,
                    remove: Perlengkapan.removeSubSubPart
                },
                dataStore:Perlengkapan.dataStoreSubSubPart,
            };
            
            var selected = Ext.getCmp('grid_sub_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Sub Part');
                }
                    var form = Perlengkapan.Component.panelPerlengkapanSubPart(Perlengkapan.URL.createUpdateSubPart, Perlengkapan.dataStoreSubPart, Perlengkapan.dataStoreSubSubPart);
                    form.insert(0, Perlengkapan.Component.dataPerlengkapanSubPart(data.id,true,Perlengkapan.dataStoreSubSubPart));
                    form.insert(1, Perlengkapan.Component.dataTambahanPerlengkapanUdara());
                    form.insert(2, Perlengkapan.Component.gridSubSubPart(setting_grid_sub_sub_part));
                    Reference.Data.subPart.changeParams({params:{id_open:2}});
                    Perlengkapan.dataStoreSubSubPart.changeParams({params:{id_sub_part:data.id}});
                    if (data !== null)
                    {
                        Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                         form.getForm().setValues(data);
                    }
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
             }
        };
        
        Perlengkapan.removeSubPart = function()
        {
            var selected = Ext.getCmp('grid_sub_part').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
           Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removeSubPart,Perlengkapan.dataStoreSubPart);
            
                    
        };

        Perlengkapan.Form.create = function(data, edit) {
            var setting_grid_sub_part = {
                id:'grid_sub_part',
                toolbar:{
                    add: Perlengkapan.addSubPart,
                    edit: Perlengkapan.editSubPart,
                    remove: Perlengkapan.removeSubPart
                },
                dataStore:Perlengkapan.dataStoreSubPart,
            };
            
            
            var form = Form.asset(Perlengkapan.URL.createUpdate, Perlengkapan.Data, edit);
            form.insert(0, Form.Component.unit(edit,form));
//            form.insert(3, Form.Component.address());
//            form.insert(4, Form.Component.perlengkapan());
//            form.insert(5, Form.Component.tambahanPerlengkapanPerlengkapan());
            form.insert(1, Form.Component.klasifikasiAset(edit))
            form.insert(2, Form.Component.perlengkapan(edit));
            form.insert(3, Form.Component.perlengkapanDataTambahan());
            form.insert(4, Perlengkapan.Component.gridSubPart(setting_grid_sub_part,edit));
            form.insert(5, Form.Component.fileUpload(edit));
            if (data !== null)
            {
                Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                form.getForm().setValues(data);
            }
            else
            {
                var presetData = {};
                if(user_kd_lokasi != null)
                {
                    presetData.kd_lokasi = user_kd_lokasi;
                }
                if(user_kode_unor != null)
                {
                    presetData.kode_unor = user_kode_unor;
                }
                form.getForm().setValues(presetData);

            }

            return form;
        };

        Perlengkapan.Form.createPemeliharaan = function(dataGrid,dataForm,edit) {
            var setting = {
                url: Perlengkapan.URL.createUpdatePemeliharaan,
                data: dataGrid,
                isEditing: edit,
                isPerlengkapan: true,
                dataMainGrid: Perlengkapan.Data,
                addBtn: {
                    isHidden: true,
                    text: '',
                    fn: null
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };
            var form = Form.pemeliharaanInAssetPerlengkapan(setting);
            
            if (dataForm !== null)
            {
                 if(dataForm.unit_waktu != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 1;
                }
                else if(dataForm.unit_pengunaan != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 2;
                }
                
                Ext.Object.each(dataForm,function(key,value,myself){
                            if(dataForm[key] == '0000-00-00')
                            {
                                dataForm[key] = '';
                            }
                        });
                form.getForm().setValues(dataForm);
            }
            return form;
        };
        
        Perlengkapan.Form.createPemeliharaanSubPart = function(dataGrid,dataForm,edit) {
//            var setting = {
//                url: Perlengkapan.URL.createUpdatePemeliharaan,
//                data: dataGrid,
//                isEditing: edit,
//                isPerlengkapan: true,
//                dataMainGrid: Perlengkapan.Data,
//                addBtn: {
//                    isHidden: true,
//                    text: '',
//                    fn: null
//                },
//                selectionAsset: {
//                    noAsetHidden: false
//                }
//            };
            
            var formPanel = Ext.create('Ext.form.Panel', {
                id : 'form-pemeliharaan-sub-part-in-asset',
                frame: true,
                url: Perlengkapan.URL.createUpdatePemeliharaanSubPart,
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                trackResetOnLoad:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', id: 'save_pemeliharaan_in_asset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = formPanel.getForm();
                            var formValues = form.getValues();
                            var imageField = form.findField('image_url');
                            var documentField = form.findField('document_url');
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = Utils.getPhotoStore(formPanel);
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Utils.getDocumentStore(formPanel);
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            if (form.isValid())
                            {
                                    form.submit({
                                        success: function(form,action) {
                                            
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            if (dataGrid !== null)
                                            {
                                                dataGrid.load();
                                            }
                                            
                                            Modal.assetSecondaryWindow.close();
                                            var grid_sub_part = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_part');
                                            if(grid_sub_part != null)
                                            {
                                                grid_sub_part.getStore().load();
                                            }
                                            
//                                            Perlengkapan.Data.load();
//                                            $.ajax({
//                                                url:BASE_URL + 'pemeliharaan_perlengkapan/getLatestUmur',
//                                                type: "POST",
//                                                dataType:'json',
//                                                async:false,
//                                                data:{kd_brg:formValues.kd_brg, kd_lokasi:formValues.kd_lokasi, no_aset:formValues.no_aset},
//                                                success:function(response, status){
//                                                    if(status == "success")
//                                                    {
//                                                        var fieldUmur = Ext.getCmp('asset_perlengkapan_umur');
//                                                        if(fieldUmur != undefined && fieldUmur !=null)
//                                                        {
//                                                            fieldUmur.setValue(response);
//                                                        }
//                                                        
//                                                    }
//
//                                                }
//                                             });
                                            
//                                           Modal.assetEdit.addListener("close",function(){ dataMainGrid.load() },this)
    //                                        if (edit)
    //                                        {
    //                                            Modal.closeProcessWindow();
    //                                        }
    //                                        else
    //                                        {
    //                                            form.reset();
    //                                        }
                                        },
                                        failure: function() {
                                            Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                        }
                                    });
                                
                            }
                            
                        }
                    }]
            });

//            form.insert(1, Form.Component.hiddenIdentifier());
            formPanel.insert(2, Perlengkapan.Component.pemeliharaanPerlengkapanSubPart(edit));
            formPanel.insert(4, Form.Component.fileUpload());
            
            if (dataForm !== null)
            {
                 if(dataForm.unit_waktu != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 1;
                }
                else if(dataForm.unit_pengunaan != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 2;
                }
                
                Ext.Object.each(dataForm,function(key,value,myself){
                            if(dataForm[key] == '0000-00-00')
                            {
                                dataForm[key] = '';
                            }
                        });
                formPanel.getForm().setValues(dataForm);
            }
            return formPanel;
        };
        
        Perlengkapan.Form.createPemeliharaanSubSubPart = function(dataGrid,dataForm,edit) {
//            var setting = {
//                url: Perlengkapan.URL.createUpdatePemeliharaanSubSubPart,
//                data: dataGrid,
//                isEditing: edit,
//                isPerlengkapan: true,
//                dataMainGrid: Perlengkapan.Data,
//                addBtn: {
//                    isHidden: true,
//                    text: '',
//                    fn: null
//                },
//                selectionAsset: {
//                    noAsetHidden: false
//                }
//            };
            
            var formPanel = Ext.create('Ext.form.Panel', {
                id : 'form-pemeliharaan-sub-sub-part-in-asset',
                frame: true,
                url: Perlengkapan.URL.createUpdatePemeliharaanSubSubPart,
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                trackResetOnLoad:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', id: 'save_pemeliharaan_in_asset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = formPanel.getForm();
                            var formValues = form.getValues();
                            var imageField = form.findField('image_url');
                            var documentField = form.findField('document_url');
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = Utils.getPhotoStore(formPanel);
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Utils.getDocumentStore(formPanel);
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            if (form.isValid())
                            {
                                    form.submit({
                                        success: function(form,action) {
                                            
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            if (dataGrid !== null)
                                            {
                                                dataGrid.load();
                                            }
                                            
                                            Modal.assetSecondaryWindow.close();
//                                            Perlengkapan.Data.load();
//                                            $.ajax({
//                                                url:BASE_URL + 'pemeliharaan_perlengkapan/getLatestUmur',
//                                                type: "POST",
//                                                dataType:'json',
//                                                async:false,
//                                                data:{kd_brg:formValues.kd_brg, kd_lokasi:formValues.kd_lokasi, no_aset:formValues.no_aset},
//                                                success:function(response, status){
//                                                    if(status == "success")
//                                                    {
//                                                        var fieldUmur = Ext.getCmp('asset_perlengkapan_umur');
//                                                        if(fieldUmur != undefined && fieldUmur !=null)
//                                                        {
//                                                            fieldUmur.setValue(response);
//                                                        }
//                                                        
//                                                    }
//
//                                                }
//                                             });
                                            
//                                           Modal.assetEdit.addListener("close",function(){ dataMainGrid.load() },this)
    //                                        if (edit)
    //                                        {
    //                                            Modal.closeProcessWindow();
    //                                        }
    //                                        else
    //                                        {
    //                                            form.reset();
    //                                        }
                                        },
                                        failure: function() {
                                            Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                        }
                                    });
                                
                            }
                            
                        }
                    }]
            });

//            form.insert(1, Form.Component.hiddenIdentifier());
            formPanel.insert(2, Perlengkapan.Component.pemeliharaanPerlengkapanSubSubPart(edit));
            formPanel.insert(4, Form.Component.fileUpload());
            
            if (dataForm !== null)
            {
                 if(dataForm.unit_waktu != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 1;
                }
                else if(dataForm.unit_pengunaan != 0 && edit == true)
                {
                    dataForm.comboUnitWaktuOrUnitPenggunaan = 2;
                }
                
                Ext.Object.each(dataForm,function(key,value,myself){
                            if(dataForm[key] == '0000-00-00')
                            {
                                dataForm[key] = '';
                            }
                        });
                formPanel.getForm().setValues(dataForm);
            }
            return formPanel;
        };
        

        Perlengkapan.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-details');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pengadaanEdit();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.penghapusanDetail();
                    }
                },
                pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pendayagunaanList();
                    }
                },
               printPDF: function() {
                        Perlengkapan.Action.printpdf();
                },
               pengelolaan: function(){
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pengelolaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pengelolaanList();
                    }
               },
            };

            return actions;
        };
        
        Perlengkapan.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: Perlengkapan.URL.createUpdatePengelolaan,
                data: data,
                isEditing: edit,
                addBtn: {
                    isHidden: true,
                    text: '',
                    fn: function() {
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.pengelolaanInAsset(setting);

            if (dataForm !== null)
            {
                Ext.Object.each(dataForm,function(key,value,myself){
                    if(dataForm[key] == '0000-00-00')
                    {
                        dataForm[key] = '';
                    }
                });
                
                form.getForm().setValues(dataForm);
            }
            return form;
        };
        
        Perlengkapan.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPengelolaan(Perlengkapan.dataStorePengelolaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pengelolaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'tanah-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePengelolaan, Perlengkapan.dataStorePengelolaan);
            }
        };


        Perlengkapan.Action.pengelolaanAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = Perlengkapan.Form.createPengelolaan(Perlengkapan.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Perlengkapan.Action.pengelolaanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perlengkapan.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "perlengkapan_grid_pengelolaan",
                    edit : Perlengkapan.Action.pengelolaanEdit,
                    add : Perlengkapan.Action.pengelolaanAdd,
                    remove : Perlengkapan.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _perlengkapanPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_perlengkapanPendayagunaanGrid, 'perlengkapan-pengelolaan', 'Pengelolaan');
            }
        };
        
        Perlengkapan.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Perlengkapan.URL.createUpdatePendayagunaan,
                data: data,
                isEditing: edit,
                addBtn: {
                    isHidden: true,
                    text: '',
                    fn: function() {
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.pendayagunaanInAsset(setting);

            if (dataForm !== null)
            {
                Ext.Object.each(dataForm,function(key,value,myself){
                            if(dataForm[key] == '0000-00-00')
                            {
                                dataForm[key] = '';
                            }
                        });
                form.getForm().setValues(dataForm);
            }
            return form;
        };
        
        Perlengkapan.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPendayagunaan(Perlengkapan.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePendayagunaan, Perlengkapan.dataStorePendayagunaan);
            }
        };


        Perlengkapan.Action.pendayagunaanAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Perlengkapan.Form.createPendayagunaan(Perlengkapan.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'perlengkapan-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Perlengkapan.Action.pendayagunaanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "perlengkapan_grid_pendayagunaan",
                    edit : Perlengkapan.Action.pendayagunaanEdit,
                    add : Perlengkapan.Action.pendayagunaanAdd,
                    remove : Perlengkapan.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _perlengkapanPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_perlengkapanPendayagunaanGrid, 'perlengkapan-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Perlengkapan.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('perlengkapan_grid_pemindahan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                var setting = {
                    url: '',
                    data: data,
                    isEditing: false,
                    addBtn: {
                        isHidden: true,
                        text: '',
                        fn: function() {
                        }
                    },
                    selectionAsset: {
                        noAsetHidden: false
                    }
                };
                        
                var form = Form.penghapusanDanMutasiInAsset(setting);

                if (data !== null && data !== undefined)
                {
                    Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                    form.getForm().setValues(data);
                }

                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Detail Pemindahan');
                }

                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
           }
        };
        
        Perlengkapan.Action.pemindahanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "perlengkapan_grid_pemindahan",
                    edit : Perlengkapan.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _perlengkapanMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_perlengkapanMutasiGrid, 'perlengkapan-pemindahan', 'Pemindahan');
            }
        };
        
         Perlengkapan.Action.penghapusanDetail = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                var params = {
                    kd_lokasi: data.kd_lokasi,
                    kd_brg: data.kd_brg,
                    no_aset: data.no_aset
                };
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                Ext.Ajax.request({
                    url: BASE_URL + 'penghapusan/getSpecificPenghapusan/',
                    params: params,
                    timeout:500000,
                    async:false,
                    success: function(resp)
                    {
                        var jsonData = params;
                        var response = Ext.decode(resp.responseText);

                        if (response.length > 0)
                        {
                            var jsonData = response[0];
                        }


                        var setting = {
                            url: '',
                            data: jsonData,
                            isEditing: false,
                            addBtn: {
                                isHidden: true,
                                text: '',
                                fn: function() {
                                }
                            },
                            selectionAsset: {
                                noAsetHidden: false
                            }
                        };
                        
                        var form = Form.penghapusanDanMutasiInAsset(setting);

                        if (jsonData !== null && jsonData !== undefined)
                        {
                            Ext.Object.each(jsonData,function(key,value,myself){
                            if(jsonData[key] == '0000-00-00')
                            {
                                jsonData[key] = '';
                            }
                        });
                            form.getForm().setValues(jsonData);
                        }
                        Tab.addToForm(form, 'perlengkapan-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Perlengkapan.Action.pengadaanEdit = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
//                var params = {
//                                kd_lokasi : data.kd_lokasi,
//                                kd_unor : data.kd_unor,
//                                kd_brg : data.kd_brg,
//                                no_aset : data.no_aset
//                        };
                var params = {
                        id_pengadaan: data.id_pengadaan,
                        isAssetPerlengkapan: true
                };
                        
                Ext.Ajax.request({
                    url: BASE_URL + 'pengadaan/getByID/',
                    params: params,
                    success: function(resp)
                    {
                        var jsonData = params;
                        var response = Ext.decode(resp.responseText);

                        if (response.length > 0)
                        {
                            var jsonData = response[0];
                        }

                        var setting = {
                            url: BASE_URL + 'Pengadaan/modifyPengadaan',
                            data: null,
                            isEditing: false,
                            addBtn: {
                                isHidden: true,
                                text: '',
                                fn: function() {
                                }
                            },
                            selectionAsset: {
                                noAsetHidden: false
                            }
                        };
                        var form = Form.pengadaanInAsset(setting);
                        if (jsonData !== null && jsonData !== undefined)
                        {
                            Ext.Object.each(jsonData,function(key,value,myself){
                            if(jsonData[key] == '0000-00-00')
                            {
                                jsonData[key] = '';
                            }
                        });
                            form.getForm().setValues(jsonData);
                        }
                        Tab.addToForm(form, 'perlengkapan-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        Perlengkapan.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPemeliharaan(Perlengkapan.dataStorePemeliharaan, dataForm, true)
//                Tab.addToForm(form, 'asset_perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
            }
        };

        Perlengkapan.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id,
                        umur:obj.data.umur,
                        cycle:obj.data.cycle,
                        kd_lokasi:obj.data.kd_lokasi,
                        no_aset:obj.data.no_aset,
                        kd_brg:obj.data.kd_brg,
                    };
                    arrayDeleted.push(data);
                });
                Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO, 
                icon: Ext.Msg.Question,
                fn: function(btn) {
                    if (btn === 'yes')
                    {
                        /*debugger;*/
                        var dataSend = {
                            data: arrayDeleted
                        };

                        $.ajax({
                            type: 'POST',
                            data: dataSend,
                            dataType: 'json',
                            url:  Perlengkapan.URL.removePemeliharaan,
                            success: function(data) {
                                 Perlengkapan.dataStorePemeliharaan.load();
//                                 Perlengkapan.Data.load();
                                 $.ajax({
                                                url:BASE_URL + 'pemeliharaan_perlengkapan/getLatestUmur',
                                                type: "POST",
                                                dataType:'json',
                                                async:false,
                                                data:{kd_brg:arrayDeleted[0].kd_brg, kd_lokasi:arrayDeleted[0].kd_lokasi, no_aset:arrayDeleted[0].no_aset},
                                                success:function(response, status){
                                                    if(status == "success")
                                                    {
                                                        var fieldUmur = Ext.getCmp('asset_perlengkapan_umur');
                                                        var fieldCycle = Ext.getCmp('asset_perlengkapan_cycle');
                                                        if(fieldUmur != undefined && fieldUmur !=null)
                                                        {
                                                            fieldUmur.setValue(response.umur);
                                                        }
                                                        if(fieldCycle != undefined && fieldCycle !=null)
                                                        {
                                                            fieldCycle.setValue(response.cycle);
                                                        }
                                                    }

                                                }
                                 });
                            }
                        });
                    }
                }
            })
//                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePemeliharaan, Perlengkapan.dataStorePemeliharaan);
            }
        };


        Perlengkapan.Action.pemeliharaanAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            var form = Perlengkapan.Form.createPemeliharaan(Perlengkapan.dataStorePemeliharaan, dataForm, false);
            
//            Tab.addToForm(form, 'asset_perlengkapan-add-pemeliharaan', 'Add Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
        };
        
        Perlengkapan.Action.pemeliharaanSubPartEdit = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPemeliharaanSubPart(Perlengkapan.dataStorePemeliharaanSubPart, dataForm, true)
//                Tab.addToForm(form, 'asset_perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
            }
        };

        Perlengkapan.Action.pemeliharaanSubPartRemove = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_part').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id,
                        id_sub_part: obj.data.id_sub_part,
                        umur:obj.data.umur,
                        cycle:obj.data.cycle
                    };
                    arrayDeleted.push(data);
                });
                Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO, 
                icon: Ext.Msg.Question,
                fn: function(btn) {
                    if (btn === 'yes')
                    {
                        /*debugger;*/
                        var dataSend = {
                            data: arrayDeleted
                        };

                        $.ajax({
                            type: 'POST',
                            data: dataSend,
                            dataType: 'json',
                            url:  Perlengkapan.URL.removePemeliharaanSubPart,
                            success: function(data) {
                                  Perlengkapan.dataStorePemeliharaanSubPart.load();
//                                debugger;
//                                 var grid_sub_part = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_part');
//                                            if(grid_sub_part != null)
//                                            {
//                                                grid_sub_part.getStore().load();
//                                            }
//                                 Perlengkapan.Data.load();
//                                 $.ajax({
//                                                url:BASE_URL + 'pemeliharaan_perlengkapan/getLatestUmur',
//                                                type: "POST",
//                                                dataType:'json',
//                                                async:false,
//                                                data:{kd_brg:arrayDeleted[0].kd_brg, kd_lokasi:arrayDeleted[0].kd_lokasi, no_aset:arrayDeleted[0].no_aset},
//                                                success:function(response, status){
//                                                    if(status == "success")
//                                                    {
//                                                        Ext.getCmp('asset_perlengkapan_umur').setValue(response);
//                                                    }
//
//                                                }
//                                 });
                            }
                        });
                    }
                }
            })
//                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePemeliharaan, Perlengkapan.dataStorePemeliharaan);
            }
        };


        Perlengkapan.Action.pemeliharaanSubPartAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
            };
            Reference.Data.subPartPemeliharaan.changeParams({params:{id_open:1,id_part:data.id}});
            var form = Perlengkapan.Form.createPemeliharaanSubPart(Perlengkapan.dataStorePemeliharaanSubPart, dataForm, false);
            
//            Tab.addToForm(form, 'asset_perlengkapan-add-pemeliharaan', 'Add Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
        };
        
        
         Perlengkapan.Action.pemeliharaanSubSubPartEdit = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_sub_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPemeliharaanSubSubPart(Perlengkapan.dataStorePemeliharaanSubSubPart, dataForm, true)
//                Tab.addToForm(form, 'asset_perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
            }
        };

        Perlengkapan.Action.pemeliharaanSubSubPartRemove = function() {
            var selected = Ext.getCmp('asset_perlengkapan_grid_pemeliharaan_sub_sub_part').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id,
                        id_sub_sub_part: obj.data.id_sub_sub_part,
                        umur:obj.data.umur,
                        cycle:obj.data.cycle
                    };
                    arrayDeleted.push(data);
                });
                Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO, 
                icon: Ext.Msg.Question,
                fn: function(btn) {
                    if (btn === 'yes')
                    {
                        /*debugger;*/
                        var dataSend = {
                            data: arrayDeleted
                        };

                        $.ajax({
                            type: 'POST',
                            data: dataSend,
                            dataType: 'json',
                            url:  Perlengkapan.URL.removePemeliharaanSubSubPart,
                            success: function(data) {
                                 Perlengkapan.dataStorePemeliharaanSubSubPart.load();
//                                 Perlengkapan.Data.load();
//                                 $.ajax({
//                                                url:BASE_URL + 'pemeliharaan_perlengkapan/getLatestUmur',
//                                                type: "POST",
//                                                dataType:'json',
//                                                async:false,
//                                                data:{kd_brg:arrayDeleted[0].kd_brg, kd_lokasi:arrayDeleted[0].kd_lokasi, no_aset:arrayDeleted[0].no_aset},
//                                                success:function(response, status){
//                                                    if(status == "success")
//                                                    {
//                                                        Ext.getCmp('asset_perlengkapan_umur').setValue(response);
//                                                    }
//
//                                                }
//                                 });
                            }
                        });
                    }
                }
            })
//                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePemeliharaan, Perlengkapan.dataStorePemeliharaan);
            }
        };


        Perlengkapan.Action.pemeliharaanSubSubPartAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
            };
            Reference.Data.subPartPemeliharaan.changeParams({params:{id_open:1,id_part:data.id}});
            var form = Perlengkapan.Form.createPemeliharaanSubSubPart(Perlengkapan.dataStorePemeliharaanSubSubPart, dataForm, false);
            
//            Tab.addToForm(form, 'asset_perlengkapan-add-pemeliharaan', 'Add Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
        };


        Perlengkapan.Action.pemeliharaanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStorePemeliharaan.load();
                
                Perlengkapan.dataStorePemeliharaanSubPart.changeParams({params:{id:data.id}});
                Perlengkapan.dataStorePemeliharaanSubSubPart.changeParams({params:{id:data.id}});
                
                var toolbarIDs = {};
                toolbarIDs.idGrid = "asset_perlengkapan_grid_pemeliharaan";
                toolbarIDs.add = Perlengkapan.Action.pemeliharaanAdd;
                toolbarIDs.remove = Perlengkapan.Action.pemeliharaanRemove;
                toolbarIDs.edit = Perlengkapan.Action.pemeliharaanEdit;
                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isPerlengkapan: true,
                    dataMainGrid: Perlengkapan.data,
                };
        
                var toolbarSubPartIDs = {};
                toolbarSubPartIDs.idGrid = "asset_perlengkapan_grid_pemeliharaan_sub_part";
                toolbarSubPartIDs.add = Perlengkapan.Action.pemeliharaanSubPartAdd;
                toolbarSubPartIDs.remove = Perlengkapan.Action.pemeliharaanSubPartRemove;
                toolbarSubPartIDs.edit = Perlengkapan.Action.pemeliharaanSubPartEdit;
                var setting_sub_part = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePemeliharaanSubPart,
                    toolbar: toolbarSubPartIDs,
                    isPerlengkapan: true,
                    dataMainGrid: Perlengkapan.data,
                };
        
                var toolbarSubSubPartIDs = {};
                toolbarSubSubPartIDs.idGrid = "asset_perlengkapan_grid_pemeliharaan_sub_sub_part";
                toolbarSubSubPartIDs.add = Perlengkapan.Action.pemeliharaanSubSubPartAdd;
                toolbarSubSubPartIDs.remove = Perlengkapan.Action.pemeliharaanSubSubPartRemove;
                toolbarSubSubPartIDs.edit = Perlengkapan.Action.pemeliharaanSubSubPartEdit;
                var setting_sub_sub_part = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePemeliharaanSubSubPart,
                    toolbar: toolbarSubSubPartIDs,
                    isPerlengkapan: true,
                    dataMainGrid: Perlengkapan.data,
                };
        
//                var subcomponent = {
//                        xtype: 'fieldset',
//                        layout: 'anchor',
//                        anchor: '100%',
//                        height: (edit==true)?325:150,
//                        title: 'Perlengkapan Angkutan Darat',
//                        border: false,
//                        frame: true,
//                        defaultType: 'container',
//                        defaults: {
//                            layout: 'anchor'
//                        },
//                        items: [(edit==true)?{xtype:'container',height:300,items:[Grid.angkutanDaratPerlengkapan(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
//                };
                
                var _perlengkapanPemeliharaanGrid = [{
                    xtype: 'container',
                    layout: 'anchor',
                    anchor: '100%',
                    items: [
                       {
                            layout: 'anchor',
                            items: [{xtype:'container',height:300,items:[Grid.pemeliharaanPerlengkapanGrid(setting)]},
                                    {xtype:'container',style: {marginTop: '10px'},height:300,items:[Grid.pemeliharaanPerlengkapanSubPartGrid(setting_sub_part)]},
                                    {xtype:'container',style: {marginTop: '10px'},height:300,items:[Grid.pemeliharaanPerlengkapanSubSubPartGrid(setting_sub_sub_part)]}
                                ]
                        }]
                }];
                
                
//                var _perlengkapanPemeliharaanGrid = Grid.pemeliharaanPerlengkapanGrid(setting);
                Tab.addToForm(_perlengkapanPemeliharaanGrid, 'perlengkapan-pemeliharaan', 'Pemeliharaan');
            }
        };
        
        
        

        Perlengkapan.Action.add = function() {
            var _form = Perlengkapan.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Perlengkapan');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Perlengkapan.Action.edit = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length <= 1)
                {
                    Modal.assetEdit.setTitle('Edit Perlengkapan');
                    Modal.assetEdit.insert(0, Region.createSidePanel(Perlengkapan.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Perlengkapan.Form.create(data, true);
                Perlengkapan.dataStoreSubPart.changeParams({params:{open:'1',id_part:data.id}});
                Tab.addToForm(_form, 'perlengkapan-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.remove = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_lokasi: obj.data.kd_lokasi,
                    kd_brg: obj.data.kd_brg,
                    no_aset: obj.data.no_aset,
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
//            Asset.Window.createDeleteAlert(arrayDeleted, Perlengkapan.URL.remove, Perlengkapan.Data);
            Modal.deleteAlert(arrayDeleted,Perlengkapan.URL.remove,Perlengkapan.Data);
        };

        Perlengkapan.Action.print = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Perlengkapan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
            var gridHeaderList = "";
            //index starts at 2 to exclude the No. column
            for (var i = 2; i < gridHeader.length; i++)
            {
                if (gridHeader[i].dataIndex === undefined || gridHeader[i].dataIndex === "") //filter the action columns in grid
                {
                    //do nothing
                }
                else
                {
                    gridHeaderList += gridHeader[i].text + "&&" + gridHeader[i].dataIndex + "^^";
                }
            }
            var serverSideModelName = "Asset_Perlengkapan_Model";
            var title = "Perlengkapan";
            var primaryKeys = "id";

            var my_form = document.createElement('FORM');
            my_form.name = 'myForm';
            my_form.method = 'POST';
            my_form.action = BASE_URL + 'excel_management/exportToExcel/';

            var my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'serverSideModelName';
            my_tb.value = serverSideModelName;
            my_form.appendChild(my_tb);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'title';
            my_tb.value = title;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'primaryKeys';
            my_tb.value = primaryKeys;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'gridHeaderList';
            my_tb.value = gridHeaderList;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'selectedData';
            my_tb.value = selectedData;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_form.submit();
        };

		Perlengkapan.Action.printpdf = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_lokasi + "||" + selected[i].data.kd_brg + "||" + selected[i].data.no_aset;  
                }
            }
            var arrayPrintpdf = [];
            var data = selected[0].data;
            _.each(selected, function(obj) {
                var data = {
                    kd_lokasi: obj.data.kd_lokasi,
                    kd_brg: obj.data.kd_brg,
                    no_aset: obj.data.no_aset
                };
                arrayPrintpdf.push(data);
            });
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_perlengkapan/cetak/' + selectedData, 'Cetak Pengelolaan Asset Perlengkapan');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_aset_perlengkapan',
                title: 'DAFTAR ASSET PERLENGKAPAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kelompok Part', dataIndex: 'nama_kelompok', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Jenis Angkutan', dataIndex: 'jenis_asset', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Part', dataIndex: 'nama_part', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Serial Number', dataIndex: 'serial_number', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Induk Asset', dataIndex: 'no_induk_asset', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Warehouse', dataIndex: 'nama_warehouse', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Ruang', dataIndex: 'nama_ruang', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Rak', dataIndex: 'nama_rak', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Umur', dataIndex: 'umur', width: 150, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Id Warehouse', dataIndex: 'warehouse_id', hidden: true, width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Ruang', dataIndex: 'ruang_id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Rak', dataIndex: 'rak_id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden:true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 90, hidden:true, groupable: false, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Perolehan', dataIndex: 'tanggal_perolehan', hidden: true, width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 150,hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Penggunaan Waktu', dataIndex: 'penggunaan_waktu', width: 150, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Penggunaan Freq', dataIndex: 'penggunaan_freq', width: 70, groupable: false,hidden: true, filter: {type: 'numeric'}},
                    {header: 'Unit Waktu', dataIndex: 'unit_waktu', width: 70, groupable: false,hidden: true, filter: {type: 'numeric'}},
                    {header: 'Unit Freq', dataIndex: 'unit_freq', width: 90, groupable: false,hidden: true, filter: {type: 'string'}},
                    {header: 'Disimpan', dataIndex: 'disimpan', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Dihapus', dataIndex: 'dihapus', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Image Url', dataIndex: 'image_url', width: 50, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Document Url', dataIndex: 'document_url', width: 50, hidden: true, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_perlengkapan'
            },
            toolbar: {
                id: 'toolbar_perlengkapan',
                prefix:'asset_perlengkapan', //semar
                add: {
                    id: 'button_add_perlengkapan',
                    action: Perlengkapan.Action.add
                },
                edit: {
                    id: 'button_edit_perlengkapan',
                    action: Perlengkapan.Action.edit
                },
                remove: {
                    id: 'button_remove_perlengkapan',
                    action: Perlengkapan.Action.remove
                },
                print: {
                    id: 'button_pring_perlengkapan',
                    action: Perlengkapan.Action.print
                }
            }
        };

        Perlengkapan.Grid.grid = Grid.inventarisGrid(setting, Perlengkapan.Data,true);


        var new_tabpanel_Asset = {
            id: 'perlengkapan_panel', title: 'Perlengkapan', iconCls: 'icon-perlengkapan_perlengkapan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAsetPerlengkapan(Perlengkapan.Data,'perlengkapan'),Perlengkapan.Grid.grid]
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>