<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Perairan = null;

        Ext.namespace('Perairan', 'Perairan.reader', 'Perairan.proxy', 'Perairan.Data', 'Perairan.Grid', 'Perairan.Window', 'Perairan.Form', 'Perairan.Action', 'Perairan.URL');
        
        Perairan.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perairan.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perairan.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perairan.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perairan.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        Perairan.URL = {
            read: BASE_URL + 'asset_perairan/getAllData',
            createUpdate: BASE_URL + 'asset_perairan/modifyPerairan',
            remove: BASE_URL + 'asset_perairan/deletePerairan',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'

        };

        Perairan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Perairan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Perairan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Perairan',
            url: Perairan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Perairan.reader,
            timeout:600000,
            afterRequest: function(request, success) {
                Params_M_Perairan = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    Perairan.Data.clearFilter();
//                    Perairan.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                      var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    Perairan.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                }
            }
        });

        Perairan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Perairan', storeId: 'DataPerairan', model: 'MPerairan', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Perairan.proxy, groupField: 'tipe'
        });
        
         Perairan.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-details');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perairan-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Perairan.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        Perairan.Action.printpdf();
                },
                pengelolaan: function(){
                   var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                   var tabpanels = _tab.getComponent('perairan-pengelolaan');
                   if (tabpanels === undefined)
                   {
                       Perairan.Action.pengelolaanList();
                   }
              },
           };

            return actions;
        };
        
        Perairan.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: Perairan.URL.createUpdatePengelolaan,
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
        
        Perairan.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('perairan_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perairan.Form.createPengelolaan(Perairan.dataStorePengelolaan, dataForm, true);
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

        Perairan.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('perairan_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Perairan.URL.removePengelolaan, Perairan.dataStorePengelolaan);
            }
        };


        Perairan.Action.pengelolaanAdd = function()
        {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = Perairan.Form.createPengelolaan(Perairan.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Perairan.Action.pengelolaanList = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perairan.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perairan.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perairan.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                Perairan.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "perairan_grid_pengelolaan",
                    edit : Perairan.Action.pengelolaanEdit,
                    add : Perairan.Action.pengelolaanAdd,
                    remove : Perairan.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Perairan.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _perairanPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_perairanPendayagunaanGrid, 'perairan-pengelolaan', 'Pengelolaan');
            }
        };

        Perairan.Form.create = function(data, edit) {
            var form = Form.asset(Perairan.URL.createUpdate, Perairan.Data, edit);
            form.insert(0, Form.Component.unit(edit,form));
            form.insert(1, Form.Component.kode(edit));
            form.insert(3, Form.Component.basicAsset(edit));
            form.insert(4, Form.Component.address());
            form.insert(5, Form.Component.bangunan());
            form.insert(6, Form.Component.fileUpload());
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
                presetData.kd_gol = '5';
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

        Perairan.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: Perairan.URL.createUpdatePemeliharaan,
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

             var setting_grid_pemeliharaan_part = {
                id:'grid_perairan_pemeliharaan_part',
                toolbar:{
                    add: Perairan.addPemeliharaanPart,
                    edit: Perairan.editPemeliharaanPart,
                    remove: Perairan.removePemeliharaanPart
                },
                dataStore:Perairan.dataStorePemeliharaanPart
            };

            var form = Form.pemeliharaanInAsset(setting,setting_grid_pemeliharaan_part);

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
        
        Perairan.addPemeliharaanPart = function(){
            var id_pemeliharaan = Ext.getCmp('hidden_identifier_id_pemeliharaan').value;
            if(id_pemeliharaan != null && id_pemeliharaan != undefined)
            {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.pemeliharaanPart(Perairan.URL.createUpdatePemeliharaanPart, Perairan.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(id_pemeliharaan));
                    form.insert(1, Form.Component.inventoryPerlengkapan(true));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();

            }
        };
        
        Perairan.editPemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_perairan_pemeliharaan_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.pemeliharaanPart(Perairan.URL.createUpdatePemeliharaanPart, Perairan.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(data.id_pemeliharaan,true));
                    form.insert(1, Form.Component.inventoryPerlengkapan(true));
                    
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
        
        Perairan.removePemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_perairan_pemeliharaan_part').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    id_penyimpanan: obj.data.id_penyimpanan,
                    qty_pemeliharaan:obj.data.qty_pemeliharaan,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
            Modal.deleteAlert(arrayDeleted, Perairan.URL.removePemeliharaanPart, Perairan.dataStorePemeliharaanPart);
        };
        
        Perairan.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Perairan.URL.createUpdatePendayagunaan,
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
        
        Perairan.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('perairan_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perairan.Form.createPendayagunaan(Perairan.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'perairan-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Perairan.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('perairan_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Perairan.URL.removePendayagunaan, Perairan.dataStorePendayagunaan);
            }
        };


        Perairan.Action.pendayagunaanAdd = function()
        {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Perairan.Form.createPendayagunaan(Perairan.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'perairan-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Perairan.Action.pendayagunaanList = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perairan.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perairan.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perairan.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Perairan.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "perairan_grid_pendayagunaan",
                    edit : Perairan.Action.pendayagunaanEdit,
                    add : Perairan.Action.pendayagunaanAdd,
                    remove : Perairan.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Perairan.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _perairanPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_perairanPendayagunaanGrid, 'perairan-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Perairan.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('perairan_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Perairan.Action.pemindahanList = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perairan.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perairan.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Perairan.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Perairan.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "perairan_grid_pemindahan",
                    edit : Perairan.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Perairan.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _perairanMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_perairanMutasiGrid, 'perairan-pemindahan', 'Pemindahan');
            }
        };
        
         Perairan.Action.penghapusanDetail = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'perairan-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Perairan.Action.detail_pengadaan = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'bangunan-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        Perairan.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('perairan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perairan.Form.createPemeliharaan(Perairan.dataStorePemeliharaan, dataForm, true);
//                Tab.addToForm(form, 'perairan-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
                Perairan.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:dataForm.id}});
            }
        };

        Perairan.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('perairan_grid_pemeliharaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Perairan.URL.removePemeliharaan, Perairan.dataStorePemeliharaan);
            }
        };


        Perairan.Action.pemeliharaanAdd = function()
        {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Perairan.Form.createPemeliharaan(Perairan.dataStorePemeliharaan, dataForm, false);
//            Tab.addToForm(form, 'perairan-add-pemeliharaan', 'Add Pemeliharaan');
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };

        Perairan.Action.pemeliharaanList = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perairan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perairan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perairan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Perairan.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "perairan_grid_pemeliharaan",
                    add : Perairan.Action.pemeliharaanAdd,
                    remove : Perairan.Action.pemeliharaanRemove,
                    edit : Perairan.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: Perairan.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _perairanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_perairanPemeliharaanGrid, 'perairan-pemeliharaan', 'Pemeliharaan');
            }
        };

        Perairan.Action.add = function() {
            var _form = Perairan.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Perairan');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Perairan.Action.edit = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Perairan');
                    Modal.assetEdit.add(Region.createSidePanel(Perairan.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Perairan.Form.create(data, true);
                Tab.addToForm(_form, 'perairan-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Perairan.Action.remove = function() {
            console.log('remove Perairan');
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Perairan.URL.remove, Perairan.Data);
        };

        Perairan.Action.print = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Perairan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Perairan_Model";
            var title = "Perairan";
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

		Perairan.Action.printpdf = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_perairan/cetak/' + selectedData, 'Cetak Pengelolaan Asset Perairan');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_perairan',
                title: 'DAFTAR ASSET PERAIRANG DAN IRIGASI',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Barang', dataIndex: 'ur_sskel', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'RPH Asset', dataIndex: 'rph_aset', width: 120, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No KIB', dataIndex: 'no_kib', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Bangunan', dataIndex: 'luas_bdg', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Luas Dasar', dataIndex: 'luas_dsr', width: 70, hidden: true, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Kapasitas', dataIndex: 'kapasitas', width: 70, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tahun Selesai', dataIndex: 'thn_sls', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Pakai', dataIndex: 'thn_pakai', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'No IMB', dataIndex: 'no_imb', width: 120, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Prov', dataIndex: 'kd_prov', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kab', dataIndex: 'kd_kab', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kec', dataIndex: 'kd_kec', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kel', dataIndex: 'kd_kel', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat', dataIndex: 'alamat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode RTRW', dataIndex: 'kd_rtrw', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Kib Tanah', dataIndex: 'no_kibtnh', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis Trn', dataIndex: 'jns_trn', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 180, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Prl', dataIndex: 'tgl_prl', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Harga Wajar', dataIndex: 'rph_wajar', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Unit Pmk', dataIndex: 'unit_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat Pmk', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kons Sist', dataIndex: 'kons_sist', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Perairan.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_bangunan'
            },
            toolbar: {
                id: 'toolbar_perairan',
                add: {
                    id: 'button_add_perairan',
                    action: Perairan.Action.add
                },
                edit: {
                    id: 'button_edit_perairan',
                    action: Perairan.Action.edit
                },
                remove: {
                    id: 'button_remove_perairan',
                    action: Perairan.Action.remove
                },
                print: {
                    id: 'button_pring_perairan',
                    action: Perairan.Action.print
                }
            }
        };

        Perairan.Grid.grid = Grid.inventarisGrid(setting, Perairan.Data);


        var new_tabpanel_Asset = {
            id: 'perairan_panel', title: 'Perairan', iconCls: 'icon-perairan_bangunan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAsetNoKlasifikasi(Perairan.Data,'perairan','5'),Perairan.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>