<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Perlengkapan = null;

        Ext.namespace('Perlengkapan', 'Perlengkapan.reader', 'Perlengkapan.proxy', 'Perlengkapan.Data', 'Perlengkapan.Grid', 'Perlengkapan.Window', 'Perlengkapan.Form', 'Perlengkapan.Action',
                'Perlengkapan.URL');
        
        Perlengkapan.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Perlengkapan.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: 'MPemeliharaanPerlengkapan', autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Perlengkapan/getSpecificPemeliharaanPerlengkapan', actionMethods: {read: 'POST'}
            })
        });

        Perlengkapan.URL = {
            read: BASE_URL + 'asset_perlengkapan/getAllData',
            createUpdate: BASE_URL + 'asset_perlengkapan/modifyPerlengkapan',
            remove: BASE_URL + 'asset_perlengkapan/deletePerlengkapan',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan_Perlengkapan/modifyPemeliharaanPerlengkapan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan_Perlengkapan/deletePemeliharaanPerlengkapan',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan'

        };

        Perlengkapan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Perlengkapan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Perlengkapan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Perlengkapan',
            url: Perlengkapan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Perlengkapan.reader,
            afterRequest: function(request, success) {
                Params_M_Perlengkapan = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null ||paramsUnker != undefined)
                {
                    Perlengkapan.Data.clearFilter();
                    Perlengkapan.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                }
            }
        });

        Perlengkapan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Perlengkapan', storeId: 'DataPerlengkapan', model: 'MPerlengkapan', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Perlengkapan.proxy, groupField: 'tipe'
        });

        Perlengkapan.Form.create = function(data, edit) {
            var form = Form.asset(Perlengkapan.URL.createUpdate, Perlengkapan.Data, edit);
            
            form.insert(0, Form.Component.unit(edit));
//            form.insert(3, Form.Component.address());
//            form.insert(4, Form.Component.perlengkapan());
//            form.insert(5, Form.Component.tambahanPerlengkapanPerlengkapan());
            form.insert(1, Form.Component.klasifikasiAset(edit))
            form.insert(2, Form.Component.perlengkapan(edit));
            form.insert(3, Form.Component.fileUpload(edit));
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        Perlengkapan.Form.createPemeliharaan = function(dataGrid,dataForm,edit) {
            var setting = {
                url: Perlengkapan.URL.createUpdatePemeliharaan,
                data: dataGrid,
                isEditing: edit,
                isPerlengkapan: true,
                addBtn: {
                    isHidden: true,
                    text: '',
                    fn: null
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

        Perlengkapan.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-details');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pengadaanEdit();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.penghapusanDetail();
                    }
                },
               
                pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('perlengkapan-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Perlengkapan.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        Perlengkapan.Action.printpdf();
                },
            };

            return actions;
        };
        
        Perlengkapan.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Perlengkapan.URL.createUpdatePendayagunaan,
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
        
        Perlengkapan.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPendayagunaan(Perlengkapan.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePendayagunaan, Perlengkapan.dataStorePendayagunaan);
            }
        };


        Perlengkapan.Action.pendayagunaanAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Perlengkapan.Form.createPendayagunaan(Perlengkapan.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'perlengkapan-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Perlengkapan.Action.pendayagunaanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "perlengkapan_grid_pendayagunaan",
                    edit : Perlengkapan.Action.pendayagunaanEdit,
                    add : Perlengkapan.Action.pendayagunaanAdd,
                    remove : Perlengkapan.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _perlengkapanPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_perlengkapanPendayagunaanGrid, 'perlengkapan-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Perlengkapan.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('perlengkapan_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Perlengkapan.Action.pemindahanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "perlengkapan_grid_pemindahan",
                    edit : Perlengkapan.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _perlengkapanMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_perlengkapanMutasiGrid, 'perlengkapan-pemindahan', 'Pemindahan');
            }
        };
        
         Perlengkapan.Action.penghapusanDetail = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'perlengkapan-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Perlengkapan.Action.pengadaanEdit = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'perlengkapan-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

        Perlengkapan.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Perlengkapan.Form.createPemeliharaan(Perlengkapan.dataStorePemeliharaan, dataForm, true)
                Tab.addToForm(form, 'perlengkapan-edit-pemeliharaan', 'Edit Pemeliharaan');
            }
        };

        Perlengkapan.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('perlengkapan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                Modal.deleteAlert(arrayDeleted, Perlengkapan.URL.removePemeliharaan, Perlengkapan.dataStorePemeliharaan);
            }
        };


        Perlengkapan.Action.pemeliharaanAdd = function()
        {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            var form = Perlengkapan.Form.createPemeliharaan(Perlengkapan.dataStorePemeliharaan, dataForm, false)
            Tab.addToForm(form, 'perlengkapan-add-pemeliharaan', 'Add Pemeliharaan');
        };


        Perlengkapan.Action.pemeliharaanList = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Perlengkapan.dataStorePemeliharaan.load();
                var toolbarIDs = {};
                toolbarIDs.idGrid = "perlengkapan_grid_pemeliharaan";
                toolbarIDs.add = Perlengkapan.Action.pemeliharaanAdd;
                toolbarIDs.remove = Perlengkapan.Action.pemeliharaanRemove;
                toolbarIDs.edit = Perlengkapan.Action.pemeliharaanEdit;
                var setting = {
                    data: data,
                    dataStore: Perlengkapan.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isPerlengkapan: true
                };
                var _perlengkapanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_perlengkapanPemeliharaanGrid, 'perlengkapan-pemeliharaan', 'Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.add = function() {
            var _form = Perlengkapan.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Perlengkapan');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Perlengkapan.Action.edit = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length <= 1)
                {
                    Modal.assetEdit.setTitle('Edit Perlengkapan');
                    Modal.assetEdit.insert(0, Region.createSidePanel(Perlengkapan.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Perlengkapan.Form.create(data, true);
                Tab.addToForm(_form, 'perlengkapan-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Perlengkapan.Action.remove = function() {
            console.log('remove Perlengkapan');
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
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
//            Asset.Window.createDeleteAlert(arrayDeleted, Perlengkapan.URL.remove, Perlengkapan.Data);
            Modal.deleteAlert(arrayDeleted,Perlengkapan.URL.remove,Perlengkapan.Data);
        };

        Perlengkapan.Action.print = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Perlengkapan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Perlengkapan_Model";
            var title = "Perlengkapan";
            var primaryKeys = "id";

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

		Perlengkapan.Action.printpdf = function() {
            var selected = Perlengkapan.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_perlengkapan/cetak/' + selectedData, 'Cetak Pengelolaan Asset Perlengkapan');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_perlengkapan',
                title: 'DAFTAR ASSET PERLENGKAPAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Serial Number', dataIndex: 'serial_number', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Warehouse', dataIndex: 'warehouse_id', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Ruang', dataIndex: 'ruang_id', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Rak', dataIndex: 'rak_id', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden:true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 90, hidden:true, groupable: false, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Perolehan', dataIndex: 'tanggal_perolehan', hidden: true, width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 150,hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Penggunaan Waktu', dataIndex: 'penggunaan_waktu', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Penggunaan Freq', dataIndex: 'penggunaan_freq', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Waktu', dataIndex: 'unit_waktu', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Freq', dataIndex: 'unit_freq', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'Disimpan', dataIndex: 'disimpan', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Dihapus', dataIndex: 'dihapus', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Image Url', dataIndex: 'image_url', width: 50, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Document Url', dataIndex: 'document_url', width: 50, hidden: true, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_perlengkapan'
            },
            toolbar: {
                id: 'toolbar_perlengkapan',
                add: {
                    id: 'button_add_perlengkapan',
                    action: Perlengkapan.Action.add
                },
                edit: {
                    id: 'button_edit_perlengkapan',
                    action: Perlengkapan.Action.edit
                },
                remove: {
                    id: 'button_remove_perlengkapan',
                    action: Perlengkapan.Action.remove
                },
                print: {
                    id: 'button_pring_perlengkapan',
                    action: Perlengkapan.Action.print
                }
            }
        };

        Perlengkapan.Grid.grid = Grid.inventarisGrid(setting, Perlengkapan.Data);


        var new_tabpanel_Asset = {
            id: 'perlengkapan_panel', title: 'Perlengkapan', iconCls: 'icon-perlengkapan_perlengkapan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAsetPerlengkapan(Perlengkapan.Data,'perlengkapan'),Perlengkapan.Grid.grid]
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>