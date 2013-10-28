<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////

        Ext.namespace('Tanah', 'Tanah.reader', 'Tanah.proxy', 'Tanah.Data', 'Tanah.Grid', 'Tanah.Window', 'Tanah.Form', 'Tanah.Action', 'Tanah.URL');
        
        
        Tanah.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Tanah.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Tanah.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Tanah.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanBangunan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Bangunan/getSpecificPemeliharaanBangunan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Tanah.dataStoreRiwayatPajak = new Ext.create('Ext.data.Store', {
            model: MRiwayatPajakTanahDanBangunan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_tanah/getSpecificRiwayatPajak', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'}),
                extraParams:{open:'0'}
            }),
            autoLoad: false,
        });

        Tanah.URL = {
            read: BASE_URL + 'asset_tanah/getAllData',
            remove: BASE_URL + 'asset_tanah/deleteTanah',
            createUpdate: BASE_URL + 'asset_tanah/modifyTanah',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan_Bangunan/modifyPemeliharaanBangunan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan_Bangunan/deletePemeliharaanBangunan',
            createUpdateRiwayatPajak: BASE_URL + 'asset_tanah/modifyRiwayatPajak',
            removeRiwayatPajak: BASE_URL + 'asset_tanah/deleteRiwayatPajak',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'
        };

        Tanah.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Tanah', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Tanah.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Tanah',
            url: Tanah.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Tanah.reader,
            timeout:600000,
            afterRequest: function(request, success) {
                Params_M_TB = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    Tanah.Data.clearFilter();
//                    Tanah.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                    var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    Tanah.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                    var a =Tanah.Data;
                    debugger;
                }
                
            }
        });
        
        
        Tanah.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Tanah', storeId: 'DataTanah', model: 'MTanah', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Tanah.proxy, remoteFilter:false
        });
        
        
        Tanah.Form.create = function(data, edit) {
            var setting_grid_riwayat_pajak = {
                id:'grid_tanah_riwayat_pajak',
                toolbar:{
                    add: Tanah.addRiwayatPajak,
                    edit: Tanah.editRiwayatPajak,
                    remove: Tanah.removeRiwayatPajak
                },
                dataStore:Tanah.dataStoreRiwayatPajak
            };
            var form = Form.asset(Tanah.URL.createUpdate, Tanah.Data, edit,true);
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
                        Form.Component.basicAsset(edit),
                        Form.Component.address(),
                        Form.Component.tanah(),
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
                layout: 'fit',
                deferredRender: false,
                bodyStyle:{background:'none'},
                items: [
                        Form.Component.tambahanBangunanTanah(),
                        Form.Component.gridRiwayatPajakTanahDanBangunan(setting_grid_riwayat_pajak,edit),
            
                       ],
                listeners: {
                    'beforeclose': function() {
                        Utils.clearDataRef();
                    }
                }
            });

            tab.setActiveTab(0);
            
            form.insert(0,tab);
