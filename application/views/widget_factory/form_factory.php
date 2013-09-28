<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    ///////////

        Ext.namespace('Reference', 'Reference.URL', 'Reference.Data', 'Reference.Properties');
        Ext.namespace('Form', 'Form.Component', 'Modal','Form.SubComponent');
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
            documentBasePath: BASE_URL + '/uploads/documents/',
            warehouse: BASE_URL +'combo_ref/combo_warehouse',
            warehouseRuang: BASE_URL + 'combo_ref/combo_warehouseRuang',
            warehouseRak: BASE_URL + 'combo_ref/combo_warehouseRak',
            partNumber: BASE_URL + 'combo_ref/combo_partNumber',
            klasifikasiAset_lvl1: BASE_URL +'combo_ref/combo_klasifikasiAset_lvl1',
            klasifikasiAset_lvl2: BASE_URL +'combo_ref/combo_klasifikasiAset_lvl2',
            klasifikasiAset_lvl3: BASE_URL +'combo_ref/combo_klasifikasiAset_lvl3',
            pengadaan: BASE_URL + 'combo_ref/combo_pengadaan',
            penerimaan: BASE_URL + 'combo_ref/combo_penerimaan',
            pemeriksaan: BASE_URL + 'combo_ref/combo_pemeriksaan',
            penyimpanan: BASE_URL + 'combo_ref/combo_penyimpanan',
        };
        
        Reference.Data.penyimpanan = new Ext.create('Ext.data.Store', {
            fields: ['id','nomor_berita_acara'], storeId: 'DataPenyimpananCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.penyimpanan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.pengadaan = new Ext.create('Ext.data.Store', {
            fields: ['id','no_sppa'], storeId: 'DataPengadaanCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.pengadaan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.penerimaan = new Ext.create('Ext.data.Store', {
            fields: ['id','nomor_berita_acara'], storeId: 'DataPenerimaanCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.penerimaan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.pemeriksaan = new Ext.create('Ext.data.Store', {
            fields: ['id','nomor_berita_acara'], storeId: 'DataPemeriksaan Combo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.pemeriksaan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.klasifikasiAset_lvl1 = new Ext.create('Ext.data.Store', {
            fields: ['kd_lvl1', 'nama'], storeId: 'DataKlasifikasiAset_lvl1 ',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.klasifikasiAset_lvl1, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
           Reference.Data.klasifikasiAset_lvl2 = new Ext.create('Ext.data.Store', {
            fields: ['kd_lvl2', 'nama'], storeId: 'DataKlasifikasiAset_lvl2',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.klasifikasiAset_lvl2, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_lvl1:0}
            }),
            autoLoad: true
        });
        
        Reference.Data.klasifikasiAset_lvl3 = new Ext.create('Ext.data.Store', {
            fields: ['kd_lvl3', 'nama'], storeId: 'DataKlasifikasiAset_lvl3',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.klasifikasiAset_lvl3, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, kd_lvl1:0, kd_lvl2:0}
            }),
            autoLoad: true
        });
        
     
        
        Reference.Data.warehouse = new Ext.create('Ext.data.Store', {
            fields: ['id', 'nama'], storeId: 'DataWarehouse',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.warehouse, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.warehouseRuang = new Ext.create('Ext.data.Store', {
            fields: ['id', 'nama'], storeId: 'DataWarehouseRuang',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.warehouseRuang, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, warehouse_id:0}
            }),
            autoLoad: true
        });
        
        Reference.Data.warehouseRak = new Ext.create('Ext.data.Store', {
            fields: ['id', 'nama'], storeId: 'DataWarehouseRak',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.warehouseRak, actionMethods: {read: 'POST'}, extraParams: {id_open: 1, warehouseruang_id:0}
            }),
            autoLoad: true
        });

        
        Reference.Data.partNumber = new Ext.create('Ext.data.Store', {
            fields: ['part_number', 'nama','kd_brg'], storeId: 'DataPartNumber',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.partNumber, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });

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
        
        Reference.Data.kategoriAset = new Ext.create('Ext.data.Store', {
            fields: ['kategori', 'value'],
            data: [{kategori: 'Alat Besar', value: 1}, {kategori: 'Angkutan', value: 2},
                    {kategori: 'Bangunan', value: 3}, {kategori: 'Perairan', value: 4},
                    {kategori: 'Senjata', value: 5}, {kategori: 'Tanah', value: 6}]
        });
        
        Reference.Data.pemeliharaanUnitWaktuOrUnitPenggunaan = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Waktu', value: 1}, {text: 'Penggunaan', value: 2}]
        });
        
        Reference.Data.jenisPerlengkapanAngkutanDarat = new Ext.create('Ext.data.Store', {
            fields: ['value'],
            data: [{value:'Alat Navigasi/Komunikasi'}, {value:'Alat Penolong/Rescue'},
                    {value:'Alat Pemadam Kebakaran'},{value:'Alat Lainnya'}]
        });
        
        Reference.Data.jenisPerlengkapanAngkutanLaut = new Ext.create('Ext.data.Store', {
            fields: ['value'],
            data: [{value:'Alat Navigasi/Komunikasi'}, {value:'Alat Penolong/Rescue'},
                    {value:'Alat Labuh Jangkar'}, {value:'Alat Pemadam Kebakaran'},
                    {value:'Alat Lainnya'}]
        });
        
        Reference.Data.jenisPerlengkapanAngkutanUdara = new Ext.create('Ext.data.Store', {
            fields: ['value'],
            data: [{value:'Alat Navigasi/Komunikasi'}, {value:'Alat Penolong/Rescue'},
                    {value:'Part Pesawat'}, {value:'Alat Pemadam Kebakaran'},
                    {value:'Alat Lainnya'}]
        });
        
        Reference.Data.kondisiPerlengkapan = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Baik', value: 'Baik'}, {text: 'Rusak Ringan', value: 'Rusak Ringan'}, {text: 'Rusak Berat', value: 'Rusak Berat'}]
        });
        
        Reference.Data.unitWaktu = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Day', value: 1}, {text: 'Month', value: 2}, {text: 'Year', value: 3}]
        });
        
        Reference.Data.unitPengunaan = new Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [{text: 'Meter', value: 1}, {text: 'Kilometer', value: 2}, {text: 'Mil', value: 3},
                    {text:'Jam Layar', value: 4}, {text:'Jam Terbang', value: 5}]
        });
        
        Reference.Data.unitPengunaanAngkutanDarat = new Ext.create('Ext.data.Store', {
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

        
        Form.inventorypenerimaan = function(setting, setting_grid_perlengkapan)
        {
            var pilihPengadaan = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENGADAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Pengadaan',
                                    name: 'id_pengadaan',
                                    allowBlank: true,
                                    store: Reference.Data.pengadaan,
                                    valueField: 'id',
                                    displayField: 'no_sppa', emptyText: 'Pilih Pengadaan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                },
                                
                            ]
                        }]
                }];
            var form = Form.inventory(setting.url, setting.data, setting.isEditing, setting.dataStoreInventoryPerlengkapan);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPengadaan);
            form.insert(2, Form.Component.inventorypenerimaan());
            form.insert(3, Form.Component.gridInventoryPerlengkapan(setting_grid_perlengkapan))
