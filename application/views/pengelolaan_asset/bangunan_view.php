<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
<script>
//////////////////
        var Params_M_Bangunan = null;

        Ext.namespace('Bangunan', 'Bangunan.reader', 'Bangunan.proxy', 'Bangunan.Data', 'Bangunan.Grid', 'Bangunan.Window', 'Bangunan.Form', 'Bangunan.Action',
                'Bangunan.URL');

        Bangunan.dataStorePemeliharaan = new Ext.create('Ext.data.Store', {
            model: 'MPemeliharaanBangunan', autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Pemeliharaan_Bangunan/getSpecificPemeliharaanBangunan', actionMethods: {read: 'POST'}
            })
        });
        
        Bangunan.dataStoreRiwayatPajak = new Ext.create('Ext.data.Store', {
            model: MRiwayatPajakTanahDanBangunan, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'Bangunan/getSpecificRiwayatPajak', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });


        Bangunan.URL = {
            read: BASE_URL + 'asset_bangunan/getAllData',
            createUpdate: BASE_URL + 'asset_bangunan/modifyBangunan',
            remove: BASE_URL + 'asset_bangunan/deleteBangunan',
            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan_Bangunan/modifyPemeliharaanBangunan',
            removePemeliharaan: BASE_URL + 'Pemeliharaan_Bangunan/deletePemeliharaanBangunan'

        };

        Bangunan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Bangunan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Bangunan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Bangunan',
            url: Bangunan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Bangunan.reader,
            afterRequest: function(request, success) {
                Params_M_Bangunan = request.operation.params;
                
                //USED FOR MAP SEARCH
                var paramsUnker = request.params.searchUnker;
                if(paramsUnker != null ||paramsUnker != undefined)
                {
                    Bangunan.Data.clearFilter();
                    Bangunan.Data.filter([{property: 'nama_unker', value: paramsUnker, anyMatch:true}]);
                }
            }
        });

        Bangunan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Bangunan', storeId: 'DataBangunan', model: 'MBangunan', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Bangunan.proxy, groupField: 'tipe'
        });
        
        
        Bangunan.addRiwayatPajak = function()
        {
        };
        Bangunan.editRiwayatPajak = function()
        {
        };
        Bangunan.removeRiwayatPajak = function()
        {
        };
        
        Bangunan.Form.create = function(data, edit) {
            var setting_grid_riwayat_pajak = {
                id:'bangunan_riwayat_pajak',
                toolbar:{
                    add: Bangunan.addRiwayatPajak,
                    edit: Bangunan.editRiwayatPajak,
                    remove: Bangunan.removeRiwayatPajak
                },
                dataStore:Bangunan.dataStoreRiwayatPajak
            };
            
            var form = Form.asset(Bangunan.URL.createUpdate, Bangunan.Data, edit);
            
            form.insert(0, Form.Component.unit(edit,form));
            form.insert(1, Form.Component.kode(edit));
            form.insert(2, Form.Component.basicAsset(edit));
            form.insert(3, Form.Component.klasifikasiAset(edit))
            form.insert(4, Form.Component.address());
            form.insert(5, Form.Component.bangunan());
            form.insert(6, Form.Component.tambahanBangunanTanah());
            form.insert(7, Form.Component.riwayatPajakTanahDanBangunan(setting_grid_riwayat_pajak,edit));
            form.insert(8, Form.Component.fileUpload(edit));
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };

        Bangunan.Form.createPemeliharaan = function(dataGrid,dataForm,edit) {
            var setting = {
                url: Bangunan.URL.createUpdatePemeliharaan,
                data: dataGrid,
                isEditing: edit,
                isBangunan: true,
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

        Bangunan.Window.actionSidePanels = function() {
            var actions = {
                details: function() {
//                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
//                    var tabpanels = _tab.getComponent('bangunan-details');
//                    if (tabpanels === undefined)
//                    {
//                        Bangunan.Action.edit();
//                    }
                    Bangunan.Action.edit();
                },
                pengadaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('bangunan-pengadaan');
                    if (tabpanels === undefined)
                    {
                        Bangunan.Action.pengadaanEdit();
                    }
                },
                pemeliharaan: function() {
                    var _tab = Modal.assetEdit.getComponent('asset-window-tab');
                    var tabpanels = _tab.getComponent('bangunan-pemeliharaan');
                    if (tabpanels === undefined)
                    {
                        Bangunan.Action.pemeliharaanList();
                    }
                }
            };

            return actions;
        };

        Bangunan.Action.pengadaanEdit = function() {
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
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

        Bangunan.Action.pemeliharaanEdit = function() {
            var selected = Ext.getCmp('bangunan_grid_pemeliharaan').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var dataForm = selected[0].data;
                var form = Bangunan.Form.createPemeliharaan(Bangunan.dataStorePemeliharaan, dataForm, true)
                Tab.addToForm(form, 'bangunan-edit-pemeliharaan', 'Edit Pemeliharaan');
            }
        };

        Bangunan.Action.pemeliharaanRemove = function() {
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
                Modal.deleteAlert(arrayDeleted, Bangunan.URL.removePemeliharaan, Bangunan.dataStorePemeliharaan);
            }
        };


        Bangunan.Action.pemeliharaanAdd = function()
        {
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
            var data = selected[0].data;
            var dataForm = {
                kd_lokasi: data.kd_lokasi,
                kd_brg: data.kd_brg,
                no_aset: data.no_aset
            };
            var form = Bangunan.Form.createPemeliharaan(Bangunan.dataStorePemeliharaan, dataForm, false)
            Tab.addToForm(form, 'bangunan-add-pemeliharaan', 'Add Pemeliharaan');
        };


        Bangunan.Action.pemeliharaanList = function() {
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                Bangunan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                Bangunan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                Bangunan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                Bangunan.dataStorePemeliharaan.load();
                var toolbarIDs = {};
                toolbarIDs.idGrid = "bangunan_grid_pemeliharaan";
                toolbarIDs.add = Bangunan.Action.pemeliharaanAdd;
                toolbarIDs.remove = Bangunan.Action.pemeliharaanRemove;
                toolbarIDs.edit = Bangunan.Action.pemeliharaanEdit;
                var setting = {
                    data: data,
                    dataStore: Bangunan.dataStorePemeliharaan,
                    toolbar: toolbarIDs,
                    isBangunan: true
                };
                var _bangunanPemeliharaanGrid = Grid.pemeliharaanGrid(setting);
                Tab.addToForm(_bangunanPemeliharaanGrid, 'bangunan-pemeliharaan', 'Pemeliharaan');
                Modal.assetEdit.show();
            }
        };

        Bangunan.Action.add = function() {
            var _form = Bangunan.Form.create(null, false);
            Modal.assetCreate.setTitle('Create Bangunan');
            Modal.assetCreate.add(_form);
            Modal.assetCreate.show();
        };

        Bangunan.Action.edit = function() {
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;

                if (Modal.assetEdit.items.length <= 1)
                {
                    Modal.assetEdit.setTitle('Edit Bangunan');
                    Modal.assetEdit.insert(0, Region.createSidePanel(Bangunan.Window.actionSidePanels()));
                    Modal.assetEdit.add(Tab.create());
                }

                var _form = Bangunan.Form.create(data, true);
                Tab.addToForm(_form, 'bangunan-details', 'Simak Details');
                Modal.assetEdit.show();
            }
        };

        Bangunan.Action.remove = function() {
            console.log('remove Bangunan');
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
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
            Asset.Window.createDeleteAlert(arrayDeleted, Bangunan.URL.remove, Bangunan.Data);
        };

        Bangunan.Action.print = function() {
            var selected = Bangunan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.kd_brg + "||" + selected[i].data.no_aset + "||" + selected[i].data.kd_lokasi + ",";
                }
            }
            var gridHeader = Bangunan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Asset_Bangunan_Model";
            var title = "Bangunan";
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
                title: 'DAFTAR ASSET BANGUNAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 90, groupable: false, filter: {type: 'string'}},
                    {header: 'No Asset', dataIndex: 'no_aset', width: 60, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, groupable: true, filter: {type: 'string'}},
                    {header: 'Kuantitas', dataIndex: 'kuantitas', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'RPH Asset', dataIndex: 'rph_aset', width: 120, hidden: true, groupable: false, filter: {type: 'numeric'}},
                    {header: 'No KIB', dataIndex: 'no_kib', width: 70, groupable: false, filter: {type: 'numeric'}},
                    {header: 'Type', dataIndex: 'type', width: 110, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Tahun Selesai', dataIndex: 'thn_sls', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Pakai', dataIndex: 'thn_pakai', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'Tahun Pakai', dataIndex: 'no_imb', width: 90, groupable: false, hidden: true, filter: {type: 'string'}},
                    {header: 'No IMB', dataIndex: 'tgl_imb', width: 120, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Prov', dataIndex: 'kd_prov', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kab', dataIndex: 'kd_kab', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kec', dataIndex: 'kd_kec', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode Kel', dataIndex: 'kd_kel', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alamat', dataIndex: 'alamat', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kode RTRW', dataIndex: 'kd_rtrw', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Kib Tanah', dataIndex: 'no_kibtnh', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Jenis Trn', dataIndex: 'jns_trn', width: 70, hidden: true, filter: {type: 'string'}},
                    {header: 'Dari', dataIndex: 'dari', width: 180, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Prl', dataIndex: 'tgl_prl', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Dasar Harga', dataIndex: 'dasar_hrg', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Sumber', dataIndex: 'sumber', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'No Dana', dataIndex: 'no_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Tanggal Dana', dataIndex: 'tgl_dana', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Unit Pmk', dataIndex: 'unit_pmk', width: 150, hidden: false, filter: {type: 'string'}},
                    {header: 'Alamat Pmk', dataIndex: 'alm_pmk', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Catatan', dataIndex: 'catatan', width: 170, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Buku', dataIndex: 'tgl_buku', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Harga Wajar', dataIndex: 'rph_wajar', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Harga NJOP', dataIndex: 'rphnjop', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Luas Dasar', dataIndex: 'luas_dsr', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Luas Bangunan', dataIndex: 'luas_bdg', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {header: 'Lantai', dataIndex: 'jml_ltg', width: 90, hidden: true, filter: {type: 'numeric'}},
                    {xtype: 'actioncolumn', width: 60, items: [{icon: '../basarnas/assets/images/icons/map1.png', tooltip: 'Map',
                                handler: function(grid, rowindex, colindex, obj) {
                                    var kodeWilayah = Bangunan.Data.getAt(rowindex).data.kd_lokasi.substring(5, 9);
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
                    action: Bangunan.Action.add
                },
                edit: {
                    id: 'button_edit_bangunan',
                    action: Bangunan.Action.edit
                },
                remove: {
                    id: 'button_remove_bangunan',
                    action: Bangunan.Action.remove
                },
                print: {
                    id: 'button_pring_bangunan',
                    action: Bangunan.Action.print
                }
            }
        };

        Bangunan.Grid.grid = Grid.inventarisGrid(setting, Bangunan.Data);


        var new_tabpanel_Asset = {
            id: 'bangunan_panel', title: 'Bangunan', iconCls: 'icon-tanah_bangunan', closable: true, border: false,layout:'border',
            items: [Region.filterPanelAset(Bangunan.Data),Bangunan.Grid.grid]
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>