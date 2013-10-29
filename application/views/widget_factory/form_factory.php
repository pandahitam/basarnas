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
            penerimaanPemeriksaan: BASE_URL + 'combo_ref/combo_penerimaan_pemeriksaan',
            penyimpanan: BASE_URL + 'combo_ref/combo_penyimpanan',
            partsInventoryPengeluaran: BASE_URL + 'combo_ref/combo_parts_inventory_pengeluaran',
            assetPerlengkapanPart: BASE_URL + 'combo_ref/combo_asset_perlengkapan_part',
            provinsi:BASE_URL + 'combo_ref/combo_prov',
            kabupaten:BASE_URL + 'combo_ref/combo_kabkota',
        };
        
        Reference.Data.kabupaten = new Ext.create('Ext.data.Store', {
            fields: ['kode_kabkota','nama_kabkota'], storeId: 'referensiKabupaten',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.kabupaten, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.provinsi = new Ext.create('Ext.data.Store', {
            fields: ['kode_prov','nama_prov'], storeId: 'referensiProvinsi',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.provinsi, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.assetPerlengkapanPart = new Ext.create('Ext.data.Store', {
            fields: ['id','part_number','serial_number'], storeId: 'assetPerlengkapanPart',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.assetPerlengkapanPart, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });

        Reference.Data.partsInventoryPengeluaran = new Ext.create('Ext.data.Store', {
            fields: ['id','part_number','nama'], storeId: 'DataPartsInventoryPengeluaranCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.partsInventoryPengeluaran, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.penyimpanan = new Ext.create('Ext.data.Store', {
            fields: ['id','nomor_berita_acara'], storeId: 'DataPenyimpananCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.penyimpanan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
            }),
            autoLoad: true
        });
        
        Reference.Data.pengadaan = new Ext.create('Ext.data.Store', {
            fields: ['id','no_sppa', 'part_number', 'serial_number'], storeId: 'DataPengadaanCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.pengadaan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1 }
            }),
            autoLoad: true
        });
        
        
        Reference.Data.penerimaanPemeriksaan = new Ext.create('Ext.data.Store', {
            fields: ['id','nomor_berita_acara'], storeId: 'DataPenerimaanPemeriksaanCombo',
            proxy: new Ext.data.AjaxProxy({
                url: Reference.URL.penerimaanPemeriksaan, actionMethods: {read: 'POST'}, extraParams: {id_open: 1}
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
        Reference.Data.jenisReferensiPart = new Ext.create('Ext.data.Store', {
            fields: ['jenis'],
            data: [{jenis: 'Fast Moving'}, {jenis: 'Slow Moving'}]
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

		
		
Form.inventoryPenerimaanPemeriksaan = function(setting, setting_grid_parts)
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
                                    readOnly:setting.isEditing,
                                    editable:false,
                                    disabled: false,
                                    fieldLabel: 'No. SPPA Pengadaan',
                                    name: 'id_pengadaan',
                                    allowBlank: true,
                                    store: Reference.Data.pengadaan,
                                    valueField: 'id',
                                    displayField: 'no_sppa', emptyText: 'Pilih Pengadaan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners:{
                                        change:{
                                            fn:function(obj, value){
                                                  
                                                if (value !== 0 && value !== '')
                                                {
                                                    /*
                                                     * If is edit, the combo box will present all id_pengadaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_pengadaan that isn't used yet
                                                     */
                                                    if(setting.isEditing == false)
                                                    {
                                                        Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_perlengkapan/getSpecificPengadaanPerlengkapan',
                                                        params: {
                                                            id_source: value
                                                        },
                                                        success: function(response){
                                                            var convertedResponseData = eval ("(" + response.responseText + ")");
                                                            var data = convertedResponseData.results;
                                                            var kd_lokasi = data[0].kd_lokasi;
                                                            var kode_unor = data[0].kode_unor;
                                                            var dataStoreInventoryPenerimaanPemeriksaan = Ext.getCmp('grid_inventory_penerimaan_pemeriksaan_parts').getStore();
                                                            dataStoreInventoryPenerimaanPemeriksaan.removeAll();
                                                            Ext.getCmp('kd_lokasi').setValue(kd_lokasi);
                                                            Ext.getCmp('kode_unor').setValue(kode_unor);
                                                            
                                                            Ext.Array.each(data,function(key,index,myself){
                                                                data[index].id = '';
                                                                data[index].id_source = '';
                                                            });
                                                            dataStoreInventoryPenerimaanPemeriksaan.add(data);
                                                        }
                                                        });
                                                    }
                                                    
                                                }
                                            }
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            var form = Form.panelInventory(setting.url, setting.data, setting.isEditing, setting_grid_parts.dataStore);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPengadaan);
            form.insert(2, Form.Component.inventoryPenerimaanPemeriksaan());
            form.insert(3, Form.Component.gridParts(setting_grid_parts,false));

            return form;
        };
        

        
        Form.inventoryPenyimpanan = function(setting,setting_grid_parts)
        {

            var pilihPenerimaanPemeriksaan = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENERIMAAN/PEMERIKSAAN',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 250
                            },
                            defaultType: 'textfield',
                            items: [{
                                    xtype: 'combo',
                                    readOnly:setting.isEditing,
                                    disabled: false,
                                    editable:false,
                                    fieldLabel: 'No. Berita Acara Penerimaan/Pemeriksaan *',
                                    name: 'id_penerimaan_pemeriksaan',
                                    id:'combo_inventory_penyimpanan_berita_acara',
                                    allowBlank: false,
                                    store: Reference.Data.penerimaanPemeriksaan,
                                    valueField: 'id',
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penerimaan/Pemeriksaan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'beforeRender': {
                                            fn: function() {
                                                if(setting.isEditing == true)
                                                {
                                                    Reference.Data.penerimaanPemeriksaan.changeParams({params: {id_open: 1, excludedValue: Ext.getCmp('combo_inventory_penyimpanan_berita_acara').value}});
                                                }
                                                else
                                                {
                                                    //Reference.Data.penerimaanPemeriksaan.changeParams({params: {id_open: 1}});
                                                }
                                            },
                                            scope: this
                                        },
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null && value !== '')
                                                {
                                                    var number_of_invalid_fields = parseInt(0);
                                                    
                                                    /*
                                                     * If is edit, the combo box will present all id_penerimaan that isn't used yet + the current selected value
                                                     * if not is edit, the combo box will only present all id_penerimaan that isn't used yet
                                                     */
                                                    
                                                    Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_perlengkapan/getSpecificInventoryPenerimaanPemeriksaanPerlengkapan',
                                                        params: {
                                                            id_source: value
                                                        },
                                                        success: function(response,action){
                                                                
                                                                if(setting.isEditing == false)
                                                                {
                                                                    
                                                                    
                                                                    var convertedResponseData = eval ("(" + response.responseText + ")");
                                                                    var data = convertedResponseData.results;
                                                                    var kd_lokasi = data[0].kd_lokasi;
                                                                    var kode_unor = data[0].kode_unor;
                                                                    var dataStoreInventoryPenyimpanan = Ext.getCmp('grid_inventory_penyimpanan_parts').getStore();
                                                                    dataStoreInventoryPenyimpanan.removeAll();
                                                                    Ext.getCmp('kd_lokasi').setValue(kd_lokasi);
                                                                    Ext.getCmp('kode_unor').setValue(kode_unor);
                                                                    Ext.Array.each(data,function(key,index,myself){
                                                                        data[index].id = '';
                                                                        data[index].id_source = '';
                                                                        if(data[index].id_warehouse == undefined || data[index].id_warehouse_ruang == undefined)
                                                                        {
                                                                            number_of_invalid_fields++;
                                                                        }
                                                                    });
                                                                    dataStoreInventoryPenyimpanan.add(data);
                                                                    Ext.getCmp('inventory_penyimpanan_grid_invalid_data').setValue(parseInt(number_of_invalid_fields));
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
            var form = Form.panelInventory(setting.url, setting.data, setting.isEditing,setting_grid_parts.dataStore);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, pilihPenerimaanPemeriksaan);
            form.insert(2, Form.Component.inventoryPenyimpanan(setting.isEditing));
            form.insert(3, Form.Component.gridPartsInventoryPenyimpanan(setting_grid_parts));

            return form;
        }
        
        Form.inventoryPengeluaran = function(setting,setting_grid_parts,id_perlengkapan)
        {

            var form = Form.panelInventoryPengeluaran(setting.url, setting.data, setting.isEditing, setting_grid_parts.dataStore);
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.inventoryPengeluaran(setting.isEditing));
//            form.insert(2, Form.Component.dataInventoryPerlengkapan(true));
            form.insert(3, Form.Component.gridParts(setting_grid_parts,true));
            return form;
        }
        
        Form.pengadaan = function(setting,setting_grid_parts)
        {
            
            var form = Form.panelPengadaan(setting.url, setting.data, setting.isEditing, setting.addBtn);
             form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'Reference',
                border: false,
                defaultType: 'container',
                frame: true,
                items: [{
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items : [{
                                    allowBlank:true,
                                    fieldLabel : "Kode Barang *",
                                    name : "kd_brg",
                                    readOnly:true,
                            }]
                        },{
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items : [{
                                    fieldLabel : "Nama",
                                    name : "nama",
                                    readOnly:true,
                            }]
                        },{
                            columnWidth: .34,
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 120
                            },
                            defaultType: 'textfield',
                            items : [{
                                    allowBlank:true,
                                    fieldLabel : "No Aset *",
                                    name : "no_aset",
                                    readOnly:true,
                            }]
                        }]
            });
//            form.insert(1, {
//                xtype: 'fieldset',
//                layout: 'column',
//                anchor: '100%',
//                title: 'Reference',
//                border: false,
//                defaultType: 'container',
//                frame: true,
//                items: [{
//                            columnWidth: .5,
//                            layout: 'anchor',
//                            defaults: {
//                                anchor: '95%',
//                                labelWidth: 120
//                            },
//                            defaultType: 'textfield',
//                            items : [{
//                                    fieldLabel : "Kode Barang ",
//                                    name : "kd_brg"
//                            }]
//                        },{
//                            columnWidth: .5,
//                            layout: 'anchor',
//                            defaults: {
//                                anchor: '100%',
//                                labelWidth: 120
//                            },
//                            defaultType: 'textfield',
//                            items : [{
//                                    fieldLabel : "Nama",
//                                    name : "nama"
//                            }]
//                        }]
//            });
            form.insert(2, Form.Component.pengadaan());
            form.insert(3, Form.Component.gridParts(setting_grid_parts,false));
            form.insert(4, Form.Component.fileUpload());

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
            var form = Form.processPengadaanInPerlengkapan(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
            form.insert(2, Form.Component.pengadaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        }

        Form.perencanaan = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,false));
            form.insert(1, Form.Component.kode(setting.isEditing));
            form.insert(2, Form.Component.perencanaan());
            form.insert(3, Form.Component.fileUpload());

            return form;
        };
        
        //start form pendayagunaan
        Form.pendayagunaan = function(setting,dataid)
        {
            var form = Form.panelPendayagunaan(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,true));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