//            form.insert(3, Form.Component.dataInventoryPerlengkapan());

            return form;
        }
        
        Form.inventorypemeriksaan = function(setting,id_penerimaan)
        {
//            debugger;
            var pilihPenerimaan = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENERIMAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Penerimaan *',
                                    name: 'id_penerimaan',
                                    allowBlank: false,
                                    store: Reference.Data.penerimaan,
                                    valueField: 'id',
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penerimaan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'focus': {
                                            fn: function(comboField) {
                                                comboField.expand();
                                            },
                                            scope: this
                                        },
                                        'beforeRender': {
                                            fn: function() {
                                                if(setting.isEditing == true)
                                                {
                                                    Reference.Data.penerimaan.changeParams({params: {id_open: 1, excludedValue: id_penerimaan}});
                                                }
                                                else
                                                {
                                                    Reference.Data.penerimaan.changeParams({params: {id_open: 1}});
                                                }
                                            },
                                            scope: this
                                        },
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                    /*
                                                     * If is edit, the combo box will present all id_penerimaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_penerimaan that isn't used yet
                                                     */
                                                    
                                                    Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_penerimaan/getSpecificInventoryPenerimaan',
                                                        params: {
                                                            id: value
                                                        },
                                                        success: function(response){
                                                            var data = eval ("(" + response.responseText + ")");
                                                            Ext.getCmp('inventory_data_perlengkapan_part_number').setValue(data.part_number);
                                                            Ext.getCmp('inventory_data_perlengkapan_serial_number').setValue(data.serial_number);
                                                            Ext.getCmp('inventory_data_perlengkapan_qty').setValue(data.qty);
                                                            Ext.getCmp('inventory_data_perlengkapan_status_barang').setValue(data.status_barang);
                                                            Ext.getCmp('inventory_data_perlengkapan_asal_barang').setValue(data.asal_barang);
                                                            Ext.getCmp('kd_lokasi').setValue(data.kd_lokasi);
                                                            Ext.getCmp('kode_unor').setValue(data.kode_unor);
                                                            // process server response here
                                                        }
                                                        });
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPenerimaan);
            form.insert(2, Form.Component.inventorypemeriksaan());
            form.insert(3, Form.Component.dataInventoryPerlengkapan());

            return form;
        }
        
        Form.inventorypenyimpanan = function(setting,id_pemeriksaan)
        {

            var pilihPemeriksaan = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMERIKSAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Pemeriksaan *',
                                    name: 'id_pemeriksaan',
                                    allowBlank: false,
                                    store: Reference.Data.pemeriksaan,
                                    valueField: 'id',
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Pemeriksaan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'focus': {
                                            fn: function(comboField) {
                                                comboField.expand();
                                            },
                                            scope: this
                                        },
                                        'beforeRender': {
                                            fn: function() {
                                                if(setting.isEditing == true)
                                                {
                                                    Reference.Data.pemeriksaan.changeParams({params: {id_open: 1, excludedValue: id_pemeriksaan}});
                                                }
                                                else
                                                {
                                                    Reference.Data.pemeriksaan.changeParams({params: {id_open: 1}});
                                                }
                                            },
                                            scope: this
                                        },
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                    /*
                                                     * If is edit, the combo box will present all id_penerimaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_penerimaan that isn't used yet
                                                     */
                                                    
                                                    Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_pemeriksaan/getSpecificInventoryPemeriksaan',
                                                        params: {
                                                            id: value
                                                        },
                                                        success: function(response){
                                                            var data = eval ("(" + response.responseText + ")");
                                                                Ext.getCmp('inventory_data_perlengkapan_part_number').setValue(data.part_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_serial_number').setValue(data.serial_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_qty').setValue(data.qty);
                                                                Ext.getCmp('inventory_data_perlengkapan_status_barang').setValue(data.status_barang);
                                                                Ext.getCmp('inventory_data_perlengkapan_asal_barang').setValue(data.asal_barang);
                                                                Ext.getCmp('kd_lokasi').setValue(data.kd_lokasi);
                                                                Ext.getCmp('kode_unor').setValue(data.kode_unor);
                                                            
                                                           
                                                            // process server response here
                                                        }
                                                        });
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPemeriksaan);
            form.insert(2, Form.Component.inventorypenyimpanan(setting.isEditing));
            form.insert(3, Form.Component.dataInventoryPerlengkapan());

            return form;
        }
        
        Form.inventorypengeluaran = function(setting,id_perlengkapan)
        {

            var pilihPerlengkapan = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENGELUARAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    readOnly:setting.isEditing,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Penyimpanan *',
                                    name: 'id_penyimpanan',
                                    allowBlank: false,
                                    store: Reference.Data.penyimpanan,
                                    valueField: 'id',
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penyimpanan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'beforeRender': {
                                            fn: function() {
                                                if(setting.isEditing == true)
                                                {
                                                    Reference.Data.penyimpanan.changeParams({params: {id_open: 1, excludedValue: id_perlengkapan}});
                                                }
                                                else
                                                {
                                                    Reference.Data.penyimpanan.changeParams({params: {id_open: 1}});
                                                }
                                            },
                                            scope: this
                                        },
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                    /*
                                                     * If is edit, the combo box will present all id_penerimaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_penerimaan that isn't used yet
                                                     */
                                                    
                                                    Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_penyimpanan/getSpecificInventoryPenyimpanan',
                                                        params: {
                                                            id: value
                                                        },
                                                        success: function(response){
                                                            var data = eval ("(" + response.responseText + ")");
                                                                Ext.getCmp('inventory_data_perlengkapan_part_number').setValue(data.part_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_serial_number').setValue(data.serial_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_qty').setValue(data.qty);
                                                                Ext.getCmp('inventory_data_perlengkapan_status_barang').setValue(data.status_barang);
                                                                Ext.getCmp('inventory_data_perlengkapan_asal_barang').setValue(data.asal_barang);
                                                                Ext.getCmp('kd_lokasi').setValue(data.kd_lokasi);
                                                                Ext.getCmp('kode_unor').setValue(data.kode_unor);
                                                                Ext.getCmp('inventory_data_pengeluaran_qty_barang_keluar').setDisabled(false);
                                                                Ext.getCmp('inventory_data_pengeluaran_qty_barang_keluar').setMaxValue(data.qty);
//                                                                Ext.getCmp('inventory_data_pengeluaran_qty_barang_keluar').validate();
                                                                if(setting.isEditing == true)
                                                                {
                                                                    Ext.getCmp('inventory_data_perlengkapan_qty').setValue(parseInt(data.qty) + parseInt(Ext.getCmp('inventory_data_pengeluaran_qty_barang_keluar').value));
                                                                    Ext.getCmp('inventory_data_pengeluaran_qty_barang_keluar').setMaxValue(Ext.getCmp('inventory_data_perlengkapan_qty').value);
                                                                }
                                                           
                                                            // process server response here
                                                        }
                                                        });
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPerlengkapan);
            form.insert(2, Form.Component.inventorypengeluaran(setting.isEditing));
            form.insert(3, Form.Component.dataInventoryPerlengkapan(true));

            return form;
        }
        
        Form.pengadaan = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Reference',
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
                            items : [{
                                    fieldLabel : "Kode Barang",
                                    name : "kd_brg"
                            }]
                        },{
                            columnWidth: .5,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items : [{
                                    fieldLabel : "Nama",
                                    name : "nama"
                            }]
                        }]
            });
            form.insert(2, Form.Component.pengadaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        };
        
        Form.penghapusanDanMutasiInAsset = function(setting)
        {
//            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
//            form.insert(1, Form.Component.hiddenIdentifier());
//            form.insert(2, Form.Component.pengadaan());
//            form.insert(3, Form.Component.fileUpload());
              
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.penghapusanDanMutasi());
            return form;
        }
        
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
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(2, Form.Component.perencanaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        };
        
        //start form pendayagunaan
        Form.pendayagunaan = function(setting,dataid)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,true));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing))
            form.insert(3, Form.Component.pendayagunaan(dataid));
            form.insert(4, Form.Component.fileUpload());

            return form;
        };
        
        Form.pendayagunaanInAsset = function(setting,dataid)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing));
            form.insert(3, Form.Component.pendayagunaan());
            form.insert(4, Form.Component.fileUpload());

            return form;
        };
        
        Form.Component.pendayagunaan = function() {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENDAYAGUNAAN',
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
                                    xtype:'numberfield',
                                    fieldLabel: 'Part Number',
                                    name: 'part_number',
                                }, {
                                    xtype:'numberfield',
                                    fieldLabel: 'Serial Number',
                                    name: 'serial_number'
                                }, {
                                    xtype:'combobox',
                                    fieldLabel: 'Mode Pendayagunaan',
                                    name: 'mode_pendayagunaan',
                                    store: Ext.create('Ext.data.Store', {
                                        fields: ['name', 'value'],
                                        data : [
                                            {"name":"Penyewaan", "value":"Penyewaan"},
                                            {"name":"Sewa Guna", "value":"Sewa Guna"},
                                            {"name":"KSO", "value":"KSO"},
                                            {"name":"Lainnya", "value":"Lainnya"},
                                        ]
                                    }),
                                    queryMode: 'local',
                                    displayField: 'name',
                                    valueField: 'value',
                                    emptyText: 'Pendayagunaan'
                                }
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
                                    fieldLabel: 'Pihak Ke-Tiga',
                                    name: 'pihak_ketiga'
                                }, {
                                    xtype:'datefield',
                                    fieldLabel: 'Tanggal Mulai',
                                    name: 'tanggal_start',
                                    format: 'Y-m-d'
                                }, {
                                    xtype:'datefield',
                                    fieldLabel: 'Tanggal Selesai',
                                    name: 'tanggal_end',
                                    format: 'Y-m-d'
                                }
                            ]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 80,
                                labelAlign:'bottom',
                            },
                            items: [
                                {
                                    fieldLabel: 'Deskripsi',
                                    name: 'description',
                                    xtype:'textarea',
                                    anchor:'100%',
                                }
                            ]
                        }]
                }]

            return component;
        };
        //end form pendayagunaan


        Form.pemeliharaan = function(setting,setting_grid_pemeliharaan_part)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,true));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(4, Form.Component.fileUpload());
            
//            Ext.getCmp('nama_unker').setDisabled(true);
//            Ext.getCmp('nama_unor').setDisabled(true);
            if (setting.isBangunan) //isBangunan and Tanah
            {
                form.insert(2, Form.Component.pemeliharaanBangunan());
            }
            else
            {
                var tipe_angkutan = null;
                if(setting.tipe_angkutan != undefined && setting.tipe_angkutan != null)
                {
                    tipe_angkutan = setting.tipe_angkutan;
                }
                
                form.insert(2, Form.Component.pemeliharaan(tipe_angkutan));
                if(setting_grid_pemeliharaan_part != null || setting_grid_pemeliharaan_part != undefined)
                {
                    form.insert(3, Form.Component.gridPemeliharaanPart(setting_grid_pemeliharaan_part,setting.isEditing));
                }
                
            }

            return form;
        };
        
        Form.pemeliharaanInAsset = function(setting,setting_grid_pemeliharaan_part){
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
            form.insert(4, Form.Component.fileUpload());
            
            if (setting.isBangunan)
            {
                form.insert(2, Form.Component.pemeliharaanBangunan(form.getForm()));
            }
            else
            {
                form.insert(2, Form.Component.pemeliharaan(form.getForm()));
                form.insert(3, Form.Component.gridPemeliharaanPart(setting_grid_pemeliharaan_part,setting.isEditing));
            }
            
            return form;
        }
        
        Form.peraturan = function(setting)
        {
            var form = Form.process(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, Form.Component.peraturan());
            form.insert(1, Form.Component.fileUploadDocumentOnly('document','fileupload_peraturan'));
            
            return form;
        }

        
        Form.pengelolaan = function(setting)
        {
            var form = Form.process(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset,false));
            form.insert(2, Form.Component.pengelolaan(setting.isEditing));
            form.insert(3, Form.Component.fileUpload(setting.isEditing));
            
            return form;
        }
        
        Form.assetRuang = function(setting)
        {
            var form = Form.asset(setting.url, setting.data, setting.isEditing);
            
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.kode(setting.isEditing));
            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing))
            form.insert(3, Form.Component.ruang(form));
            form.insert(4, Form.Component.fileUpload(setting.isEditing));
            
            return form;
        }
        
        Form.secondaryWindowAsset= function(data,operationType,storeIndex) {
            var _form = Ext.create('Ext.form.Panel', {
                frame: true,
                url: '',
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', id: 'save_perlengkapan', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var formValues = form.getValues();
                            if (form.isValid())
                            {
                                if(operationType == 'add')
                                {
                                    data.add(formValues);
                                }
                                if(operationType == 'edit')
                                {
                                    var record = data.getAt(storeIndex);
                                    record.set(formValues);
                                }
                                if(operationType == 'remove')
                                {
//                                    data.removeAt(storeIndex);
//                                    data.commitChanges();
                                }
                                
                                
                                Modal.assetSecondaryWindow.close();
                            }
                        }
                    }]// BUTTONS END

            });

            return _form;
        };
        
        Form.inventory = function(url, data, edit, dataStoreInventoryPerlengkapan) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-process',
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
                        text: 'Simpan', id: 'save_inventory', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function(form,action) {
                                        var id = action.result.id;
                                        var grid = Ext.getCmp('grid_inventory_penerimaan_perlengkapan').getStore();
                                        var new_records = grid.getNewRecords();
//                                        var updated_records = grid.getUpdatedRecords();
//                                        var removed_records = grid.getRemovedRecords();
                                        Ext.each(new_records, function(obj){
                                            var index = grid.indexOf(obj);
                                            var record = grid.getAt(index);
                                            record.set('id_inventory',id);
                                        });
                                            grid.sync();
                     
                                        
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        if (data !== null)
                                        {
                                            data.load();
                                        }
                                        Modal.closeProcessWindow();
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
                    },]
            });


            return _form;
        };

        Form.process = function(url, data, edit, addBtn) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-process',
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
                            
