<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    ////////////
        var Params_M_Perairan = null;

        Ext.namespace('Perairan', 'Perairan.reader', 'Perairan.proxy', 'Perairan.Data', 'Perairan.Grid', 'Perairan.Window', 'Perairan.Form', 'Perairan.Action', 'Perairan.URL');


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
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan'

        };

        Perairan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Perairan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Perairan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Perairan',
            url: Perairan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Perairan.reader,
            afterRequest: function(request, success) {
                Params_M_Perairan = request.operation.params;
            }
        });

        Perairan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Perairan', storeId: 'DataPerairan', model: 'MPerairan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Perairan.proxy, groupField: 'tipe'
        });

        Perairan.Form.create = function(data, edit) {
            var form = Form.asset(Perairan.URL.createUpdate, Perairan.Data, edit);
            form.insert(0, Form.Component.unit(edit,form));
            form.insert(1, Form.Component.kode(edit));
            form.insert(2, Form.Component.basicAsset(edit));
            form.insert(3, Form.Component.address());
            form.insert(4, Form.Component.bangunan());
            form.insert(5, Form.Component.fileUpload());
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        Perairan.Form.createPemeliharaan = function(data, kode, edit) {
            var setting = {
                url: Perairan.URL.createUpdatePemeliharaan,
                data: data,
                kode: kode,
                isEditing: edit,
                isPemeliharaanAssetInventaris: true,
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

            var form = Form.pemeliharaan(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
            }
            return form;
        };

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
                        Perairan.Action.list_pemeliharaan();
                    }
                }
            };

            return actions;
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

        Perairan.Action.edit_pemeliharaan = function() {
            var selected = Ext.getCmp('perairan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                var form = Perairan.Form.createPemeliharaan(data, null, true);
                Tab.addToForm(form, 'perairan-edit-pemeliharaan', 'Ubah Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Perairan.Action.remove_pemeliharaan = function() {
            debugger;
            var selected = Ext.getCmp('perairan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length > 0)
            {
                var selectedData = selected[0].data;
                var dataStore = Perairan.dataStorePemeliharaan.load({params: {kd_lokasi: selectedData.kd_lokasi, kd_brg: selectedData.kd_brg, no_aset: selectedData.no_aset}});
                var arrayDeleted = [];
                _.each(selected, function(obj) {
                    var data = {
                        id: obj.data.id
                    };
                    arrayDeleted.push(data);
                });
                console.log(arrayDeleted);
                Modal.deleteAlert(arrayDeleted, Perairan.URL.removePemeliharaan, dataStore);
            }
        };


        Perairan.Action.add_pemeliharaan = function()
        {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var kode = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            var form = Perairan.Form.createPemeliharaan(null, kode, false);
            Tab.addToForm(form, 'perairan-add-pemeliharaan', 'Tambah Pemeliharaan');
            Modal.assetEdit.show();
        };

        Perairan.Action.list_pemeliharaan = function() {
            var selected = Perairan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                var dataStore = Perairan.dataStorePemeliharaan.load({params: {kd_lokasi: data.kd_lokasi, kd_brg: data.kd_brg, no_aset: data.no_aset}});
                var toolbarIDs = {};
                toolbarIDs.idGrid = "perairan_grid_pemeliharaan";
                toolbarIDs.add = Perairan.Action.add_pemeliharaan;
                toolbarIDs.remove = Perairan.Action.remove_pemeliharaan;
                toolbarIDs.edit = Perairan.Action.edit_pemeliharaan;
                var setting = {
                    data: data,
                    dataStore: dataStore,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };

                var _perairanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_perairanPemeliharaanGrid, 'perairan-pemeliharaan', 'Simak Pemeliharaan');
                Modal.assetEdit.show();
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
            Asset.Window.createDeleteAlert(arrayDeleted, Perairan.URL.remove, Perairan.Data);
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

        var setting = {
            grid: {
                id: 'grid_perairan',
                title: 'DAFTAR ASSET PERAIRANG DAN IRIGASI',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
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
                                    var kodeWilayah = Perairan.Data.getAt(rowindex).data.kd_lokasi.substring(5, 9);
                                    console.log(kodeWilayah);
                                    Ext.getCmp('Content_Body_Tabs').setActiveTab('map_asset');
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
            id: 'perairan_panel', title: 'Perairan', iconCls: 'icon-tanah_bangunan', closable: true, border: false,
            items: [Perairan.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>