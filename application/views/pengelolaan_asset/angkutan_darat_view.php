<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_AngkutanDarat = null;

        Ext.namespace('AngkutanDarat', 'AngkutanDarat.reader', 'AngkutanDarat.proxy', 'AngkutanDarat.Data', 'AngkutanDarat.Grid', 'AngkutanDarat.Window',
                'AngkutanDarat.Form', 'AngkutanDarat.Action', 'AngkutanDarat.URL');
        
        AngkutanDarat.dataStorePemeliharaanParts = new Ext.create('Ext.data.Store', {
            model: MAngkutanDaratPerlengkapan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPartsAngkutanDarat',
                create: BASE_URL + 'pemeliharaan_part/createPemeliharaanPartsAngkutanDarat',
                update: BASE_URL + 'pemeliharaan_part/updatePemeliharaanPartsAngkutanDarat',
                destroy: BASE_URL + 'pemeliharaan_part/destroyPemeliharaanPartsAngkutanDarat'
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
        
        AngkutanDarat.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanDarat.dataStoreDetailPenggunaanAngkutan = new Ext.create('Ext.data.Store', {
            model: MDetailPenggunaanAngkutan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_angkutan_detail_penggunaan/getSpecificDetailPenggunaanAngkutan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
//        
//        AngkutanDarat.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
//            model: MPemeliharaanPart, autoLoad: false, noCache: false,
//            proxy: new Ext.data.AjaxProxy({
//                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
//                reader: new Ext.data.JsonReader({
//                    root: 'results', totalProperty: 'total', idProperty: 'id'})
//            })
//        });
        
        AngkutanDarat.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanDarat.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanDarat.dataStorePerlengkapanAngkutanDarat = new Ext.create('Ext.data.Store', {
            model: MAngkutanDaratPerlengkapan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_angkutan_darat/getSpecificPerlengkapanAngkutanDarat', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanDarat.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        AngkutanDarat.URL = {
            read: BASE_URL + 'asset_angkutan_darat/getAllData',
            createUpdate: BASE_URL + 'asset_angkutan_darat/modifyAngkutanDarat',
            remove: BASE_URL + 'asset_angkutan_darat/deleteAngkutanDarat',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan_Darat/modifyPemeliharaanDarat',
            removePemeliharaan: BASE_URL + 'Pemeliharaan_Darat/deletePemeliharaanDarat',
            createUpdatePerlengkapanAngkutanDarat: BASE_URL + 'asset_angkutan_darat/modifyPerlengkapanAngkutanDarat',
            removePerlengkapanAngkutanDarat: BASE_URL + 'asset_angkutan_darat/deletePerlengkapanAngkutanDarat',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
            createUpdateDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/modifyDetailPenggunaanAngkutan',
            removeDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/deleteDetailPenggunaanAngkutan',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'
            
        };

        AngkutanDarat.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_AngkutanDarat', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        AngkutanDarat.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_AngkutanDarat',
            url: AngkutanDarat.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: AngkutanDarat.reader,
            timeout: 600000,
            afterRequest: function(request, success) {
                //Params_M_AngkutanDarat = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    AngkutanDarat.Data.clearFilter();
//                    AngkutanDarat.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                    var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    AngkutanDarat.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                }
            }
        });

        AngkutanDarat.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_AngkutanDarat', storeId: 'DataAngkutanDarat', model: 'MAngkutanDarat', pageSize: 50, noCache: false, autoLoad: true,
            proxy: AngkutanDarat.proxy, groupField: 'tipe'
        });
        
        AngkutanDarat.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-details');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-pengadaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-penghapusan');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-pemindahan');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanDarat-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanDarat.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        AngkutanDarat.Action.printpdf();
                },
                pengelolaan: function(){
                        var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                        var tabpanels = _tab.getComponent('angkutanDarat-pengelolaan');
                        if (tabpanels === undefined)
                        {
                            AngkutanDarat.Action.pengelolaanList();
                        }
                   },
            };

            return actions;
        };
        
        AngkutanDarat.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanDarat.URL.createUpdatePengelolaan,
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
        
        AngkutanDarat.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanDarat.Form.createPengelolaan(AngkutanDarat.dataStorePengelolaan, dataForm, true);
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

        AngkutanDarat.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.removePengelolaan, AngkutanDarat.dataStorePengelolaan);
            }
        };


        AngkutanDarat.Action.pengelolaanAdd = function()
        {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = AngkutanDarat.Form.createPengelolaan(AngkutanDarat.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        AngkutanDarat.Action.pengelolaanList = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanDarat.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanDarat.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanDarat.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanDarat.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanDarat_grid_pengelolaan",
                    edit : AngkutanDarat.Action.pengelolaanEdit,
                    add : AngkutanDarat.Action.pengelolaanAdd,
                    remove : AngkutanDarat.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanDarat.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanDaratPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_angkutanDaratPendayagunaanGrid, 'angkutanDarat-pengelolaan', 'Pengelolaan');
            }
        };
        
        AngkutanDarat.addPerlengkapan = function()
        {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanDarat.URL.createUpdatePerlengkapanAngkutanDarat, AngkutanDarat.dataStorePerlengkapanAngkutanDarat, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat(data.id));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                    Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1}});
                
            }
        };
        
        AngkutanDarat.editPerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanDarat_perlengkapan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanDarat.URL.createUpdatePerlengkapanAngkutanDarat, AngkutanDarat.dataStorePerlengkapanAngkutanDarat, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat(data.id));
                    
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
                
        }};
        
        AngkutanDarat.removePerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanDarat_perlengkapan').getSelectionModel().getSelection();
           if(selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id,
                        id_asset_perlengkapan: obj.data.id_asset_perlengkapan
                    };
                    arrayDeleted.push(data);
                });
            }
            Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.removePerlengkapanAngkutanDarat,AngkutanDarat.dataStorePerlengkapanAngkutanDarat);
        };
        
         AngkutanDarat.addDetailPenggunaan = function()
        {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                }
                    var form = Form.detailPenggunaanAngkutan(AngkutanDarat.URL.createUpdateDetailPenggunaanAngkutan, AngkutanDarat.dataStoreDetailPenggunaanAngkutan, false,'darat');
                    form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id,'darat'));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
            }
        };
        
        AngkutanDarat.editDetailPenggunaan = function()
        {
            var selected = Ext.getCmp('grid_angkutanDarat_detail_penggunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Penggunaan');
                }
                    var form = Form.detailPenggunaanAngkutan(AngkutanDarat.URL.createUpdateDetailPenggunaanAngkutan, AngkutanDarat.dataStoreDetailPenggunaanAngkutan, true,'darat');
                    form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id,'darat'));
                    
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
                
        }};
        
        AngkutanDarat.removeDetailPenggunaan = function()
        {
            var selected = Ext.getCmp('grid_angkutanDarat_detail_penggunaan').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    id_ext_asset:obj.data.id_ext_asset,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
           Modal.deleteAlertDetailPenggunaanAngkutan(arrayDeleted, AngkutanDarat.URL.removeDetailPenggunaanAngkutan,AngkutanDarat.dataStoreDetailPenggunaanAngkutan,'darat');
            
                    
        };
        

        AngkutanDarat.Form.create = function(data, edit) {
           var setting_grid_detail_penggunaan = {
                id:'grid_angkutanDarat_detail_penggunaan',
                toolbar:{
                    add: AngkutanDarat.addDetailPenggunaan,
                    edit: AngkutanDarat.editDetailPenggunaan,
                    remove: AngkutanDarat.removeDetailPenggunaan
                },
                dataStore:AngkutanDarat.dataStoreDetailPenggunaanAngkutan,
            };
        
            var setting_grid_perlengkapan = {
                id:'grid_angkutanDarat_perlengkapan',
                toolbar:{
                    add: AngkutanDarat.addPerlengkapan,
                    edit: AngkutanDarat.editPerlengkapan,
                    remove: AngkutanDarat.removePerlengkapan
                },
                dataStore:AngkutanDarat.dataStorePerlengkapanAngkutanDarat
            };
           
            var form = Form.asset(AngkutanDarat.URL.createUpdate, AngkutanDarat.Data, edit, true);
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
                        Form.Component.detailPenggunaanAngkutan(setting_grid_detail_penggunaan,edit),
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
                        Form.Component.tambahanAngkutanDarat(setting_grid_perlengkapan,edit),
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
                $.ajax({
                       url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       data:{tipe_angkutan:'darat',id_ext_asset:data.id},
                       success:function(response, status){
                        if(response.status == 'success')
                        {
                            data.total_detail_penggunaan_angkutan = response.total + ' Km';
                        }
                           
                       }
                    });
                    
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
                presetData.kd_bid = '02';
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

        AngkutanDarat.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanDarat.URL.createUpdatePemeliharaan,
                data: data,
                isEditing: edit,
                isBangunan: false,
                tipe_angkutan:'darat',
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
                id:'grid_angkutanDarat_pemeliharaan_part',
                toolbar:{
                    add: AngkutanDarat.addPemeliharaanPart,
                    edit: AngkutanDarat.editPemeliharaanPart,
                    remove: AngkutanDarat.removePemeliharaanPart
                },
                dataStore:AngkutanDarat.dataStorePemeliharaanParts
            };

            var form = Form.pemeliharaanInAssetWithParts(setting,setting_grid_pemeliharaan_part);

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
        
        AngkutanDarat.addPemeliharaanPart = function(){
                
//                var id_pemeliharaan = Ext.getCmp('hidden_identifier_id_pemeliharaan').value;
//                if(id_pemeliharaan != null && id_pemeliharaan != undefined)
//                {
//                    if (Modal.assetSecondaryWindow.items.length === 0)
//                    {
//                        Modal.assetSecondaryWindow.setTitle('Tambah Part');
//                    }
//                        var form = Form.pemeliharaanPart(AngkutanDarat.URL.createUpdatePemeliharaanPart, AngkutanDarat.dataStorePemeliharaanPart, false);
//                        form.insert(0, Form.Component.dataPemeliharaanPart(id_pemeliharaan));
//                        form.insert(1, Form.Component.inventoryPerlengkapan(true));
//                        Modal.assetSecondaryWindow.add(form);
//                        Modal.assetSecondaryWindow.show();
//                }
            if (Modal.assetTertiaryWindow.items.length === 0)
                {
                    Modal.assetTertiaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.tertiaryWindowAsset(AngkutanDarat.dataStorePemeliharaanParts,'add');
//                    form.insert(0, Form.Component.dataPemeliharaanParts());
//                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat());
                    Modal.assetTertiaryWindow.add(form);
                    Modal.assetTertiaryWindow.show();
                
                
        };
        
        AngkutanDarat.editPemeliharaanPart = function(){
//            var selected = Ext.getCmp('grid_angkutanDarat_pemeliharaan_part').getSelectionModel().getSelection();
//            if (selected.length === 1)
//            {
//               
//                var data = selected[0].data;
//                
//                if (Modal.assetSecondaryWindow.items.length === 0)
//                {
//                    Modal.assetSecondaryWindow.setTitle('Edit Part');
//                }
//                    var form = Form.pemeliharaanPart(AngkutanDarat.URL.createUpdatePemeliharaanPart, AngkutanDarat.dataStorePemeliharaanPart, false);
//                    form.insert(0, Form.Component.dataPemeliharaanPart(data.id_pemeliharaan,true));
//                    form.insert(1, Form.Component.inventoryPerlengkapan(true));
//                    
//                    if (data !== null)
//                    {
//                        Ext.Object.each(data,function(key,value,myself){
//                            if(data[key] == '0000-00-00')
//                            {
//                                data[key] = '';
//                            }
//                        });
//                         form.getForm().setValues(data);
//                    }
//                    Modal.assetSecondaryWindow.add(form);
//                    Modal.assetSecondaryWindow.show();
//                
//            }
            var grid = Ext.getCmp('grid_angkutanDarat_pemeliharaan_part');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);
                
                
                if (Modal.assetTertiaryWindow.items.length === 0)
                {
                    Modal.assetTertiaryWindow.setTitle('Edit Part');
                }
                    var form = Form.tertiaryWindowAsset(AngkutanDarat.dataStorePemeliharaanParts, 'edit',storeIndex);
//                    form.insert(0, Form.Component.dataPemeliharaanParts(true));
//                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat('',true));
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
        
        AngkutanDarat.removePemeliharaanPart = function(){
//            var selected = Ext.getCmp('grid_angkutanDarat_pemeliharaan_part').getSelectionModel().getSelection();
//            var arrayDeleted = [];
//            _.each(selected, function(obj) {
//                var data = {
//                    id: obj.data.id,
//                    id_penyimpanan: obj.data.id_penyimpanan,
//                    qty_pemeliharaan:obj.data.qty_pemeliharaan,
//                };
//                arrayDeleted.push(data);
//            });
//            console.log(arrayDeleted);
//            Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.removePemeliharaanPart, AngkutanDarat.dataStorePemeliharaanPart);
            var grid = Ext.getCmp('grid_angkutanDarat_pemeliharaan_part');
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


        
        
        AngkutanDarat.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanDarat.URL.createUpdatePendayagunaan,
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
        
        AngkutanDarat.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanDarat.Form.createPendayagunaan(AngkutanDarat.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();

            }
        };

        AngkutanDarat.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.removePendayagunaan, AngkutanDarat.dataStorePendayagunaan);
            }
        };


        AngkutanDarat.Action.pendayagunaanAdd = function()
        {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = AngkutanDarat.Form.createPendayagunaan(AngkutanDarat.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };
        
        AngkutanDarat.Action.pendayagunaanList = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanDarat.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanDarat.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanDarat.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanDarat.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanDarat_grid_pendayagunaan",
                    edit : AngkutanDarat.Action.pendayagunaanEdit,
                    add : AngkutanDarat.Action.pendayagunaanAdd,
                    remove : AngkutanDarat.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanDarat.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanDaratPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_angkutanDaratPendayagunaanGrid, 'angkutanDarat-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        AngkutanDarat.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('angkutanDarat_grid_pemindahan').getSelectionModel().getSelection();
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
        
        AngkutanDarat.Action.pemindahanList = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanDarat.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanDarat.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanDarat.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanDarat.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanDarat_grid_pemindahan",
                    edit : AngkutanDarat.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanDarat.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanDaratMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_angkutanDaratMutasiGrid, 'angkutanDarat-pemindahan', 'Pemindahan');
            }
        };
        
         AngkutanDarat.Action.penghapusanDetail = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'angkutanDarat-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        AngkutanDarat.Action.detail_pengadaan = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'angkutanDarat-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        AngkutanDarat.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var id_ext_asset = 0;
                $.ajax({
                       url:BASE_URL + 'asset_angkutan_darat/getIdExtAsset',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       data:{kd_brg:dataForm.kd_brg, kd_lokasi:dataForm.kd_lokasi, no_aset:dataForm.no_aset},
                       success:function(response, status){
                        if(status == 'success')
                        {
                            id_ext_asset = response.idExt;
                            AngkutanDarat.dataStorePemeliharaanParts.changeParams({params:{id_ext_asset:id_ext_asset}});
                            AngkutanDarat.dataStorePemeliharaanParts.removed = [];
                        }     
                       }
                    });
                    
                $.ajax({
                    url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                    type: "POST",
                    dataType:'json',
                    async:false,
                    data:{tipe_angkutan:'darat',id_ext_asset:id_ext_asset},
                    success:function(response, status){
                     if(response.status == 'success')
                     {
                         dataForm.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                     }

                    }
                 });
                var form = AngkutanDarat.Form.createPemeliharaan(AngkutanDarat.dataStorePemeliharaan, dataForm, true);