//                            console.log(form.getValues());
                            
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
                                        Modal.closeProcessWindow();
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
        
        Form.assetAngkutanLaut = function(url, data, edit, hasTabs) {
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
                            if(hasTabs == true)
                            {
                                var uploadComponent = Ext.getCmp('form_tabs').items.items[0];
                            }
                            
                             if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = null;
                                if(hasTabs == true)
                                {
                                    photoStore = Utils.getPhotoStore(uploadComponent);
                                }
                                else
                                {
                                    photoStore = Utils.getPhotoStore(_form);
                                }
                                
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                if(hasTabs == true)
                                {
                                    documentStore = Utils.getDocumentStore(uploadComponent);
                                }
                                else
                                {
                                    documentStore = Utils.getDocumentStore(_form);
                                }
                                
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            
                            var laut_stkk_file = form.findField('laut_stkk_file');
                            var laut_sertifikasi_keselamatan_file = form.findField('laut_sertifikasi_keselamatan_file');
                            var laut_sertifikasi_radio_file = form.findField('laut_sertifikasi_radio_file');
                            var laut_surat_ijin_berlayar_file = form.findField('laut_surat_ijin_berlayar_file');
  
                            if (laut_stkk_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanLautTambahanSTKKFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                laut_stkk_file.setRawValue(arrayDoc.join());
                            }
                            
                            if (laut_sertifikasi_keselamatan_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanLautTambahanSertifikasiKeselamatanFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                laut_sertifikasi_keselamatan_file.setRawValue(arrayDoc.join());
                            }
                            
                            if (laut_sertifikasi_radio_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanLautTambahanSertifikasiRadioFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                laut_sertifikasi_radio_file.setRawValue(arrayDoc.join());
                            }
                            
                            if (laut_surat_ijin_berlayar_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanLautTambahanSuratIjinBerlayarFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                laut_surat_ijin_berlayar_file.setRawValue(arrayDoc.join());
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
        
        Form.assetAngkutanUdara = function(url, data, edit, hasTabs) {
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
                            if(hasTabs == true)
                            {
                                var uploadComponent = Ext.getCmp('form_tabs').items.items[0];
                            }
                            
                             if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = null;
                                if(hasTabs == true)
                                {
                                    photoStore = Utils.getPhotoStore(uploadComponent);
                                }
                                else
                                {
                                    photoStore = Utils.getPhotoStore(_form);
                                }
                                
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                if(hasTabs == true)
                                {
                                    documentStore = Utils.getDocumentStore(uploadComponent);
                                }
                                else
                                {
                                    documentStore = Utils.getDocumentStore(_form);
                                }
                                
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            var udara_sertifikat_kelaikan_udara_file = form.findField('udara_sertifikat_kelaikan_udara_file');
                            var udara_sertifikat_pendaftaran_pesawat_udara_file = form.findField('udara_sertifikat_pendaftaran_pesawat_udara_file');
                            var udara_surat_bukti_kepemilikan_file = form.findField('udara_surat_bukti_kepemilikan_file');
                           
  
                            if (udara_sertifikat_kelaikan_udara_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanUdaraTambahanSertifikatKelaikanUdaraFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                udara_sertifikat_kelaikan_udara_file.setRawValue(arrayDoc.join());
                            }
                            
                            if (udara_sertifikat_pendaftaran_pesawat_udara_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanUdaraTambahanSertifikatPendaftaranPesawatUdaraFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                udara_sertifikat_pendaftaran_pesawat_udara_file.setRawValue(arrayDoc.join());
                            }
                            
                            if (udara_surat_bukti_kepemilikan_file !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                     documentStore = Ext.getCmp('AngkutanUdaraTambahanSuratBuktiKepemilikanFile').getStore(); 
                                }
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                udara_surat_bukti_kepemilikan_file.setRawValue(arrayDoc.join());
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
        
        
        Form.assetBangunanDanTanah = function(url, data, edit, hasTabs, storeRiwayatPajak) {
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
                            if(hasTabs == true)
                            {
                                var uploadComponent = Ext.getCmp('form_tabs').items.items[0];
                            }
                            
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = null;
                                if(hasTabs == true)
                                {
                                    photoStore = Utils.getPhotoStore(uploadComponent);
                                }
                                else
                                {
                                    photoStore = Utils.getPhotoStore(_form);
                                }
                                
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                if(hasTabs == true)
                                {
                                    documentStore = Utils.getDocumentStore(uploadComponent);
                                }
                                else
                                {
                                    documentStore = Utils.getDocumentStore(_form);
                                }
                                
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            if (form.isValid())
                            {
                                
                                form.submit({
                                    success: function(response) {
                                        debugger;
                                        storeRiwayatPajak.sync();
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
        
        Form.asset = function(url, data, edit, hasTabs) {
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
                            if(hasTabs == true)
                            {
                                var uploadComponent = Ext.getCmp('form_tabs').items.items[0];
                            }
                            
                            if (imageField !== null)
                            {
                                var arrayPhoto = [];
                                var photoStore = null;
                                if(hasTabs == true)
                                {
                                    photoStore = Utils.getPhotoStore(uploadComponent);
                                }
                                else
                                {
                                    photoStore = Utils.getPhotoStore(_form);
                                }
                                
                                
                                _.each(photoStore.data.items, function(obj) {
                                    arrayPhoto.push(obj.data.name);
                                });
                                
                                imageField.setRawValue(arrayPhoto.join());
                            }
                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                if(hasTabs == true)
                                {
                                    documentStore = Utils.getDocumentStore(uploadComponent);
                                }
                                else
                                {
                                    documentStore = Utils.getDocumentStore(_form);
                                }
                                
                                
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
        
        Form.detailPenggunaanAngkutan = function(url, data, edit,tipe_angkutan) {
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
                        text: 'Simpan', id: 'save_penggunaan', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function() {
                                        data.load();
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        
                                        if (Modal.assetSecondaryWindow.isVisible(true))
                                        {
                                            var id_ext_asset = Ext.getCmp('id_ext_asset_detail_penggunaan_angkutan').value;
                                            $.ajax({
                                                url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                                                type: "POST",
                                                dataType:'json',
                                                async:false,
                                                data:{tipe_angkutan:tipe_angkutan,id_ext_asset:id_ext_asset},
                                                success:function(response, status){
                                                 if(response.status == 'success')
                                                 {
                                                     if(tipe_angkutan == "darat")
                                                    {
                                                        var updateTotalPenggunaan = response.total + ' Km';
                                                        Ext.getCmp('total_detail_penggunaan_angkutan').setValue(updateTotalPenggunaan);
                                                    }
                                                    else if(tipe_angkutan == "laut" || tipe_angkutan == "udara")
                                                    {
                                                        var updateTotalPenggunaan = response.total + ' Jam';
                                                        Ext.getCmp('total_detail_penggunaan_angkutan').setValue(updateTotalPenggunaan);
                                                    }

                                                 }

                                                }
                                             });

                                            Modal.assetSecondaryWindow.close();
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
        
        Form.perlengkapanAngkutan = function(url, data, edit) {
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
                        text: 'Simpan', id: 'save_perlengkapan', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function() {
                                        data.load();
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        if (!edit)
                                        {
                                            if (Modal.assetSecondaryWindow.isVisible(true))
                                            {
                                                Modal.assetSecondaryWindow.close();
                                            }
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
        
        Form.riwayatPajak = function(url, data, edit, jenis) {
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
                        text: 'Simpan', id: 'save_riwayat_pajak', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            var documentField = form.findField('file_setoran');
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                var documentStore = null;
                                
                                if(form !=null)
                                {
                                    if(jenis == 'tanah')
                                    {
                                        documentStore = Ext.getCmp('TanahRiwayatPajakFile').getStore(); 
                                    }
                                    else if(jenis == 'bangunan')
                                    {
                                        documentStore = Ext.getCmp('BangunanRiwayatPajakFile').getStore(); 
                                    }
                                }
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
                            if (form.isValid())
                            {
                                var form_values = form.getValues();
                                data.add(form_values);
                                Modal.assetSecondaryWindow.close();
                                

                            }
                        }
                    }]// BUTTONS END

            });


            return _form;
        };
        
        Form.pemeliharaanPart = function(url, data, edit) {
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
                        text: 'Simpan', id: 'save_pemeliharaan_part', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function() {
                                        
                                        data.load();
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        if (!edit)
                                        {
                                            if (Modal.assetSecondaryWindow.isVisible(true))
                                            {
                                                Modal.assetSecondaryWindow.close();
                                            }
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

        Form.Component.unit = function(edit,form,isReadOnly) {
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
//                                        if (edit)
//                                        {
                                            var comboUnker = Ext.getCmp('nama_unker');
                                            var unorField = Ext.getCmp('nama_unor');
                                                unorField.setValue('');
                                            if (comboUnker !== null)
                                            {
                                                comboUnker.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kode_unor',
                                id: 'kode_unor',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboUnor = Ext.getCmp('nama_unor');
                                            if (comboUnor !== null)
                                            {
                                                comboUnor.setValue(value);
                                            }
//                                        }
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
                                allowBlank: true,
                                readOnly:(isReadOnly == true)?true:false,
                                store: Reference.Data.unker,
                                valueField: 'kdlok',
                                displayField: 'ur_upb', emptyText: 'Pilih Unit Kerja',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            if(isReadOnly != true)
                                            {
                                                comboField.expand();
                                            }
                                            
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {

                                            if (value !== null)
                                            {
                                                var unorField = Ext.getCmp('nama_unor');
                                                var kodeUnkerField = Ext.getCmp('kd_lokasi');
                                                if (unorField !== null && kodeUnkerField !== null) {
                                                    if (value.length > 0) {
                                                        unorField.enable();
                                                        kodeUnkerField.setValue(value);
                                                        Reference.Data.unor.changeParams({params: {id_open: 1, kode_unker: value}});
                                                    }
                                                    else {
                                                        unorField.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('unit organisasi could not be found');
                                                }
                                            }

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
                                readOnly:(isReadOnly == true)?true:false,
                                store: Reference.Data.unor,
                                valueField: 'kode_unor',
                                displayField: 'nama_unor', emptyText: 'Pilih Unit Organisasi',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            if(isReadOnly != true)
                                            {
                                                var dataStore = comboField.getStore();
                                            var kd_lokasi = Utils.getUnkerCombo(form).getValue();
                                            if (kd_lokasi !== null)
                                            {
                                                console.log(Utils.getUnkerCombo(form).getValue());
                                                dataStore.clearFilter();
                                                dataStore.filter({property:"kd_lokasi", value:kd_lokasi});
                                            }
                                            comboField.expand();
                                            }
                                            
                                            
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
        
        /*
         * @param {string} database_field = the field fileupload field name in database
         * @param {string} id_fileupload = unique id for fileupload grid     
         */
        Form.Component.fileUploadDocumentOnly= function(database_field,id_fileupload)
        {
          
            var documentStore = new Ext.create('Ext.data.Store', {
                                        fields: ['url', 'name']
                                    })
            
            var component = {
                xtype: 'container',
                itemId: 'fileUpload',
                layout: 'column',
                border: false,
//                title: 'FILE',
                defaultType: 'container',
                style: {
                    marginTop: '10px'
                },
                items: [{
                                xtype: 'hidden',
                                name: database_field,
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
                            }, {// DOCUMENT START
                        columnWidth: .99,
                        layout: 'anchor',
                        itemId: 'documentColumn',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [{
                                xtype: 'gridpanel',
                                id : id_fileupload,
                                store: documentStore,
                                columnWidth: .5,
                                width: '100%',
                                height: 110,
                                style: {
                                    marginBottom: '10px'
                                },
                                columns: [{
                                        text: 'Document Name',
                                        dataIndex: 'name',
                                        width: 230
                                    }, {
                                        xtype: 'actioncolumn',
                                        width: 30,
                                        items: [{
                                                icon: '../basarnas/assets/images/icons/disk.png',
                                                tooltipe: 'View Document',
                                                handler: function(grid, rowIndex, colIndex, obj) {
                                                    var record = documentStore.getAt(rowIndex);

                                                    
                                                    
                                                    window.open(record.data.url,'_blank');
                                                }
                                            }]
                                    },{
                                        xtype: 'actioncolumn',
                                        width: 30,
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
                                height : 110,
                                style : {
                                    marginBottom: '10px'
                                },
                                items: Ext.create('Ext.view.View', {
                                    store: photoStore,
                                    itemId: 'photoView',
                                    tpl: [
                                        '<tpl for=".">',
                                        '<div class="thumb-wrap" id="{name}" style="float:left; padding:5px">',
                                        '<div class="thumb"><img src="{url}" height="70" width="70"><br/><input type="button" value="Tindakan" id="{name}" class="action_btn" /></div>',
                                        '</div>',
                                        '</tpl>',
                                        '<div class="x-clear"></div>'
                                    ],
                                    height: 80,
                                    emptyText: 'No image',
//                                    itemSelector: 'div.thumb-wrap',
                                    itemSelector: 'input.action_btn',
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
                                            
                                            var messageBox = Ext.create('Ext.window.MessageBox', {
                                                width:300,
                                                height: 100,
                                                buttonText: {yes: "Lihat",no: "Hapus",cancel: "Batal"},

                                           });
                                           

                                            messageBox.show({
                                                title:'Tindakan',
                                                msg: 'Pilih Tindakan',
                                                buttons: Ext.Msg.YESNOCANCEL,
                                                fn: function(btn){
                                                    if (btn === 'yes')
                                                    {
                                                        window.open(data.url,'_blank');
                                                    }
                                                    else if(btn === 'no')
                                                    {
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
                                height: 110,
                                style: {
                                    marginBottom: '10px'
                                },
                                columns: [{
                                        text: 'Document Name',
                                        dataIndex: 'name',
                                        width: 270
                                    }, {
                                        xtype: 'actioncolumn',
                                        width: 30,
                                        items: [{
                                                icon: '../basarnas/assets/images/icons/disk.png',
                                                tooltipe: 'View Document',
                                                handler: function(grid, rowIndex, colIndex, obj) {
                                                    var record = documentStore.getAt(rowIndex);

                                                    
                                                    
                                                    window.open(record.data.url,'_blank');
                                                }
                                            }]
                                    },{
                                        xtype: 'actioncolumn',
                                        width: 30,
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
                                    },
                                    ]
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
                        columnWidth: .33,
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
                            },{
                                fieldLabel: 'Unit Kerja',
                                name: 'unit_pmk'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [ {
                                fieldLabel: 'Catatan',
                                name: 'catatan'
                            },{
                                fieldLabel: 'Alamat Unit',
                                name: 'alm_pmk'
                            }, {
                                fieldLabel: 'Status',
                                name: 'status'
                            }]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kuantitas',
                                name: 'kuantitas'
                            }, {
                                xtype: 'numberfield',
                                fieldLabel: 'Harga Aset',
                                name: 'rph_aset'
                            },{
                                xtype: 'numberfield',
                                fieldLabel: 'Harga Wajar',
                                name: 'rphwajar'
                            }]
                    }, ]
            };


            return component;
        };

        Form.Component.selectionAsset = function(cmpSetting,isReadOnly) {

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
                                name: 'kd_brg',
                                readOnly:(isReadOnly == false)?false:true,
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
                                editable: false,
                                readOnly:(isReadOnly == false)?false:true,
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
                                editable: false,
                                readOnly:true,
                            }]
                    }]
            };


            return component;
        };
        
        Form.Component.klasifikasiAset = function(edit) {

            var component = {
                xtype: 'fieldset',
                title: 'KLASIFIKASI ASET',
                layout: 'column',
                border: false,
                defaultType: 'container',
                margin: 0,
                items: [{
                        defaultType: 'hidden',
                        items: [{
                                name: 'kd_lvl1',
                                id: 'kd_lvl1',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboLvl1 = Ext.getCmp('combo_kd_lvl1');
                                            if (comboLvl1 !== null)
                                            {
                                                comboLvl1.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_lvl2',
                                id: 'kd_lvl2',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboLvl2 = Ext.getCmp('combo_kd_lvl2');
                                            if (comboLvl2 !== null)
                                            {
                                                comboLvl2.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'kd_lvl3',
                                id: 'kd_lvl3',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboLvl3 = Ext.getCmp('combo_kd_lvl3');
                                            if (comboLvl3 !== null)
                                            {
                                                comboLvl3.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .50,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Level 1 *',
                                name: 'combo_kd_lvl1',
                                id: 'combo_kd_lvl1',
                                hideLabel: false,
                                allowBlank: true,
                                store: Reference.Data.klasifikasiAset_lvl1,
                                valueField: 'kd_lvl1',
                                displayField: 'nama', emptyText: 'Klasifikasi Aset',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
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
                                                var Lvl3Field = Ext.getCmp('combo_kd_lvl3'); 
                                                var Lvl2Field = Ext.getCmp('combo_kd_lvl2');
                                                Lvl2Field.disable();
                                                Lvl3Field.disable();
                                                var Lvl1Field = Ext.getCmp('kd_lvl1');
                                                if (Lvl1Field !== null && Lvl2Field !== null) {
                                                    if (!isNaN(value) && value.length > 0 || edit === true) {
                                                        Lvl2Field.enable();
                                                        Lvl1Field.setValue(value);
                                                        Reference.Data.klasifikasiAset_lvl2.changeParams({params: {id_open: 1, kd_lvl1: value}});
                                                    }
                                                    else {
                                                        Lvl2Field.disable();
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
                            },
                            {
                                fieldLabel: 'Level 2 *',
                                name: 'combo_kd_lvl2',
                                id: 'combo_kd_lvl2',
                                disabled: true,
                                allowBlank: false,
                                store: Reference.Data.klasifikasiAset_lvl2,
                                valueField: 'kd_lvl2',
                                displayField: 'nama', emptyText: 'Klasifikasi Aset',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var Lvl3Field = Ext.getCmp('combo_kd_lvl3');
                                            var Lvl2Field = Ext.getCmp('kd_lvl2');
                                            var Lvl1Field = Ext.getCmp('kd_lvl1').getValue();
                                            if (Lvl3Field !== null && Lvl2Field !== null) {
                                                if (!isNaN(value) && value.length > 0 || edit === true) {
                                                    Lvl3Field.enable();
                                                    Lvl2Field.setValue(value);
                                                    Reference.Data.klasifikasiAset_lvl3.changeParams({params: {id_open: 1, kd_lvl1: Lvl1Field, kd_lvl2: value}});
                                                }
                                                else {
                                                    Lvl3Field.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .50,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Level 3 *',
                                name: 'combo_kd_lvl3',
                                id: 'combo_kd_lvl3',
                                disabled: true,
                                allowBlank: false,
                                labelWidth : 110,
                                store: Reference.Data.klasifikasiAset_lvl3,
                                valueField: 'kd_lvl3',
                                displayField: 'nama', emptyText: 'Klasifikasi Aset',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var Lvl3Field = Ext.getCmp('kd_lvl3');

                                            if (Lvl3Field !== null && !isNaN(value)) {
                                                Lvl3Field.setValue(value);
                                            }
                                        }
                                    }
                                }
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
                                xtype : 'hidden',
                                name : 'no_aset',
                                value: ''
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
        
        Form.Component.dataPerlengkapanAngkutanLaut = function (id_ext_asset)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'Perlengkapan Angkutan Darat',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'id_ext_asset',
                                value:id_ext_asset,
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: 'Jenis Perlengkapan *',
                                name: 'jenis_perlengkapan',
                                anchor: '100%',
                                allowBlank: false,
                                store: Reference.Data.jenisPerlengkapanAngkutanDarat,
                                valueField: 'value',
                                displayField: 'value', emptyText: 'Pilih Jenis',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Ruangan',
                                listeners: {
//                                    'focus': {
//                                        fn: function(comboField) {
//                                            var store = comboField.getStore();
//                                            store.changeParams({params: {kd_lokasi:Utils.getUnkerCombo(form).getValue()}} );
//                                            comboField.expand();
//                                        },
//                                        scope: this
//                                    },
//                                    'change': {
//                                        fn: function(obj, value) {
//
//                                        },
//                                        scope: this
//                                    }
                                }
                            },
                            {
                                fieldLabel: 'No',
                                name: 'no'
                            }, {
                                fieldLabel: 'Nama',
                                name: 'nama',
                            },
                            {
                                xtype:'textarea',
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            }]
                    },]
            };

            return component;
        
        };
        
        Form.Component.dataPerlengkapanAngkutanDarat = function (id_ext_asset)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'Perlengkapan Angkutan Darat',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'id_ext_asset',
                                value:id_ext_asset,
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: 'Jenis Perlengkapan *',
                                name: 'jenis_perlengkapan',
                                anchor: '100%',
                                allowBlank: false,
                                store: Reference.Data.jenisPerlengkapanAngkutanDarat,
                                valueField: 'value',
                                displayField: 'value', emptyText: 'Pilih Jenis',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',
                                listeners: {
//                                    'focus': {
//                                        fn: function(comboField) {
//                                            var store = comboField.getStore();
//                                            store.changeParams({params: {kd_lokasi:Utils.getUnkerCombo(form).getValue()}} );
//                                            comboField.expand();
//                                        },
//                                        scope: this
//                                    },
//                                    'change': {
//                                        fn: function(obj, value) {
//
//                                        },
//                                        scope: this
//                                    }
                                }
                            },
                            {
                                fieldLabel: 'No',
                                name: 'no'
                            }, {
                                fieldLabel: 'Nama',
                                name: 'nama',
                            },
                            {
                                xtype:'textarea',
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            }]
                    },]
            };

            return component;
        
        };
        
        Form.Component.dataPerlengkapanAngkutanLaut = function (id_ext_asset)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'Perlengkapan Angkutan Laut',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'id_ext_asset',
                                value:id_ext_asset,
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: 'Jenis Perlengkapan *',
                                name: 'jenis_perlengkapan',
                                anchor: '100%',
                                allowBlank: false,
                                store: Reference.Data.jenisPerlengkapanAngkutanLaut,
                                valueField: 'value',
                                displayField: 'value', emptyText: 'Pilih Jenis',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',
                                listeners: {
//                                    'focus': {
//                                        fn: function(comboField) {
//                                            var store = comboField.getStore();
//                                            store.changeParams({params: {kd_lokasi:Utils.getUnkerCombo(form).getValue()}} );
//                                            comboField.expand();
//                                        },
//                                        scope: this
//                                    },
//                                    'change': {
//                                        fn: function(obj, value) {
//
//                                        },
//                                        scope: this
//                                    }
                                }
                            },
                            {
                                fieldLabel: 'No',
                                name: 'no'
                            }, {
                                fieldLabel: 'Nama',
                                name: 'nama',
                            },
                            {
                                xtype:'textarea',
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            }]
                    },]
            };

            return component;
        
        };
        
        Form.Component.dataPerlengkapanAngkutanUdara = function (id_ext_asset)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'Perlengkapan Angkutan Udara',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'id_ext_asset',
                                value:id_ext_asset,
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: 'Jenis Perlengkapan *',
                                name: 'jenis_perlengkapan',
                                anchor: '100%',
                                allowBlank: false,
                                store: Reference.Data.jenisPerlengkapanAngkutanUdara,
                                valueField: 'value',
                                displayField: 'value', emptyText: 'Pilih Jenis',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',
                                listeners: {
//                                    'focus': {
//                                        fn: function(comboField) {
//                                            var store = comboField.getStore();
//                                            store.changeParams({params: {kd_lokasi:Utils.getUnkerCombo(form).getValue()}} );
//                                            comboField.expand();
//                                        },
//                                        scope: this
//                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            if(value == "Part Pesawat")
                                            {
                                                Ext.getCmp('perlengkapan_angkutan_udara_part_number').setDisabled(false);
                                                Ext.getCmp('perlengkapan_angkutan_udara_serial_number').setDisabled(false);
                                                Ext.getCmp('perlengkapan_angkutan_udara_keterangan').setDisabled(true);
                                            }
                                            else
                                            {
                                                Ext.getCmp('perlengkapan_angkutan_udara_part_number').setDisabled(true);
                                                Ext.getCmp('perlengkapan_angkutan_udara_serial_number').setDisabled(true);
                                                Ext.getCmp('perlengkapan_angkutan_udara_keterangan').setDisabled(false);
                                            }
                                            
                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                fieldLabel: 'No',
                                name: 'no'
                            }, {
                                fieldLabel: 'Nama',
                                name: 'nama',
                            },
                            {
                                xtype:'textarea',
                                fieldLabel: 'Keterangan',
                                name: 'keterangan',
                                id:'perlengkapan_angkutan_udara_keterangan'
                            },
                            {
                                disabled:true,
                                fieldLabel: 'Part Number',
                                name: 'part_number',
                                id:'perlengkapan_angkutan_udara_part_number'
                            },
                            {
                                disabled:true,
                                fieldLabel: 'Serial Number',
                                name: 'serial_number',
                                id:'perlengkapan_angkutan_udara_serial_number'
                            }]
                    },]
            };

            return component;
        
        }
        
        Form.SubComponent.jenisSatuanDetailPenggunaanAngkutan = function(tipe_angkutan)
        {
          if(tipe_angkutan == "darat")
          {
              var subComponent = {
                  xtype:'container',
                  items:[
                         {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Satuan Penggunaan',
                                    name: 'satuan_penggunaan',
                                    allowBlank: false,
                                    store: Reference.Data.unitPengunaanAngkutanDarat,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Satuan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                             },
                  ]
              }
              
              return subComponent;
          }
          else if(tipe_angkutan == "laut")
          {
              var subComponent = {
                  xtype:'container',
                  items:[
                         {
                            xtype: 'hidden',
                            name: 'satuan_penggunaan',
                            value:'4',
                         },
                         {
                             xtype: 'displayfield',
                             fieldLabel: 'Satuan Penggunaan',
                             value: 'Jam Layar',
                         }
                  ]
              }
              
              return subComponent;

          }
          else if(tipe_angkutan == "udara")
          {
              var subComponent = {
                  xtype:'container',
                  items:[
                         {
                            xtype: 'hidden',
                            name: 'satuan_penggunaan',
                            value:'5',
                         },
                         {
                             xtype: 'displayfield',
                             fieldLabel: 'Satuan Penggunaan',
                             value: 'Jam Terbang',
                         }
                  ]
              }
              
              return subComponent;

          }
        };
        
        Form.Component.dataDetailPenggunaanAngkutan= function(id_ext_asset,tipe_angkutan)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'DETAIL PENGGUNAAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .50,
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
                                name:'id_ext_asset',
                                id:'id_ext_asset_detail_penggunaan_angkutan',
                                value:id_ext_asset,
                            },
                            {
                                xtype:'datefield',
                                fieldLabel: 'Tanggal',
                                name: 'tanggal',
                                format: 'Y-m-d',
                                allowBlank:false,
                            },
                            {
                                fieldLabel: 'Jumlah Penggunaan',
                                name: 'jumlah_penggunaan',
                                allowBlank:false,
                                minValue:1,
                            },
                            Form.SubComponent.jenisSatuanDetailPenggunaanAngkutan(tipe_angkutan)
                           ]
                    }, {
                        columnWidth: .50,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textarea',
                        items: [{
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            },
                        ]
                    }]
            };

            return component;
        
        };
        
        Form.Component.dataRiwayatPajakTanahDanBangunan = function(id_ext_asset)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'RIWAYAT PAJAK',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .50,
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
                                name:'id_ext_asset',
                                value:id_ext_asset,
                            },
                            {
                                fieldLabel: 'Tahun Pajak',
                                name: 'tahun_pajak'
                            }, {
                                xtype:'datefield',
                                fieldLabel: 'Tanggal Pembayaran',
                                name: 'tanggal_pembayaran',
                                format: 'Y-m-d'
                            },
                            {
                                fieldLabel: 'Jumlah Setoran',
                                name: 'jumlah_setoran'
                            },
                            ]
                    }, {
                        columnWidth: .50,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textarea',
                        items: [{
                                fieldLabel: 'Keterangan',
                                name: 'keterangan'
                            },
                        ]
                    }]
            };

            return component;
        
        };
        
        Form.Component.dataPemeliharaanPart = function(id_pemeliharaan,edit)
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'PEMELIHARAAN PART',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [
                            {
                                    readOnly:(edit==true)?true:false,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Penyimpanan *',
                                    name: 'id_penyimpanan',
                                    allowBlank: false,
                                    store: Reference.Data.penyimpanan,
                                    valueField: 'id',
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penyimpanan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'beforeRender': {
                                            fn: function() {
                                                if(setting.isEditing == true)
                                                {
                                                    Reference.Data.penyimpanan.changeParams({params: {id_open: 1, excludedValue: id_perlengkapan}});
                                                }
                                                else
                                                {
                                                    Reference.Data.penyimpanan.changeParams({params: {id_open: 1}});
                                                }
                                            },
                                            scope: this
                                        },
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                    /*
                                                     * If is edit, the combo box will present all id_penerimaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_penerimaan that isn't used yet
                                                     */
                                                    
                                                    Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_penyimpanan/getSpecificInventoryPenyimpanan',
                                                        params: {
                                                            id: value
                                                        },
                                                        success: function(response){
                                                            var data = eval ("(" + response.responseText + ")");
                                                                Ext.getCmp('inventory_data_perlengkapan_part_number').setValue(data.part_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_serial_number').setValue(data.serial_number);
                                                                Ext.getCmp('inventory_data_perlengkapan_qty').setValue(data.qty);
                                                                Ext.getCmp('inventory_data_perlengkapan_status_barang').setValue(data.status_barang);
                                                                Ext.getCmp('inventory_data_perlengkapan_asal_barang').setValue(data.asal_barang);
                                                                Ext.getCmp('pemeliharaan_part_qty').setDisabled(false);
                                                                Ext.getCmp('pemeliharaan_part_qty').setMaxValue(data.qty);
                                                                if(edit == true)
                                                                {
                                                                    Ext.getCmp('inventory_data_perlengkapan_qty').setValue(parseInt(data.qty) + parseInt(Ext.getCmp('pemeliharaan_part_qty').value));
                                                                    Ext.getCmp('pemeliharaan_part_qty').setMaxValue(Ext.getCmp('inventory_data_perlengkapan_qty').value);
                                                                }
//                                                                Ext.getCmp('pemeliharaan_part_qty').reset();
                                                           
                                                        }
                                                        });
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'id_pemeliharaan',
                                value:id_pemeliharaan,
                            },
                            {
                                disabled:true,
                                xtype:'numberfield',
                                fieldLabel: 'Qty Pemeliharaan',
                                name: 'qty_pemeliharaan',
                                id:'pemeliharaan_part_qty',
                                minValue:1,
                            },
                            ]
                    }]
            };

            return component;
        
        }
        
        
        Form.Component.gridPemeliharaanPart = function(setting,edit) {
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: (edit == true)?325:150,
                anchor: '100%',
                title: 'PEMELIHARAAN PART',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.pemeliharaanPart(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
            };

            return component;
        };
        
        Form.Component.gridInventoryPerlengkapan = function(setting) {
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: 325,
                anchor: '100%',
                title: 'PERLENGKAPAN',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [{xtype:'container',height:300,items:[Grid.inventoryPerlengkapan(setting)]}]
            };

            return component;
        };
        
        Form.Component.gridRiwayatPajakTanahDanBangunan = function(setting,edit) {
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: (edit == true)?325:150,
                anchor: '100%',
                title: 'Riwayat Pajak',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.riwayatPajak(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
            };

            return component;
        };

        
