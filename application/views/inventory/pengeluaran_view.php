<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPengeluaran = null;

        Ext.namespace('InventoryPengeluaran', 'InventoryPengeluaran.reader', 'InventoryPengeluaran.proxy', 'InventoryPengeluaran.Data', 'InventoryPengeluaran.Grid', 'InventoryPengeluaran.Window', 'InventoryPengeluaran.Form', 'InventoryPengeluaran.Action', 'InventoryPengeluaran.URL');
        InventoryPengeluaran.URL = {
            read: BASE_URL + 'inventory_pengeluaran/getAllData',
            createUpdate: BASE_URL + 'inventory_pengeluaran/modifyInventoryPengeluaran',
            remove: BASE_URL + 'inventory_pengeluaran/deleteInventoryPengeluaran'
        };

        InventoryPengeluaran.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPengeluaran', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPengeluaran.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPengeluaran.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPengeluaran',
            url: InventoryPengeluaran.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPengeluaran.reader,
            writer: InventoryPengeluaran.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPengeluaran = request.operation.params;
            }
        });

        InventoryPengeluaran.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPengeluaran', storeId: 'DataInventoryPengeluaran', model: 'MInventoryPengeluaran', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPengeluaran.proxy, groupField: 'tipe'
        });

        InventoryPengeluaran.Form.create = function(data, edit) {
            var setting = {
                url: InventoryPengeluaran.URL.createUpdate,
                data: InventoryPengeluaran.Data,
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
                            console.error('There is existing grid in the popup selection - inventorypengeluaran');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.inventorypengeluaran(setting);

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
            return form;
        };

        InventoryPengeluaran.Action.add = function() {
            var _form = InventoryPengeluaran.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Pengeluaran');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        InventoryPengeluaran.Action.edit = function() {
            var selected = InventoryPengeluaran.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Pengeluaran');
                }
                var _form = InventoryPengeluaran.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        InventoryPengeluaran.Action.remove = function() {
            var selected = InventoryPengeluaran.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    id_penyimpanan: obj.data.id_penyimpanan,
                    qty_barang_keluar: obj.data.qty_barang_keluar,
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPengeluaran.URL.remove, InventoryPengeluaran.Data);
        };

        InventoryPengeluaran.Action.print = function() {
            var selected = InventoryPengeluaran.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPengeluaran.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Inventory_Pengeluaran_Model";
            var title = "Inventory Pengeluaran";
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
                id: 'grid_InventoryPengeluaran',
                title: 'DAFTAR INVENTORY PENGELUARAN',
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
                    {header: 'Qty Awal', dataIndex: 'qty', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Qty Barang Keluar', dataIndex: 'qty_barang_keluar', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Pengeluaran', dataIndex: 'tgl_pengeluaran', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Asal Barang', dataIndex: 'asal_barang', width: 90, hidden: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_InventoryPengeluaran'
            },
            toolbar: {
                id: 'toolbar_InventoryPengeluaran',
                add: {
                    id: 'button_add_InventoryPengeluaran',
                    action: InventoryPengeluaran.Action.add
                },
                edit: {
                    id: 'button_edit_InventoryPengeluaran',
                    action: InventoryPengeluaran.Action.edit
                },
                remove: {
                    id: 'button_remove_InventoryPengeluaran',
                    action: InventoryPengeluaran.Action.remove
                },
                print: {
                    id: 'button_print_InventoryPengeluaran',
                    action: InventoryPengeluaran.Action.print
                }
            }
        };

        InventoryPengeluaran.Grid.grid = Grid.processGrid(setting, InventoryPengeluaran.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventorypengeluaran_asset', title: 'Inventory - Pengeluaran', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPengeluaran.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>