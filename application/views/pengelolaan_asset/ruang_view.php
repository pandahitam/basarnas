<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Ruang = null;

        Ext.namespace('Ruang', 'Ruang.reader', 'Ruang.proxy', 'Ruang.Data', 'Ruang.Grid', 'Ruang.Window', 'Ruang.Form', 'Ruang.Action',
                'Ruang.URL');
        
        Ruang.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Ruang.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Ruang.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Ruang.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Ruang.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: 'MPemeliharaanRuang', autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'}
            })
        });

        Ruang.URL = {
            read: BASE_URL + 'asset_ruang/getAllData',
            createUpdate: BASE_URL + 'asset_ruang/modifyRuang',
            remove: BASE_URL + 'asset_ruang/deleteRuang',
            createUpdatePemeliharaan: BASE_URL + 'pemeliharaan/modifyPemeliharaanRuang',
            removePemeliharaan: BASE_URL + 'pemeliharaan/deletePemeliharaanRuang',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'

        };

        Ruang.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Ruang', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Ruang.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Ruang',
            url: Ruang.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Ruang.reader,
            timeout:0,
            afterRequest: function(request, success) {
                Params_M_Ruang = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    Ruang.Data.clearFilter();
//                    Ruang.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                      var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    Ruang.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                }
            }
        });

        Ruang.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Ruang', storeId: 'DataRuang', model: 'MRuang', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Ruang.proxy, groupField: 'tipe'
        });
        
         Ruang.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('bangunan-details');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('bangunan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.pengadaanEdit();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('bangunan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('ruang-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.penghapusanDetail();
                    }
                },
               
                pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('ruang-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('ruang-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Ruang.Action.pendayagunaanList();
                    }
                 },
                printPDF: function() {
                        Ruang.Action.printpdf();
                },
                pengelolaan: function(){
                     var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                     var tabpanels = _tab.getComponent('ruang-pengelolaan');
                     if (tabpanels === undefined)
                     {
                         Ruang.Action.pengelolaanList();
                     }
                },
            };

            return actions;
        };
        
        Ruang.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: Ruang.URL.createUpdatePengelolaan,
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
        
        Ruang.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('ruang_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Ruang.Form.createPengelolaan(Ruang.dataStorePengelolaan, dataForm, true);
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

        Ruang.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('ruang_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Ruang.URL.removePengelolaan, Ruang.dataStorePengelolaan);
            }
        };


        Ruang.Action.pengelolaanAdd = function()
        {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = Ruang.Form.createPengelolaan(Ruang.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Ruang.Action.pengelolaanList = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Ruang.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Ruang.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Ruang.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                Ruang.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "ruang_grid_pengelolaan",
                    edit : Ruang.Action.pengelolaanEdit,
                    add : Ruang.Action.pengelolaanAdd,
                    remove : Ruang.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Ruang.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _ruangPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_ruangPendayagunaanGrid, 'ruang-pengelolaan', 'Pengelolaan');
            }
        };

        Ruang.Form.create = function(dataForm, edit) {
            
            var setting = {
                url : Ruang.URL.createUpdate,
                dataGrid : Ruang.Data,
                isEditing : edit
            };
            
            var form = Form.assetRuang(setting);
            
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

        Ruang.Form.createPemeliharaan = function(dataGrid,dataForm,edit) {
            var setting = {
                url: Ruang.URL.createUpdatePemeliharaan,
                data: dataGrid,
                isEditing: edit,
                isRuang: true,
                addBtn: {
                    isHidden: true,
                    text: '',
                    fn: null
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

          var setting_grid_pemeliharaan_part = {
                id:'grid_ruang_pemeliharaan_part',
                toolbar:{
                    add: Ruang.addPemeliharaanPart,
                    edit: Ruang.editPemeliharaanPart,
                    remove: Ruang.removePemeliharaanPart
                },
                dataStore:Ruang.dataStorePemeliharaanPart
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
        
        Ruang.addPemeliharaanPart = function(){
            var id_pemeliharaan = Ext.getCmp('hidden_identifier_id_pemeliharaan').value;
            if(id_pemeliharaan != null && id_pemeliharaan != undefined)
            {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.pemeliharaanPart(Ruang.URL.createUpdatePemeliharaanPart, Ruang.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(id_pemeliharaan));
                    form.insert(1, Form.Component.inventoryPerlengkapan(true));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();

            }
        };
        
        Ruang.editPemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_ruang_pemeliharaan_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.pemeliharaanPart(Ruang.URL.createUpdatePemeliharaanPart, Ruang.dataStorePemeliharaanPart, false);
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
        
        Ruang.removePemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_ruang_pemeliharaan_part').getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Ruang.URL.removePemeliharaanPart, Ruang.dataStorePemeliharaanPart);
        };

       
        
        Ruang.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Ruang.URL.createUpdatePendayagunaan,
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
        
        Ruang.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('ruang_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Ruang.Form.createPendayagunaan(Ruang.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'ruang-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Ruang.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('ruang_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Ruang.URL.removePendayagunaan, Ruang.dataStorePendayagunaan);
            }
        };


        Ruang.Action.pendayagunaanAdd = function()
        {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Ruang.Form.createPendayagunaan(Ruang.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'ruang-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Ruang.Action.pendayagunaanList = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Ruang.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Ruang.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Ruang.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Ruang.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "ruang_grid_pendayagunaan",
                    edit : Ruang.Action.pendayagunaanEdit,
                    add : Ruang.Action.pendayagunaanAdd,
                    remove : Ruang.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Ruang.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _ruangPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_ruangPendayagunaanGrid, 'ruang-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Ruang.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('ruang_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Ruang.Action.pemindahanList = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Ruang.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Ruang.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Ruang.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Ruang.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "ruang_grid_pemindahan",
                    edit : Ruang.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Ruang.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _ruangMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_ruangMutasiGrid, 'ruang-pemindahan', 'Pemindahan');
            }
        };
        
         Ruang.Action.penghapusanDetail = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'ruang-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Ruang.Action.pengadaanEdit = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
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

        Ruang.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('bangunan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Ruang.Form.createPemeliharaan(Ruang.dataStorePemeliharaan, dataForm, true)
//                Tab.addToForm(form, 'bangunan-edit-pemeliharaan', 'Edit Pemeliharaan');
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
                Ruang.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:dataForm.id}});
            }
        };

        Ruang.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('bangunan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Ruang.URL.removePemeliharaan, Ruang.dataStorePemeliharaan);
            }
        };


        Ruang.Action.pemeliharaanAdd = function()
        {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            var form = Ruang.Form.createPemeliharaan(Ruang.dataStorePemeliharaan, dataForm, false)
//            Tab.addToForm(form, 'bangunan-add-pemeliharaan', 'Add Pemeliharaan');
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };


        Ruang.Action.pemeliharaanList = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                Ruang.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Ruang.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Ruang.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Ruang.dataStorePemeliharaan.load();
                var toolbarIDs = {};
                toolbarIDs.idGrid = "bangunan_grid_pemeliharaan";
                toolbarIDs.add = Ruang.Action.pemeliharaanAdd;
                toolbarIDs.remove = Ruang.Action.pemeliharaanRemove;
                toolbarIDs.edit = Ruang.Action.pemeliharaanEdit;
                var setting = {
                    data: data,
                    dataStore: Ruang.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isRuang: true
                };
                var _bangunanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_bangunanPemeliharaanGrid, 'bangunan-pemeliharaan', 'Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Ruang.Action.add = function() {
            var _form = Ruang.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Ruang');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Ruang.Action.edit = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                delete dataForm.nama_unker;
                delete dataForm.nama_unor;

                if (Modal.assetEdit.items.length <= 1)
                {
                    Modal.assetEdit.setTitle('Edit Ruang');
                    Modal.assetEdit.insert(0, Region.createSidePanel(Ruang.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Ruang.Form.create(dataForm, true);
                Tab.addToForm(_form, 'ruang-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Ruang.Action.remove = function() {
            console.log('remove Ruang');
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Ruang.URL.remove, Ruang.Data);
        };

        Ruang.Action.print = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Ruang.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Ruang_Model";
            var title = "Ruang";
            var primaryKeys = "kd_lokasi,kd_brg,no_aset";

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
		
		Ruang.Action.printpdf = function() {
            var selected = Ruang.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_ruang/cetak/' + selectedData, 'Cetak Pengelolaan Asset Ruang');
            
        };

        var setting = {
            grid: {
                id: 'grid_asset_ruang',
                title: 'DAFTAR ASSET RUANG',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden:true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Barang', dataIndex: 'ur_sskel', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'ur_sskel', width: 150, hidden: false, filter: {type: 'string'}},
                    {header: 'Ruang', dataIndex: 'ruang', width: 120, hidden: false, filter: {type: 'string'}},
//                    {header: 'Pejabat Ruang', dataIndex: 'pejabat_ruang', width: 150, hidden: false, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Ruang.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }}]}
                ]
            },
            search: {
                id: 'search_ruang'
            },
            toolbar: {
                id: 'toolbar_ruang',
                add: {
                    id: 'button_add_ruang',
                    action: Ruang.Action.add
                },
                edit: {
                    id: 'button_edit_ruang',
                    action: Ruang.Action.edit
                },
                remove: {
                    id: 'button_remove_ruang',
                    action: Ruang.Action.remove
                },
                print: {
                    id: 'button_pring_ruang',
                    action: Ruang.Action.print
                }
            }
        };

        Ruang.Grid.grid = Grid.inventarisGrid(setting, Ruang.Data);


        var new_tabpanel_Asset = {
            id: 'ruang_panel', title: 'Ruang', iconCls: 'icon-ruang_bangunan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(Ruang.Data,'ruang'),Ruang.Grid.grid]
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>