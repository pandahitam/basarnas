<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_AngkutanDarat = null;

        Ext.namespace('AngkutanDarat', 'AngkutanDarat.reader', 'AngkutanDarat.proxy', 'AngkutanDarat.Data', 'AngkutanDarat.Grid', 'AngkutanDarat.Window',
                'AngkutanDarat.Form', 'AngkutanDarat.Action', 'AngkutanDarat.URL');
        
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
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan'
        };

        AngkutanDarat.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_AngkutanDarat', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        AngkutanDarat.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_AngkutanDarat',
            url: AngkutanDarat.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: AngkutanDarat.reader,
            afterRequest: function(request, success) {
                //Params_M_AngkutanDarat = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null ||paramsUnker != undefined)
                {
                    AngkutanDarat.Data.clearFilter();
                    AngkutanDarat.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                }
            }
        });

        AngkutanDarat.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_AngkutanDarat', storeId: 'DataAngkutanDarat', model: 'MAngkutanDarat', pageSize: 50, noCache: false, autoLoad: true,
            proxy: AngkutanDarat.proxy, groupField: 'tipe'
        });

        AngkutanDarat.Form.create = function(data, edit) {
           var form = Form.asset(AngkutanDarat.URL.createUpdate, AngkutanDarat.Data, edit, true);
             var tab = Tab.formTabs();
            tab.add({
                title: 'Utama',
                closable: true,
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
                closable: true,
                border: false,
                layout:'fit',
                deferredRender: false,
                bodyStyle:{background:'none'},
                items: [
                        Form.Component.tambahanAngkutanDarat(),
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

        AngkutanDarat.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: AngkutanDarat.URL.createUpdatePemeliharaan,
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
            };

            return actions;
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

                        if (jsonData !== null || jsonData !== undefined)
                        {
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
                        if (jsonData !== null || jsonData !== undefined)
                        {
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
                var form = AngkutanDarat.Form.createPemeliharaan(AngkutanDarat.dataStorePemeliharaan, dataForm, true);
                Tab.addToForm(form, 'angkutanDarat-edit-pemeliharaan', 'Edit Pemeliharaan');
                Modal.assetEdit.show();
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
                console.log(arrayDeleted);
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
                no_aset: data.no_aset
            };

            var form = AngkutanDarat.Form.createPemeliharaan(AngkutanDarat.dataStorePemeliharaan, dataForm, false);
            Tab.addToForm(form, 'angkutanDarat-add-pemeliharaan', 'Add Pemeliharaan');
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

                var _form = AngkutanDarat.Form.create(data, true);
                Tab.addToForm(_form, 'angkutanDarat-details', 'Simak Details');
                Modal.assetEdit.show();

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
                                    var kodeWilayah = AngkutanDarat.Data.getAt(rowindex).data.kd_lokasi.substring(5, 9);
                                    //console.log(kodeWilayah);
                                    Ext.getCmp('Content_Body_Tabs').setActiveTab('map_asset');
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
            id: 'angkutanDarat_darat_panel', title: 'Angkutan Darat', iconCls: 'icon-tanah_AngkutanDarat', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(AngkutanDarat.Data,'angkutanDarat'),AngkutanDarat.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>