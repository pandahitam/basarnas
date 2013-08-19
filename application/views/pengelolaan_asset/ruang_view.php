<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Ruang = null;

        Ext.namespace('Ruang', 'Ruang.reader', 'Ruang.proxy', 'Ruang.Data', 'Ruang.Grid', 'Ruang.Window', 'Ruang.Form', 'Ruang.Action',
                'Ruang.URL');

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
            removePemeliharaan: BASE_URL + 'pemeliharaan/deletePemeliharaanRuang'

        };

        Ruang.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Ruang', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Ruang.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Ruang',
            url: Ruang.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Ruang.reader,
            afterRequest: function(request, success) {
                Params_M_Ruang = request.operation.params;
            }
        });

        Ruang.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Ruang', storeId: 'DataRuang', model: 'MRuang', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Ruang.proxy, groupField: 'tipe'
        });

        Ruang.Form.create = function(dataForm, edit) {
            
            var setting = {
                url : Ruang.URL.createUpdate,
                dataGrid : Ruang.Data,
                isEditing : edit
            };
            
            var form = Form.assetRuang(setting);
            
            if (dataForm !== null)
            {
                form.getForm().setValues(dataForm);
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

            var form = Form.pemeliharaanInAsset(setting);

            if (dataForm !== null)
            {
                form.getForm().setValues(dataForm);
            }
            
            return form;
        };

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
                }
            };

            return actions;
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
                        if (jsonData !== null || jsonData !== undefined)
                        {
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
                Tab.addToForm(form, 'bangunan-edit-pemeliharaan', 'Edit Pemeliharaan');
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
            Tab.addToForm(form, 'bangunan-add-pemeliharaan', 'Add Pemeliharaan');
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
                Tab.addToForm(_form, 'bangunan-details', 'Simak Details');
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
            Asset.Window.createDeleteAlert(arrayDeleted, Ruang.URL.remove, Ruang.Data);
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

        var setting = {
            grid: {
                id: 'grid_bangunan',
                title: 'DAFTAR ASSET RUANG',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'ur_sskel', width: 150, hidden: false, filter: {type: 'string'}},
                    {header: 'Ruang', dataIndex: 'ruang', width: 120, hidden: false, filter: {type: 'string'}},
                    {header: 'Pejabat Ruang', dataIndex: 'pejabat_ruang', width: 150, hidden: false, filter: {type: 'string'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Ruang.Data.getAt(rowindex).data.kd_lokasi.substring(5, 9);
                                    console.log(kodeWilayah);
                                    Ext.getCmp('Content_Body_Tabs').setActiveTab('map_asset');
                                    applyItemQuery(kodeWilayah);
                                }}]}
                ]
            },
            search: {
                id: 'search_bangunan'
            },
            toolbar: {
                id: 'toolbar_bangunan',
                add: {
                    id: 'button_add_bangunan',
                    action: Ruang.Action.add
                },
                edit: {
                    id: 'button_edit_bangunan',
                    action: Ruang.Action.edit
                },
                remove: {
                    id: 'button_remove_bangunan',
                    action: Ruang.Action.remove
                },
                print: {
                    id: 'button_pring_bangunan',
                    action: Ruang.Action.print
                }
            }
        };

        Ruang.Grid.grid = Grid.inventarisGrid(setting, Ruang.Data);


        var new_tabpanel_Asset = {
            id: 'ruang_panel', title: 'Ruang', iconCls: 'icon-tanah_bangunan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(Ruang.Data),Ruang.Grid.grid]
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>