//        Form.Component.gridRiwayatPajakTanahDanBangunan = function(setting,edit) {
//            var component = {
//                xtype: 'fieldset',
//                layout:'anchor',
//                height: 325,
//                anchor: '100%',
//                title: 'Riwayat Pajak',
//                border: false,
//                frame: true,
//                defaultType: 'container',
//                items: [{xtype:'container',height:300,items:[Grid.riwayatPajak(setting)]}]
//            };
//
//            return component;
//        };
//        
        
        
        Form.Component.peraturan = function()
        {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'PERATURAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .50,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'textfield',
                        items: [
                            {
                                xtype:'hidden',
                                name:'id',
                            },
                            {
                                xtype:'hidden',
                                name:'date_upload',
                            },
                            {
                                fieldLabel: 'Nama',
                                name: 'nama'
                            }, 
                            {
                                fieldLabel: 'No Dokumen',
                                name: 'no_dokumen'
                            },{
                                xtype:'datefield',
                                fieldLabel: 'Tanggal Dokumen',
                                name: 'tanggal_dokumen',
                                format: 'Y-m-d'
                            },
                            {
                                fieldLabel: 'Initiator',
                                name: 'initiator'
                            },
                            {
                                xtype:'textarea',
                                fieldLabel: 'Perihal',
                                name: 'perihal'
                            },
                        ]
                  
                        
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
        
        Form.SubComponent.tambahanAngkutanDaratPerlengkapan = function(setting,edit){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                height: (edit==true)?325:150,
                title: 'Perlengkapan Angkutan Darat',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.angkutanDaratPerlengkapan(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
        };
                
            return subcomponent;
        };
        
        
        Form.SubComponent.tambahanAngkutanDarat = function() {
            var subcomponent = {
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
                        defaultType: 'textfield',
                        items: [{
                                xtype:'hidden',
                                name:'id_ext_angkutan'
                            },
                            {
                                fieldLabel: 'No STNK',
                                name: 'darat_no_stnk'
                            },
                            {
                                xtype:'datefield',
                                fieldLabel: 'Masa Berlaku STNK',
                                name: 'darat_masa_berlaku_stnk',
                                format: 'Y-m-d'
                            }]
                    }, {
                        columnWidth: .33,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'numberfield',
                        items: [{
                                fieldLabel: 'Jumlah Pajak',
                                name: 'darat_jumlah_pajak'
                            },
                            {
                                xtype:'datefield',
                                fieldLabel: 'Masa Berlaku Pajak',
                                name: 'darat_masa_berlaku_pajak',
                                format: 'Y-m-d'
                            }]
                    },{
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textarea',
                        items: [{
                                fieldLabel:'Keterangan',
                                name: 'darat_keterangan_lainnya',
                        }]
                    }]
            };

            return subcomponent;
        };
        
        Form.Component.tambahanAngkutanDarat = function(setting_grid_perlengkapan,edit) {
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                anchor: '100%',
                title: 'Darat',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [
                        Form.SubComponent.tambahanAngkutanDarat(),
                        Form.SubComponent.tambahanAngkutanDaratPerlengkapan(setting_grid_perlengkapan,edit)
                       ]
            };

            return component;
        };
        
        Form.SubComponent.tambahanAngkutanLautSTKK = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor:'100%',
                title: 'STKK',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                        items: [
                    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                xtype: 'textfield',
                                fieldLabel: 'No',
                                name: 'laut_stkk_no'
                            },
                                    {
                                xtype: 'datefield',
                                fieldLabel: 'Masa Berlaku',
                                name: 'laut_stkk_masa_berlaku',
                                format: 'Y-m-d'
                            },{
                                xtype: 'textarea',
                                fieldLabel: 'Keterangan',
                                name: 'laut_stkk_keterangan'
                            },
                                   ]
                                
                            }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [Form.Component.fileUploadDocumentOnly('laut_stkk_file','AngkutanLautTambahanSTKKFile')]
                    }  
                    ]};
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanLautSuratUkur = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor:'100%',
                title: 'Surat Ukur',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [ {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[
                                        {
                                            xtype: 'textfield',
                                            fieldLabel: 'No',
                                            name: 'laut_surat_ukur_no'
                                        },
                                        {
                                            xtype: 'datefield',
                                            fieldLabel: 'Masa Berlaku',
                                            name: 'laut_surat_ukur_masa_berlaku',
                                            format: 'Y-m-d'
                                        },
                                    ]
                                
                            },
                            {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[  
                                    {
                                            xtype: 'textarea',
                                            fieldLabel: 'Keterangan',
                                            name: 'laut_surat_ukur_keterangan'
                                    }   ]
                              
                            },
                       
                    ]};
                
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanLautSertifikasiKeselamatan = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Sertifikasi Keselamatan',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'laut_sertifikasi_keselamatan_no'
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'Masa Berlaku',
                                        name: 'laut_sertifikasi_keselamatan_masa_berlaku',
                                        format: 'Y-m-d'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'laut_sertifikasi_keselamatan_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('laut_sertifikasi_keselamatan_file','AngkutanLautTambahanSertifikasiKeselamatanFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanLautSertifikasiRadio = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Sertifikasi Radio',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'laut_sertifikasi_radio_no'
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'Masa Berlaku',
                                        name: 'laut_sertifikasi_radio_masa_berlaku',
                                        format: 'Y-m-d'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'laut_sertifikasi_radio_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('laut_sertifikasi_radio_file','AngkutanLautTambahanSertifikasiRadioFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanLautSuratIjinBerlayar = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Surat Ijin Berlayar',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'laut_surat_ijin_berlayar_no'
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'Masa Berlaku',
                                        name: 'laut_surat_ijin_berlayar_masa_berlaku',
                                        format: 'Y-m-d'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'laut_surat_ijin_berlayar_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('laut_surat_ijin_berlayar_file','AngkutanLautTambahanSuratIjinBerlayarFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanLautPerlengkapan = function(setting,edit){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                height: (edit==true)?325:150,
                title: 'Perlengkapan Angkutan Laut',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.angkutanLautPerlengkapan(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
        };
                
            return subcomponent;
        };

        Form.Component.tambahanAngkutanLaut = function(setting_grid_perlengkapan,edit) {
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
//                layout:{type: 'table', columns: 1,tableAttrs: { style: {width: '99%'}}},
//                layout:'anchor',
                anchor: '100%',
                title: 'Laut',
                border: false,
                frame: true,
                defaultType: 'container',
//                defaults: {
//                    layout: 'anchor'
//                },
                items: [
                            Form.SubComponent.tambahanAngkutanLautSTKK(),
                            Form.SubComponent.tambahanAngkutanLautSuratUkur(),
                            Form.SubComponent.tambahanAngkutanLautSertifikasiKeselamatan(),
                            Form.SubComponent.tambahanAngkutanLautSertifikasiRadio(),
                            Form.SubComponent.tambahanAngkutanLautSuratIjinBerlayar(),
                            Form.SubComponent.tambahanAngkutanLautPerlengkapan(setting_grid_perlengkapan,edit)
                            
                       ]
            };

            return component;
        };
        
         Form.SubComponent.tambahanAngkutanUdaraSuratBuktiKepemilikan = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Surat Bukti Kepemilikan',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'udara_surat_bukti_kepemilikan_no'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'udara_surat_bukti_kepemilikan_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('udara_surat_bukti_kepemilikan_file','AngkutanUdaraTambahanSuratBuktiKepemilikanFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
         Form.SubComponent.tambahanAngkutanUdaraSertifikatPendaftaranPesawatUdara = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Sertifikat Pendaftaran Pesawat Udara',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'udara_sertifikat_pendaftaran_pesawat_udara_no'
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'Masa Berlaku',
                                        name: 'udara_sertifikat_pendaftaran_pesawat_udara_masa_berlaku',
                                        format: 'Y-m-d'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'udara_sertifikat_pendaftaran_pesawat_udara_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('udara_sertifikat_pendaftaran_pesawat_udara_file','AngkutanUdaraTambahanSertifikatPendaftaranPesawatUdaraFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
        Form.SubComponent.tambahanAngkutanUdaraSertifikatKelaikanUdara = function(){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Sertifikat Kelaikan Udara',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [    {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[{
                                        xtype: 'textfield',
                                        fieldLabel: 'No',
                                        name: 'udara_sertifikat_kelaikan_udara_no'
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'Masa Berlaku',
                                        name: 'udara_sertifikat_kelaikan_udara_masa_berlaku',
                                        format: 'Y-m-d'
                                    },
                                    {
                                        xtype: 'textarea',
                                        fieldLabel: 'Keterangan',
                                        name: 'udara_sertifikat_kelaikan_udara_keterangan'
                                    }
                                   ]
                                
                            }, {
                                columnWidth: .5,
                                layout: 'anchor',
                                defaults: {
                                    anchor: '95%'
                                },
                                items:[Form.Component.fileUploadDocumentOnly('udara_sertifikat_kelaikan_udara_file','AngkutanUdaraTambahanSertifikatKelaikanUdaraFile')]
                              
                            },
                ]};
                
            return subcomponent;
        };
        
       Form.SubComponent.tambahanAngkutanUdaraPerlengkapan = function(setting,edit){
            var subcomponent = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                height: (edit==true)?325:150,
                title: 'Perlengkapan Angkutan Udara',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.angkutanUdaraPerlengkapan(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]};
                
            return subcomponent;
        };

        Form.Component.tambahanAngkutanUdara = function(setting_grid_perlengkapan,edit) {
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                title: 'Udara',
                border: false,
                frame: true,
                defaultType: 'container',
//                defaults: {
//                    layout: 'anchor'
//                },
                items: [
                            Form.SubComponent.tambahanAngkutanUdaraSuratBuktiKepemilikan(),
                            Form.SubComponent.tambahanAngkutanUdaraSertifikatPendaftaranPesawatUdara(),
                            Form.SubComponent.tambahanAngkutanUdaraSertifikatKelaikanUdara(),
                            Form.SubComponent.tambahanAngkutanUdaraPerlengkapan(setting_grid_perlengkapan,edit),
                            
                ]
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
        
        Form.Component.luar = function(form){
            var Component = {
                xtype:'fieldset',
                anchor: '100%',
                title: 'LUAR',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items:[{
                    xtype: 'textfield',
                    fieldLabel: 'Lokasi Fisik',
                    name: 'lok_fisik',
                    anchor: '50%',
                    allowBlank: false,
                },
                {
                    xtype:'hidden',
                    fieldLabel:'Kode Pemilik',
                    name:'kd_pemilik',
                    value:'1',
                }
                ]
            };
            
            return Component;
        }
        
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
                                        xtype:'hidden',
                                        name:'id',
                                    },
                                    {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Part Number',
                                    name: 'part_number',
                                    allowBlank: true,
                                    store: Reference.Data.partNumber,
                                    valueField: 'part_number',
                                    displayField: 'nama', emptyText: 'Pilih Part Number',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                },
                                {
                                    fieldLabel: 'Serial Number',
                                    name: 'serial_number',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value != '')
                                                {
                                                    var qtyField = Ext.getCmp('pengadaan_data_perlengkapan_qty');
                                                    qtyField.setValue(1);
                                                    qtyField.readOnly = true;
                                                }
                                                else
                                                {
                                                    var qtyField = Ext.getCmp('pengadaan_data_perlengkapan_qty');
                                                    qtyField.readOnly = false;
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    xtype:'numberfield',
                                    fieldLabel:'Qty',
                                    name:'qty',
                                    id:'pengadaan_data_perlengkapan_qty'
                                },
                                {
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
                                    fieldLabel: 'No SPPA *',
                                    name: 'no_sppa',
                                    allowBlank:'false',
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
                                { xtype : 'hidden', name: 'id', id:'hidden_identifier_id_pemeliharaan'},
                                { xtype : 'hidden', name: 'kd_brg'},
                                { xtype : 'hidden', name: 'no_aset'}
                            ];       
            return components;
        };
        
        
