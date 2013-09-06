<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPenerimaan = null;

        Ext.namespace('InventoryPenerimaan', 'InventoryPenerimaan.reader', 'InventoryPenerimaan.proxy', 'InventoryPenerimaan.Data', 'InventoryPenerimaan.Grid', 'InventoryPenerimaan.Window', 'InventoryPenerimaan.Form', 'InventoryPenerimaan.Action', 'InventoryPenerimaan.URL');
        InventoryPenerimaan.URL = {
            read: BASE_URL + 'inventory_penerimaan/getAllData',
            createUpdate: BASE_URL + 'inventory_penerimaan/modifyInventoryPenerimaan',
            remove: BASE_URL + 'inventory_penerimaan/deleteInventoryPenerimaan'
        };

        InventoryPenerimaan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPenerimaan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPenerimaan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPenerimaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPenerimaan',
            url: InventoryPenerimaan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPenerimaan.reader,
            writer: InventoryPenerimaan.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPenerimaan = request.operation.params;
            }
        });

        InventoryPenerimaan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPenerimaan', storeId: 'DataInventoryPenerimaan', model: 'MInventoryPenerimaan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPenerimaan.proxy, groupField: 'tipe'
        });

        InventoryPenerimaan.Form.create = function(data, edit) {
            var setting = {
                url: InventoryPenerimaan.URL.createUpdate,
                data: InventoryPenerimaan.Data,
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
                            console.error('There is existing grid in the popup selection - inventorypenerimaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.inventorypenerimaan(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
            }
            return form;
        };

        InventoryPenerimaan.Action.add = function() {
            var _form = InventoryPenerimaan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Penerimaan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        InventoryPenerimaan.Action.edit = function() {
            var selected = InventoryPenerimaan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Penerimaan');
                }
                var _form = InventoryPenerimaan.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        InventoryPenerimaan.Action.remove = function() {
            var selected = InventoryPenerimaan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPenerimaan.URL.remove, InventoryPenerimaan.Data);
        };

        InventoryPenerimaan.Action.print = function() {
            var selected = InventoryPenerimaan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPenerimaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Inventory_Penerimaan_Model";
            var title = "Inventory Penerimaan";
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
                id: 'grid_InventoryPenerimaan',
                title: 'DAFTAR INVENTORY PENERIMAAN',
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
                    {header: 'Tanggal Penerimaan', dataIndex: 'tgl_penerimaan', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Asal Barang', dataIndex: 'asal_barang', width: 90, hidden: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_InventoryPenerimaan'
            },
            toolbar: {
                id: 'toolbar_InventoryPenerimaan',
                add: {
                    id: 'button_add_InventoryPenerimaan',
                    action: InventoryPenerimaan.Action.add
                },
                edit: {
                    id: 'button_edit_InventoryPenerimaan',
                    action: InventoryPenerimaan.Action.edit
                },
                remove: {
                    id: 'button_remove_InventoryPenerimaan',
                    action: InventoryPenerimaan.Action.remove
                },
                print: {
                    id: 'button_print_InventoryPenerimaan',
                    action: InventoryPenerimaan.Action.print
                }
            }
        };

        InventoryPenerimaan.Grid.grid = Grid.processGrid(setting, InventoryPenerimaan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventorypenerimaan_asset', title: 'Inventory - Penerimaan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPenerimaan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>