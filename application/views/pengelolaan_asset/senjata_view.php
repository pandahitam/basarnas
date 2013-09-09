<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
///////////
        var Params_M_Senjata = null;

        Ext.namespace('Senjata', 'Senjata.reader', 'Senjata.proxy', 'Senjata.Data', 'Senjata.Grid', 'Senjata.Window', 'Senjata.Form', 'Senjata.Action', 'Senjata.URL');
        
        Senjata.dataStorePendayagunaan = new Ext.create('Ext.data.Store', {
            model: MPendayagunaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pendayagunaan/getSpecificPendayagunaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Senjata.dataStoreMutasi = new Ext.create('Ext.data.Store', {
            model: MMutasi, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'mutasi/getSpecificMutasi', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        Senjata.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        Senjata.URL = {
            read: BASE_URL + 'asset_Senjata/getAllData',
            createUpdate: BASE_URL + 'asset_Senjata/modifySenjata',
            remove: BASE_URL + 'asset_Senjata/deleteSenjata',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
            createUpdatePendayagunaan: BASE_URL +'pendayagunaan/modifyPendayagunaan',
            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan'
        };

        Senjata.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Senjata', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Senjata.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Senjata',
            url: Senjata.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Senjata.reader,
            afterRequest: function(request, success) {
                Params_M_Senjata = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null ||paramsUnker != undefined)
                {
                    Senjata.Data.clearFilter();
                    Senjata.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
                }
            }
        });

        Senjata.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Senjata', storeId: 'DataSenjata', model: 'MSenjata', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Senjata.proxy, groupField: 'tipe'
        });

        Senjata.Form.create = function(data, edit) {
            var form = Form.asset(Senjata.URL.createUpdate, Senjata.Data, edit);
            form.insert(0, Form.Component.unit(edit,form));
            form.insert(1, Form.Component.kode(edit));
            form.insert(2, Form.Component.klasifikasiAset(edit))
            form.insert(3, Form.Component.basicAsset(edit));
            form.insert(4, Form.Component.mechanical());
            form.insert(5, Form.Component.senjata());
            form.insert(6, Form.Component.fileUpload());
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        Senjata.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: Senjata.URL.createUpdatePemeliharaan,
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

        Senjata.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-details');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.pemeliharaanList();
                    }
                },
                penghapusan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-penghapusan');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.penghapusanDetail();
                    }
                },
               pemindahan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-pemindahan');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.pemindahanList();
                    }
                },
               pendayagunaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('senjata-pendayagunaan');
                    if (tabpanels === undefined)
                    {
                        Senjata.Action.pendayagunaanList();
                    }
                },
                printPDF: function() {
                        Senjata.Action.printpdf();
                },
            };

            return actions;
        };
        
        Senjata.Form.createPendayagunaan = function(data, dataForm, edit) {
            var setting = {
                url: Senjata.URL.createUpdatePendayagunaan,
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
        
        Senjata.Action.pendayagunaanEdit = function() {
            var selected = Ext.getCmp('senjata_grid_pendayagunaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Senjata.Form.createPendayagunaan(Senjata.dataStorePendayagunaan, dataForm, true);
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Pendayagunaan');
                }
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
//                Tab.addToForm(form, 'senjata-edit-pemeliharaan', 'Edit Pemeliharaan');
//                Modal.assetEdit.show();
            }
        };

        Senjata.Action.pendayagunaanRemove = function() {
            var selected = Ext.getCmp('senjata_grid_pendayagunaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Senjata.URL.removePendayagunaan, Senjata.dataStorePendayagunaan);
            }
        };


        Senjata.Action.pendayagunaanAdd = function()
        {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Senjata.Form.createPendayagunaan(Senjata.dataStorePendayagunaan, dataForm, false);
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Pendayagunaan');
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
//            Tab.addToForm(form, 'senjata-add-pendayagunaan', 'Add Pendayagunaan');
        };
        
        Senjata.Action.pendayagunaanList = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Senjata.dataStorePendayagunaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Senjata.dataStorePendayagunaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Senjata.dataStorePendayagunaan.getProxy().extraParams.no_aset = data.no_aset;
                Senjata.dataStorePendayagunaan.load();
                
                var toolbarIDs = {
                    idGrid : "senjata_grid_pendayagunaan",
                    edit : Senjata.Action.pendayagunaanEdit,
                    add : Senjata.Action.pendayagunaanAdd,
                    remove : Senjata.Action.pendayagunaanRemove,
                };

                var setting = {
                    data: data,
                    dataStore: Senjata.dataStorePendayagunaan,
                    toolbar: toolbarIDs,
                };
                
                var _senjataPendayagunaanGrid = Grid.pendayagunaanGrid(setting);
                Tab.addToForm(_senjataPendayagunaanGrid, 'senjata-pendayagunaan', 'Pendayagunaan');
            }
        };
        
        Senjata.Action.pemindahanEdit = function () {
            var selected = Ext.getCmp('senjata_grid_pemindahan').getSelectionModel().getSelection();
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
        
        Senjata.Action.pemindahanList = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Senjata.dataStoreMutasi.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Senjata.dataStoreMutasi.getProxy().extraParams.kd_brg = data.kd_brg;
                Senjata.dataStoreMutasi.getProxy().extraParams.no_aset = data.no_aset;
                Senjata.dataStoreMutasi.load();
                
                var toolbarIDs = {
                    idGrid : "senjata_grid_pemindahan",
                    edit : Senjata.Action.pemindahanEdit,
                    add : false,
                    remove : false,
                };

                var setting = {
                    data: data,
                    dataStore: Senjata.dataStoreMutasi,
                    toolbar: toolbarIDs,
                };
                
                var _senjataMutasiGrid = Grid.mutasiGrid(setting);
                Tab.addToForm(_senjataMutasiGrid, 'senjata-pemindahan', 'Pemindahan');
            }
        };
        
         Senjata.Action.penghapusanDetail = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'senjata-penghapusan', 'Penghapusan');
                        Modal.assetEdit.show();
                        
                    },
                    callback: function()
                    {
                        Ext.getCmp('layout-body').body.unmask();
                    },
                });
            }
        };

        Senjata.Action.detail_pengadaan = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
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
                        Tab.addToForm(form, 'senjata-pengadaan', 'Pengadaan');
                        Modal.assetEdit.show();
                    }
                });
            }
        };

       Senjata.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('senjata_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Senjata.Form.createPemeliharaan(Senjata.dataStorePemeliharaan, dataForm, true);
                Tab.addToForm(form, 'senjata-edit-pemeliharaan', 'Edit Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Senjata.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('senjata_grid_pemeliharaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Senjata.URL.removePemeliharaan, Senjata.dataStorePemeliharaan);
            }
        };


        Senjata.Action.pemeliharaanAdd = function()
        {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Senjata.Form.createPemeliharaan(Senjata.dataStorePemeliharaan, dataForm, false);
            Tab.addToForm(form, 'senjata-add-pemeliharaan', 'Add Pemeliharaan');
        };

        Senjata.Action.pemeliharaanList = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Senjata.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Senjata.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Senjata.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Senjata.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "senjata_grid_pemeliharaan",
                    add : Senjata.Action.pemeliharaanAdd,
                    remove : Senjata.Action.pemeliharaanRemove,
                    edit : Senjata.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: Senjata.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _senjataPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_senjataPemeliharaanGrid, 'senjata-pemeliharaan', 'Pemeliharaan');
            }
        };

        Senjata.Action.add = function() {
            var _form = Senjata.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Senjata');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Senjata.Action.edit = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Senjata');
                    Modal.assetEdit.add(Region.createSidePanel(Senjata.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Senjata.Form.create(data, true);
                Tab.addToForm(_form, 'senjata-details', 'Simak Details');
                Modal.assetEdit.show();

            }
        };

        Senjata.Action.remove = function() {
            console.log('remove Senjata');
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
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
            Modal.deleteAlert(arrayDeleted, Senjata.URL.remove, Senjata.Data);
        };

        Senjata.Action.print = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Senjata.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Senjata_Model";
            var title = "Senjata";
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

		Senjata.Action.printpdf = function() {
            var selected = Senjata.Grid.grid.getSelectionModel().getSelection();
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
            Modal.printDocPdf(Ext.encode(arrayPrintpdf), BASE_URL + 'asset_senjata/cetak/' + selectedData, 'Cetak Pengelolaan Asset Senjata');
            
        };
		
        var setting = {
            grid: {
                id: 'grid_Senjata',
                title: 'DAFTAR ASSET Senjata',
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
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'RPH Asset', dataIndex: 'rph_aset', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No KIB', dataIndex: 'no_kib', width: 50, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 65, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Nama', dataIndex: 'nama', width: 180, groupable: false, filter: {type: 'string'}},
                    {header: 'Merk', dataIndex: 'merk', width: 100, groupable: false, filter: {type: 'string'}},
                    {header: 'Type', dataIndex: 'type', width: 120, groupable: false, filter: {type: 'string'}},
                    {header: 'Kaliber', dataIndex: 'kaliber', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'No Pabrik', dataIndex: 'no_pabrik', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Buat', dataIndex: 'thn_buat', width: 120, hidden: true, filter: {type: 'string'}},
                    {header: 'Tangal Surat', dataIndex: 'tgl_surat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap 1', dataIndex: 'lengkap1', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap 2', dataIndex: 'lengkap2', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Lengkap 3', dataIndex: 'lengkap3', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis TRN', dataIndex: 'jns_trn', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 150, hidden: false, filter: {type: 'string'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Unit PMK', dataIndex: 'unit_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat PMK', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Harga Wajar', dataIndex: 'rph_wajar', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Senjata.Data.getAt(rowindex).data.kd_lokasi.substring(9, 15);
									Load_TabPage('map_asset', BASE_URL + 'global_map');
                                    applyItemQuery(kodeWilayah);
                                }}]},
                ]
            },
            search: {
                id: 'search_Senjata'
            },
            toolbar: {
                id: 'toolbar_senjata',
                add: {
                    id: 'button_add_Senjata',
                    action: Senjata.Action.add
                },
                edit: {
                    id: 'button_edit_Senjata',
                    action: Senjata.Action.edit
                },
                remove: {
                    id: 'button_remove_Senjata',
                    action: Senjata.Action.remove
                },
                print: {
                    id: 'button_pring_Senjata',
                    action: Senjata.Action.print
                }
            }
        }

        Senjata.Grid.grid = Grid.inventarisGrid(setting, Senjata.Data)


        var new_tabpanel_Asset = {
            id: 'senjata_panel', title: 'Senjata', iconCls: 'icon-senjata_Senjata', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(Senjata.Data,'senjata','3','09'),Senjata.Grid.grid]
        }

<?php

} else {
    echo "var new_tabpanel_MD = 'GAGAL';";
}
?>