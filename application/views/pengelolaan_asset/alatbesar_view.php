<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
///////////
        var Params_M_Alatbesar = null;

        Ext.namespace('Alatbesar', 'Alatbesar.reader', 'Alatbesar.proxy',
                'Alatbesar.Data', 'Alatbesar.Grid', 'Alatbesar.Window', 'Alatbesar.Form', 'Alatbesar.Action', 'Alatbesar.URL');
        
        Alatbesar.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Alatbesar.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Alatbesar.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Alatbesar.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Alatbesar.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        Alatbesar.URL = {
            read: BASE_URL + 'asset_Alatbesar/getAllData',
            createUpdate: BASE_URL + 'asset_Alatbesar/modifyAlatbesar',
            remove: BASE_URL + 'asset_Alatbesar/deleteAlatbesar',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'

        };

        Alatbesar.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Alatbesar', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Alatbesar.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Alatbesar',
            url: Alatbesar.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Alatbesar.reader,
            timeout:600000,
            afterRequest: function(request, success) {
                if(success == true)
                {
                    Params_M_Alatbesar = request.operation.params;
                    
                    var responseObject = eval ("(" + request.operation.response.responseText + ")");
                    var total_asset_field = Ext.getCmp('total_grid_Alatbesar');

                    if(responseObject.total_rph_aset !=null && responseObject.total_rph_aset != undefined)
                    {
                        total_asset_field.setValue(responseObject.total_rph_aset.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    
                    //USED FOR MAP SEARCH
                    var paramsUnker = request.params.searchUnker;
                    if(paramsUnker != null && paramsUnker != undefined)
                    {
    //                    Alatbesar.Data.clearFilter();
    //                    Alatbesar.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                        var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                        var gridFilter = JSON.stringify(gridFilterObject);

                        Alatbesar.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                    }
                }
                
            }
        });

        Alatbesar.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Alatbesar', storeId: 'DataAlatbesar', model: 'MAlatbesar', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Alatbesar.proxy,
        });
        
        Alatbesar.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-details');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.edit('alatbesar-details');
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.pemeliharaanList();
                    }
                },
                perencanaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-perencanaan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.detail_perencanaan();
                    }
                },
               penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        Alatbesar.Action.printpdf();
                },
                pengelolaan: function(){
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('alatbesar-pengelolaan');
                    if (tabpanels === undefined)
                    {
                        Alatbesar.Action.pengelolaanList();
                    }
               },
            };

            return actions;
        };
        
        Alatbesar.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: Alatbesar.URL.createUpdatePengelolaan,
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
        
        Alatbesar.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('alatbesar_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Alatbesar.Form.createPengelolaan(Alatbesar.dataStorePengelolaan, dataForm, true);
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

        Alatbesar.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('alatbesar_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Alatbesar.URL.removePengelolaan, Alatbesar.dataStorePengelolaan);
            }
        };


        Alatbesar.Action.pengelolaanAdd = function()
        {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = Alatbesar.Form.createPengelolaan(Alatbesar.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Alatbesar.Action.pengelolaanList = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Alatbesar.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Alatbesar.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Alatbesar.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                Alatbesar.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "alatbesar_grid_pengelolaan",
                    edit : Alatbesar.Action.pengelolaanEdit,
                    add : Alatbesar.Action.pengelolaanAdd,
                    remove : Alatbesar.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Alatbesar.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _alatbesarPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_alatbesarPendayagunaanGrid, 'alatbesar-pengelolaan', 'Pengelolaan');
            }
        };

        Alatbesar.Form.create = function(data, edit) {
            var form = Form.asset(Alatbesar.URL.createUpdate, Alatbesar.Data, edit);
            form.insert(0, Form.Component.unit(edit,form));
            form.insert(1, Form.Component.kode(edit));
            form.insert(2, Form.Component.klasifikasiAset(edit))
            form.insert(3, Form.Component.basicAsset(edit));
            form.insert(4, Form.Component.mechanical());
            form.insert(5, Form.Component.alatbesar());
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
                presetData.kd_gol = '3';
//                presetData.kd_bid = '09';
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

        Alatbesar.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: Alatbesar.URL.createUpdatePemeliharaan,
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
                id:'grid_alatbesar_pemeliharaan_part',
                toolbar:{
                    add: Alatbesar.addPemeliharaanPart,
                    edit: Alatbesar.editPemeliharaanPart,
                    remove: Alatbesar.removePemeliharaanPart
                },
                dataStore:Alatbesar.dataStorePemeliharaanPart
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
        
        Alatbesar.addPemeliharaanPart = function(){
            var id_pemeliharaan = Ext.getCmp('hidden_identifier_id_pemeliharaan').value;
            if(id_pemeliharaan != null && id_pemeliharaan != undefined)
            {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.pemeliharaanPart(Alatbesar.URL.createUpdatePemeliharaanPart, Alatbesar.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(id_pemeliharaan));
                    form.insert(1, Form.Component.inventoryPerlengkapan(true));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();

            }
        };
        
        Alatbesar.editPemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_alatbesar_pemeliharaan_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.pemeliharaanPart(Alatbesar.URL.createUpdatePemeliharaanPart, Alatbesar.dataStorePemeliharaanPart, false);
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
        
        Alatbesar.removePemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_alatbesar_pemeliharaan_part').getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Alatbesar.URL.removePemeliharaanPart, Alatbesar.dataStorePemeliharaanPart);
        };

        
        
        Alatbesar.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Alatbesar.URL.createUpdatePendayagunaan,
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
        
        Alatbesar.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('alatbesar_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Alatbesar.Form.createPendayagunaan(Alatbesar.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'alatbesar-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Alatbesar.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('alatbesar_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Alatbesar.URL.removePendayagunaan, Alatbesar.dataStorePendayagunaan);
            }
        };


        Alatbesar.Action.pendayagunaanAdd = function()
        {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Alatbesar.Form.createPendayagunaan(Alatbesar.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'alatbesar-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Alatbesar.Action.pendayagunaanList = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Alatbesar.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Alatbesar.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Alatbesar.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Alatbesar.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "alatbesar_grid_pendayagunaan",
                    edit : Alatbesar.Action.pendayagunaanEdit,
                    add : Alatbesar.Action.pendayagunaanAdd,
                    remove : Alatbesar.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Alatbesar.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _alatbesarPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_alatbesarPendayagunaanGrid, 'alatbesar-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Alatbesar.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('alatbesar_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Alatbesar.Action.pemindahanList = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Alatbesar.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Alatbesar.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Alatbesar.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Alatbesar.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "alatbesar_grid_pemindahan",
                    edit : Alatbesar.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Alatbesar.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _alatbesarMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_alatbesarMutasiGrid, 'alatbesar-pemindahan', 'Pemindahan');
            }
        };
        
         Alatbesar.Action.penghapusanDetail = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'alatbesar-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Alatbesar.Action.detail_perencanaan = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                Ext.Ajax.request({
                    url: BASE_URL + 'perencanaan/getByID/',
                    params: {
                        id_perencanaan: 1
                    },
                    success: function(resp)
                    {
                        var form = Form.pengadaan(BASE_URL + 'Perencanaan/modifyPerencanaan', resp.responseText);
                        Tab.addToForm(form, 'alatbesar-perencanaan', 'Simak Perencanaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };


        Alatbesar.Action.detail_pengadaan = function() {

            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'alatbesar-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        Alatbesar.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('alatbesar_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Alatbesar.Form.createPemeliharaan(Alatbesar.dataStorePemeliharaan, dataForm, true);
//                Tab.addToForm(form, 'alatbesar-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
                Alatbesar.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:dataForm.id}});
            }
        };

        Alatbesar.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('alatbesar_grid_pemeliharaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Alatbesar.URL.removePemeliharaan, Alatbesar.dataStorePemeliharaan);
            }
        };


        Alatbesar.Action.pemeliharaanAdd = function()
        {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Alatbesar.Form.createPemeliharaan(Alatbesar.dataStorePemeliharaan, dataForm, false);
//            Tab.addToForm(form, 'alatbesar-add-pemeliharaan', 'Add Pemeliharaan');
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };

        Alatbesar.Action.pemeliharaanList = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Alatbesar.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Alatbesar.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Alatbesar.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Alatbesar.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "alatbesar_grid_pemeliharaan",
                    add : Alatbesar.Action.pemeliharaanAdd,
                    remove : Alatbesar.Action.pemeliharaanRemove,
                    edit : Alatbesar.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: Alatbesar.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _alatbesarPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_alatbesarPemeliharaanGrid, 'alatbesar-pemeliharaan', 'Pemeliharaan');
            }
        };

        Alatbesar.Action.add = function() {
            var _form = Alatbesar.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Peralatan');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Alatbesar.Action.edit = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Peralatan');
                    Modal.assetEdit.add(Region.createSidePanel(Alatbesar.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }
                var _form = Alatbesar.Form.create(data, true);
                Tab.addToForm(_form, 'alatbesar-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Alatbesar.Action.remove = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            if (selected.length > 0)
            {
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
                Modal.deleteAlert(arrayDeleted, Alatbesar.URL.remove, Alatbesar.Data);
            }
        };

        Alatbesar.Action.print = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Alatbesar.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Alatbesar_Model";
            var title = "Alat Besar";
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

            var my_tb = document.createElement('INPUT');
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

	Alatbesar.Action.printpdf = function() {
            var selected = Alatbesar.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_alatbesar/cetak/' + selectedData, 'Cetak Pengelolaan Asset Alat Besar');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_Alatbesar',
                title: 'DAFTAR ASSET PERALATAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
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
                    {header: 'No KIB', dataIndex: 'no_kib', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Merk', dataIndex: 'merk', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Type', dataIndex: 'type', width: 50, groupable: false, filter: {type: 'string'}},
                    {header: 'Pabrik', dataIndex: 'pabrik', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Rakit', dataIndex: 'thn_rakit', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Buat', dataIndex: 'thn_buat', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Negara', dataIndex: 'negara', width: 120, hidden: true, filter: {type: 'string'}},
                    {header: 'Kapasitas', dataIndex: 'kapasitas', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sis Opr', dataIndex: 'sis_opr', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sis Dingin', dataIndex: 'sis_dingin', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sis Bakar', dataIndex: 'sis_bakar', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Duk Alat', dataIndex: 'duk_alat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Pwr Train', dataIndex: 'pwr_train', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Mesin', dataIndex: 'no_mesin', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Rangka', dataIndex: 'no_rangka', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'lengkap1', dataIndex: 'lengkap1', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'lengkap2', dataIndex: 'lengkap2', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'lengkap3', dataIndex: 'lengkap3', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis Trn', dataIndex: 'jns_trn', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 150, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Prl', dataIndex: 'tgl_prl', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Rph Asset', dataIndex: 'rph_aset', width: 120, hidden: false, filter: {type: 'numeric'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Unit Pmk', dataIndex: 'unit_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat Pmk', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Rph Wajar', dataIndex: 'rphwajar', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Cad1', dataIndex: 'cad1', width: 90, hidden: true, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Alatbesar.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_Alatbesar'
            },
            toolbar: {
                id: 'toolbar_alatbesar',
                add: {
                    id: 'button_add_Alatbesar',
                    action: Alatbesar.Action.add
                },
                edit: {
                    id: 'button_edit_Alatbesar',
                    action: Alatbesar.Action.edit
                },
                remove: {
                    id: 'button_remove_Alatbesar',
                    action: Alatbesar.Action.remove
                },
                print: {
                    id: 'button_pring_Alatbesar',
                    action: Alatbesar.Action.print
                }
            }
        };

        Alatbesar.Grid.grid = Grid.inventarisGrid(setting, Alatbesar.Data);

        var new_tabpanel_Asset = {
            id: 'alatbesar_panel', title: 'Peralatan', iconCls: 'icon-alatbesar_Alatbesar', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAsetPeralatan(Alatbesar.Data,'alatbesar','3'),Alatbesar.Grid.grid]
        };

<?php

} else {
    echo "var new_tabpanel_MD = 'GAGAL';";
}
?>