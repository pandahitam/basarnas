<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_AngkutanLaut = null;

        Ext.namespace('AngkutanLaut', 'AngkutanLaut.reader', 'AngkutanLaut.proxy', 'AngkutanLaut.Data', 'AngkutanLaut.Grid', 'AngkutanLaut.Window',
                'AngkutanLaut.Form', 'AngkutanLaut.Action', 'AngkutanLaut.URL');
        
         AngkutanLaut.dataStorePengelolaan = new Ext.create('Ext.data.Store', {
            model: MPengelolaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pengelolaan/getSpecificPengelolaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStoreDetailPenggunaanAngkutan = new Ext.create('Ext.data.Store', {
            model: MDetailPenggunaanAngkutan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_angkutan_detail_penggunaan/getSpecificDetailPenggunaanAngkutan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStorePerlengkapanAngkutanLaut = new Ext.create('Ext.data.Store', {
            model: MAngkutanLautPerlengkapan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'asset_angkutan_laut/getSpecificPerlengkapanAngkutanLaut', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        AngkutanLaut.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        AngkutanLaut.URL = {
            read: BASE_URL + 'asset_angkutan_laut/getAllData',
            createUpdate: BASE_URL + 'asset_angkutan_laut/modifyAngkutanLaut',
            remove: BASE_URL + 'asset_angkutan_laut/deleteAngkutanLaut',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePerlengkapanAngkutanLaut: BASE_URL + 'asset_angkutan_laut/modifyPerlengkapanAngkutanLaut',
            removePerlengkapanAngkutanLaut: BASE_URL + 'asset_angkutan_laut/deletePerlengkapanAngkutanLaut',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
            createUpdateDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/modifyDetailPenggunaanAngkutan',
            removeDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/deleteDetailPenggunaanAngkutan',
            createUpdatePengelolaan: BASE_URL +'pengelolaan/modifyPengelolaan',
            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'
        };

        AngkutanLaut.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_AngkutanLaut', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        AngkutanLaut.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_AngkutanLaut',
            url: AngkutanLaut.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: AngkutanLaut.reader,
            timeout:600000,
            afterRequest: function(request, success) {
                //Params_M_AngkutanLaut = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null && paramsUnker != undefined)
                {
//                    AngkutanLaut.Data.clearFilter();
//                    AngkutanLaut.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                    var gridFilterObject = {type:'string',value:paramsUnker,field:'kd_lokasi'};
                    var gridFilter = JSON.stringify(gridFilterObject);
                    AngkutanLaut.Data.changeParams({params:{"gridFilter":'['+gridFilter+']'}})
                }
            }
        });

        AngkutanLaut.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_AngkutanLaut', storeId: 'DataAngkutanLaut', model: 'MAngkutanLaut', pageSize: 50, noCache: false, autoLoad: true,
            proxy: AngkutanLaut.proxy, groupField: 'tipe'
        });
        
        AngkutanLaut.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-details');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-pengadaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.pemeliharaanList();
                    }
                }, 
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-penghapusan');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-pemindahan');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutanLaut-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        AngkutanLaut.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        AngkutanLaut.Action.printpdf();
                },
                pengelolaan: function(){
                      var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                      var tabpanels = _tab.getComponent('angkutanLaut-pengelolaan');
                      if (tabpanels === undefined)
                      {
                          AngkutanLaut.Action.pengelolaanList();
                      }
                 },
            };

            return actions;
        };
        
        AngkutanLaut.Form.createPengelolaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanLaut.URL.createUpdatePengelolaan,
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
        
        AngkutanLaut.Action.pengelolaanEdit = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanLaut.Form.createPengelolaan(AngkutanLaut.dataStorePengelolaan, dataForm, true);
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

        AngkutanLaut.Action.pengelolaanRemove = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pengelolaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.removePengelolaan, AngkutanLaut.dataStorePengelolaan);
            }
        };


        AngkutanLaut.Action.pengelolaanAdd = function()
        {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset,
                nama:data.ur_sskel,
            };

            var form = AngkutanLaut.Form.createPengelolaan(AngkutanLaut.dataStorePengelolaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pengelolaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'tanah-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        AngkutanLaut.Action.pengelolaanList = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanLaut.dataStorePengelolaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanLaut.dataStorePengelolaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanLaut.dataStorePengelolaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanLaut.dataStorePengelolaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanLaut_grid_pengelolaan",
                    edit : AngkutanLaut.Action.pengelolaanEdit,
                    add : AngkutanLaut.Action.pengelolaanAdd,
                    remove : AngkutanLaut.Action.pengelolaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanLaut.dataStorePengelolaan,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanLautPendayagunaanGrid = Grid.pengelolaanGrid(setting);
                Tab.addToForm(_angkutanLautPendayagunaanGrid, 'angkutanLaut-pengelolaan', 'Pengelolaan');
            }
        };
        
        AngkutanLaut.addPerlengkapan = function()
        {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanLaut.URL.createUpdatePerlengkapanAngkutanLaut, AngkutanLaut.dataStorePerlengkapanAngkutanLaut, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanLaut(data.id));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                    Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1}});
                
            }
        };
        
        AngkutanLaut.editPerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanLaut_perlengkapan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Perlengkapan');
                }
                    var form = Form.perlengkapanAngkutan(AngkutanLaut.URL.createUpdatePerlengkapanAngkutanLaut, AngkutanLaut.dataStorePerlengkapanAngkutanLaut, false);
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanLaut(data.id));
                    
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
        
        AngkutanLaut.removePerlengkapan = function()
        {
            var selected = Ext.getCmp('grid_angkutanLaut_perlengkapan').getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.removePerlengkapanAngkutanLaut,AngkutanLaut.dataStorePerlengkapanAngkutanLaut);
        };
        
        AngkutanLaut.addDetailPenggunaan = function()
        {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                }
                    var form = Form.detailPenggunaanAngkutan(AngkutanLaut.URL.createUpdateDetailPenggunaanAngkutan, AngkutanLaut.dataStoreDetailPenggunaanAngkutan, false,'laut');
                    form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id,'laut'));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
            }
        };
        
        AngkutanLaut.editDetailPenggunaan = function()
        {
            var selected = Ext.getCmp('grid_angkutanLaut_detail_penggunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Penggunaan');
                }
                    var form = Form.detailPenggunaanAngkutan(AngkutanLaut.URL.createUpdateDetailPenggunaanAngkutan, AngkutanLaut.dataStoreDetailPenggunaanAngkutan, true,'laut');
                    form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id,'laut'));
                    
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
        
        AngkutanLaut.removeDetailPenggunaan = function()
        {
            var selected = Ext.getCmp('grid_angkutanLaut_detail_penggunaan').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    id_ext_asset:obj.data.id_ext_asset,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
           Modal.deleteAlertDetailPenggunaanAngkutan(arrayDeleted, AngkutanLaut.URL.removeDetailPenggunaanAngkutan,AngkutanLaut.dataStoreDetailPenggunaanAngkutan,'laut');
            
                    
        };
        
        AngkutanLaut.Form.create = function(data, edit) {
        var setting_grid_detail_penggunaan = {
                id:'grid_angkutanLaut_detail_penggunaan',
                toolbar:{
                    add: AngkutanLaut.addDetailPenggunaan,
                    edit: AngkutanLaut.editDetailPenggunaan,
                    remove: AngkutanLaut.removeDetailPenggunaan
                },
                dataStore:AngkutanLaut.dataStoreDetailPenggunaanAngkutan,
            }; 
        
          var setting_grid_perlengkapan = {
                id:'grid_angkutanLaut_perlengkapan',
                toolbar:{
                    add: AngkutanLaut.addPerlengkapan,
                    edit: AngkutanLaut.editPerlengkapan,
                    remove: AngkutanLaut.removePerlengkapan
                },
                dataStore:AngkutanLaut.dataStorePerlengkapanAngkutanLaut
            };
            
           var form = Form.assetAngkutanLaut(AngkutanLaut.URL.createUpdate, AngkutanLaut.Data, edit, true);
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
                layout: 'fit',
//                anchor: '100%',
                deferredRender: false,
//                defaults: {
//                    layout: 'anchor'
//                },
                bodyStyle:{background:'none'},
                items: [
                        Form.Component.tambahanAngkutanLaut(setting_grid_perlengkapan,edit),
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
                       data:{tipe_angkutan:'laut',id_ext_asset:data.id},
                       success:function(response, status){
                        if(response.status == 'success')
                        {
                            data.total_detail_penggunaan_angkutan = response.total + ' Jam';
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

        AngkutanLaut.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanLaut.URL.createUpdatePemeliharaan,
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
                id:'grid_angkutanLaut_pemeliharaan_part',
                toolbar:{
                    add: AngkutanLaut.addPemeliharaanPart,
                    edit: AngkutanLaut.editPemeliharaanPart,
                    remove: AngkutanLaut.removePemeliharaanPart
                },
                dataStore:AngkutanLaut.dataStorePemeliharaanPart
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
        
        AngkutanLaut.addPemeliharaanPart = function(){
                var id_pemeliharaan = Ext.getCmp('hidden_identifier_id_pemeliharaan').value;
                if(id_pemeliharaan != null && id_pemeliharaan != undefined)
                {
                    if (Modal.assetSecondaryWindow.items.length === 0)
                    {
                        Modal.assetSecondaryWindow.setTitle('Tambah Part');
                    }
                        var form = Form.pemeliharaanPart(AngkutanLaut.URL.createUpdatePemeliharaanPart, AngkutanLaut.dataStorePemeliharaanPart, false);
                        form.insert(0, Form.Component.dataPemeliharaanPart(id_pemeliharaan));
                        form.insert(1, Form.Component.inventoryPerlengkapan(true));
                        Modal.assetSecondaryWindow.add(form);
                        Modal.assetSecondaryWindow.show();
                
                }
        };
        
        AngkutanLaut.editPemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_angkutanLaut_pemeliharaan_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.pemeliharaanPart(AngkutanLaut.URL.createUpdatePemeliharaanPart, AngkutanLaut.dataStorePemeliharaanPart, false);
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
        
        AngkutanLaut.removePemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_angkutanLaut_pemeliharaan_part').getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.removePemeliharaanPart, AngkutanLaut.dataStorePemeliharaanPart);
        };

        
        
        AngkutanLaut.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanLaut.URL.createUpdatePendayagunaan,
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
        
        AngkutanLaut.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanLaut.Form.createPendayagunaan(AngkutanLaut.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'angkutanLaut-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        AngkutanLaut.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.removePendayagunaan, AngkutanLaut.dataStorePendayagunaan);
            }
        };


        AngkutanLaut.Action.pendayagunaanAdd = function()
        {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = AngkutanLaut.Form.createPendayagunaan(AngkutanLaut.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'angkutanLaut-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        AngkutanLaut.Action.pendayagunaanList = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanLaut.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanLaut.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanLaut.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanLaut.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanLaut_grid_pendayagunaan",
                    edit : AngkutanLaut.Action.pendayagunaanEdit,
                    add : AngkutanLaut.Action.pendayagunaanAdd,
                    remove : AngkutanLaut.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanLaut.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanLautPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_angkutanLautPendayagunaanGrid, 'angkutanLaut-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        AngkutanLaut.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('angkutanLaut_grid_pemindahan').getSelectionModel().getSelection();
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
        
        AngkutanLaut.Action.pemindahanList = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanLaut.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanLaut.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanLaut.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanLaut.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanLaut_grid_pemindahan",
                    edit : AngkutanLaut.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanLaut.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _angkutanLautMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_angkutanLautMutasiGrid, 'angkutanLaut-pemindahan', 'Pemindahan');
            }
        };
        
         AngkutanLaut.Action.penghapusanDetail = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'angkutanLaut-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        AngkutanLaut.Action.detail_pengadaan = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'angkutanLaut-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        AngkutanLaut.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = AngkutanLaut.Form.createPemeliharaan(AngkutanLaut.dataStorePemeliharaan, dataForm, true);
//                Tab.addToForm(form, 'angkutanLaut-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pemeliharaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
                AngkutanLaut.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:dataForm.id}});
            }
        };

        AngkutanLaut.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('angkutanLaut_grid_pemeliharaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.removePemeliharaan, AngkutanLaut.dataStorePemeliharaan);
            }
        };


        AngkutanLaut.Action.pemeliharaanAdd = function()
        {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = AngkutanLaut.Form.createPemeliharaan(AngkutanLaut.dataStorePemeliharaan, dataForm, false);
//            Tab.addToForm(form, 'angkutanLaut-add-pemeliharaan', 'Add Pemeliharaan');
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
        };

        AngkutanLaut.Action.pemeliharaanList = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                AngkutanLaut.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                AngkutanLaut.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                AngkutanLaut.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                AngkutanLaut.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutanLaut_grid_pemeliharaan",
                    add : AngkutanLaut.Action.pemeliharaanAdd,
                    remove : AngkutanLaut.Action.pemeliharaanRemove,
                    edit : AngkutanLaut.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: AngkutanLaut.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _angkutanLautPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_angkutanLautPemeliharaanGrid, 'angkutanLaut-pemeliharaan', 'Pemeliharaan');
            }
        };

        AngkutanLaut.Action.add = function() {
            var _form = AngkutanLaut.Form.create(null, false);
            Modal.assetCreate.add(_form);
            Modal.assetCreate.setTitle('Create Angkutan Laut');
            Modal.assetCreate.show();
        };

        AngkutanLaut.Action.edit = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                var flagExtAsset = false;
                
                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Angkutan Laut');
                    Modal.assetEdit.add(Region.createSidePanel(AngkutanLaut.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }
                
                if(data.id == null || data.id == undefined)
                {   
                    $.ajax({
                       url:BASE_URL + 'asset_angkutan_laut/requestIdExtAsset',
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
                    var _form = AngkutanLaut.Form.create(data, true);
                    Tab.addToForm(_form, 'angkutanLaut-details', 'Simak Details');
                    Modal.assetEdit.show();
                    AngkutanLaut.dataStorePerlengkapanAngkutanLaut.changeParams({params:{open:'1',id_ext_asset:data.id}});
                    AngkutanLaut.dataStoreDetailPenggunaanAngkutan.changeParams({params:{open:'1',id_ext_asset:data.id}});
                }

            }
        };

        AngkutanLaut.Action.remove = function() {
            console.log('remove AngkutanLaut');
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, AngkutanLaut.URL.remove, AngkutanLaut.Data);
        };

        AngkutanLaut.Action.print = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = AngkutanLaut.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Angkutan_Laut_Model";
            var title = "Angkutan Laut";
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

		AngkutanLaut.Action.printpdf = function() {
            var selected = AngkutanLaut.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_angkutan_laut/cetak/' + selectedData, 'Cetak Pengelolaan Asset Angkutan Laut');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_AngkutanLaut',
                title: 'DAFTAR ASSET ANGKUTAN LAUT',
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
                                    var kodeWilayah = AngkutanLaut.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_AngkutanLaut'
            },
            toolbar: {
                id: 'toolbar_angkutanLaut',
                add: {
                    id: 'button_add_AngkutanLaut',
                    action: AngkutanLaut.Action.add
                },
                edit: {
                    id: 'button_edit_AngkutanLaut',
                    action: AngkutanLaut.Action.edit
                },
                remove: {
                    id: 'button_remove_AngkutanLaut',
                    action: AngkutanLaut.Action.remove
                },
                print: {
                    id: 'button_pring_AngkutanLaut',
                    action: AngkutanLaut.Action.print
                }
            }
        };

        AngkutanLaut.Grid.grid = Grid.inventarisGrid(setting, AngkutanLaut.Data);


        var new_tabpanel_Asset = {
            id: 'angkutan_laut_panel', title: 'Angkutan Laut', iconCls: 'icon-tanah_AngkutanLaut', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(AngkutanLaut.Data,'angkutanLaut','3','02'),AngkutanLaut.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>