//            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing))
            form.insert(3, Form.Component.pendayagunaan(dataid));
            form.insert(4, Form.Component.fileUploadDocumentOnly('document','fileupload_pendayagunaan'));

            return form;
        };
        
        Form.pendayagunaanInAsset = function(setting,dataid)
        {
            var form = Form.panelPendayagunaan(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
//            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing));
            form.insert(3, Form.Component.pendayagunaan());
            form.insert(4, Form.Component.fileUploadDocumentOnly('document','fileupload_pendayagunaan'));

            return form;
        };
        
        Form.pengelolaanInAsset = function(setting)
        {
            var form = Form.process(setting.url, setting.data, setting.isEditing, setting.addBtn);
            form.insert(1, Form.Component.hiddenIdentifier());
//            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing));
            form.insert(2, Form.Component.pengelolaan(setting.isEditing));
            form.insert(3, Form.Component.fileUpload(setting.isEditing));

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
//                                {
//                                    xtype:'numberfield',
//                                    fieldLabel: 'Part Number',
//                                    name: 'part_number',
//                                }, {
//                                    xtype:'numberfield',
//                                    fieldLabel: 'Serial Number',
//                                    name: 'serial_number'
//                                }, 
                                {
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

        
        Form.pemeliharaanWithParts = function(setting,setting_grid_pemeliharaan_part)
        {
            var form = Form.panelPemeliharaanParts(setting.url, setting.data, setting.isEditing, setting_grid_pemeliharaan_part.dataStore,setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,true));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(4, Form.Component.fileUpload());
            
            var tipe_angkutan = setting.tipe_angkutan;
            form.insert(2, Form.Component.pemeliharaan(tipe_angkutan));
            form.insert(3, Form.Component.gridPemeliharaanPart(setting_grid_pemeliharaan_part,setting.isEditing));
                
            return form;
        };
        
        
        Form.panelPemeliharaanPartsAngkutanUdara = function(url, data, edit, dataStoreParts, addBtn) {
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
                                var list_data = dataStoreParts.getRange();
                                var data_to_check = [];
                                Ext.Array.each(list_data,function(key,index,self){
                                    if(list_data[index].phantom == true || list_data[index].dirty == true)
                                    {
                                        data_to_check.push(list_data[index].data);
                                    }
                                });
                                //checks the real quantity from the server to minimize dirty read
                                //NOT YET FINISHED
                                var flag_quantity = true;
//                                $.ajax({
//                                    url:BASE_URL + 'inventory_penyimpanan/checkServerQuantity',
//                                    type: "POST",
//                                    dataType:'json',
//                                    async:false,
//                                    data:{data:data_to_check},
//                                    success:function(response, status){
//                                        flag_quantity = true;
//
//                                    }
//                                 });
                                if(flag_quantity == true)
                                {
                                    form.submit({
                                        success: function(form,action) {
                                            
                                            var id = action.result.id;
                                            var gridStore = dataStoreParts;
                                            var new_records = gridStore.getNewRecords();
    //                                        var updated_records = grid.getUpdatedRecords();
    //                                        var removed_records = grid.getRemovedRecords();
                                            Ext.each(new_records, function(obj){
                                                var index = gridStore.indexOf(obj);
                                                var record = gridStore.getAt(index);
                                                record.set('id_ext_asset',id);
                                            });
                                            
                                                gridStore.sync();


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
                                else
                                {
                                    Ext.MessageBox.alert('Fail', 'Terdapat kesalahan pada qty. Harap melakukan perbaikan');
                                }
                                
                            }
                            
                        }
                    }, {
                        text: addBtn.text, iconCls: 'icon-add', hidden: addBtn.isHidden,
                        handler: addBtn.fn
                    }]
            });


            return _form;
        };
        
        Form.Component.gridPemeliharaanAngkutanUdaraPerlengkapan = function(setting,edit){
            var component = {
                xtype: 'fieldset',
                layout: 'anchor',
                anchor: '100%',
                id:'grid_pemeliharaan_perlengkapan_angkutan_udara',
                height: 325,
                title: 'PERLENGKAPAN ANGKUTAN UDARA',
                border: false,
                frame: true,
                disabled:(edit == true)?false:true,
                defaultType: 'container',
                defaults: {
                    layout: 'anchor'
                },
                items: [{xtype:'container',height:300,items:[Grid.angkutanUdaraPerlengkapan(setting)]}]};
                
            return component;
        };
        
        Form.pemeliharaanWithPartsAngkutanUdara = function(setting,setting_grid_pemeliharaan_part)
        {
            var form = Form.panelPemeliharaanPartsAngkutanUdara(setting.url, setting.data, setting.isEditing, setting_grid_pemeliharaan_part.dataStore,setting.addBtn);
            form.insert(0, Form.Component.unit(setting.isEditing,form,true));
            form.insert(1, Form.Component.selectionAsset(setting.selectionAsset));
            form.insert(4, Form.Component.fileUpload());
            
            var tipe_angkutan = setting.tipe_angkutan;
            form.insert(2, Form.Component.pemeliharaan(tipe_angkutan));
            form.insert(3, Form.Component.gridPemeliharaanAngkutanUdaraPerlengkapan(setting_grid_pemeliharaan_part,setting.isEditing));
                
            return form;
        };
        
        
        
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
            var form = Form.panelPeraturan(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, Form.Component.peraturan());
            form.insert(1, Form.Component.fileUploadSingleDocumentOnly('document','fileupload_peraturan'));
            
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
            var form = Form.asset(setting.url, setting.dataGrid, setting.isEditing);
            
            form.insert(0, Form.Component.unit(setting.isEditing,form));
            form.insert(1, Form.Component.kode(setting.isEditing));
            form.insert(2, Form.Component.klasifikasiAset(setting.isEditing))
            form.insert(3, Form.Component.ruang(form));
            form.insert(4, Form.Component.fileUpload(setting.isEditing));
            
            return form;
        }
        
        Form.referensiKlasifikasiAsetLvl1 = function(setting)
        {
            var form = Form.referensiKlasifikasiAset(setting.url,setting.data,setting.isEditing,'ref_klasifikasiaset_lvl1','kd_lvl1');
            form.insert(0, Form.Component.referensiKlasifikasiAset('KLASIFIKASI ASET LVL 1','kd_lvl1',setting.isEditing));
            
            return form;
        }
        
        Form.referensiKlasifikasiAsetLvl2 = function(setting)
        {
            var pilihKlasifikasiAset = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title:'KLASIFIKASI ASET',
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
                                    fieldLabel: 'Klasifikasi Aset Lvl 1 *',
                                    name: 'kd_lvl1',
                                    allowBlank: false,
                                    store: Reference.Data.klasifikasiAset_lvl1,
                                    valueField: 'kd_lvl1',
                                    displayField: 'nama', emptyText: 'Pilih Klasifikasi Aset',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                   
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            
            var form = Form.referensiKlasifikasiAset(setting.url,setting.data,setting.isEditing,'ref_klasifikasiaset_lvl2','kd_lvl2_brg');
            form.insert(0, pilihKlasifikasiAset);
            form.insert(1, Form.Component.referensiKlasifikasiAset('KLASIFIKASI ASET LVL 2','kd_lvl2',setting.isEditing));
            
            return form;
        }
        
        Form.referensiKlasifikasiAsetLvl3 = function(setting)
        {
            var pilihKlasifikasiAset = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title:'KLASIFIKASI ASET',
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
                                    fieldLabel: 'Klasifikasi Aset Lvl 1 *',
                                    name: 'kd_lvl1',
                                    id:'referensi_klasifikasi_aset_lvl1',
                                    allowBlank: false,
                                    store: Reference.Data.klasifikasiAset_lvl1,
                                    valueField: 'kd_lvl1',
                                    displayField: 'nama', emptyText: 'Pilih Klasifikasi Aset',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                { 
                                                    var Lvl2Field = Ext.getCmp('referensi_klasifikasi_aset_lvl2');
                                                    if (Lvl2Field !== null) {
                                                        if (!isNaN(value) && value.length > 0) {
                                                            Lvl2Field.enable();
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
                                    readOnly:setting.isEditing,
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Klasifikasi Aset Lvl 2 *',
                                    name: 'kd_lvl2',
                                    id:'referensi_klasifikasi_aset_lvl2',
                                    allowBlank: false,
                                    store: Reference.Data.klasifikasiAset_lvl2,
                                    valueField: 'kd_lvl2',
                                    displayField: 'nama', emptyText: 'Pilih Klasifikasi Aset',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                   
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
            
            var form = Form.referensiKlasifikasiAset(setting.url,setting.data,setting.isEditing,'ref_klasifikasiaset_lvl3','kd_klasifikasi_aset');
            form.insert(0, pilihKlasifikasiAset);
            form.insert(1, Form.Component.referensiKlasifikasiAset('KLASIFIKASI ASET LVL 3','kd_lvl3',setting.isEditing));
            
            return form;
        }
        
        Form.referensiPartNumber = function(setting)
        {
            var formComponentPartNumber = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PART NUMBER',
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
                                        xtype:'hidden',
                                        name:'id'
                                    },
                                    {
                                        xtype:'hidden',
                                        name:'vendor_id',
                                        value: null
                                    },
                                                                        {
                                        fieldLabel:'Nama',
                                        name: 'nama',
                                    },
                                    {
                                        fieldLabel:'Part Number',
                                        name: 'part_number',
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Part Number Substitusi',
                                        name: 'part_number_substitusi',
                                       
                                    },
                                    {
                                        fieldLabel:'Kode Barang',
                                        name: 'kd_brg',
                                       
                                    },
                                    {
                                        fieldLabel:'Merek',
                                        name: 'merek',
                                    },
                                    {
                                        fieldLabel:'Jenis',
                                        name: 'jenis', 
                                        xtype:'combo',
                                        allowBlank: true,
                                        store: Reference.Data.jenisReferensiPart,
                                        valueField: 'jenis',
                                        displayField: 'jenis', emptyText: 'Pilih Jenis',
                                        editable:false,
                                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',
                                        
                                    },
                                    {
                                        xtype:'numberfield',
                                        fieldLabel:'Umur Maksimum (Jam)',
                                        name: 'umur_maks',
                                    },
                                   ]
                        }]
                }];
            
            var form = Form.panelReferensiPartNumber(setting.url,setting.data,setting.isEditing);
            form.insert(1, formComponentPartNumber);
            
            return form;
        }
        
        Form.referensiUnitKerja = function(setting)
        {
            var formComponentUnitKerja = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'UNIT KERJA',
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
                                        fieldLabel:'Kode PEBIN',
                                        name: 'kd_pebin',
                                        maxLength: 9,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Kode PBI',
                                        name: 'kd_pbi',
                                        maxLength: 6,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Kode PPBI',
                                        name: 'kd_ppbi',
                                        maxLength: 12,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Kode UPB',
                                        name: 'kd_upb',
                                        maxLength: 18,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Kode Sub UPB',
                                        name: 'kd_subupb',
                                        maxLength: 9,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Kode JK',
                                        name: 'kd_jk',
                                        maxLength: 6,
                                        allowBlank:false,
                                        readOnly:setting.isEditing
                                    },
                                    {
                                        fieldLabel:'Nama',
                                        name: 'ur_upb',
                                        maxLength: 300,
                                        allowBlank:false
                                    },
                                   ]
                        }]
                }];
            
            var form = Form.panelReferensiUnitKerja(setting.url,setting.data,setting.isEditing);
            form.insert(1, formComponentUnitKerja);
            
            return form;
        }
        
        Form.referensiUnitOrganisasi = function(setting)
        {
            var formComponentUnitOrganisasi = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'UNIT ORGANISASI',
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
                                        xtype:'hidden',
                                        name:'ID_Unor'
                                    },
                                    {
                                        xtype:'hidden',
                                        name: 'kd_lokasi',
                                        id: 'kd_lokasi',
                                        listeners: {
                                            change: function(ob, value) {
        //                                        if (edit)
        //                                        {
                                                    var comboUnker = Ext.getCmp('combo_nama_unker');
                                                    if (comboUnker !== null)
                                                    {
                                                        comboUnker.setValue(value);
                                                    }
        //                                        }
                                            }
                                        }
                                    },