/* FORM FOR PEMELIHARAAN TANAH AND BANGUNAN */
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
//                                            var subjenis = form.findField('subjenis');
                                            var subjenis = Ext.getCmp('pemeliharaan_subjenis');
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
                                    id:'pemeliharaan_subjenis',
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
        


        Form.Component.pemeliharaan = function(tipe_angkutan) {
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
                                           var selWaktu = Ext.getCmp('unit_waktu').value;
                                           var selPengunaan = Ext.getCmp('unit_pengunaan').value;
                                           var pilihUnit = Ext.getCmp('comboUnitWaktuOrUnitPenggunaan');
                                           var pilihUnitWaktu = Ext.getCmp('unit_waktu');
                                           var pilihUnitPengunaan = Ext.getCmp('unit_pengunaan');
                                           var pilihFreqwaktu = Ext.getCmp('freq_waktu');
                                           var pilihFreqpengunaan = Ext.getCmp('freq_pengunaan');
                                           var pilihRenwaktu = Ext.getCmp('rencana_waktu');
                                           var pilihRenpengunaan = Ext.getCmp('rencana_pengunaan');
                                           var pilihRenketerangan = Ext.getCmp('rencana_keterangan');
                                           
                                            if (value === 1)
                                            {
                                                pilihUnit.enable();
                                                
                                            }
                                            else if (value === 2)
                                            {
                                                pilihUnit.enable();
                                            }
                                            else if (value === 3)
                                            {
                                                pilihUnit.disable();
                                                pilihUnitWaktu.disable();
                                                pilihUnitPengunaan.disable();
                                                pilihFreqwaktu.disable();
                                                pilihFreqpengunaan.disable();
                                                pilihRenwaktu.disable();
                                                pilihRenpengunaan.disable();
                                                pilihRenketerangan.disable();
                                            }
                                            else
                                            {
                                                pilihUnit.disable();
                                                pilihUnitWaktu.disable();
                                                pilihUnitPengunaan.disable();
                                                pilihFreqwaktu.disable();
                                                pilihFreqpengunaan.disable();
                                                pilihRenwaktu.disable();
                                                pilihRenpengunaan.disable();
                                                pilihRenketerangan.disable();
                                            }
                                            
                                            if(selWaktu != 0 && selWaktu != null)
                                            {
                                                pilihUnit.setValue(1);
                                            }
                                            else if(selPengunaan != 0 && selPengunaan != null)
                                            {
                                                 pilihUnit.setValue(2);
                                            }
                                        }
                                    }

                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Pelaksana',
                                    name: 'pelaksana_tgl',
                                    id: 'pelaksana_tgl',
                                    format: 'Y-m-d',
                                    listeners: {
                                        change: function(obj, value) {
                                           var selectedUnitWaktu = Ext.getCmp('unit_waktu').value;
                                           var selectedRencanaWaktu = Ext.getCmp('rencana_waktu');
                                           var selectedTglPelaksana = Ext.getCmp('pelaksana_tgl').value;
                                           var selectedFreqWaktu = Ext.getCmp('freq_waktu').value;
                                           if(selectedFreqWaktu != null && selectedUnitWaktu != null)
                                           {
                                                if (selectedUnitWaktu === 1) //day
                                                {
                                                      selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.DAY,selectedFreqWaktu));                                            
                                                }
                                                else if (selectedUnitWaktu === 2) //month
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.MONTH,selectedFreqWaktu)); 
                                                }
                                                else if (selectedUnitWaktu === 3) //year
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.YEAR,selectedFreqWaktu));
                                                }
                                                else
                                                {

                                                }
                                           }
                                        }
                                    }
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
                                },
                                (tipe_angkutan != null)?{
                                    xtype:'fieldset',
                                    items:[
                                        {
                                            xtype:'label',
                                            text: 'Status Penggunaan Sampai Saat Ini:',
                                            
                                        },
                                        {
                                            xtype:'displayfield',
                                            id:'pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini',
                                            name:'pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini',
                                            value:'',
                                        }
                                    ]
                                }:{xtype:'displayfield'}
                                
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
                                /*{
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi'
                                },*/
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi',
                                    id : 'kondisi',
                                    allowBlank: true,
                                    store: Reference.Data.kondisiPerlengkapan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Kondisi',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: ''
                                },{
                                    xtype: 'textarea',
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
                                    fieldLabel: 'Pilih Unit',
                                    name: 'comboUnitWaktuOrUnitPenggunaan',
                                    id : 'comboUnitWaktuOrUnitPenggunaan',
                                    allowBlank: true,
                                    store: Reference.Data.pemeliharaanUnitWaktuOrUnitPenggunaan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Unit',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit',
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
                                                unitPengunaan.disable();
                                                freqwaktu.enable();
                                                freqpengunaan.disable();
                                                renwaktu.enable();
                                                renpengunaan.disable();
                                                renketerangan.enable();
                                                alert.enable();
                                                
                                            }
                                            else if (value === 2)
                                            {
                                                unitWaktu.disable();
                                                unitPengunaan.enable();
                                                freqwaktu.disable();
                                                freqpengunaan.enable();
                                                renwaktu.disable();
                                                renpengunaan.enable();
                                                renketerangan.enable();
                                                alert.enable();
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
                                },
                                {
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
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Waktu',
                                    listeners: {
                                        change: function(obj, value) {
                                           var selectedUnitWaktu = Ext.getCmp('unit_waktu').value;
                                           var selectedRencanaWaktu = Ext.getCmp('rencana_waktu');
                                           var selectedTglPelaksana = Ext.getCmp('pelaksana_tgl').value;
                                           var selectedFreqWaktu = Ext.getCmp('freq_waktu').value;
                                           if(selectedFreqWaktu != null && selectedTglPelaksana != null)
                                           {
                                                if (selectedUnitWaktu === 1) //day
                                                {
                                                      selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.DAY,selectedFreqWaktu));                                            
                                                }
                                                else if (selectedUnitWaktu === 2) //month
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.MONTH,selectedFreqWaktu)); 
                                                }
                                                else if (selectedUnitWaktu === 3) //year
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.YEAR,selectedFreqWaktu));
                                                }
                                                else
                                                {

                                                }
                                           }
                                        }
                                    }
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
                                    xtype:'numberfield',
                                    fieldLabel: 'Frequncy Waktu',
                                    name: 'freq_waktu',
                                    id: 'freq_waktu',
                                    disabled: true,
                                    listeners: {
                                        change: function(obj, value) {
                                           var selectedUnitWaktu = Ext.getCmp('unit_waktu').value;
                                           var selectedRencanaWaktu = Ext.getCmp('rencana_waktu');
                                           var selectedTglPelaksana = Ext.getCmp('pelaksana_tgl').value;
                                           if(selectedTglPelaksana != null)
                                           {
                                                if (selectedUnitWaktu === 1) //day
                                                {
                                                      selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.DAY,value));                                            
                                                }
                                                else if (selectedUnitWaktu === 2) //month
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.MONTH,value)); 
                                                }
                                                else if (selectedUnitWaktu === 3) //year
                                                {
                                                    selectedRencanaWaktu.setValue(Ext.Date.add(selectedTglPelaksana, Ext.Date.YEAR,value));
                                                }
                                                else
                                                {

                                                }
                                          }
                                        }
                                    }
                                },{
                                    xtype:'numberfield',
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
                                    disabled: true,
                                    readOnly: true,
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
                                    name: 'quantity',
                                    listeners:{
                                        change:function(v){
                                            var o_form_p = Ext.getCmp('form-process').getForm()
                                                , v_qu = v.getValue()
                                                , v_satuan = o_form_p.findField('harga_satuan').getValue();
                                            o_form_p.findField('harga_total').setValue((v_qu * v_satuan));
                                        }
                                    }
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
                                    name: 'harga_satuan',
                                    listeners:{
                                        change:function(v){
                                            var o_form_p = Ext.getCmp('form-process').getForm()
                                                , v_qu = o_form_p.findField('quantity').getValue()
                                                , v_satuan = v.getValue();
                                            o_form_p.findField('harga_total').setValue((v_qu * v_satuan));
                                        }
                                    }
                                }, {
                                    fieldLabel: 'Harga Total',
                                    readOnly:true,
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
        
        Form.Component.pengelolaan = function(edit) {
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENGELOLAAN',
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
                            items: [
                                {
                                    fieldLabel: 'Nama Operasi SAR',
                                    name: 'nama_operasi',
                                }, {
                                    fieldLabel: 'PIC',
                                    name: 'pic'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Mulai',
                                    name: 'tanggal_mulai',
                                    format : 'Y-m-d'
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Selesai',
                                    name: 'tanggal_selesai',
                                    format : 'Y-m-d'
                                }
                            ]
                        }, {
                            columnWidth: .5,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 80,
                                labelAlign:'bottom',
                            },
                            items: [
                                {
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi',
                                    xtype:'textarea',
                                    anchor:'100%',
                                }
                            ]
                        }]
                }]

            return component;
        }
        
        Form.Component.perlengkapan = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PERLENGKAPAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                        {
                        defaultType: 'hidden',
                        items: [{
                                name: 'warehouse_id',
                                id: 'warehouse_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouse = Ext.getCmp('combo_warehouse_id');
                                            if (comboWarehouse !== null)
                                            {
                                                comboWarehouse.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'ruang_id',
                                id: 'ruang_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouseRuang = Ext.getCmp('combo_ruang_id');
                                            if (comboWarehouseRuang !== null)
                                            {
                                                comboWarehouseRuang.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                name: 'rak_id',
                                id: 'rak_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouseRak = Ext.getCmp('combo_rak_id');
                                            if (comboWarehouseRak !== null)
                                            {
                                                comboWarehouseRak.setValue(value);
                                            }
                                        }
                                    }
                                }
                            },
                                {
                                name: 'unit_waktu',
                                id: 'unit_waktu',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboUnitWaktu = Ext.getCmp('combo_unit_waktu');
                                            if (comboUnitWaktu !== null)
                                            {
                                                comboUnitWaktu.setValue(value);
                                            }
                                            if(value != 0 || value != null)
                                            {
                                                var pilihUnit = Ext.getCmp('comboUnitWaktuOrUnitPenggunaan');
                                                pilihUnit.setValue(1);
                                            }
                                        }
                                    }
                                }
                            },
                                {
                                name: 'unit_freq',
                                id: 'unit_freq',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboUnitFreq = Ext.getCmp('combo_unit_freq');
                                            if (comboUnitFreq !== null)
                                            {
                                                comboUnitFreq.setValue(value);
                                            }
                                            if(value != 0 || value != null)
                                            {
                                                var pilihUnit = Ext.getCmp('comboUnitWaktuOrUnitPenggunaan');
                                                pilihUnit.setValue(2);
                                            }
                                        }
                                    }
                                }
                            },
                                {
                                name: 'part_number',
                                id: 'part_number',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboPartNumber = Ext.getCmp('combo_part_number');
                                            if (comboPartNumber !== null)
                                            {
                                                comboPartNumber.setValue(value);
                                            }
                                        }
                                    }
                                }
                            },
                                {
                                name: 'kd_brg',
                                id: 'kd_brg',
                            }
                            ]
                    },
                        
                       {
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Warehouse',
                                    name: 'combo_warehouse_id',
                                    id : 'combo_warehouse_id',
                                    allowBlank: true,
                                    store: Reference.Data.warehouse,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Warehouse',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var comboWarehouseRuang = Ext.getCmp('combo_ruang_id');
                                                    var fieldWarehouse = Ext.getCmp('warehouse_id');
                                                    
                                                    if (comboWarehouseRuang != null && fieldWarehouse != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRuang.enable();
                                                            fieldWarehouse.setValue(value);
                                                            Reference.Data.warehouseRuang.changeParams({params: {id_open: 1, warehouse_id: value}});
                                                        }
                                                        else {
                                                            comboWarehouseRuang.disable();
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
                                }, {
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Ruang',
                                    name: 'combo_ruang_id',
                                    id : 'combo_ruang_id',
                                    allowBlank: false,
                                    store: Reference.Data.warehouseRuang,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Ruang',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var comboWarehouseRak = Ext.getCmp('combo_rak_id');
                                                    var fieldWarehouseRuang = Ext.getCmp('ruang_id');
                                                    
                                                    if (comboWarehouseRak != null && fieldWarehouseRuang != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRak.enable();
                                                            fieldWarehouseRuang.setValue(value);
                                                            Reference.Data.warehouseRak.changeParams({params: {id_open: 1, warehouseruang_id: value}});
                                                        }
                                                        else {
                                                            comboWarehouseRak.disable();
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
                                }, {
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Rak',
                                    name: 'combo_rak_id',
                                    id : 'combo_rak_id',
                                    allowBlank: false,
                                    store: Reference.Data.warehouseRak,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Rak',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var fieldWarehouseRak = Ext.getCmp('rak_id');
                                                    
                                                    if (fieldWarehouseRak != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            fieldWarehouseRak.setValue(value);
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
                                }
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
                                    fieldLabel: 'Part Number *',
                                    name: 'combo_part_number',
                                    id : 'combo_part_number',
                                    allowBlank: false,
                                    store: Reference.Data.partNumber,
                                    valueField: 'part_number',
                                    displayField: 'nama', emptyText: 'Pilih Part Number',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var fieldPartNumber = Ext.getCmp('part_number');
                                                    
                                                    if (fieldPartNumber != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            fieldPartNumber.setValue(value);
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
                                },
                                {
                                    fieldLabel: 'Serial Number',
                                    name: 'serial_number'
                                },
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Kondisi',
                                    name: 'kondisi',
                                    id : 'kondisi',
                                    allowBlank: true,
                                    store: Reference.Data.kondisiPerlengkapan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Kondisi',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: ''
                                },
                                {
                                    xtype: 'numberfield',
                                    fieldLabel: 'Kuantitas',
                                    name: 'kuantitas'
                                }, {
                                    fieldLabel: 'Dari',
                                    name: 'dari'
                                },
                                {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Perolehan',
                                    name: 'tanggal_perolehan',
                                    format: 'Y-m-d'
                                },
                                {
                                    fieldLabel: 'No Dana',
                                    name: 'no_dana'
                                },]
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
                                    disabled: false,
                                    fieldLabel: 'Pilih Unit',
                                    name: 'comboUnitWaktuOrUnitPenggunaan',
                                    id : 'comboUnitWaktuOrUnitPenggunaan',
                                    allowBlank: true,
                                    store: Reference.Data.pemeliharaanUnitWaktuOrUnitPenggunaan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Unit',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit',
                                    listeners: {
                                        change: function(obj, value) {
                                            var unitWaktu = Ext.getCmp('combo_unit_waktu');
                                            var unitPengunaan = Ext.getCmp('combo_unit_freq');
                                            var freqwaktu = Ext.getCmp('penggunaan_waktu');
                                            var freqpengunaan = Ext.getCmp('penggunaan_freq');
                                            if (value === 1)
                                            {
                                                unitWaktu.enable();
                                                unitPengunaan.disable();
                                                freqwaktu.enable();
                                                freqpengunaan.disable();
                                                
                                            }
                                            else if (value === 2)
                                            {
                                                unitWaktu.disable();
                                                unitPengunaan.enable();
                                                freqwaktu.disable();
                                                freqpengunaan.enable();
                                            }
                                            else
                                            {
                                                unitWaktu.disable();
                                                unitPengunaan.disable();
                                                freqwaktu.disable();
                                                freqpengunaan.disable();
                                            }
                                        }
                                    }
                                },
                                {
                                    disabled:true,
                                    xtype: 'numberfield',
                                    fieldLabel: 'Penggunaan Waktu',
                                    name: 'penggunaan_waktu',
                                    id:'penggunaan_waktu'
                                },{
                                    disabled:true,
                                    xtype: 'numberfield',
                                    fieldLabel: 'Penggunaan Freq',
                                    name: 'penggunaan_freq',
                                    id: 'penggunaan_freq',
                                },
                                {
                                    disabled:true,
                                    xtype: 'combo',
                                    fieldLabel: 'Unit Waktu',
                                    name: 'combo_unit_waktu',
                                    id : 'combo_unit_waktu',
                                    allowBlank: true,
                                    store: Reference.Data.unitWaktu,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Unit Waktu',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Waktu',
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
                                                    var fieldUnitWaktu = Ext.getCmp('unit_waktu');
                                                    
                                                    if (fieldUnitWaktu != null) {
                                                        
                                                            fieldUnitWaktu.setValue(value);
                                                        
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
                                    disabled:true,
                                    xtype: 'combo',
                                    fieldLabel: 'Unit Freq',
                                    name: 'combo_unit_freq',
                                    id : 'combo_unit_freq',
                                    allowBlank: true,
                                    store: Reference.Data.unitPengunaan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Unit Freq',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Freq',
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
                                                    var fieldUnitFreq = Ext.getCmp('unit_freq');
                                                    if (fieldUnitFreq != null) {
                                                    
                                                            fieldUnitFreq.setValue(value);
                                                        
                                                    }
                                                    else {
                                                        console.error('error');
                                                    }
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    xtype: 'checkboxfield',
                                    value: 0,
                                    inputValue: 1,
                                    fieldLabel: 'Disimpan',
                                    name: 'disimpan',
                                    boxLabel: 'Ya'
                                },
                                {
                                    xtype: 'checkboxfield',
                                    inputValue: 1,
                                    fieldLabel: 'Dihapus',
                                    name: 'dihapus',
                                    boxLabel: 'Ya'
                                },
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.dataInventoryPerlengkapan = function(readOnly) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'DETAIL PERLENGKAPAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                        
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [
                                    {
                                    readOnly:(readOnly == true)?true:false,
                                    disabled: false,
                                    fieldLabel: 'Kode Barang',
                                    name: 'kd_brg',
                                    id:'inventory_data_perlengkapan_kode_barang'
                                    },{
                                    readOnly:(readOnly == true)?true:false,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Part Number *',
                                    name: 'part_number',
                                    id:'inventory_data_perlengkapan_part_number',
                                    allowBlank: false,
                                    store: Reference.Data.partNumber,
                                    valueField: 'part_number',
                                    displayField: 'nama', emptyText: 'Pilih Part Number',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                },
                                {
                                    readOnly:(readOnly == true)?true:false,
                                    fieldLabel: 'Serial Number',
                                    name: 'serial_number',
                                    id:'inventory_data_perlengkapan_serial_number',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value != '')
                                                {
                                                    var qtyField = Ext.getCmp('inventory_data_perlengkapan_qty');
                                                    qtyField.setValue(1);
                                                    qtyField.readOnly = true;
                                                }
                                                else
                                                {
                                                    var qtyField = Ext.getCmp('inventory_data_perlengkapan_qty');
                                                    qtyField.readOnly = false;
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    readOnly:(readOnly == true)?true:false,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Status Barang',
                                    name: 'status_barang',
                                    id:'inventory_data_perlengkapan_status_barang',
                                    allowBlank: true,
                                    store: Reference.Data.kondisiPerlengkapan,
                                    valueField: 'value',
                                    displayField: 'text', emptyText: 'Pilih Status',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: ''
                                },
                                {
                                    readOnly:(readOnly == true)?true:false,
                                    xtype: 'numberfield',
                                    fieldLabel: 'Qty',
                                    name: 'qty',
                                    id:'inventory_data_perlengkapan_qty'
                                },
                                {
                                    readOnly:(readOnly == true)?true:false,
                                    disabled: false,
                                    fieldLabel: 'Asal Barang',
                                    name: 'asal_barang',
                                    id:'inventory_data_perlengkapan_asal_barang'
                                },
                                {
                                    xtype:'hidden',
                                    name: 'id',
                                    value:'',
                                },
                                {
                                    xtype:'hidden',
                                    name: 'id_inventory',
                                    value:'',
                                },
                                
                            ]
                        }]
                }]

            return component;
        };
        
        
        Form.Component.inventorypenerimaan = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENERIMAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 130
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Berita Acara *',
                                    name: 'tgl_berita_acara',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                }, {
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara *',
                                    name: 'nomor_berita_acara',
                                    allowBlank: false,
                                }, {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Penerimaan *',
                                    name: 'tgl_penerimaan',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                },
                                {
                                    disabled: false,
                                    fieldLabel: 'Nama Penerima *',
                                    name: 'nama_org',
                                    allowBlank: false,
                                },
                                {
                                    xtype:'textarea',
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan',
                                },
                                {
                                    xtype:'hidden',
                                    disabled: false,
                                    fieldLabel: 'Date Created',
                                    name: 'date_created',
                                    value: new Date()
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.inventorypemeriksaan = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMERIKSAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 130
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Berita Acara *',
                                    name: 'tgl_berita_acara',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                }, {
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara *',
                                    name: 'nomor_berita_acara',
                                    allowBlank: false,
                                }, {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Penyimpanan *',
                                    name: 'tgl_penyimpanan',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                },
                                {
                                    disabled: false,
                                    fieldLabel: 'Nama Pemeriksa *',
                                    name: 'nama_org',
                                    allowBlank: false,
                                },
                                {
                                    xtype:'textarea',
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan',
                                },
                                {
                                    xtype:'hidden',
                                    disabled: false,
                                    fieldLabel: 'Date Created',
                                    name: 'date_created',
                                    value: new Date()
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.inventorypenyimpanan = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENYIMPANAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 130
                            },
                            defaultType: 'textfield',
                            items: [{
                                xtype:'hidden',
                                name: 'warehouse_id',
                                id: 'warehouse_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouse = Ext.getCmp('combo_warehouse_id');
                                            if (comboWarehouse !== null)
                                            {
                                                comboWarehouse.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                xtype:'hidden',
                                name: 'ruang_id',
                                id: 'ruang_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouseRuang = Ext.getCmp('combo_ruang_id');
                                            if (comboWarehouseRuang !== null)
                                            {
                                                comboWarehouseRuang.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, {
                                xtype:'hidden',
                                name: 'rak_id',
                                id: 'rak_id',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboWarehouseRak = Ext.getCmp('combo_rak_id');
                                            if (comboWarehouseRak !== null)
                                            {
                                                comboWarehouseRak.setValue(value);
                                            }
                                        }
                                    }
                                }
                            },
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Warehouse',
                                    name: 'combo_warehouse_id',
                                    id : 'combo_warehouse_id',
                                    allowBlank: false,
                                    store: Reference.Data.warehouse,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Warehouse',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var comboWarehouseRuang = Ext.getCmp('combo_ruang_id');
                                                    var fieldWarehouse = Ext.getCmp('warehouse_id');
                                                    
                                                    if (comboWarehouseRuang != null && fieldWarehouse != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRuang.enable();
                                                            fieldWarehouse.setValue(value);
                                                            Reference.Data.warehouseRuang.changeParams({params: {id_open: 1, warehouse_id: value}});
                                                        }
                                                        else {
                                                            comboWarehouseRuang.disable();
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
                                }, {
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Ruang',
                                    name: 'combo_ruang_id',
                                    id : 'combo_ruang_id',
                                    allowBlank: false,
                                    store: Reference.Data.warehouseRuang,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Ruang',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var comboWarehouseRak = Ext.getCmp('combo_rak_id');
                                                    var fieldWarehouseRuang = Ext.getCmp('ruang_id');
                                                    
                                                    if (comboWarehouseRak != null && fieldWarehouseRuang != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRak.enable();
                                                            fieldWarehouseRuang.setValue(value);
                                                            Reference.Data.warehouseRak.changeParams({params: {id_open: 1, warehouseruang_id: value}});
                                                        }
                                                        else {
                                                            comboWarehouseRak.disable();
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
                                }, {
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Rak',
                                    name: 'combo_rak_id',
                                    id : 'combo_rak_id',
                                    allowBlank: true,
                                    store: Reference.Data.warehouseRak,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Rak',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
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
                                                    var fieldWarehouseRak = Ext.getCmp('rak_id');
                                                    
                                                    if (fieldWarehouseRak != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            fieldWarehouseRak.setValue(value);
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
                                },
                                {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Berita Acara *',
                                    name: 'tgl_berita_acara',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                }, {
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara *',
                                    name: 'nomor_berita_acara',
                                    allowBlank: false,
                                }, {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Penyimpanan *',
                                    name: 'tgl_penyimpanan',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                },
                                {
                                    disabled: false,
                                    fieldLabel: 'Nama Penyimpan *',
                                    name: 'nama_org',
                                    allowBlank: false,
                                },
                                {
                                    xtype:'textarea',
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan',
                                },
                                {
                                    xtype:'hidden',
                                    disabled: false,
                                    fieldLabel: 'Date Created',
                                    name: 'date_created',
                                    value: new Date()
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.inventorypengeluaran = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENGELUARAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 130
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'numberfield',
                                    disabled: true,
                                    fieldLabel: 'Qty Barang Keluar *',
                                    name: 'qty_barang_keluar',
                                    id:'inventory_data_pengeluaran_qty_barang_keluar',
                                    minValue: 1,
                                }, 
                                {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Berita Acara *',
                                    name: 'tgl_berita_acara',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                }, {
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara *',
                                    name: 'nomor_berita_acara',
                                    allowBlank: false,
                                }, {
                                    xtype: 'datefield',
                                    disabled: false,
                                    fieldLabel: 'Tanggal Pengeluaran *',
                                    name: 'tgl_pengeluaran',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                },
                                {
                                    disabled: false,
                                    fieldLabel: 'Nama Pengeluar *',
                                    name: 'nama_org',
                                    allowBlank: false,
                                },
                                {
                                    xtype:'textarea',
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan',
                                },
                                {
                                    xtype:'hidden',
                                    disabled: false,
                                    fieldLabel: 'Date Created',
                                    name: 'date_created',
                                    value: new Date()
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.penghapusanDanMutasi = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'Detail',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items: [{
                                    fieldLabel: 'NO SPPA',
                                    name: 'no_sppa',
                                    readOnly:true,
                                },
                                {
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'thn_ang',
                                    readOnly:true,
                                },
                                {
                                    fieldLabel: 'Kode Asset',
                                    name: 'kd_brg',
                                    readOnly:true,
                                },{
                                    fieldLabel: 'No Awal',
                                    name: 'no_awal',
                                    readOnly:true,
                                },
                                {
                                    fieldLabel: 'No Akhir',
                                    name: 'no_akhir',
                                    readOnly:true,
                                },{
                                    xtype: 'datefield',
                                    readOnly:true,
                                    fieldLabel: 'Tanggal Perolehan',
                                    name: 'tgl_perlh',
                                },{
                                    xtype: 'datefield',
                                    readOnly:true,
                                    fieldLabel: 'Tanggal Buku',
                                    name: 'tgl_buku',
                                },
                                {
                                    readOnly:true,
                                    fieldLabel: 'No SK',
                                    name: 'no_dsr_mts',
                                },{
                                    xtype: 'datefield',
                                    readOnly:true,
                                    fieldLabel: 'Tanggal SK',
                                    name: 'tgl_dsr_mts',
                                },
                                {
                                    readOnly:true,
                                    fieldLabel: 'Keterangan',
                                    name: 'keterangan',
                                },
                                
                            ]
                        }]
                }]

            return component;
        };
        
  

        
        Form.Component.detailPenggunaanAngkutan = function(setting_grid_penggunaan,edit) {
            
        var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'DETAIL PENGGUNAAN',
                border: false,
                frame: true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items: [
                                    {
                                        xtype:'displayfield',
                                        fieldLabel:'Total Penggunaan',
                                        name:'total_penggunaan',
                                        labelWidth: 125,
                                        id:'total_detail_penggunaan_angkutan',
                                        value:'',
                                    },
//                                    {
//                                        xtype:'displayfield',
//                                        fieldLabel:'Satuan',
//                                        name:'satuan_detail_penggunaan_angkutan',
//                                        labelWidth: 125,
//                                        id:'satuan_detail_penggunaan_angkutan',
//                                        value:'',
//                                    },
                                    {
                                        xtype:'fieldset',
                                        title:'Daftar Penggunaan',
                                        height:(edit ==true)?325:150,
                                        items:[(edit==true)?{xtype:'container',height:300,items:[Grid.detailPenggunaanAngkutan(setting_grid_penggunaan,edit)]}:{xtype:'displayfield', value:'Harap Simpan data terlebih dahulu'}]
                                    }
                                    
                                ]
                    },
                    ]
            };

            return component;
            
            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                anchor: '100%',
                title: 'DETAIL PENGGUNAAN',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [
                        
//                        Form.SubComponent.tambahanAngkutanDaratPerlengkapan(setting_grid_penggunaan,edit)
                       ]
            };

            return component;
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>