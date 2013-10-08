<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPenyimpanan = null;

        Ext.namespace('InventoryPenyimpanan', 'InventoryPenyimpanan.reader', 'InventoryPenyimpanan.proxy', 'InventoryPenyimpanan.Data', 'InventoryPenyimpanan.Grid', 'InventoryPenyimpanan.Window', 'InventoryPenyimpanan.Form', 'InventoryPenyimpanan.Action', 'InventoryPenyimpanan.URL');
        InventoryPenyimpanan.URL = {
            read: BASE_URL + 'inventory_penyimpanan/getAllData',
            createUpdate: BASE_URL + 'inventory_penyimpanan/modifyInventoryPenyimpanan',
            remove: BASE_URL + 'inventory_penyimpanan/deleteInventoryPenyimpanan'
        };

        InventoryPenyimpanan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPenyimpanan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPenyimpanan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPenyimpanan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPenyimpanan',
            url: InventoryPenyimpanan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPenyimpanan.reader,
            writer: InventoryPenyimpanan.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPenyimpanan = request.operation.params;
            }
        });

        InventoryPenyimpanan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPenyimpanan', storeId: 'DataInventoryPenyimpanan', model: 'MInventoryPenyimpanan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPenyimpanan.proxy, groupField: 'tipe'
        });

        InventoryPenyimpanan.Form.create = function(data, edit,id_pemeriksaan) {
            var setting = {
                url: InventoryPenyimpanan.URL.createUpdate,
                data: InventoryPenyimpanan.Data,
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
                            console.error('There is existing grid in the popup selection - inventorypenyimpanan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };
            debugger;

            var form = Form.inventorypenyimpanan(setting,id_pemeriksaan);

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

        InventoryPenyimpanan.Action.add = function() {
            var _form = InventoryPenyimpanan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Penyimpanan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        InventoryPenyimpanan.Action.edit = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Penyimpanan');
                }
                var _form = InventoryPenyimpanan.Form.create(data, true,data.id_pemeriksaan);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        InventoryPenyimpanan.Action.remove = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPenyimpanan.URL.remove, InventoryPenyimpanan.Data);
        };

        InventoryPenyimpanan.Action.print = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPenyimpanan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Inventory_Penyimpanan_Model";
            var title = "Inventory Penyimpanan";
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
                id: 'grid_InventoryPenyimpanan',
                title: 'DAFTAR INVENTORY PENYIMPANAN',
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
                    {header: 'Tanggal Penyimpanan', dataIndex: 'tgl_penyimpanan', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Asal Barang', dataIndex: 'asal_barang', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Id Warehouse', dataIndex: 'warehouse_id', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Id Ruang', dataIndex: 'ruang_id', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Id Rak', dataIndex: 'rak_id', width: 90, hidden: true, filter: {type: 'string'}},
                    
                ]
            },
            search: {
                id: 'search_InventoryPenyimpanan'
            },
            toolbar: {
                id: 'toolbar_InventoryPenyimpanan',
                add: {
                    id: 'button_add_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.add
                },
                edit: {
                    id: 'button_edit_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.edit
                },
                remove: {
                    id: 'button_remove_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.remove
                },
                print: {
                    id: 'button_print_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.print
                }
            }
        };

        InventoryPenyimpanan.Grid.grid = Grid.processGrid(setting, InventoryPenyimpanan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventorypenyimpanan_asset', title: 'Inventory - Penyimpanan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPenyimpanan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>