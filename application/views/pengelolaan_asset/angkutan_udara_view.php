<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_AngkutanUdara = null;

        Ext.namespace('AngkutanUdara', 'AngkutanUdara.reader', 'AngkutanUdara.proxy', 'AngkutanUdara.Data', 'AngkutanUdara.Grid', 'AngkutanUdara.Window',
                'AngkutanUdara.Form', 'AngkutanUdara.Action', 'AngkutanUdara.URL');
        
       AngkutanUdara.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanUdara.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanUdara.dataStorePerlengkapanAngkutanUdara = new Ext.create('Ext.data.Store', {
            model: MAngkutanUdaraPerlengkapan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_angkutan_udara/getSpecificPerlengkapanAngkutanUdara', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanUdara.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        AngkutanUdara.URL = {
            read: BASE_URL + 'asset_angkutan_udara/getAllData',
            createUpdate: BASE_URL + 'asset_angkutan_udara/modifyAngkutanUdara',
            remove: BASE_URL + 'asset_angkutan_udara/deleteAngkutanUdara',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePerlengkapanAngkutanUdara: BASE_URL + 'asset_angkutan_udara/modifyPerlengkapanAngkutanUdara',
            removePerlengkapanAngkutanUdara: BASE_URL + 'asset_angkutan_udara/deletePerlengkapanAngkutanUdara',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan'
        };

        AngkutanUdara.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_AngkutanUdara', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        AngkutanUdara.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_AngkutanUdara',
            url: AngkutanUdara.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: AngkutanUdara.reader,
            afterRequest: function(request, success) {
                //Params_M_AngkutanUdara = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null ||paramsUnker != undefined)
                {
                    AngkutanUdara.Data.clearFilter();
                    AngkutanUdara.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                }
            }
        });

        AngkutanUdara.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_AngkutanUdara', storeId: 'DataAngkutanUdara', model: 'MAngkutanUdara', pageSize: 50, noCache: false, autoLoad: true,
            proxy: AngkutanUdara.proxy, groupField: 'tipe'
        });
        
        AngkutanUdara.addPerlengkapan = function()
        {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanUdara.URL.createUpdatePerlengkapanAngkutanUdara, AngkutanUdara.dataStorePerlengkapanAngkutanUdara, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanUdara(data.id));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
            }
        };
        
        AngkutanUdara.editPerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanUdara_perlengkapan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanUdara.URL.createUpdatePerlengkapanAngkutanUdara, AngkutanUdara.dataStorePerlengkapanAngkutanUdara, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanUdara(data.id));
                    
                    if (data !== null)
                    {
                         form.getForm().setValues(data);
                    }
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
        }};
        
        AngkutanUdara.removePerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanUdara_perlengkapan').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
            Modal.deleteAlert(arrayDeleted, AngkutanUdara.URL.removePerlengkapanAngkutanUdara,AngkutanUdara.dataStorePerlengkapanAngkutanUdara);
        };

        AngkutanUdara.Form.create = function(data, edit) {
            var setting_grid_perlengkapan = {
                id:'grid_angkutanUdara_perlengkapan',
                toolbar:{
                    add: AngkutanUdara.addPerlengkapan,
                    edit: AngkutanUdara.editPerlengkapan,
                    remove: AngkutanUdara.removePerlengkapan
                },
                dataStore:AngkutanUdara.dataStorePerlengkapanAngkutanUdara
            };
           var form = Form.assetAngkutanUdara(AngkutanUdara.URL.createUpdate, AngkutanUdara.Data, edit, true);
             var tab = Tab.formTabs();
            tab.add({
                title: 'Utama',
                closable: false,
                border: false,
                deferredRender: false,
                bodyStyle:{background:'none'},
                items: [
                        Form.Component.unit(edit,form),
                        Form.Component.kode(edit),
                        Form.Component.klasifikasiAset(edit),
                        Form.Component.basicAsset(edit),
                        Form.Component.mechanical(),
                        Form.Component.angkutan(),
                        Form.Component.fileUpload(),
                       ],
                listeners: {
                    'beforeclose': function() {
                        Utils.clearDataRef();
                    }
                }
            });
            
            tab.add({
                title: 'Tambahan',
                closable: false,
                border: false,
                layout:'fit',
                deferredRender: false,
                bodyStyle:{background:'none'},
                items: [
                        Form.Component.tambahanAngkutanUdara(setting_grid_perlengkapan,edit),
                       ],
                listeners: {
                    'beforeclose': function() {
                        Utils.clearDataRef();
                    }
                }
            });

            tab.setActiveTab(0);
            
            form.insert(0,tab);
            
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        AngkutanUdara.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanUdara.URL.createUpdatePemeliharaan,
                data: data,
                isEditing: edit,
                isBangunan: false,
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

            var form = Form.pemeliharaanInAsset(setting);

            if (dataForm !== null)
            {
                form.getForm().setValues(dataForm);
            }
            return form;
        };

        AngkutanUdara.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-details');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-pengadaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-penghapusan');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-pemindahan');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanUdara-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanUdara.Action.pendayagunaanList();
                    }
               },
                printPDF: function() {
                        AngkutanUdara.Action.printpdf();
                },
            };

            return actions;
        };
        
        AngkutanUdara.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanUdara.URL.createUpdatePendayagunaan,
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
                form.getForm().setValues(dataForm);
            }
            return form;
        };
        
        AngkutanUdara.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('angkutanUdara_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanUdara.Form.createPendayagunaan(AngkutanUdara.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'angkutanUdara-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        AngkutanUdara.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('angkutanUdara_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                console.log(arrayDeleted);
                Modal.deleteAlert(arrayDeleted, AngkutanUdara.URL.removePendayagunaan, AngkutanUdara.dataStorePendayagunaan);
            }
        };


        AngkutanUdara.Action.pendayagunaanAdd = function()
        {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = AngkutanUdara.Form.createPendayagunaan(AngkutanUdara.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'angkutanUdara-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        AngkutanUdara.Action.pendayagunaanList = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanUdara.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanUdara.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanUdara.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanUdara.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanUdara_grid_pendayagunaan",
                    edit : AngkutanUdara.Action.pendayagunaanEdit,
                    add : AngkutanUdara.Action.pendayagunaanAdd,
                    remove : AngkutanUdara.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanUdara.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanUdaraPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_angkutanUdaraPendayagunaanGrid, 'angkutanUdara-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        AngkutanUdara.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('angkutanUdara_grid_pemindahan').getSelectionModel().getSelection();
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

                if (data !== null || data !== undefined)
                {
                    form.getForm().setValues(jsonData);
                }

                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Detail Pemindahan');
                }

                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
           }
        };
        
        AngkutanUdara.Action.pemindahanList = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanUdara.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanUdara.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanUdara.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanUdara.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanUdara_grid_pemindahan",
                    edit : AngkutanUdara.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanUdara.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanUdaraMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_angkutanUdaraMutasiGrid, 'angkutanUdara-pemindahan', 'Pemindahan');
            }
        };
        
         AngkutanUdara.Action.penghapusanDetail = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
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

                        console.log(jsonData);

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

                        if (jsonData !== null || jsonData !== undefined)
                        {
                            form.getForm().setValues(jsonData);
                        }
                        Tab.addToForm(form, 'angkutanUdara-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        AngkutanUdara.Action.detail_pengadaan = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                var params = {
                                kd_lokasi : data.kd_lokasi,
                                kd_unor : data.kd_unor,
                                kd_brg : data.kd_brg,
                                no_aset : data.no_aset
                        };
                        
                Ext.Ajax.request({
                    url: BASE_URL + 'pengadaan/getByKode/',
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
                        if (jsonData !== null || jsonData !== undefined)
                        {
                            form.getForm().setValues(jsonData);
                        }
                        Tab.addToForm(form, 'angkutanUdara-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        AngkutanUdara.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('angkutanUdara_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanUdara.Form.createPemeliharaan(AngkutanUdara.dataStorePemeliharaan, dataForm, true);
                Tab.addToForm(form, 'angkutanUdara-edit-pemeliharaan', 'Edit Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        AngkutanUdara.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('angkutanUdara_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                console.log(arrayDeleted);
                Modal.deleteAlert(arrayDeleted, AngkutanUdara.URL.removePemeliharaan, AngkutanUdara.dataStorePemeliharaan);
            }
        };


        AngkutanUdara.Action.pemeliharaanAdd = function()
        {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = AngkutanUdara.Form.createPemeliharaan(AngkutanUdara.dataStorePemeliharaan, dataForm, false);
            Tab.addToForm(form, 'angkutanUdara-add-pemeliharaan', 'Add Pemeliharaan');
        };

        AngkutanUdara.Action.pemeliharaanList = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanUdara.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanUdara.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanUdara.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanUdara.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanUdara_grid_pemeliharaan",
                    add : AngkutanUdara.Action.pemeliharaanAdd,
                    remove : AngkutanUdara.Action.pemeliharaanRemove,
                    edit : AngkutanUdara.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanUdara.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _angkutanUdaraPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_angkutanUdaraPemeliharaanGrid, 'angkutanUdara-pemeliharaan', 'Pemeliharaan');
            }
        };

        AngkutanUdara.Action.add = function() {
            var _form = AngkutanUdara.Form.create(null, false);
            Modal.assetCreate.add(_form);
            Modal.assetCreate.setTitle('Create Angkutan Udara');
            Modal.assetCreate.show();
        };

        AngkutanUdara.Action.edit = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                var flagExtAsset = false;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Angkutan Udara');
                    Modal.assetEdit.add(Region.createSidePanel(AngkutanUdara.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }
                
                if(data.id == null || data.id == undefined)
                {   
                    $.ajax({
                       url:BASE_URL + 'asset_angkutan_udara/requestIdExtAsset',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       data:{kd_brg:data.kd_brg, kd_lokasi:data.kd_lokasi, no_aset:data.no_aset},
                       success:function(response, status){
                        if(response.status == 'success')
                        {
                            flagExtAsset = true;
                            data.id = response.idExt;
                        }
                           
                       }
                    });
                }
                else
                {
                    flagExtAsset = true;
                }
                if(flagExtAsset == true)
                {
                    var _form = AngkutanUdara.Form.create(data, true);
                    Tab.addToForm(_form, 'angkutanUdara-details', 'Simak Details');
                    Modal.assetEdit.show();
                    AngkutanUdara.dataStorePerlengkapanAngkutanUdara.changeParams({params:{open:'1',id_ext_asset:data.id}});
                }

            }
        };

        AngkutanUdara.Action.remove = function() {
            console.log('remove AngkutanUdara');
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
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
            console.log(arrayDeleted);
            Modal.deleteAlert(arrayDeleted, AngkutanUdara.URL.remove, AngkutanUdara.Data);
        };

        AngkutanUdara.Action.print = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = AngkutanUdara.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
            var gridHeaderList = "";
            //index starts at 2 to exclude the No. column
            for (var i = 2; i < gridHeader.length; i++)
            {
                if (gridHeader[i].dataIndex == undefined || gridHeader[i].dataIndex == "") //filter the action columns in grid
                {
                    //do nothing
                }
                else
                {
                    gridHeaderList += gridHeader[i].text + "&&" + gridHeader[i].dataIndex + "^^";
                }
            }
            var serverSideModelName = "Asset_Angkutan_Udara_Model";
            var title = "Angkutan Udara";
            var primaryKeys = "kd_lokasi,kd_brg,no_aset";

            my_form = document.createElement('FORM');
            my_form.name = 'myForm';
            my_form.method = 'POST';
            my_form.action = BASE_URL + 'excel_management/exportToExcel/';

            my_tb = document.createElement('INPUT');
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

		AngkutanUdara.Action.printpdf = function() {
            var selected = AngkutanUdara.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_angkutan_udara/cetak/' + selectedData, 'Cetak Pengelolaan Asset Angkutan Udara');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_AngkutanUdara',
                title: 'DAFTAR ASSET ANGKUTAN UDARA',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150, groupable: true, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150, groupable: true, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No KIB', dataIndex: 'no_kib', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Merk', dataIndex: 'merk', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Type', dataIndex: 'type', width: 120, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Pabrik', dataIndex: 'pabrik', width: 90, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tahun Rakit', dataIndex: 'thn_rakit', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Buat', dataIndex: 'thn_buat', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Negara', dataIndex: 'negara', width: 120, hidden: true, filter: {type: 'string'}},
                    {header: 'Muat Gedung', dataIndex: 'muat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Bobot', dataIndex: 'bobot', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Daya', dataIndex: 'daya', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Msn Grk', dataIndex: 'msn_grk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jumlah', dataIndex: 'jml_msn', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Bahan Bakar', dataIndex: 'bhn_bakar', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Mesin', dataIndex: 'no_mesin', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Rangka', dataIndex: 'no_rangka', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Polisi', dataIndex: 'no_polisi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No BPKB', dataIndex: 'no_bpkb', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap1', dataIndex: 'lengkap1', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap2', dataIndex: 'lengkap2', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap3', dataIndex: 'lengkap3', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis Trn', dataIndex: 'jns_trn', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 180, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal PRL', dataIndex: 'tgl_prl', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'RPH Asset', dataIndex: 'rph_aset', width: 120, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Unit PMK', dataIndex: 'unit_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat PMK', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'RPH Wajar', dataIndex: 'rphwajar', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Cad1', dataIndex: 'cad1', width: 90, hidden: true, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = AngkutanUdara.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_AngkutanUdara'
            },
            toolbar: {
                id: 'toolbar_angkutanUdara',
                add: {
                    id: 'button_add_AngkutanUdara',
                    action: AngkutanUdara.Action.add
                },
                edit: {
                    id: 'button_edit_AngkutanUdara',
                    action: AngkutanUdara.Action.edit
                },
                remove: {
                    id: 'button_remove_AngkutanUdara',
                    action: AngkutanUdara.Action.remove
                },
                print: {
                    id: 'button_pring_AngkutanUdara',
                    action: AngkutanUdara.Action.print
                }
            }
        };

        AngkutanUdara.Grid.grid = Grid.inventarisGrid(setting, AngkutanUdara.Data);


        var new_tabpanel_Asset = {
            id: 'angkutan_udara_panel', title: 'Angkutan Udara', iconCls: 'icon-tanah_AngkutanUdara', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(AngkutanUdara.Data,'angkutanUdara','3','02','05'),AngkutanUdara.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>