//                                    {
//                                        xtype:'numberfield',
//                                        fieldLabel:'No Urut',
//                                        name: 'urut_unor',
//                                    },
                                    {
                                        xtype:'combo',
                                        fieldLabel: 'Unit Kerja *',
                                        name: 'combo_nama_unker',
                                        id: 'combo_nama_unker',
                                        itemId: 'unker',
                                        allowBlank: true,
                                        readOnly:setting.isEditing,
                                        store: Reference.Data.unker,
                                        valueField: 'kdlok',
                                        displayField: 'ur_upb', emptyText: 'Pilih Unit Kerja',
                                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                        listeners: {
                                            'focus': {
                                                fn: function(comboField) {
                                                    if(setting.isEditing != true)
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
                                                        var kodeUnkerField = Ext.getCmp('kd_lokasi');
                                                        if (kodeUnkerField !== null) {
                                                            if (value.length > 0) {
                                                                kodeUnkerField.setValue(value);
                                                            }
                                                        }
                                                    }

                                                },
                                                scope: this
                                            }
                                        }
                                    },
                                    {
                                        xtype:'numberfield',
                                        fieldLabel:'Kode Unor',
                                        name:'kode_unor',
                                        minValue: 1,
                                        allowBlank:false,
                                        readOnly:setting.isEditing,
                                    },
                                    {
                                        fieldLabel:'Nama Unit Organisasi',
                                        name: 'nama_unor',
                                        allowBlank:false,
                                    },
                                   ]
                        }]
                }];
            
            var form = Form.panelReferensiUnitOrganisasi(setting.url,setting.data,setting.isEditing);
            form.insert(1, formComponentUnitOrganisasi);
            
            return form;
        }
        
        Form.referensiWarehouse = function(setting)
        {
            var form = Form.process(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, Form.Component.unitUnkerOnly(setting.isEditing,form));
            form.insert(1, Form.Component.referensiWarehouseRuangRak('WAREHOUSE'));
            
            return form;
        }
        
        Form.referensiRuang = function(setting)
        {
            var pilihWarehouse = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'WAREHOUSE',
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
                                    fieldLabel: 'Pilih Warehouse *',
                                    name: 'warehouse_id',
                                    allowBlank: false,
                                    store: Reference.Data.warehouse,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Warehouse',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                   
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
                
            var form = Form.process(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, pilihWarehouse);
            form.insert(1, Form.Component.referensiWarehouseRuangRak('RUANG'));
            
            return form;
        }
        
        Form.referensiRak = function(setting)
        {
            var pilihWarehouse = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'RUANG',
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
                                    fieldLabel: 'Pilih Warehouse *',
                                    name: 'warehouse_id',
                                    id:'referensi_warehouse_combo',
                                    allowBlank: false,
                                    store: Reference.Data.warehouse,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Warehouse',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                   Reference.Data.warehouseRuang.changeParams({params: {id_open: 1, warehouse_id: value}});
                                                   var comboRuang = Ext.getCmp('referensi_warehouse_ruang_combo');
                                                   comboRuang.setDisabled(false);
                                                   
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    readOnly:setting.isEditing,
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Pilih Ruang *',
                                    name: 'warehouseruang_id',
                                    id:'referensi_warehouse_ruang_combo',
                                    allowBlank: false,
                                    store: Reference.Data.warehouseRuang,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Ruang',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null || value !== '')
                                                {
                                                   
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                
                            ]
                        }]
                }];
                
            var form = Form.process(setting.url,setting.data,setting.isEditing,setting.addBtn);
            form.insert(0, pilihWarehouse);
            form.insert(1, Form.Component.referensiWarehouseRuangRak('RAK'));
            
            return form;
        }
        
        Form.secondaryWindowAssetInventoryPenyimpanan= function(data,operationType,storeIndex) {
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
                                    var gridStoreRecords = Ext.getCmp('grid_inventory_penyimpanan_parts').getStore().getRange();
                                    var count_of_invalid_values = parseInt(0);
                                    Ext.Array.each(gridStoreRecords,function(key,index,self)
                                    {
                                        if(gridStoreRecords[index].data.id_warehouse == '' || gridStoreRecords[index].data.id_warehouse_ruang == '')
                                        {
                                            count_of_invalid_values++;
                                        }
                                    });
                                    Ext.getCmp('inventory_penyimpanan_grid_invalid_data').setValue(count_of_invalid_values);
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
        
        Form.panelInventory = function(url, data, edit, dataStoreParts) {
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
                                        var gridStore = dataStoreParts;
                                        var new_records = gridStore.getNewRecords();
//                                        var updated_records = grid.getUpdatedRecords();
//                                        var removed_records = grid.getRemovedRecords();
                                        Ext.each(new_records, function(obj){
                                            var index = gridStore.indexOf(obj);
                                            var record = gridStore.getAt(index);
                                            record.set('id_source',id);
                                        });
                                            gridStore.sync();
                   
                                        
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
        
        
        Form.panelInventoryPengeluaran = function(url, data, edit, dataStoreParts) {
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
                                var list_data = dataStoreParts.getRange();
                                var data_to_check = [];
                                Ext.Array.each(list_data,function(key,index,self){
                                    if(list_data[index].phantom == true || list_data[index].dirty == true)
                                    {
                                        data_to_check.push(list_data[index].data);
                                    }
                                });
                                //checks the real quantity from the server to minimize dirty read
                                //NOT YET FINISHED
                                var flag_quantity = true;
//                                $.ajax({
//                                    url:BASE_URL + 'inventory_penyimpanan/checkServerQuantity',
//                                    type: "POST",
//                                    dataType:'json',
//                                    async:false,
//                                    data:{data:data_to_check},
//                                    success:function(response, status){
//                                        flag_quantity = true;
//
//                                    }
//                                 });
                                if(flag_quantity == true)
                                {
                                    form.submit({
                                        success: function(form,action) {
                                            var id = action.result.id;
                                            var gridStore = dataStoreParts;
                                            var new_records = gridStore.getNewRecords();
    //                                        var updated_records = grid.getUpdatedRecords();
    //                                        var removed_records = grid.getRemovedRecords();
                                            Ext.each(new_records, function(obj){
                                                var index = gridStore.indexOf(obj);
                                                var record = gridStore.getAt(index);
                                                record.set('id_source',id);
                                            });
                                                gridStore.sync();


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
                                else
                                {
                                    Ext.MessageBox.alert('Fail', 'Terdapat kesalahan pada qty. Harap melakukan perbaikan');
                                }
                                
                            }
                            
                        }
                    },]
            });


            return _form;
        };
        
        Form.panelPemeliharaanParts = function(url, data, edit, dataStoreParts, addBtn) {
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
                                var list_data = dataStoreParts.getRange();
                                var data_to_check = [];
                                Ext.Array.each(list_data,function(key,index,self){
                                    if(list_data[index].phantom == true || list_data[index].dirty == true)
                                    {
                                        data_to_check.push(list_data[index].data);
                                    }
                                });
                                //checks the real quantity from the server to minimize dirty read
                                //NOT YET FINISHED
                                var flag_quantity = true;
//                                $.ajax({
//                                    url:BASE_URL + 'inventory_penyimpanan/checkServerQuantity',
//                                    type: "POST",
//                                    dataType:'json',
//                                    async:false,
//                                    data:{data:data_to_check},
//                                    success:function(response, status){
//                                        flag_quantity = true;
//
//                                    }
//                                 });
                                if(flag_quantity == true)
                                {
                                    form.submit({
                                        success: function(form,action) {
                                            
                                            var id = action.result.id;
                                            var gridStore = dataStoreParts;
                                            var new_records = gridStore.getNewRecords();
    //                                        var updated_records = grid.getUpdatedRecords();
    //                                        var removed_records = grid.getRemovedRecords();
                                            Ext.each(new_records, function(obj){
                                                var index = gridStore.indexOf(obj);
                                                var record = gridStore.getAt(index);
                                                record.set('id_pemeliharaan',id);
                                            });
                                            debugger;
                                                gridStore.sync();


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
                                else
                                {
                                    Ext.MessageBox.alert('Fail', 'Terdapat kesalahan pada qty. Harap melakukan perbaikan');
                                }
                                
                            }
                            
                        }
                    }, {
                        text: addBtn.text, iconCls: 'icon-add', hidden: addBtn.isHidden,
                        handler: addBtn.fn
                    }]
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
//                                console.log(form.getValues());
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
                                            var ref_combo_warehouse = Ext.getCmp('referensi_warehouse_combo');
                                            var ref_combo_warehouse_ruang = Ext.getCmp('referensi_warehouse_ruang_combo');
//                                            if(ref_combo_warehouse !=null)
//                                            {
//                                                ref_combo_warehouse.setValue('');
//                                            }
                                            if(ref_combo_warehouse_ruang != null)
                                            {
                                                ref_combo_warehouse_ruang.setValue('');
                                                ref_combo_warehouse_ruang.setDisabled(true);
                                            }
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
        
        Form.processPengadaanInPerlengkapan = function(url, data, edit, addBtn) {
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
//                                console.log(form.getValues());
                                form.submit({
                                    success: function(form) {
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        



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
        
        Form.panelPengadaan = function(url, data, edit, addBtn) {
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
//                                console.log(form.getValues());
                                form.submit({
                                    success: function(form, action) {
                                        var id = action.result.id;
                                        var kd_lokasi = '';
                                        $.ajax({
                                                url:BASE_URL + 'pengadaan/getByID',
                                                type: "POST",
                                                dataType:'json',
                                                async:false,
                                                data:{id_pengadaan:id},
                                                success:function(response, status){
                                                 
                                                     kd_lokasi = response.data[0].kd_lokasi;
                                                 

                                                }
                                             });
                                        var gridStore = Ext.getCmp('grid_pengadaan_parts').getStore();
                                        var new_records = gridStore.getNewRecords();
//                                        var updated_records = grid.getUpdatedRecords();
//                                        var removed_records = grid.getRemovedRecords();
                                        Ext.each(new_records, function(obj){
                                            var index = gridStore.indexOf(obj);
                                            var record = gridStore.getAt(index);
                                            record.set('id_source',id);
                                            record.set('kd_lokasi',kd_lokasi);
                                        });
                                            gridStore.sync();
                     
                                        
                                        Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                        if (data !== null)
                                        {
                                            data.load();
                                        }
                                        Modal.closeProcessWindow();



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
        
         Form.panelPendayagunaan = function(url, data, edit, addBtn) {
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
                        text: 'Simpan', id: 'save', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var documentField = form.findField('document');

                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Ext.getCmp('fileupload_pendayagunaan').getStore(); 
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
//                            console.log(form.getValues());
                            
                            if (form.isValid())
                            {
//                                console.log(form.getValues());
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
        
        Form.panelPeraturan = function(url, data, edit, addBtn) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-peraturan',
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
                        text: 'Simpan', id: 'save', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var documentField = form.findField('document');

                            
                            if (documentField !== null)
                            {
                                var arrayDoc = [];
                                
                                var documentStore = Ext.getCmp('fileupload_peraturan').getStore(); 
                                
                                _.each(documentStore.data.items, function(obj) {
                                    arrayDoc.push(obj.data.name);
                                });
                                
                                documentField.setRawValue(arrayDoc.join());
                            }
                            
//                            console.log(form.getValues());
                            
                            if (form.isValid())
                            {
//                                console.log(form.getValues());
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
        
        Form.panelReferensiUnitKerja = function(url, data, edit) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-referensiUnitKerja',
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
                        text: 'Simpan', id: 'save_referensiKlasifikasiAset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var formValues = form.getValues(); 
                            var pk_check = false;
                            var kd_lokasi = formValues.kd_pebin + formValues.kd_pbi + formValues.kd_ppbi + formValues.kd_upb + formValues.kd_subupb + formValues.kd_jk;
//                            debugger;
                            $.ajax({
                                url:BASE_URL + 'master_data/checkUnitKerja',
                                type: "POST",
                                dataType:'json',
                                async:false,
                                data:{kd_lokasi:kd_lokasi, edit:edit},
                                success:function(response, status){
                                if(response == true)
                                {
                                    pk_check = true;
                                }
                                else
                                {
                                    pk_check = false;
                                }

                                }
                             });
                            if(pk_check == true)
                            {
                                if (form.isValid())
                                {
    //                                console.log(form.getValues());
                                    form.submit({
                                        success: function(form) {
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            
                                            if (data !== null)
                                            {
                                                data.load();
                                            }
                                            if(!edit)
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
                            else
                            {
                                Ext.MessageBox.alert('Fail', 'Kombinasi Kode Sudah Digunakan!');
                            }

                            
                        }
                    }]
            });


            return _form;
        };
        
         Form.panelReferensiUnitOrganisasi = function(url, data, edit) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-referensiUnitKerja',
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
                        text: 'Simpan', id: 'save_referensiKlasifikasiAset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var formValues = form.getValues(); 
                            var kode_unor = formValues.kode_unor;
                            var pk_check = false;
                            $.ajax({
                                url:BASE_URL + 'master_data/checkKodeUnitOrganisasi',
                                type: "POST",
                                dataType:'json',
                                async:false,
                                data:{kode_unor:kode_unor, edit:edit},
                                success:function(response, status){
                                if(response == true)
                                {
                                    pk_check = true;
                                }
                                else
                                {
                                    pk_check = false;
                                }

                                }
                             });
                            if(pk_check == true)
                            {
                                if (form.isValid())
                                {
    //                                console.log(form.getValues());
                                    form.submit({
                                        success: function(form) {
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            
                                            if (data !== null)
                                            {
                                                data.load();
                                            }
                                            if(!edit)
                                            {
                                                form.reset();
                                                form.setValues({kode_unor:parseInt(formValues.kode_unor) + 1});
                                            }
    
    
                                        },
                                        failure: function() {
                                            Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                        }
                                    });
                                }
                            }
                            else
                            {
                                Ext.MessageBox.alert('Fail', 'Kode Unor Sudah Digunakan!');
                            }


                            
                        }
                    }]
            });


            return _form;
        };
        
        Form.panelReferensiPartNumber = function(url, data, edit) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-referenPartNumber',
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
                        text: 'Simpan', id: 'save_referensiKlasifikasiAset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var formValues = form.getValues(); 
                            var part_number = formValues.part_number;
                            var pk_check = false;
                            $.ajax({
                                url:BASE_URL + 'master_data/checkPartNumber',
                                type: "POST",
                                dataType:'json',
                                async:false,
                                data:{part_number:part_number, edit:edit},
                                success:function(response, status){
                                if(response == true)
                                {
                                    pk_check = true;
                                }
                                else
                                {
                                    pk_check = false;
                                }

                                }
                             });
                            if(pk_check == true)
                            {
                                if (form.isValid())
                                {
    //                                console.log(form.getValues());
                                    form.submit({
                                        success: function(form) {
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            
                                            if (data !== null)
                                            {
                                                data.load();
                                            }
                                            if(!edit)
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
                            else
                            {
                                Ext.MessageBox.alert('Fail', 'Kode Part Number Sudah Digunakan!');
                            }

                            
                        }
                    }]
            });


            return _form;
        };
        
        Form.referensiKlasifikasiAset = function(url, data, edit, table_name, key) {
            var _form = Ext.create('Ext.form.Panel', {
                id : 'form-referensiKlasifikasiAset',
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
                        text: 'Simpan', id: 'save_referensiKlasifikasiAset', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            var formValues = form.getValues(); 
                            var pk_check = false;
                            if(formValues.kd_lvl1 != undefined)
                            {
                                formValues.key = formValues.kd_lvl1;
                                if(formValues.kd_lvl2 != undefined)
                                {
                                    formValues.key += formValues.kd_lvl2;
                                    if(formValues.kd_lvl3 != undefined)
                                    {
                                         formValues.key += formValues.kd_lvl3;
                                    }

                                }
                            }
                            
//                            debugger;
                            $.ajax({
                                url:BASE_URL + 'master_data/checkKdKlasifikasiAset',
                                type: "POST",
                                dataType:'json',
                                async:false,
                                data:{table_name:table_name, key:key, value:formValues, edit:edit},
                                success:function(response, status){
                                if(response == true)
                                {
                                    pk_check = true;
                                }
                                else
                                {
                                    pk_check = false;
                                }

                                }
                             });
                            if(pk_check == true)
                            {
                                if (form.isValid())
                                {
    //                                console.log(form.getValues());
                                    form.submit({
                                        success: function(form) {
                                            Ext.MessageBox.alert('Success', 'Changes saved successfully.');
                                            
                                            if (data !== null)
                                            {
                                                data.load();
                                            }
                                            if(!edit)
                                            {
                                                var combo_ref_klasifikasi_lvl2 = Ext.getCmp('referensi_klasifikasi_aset_lvl2');
                                                var combo_ref_klasifikasi_lvl1 = Ext.getCmp('referensi_klasifikasi_aset_lvl1');
                                                if(combo_ref_klasifikasi_lvl1 != null)
                                                {
                                                    combo_ref_klasifikasi_lvl1.setValue('');
                                                }
                                                if(combo_ref_klasifikasi_lvl2 != null)
                                                {
                                                    combo_ref_klasifikasi_lvl2.setValue('');
                                                    combo_ref_klasifikasi_lvl2.setDisabled(true);
                                                }
                                                form.reset();
                                            }
    
    
                                        },
                                        failure: function() {
                                            Ext.MessageBox.alert('Fail', 'Changes saved fail.');
                                        }
                                    });
                                }
                            }
                            else
                            {
                                Ext.MessageBox.alert('Fail', 'Kode Sudah Digunakan!');
                            }

                            
                        }
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

                                        
                                            Modal.closeAssetWindow();
                                        
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

//                                        if (!edit)
//                                        {
//                                            Modal.closeAssetWindow();
//                                        }
                                            Modal.closeAssetWindow();
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
        
        Form.assetNoButton = function(url, data, edit, hasTabs) {
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
        
        
        Form.detailPenggunaanAngkutanUdara = function(url, data, edit,mesin) {
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
                                                url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaanAngkutanUdara/',
                                                type: "POST",
                                                dataType:'json',
                                                async:false,
                                                data:{tipe_angkutan:'udara',id_ext_asset:id_ext_asset},
                                                success:function(response, status){
                                                 if(response.status == 'success')
                                                 {
                                                        var updateTotalPenggunaanMesin1 = response.total_mesin1 + ' Jam';
                                                        var updateTotalPenggunaanMesin2 = response.total_mesin2 + ' Jam';
                                                        
                                                            Ext.getCmp('total_detail_penggunaan_angkutan_udara_mesin1').setValue(updateTotalPenggunaanMesin1);
                                                            Ext.getCmp('total_detail_penggunaan_angkutan_udara_mesin2').setValue(updateTotalPenggunaanMesin2);
                                                        
                                                        
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
//                                var form_values = form.getValues();
//                                data.add(form_values);
//                                Modal.assetSecondaryWindow.close();
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

        Form.Component.unit = function(edit,form,isReadOnly,isUnorReadOnly) {
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
                                allowBlank: false,
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
        
        
        Form.Component.unitUnkerOnly = function(edit,form,isReadOnly) {
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
                                            if (comboUnker !== null)
                                            {
                                                comboUnker.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .99,
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
                                                var kodeUnkerField = Ext.getCmp('kd_lokasi');
                                                if (kodeUnkerField !== null) {
                                                    if (value.length > 0) {
                                                        kodeUnkerField.setValue(value);
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
                    },]
            };


            return component;
        };
        
        /*
         * @param {string} database_field = the field fileupload field name in database
         * @param {string} id_fileupload = unique id for fileupload grid     
         */
        Form.Component.fileUploadSingleDocumentOnly= function(database_field,id_fileupload)
        {
          
            var documentStore = new Ext.create('Ext.data.Store', {
                                        fields: ['url', 'name'],
                                        listeners:{
                                            datachanged : function(){
                                                var count = this.count();
                                                if(count == 1)
                                                {
                                                    Ext.getCmp('add_'+id_fileupload).setDisabled(true);
                                                }
                                                else
                                                {
                                                    Ext.getCmp('add_'+id_fileupload).setDisabled(false);
                                                }
                                            }
                                        }
                                    });
            
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
                                listeners: {
                                    itemdblclick: function(dataview, record, item, index, e) {
//                                        Ext.getCmp(setting.toolbar.edit.id).handler.call(Ext.getCmp(setting.toolbar.edit.id).scope);
                                    }
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
                                id:'add_' + id_fileupload,
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
//                                        if (edit)
//                                        {
                                            var comboGolongan = Ext.getCmp('nama_golongan');
                                            if (comboGolongan !== null)
                                            {
                                                comboGolongan.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kd_bid',
                                id: 'kd_bid',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboBidang = Ext.getCmp('nama_bidang');
                                            if (comboBidang !== null)
                                            {
                                                comboBidang.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kd_kelompok',
                                id: 'kd_kelompok',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboKelompok = Ext.getCmp('nama_kelompok');
                                            if (comboKelompok !== null)
                                            {
                                                comboKelompok.setValue(value);
                                            }
//                                        }
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
                                        fieldLabel:'Provinsi',
                                        name: 'kd_prov', 
                                        xtype:'combo',
                                        allowBlank: true,
                                        store: Reference.Data.provinsi,
                                        valueField: 'kode_prov',
                                        displayField: 'nama_prov', emptyText: 'Pilih Provinsi',
                                        editable:false,
                                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Provinsi',
                                        listeners:{
                                            'change':
                                            {
                                                fn:function(obj,value)
                                                {
                                                    Reference.Data.kabupaten.changeParams({params:{kode_prov:value,id_open:1}});
                                                }
                                            }
                                        }
                                    },
                                    {
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
                                        fieldLabel:'Kabupaten',
                                        name: 'kd_kab', 
                                        xtype:'combo',
                                        allowBlank: true,
                                        store: Reference.Data.kabupaten,
                                        valueField: 'kode_kabkota',
                                        displayField: 'nama_kabkota', emptyText: 'Pilih Kabupaten',
                                        editable:false,
                                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Kabupaten',
                                        
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
        
        
        Form.Component.mechanicalAngkutanUdara = function() {
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
                                fieldLabel: 'No Mesin 1',
                                name: 'no_mesin'
                            },{
                                fieldLabel: 'No Mesin 2',
                                name: 'udara_no_mesin2'
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
                            },{
                                xtype:'numberfield',
                                fieldLabel: 'Inisialisasi Mesin 1',
                                name: 'udara_inisialisasi_mesin1',
                                value:0,
                                minValue:0,
                            },{
                                xtype:'numberfield',
                                fieldLabel: 'Inisialisasi Mesin 2',
                                name: 'udara_inisialisasi_mesin2',
                                value:0,
                                minValue:0
                            }, ]
                    }, {
                        columnWidth: .34,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'No Rangka',
                                name: 'no_rangka'
                            },{
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
                                editable:false,
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
                                xtype: 'combo',
                                fieldLabel: 'Part Number Asset Perlengkapan',
                                name: 'id_asset_perlengkapan',
                                anchor: '100%',
                                allowBlank: true,
                                store: Reference.Data.assetPerlengkapanPart,
                                valueField: 'id',
                                editable:false,
                                displayField: 'part_number', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            var serial_number = obj.valueModels[0].data.serial_number;
                                           Ext.getCmp('angkutan_darat_asset_perlengkapan_part').setValue(serial_number);
                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                xtype:'textfield',
                                fieldLabel:'Serial Number Asset Perlengkapan',
                                name:'serial_number',
                                id:'angkutan_darat_asset_perlengkapan_part',
                                readOnly:true,
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
                                xtype: 'combo',
                                fieldLabel: 'Part Number Asset Perlengkapan',
                                name: 'id_asset_perlengkapan',
                                anchor: '100%',
                                allowBlank: true,
                                store: Reference.Data.assetPerlengkapanPart,
                                valueField: 'id',
                                editable:false,
                                displayField: 'part_number', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            var serial_number = obj.valueModels[0].data.serial_number;
                                           Ext.getCmp('angkutan_laut_asset_perlengkapan_part').setValue(serial_number);
                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                xtype:'textfield',
                                fieldLabel:'Serial Number Asset Perlengkapan',
                                name:'serial_number',
                                id:'angkutan_laut_asset_perlengkapan_part',
                                readOnly:true,
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
        
        Form.Component.dataPerlengkapanAngkutanUdara = function (id_ext_asset,readOnly)
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
                                readOnly:(readOnly == true)?true:false,
                                store: Reference.Data.jenisPerlengkapanAngkutanUdara,
                                valueField: 'value',
                                displayField: 'value', emptyText: 'Pilih Jenis',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Jenis',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                            if(value == "Part Pesawat")
                                            {
                                                Ext.getCmp('angkutan_udara_asset_perlengkapan_part').setDisabled(false);
                                                Ext.getCmp('angkutan_udara_asset_perlengkapan_serial_number').setDisabled(false);
                                                Ext.getCmp('perlengkapan_angkutan_udara_keterangan').setDisabled(true);
                                            }
                                            else
                                            {
                                                Ext.getCmp('angkutan_udara_asset_perlengkapan_part').setDisabled(true);
                                                Ext.getCmp('angkutan_udara_asset_perlengkapan_serial_number').setDisabled(true);
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
                                xtype: 'combo',
                                id:'angkutan_udara_asset_perlengkapan_part',
                                fieldLabel: 'Part Number Asset Perlengkapan',
                                name: 'id_asset_perlengkapan',
                                anchor: '100%',
                                allowBlank: true,
                                readOnly:(readOnly == true)?true:false,
                                store: Reference.Data.assetPerlengkapanPart,
                                valueField: 'id',
                                editable:false,
                                displayField: 'part_number', emptyText: 'Pilih Part',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih part',
                                listeners: {
                                    'change': {
                                        fn: function(obj, value) {
                                           
                                            if(readOnly == true)
                                            {
                                                Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 2}});
                                            }
                                            else
                                            {
                                                
                                                var serial_number = obj.valueModels[0].data.serial_number;
                                                Ext.getCmp('angkutan_udara_asset_perlengkapan_serial_number').setValue(serial_number);
                                            }
                                            
                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                disabled:true,
                                xtype:'textfield',
                                fieldLabel:'Serial Number Asset Perlengkapan',
                                name:'serial_number',
                                id:'angkutan_udara_asset_perlengkapan_serial_number',
                                readOnly:true,
                            },]
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
        
       
        
        Form.Component.gridParts = function(setting,isInventoryPengeluaran) {
    

            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: 325,
                anchor: '100%',
                title: 'PARTS',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [{xtype:'container',height:300,items:[Grid.parts(setting,false,isInventoryPengeluaran)]}]
            };

            return component;
        };
        
         Form.Component.gridPartsInventoryPenyimpanan = function(setting) {
            
            Ext.apply(Ext.form.field.VTypes, {
                ZeroOnly:  function(v) {
                    return /0$/.test(v);
                },
                ZeroOnlyText: 'Terdapat kesalahan pada data di grid',
                ZeroOnlyMask: ''
            });
    

            var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: 350,
                anchor: '100%',
                title: 'PARTS',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [{xtype:'textfield', readOnly:true, vtype:'ZeroOnly', labelWidth:240, id:'inventory_penyimpanan_grid_invalid_data', fieldLabel:'Jumlah data pada grid yang harus diperbaiki', name:'invalid_grid_field_count',value:0},{xtype:'container',height:300,items:[Grid.parts(setting,true,false)]}]
            };

            return component;
        };
        
        Form.Component.gridPemeliharaanPart = function(setting,edit) {
//            var component = {
//                xtype: 'fieldset',
//                layout:'anchor',
//                height: (edit == true)?325:150,
//                anchor: '100%',
//                title: 'PEMELIHARAAN PART',
//                border: false,
//                frame: true,
//                defaultType: 'container',
//                items: [(edit==true)?{xtype:'container',height:300,items:[Grid.pemeliharaanPart(setting)]}:{xtype:'label',text:'Harap Simpan Data Terlebih Dahulu Untuk Mengisi Bagian Ini'}]
//            };
//
//            return component;
            
             var component = {
                xtype: 'fieldset',
                layout:'anchor',
                height: 325,
                anchor: '100%',
                title: 'PEMELIHARAAN PART',
                border: false,
                frame: true,
                defaultType: 'container',
                items: [{xtype:'container',height:300,items:[Grid.pemeliharaanPart(setting)]}]
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
        
        Form.Component.referensiWarehouseRuangRak = function(title) {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: title,
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
                        defaultType: 'textfield',
                        items: [{
                                xtype:'hidden',
                                name:'id'
                            },
                            {
                                fieldLabel: 'Nama',
                                name: 'nama',
                                allowBlank:false,
                            }]
                    }]
            };

            return component;
        };
        
         Form.Component.referensiKlasifikasiAset = function(title,field_kd_klasifikasi_aset,edit) {
            var component = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: title,
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
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kode Klasifikasi Aset',
                                name: field_kd_klasifikasi_aset,
                                allowBlank:false,
                                maxLength:10,
                                readOnly:edit
                            },
                            {
                                fieldLabel: 'Nama',
                                name: 'nama',
                                allowBlank:false,
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
                            items: [
//                                    {
//                                        xtype:'hidden',
//                                        name:'id',
//                                    },
                                {
                                    fieldLabel: 'No SPPA *',
                                    name: 'no_sppa',
                                    allowBlank:false,
                                },
                                {
                                    fieldLabel: 'Asal Pengadaan',
                                    name: 'asal_pengadaan'
                                },
                                {
                                    xtype:'textarea',
                                    fieldLabel: 'Deskripsi',
                                    name: 'deskripsi'
                                },
                                {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'tahun_angaran',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: '',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                                }, {
                                    fieldLabel: 'Sumber',
                                    name: 'perolehan_sumber'
                                }, {
                                    fieldLabel: 'Nama Vendor',
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
                                    fieldLabel: 'Tanggal Kuitansi',
                                    name: 'kuitansi_tanggal',
                                    format: 'Y-m-d'
                                },]
                        }, {
                            columnWidth: .33,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%'
                            },
                            defaultType: 'textfield',
                            items: [  {
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
                                    xtype:'textarea',
                                    fieldLabel: 'Pelihara Ket.',
                                    name: 'pelihara_keterangan'
                                }, {
                                    fieldLabel: 'Data Kontrak',
                                    name: 'data_kontrak'
                                },
                                {
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
                                anchor: '100%'
                            },
                            defaultType: 'textfield',
                            items: [ {
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
                                    xtype:'textarea',
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
                                { xtype : 'hidden', name: 'no_aset'},
                                { xtype : 'hidden', name: 'nama'}
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
                                    xtype:'textarea',
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
                            items: [
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
                                    listeners: {
                                        change: function(obj, value) {
//                                           var selWaktu = Ext.getCmp('unit_waktu').value;
//                                           var selPengunaan = Ext.getCmp('unit_pengunaan').value;
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
                                            
//                                            if(selWaktu != 0 && selWaktu != null)
//                                            {
//                                                pilihUnit.setValue(1);
//                                            }
//                                            else if(selPengunaan != 0 && selPengunaan != null)
//                                            {
//                                                 pilihUnit.setValue(2);
//                                            }
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
                                    fieldLabel: 'Tahun Anggaran',
                                    name: 'tahun_angaran',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: '',
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
                                            width:300,
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
                                    xtype:'textarea',
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
                                    xtype:'textfield',
                                    fieldLabel: 'Nama',
                                    name:'nama'
                                    
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
                                }, {
                                    fieldLabel: 'Satuan',
                                    name: 'satuan'
                                },]
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
                                    allowBlank:false,
                                }, {
                                    fieldLabel: 'PIC',
                                    name: 'pic',
                                    allowBlank:false,
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Mulai',
                                    name: 'tanggal_mulai',
                                    format : 'Y-m-d',
                                    allowBlank:false,
                                }, {
                                    xtype: 'datefield',
                                    fieldLabel: 'Tanggal Selesai',
                                    name: 'tanggal_selesai',
                                    format : 'Y-m-d',
                                    allowBlank:false,
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
                                            if(value != 0 && value != null)
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
                                            if(value != 0 && value != null)
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
                                    editable:false,
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
                                                        
                                                            fieldPartNumber.setValue(value);
                                                        
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
                                    name: 'serial_number',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {

                                                if (value !== null && value != '')
                                                {
                                                    var qtyField = Ext.getCmp('asset_perlengkapan_qty');
                                                    qtyField.setValue(1);
                                                    qtyField.setReadOnly(true);
                                                }
                                                else
                                                {
                                                    var qtyField = Ext.getCmp('asset_perlengkapan_qty');
                                                    qtyField.setReadOnly(false);
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
//                                {
//                                    fieldLabel: 'Kode Barang',
//                                    name: 'kd_brg'
//                                },
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
                                    id:'asset_perlengkapan_qty',
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
        
        
         Form.Component.dataInventoryPerlengkapanWithWarehouse = function(readOnly) {

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
                            items: [{
                                xtype:'hidden',
                                name: 'id_warehouse',
                                id: 'inventory_perlengkapan_id_warehouse',
                                listeners: {
                                    change: function(obj, value) {

                                            var comboWarehouse = Ext.getCmp('combo_inventory_perlengkapan_id_warehouse');
                                            if (comboWarehouse !== null)
                                            {
                                                comboWarehouse.setValue(value);
                                            }

                                    }
                                }
                            }, {
                                xtype:'hidden',
                                name: 'id_warehouse_ruang',
                                id: 'inventory_perlengkapan_id_warehouse_ruang',
                                listeners: {
                                    change: function(obj, value) {

                                            var comboWarehouseRuang = Ext.getCmp('combo_inventory_perlengkapan_id_warehouse_ruang');
                                            if (comboWarehouseRuang !== null)
                                            {
                                                comboWarehouseRuang.setValue(value);
                                            }
                                        
                                    }
                                }
                            }, {
                                xtype:'hidden',
                                name: 'id_warehouse_rak',
                                id: 'inventory_perlengkapan_id_warehouse_rak',
                                listeners: {
                                    change: function(obj, value) {

                                            var comboWarehouseRak = Ext.getCmp('combo_inventory_perlengkapan_id_warehouse_rak');
                                            if (comboWarehouseRak !== null)
                                            {
                                                comboWarehouseRak.setValue(value);
                                            }
                                        
                                    }
                                }
                            },
                            {
                                xtype:'hidden',
                                name: 'nama_warehouse',
                                id: 'inventory_perlengkapan_nama_warehouse',
                            },
                            {
                                xtype:'hidden',
                                name: 'nama_ruang',
                                id: 'inventory_perlengkapan_nama_warehouse_ruang',
                            },
                            {
                                xtype:'hidden',
                                name: 'nama_rak',
                                id: 'inventory_perlengkapan_nama_warehouse_rak',
                            },
                                {
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Warehouse',
                                    name: 'combo_warehouse_id',
                                    id : 'combo_inventory_perlengkapan_id_warehouse',
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
                                                    var comboWarehouseRuang = Ext.getCmp('combo_inventory_perlengkapan_id_warehouse_ruang');
                                                    var fieldWarehouse = Ext.getCmp('inventory_perlengkapan_id_warehouse');
                                                    var fieldNamaWarehouse = Ext.getCmp('inventory_perlengkapan_nama_warehouse');
                                                    
                                                    if (comboWarehouseRuang != null && fieldWarehouse != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRuang.enable();
                                                            fieldWarehouse.setValue(value);
                                                            fieldNamaWarehouse.setValue(obj.rawValue);
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
                                    id : 'combo_inventory_perlengkapan_id_warehouse_ruang',
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
                                                    var comboWarehouseRak = Ext.getCmp('combo_inventory_perlengkapan_id_warehouse_rak');
                                                    var fieldWarehouseRuang = Ext.getCmp('inventory_perlengkapan_id_warehouse_ruang');
                                                    var fieldNamaWarehouseRuang = Ext.getCmp('inventory_perlengkapan_nama_warehouse_ruang');
                                                    if (comboWarehouseRak != null && fieldWarehouseRuang != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            comboWarehouseRak.enable();
                                                            fieldWarehouseRuang.setValue(value);
                                                            fieldNamaWarehouseRuang.setValue(obj.rawValue);
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
                                    id : 'combo_inventory_perlengkapan_id_warehouse_rak',
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
                                                    var fieldWarehouseRak = Ext.getCmp('inventory_perlengkapan_id_warehouse_rak');
                                                    var fieldNamaWarehouseRak = Ext.getCmp('inventory_perlengkapan_nama_warehouse_rak');
                                                    if (fieldWarehouseRak != null) {
                                                        if (!isNaN(value) && value.length > 0 || edit === true) {
                                                            fieldWarehouseRak.setValue(value);
                                                            fieldNamaWarehouseRak.setValue(obj.rawValue);
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
                                                    qtyField.setReadOnly(true);
                                                }
                                                else
                                                {
                                                    var qtyField = Ext.getCmp('inventory_data_perlengkapan_qty');
                                                    qtyField.setReadOnly(false);
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
//                                {
//                                    xtype:'hidden',
//                                    name: 'id',
//                                    value:'',
//                                },
//                                {
//                                    xtype:'hidden',
//                                    name: 'id_inventory',
//                                    value:'',
//                                },
                                
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
                                    readOnly:readOnly,
                                    disabled: false,
                                    fieldLabel: 'Kode Barang',
                                    name: 'kd_brg',
                                    id:'inventory_data_perlengkapan_kode_barang'
                                    },{
                                    readOnly:readOnly,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'Part *',
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
                                                    qtyField.setReadOnly(true);
                                                }
                                                else
                                                {
                                                    var qtyField = Ext.getCmp('inventory_data_perlengkapan_qty');
                                                    qtyField.setReadOnly(false);
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
//                                {
//                                    xtype:'hidden',
//                                    name: 'id',
//                                    value:'',
//                                },
//                                {
//                                    xtype:'hidden',
//                                    name: 'id_inventory',
//                                    value:'',
//                                },
                                
                            ]
                        }]
                }]

            return component;
        };
        
        Form.Component.dataInventoryPerlengkapanPengeluaran = function (readOnly){
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
                                labelWidth: 220
                            },
                            items: [{
                                        xtype:'hidden',
                                        name:'id',
                                        id:'inventory_pengeluaran_data_perlengkapan_parts_id',
                                    },
                                    {
                                        xtype:'hidden',
                                        name:'nomor_berita_acara',
                                        id:'inventory_pengeluaran_data_perlengkapan_parts_nomor_berita_acara',
                                    },
                                    {
                                    allowBlank:false,
                                    readOnly:readOnly,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara Penyimpanan *',
                                    name: 'id_penyimpanan',
                                    id:'inventory_pengeluaran_data_perlengkapan_parts_id_penyimpanan',
                                    store: Reference.Data.penyimpanan,
                                    valueField: 'id',
                                    editable:false,
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penyimpanan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {
                                               
                                                if (value !== null && value !== '')
                                                {
                                                    var excluded_id_penyimpanan_data_perlengkapan = '';
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_nomor_berita_acara').setValue(obj.rawValue);
                                                    if(readOnly != true)
                                                    {
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_combo').setValue('');
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_combo').setDisabled(true);
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setDisabled(true);
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setValue('');
                                                    var gridData = Ext.getCmp('grid_inventory_pengeluaran_parts').getStore().getRange();
                                                        Ext.Array.each(gridData,function(key,index,self){
                                                        if(gridData[index].data.id_penyimpanan == value)
                                                        {
                                                            excluded_id_penyimpanan_data_perlengkapan += gridData[index].data.id_penyimpanan_data_perlengkapan +',';
                                                        }
                                                     });
                                                    }
                                                    Reference.Data.partsInventoryPengeluaran.changeParams({params: {id_open: 1, id_penyimpanan: value, excluded_id_penyimpanan_data_perlengkapan:excluded_id_penyimpanan_data_perlengkapan.slice(0,-1)}});
                                                    Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_combo').setDisabled(false);
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    allowBlank:false,
                                    readOnly:readOnly,
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Part *',
                                    name: 'id_penyimpanan_data_perlengkapan',
                                    id:'inventory_pengeluaran_data_perlengkapan_parts_combo',
                                    store: Reference.Data.partsInventoryPengeluaran,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Part',
                                    editable:false,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {
                                                
                                                
                                              
                                                if (value !== null && value !== '')
                                                {
                                                    
                                                    if(readOnly != true)
                                                    {
                                                        Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setValue('');
                                                        Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setDisabled(true);
                                                        
                                                    }
                                                   Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_penyimpanan/getSpecificInventoryPenyimpanan',
                                                        dataType: 'JSON',
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
                                                                Ext.getCmp('inventory_data_perlengkapan_kode_barang').setValue(data.kd_brg);
                                                                Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setMaxValue(data.qty);
                                                                Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setDisabled(false);
//                                                                var gridData = Ext.getCmp('grid_inventory_pengeluaran_parts').getStore().getRange();
//                                                                debugger;
//                                                                Ext.Array.each(gridData,function(key,index,self){
//                                                                    var grid_id_penyimpanan = gridData[index].data.id_penyimpanan;
//                                                                    var grid_id_penyimpanan_data_perlengkapan = gridData[index].data.id_penyimpanan_data_perlengkapan;
//                                                                    var grid_qty_keluar = gridData[index].data.id_penyimpanan_data_perlengkapan.qty_keluar;
//                                                                    var form_current_id_penyimpanan = Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_id_penyimpanan').value;
//                                                                    var form_current_id_penyimpanan_data_perlengkapan = Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_combo').value;
//                                                                    
//                                                                    if(grid_id_penyimpanan == form_current_id_penyimpanan && grid_id_penyimpanan_data_perlengkapan == form_current_id_penyimpanan_data_perlengkapan)
//                                                                    {
//                                                                        
//                                                                    }
//                                                                    
//                                                                });
//                                                                debugger;
                                                                if(readOnly == true)
                                                                {
                                                                    var id_pengeluaran = Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_id').value;
                                                                    if(id_pengeluaran != '') //if the record has been committed to the database
                                                                    {
                                                                        Ext.getCmp('inventory_data_perlengkapan_qty').setValue(parseInt(data.qty) + parseInt(Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').value));
                                                                        Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_qty_keluar').setMaxValue(Ext.getCmp('inventory_data_perlengkapan_qty').value);
                                                                    }
                                                                    
                                                                }
                                                           
                                                            // process server response here
                                                        }
                                                        });
                                                        
                                                        
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },{
                                    xtype:'numberfield',
                                    fieldLabel:'Qty Keluar',
                                    name:'qty_keluar',
                                    id:'inventory_pengeluaran_data_perlengkapan_parts_qty_keluar',
                                    minValue:1,
                                    disabled:true,
                                    allowBlank:false,
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        
        
        Form.Component.dataPemeliharaanParts = function (readOnly){
            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PEMELIHARAAN PART',
                    border: false,
                    defaultType: 'container',
                    frame: true,
                    items: [
                       {
                            columnWidth: .99,
                            layout: 'anchor',
                            defaults: {
                                anchor: '95%',
                                labelWidth: 220
                            },
                            items: [{
                                        xtype:'hidden',
                                        name:'id',
                                        id:'pemeliharaan_parts_id',
                                    },
                                    {
                                        xtype:'hidden',
                                        name:'id_pemeliharaan',
                                        id:'pemeliharaan_parts_id_pemeliharaan',
                                    },
                                    {
                                        xtype:'hidden',
                                        name:'nama',
                                        id:'pemeliharaan_parts_nama',
                                    },
                                    {
                                    allowBlank:false,
                                    readOnly:readOnly,
                                    xtype: 'combo',
                                    disabled: false,
                                    fieldLabel: 'No Berita Acara Penyimpanan *',
                                    name: 'id_penyimpanan',
                                    id:'pemeliharaan_parts_id_penyimpanan',
                                    store: Reference.Data.penyimpanan,
                                    valueField: 'id',
                                    editable:false,
                                    displayField: 'nomor_berita_acara', emptyText: 'Pilih Penyimpanan',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {
                                               
                                                if (value !== null && value !== '')
                                                {
                                                    var excluded_id_penyimpanan_data_perlengkapan = '';
                                                    
                                                    if(readOnly != true)
                                                    {
                                                    Ext.getCmp('pemeliharaan_parts_combo').setValue('');
                                                    Ext.getCmp('pemeliharaan_parts_combo').setDisabled(true);
                                                    Ext.getCmp('pemeliharaan_parts_qty').setDisabled(true);
                                                    Ext.getCmp('pemeliharaan_parts_qty').setValue('');
                                                    var gridData = Ext.getCmp('grid_pemeliharaan_parts').getStore().getRange();
                                                        Ext.Array.each(gridData,function(key,index,self){
                                                        if(gridData[index].data.id_penyimpanan == value)
                                                        {
                                                            excluded_id_penyimpanan_data_perlengkapan += gridData[index].data.id_penyimpanan_data_perlengkapan +',';
                                                        }
                                                     });
                                                    }
                                                    Reference.Data.partsInventoryPengeluaran.changeParams({params: {id_open: 1, id_penyimpanan: value, excluded_id_penyimpanan_data_perlengkapan:excluded_id_penyimpanan_data_perlengkapan.slice(0,-1)}});
                                                    Ext.getCmp('pemeliharaan_parts_combo').setDisabled(false);
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },
                                {
                                    allowBlank:false,
                                    readOnly:readOnly,
                                    xtype: 'combo',
                                    disabled: true,
                                    fieldLabel: 'Part *',
                                    name: 'id_penyimpanan_data_perlengkapan',
                                    id:'pemeliharaan_parts_combo',
                                    store: Reference.Data.partsInventoryPengeluaran,
                                    valueField: 'id',
                                    displayField: 'nama', emptyText: 'Pilih Part',
                                    editable:false,
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: '',
                                    listeners: {
                                        'change': {
                                            fn: function(obj, value) {
                                                
                                                
                                              
                                                if (value !== null && value !== '')
                                                {
                                                    Ext.getCmp('pemeliharaan_parts_nama').setValue(obj.rawValue);
                                                    if(readOnly != true)
                                                    {
                                                        Ext.getCmp('pemeliharaan_parts_qty').setValue('');
                                                        Ext.getCmp('pemeliharaan_parts_qty').setDisabled(true);
                                                        
                                                    }
                                                   Ext.Ajax.request({
                                                        url: BASE_URL + 'inventory_penyimpanan/getSpecificInventoryPenyimpanan',
                                                        dataType: 'JSON',
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
                                                                Ext.getCmp('inventory_data_perlengkapan_kode_barang').setValue(data.kd_brg);
                                                                Ext.getCmp('pemeliharaan_parts_qty').setMaxValue(data.qty);
                                                                Ext.getCmp('pemeliharaan_parts_qty').setDisabled(false);
//                                                                var gridData = Ext.getCmp('grid_inventory_pengeluaran_parts').getStore().getRange();
//                                                                debugger;
//                                                                Ext.Array.each(gridData,function(key,index,self){
//                                                                    var grid_id_penyimpanan = gridData[index].data.id_penyimpanan;
//                                                                    var grid_id_penyimpanan_data_perlengkapan = gridData[index].data.id_penyimpanan_data_perlengkapan;
//                                                                    var grid_qty_keluar = gridData[index].data.id_penyimpanan_data_perlengkapan.qty_keluar;
//                                                                    var form_current_id_penyimpanan = Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_id_penyimpanan').value;
//                                                                    var form_current_id_penyimpanan_data_perlengkapan = Ext.getCmp('inventory_pengeluaran_data_perlengkapan_parts_combo').value;
//                                                                    
//                                                                    if(grid_id_penyimpanan == form_current_id_penyimpanan && grid_id_penyimpanan_data_perlengkapan == form_current_id_penyimpanan_data_perlengkapan)
//                                                                    {
//                                                                        
//                                                                    }
//                                                                    
//                                                                });
//                                                                debugger;
                                                                if(readOnly == true)
                                                                {
                                                                    var id_pemeliharaan_parts = Ext.getCmp('pemeliharaan_parts_id').value;
                                                                    if(id_pemeliharaan_parts != '') //if the record has been committed to the database
                                                                    {
                                                                        Ext.getCmp('inventory_data_perlengkapan_qty').setValue(parseInt(data.qty) + parseInt(Ext.getCmp('pemeliharaan_parts_qty').value));
                                                                        Ext.getCmp('pemeliharaan_parts_qty').setMaxValue(Ext.getCmp('inventory_data_perlengkapan_qty').value);
                                                                    }
                                                                    
                                                                }
                                                           
                                                            // process server response here
                                                        }
                                                        });
                                                        
                                                        
                                                }

                                            },
                                            scope: this
                                        }
                                    }
                                },{
                                    xtype:'numberfield',
                                    fieldLabel:'Qty Pemeliharaan',
                                    name:'qty_pemeliharaan',
                                    id:'pemeliharaan_parts_qty',
                                    minValue:1,
                                    disabled:true,
                                    allowBlank:false,
                                }
                                
                            ]
                        }]
                }]

            return component;
        };
        
        
        Form.Component.inventoryPenerimaanPemeriksaan = function(edit) {

            var component = [{
                    xtype: 'fieldset',
                    layout: 'column',
                    anchor: '100%',
                    title: 'PENERIMAAN/PEMERIKSAAN',
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
                                    fieldLabel: 'Tanggal Penerimaan/Pemeriksaan *',
                                    name: 'tgl_penerimaan',
                                    allowBlank: false,
                                    format:'Y-m-d'
                                },
                                {
                                    disabled: false,
                                    fieldLabel: 'Nama Penerima/Pemeriksa *',
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
        
        
        
        Form.Component.inventoryPenyimpanan = function(edit) {

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
                            items: [
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
        
        Form.Component.inventoryPengeluaran = function(edit) {

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
                            items: [
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
        };

        Form.Component.detailPenggunaanAngkutanUdara = function(setting_grid_penggunaan,edit,mesin) {
            
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
                        items: [{
                                        xtype:'label',
                                        text:'Total Penggunaan',
                                },{
                                        xtype:'displayfield',
                                        fieldLabel:'Mesin 1',
                                        name:'total_penggunaan_mesin2',
                                        labelWidth: 50,
                                        id:'total_detail_penggunaan_angkutan_udara_mesin1',
                                        value:'',
                                    },
                                    {
                                        xtype:'displayfield',
                                        fieldLabel:'Mesin 2',
                                        name:'total_penggunaan_mesin'+mesin,
                                        labelWidth: 50,
                                        id:'total_detail_penggunaan_angkutan_udara_mesin2',
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
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>