//            form.insert(0, Form.Component.unit(edit,form));
//            form.insert(1, Form.Component.kode(edit));
//            form.insert(2, Form.Component.klasifikasiAset(edit))
//            form.insert(3, Form.Component.basicAsset(edit));
//            form.insert(4, Form.Component.address());
//            form.insert(5, Form.Component.tanah());
//            form.insert(6, Form.Component.tambahanBangunanTanah());
//            form.insert(7, Form.Component.gridRiwayatPajakTanahDanBangunan(setting_grid_riwayat_pajak,edit));
//            form.insert(8, Form.Component.fileUpload());
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
                presetData.kd_gol = '2';
                presetData.kd_bid = '01';
                form.getForm().setValues(presetData);
            }
            
            
            return form;
        };

        Tanah.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: Tanah.URL.createUpdatePemeliharaan,
                data: data,
                isEditing: edit,
                isBangunan: true, //isBangunan and tanah
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

        Tanah.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-details');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.penghapusanDetail();
                    }
                },
                pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        Tanah.Action.printpdf();
                },
               pengelolaan: function(){
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('tanah-pengelolaan');
                    if (tabpanels === undefined)
                    {
                        Tanah.Action.pengelolaanList();
                    }
               },
            };

            return actions;
        };
        
        Tanah.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: Tanah.URL.createUpdatePengelolaan,
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
        
        Tanah.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('tanah_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Tanah.Form.createPengelolaan(Tanah.dataStorePengelolaan, dataForm, true);
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

        Tanah.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('tanah_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Tanah.URL.removePengelolaan, Tanah.dataStorePengelolaan);
            }
        };


        Tanah.Action.pengelolaanAdd = function()
        {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = Tanah.Form.createPengelolaan(Tanah.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Tanah.Action.pengelolaanList = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Tanah.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Tanah.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Tanah.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                Tanah.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "tanah_grid_pengelolaan",
                    edit : Tanah.Action.pengelolaanEdit,
                    add : Tanah.Action.pengelolaanAdd,
                    remove : Tanah.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Tanah.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _tanahPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_tanahPendayagunaanGrid, 'tanah-pengelolaan', 'Pengelolaan');
            }
        };
        
        Tanah.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Tanah.URL.createUpdatePendayagunaan,
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
        
        Tanah.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('tanah_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Tanah.Form.createPendayagunaan(Tanah.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'tanah-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Tanah.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('tanah_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Tanah.URL.removePendayagunaan, Tanah.dataStorePendayagunaan);
            }
        };


        Tanah.Action.pendayagunaanAdd = function()
        {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Tanah.Form.createPendayagunaan(Tanah.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Tanah.Action.pendayagunaanList = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Tanah.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Tanah.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Tanah.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Tanah.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "tanah_grid_pendayagunaan",
                    edit : Tanah.Action.pendayagunaanEdit,
                    add : Tanah.Action.pendayagunaanAdd,
                    remove : Tanah.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Tanah.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _tanahPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_tanahPendayagunaanGrid, 'tanah-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Tanah.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('tanah_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Tanah.Action.pemindahanList = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Tanah.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Tanah.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Tanah.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Tanah.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "tanah_grid_pemindahan",
                    edit : Tanah.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Tanah.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _tanahMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_tanahMutasiGrid, 'tanah-pemindahan', 'Pemindahan');
            }
        };
        
        Tanah.Action.penghapusanDetail = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'tanah-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Tanah.Action.detail_pengadaan = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                var params = {
                    kd_lokasi: data.kd_lokasi,
                    kd_unor: data.kd_unor,
                    kd_brg: data.kd_brg,
                    no_aset: data.no_aset
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

                        console.log(jsonData);

                        var setting = {
                            url: BASE_URL + 'Pengadaan/modifyPengadaan',
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
                        Tab.addToForm(form, 'tanah-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };


        Tanah.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('tanah_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Tanah.Form.createPemeliharaan(Tanah.dataStorePemeliharaan, dataForm, true);
//                if (Modal.assetSecondaryWindow.items.length === 0)
//                {
//                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
//                }
//                Modal.assetSecondaryWindow.add(form);
//                Modal.assetSecondaryWindow.show();
                Tab.addToForm(form, 'tanah-edit-pemeliharaan', 'Edit Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Tanah.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('tanah_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Tanah.URL.removePemeliharaan, Tanah.dataStorePemeliharaan);
            }
        };


        Tanah.Action.pemeliharaanAdd = function()
        {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            
            var form = Tanah.Form.createPemeliharaan(Tanah.dataStorePemeliharaan, dataForm, false);
//            if (Modal.assetSecondaryWindow.items.length === 0)
//            {
//                Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
//            }
//            Modal.assetSecondaryWindow.add(form);
//            Modal.assetSecondaryWindow.show();
            
            Tab.addToForm(form, 'tanah-add-pemeliharaan', 'Add Pemeliharaan');
        };

        Tanah.Action.pemeliharaanList = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Tanah.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Tanah.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Tanah.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Tanah.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "tanah_grid_pemeliharaan",
                    add : Tanah.Action.pemeliharaanAdd,
                    remove : Tanah.Action.pemeliharaanRemove,
                    edit : Tanah.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: Tanah.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: true,
                };
                
                var _tanahPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_tanahPemeliharaanGrid, 'tanah-pemeliharaan', 'Pemeliharaan');
            }
        };
        
        Tanah.addRiwayatPajak = function()
        {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Riwayat Pajak');
                }
                    var uploadRiwayatPajak = {
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
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items:[Form.Component.fileUploadDocumentOnly('file_setoran','TanahRiwayatPajakFile')]
                    }]
                    };
                    
                    var form = Form.riwayatPajak(Tanah.URL.createUpdateRiwayatPajak, Tanah.dataStoreRiwayatPajak, false,'tanah');
                    form.insert(0, Form.Component.dataRiwayatPajakTanahDanBangunan(data.id));
                    form.insert(1, uploadRiwayatPajak);
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
            }
                
        };
        
        Tanah.editRiwayatPajak = function()
        {
            var selected = Ext.getCmp('grid_tanah_riwayat_pajak').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Riwayat Pajak');
                }
                
                var uploadRiwayatPajak = {
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
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        items:[Form.Component.fileUploadDocumentOnly('file_setoran','TanahRiwayatPajakFile')]
                    }]
                    };
                   
                    var form = Form.riwayatPajak(Tanah.URL.createUpdateRiwayatPajak, Tanah.dataStoreRiwayatPajak, true, 'tanah');
                    form.insert(0, Form.Component.dataRiwayatPajakTanahDanBangunan(data.id_ext_asset));
                    form.insert(1, uploadRiwayatPajak);