//                Tab.addToForm(form, 'angkutanDarat-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                AngkutanDarat.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:dataForm.id}});
            }
        };

        AngkutanDarat.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('angkutanDarat_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.removePemeliharaan, AngkutanDarat.dataStorePemeliharaan);
            }
        };


        AngkutanDarat.Action.pemeliharaanAdd = function()
        {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                id_ext_asset: data.id
            };
                $.ajax({
                    url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                    type: "POST",
                    dataType:'json',
                    async:false,
                    data:{tipe_angkutan:'darat',id_ext_asset:dataForm.id_ext_asset},
                    success:function(response, status){
                     if(response.status == 'success')
                     {
                         data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                     }

                    }
                 });
            var form = AngkutanDarat.Form.createPemeliharaan(AngkutanDarat.dataStorePemeliharaan, dataForm, false);
//            Tab.addToForm(form, 'angkutanDarat-add-pemeliharaan', 'Add Pemeliharaan');
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
            }
            form.getForm().setValues({pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini:data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini})
            AngkutanDarat.dataStorePemeliharaanParts.changeParams({params:{id_ext_asset:dataForm.id_ext_asset}});
            AngkutanDarat.dataStorePemeliharaanParts.removed = [];
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };

        AngkutanDarat.Action.pemeliharaanList = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanDarat.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanDarat.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanDarat.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanDarat.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanDarat_grid_pemeliharaan",
                    add : AngkutanDarat.Action.pemeliharaanAdd,
                    remove : AngkutanDarat.Action.pemeliharaanRemove,
                    edit : AngkutanDarat.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanDarat.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _angkutanDaratPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_angkutanDaratPemeliharaanGrid, 'angkutanDarat-pemeliharaan', 'Pemeliharaan');
            }
        };

        AngkutanDarat.Action.add = function() {
            var _form = AngkutanDarat.Form.create(null, false);
            Modal.assetCreate.add(_form);
            Modal.assetCreate.setTitle('Create Angkutan Darat');
            Modal.assetCreate.show();
        };

        AngkutanDarat.Action.edit = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            var flagExtAsset = false;
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Angkutan Darat');
                    Modal.assetEdit.add(Region.createSidePanel(AngkutanDarat.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }
                
                if(data.id == null || data.id == undefined)
                {   
                    $.ajax({
                       url:BASE_URL + 'asset_angkutan_darat/requestIdExtAsset',
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
                    var _form = AngkutanDarat.Form.create(data, true);
                    Tab.addToForm(_form, 'angkutanDarat-details', 'Simak Details');
                    Modal.assetEdit.show();
                    AngkutanDarat.dataStorePerlengkapanAngkutanDarat.changeParams({params:{open:'1',id_ext_asset:data.id}});
                    AngkutanDarat.dataStoreDetailPenggunaanAngkutan.changeParams({params:{open:'1',id_ext_asset:data.id}});
                }
            }
        };

        AngkutanDarat.Action.remove = function() {
            console.log('remove AngkutanDarat');
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, AngkutanDarat.URL.remove, AngkutanDarat.Data);
        };

        AngkutanDarat.Action.print = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = AngkutanDarat.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Angkutan_Darat_Model";
            var title = "Angkutan Darat";
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

		AngkutanDarat.Action.printpdf = function() {
            var selected = AngkutanDarat.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_angkutan_darat/cetak/' + selectedData, 'Cetak Pengelolaan Asset Angkutan Darat');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_AngkutanDarat',
                title: 'DAFTAR ASSET ANGKUTAN DARAT',
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
                                    var kodeWilayah = AngkutanDarat.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_AngkutanDarat'
            },
            toolbar: {
                id: 'toolbar_angkutanDarat',
                add: {
                    id: 'button_add_AngkutanDarat',
                    action: AngkutanDarat.Action.add
                },
                edit: {
                    id: 'button_edit_AngkutanDarat',
                    action: AngkutanDarat.Action.edit
                },
                remove: {
                    id: 'button_remove_AngkutanDarat',
                    action: AngkutanDarat.Action.remove
                },
                print: {
                    id: 'button_pring_AngkutanDarat',
                    action: AngkutanDarat.Action.print
                }
            }
        };

        AngkutanDarat.Grid.grid = Grid.inventarisGrid(setting, AngkutanDarat.Data);


        var new_tabpanel_Asset = {
            id: 'angkutan_darat_panel', title: 'Angkutan Darat', iconCls: 'icon-tanah_AngkutanDarat', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(AngkutanDarat.Data,'angkutanDarat','3','02'),AngkutanDarat.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>