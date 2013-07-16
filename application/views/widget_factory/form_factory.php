<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    ///////////

        Ext.namespace('Reference', 'Reference.URL', 'Reference.Data', 'Reference.Properties');
        Ext.namespace('Form', 'Form.Component', 'Modal');
        Ext.namespace('Utils');

        Reference.URL = {
            unker: BASE_URL + 'combo_ref/combo_simak_unker',
            unor: BASE_URL + 'combo_ref/combo_unor',
            ruang: BASE_URL + 'combo_ref/combo_ruang',
            upImage: BASE_URL + 'upload_file/imageUpload',
            deleteImage: BASE_URL + 'upload_file/imageDelete',
            upDocument: BASE_URL + 'upload_file/documentUpload',
            deleteDocument: BASE_URL + 'upload_file/documentDelete',
            golongan: BASE_URL + 'combo_ref/combo_assetgolongan',
            bidang: BASE_URL + 'combo_ref/combo_assetbidang',
            kelompok: BASE_URL + 'combo_ref/combo_kelompok',
            subKelompok: BASE_URL + 'combo_ref/combo_subKelompok',
            subsubKelompok: BASE_URL + 'combo_ref/combo_subsubKelompok',
            imageBasePath: BASE_URL + '/uploads/images/',
            documentBasePath: BASE_URL + '/uploads/documents/'
        };

        Reference.Data.unker = new Ext.create('Ext.data.Store', {
            fields: ['kdlok', 'ur_upb'], idProperty: 'ID_UK', storeId: 'DataUnker',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.unker, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });

        Reference.Data.unor = new Ext.create('Ext.data.Store', {
            fields: ['kode_unor', 'nama_unor', 'kd_lokasi'], storeId: 'DataUnor',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.unor, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_lokasi: 0}
            }),
            autoLoad: true
        });
        
        Reference.Data.ruang = new Ext.create('Ext.data.Store', {
            fields: ['kd_ruang', 'ur_ruang'], storeId: 'DataRuang',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.ruang, actionMethods: {read: 'POST'}, extraParams: {kd_lokasi: 0}
            }),
            autoLoad: true
        });

        Reference.Data.unitWaktu = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Day', value: 1}, {text: 'Month', value: 2}, {text: 'Year', value: 3}]
        });
        
        Reference.Data.unitPengunaan = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Meter', value: 1}, {text: 'Kilometer', value: 2}, {text: 'Mil', value: 3}]
        });
        
        Reference.Data.jenisPemeliharaan = new Ext.create('Ext.data.Store', {
            fields: ['nama', 'id'],
            data: [{nama: 'Predictive', id: 1}, {nama: 'Preventive', id: 2}, {nama: 'Corrective', id: 3}]
        });

        Reference.Data.jenisPemeliharaanBangunan = new Ext.create('Ext.data.Store', {
            fields: ['nama', 'id'],
            data: [{nama: 'Pemeliharaan', id: 1}, {nama: 'Perawatan', id: 2}]
        });

        Reference.Data.jenisSubPemeliharaanBangunan = new Ext.create('Ext.data.Store', {
            fields: ['nama', 'id'],
            data: [{nama: 'Arsitektural', id: 1}, {nama: 'Struktural', id: 2}, {nama: 'Mekanikal', id: 3},
                {nama: 'Elektrikal', id: 4}, {nama: 'Tata Ruang Luar', id: 5},
                {nama: 'Tata Graha (House Keeping)', id: 6}, {nama: 'Rehabilitasi', id: 11},
                {nama: 'Renovasi', id: 12}, {nama: 'Restorasi', id: 13},
                {nama: 'Perawatan Kerusakan', id: 14}]
        });

        Reference.Data.jenisSubPemeliharaanBangunanPemeliharaan = new Ext.create('Ext.data.Store', {
            fields: ['nama', 'id'],
            data: [{nama: 'Arsitektural', id: 1}, {nama: 'Struktural', id: 2}, {nama: 'Mekanikal', id: 3},
                {nama: 'Elektrikal', id: 4}, {nama: 'Tata Ruang Luar', id: 5},
                {nama: 'Tata Graha (House Keeping)', id: 6}]
        });

        Reference.Data.jenisSubPemeliharaanBangunanPerawatan = new Ext.create('Ext.data.Store', {
            fields: ['nama', 'id'],
            data: [{nama: 'Rehabilitasi', id: 11}, {nama: 'Renovasi', id: 12}, {nama: 'Restorasi', id: 13},
                {nama: 'Perawatan Kerusakan', id: 14}]
        });

    // url : image full path, name : file name exist in the folder
        Reference.Data.photo = new Ext.create('Ext.data.Store', {
            fields: ['url', 'name']
        });

    // url : document full path, name : name displayed on grid, filename : file name exist in the folder
        Reference.Data.document = new Ext.create('Ext.data.Store', {
            fields: ['url', 'name']
        });

        Reference.Data.year = new Ext.create('Ext.data.Store', {
            fields: ['year'],
            data: [{year: '1980'},
                {year: '1981'}, {year: '1982'}, {year: '1983'}, {year: '1984'}, {year: '1985'},
                {year: '1986'}, {year: '1987'}, {year: '1988'}, {year: '1989'}, {year: '1990'},
                {year: '1991'}, {year: '1992'}, {year: '1993'}, {year: '1994'}, {year: '1995'},
                {year: '1996'}, {year: '1997'}, {year: '1998'}, {year: '1999'}, {year: '2000'},
                {year: '2001'}, {year: '2002'}, {year: '2003'}, {year: '2004'}, {year: '2005'},
                {year: '2006'}, {year: '2007'}, {year: '2008'}, {year: '2009'}, {year: '2010'},
                {year: '2011'}, {year: '2012'}, {year: '2013'}, {year: '2014'}, {year: '2015'},
                {year: '2016'}, {year: '2017'}, {year: '2018'}, {year: '2019'}, {year: '2020'}]
        });

        Reference.Data.golongan = new Ext.create('Ext.data.Store', {
            fields: ['kd_gol', 'ur_gol'], storeId: 'DataGolongan',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.golongan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });

        Reference.Data.bidang = new Ext.create('Ext.data.Store', {
            fields: ['kd_bid', 'ur_bid'], storeId: 'DataBidang',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.bidang, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_gol: 0}
            }),
            autoLoad: true
        });

        Reference.Data.kelompok = new Ext.create('Ext.data.Store', {
            fields: ['kd_kel', 'ur_kel'], storeId: 'DataKelompok',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.kelompok, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_gol: 0, kd_bid: 0}
            }),
            autoLoad: true
        });

        Reference.Data.subKelompok = new Ext.create('Ext.data.Store', {
            fields: ['kd_skel', 'ur_skel'],
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.subKelompok, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_gol: 0, kd_bid: 0, kd_kel: 0}
            }),
            autoLoad: true
        });

        Reference.Data.subSubKelompok = new Ext.create('Ext.data.Store', {
            fields: ['kd_sskel', 'ur_sskel'],
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.subsubKelompok, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0}
            }),
            autoLoad: false
        });

        Utils.clearWindowEdit = function() {
            var _tab = Modal.assetEdit.getComponent('asset-window-tab');
            _tab.removeAll(true);
        };

        Utils.addImageUrlField = function(form) {
            var imageField = form.findField('image_url');

            if (imageField !== null)
            {
                var array = [];
                _.each(Reference.Data.photo.data.items, function(obj) {
                    array.push(obj.data.name);
                });

                imageField.setValue(array.join());
            }
        };

        Utils.addDocumentUrlField = function(form) {
            var documentField = form.findField('document_url');

            if (documentField !== null)
            {
                var array = [];
                _.each(Reference.Data.document.data.items, function(obj) {
                    array.push(obj.data.name);
                });

                documentField.setValue(array.join());
            }
        };
        
        // use to get data store for photo view in form
        Utils.getPhotoStore = function(form){
            var dataStore = null;
            if (form !== null)
            {
                dataStore = form.getComponent('fileUpload').getComponent('photoColumn').getComponent('photoPanel').getComponent('photoView').getStore();
            }
            
            return dataStore;
        }
        
        Utils.getUnkerCombo = function(form){
            var unkerCombo = null;
            
            if (form !== null)
            {
                unkerCombo = form.getForm().findField("nama_unker");
            
            }
            
            return unkerCombo;
        }
        
        // use to get data store for document grid in form
        Utils.getDocumentStore = function(form){
            var dataStore = null;
            if (form !== null)
            {
                dataStore = form.getComponent('fileUpload').getComponent('documentColumn').getComponent('documentGrid').getStore();
            }
            
            return dataStore;
        }


        Form.pengadaan = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing));
            form.insert(2, Form.Component.pengadaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        };
        
        Form.pengadaanInAsset = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
            form.insert(2, Form.Component.pengadaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        }

        Form.perencanaan = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(2, Form.Component.perencanaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        };


        Form.pemeliharaan = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(3, Form.Component.fileUpload());

            if (setting.isBangunan)
            {
                form.insert(2, Form.Component.pemeliharaanBangunan());
            }
            else
            {
                form.insert(2, Form.Component.pemeliharaan());
            }

            return form;
        };
        
        Form.pemeliharaanInAsset = function(setting){
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
            form.insert(3, Form.Component.fileUpload());
            
            if (setting.isBangunan)
            {
                form.insert(2, Form.Component.pemeliharaanBangunan(form.getForm()));
            }
            else
            {
                form.insert(2, Form.Component.pemeliharaan(form.getForm()));
            }
            
            return form;
        }

        Form.penghapusan = function(setting)
        {

        }
        
        Form.assetRuang = function(setting)
        {
            var form = Form.asset(setting.url, setting.data, setting.isEditing);
            
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.kode(setting.isEditing));
            form.insert(2, Form.Component.ruang(form));
            form.insert(3, Form.Component.fileUpload(setting.isEditing));
            
            return form;
        }

        Form.process = function(url, data, edit, addBtn) {
            var _form = Ext.create('Ext.form.Panel', {
                frame: true,
                url: url,
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                trackResetOnLoad:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', id: 'save_process', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var imageField = form.findField('image_url');
                            var documentField = form.findField('document_url');
                            
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = Utils.getPhotoStore(_form);
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Utils.getDocumentStore(_form);
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            console.log(form.getValues());
                            
                            if (form.isValid())
                            {
                                console.log(form.getValues());
                                form.submit({
                                    success: function(form) {
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        
                                        if (data !== null)
                                        {
                                            data.load();
                                        }
                                        
                                        if (edit)
                                        {
                                            Modal.closeProcessWindow();
                                        }
                                        else
                                        {
                                            form.reset();
                                        }


                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                    }
                                });
                            }
                            
                        }
                    }, {
                        text: addBtn.text, iconCls: 'icon-add', hidden: addBtn.isHidden,
                        handler: addBtn.fn
                    }]
            });


            return _form;
        };

        Form.asset = function(url, data, edit) {
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
                        text: 'Simpan', id: 'save_asset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var imageField = form.findField('image_url');
                            var documentField = form.findField('document_url');
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = Utils.getPhotoStore(_form);
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Utils.getDocumentStore(_form);
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function() {
                                        data.load();
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');

                                        if (!edit)
                                        {
                                            Modal.closeAssetWindow();
                                        }
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

        Form.Component.unit = function(edit,form) {
            var component = {
                xtype: 'fieldset',
                itemId : 'unit_selection',
                title: 'UNIT',
                layout: 'column',
                border: false,
                defaultType: 'container',
                margin: 0,
                items: [{
                        defaultType: 'hidden',
                        items: [{
                                name: 'kd_lokasi',
                                id: 'kd_lokasi',
                                listeners: {
                                    change: function(ob, value) {
                                        if (edit)
                                        {
                                            var comboUnker = Ext.getCmp('nama_unker');
                                            if (comboUnker !== null)
                                            {
                                                comboUnker.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kode_unor',
                                id: 'kode_unor',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboUnor = Ext.getCmp('nama_unor');
                                            if (comboUnor !== null)
                                            {
                                                comboUnor.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'id',
                                id: 'id'
                            }]
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        itemId:'column_unker',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Unit Kerja *',
                                name: 'nama_unker',
                                id: 'nama_unker',
                                itemId: 'unker',
                                allowBlank: false,
                                store: Reference.Data.unker,
                                valueField: 'kdlok',
                                displayField: 'ur_upb', emptyText: 'Pilih Unit Kerja',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {

//                                            if (value !== null)
//                                            {
//                                                var unorField = Ext.getCmp('nama_unor');
//                                                var kodeUnkerField = Ext.getCmp('kd_lokasi');
//                                                if (unorField !== null && kodeUnkerField !== null) {
//                                                    if (value.length > 0) {
//                                                        unorField.enable();
//                                                        kodeUnkerField.setValue(value);
//                                                        Reference.Data.unor.changeParams({params: {id_open: 1, kode_unker: value}});
//                                                    }
//                                                    else {
//                                                        unorField.disable();
//                                                    }
//                                                }
//                                                else {
//                                                    console.error('unit organisasi could not be found');
//                                                }
//                                            }

                                        },
                                        scope: this
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: ' Unit Organisasi',
                                name: 'nama_unor',
                                id: 'nama_unor',
                                disabled: false,
                                allowBlank: true,
                                store: Reference.Data.unor,
                                valueField: 'kode_unor',
                                displayField: 'nama_unor', emptyText: 'Pilih Unit Organisasi',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            var dataStore = comboField.getStore();
                                            var kd_lokasi = Utils.getUnkerCombo(form).getValue();
                                            if (kd_lokasi !== null)
                                            {
                                                console.log(Utils.getUnkerCombo(form).getValue());
                                                dataStore.clearFilter();
                                                dataStore.filter({property:"kd_lokasi", value:kd_lokasi});
                                            }
                                            comboField.expand();
                                            
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var kodeUnorField = form.getForm().findField('kode_unor');
                                            if (kodeUnorField !== null && !isNaN(value)) {
                                                kodeUnorField.setValue(value);
                                                console.log(kodeUnorField.getValue());
                                            }
                                        }
                                    }
                                }
                            }]
                    }]
            };


            return component;
        };

        Form.Component.fileUpload = function(edit) {
            
            var photoStore = new Ext.create('Ext.data.Store', {
                                        fields: ['url', 'name']
                                    });
                                    
            var documentStore = new Ext.create('Ext.data.Store', {
                                        fields: ['url', 'name']
                                    })
            
            var component = {
                xtype: 'fieldset',
                itemId: 'fileUpload',
                layout: 'column',
                border: false,
                title: 'FILE UPLOAD',
                defaultType: 'container',
                style: {
                    marginTop: '10px'
                },
                items: [{
                        xtype: 'hidden',
                        name: 'image_url',
                        listeners: {
                            change: function(obj, value) {
                                
                                if (value !== null & value.length > 0)
                                {
                                    
                                    _.each(value.split(','), function(img) {
                                        var fullPath = Reference.URL.imageBasePath + img;
                                        photoStore.add({url: fullPath, name: img});

                                    });
                                }
                            }
                        }
                    }, {
                        xtype: 'hidden',
                        name: 'document_url',
                        listeners: {
                            change: function(obj, value) {

                                if (value !== null && value.length > 0)
                                {
                                    _.each(value.split(','), function(doc) {
                                        var fullPath = Reference.URL.documentBasePath + doc;
                                        documentStore.add({url: fullPath, name: doc});
                                    });
                                }
                            }
                        }
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        itemId : 'photoColumn',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{// IMAGE
                                xtype : 'panel',
                                itemId : 'photoPanel',
                                frame : true,
                                height : 90,
                                style : {
                                    marginBottom: '10px'
                                },
                                items: Ext.create('Ext.view.View', {
                                    store: photoStore,
                                    itemId: 'photoView',
                                    tpl: [
                                        '<tpl for=".">',
                                        '<div class="thumb-wrap" id="{name}" style="float:left; padding:5px">',
                                        '<div class="thumb"><img src="{url}" height="70" width="70"></div>',
                                        '</div>',
                                        '</tpl>',
                                        '<div class="x-clear"></div>'
                                    ],
                                    height: 80,
                                    emptyText: 'No image',
                                    itemSelector: 'div.thumb-wrap',
                                    prepareData: function(data) {
                                        Ext.apply(data);
                                        return data;
                                    },
                                    listeners: {
                                        itemmouseenter: function(view, record, item, index) {
                                            console.log('photo hover');
                                        },
                                        itemclick: function(view, record, item, index) {
                                            var data = record.data;

                                            var dataSend = {
                                                file: data.name
                                            };

                                            $.ajax({
                                                type: 'POST',
                                                dataType: 'json',
                                                data: dataSend,
                                                url: Reference.URL.deleteImage,
                                                success: function(res) {
                                                    if (res.success)
                                                    {
                                                        var recordToRemove = photoStore.findRecord('name', data.name);
                                                        if (recordToRemove !== null)
                                                        {
                                                            photoStore.remove(recordToRemove);
                                                            console.log(photoStore.count());
                                                        }
                                                        else
                                                        {
                                                            console.error('could not found the expected image');
                                                        }
                                                    }
                                                    else
                                                    {
                                                        console.error('fail to delete image');
                                                    }
                                                }
                                            });
                                        }
                                    }
                                })
                            }, {
                                xtype : 'filefield',
                                name : 'userfile',
                                buttonOnly: true,
                                buttonText: 'Add Photo',
                                listeners: {
                                    'change': {
                                        fn: function() {
                                            var tempForm = Ext.create('Ext.form.Panel', {
                                                url: Reference.URL.upImage,
                                                items: this
                                            });

                                            tempForm.getForm().submit({
                                                waitMsg: 'Uploading your photo...',
                                                success: function(response, action) {
                                                    console.log('success');
                                                    var res = action.result.upload_data;
                                                    var fullPath = Reference.URL.imageBasePath + res.file_name;
                                                    photoStore.add({url: fullPath, name: res.file_name});
                                                },
                                                failure: function(response, action) {
                                                    console.log('fail');
                                                    console.log(response);
                                                    console.log(action);
                                                }
                                            });
                                        }
                                    }
                                }
                            }]//IMAGE END
                    }, {// DOCUMENT START
                        columnWidth: .5,
                        layout: 'anchor',
                        itemId: 'documentColumn',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{// DOCUMENT START
                                xtype: 'gridpanel',
                                itemId : 'documentGrid',
                                store: documentStore,
                                columnWidth: .5,
                                width: '100%',
                                height: 90,
                                style: {
                                    marginBottom: '10px'
                                },
                                columns: [{
                                        text: 'Document Name',
                                        dataIndex: 'name',
                                        width: 200
                                    }, {
                                        xtype: 'actioncolumn',
                                        width: 50,
                                        items: [{
                                                icon: '../basarnas/assets/images/icons/delete.png',
                                                tooltipe: 'Remove Document',
                                                handler: function(grid, rowIndex, colIndex, obj) {
                                                    var record = documentStore.getAt(rowIndex);

                                                    var dataSend = {
                                                        file: record.data.name
                                                    };

                                                    $.ajax({
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: dataSend,
                                                        url: Reference.URL.deleteDocument,
                                                        success: function(res) {
                                                            if (res.success)
                                                            {
                                                                console.log(res);
                                                                documentStore.remove(record);
                                                            }
                                                            else
                                                            {
                                                                console.error('failed to remove');
                                                            }
                                                        }
                                                    });


                                                }
                                            }]
                                    }]
                            }, {
                                xtype: 'filefield',
                                name: 'userfile',
                                width: 100,
                                buttonOnly: true,
                                buttonText: 'Add Document',
                                listeners: {
                                    'change': {
                                        fn: function() {
                                            var tempForm = Ext.create('Ext.form.Panel', {
                                                url: Reference.URL.upDocument,
                                                items: this
                                            });

                                            tempForm.getForm().submit({
                                                waitMsg: 'Uploading your document...',
                                                success: function(response, action) {
                                                    var res = action.result.upload_data;
                                                    var fullPath = Reference.URL.documentBasePath + res.file_name;
                                                    documentStore.add({url:fullPath, name: res.file_name});
                                                },
                                                failure: function(response, action) {
                                                    console.error('fail');
                                                    console.log(action);
                                                    Ext.Msg.alert('Fail',action.result.error);
                                                }
                                            });
                                        }
                                    }
                                }
                            }]
                    }]// DOCUMENT END
            };

            return component;
        };

        Form.Component.basicAsset = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'ASSET',
                border: false,
                defaultType: 'container',
                frame: true,
                items: [{
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 60
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kondisi',
                                name: 'kondisi'
                            }, {
                                fieldLabel: 'No KIB',
                                name: 'no_kib'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Unit Kerja',
                                name: 'unit_pmk'
                            }, {
                                fieldLabel: 'Catatan',
                                name: 'catatan'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Alamat Unit',
                                name: 'alm_pmk'
                            }, {
                                fieldLabel: 'Status',
                                name: 'status'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80,
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kuantitas',
                                name: 'kuantitas'
                            }, {
                                xtype: 'numberfield',
                                fieldLabel: 'Harga Wajar',
                                name: 'rphwajar'
                            }]
                    }]
            };


            return component;
        };

        Form.Component.selectionAsset = function(cmpSetting) {

            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'ASSET',
                border: false,
                defaultType: 'container',
                frame: true,
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kode Barang*',
                                name: 'kd_brg'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Nama',
                                name: 'nama',
                                editable: false
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'No Asset*',
                                name: 'no_aset',
                                hidden: cmpSetting.noAsetHidden,
                                disabled: cmpSetting.noAsetHidden,
                                editable: false
                            }]
                    }]
            };


            return component;
        };

        Form.Component.kode = function(edit) {

            var component = {
                xtype: 'fieldset',
                title: 'KODE',
                layout: 'column',
                border: false,
                defaultType: 'container',
                margin: 0,
                items: [{
                        defaultType: 'hidden',
                        items: [{
                                name: 'kd_gol',
                                id: 'kd_gol',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboGolongan = Ext.getCmp('nama_golongan');
                                            if (comboGolongan !== null)
                                            {
                                                comboGolongan.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_bid',
                                id: 'kd_bid',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboBidang = Ext.getCmp('nama_bidang');
                                            if (comboBidang !== null)
                                            {
                                                comboBidang.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_kelompok',
                                id: 'kd_kelompok',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboKelompok = Ext.getCmp('nama_kelompok');
                                            if (comboKelompok !== null)
                                            {
                                                comboKelompok.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_skel',
                                id: 'kd_skel',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboSubKelompok = Ext.getCmp('nama_subkel');
                                            if (comboSubKelompok !== null)
                                            {
                                                comboSubKelompok.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_sskel',
                                id: 'kd_sskel',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboSubSubKelompok = Ext.getCmp('nama_subsubkel');
                                            if (comboSubSubKelompok !== null)
                                            {
                                                comboSubSubKelompok.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .30,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Golongan',
                                name: 'nama_golongan',
                                id: 'nama_golongan',
                                hideLabel: false,
                                allowBlank: false,
                                store: Reference.Data.golongan,
                                valueField: 'kd_gol',
                                displayField: 'ur_gol', emptyText: 'Golongan',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Golongan',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            if (value !== null)
                                            {
                                                var bidangField = Ext.getCmp('nama_bidang');
                                                var golonganField = Ext.getCmp('kd_gol');
                                                if (golonganField !== null && bidangField !== null) {
                                                    if (!isNaN(value) && value.length > 0 || edit === true) {
                                                        bidangField.enable();
                                                        golonganField.setValue(value);
                                                        Reference.Data.bidang.changeParams({params: {id_open: 1, kd_gol: value}});
                                                    }
                                                    else {
                                                        bidangField.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('error');
                                                }
                                            }

                                        },
                                        scope: this
                                    }
                                }
                            },{
                                fieldLabel: 'Sub Kelompok',
                                name: 'nama_subkel',
                                id: 'nama_subkel',
                                disabled: true,
                                allowBlank: true,
                                store: Reference.Data.subKelompok,
                                valueField: 'kd_skel',
                                displayField: 'ur_skel', emptyText: 'Sub Kelompok',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Sub Kelompok',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var subSubKelompokField = Ext.getCmp('nama_subsubkel');
                                            var kelompokFieldValue = Ext.getCmp('kd_kelompok').getValue();
                                            var bidangFieldValue = Ext.getCmp('kd_bid').getValue();
                                            var golonganFieldValue = Ext.getCmp('kd_gol').getValue();
                                            var subkelField = Ext.getCmp('kd_skel');

                                            if (subkelField !== null && subSubKelompokField !== null && !isNaN(value)) {
                                                subkelField.setValue(value);
                                                subSubKelompokField.enable();
                                                Reference.Data.subSubKelompok.changeParams({params: {id_open: 1,
                                                        kd_gol: golonganFieldValue,
                                                        kd_bid: bidangFieldValue,
                                                        kd_kel: kelompokFieldValue,
                                                        kd_skel: value}});
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .40,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Bidang',
                                name: 'nama_bidang',
                                id: 'nama_bidang',
                                disabled: true,
                                allowBlank: true,
                                labelWidth : 110,
                                store: Reference.Data.bidang,
                                valueField: 'kd_bid',
                                displayField: 'ur_bid', emptyText: 'Bidang',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Bidang',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var kelompokField = Ext.getCmp('nama_kelompok');
                                            var bidangField = Ext.getCmp('kd_bid');
                                            var golonganField = Ext.getCmp('kd_gol').getValue();
                                            if (kelompokField !== null && bidangField !== null) {
                                                if (!isNaN(value) && value.length > 0 || edit === true) {
                                                    kelompokField.enable();
                                                    bidangField.setValue(value);
                                                    Reference.Data.kelompok.changeParams({params: {id_open: 1, kd_gol: golonganField, kd_bid: value}});
                                                }
                                                else {
                                                    kelompokField.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                        }
                                    }
                                }
                            },{
                                fieldLabel: 'SubSub Kelompok',
                                name: 'nama_subsubkel',
                                id: 'nama_subsubkel',
                                disabled: true,
                                allowBlank: true,
                                labelWidth: 110,
                                store: Reference.Data.subSubKelompok,
                                valueField: 'kd_sskel',
                                displayField: 'ur_sskel', emptyText: 'Sub Sub Kelompok',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Sub Sub Kelompok',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var subSubKelField = Ext.getCmp('kd_sskel');

                                            if (subSubKelField !== null && !isNaN(value)) {
                                                subSubKelField.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .30,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Kelompok',
                                name: 'nama_kelompok',
                                id: 'nama_kelompok',
                                disabled: true,
                                allowBlank: true,
                                labelWidth: 70,
                                store: Reference.Data.kelompok,
                                valueField: 'kd_kel',
                                displayField: 'ur_kel', emptyText: 'Kelompok',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Kelompok',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var subKelompokField = Ext.getCmp('nama_subkel');
                                            var kelompokField = Ext.getCmp('kd_kelompok');
                                            var bidangFieldValue = Ext.getCmp('kd_bid').getValue();
                                            var golonganFieldValue = Ext.getCmp('kd_gol').getValue();

                                            if (kelompokField !== null && subKelompokField !== null && !isNaN(value)) {
                                                kelompokField.setValue(value);
                                                subKelompokField.enable();
                                                Reference.Data.subKelompok.changeParams({params: {id_open: 1,
                                                        kd_gol: golonganFieldValue,
                                                        kd_bid: bidangFieldValue,
                                                        kd_kel: value}});
                                            }
                                        }
                                    }
                                }
                            },{
                                xtype : 'numberfield',
                                fieldLabel : 'No Asset',
                                labelWidth: 70,
                                name : 'no_aset',
                            }]
                    }]
            };


            return component;
        };
        
        Form.Component.address = function() {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'ADDRESS (* dibutuhkan)',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [{
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%'
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Provinsi',
                                    name: 'kd_prov'
                                }, {
                                    fieldLabel: 'Kelurahan',
                                    name: 'kd_kel'
                                }]
                        }, {
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%'
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Kabupaten',
                                    name: 'kd_kab'
                                }, {
                                    fieldLabel: 'RT/RW',
                                    name: 'kd_rtrw'
                                }]
                        }, {
                            columnWidth: .32,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%'
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Kecamatan',
                                    name: 'kd_kec'
                                }, {
                                    fieldLabel: 'alamat',
                                    name: 'alamat'
                                }]
                        }]
                }]

            return component;
        };

        Form.Component.mechanical = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL ALAT / KENDARAAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Merek',
                                name: 'merk'
                            }, {
                                fieldLabel: 'Tipe',
                                name: 'type'
                            }, {
                                fieldLabel: 'Pabrik',
                                name: 'pabrik'
                            }, {
                                fieldLabel: 'No Mesin',
                                name: 'no_mesin'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Tahun Buat',
                                name: 'thn_buat'
                            }, {
                                fieldLabel: 'Tahun Rakit',
                                name: 'thn_akit'
                            }, {
                                fieldLabel: 'Negara',
                                name: 'negara'
                            }, {
                                fieldLabel: 'No Rangka',
                                name: 'no_rangka'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Lengkap 1',
                                name: 'lengkap1'
                            }, {
                                fieldLabel: 'Lengkap 2',
                                name: 'lengkap2'
                            }, {
                                fieldLabel: 'Lengkap 3',
                                name: 'lengkap3'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.tambahanBangunanTanah = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Tambahan',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [{
                                fieldLabel: 'NJKP',
                                name: 'njkp'
                            }, {
                                fieldLabel: 'NOP',
                                name: 'nop'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'numberfield',
                                fieldLabel: 'Setoran Pajak',
                                name: 'setoran_pajak'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Waktu Pembayaran',
                                name: 'waktu_pembayaran',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textarea',
                        items: [{
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.bangunan = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL BANGUNAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [{
                                fieldLabel: 'Luas Dasar',
                                name: 'luas_dsr'
                            }, {
                                fieldLabel: 'Luas Bangunan',
                                name: 'luas_bdg'
                            }, {
                                fieldLabel: 'Lantai',
                                name: 'jml_lt'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Tahun Selesai',
                                name: 'thn_sls'
                            }, {
                                fieldLabel: 'Tahun Pakai',
                                name: 'thn_pakai'
                            }, {
                                fieldLabel: 'No KIB Tanah',
                                name: 'no_kibtnh'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'No IMB',
                                name: 'no_imb'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Tanggal IMB',
                                name: 'tgl_imb',
                                format: 'Y-m-d'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.tanah = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL TANAH',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .3,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [{
                                fieldLabel: 'Luas Seluruhnya',
                                name: 'luas_tnhs'
                            }, {
                                fieldLabel: 'Luas Bangunan',
                                name: 'luas_tnhb'
                            }, {
                                fieldLabel: 'Luas Lingkungan',
                                name: 'luas_tnhl'
                            }, {
                                fieldLabel: 'Luas Kosong',
                                name: 'luas_tnhk'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Utara',
                                name: 'batas_u'
                            }, {
                                fieldLabel: 'Barat',
                                name: 'batas_b'
                            }, {
                                fieldLabel: 'Timur',
                                name: 'batas_t'
                            }, {
                                fieldLabel: 'Selatan',
                                name: 'batas_s'
                            }]
                    }, {
                        columnWidth: .36,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Surat 1',
                                name: 'surat1'
                            }, {
                                fieldLabel: 'Surat 2',
                                name: 'surat2'
                            }, {
                                fieldLabel: 'Surat 3',
                                name: 'surat3'
                            }, {
                                fieldLabel: 'Milik',
                                name: 'smilik'
                            }]
                    }]
            };


            return component;
        };

        Form.Component.angkutan = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL ANGKUTAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .35,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Muat',
                                name: 'muat'
                            }, {
                                fieldLabel: 'Bobot',
                                name: 'bobot'
                            }, {
                                fieldLabel: 'Daya',
                                name: 'daya'
                            }]
                    }, {
                        columnWidth: .35,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Mesin Gerak',
                                name: 'msn_gerak'
                            }, {
                                fieldLabel: 'Jumlah Mesin',
                                name: 'jml_msn'
                            }, {
                                fieldLabel: 'Bahan Bakar',
                                name: 'bhn_bakar'
                            }]
                    }, {
                        columnWidth: .3,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'No Polisi',
                                name: 'no_polisi'
                            }, {
                                fieldLabel: 'No BPKB',
                                name: 'no_bpkb'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.tambahanAngkutanDarat = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Darat',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'STNK',
                                name: 'stnk'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'datefield',
                        items: [{
                                fieldLabel: 'STNK Berlaku',
                                name: 'stnk_berlaku',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [{
                                fieldLabel: 'Pajak',
                                name: 'pajak'
                            }]
                    }, {
                        columnWidth: .25,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'datefield',
                        items: [{
                                fieldLabel: 'Pajak Berlaku',
                                name: 'pajak_berlaku',
                                format: 'Y-m-d'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.tambahanAngkutanLaut = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Laut',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'STKK',
                                name: 'stkk'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'STKK Ex',
                                name: 'stkk_berlaku',
                                format: 'Y-m-d'
                            }, {
                                xtype: 'textfield',
                                fieldLabel: 'Sertifikat Radio',
                                name: 'sertifikat_radio'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Sertifikat Radio Ex',
                                name: 'sertifikat_radio_berlaku',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'Surat Ukur',
                                name: 'surat_ukur'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Surat Ukur Ex',
                                name: 'surat_ukur_berlaku',
                                format: 'Y-m-d'
                            }, {
                                xtype: 'textfield',
                                fieldLabel: 'Ijin Berlayar',
                                name: 'ijin_berlayar'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Ijin Berlayar Ex',
                                name: 'ijin_berlayar_berlaku',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'Sertifikat Keselamatan',
                                name: 'sertifikat_keselamatan'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Sertifikat Keselamatan Ex',
                                name: 'sertifikat_keselamatan_berlaku',
                                format: 'Y-m-d'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.tambahanAngkutanUdara = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Udara',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'Sertifikat Pesawat',
                                name: 'sertifikat_pesawat'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Sertifikat Pesawat Ex',
                                name: 'sertifikat_pesawat_berlaku',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'Sertifikat Kelayakan',
                                name: 'sertifikat_kelayakan'
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'Sertifikat Kelayakan Ex',
                                name: 'sertifikat_kelayakan_berlaku',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'textfield',
                                fieldLabel: 'Bukti Pemilik',
                                name: 'bukti_pemilik'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.senjata = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL SENJATA',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .7,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Surat',
                                name: 'surat'
                            }]
                    }, {
                        columnWidth: .3,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'datefield',
                        items: [{
                                fieldLabel: 'Tanggal Surat',
                                name: 'surat',
                                format: 'Y-m-d'
                            }]
                    }]
            };

            return component;
        };

        Form.Component.alatbesar = function() {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL ALATBESAR',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .35,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Sistem Operasi',
                                name: 'sis_opr'
                            }, {
                                fieldLabel: 'Kapasitas',
                                name: 'kapasitas'
                            }]
                    }, {
                        columnWidth: .35,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Sistem Dingin',
                                name: 'sis_dingin'
                            }, {
                                fieldLabel: 'Duk Alat',
                                name: 'duk_alat'
                            }]
                    }, {
                        columnWidth: .3,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Sistem Bakar',
                                name: 'sis_bakar'
                            }, {
                                fieldLabel: 'Power',
                                name: 'pwr_train'
                            }]
                    }]
            };

            return component;
        };
        
        Form.Component.ruang = function(form){
            var Component = {
                xtype:'fieldset',
                anchor: '100%',
                title: 'RUANG SELECTION',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items:[{
                    xtype: 'combo',
                    fieldLabel: 'Ruang *',
                    name: 'kd_ruang',
                    anchor: '100%',
                    allowBlank: false,
                    store: Reference.Data.ruang,
                    valueField: 'kd_ruang',
                    displayField: 'ur_ruang', emptyText: 'Pilih Ruangan',
                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Ruangan',
                    listeners: {
                        'focus': {
                            fn: function(comboField) {
                                var store = comboField.getStore();
                                store.changeParams({params: {kd_lokasi:Utils.getUnkerCombo(form).getValue()}} );
                                comboField.expand();
                            },
                            scope: this
                        },
                        'change': {
                            fn: function(obj, value) {

                            },
                            scope: this
                        }
                    }
                }]
            };
            
            return Component;
        }

        Form.Component.perairan = function() {
        };

        Form.Component.pengadaan = function() {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENGADAAN',
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
                            items: [{
                                    xtype: 'datefield',
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'tahun_angaran',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Sumber',
                                    name: 'perolehan_sumber'
                                }, {
                                    fieldLabel: 'Perolehan BMN',
                                    name: 'perolehan_bmn'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Perolehan Tanggal',
                                    name: 'perolehan_tanggal',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'No Kuitansi',
                                    name: 'kuitansi_no'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Kuintansi',
                                    name: 'kuitansi_tanggal',
                                    format: 'Y-m-d'
                                }, {
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'Bergaransi',
                                    name: 'is_garansi',
                                    boxLabel: 'Yes'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Garansi Berlaku',
                                    name: 'garansi_berlaku',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Garansi Ket.',
                                    name: 'garansi_keterangan'
                                }]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%'
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'No SPPA',
                                    name: 'no_sppa'
                                }, {
                                    fieldLabel: 'Asal Pengadaan',
                                    name: 'asal_pengadaan'
                                }, {
                                    xtype: 'numberfield',
                                    fieldLabel: 'Total Harga',
                                    name: 'harga_total'
                                }, {
                                    fieldLabel: 'No SP2D',
                                    name: 'sp2d_no'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal SP2D',
                                    name: 'sp2d_tanggal',
                                    format: 'Y-m-d'
                                }, {
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'Terpelihara',
                                    name: 'is_terpelihara',
                                    boxLabel: 'Yes'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Pelihara Berlaku',
                                    name: 'pelihara_berlaku',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Garansi Ket.',
                                    name: 'pelihara_keterangan'
                                }, {
                                    fieldLabel: 'Data Kontrak',
                                    name: 'data_kontrak'
                                }]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%'
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Deskirpsi',
                                    name: 'deskripsi'
                                }, {
                                    fieldLabel: 'No Faktur',
                                    name: 'faktur_no'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Faktur',
                                    name: 'faktur_tanggal',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'No Mutasi',
                                    name: 'mutasi_no'
                                }, {
                                    xtype : 'datefield',
                                    fieldLabel: 'Tanggal Mutasi',
                                    name: 'mutasi_tanggal',
                                    format : 'Y-m-d'
                                }, {
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'SPK',
                                    name: 'is_spk',
                                    boxLabel: 'Yes'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'SPK Berlaku',
                                    name: 'spk_berlaku',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Spk Ket.',
                                    name: 'spk_keterangan'
                                }, {
                                    fieldLabel: 'Spk No.',
                                    name: 'spk_no'
                                }, {
                                    fieldLabel: 'Spk Jenis',
                                    name: 'spk_jenis'
                                }]
                        }]
                }]

            return component;
        };
        
        Form.Component.hiddenIdentifier = function() {
            var components = [{ xtype : 'hidden', name: 'kd_lokasi'},        
                                { xtype : 'hidden',name: 'kode_unor'}, 
                                { xtype : 'hidden', name: 'id' },
                                { xtype : 'hidden', name: 'kd_brg'},
                                { xtype : 'hidden', name: 'no_aset'}
                            ];       
            return components;
        };

        Form.Component.pemeliharaanBangunan = function(form) {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMELIHARAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [{
                            columnWidth: .5,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    fieldLabel: 'Jenis',
                                    name: 'jenis',
                                    allowBlank: true,
                                    store: Reference.Data.jenisPemeliharaanBangunan,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Jenis',
                                    value: -1,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',
                                    editable: false,
                                    listeners: {
                                        change: function(obj, value) {
                                            var subjenis = form.findField('subjenis');
                                            subjenis.clearValue();
                                            subjenis.applyEmptyText();
                                            if (value !== -1)
                                            {
                                                if (value === 1)
                                                {
                                                    subjenis.bindStore(Reference.Data.jenisSubPemeliharaanBangunanPemeliharaan);
                                                }
                                                else if (value === 2)
                                                {
                                                    subjenis.bindStore(Reference.Data.jenisSubPemeliharaanBangunanPerawatan);
                                                }
                                                subjenis.enable();
                                            }

                                        }
                                    }

                                }, {
                                    xtype: 'combo',
                                    fieldLabel: 'Sub Jenis',
                                    name: 'subjenis',
                                    allowBlank: true,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'SubJenis',
                                    value: -1,
                                    disabled: true,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'SubJenis',
                                    editable: false
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Start Pelaksanaan',
                                    name: 'pelaksana_startdate',
                                    format: 'Y-m-d'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal End Pelaksanaan',
                                    name: 'pelaksana_endate',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Pelaksana',
                                    name: 'pelaksana_nama'
                                }]
                        }, {
                            columnWidth: .5,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi'
                                }, {
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi'
                                }, {
                                    xtype: 'numberfield',
                                    fieldLabel: 'Biaya',
                                    name: 'biaya'
                                }]
                        }]
                }]

            return component;
        };


        Form.Component.pemeliharaan = function() {
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
                            items: [{
                                    xtype: 'combo',
                                    fieldLabel: 'Jenis',
                                    name: 'jenis',
                                    allowBlank: true,
                                    store: Reference.Data.jenisPemeliharaan,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Jenis',
                                    value: 3,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',
                                    listeners: {
                                        change: function(obj, value) {
                                            var unitWaktu = Ext.getCmp('unit_waktu');
                                            var unitPengunaan = Ext.getCmp('unit_pengunaan');
                                            var freqwaktu = Ext.getCmp('freq_waktu');
                                            var freqpengunaan = Ext.getCmp('freq_pengunaan');
                                            var renwaktu = Ext.getCmp('rencana_waktu');
                                            var renpengunaan = Ext.getCmp('rencana_pengunaan');
                                            var renketerangan = Ext.getCmp('rencana_keterangan');
                                            var alert = Ext.getCmp('alert');
                                            if (value === 1)
                                            {
                                                unitWaktu.enable();
                                                unitPengunaan.enable();
                                                freqwaktu.enable();
                                                freqpengunaan.enable();
                                                renwaktu.enable();
                                                renpengunaan.enable();
                                                renketerangan.enable();
                                                alert.enable();
                                                
                                            }
                                            else if (value === 2)
                                            {
                                                unitWaktu.enable();
                                                unitPengunaan.enable();
                                                freqwaktu.enable();
                                                freqpengunaan.enable();
                                                renwaktu.enable();
                                                renpengunaan.enable();
                                                renketerangan.enable();
                                                alert.enable();
                                            }
                                            else if (value === 3)
                                            {
                                                unitWaktu.disable();
                                                unitPengunaan.disable();
                                                freqwaktu.disable();
                                                freqpengunaan.disable();
                                                renwaktu.disable();
                                                renpengunaan.disable();
                                                renketerangan.disable();
                                                alert.disable();
                                            }
                                            else
                                            {
                                                unitWaktu.disable();
                                                unitPengunaan.disable();
                                                freqwaktu.disable();
                                                freqpengunaan.disable();
                                                renwaktu.disable();
                                                renpengunaan.disable();
                                                renketerangan.disable();
                                                alert.disable();
                                            }
                                        }
                                    }

                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Pelaksana',
                                    name: 'pelaksana_tgl',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Pelaksana',
                                    name: 'pelaksana_nama'
                                }, {
                                    fieldLabel: 'Kode Angaran',
                                    name: 'kode_angaran'
                                }, {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun Angaran',
                                    name: 'tahun_angaran',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: 'Year',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                                }]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi'
                                }, {
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi'
                                }, {
                                    xtype: 'numberfield',
                                    fieldLabel: 'Harga',
                                    name: 'harga'
                                }, {
                                    fieldLabel: 'Status',
                                    name: 'status'
                                }, {
                                    fieldLabel: 'Durasi',
                                    name: 'durasi'
                                }]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Unit Waktu',
                                    name: 'unit_waktu',
                                    id : 'unit_waktu',
                                    allowBlank: true,
                                    store: Reference.Data.unitWaktu,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Unit Waktu',
                                    value: 1,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Waktu'
                                },{
                                    xtype: 'combo',
                                    disabled:true,
                                    fieldLabel: 'Unit Pengunaan',
                                    name: 'unit_pengunaan',
                                    id : 'unit_pengunaan',
                                    allowBlank: true,
                                    store: Reference.Data.unitPengunaan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Unit Pengunaan',
                                    value: 1,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Pengunaan'
                                },{
                                    fieldLabel: 'Frequncy Waktu',
                                    name: 'freq_waktu',
                                    id: 'freq_waktu',
                                    disabled: true
                                },{
                                    fieldLabel: 'Frequncy Pengunaan',
                                    name: 'freq_pengunaan',
                                    id: 'freq_pengunaan',
                                    disabled: true
                                },{
                                    xtype : 'datefield',
                                    fieldLabel: 'Rencana Waktu',
                                    name: 'rencana_waktu',
                                    id: 'rencana_waktu',
                                    format : 'Y-m-d',
                                    disabled: true
                                },{
                                    fieldLabel: 'Rencana Pengunaan',
                                    name: 'rencana_pengunaan',
                                    id: 'rencana_pengunaan',
                                    disabled: true
                                },{
                                    fieldLabel: 'Rencana Ket.',
                                    name: 'rencana_keterangan',
                                    id: 'rencana_keterangan',
                                    disabled: true
                                },{
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'Alert',
                                    name: 'alert',
                                    id: 'alert',
                                    boxLabel: 'Yes',
                                    disabled: true
                                }]
                        }]
                }]

            return component;
        };

        Form.Component.pemeliharaanHidden = function() {
            
        };
        Form.Component.perencanaan = function() {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PERENCANAAN',
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
                            items: [{
                                    xtype: 'datefield',
                                    fieldLabel: 'Tahun Angaran',
                                    name: 'tahun_angaran',
                                    format: 'Y-m-d'
                                }, {
                                    fieldLabel: 'Kebutuhan',
                                    name: 'kebutuhan'
                                }, {
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan'
                                }]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'Satuan',
                                    name: 'satuan'
                                }, {
                                    xtype: 'numberfield',
                                    fieldLabel: 'Quantity',
                                    name: 'quantity'
                                }, ]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'numberfield',
                            items: [{
                                    fieldLabel: 'Harga Satuan',
                                    name: 'harga_satuan'
                                }, {
                                    fieldLabel: 'Harga Total',
                                    name: 'harga_total'
                                }, {
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'Realisasi',
                                    name: 'is_realisasi',
                                    boxLabel: 'Yes'
                                }]
                        }]
                }]

            return component;
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>