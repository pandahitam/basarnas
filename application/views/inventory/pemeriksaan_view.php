<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPemeriksaan = null;

        Ext.namespace('InventoryPemeriksaan', 'InventoryPemeriksaan.reader', 'InventoryPemeriksaan.proxy', 'InventoryPemeriksaan.Data', 'InventoryPemeriksaan.Grid', 'InventoryPemeriksaan.Window', 'InventoryPemeriksaan.Form', 'InventoryPemeriksaan.Action', 'InventoryPemeriksaan.URL');
        InventoryPemeriksaan.URL = {
            read: BASE_URL + 'inventory_pemeriksaan/getAllData',
            createUpdate: BASE_URL + 'inventory_pemeriksaan/modifyInventoryPemeriksaan',
            remove: BASE_URL + 'inventory_pemeriksaan/deleteInventoryPemeriksaan'
        };

        InventoryPemeriksaan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPemeriksaan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPemeriksaan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPemeriksaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPemeriksaan',
            url: InventoryPemeriksaan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPemeriksaan.reader,
            writer: InventoryPemeriksaan.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPemeriksaan = request.operation.params;
            }
        });

        InventoryPemeriksaan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPemeriksaan', storeId: 'DataInventoryPemeriksaan', model: 'MInventoryPemeriksaan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPemeriksaan.proxy, groupField: 'tipe'
        });

        InventoryPemeriksaan.Form.create = function(data, edit) {
            var setting = {
                url: InventoryPemeriksaan.URL.createUpdate,
                data: InventoryPemeriksaan.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: true,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset());
                            Modal.assetSelection.show();
                        }
                        else
                        {
                            console.error('There is existing grid in the popup selection - inventorypemeriksaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.inventorypemeriksaan(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
            }
            return form;
        };

        InventoryPemeriksaan.Action.add = function() {
            var _form = InventoryPemeriksaan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Pemeriksaan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        InventoryPemeriksaan.Action.edit = function() {
            var selected = InventoryPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Pemeriksaan');
                }
                var _form = InventoryPemeriksaan.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        InventoryPemeriksaan.Action.remove = function() {
            var selected = InventoryPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPemeriksaan.URL.remove, InventoryPemeriksaan.Data);
        };

        InventoryPemeriksaan.Action.print = function() {
            var selected = InventoryPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPemeriksaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Inventory_Pemeriksaan_Model";
            var title = "Inventory Pemeriksaan";
            var primaryKeys = "id";

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
                id: 'grid_InventoryPemeriksaan',
                title: 'DAFTAR INVENTORY PEMERIKSAAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', width: 50, hidden: true, groupable: false, filter: {type: 'number'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 180, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Berita Acara', dataIndex: 'tgl_berita_acara', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nomor Berita Acara', dataIndex: 'nomor_berita_acara', width: 90, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 120, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Serial Number', dataIndex: 'serial_number', width: 70, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Date Created', dataIndex: 'date_created', width: 100, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Keterangan', dataIndex: 'keterangan', width: 120, hidden: false, filter: {type: 'string'}},
                    {header: 'Status Barang', dataIndex: 'status_barang', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Qty', dataIndex: 'qty', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Pemeriksaan', dataIndex: 'tgl_pemeriksaan', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Asal Barang', dataIndex: 'asal_barang', width: 90, hidden: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_InventoryPemeriksaan'
            },
            toolbar: {
                id: 'toolbar_InventoryPemeriksaan',
                add: {
                    id: 'button_add_InventoryPemeriksaan',
                    action: InventoryPemeriksaan.Action.add
                },
                edit: {
                    id: 'button_edit_InventoryPemeriksaan',
                    action: InventoryPemeriksaan.Action.edit
                },
                remove: {
                    id: 'button_remove_InventoryPemeriksaan',
                    action: InventoryPemeriksaan.Action.remove
                },
                print: {
                    id: 'button_print_InventoryPemeriksaan',
                    action: InventoryPemeriksaan.Action.print
                }
            }
        };

        InventoryPemeriksaan.Grid.grid = Grid.processGrid(setting, InventoryPemeriksaan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventorypemeriksaan_asset', title: 'Inventory - Pemeriksaan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPemeriksaan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>