//                    form.insert(1, Form.Component.fileUpload());
                    
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
        Tanah.removeRiwayatPajak = function()
        {
            var selected = Ext.getCmp('grid_tanah_riwayat_pajak').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
            Modal.deleteAlert(arrayDeleted, Tanah.URL.removeRiwayatPajak,Tanah.dataStoreRiwayatPajak);
        };

        Tanah.Action.add = function() {
            var _form = Tanah.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Tanah');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Tanah.Action.edit = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var flagExtAsset = false;
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Tanah');
                    Modal.assetEdit.add(Region.createSidePanel(Tanah.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }
                
                if(data.id == null || data.id == undefined)
                {   
                    $.ajax({
                       url:BASE_URL + 'asset_tanah/requestIdExtAsset',
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
                    var _form = Tanah.Form.create(data, true);
                    Tab.addToForm(_form, 'tanah-details', 'Simak Details');
                    Modal.assetEdit.show();
                    Tanah.dataStoreRiwayatPajak.changeParams({params:{open:'1',id_ext_asset:data.id}});
                }
            }
        };

        Tanah.Action.remove = function() {
            console.log('remove tanah');
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Tanah.URL.remove, Tanah.Data);
        };

        Tanah.Action.print = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Tanah.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Tanah_Model";
            var title = "Tanah";
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
		
		Tanah.Action.printpdf = function() {
            var selected = Tanah.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_tanah/cetak/' + selectedData, 'Cetak Pengelolaan Asset Tanah');
            
        };

        var setting = {
            grid: {
                id: 'grid_tanah',
                title: 'DAFTAR ASSET TANAH',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Id Ext Asset', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Barang', dataIndex: 'ur_sskel', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150, groupable: true, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150, groupable: true, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'RPH Asset', dataIndex: 'rph_aset', width: 120, groupable: false, filter: {type: 'numeric'}},
                    {header: 'RPH Wajar', dataIndex: 'rphwajar', width: 90, hidden: false, filter: {type: 'numeric'}},
                    {header: 'No KIB', dataIndex: 'no_kib', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Tnhs', dataIndex: 'luas_tnhs', width: 70, hidden: false, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Thnb', dataIndex: 'luas_tnhb', width: 70, hidden: false, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Thnl', dataIndex: 'luas_tnhl', width: 70, hidden: false, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Thnk', dataIndex: 'luas_tnhk', width: 70, hidden: false, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Kode Prov', dataIndex: 'kd_prov', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kab', dataIndex: 'kd_kab', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kec', dataIndex: 'kd_kec', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kel', dataIndex: 'kd_kel', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat', dataIndex: 'alamat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode RTRW', dataIndex: 'kd_rtrw', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Batas Utara', dataIndex: 'batas_u', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Batas Selatan', dataIndex: 'batas_s', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Batas Timur', dataIndex: 'batas_t', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Batas Barat', dataIndex: 'batas_b', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis Trn', dataIndex: 'jns_trn', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 180, hidden: true, filter: {type: 'string'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Surat 1', dataIndex: 'surat1', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Surat 2', dataIndex: 'surat2', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Surat 3', dataIndex: 'surat3', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Harga M2', dataIndex: 'rph_m2', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Unit PMK', dataIndex: 'unit_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat PMK', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Prl', dataIndex: 'tgl_prl', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'RPH NJOP', dataIndex: 'rphnjop', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Milik', dataIndex: 'smilik', width: 90, hidden: true, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Tanah.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }}]}
                ]
            },
            search: {
                id: 'search_tanah'
            },
            toolbar: {
                id: 'toolbar_tanah',
                add: {
                    id: 'button_add_tanah',
                    action: Tanah.Action.add
                },
                edit: {
                    id: 'button_edit_tanah',
                    action: Tanah.Action.edit
                },
                remove: {
                    id: 'button_remove_tanah',
                    action: Tanah.Action.remove
                },
                print: {
                    id: 'button_pring_tanah',
                    action: Tanah.Action.print
                }
            }
        };

        Tanah.Grid.grid = Grid.inventarisGrid(setting, Tanah.Data);

        var new_tabpanel_Asset = {
            id: 'tanah_panel', title: 'Tanah', iconCls: 'icon-tanah_bangunan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAsetNoKlasifikasi(Tanah.Data,'tanah','2','01'),Tanah.Grid.grid]
        };
<?php

} else {
    echo "var new_tabpanel_MD = 'GAGAL';";
}
?>