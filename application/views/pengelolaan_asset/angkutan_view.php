<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Angkutan = null;

        Ext.namespace('Angkutan', 'Angkutan.reader', 'Angkutan.proxy', 'Angkutan.Data', 'Angkutan.Grid', 'Angkutan.Window',
                'Angkutan.Form', 'Angkutan.Action', 'Angkutan.URL');

        Angkutan.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: MPemeliharaan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan/getSpecificPemeliharaan', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });

        Angkutan.URL = {
            read: BASE_URL + 'asset_Angkutan/getAllData',
            createUpdate: BASE_URL + 'asset_Angkutan/modifyAngkutan',
            remove: BASE_URL + 'asset_Angkutan/deleteAngkutan',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan'
        };

        Angkutan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Angkutan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Angkutan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Angkutan',
            url: Angkutan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Angkutan.reader,
            afterRequest: function(request, success) {
                //Params_M_Angkutan = request.operation.params;
            }
        });

        Angkutan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Angkutan', storeId: 'DataAngkutan', model: 'MAngkutan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Angkutan.proxy, groupField: 'tipe'
        });

        Angkutan.Form.create = function(data, edit) {
            var form = Form.asset(Angkutan.URL.createUpdate, Angkutan.Data, edit);
            form.insert(0, Form.Component.unit(edit));
            form.insert(1, Form.Component.kode(edit));
            form.insert(2, Form.Component.basicAsset(edit));
            form.insert(3, Form.Component.mechanical());
            form.insert(4, Form.Component.angkutan());
            form.insert(5, Form.Component.fileUpload());
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        Angkutan.Form.createPemeliharaan = function(data, dataForm, edit) {
            var setting = {
                url: Angkutan.URL.createUpdatePemeliharaan,
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

        Angkutan.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
                    var _tab = Asset.Window.popupEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutan-details');
                    if (tabpanels === undefined)
                    {
                        Angkutan.Action.edit();
                    }
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Angkutan.Action.detail_pengadaan();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('angkutan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Angkutan.Action.pemeliharaanList();
                    }
                }
            };

            return actions;
        };

        Angkutan.Action.detail_pengadaan = function() {
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
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

        Angkutan.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('angkutan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Angkutan.Form.createPemeliharaan(Angkutan.dataStorePemeliharaan, dataForm, true);
                Tab.addToForm(form, 'angkutan-edit-pemeliharaan', 'Edit Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Angkutan.Action.pemeliharaanRemove = function() {
            var selected = Ext.getCmp('angkutan_grid_pemeliharaan').getSelectionModel().getSelection();
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
                Modal.deleteAlert(arrayDeleted, Angkutan.URL.removePemeliharaan, Angkutan.dataStorePemeliharaan);
            }
        };


        Angkutan.Action.pemeliharaanAdd = function()
        {
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };

            var form = Angkutan.Form.createPemeliharaan(Angkutan.dataStorePemeliharaan, dataForm, false);
            Tab.addToForm(form, 'angkutan-add-pemeliharaan', 'Add Pemeliharaan');
        };

        Angkutan.Action.pemeliharaanList = function() {
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                
                Angkutan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Angkutan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Angkutan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Angkutan.dataStorePemeliharaan.load();
                
                var toolbarIDs = {
                    idGrid : "angkutan_grid_pemeliharaan",
                    add : Angkutan.Action.pemeliharaanAdd,
                    remove : Angkutan.Action.pemeliharaanRemove,
                    edit : Angkutan.Action.pemeliharaanEdit
                };

                var setting = {
                    data: data,
                    dataStore: Angkutan.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: false
                };
                
                var _angkutanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_angkutanPemeliharaanGrid, 'angkutan-pemeliharaan', 'Pemeliharaan');
            }
        };

    // ADI - temporary only need change in the future
        Angkutan.Action.add = function() {
            var _form = Angkutan.Form.create(null, false);
            var form = Form.asset(Angkutan.URL.createUpdate, null, false);
            form.insert(0, Form.Component.tambahanAngkutanDarat());
            form.insert(1, Form.Component.tambahanAngkutanLaut());
            form.insert(2, Form.Component.tambahanAngkutanUdara());

            var tab = Tab.tempcreate();
            tab.add({
                title: 'Utama',
                closable: true,
                border: false,
                items: [_form],
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
                items: [form],
                listeners: {
                    'beforeclose': function() {
                        Utils.clearDataRef();
                    }
                }
            });

            tab.setActiveTab(0);

            Modal.assetCreate.add(tab);
            Modal.assetCreate.setTitle('Create Angkutan');
            Modal.assetCreate.show();
        };

        Angkutan.Action.edit = function() {
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length === 0)
                {
                    Modal.assetEdit.setTitle('Edit Angkutan');
                    Modal.assetEdit.add(Region.createSidePanel(Angkutan.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Angkutan.Form.create(data, true);
                Tab.addToForm(_form, 'angkutan-details', 'Simak Details');
                Modal.assetEdit.show();

            }
        };

        Angkutan.Action.remove = function() {
            console.log('remove Angkutan');
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
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
            Asset.Window.createDeleteAlert(arrayDeleted, Angkutan.URL.remove, Angkutan.Data);
        };

        Angkutan.Action.print = function() {
            var selected = Angkutan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Angkutan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Angkutan_Model";
            var title = "Angkutan";
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
                id: 'grid_Angkutan',
                title: 'DAFTAR ASSET ANGKUTAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
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
                                    var kodeWilayah = Angkutan.Data.getAt(rowindex).data.kd_lokasi.substring(5, 9);
                                    console.log(kodeWilayah);
                                    Ext.getCmp('Content_Body_Tabs').setActiveTab('map_asset');
                                    applyItemQuery(kodeWilayah);
                                }
                            }]}
                ]
            },
            search: {
                id: 'search_Angkutan'
            },
            toolbar: {
                id: 'toolbar_angkutan',
                add: {
                    id: 'button_add_Angkutan',
                    action: Angkutan.Action.add
                },
                edit: {
                    id: 'button_edit_Angkutan',
                    action: Angkutan.Action.edit
                },
                remove: {
                    id: 'button_remove_Angkutan',
                    action: Angkutan.Action.remove
                },
                print: {
                    id: 'button_pring_Angkutan',
                    action: Angkutan.Action.print
                }
            }
        };

        Angkutan.Grid.grid = Grid.inventarisGrid(setting, Angkutan.Data);


        var new_tabpanel_Asset = {
            id: 'angkutan_panel', title: 'Angkutan', iconCls: 'icon-tanah_Angkutan', closable: true, border: false,
            items: [Angkutan.Grid.grid]
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>