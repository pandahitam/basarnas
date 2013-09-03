<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_Warehouse = null;

        Ext.namespace('Warehouse', 'Warehouse.reader', 'Warehouse.proxy', 'Warehouse.Data', 'Warehouse.Grid', 'Warehouse.Window', 'Warehouse.Form', 'Warehouse.Action', 'Warehouse.URL');
        Warehouse.URL = {
            read: BASE_URL + 'master_data/warehouse_getAllData',
            createUpdate: BASE_URL + 'master_data/warehouse_modifyWarehouse',
            remove: BASE_URL + 'master_data/warehouse_deleteWarehouse'
        };

        Warehouse.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Warehouse', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Warehouse.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        Warehouse.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Warehouse',
            url: Warehouse.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Warehouse.reader,
            writer: Warehouse.writer,
            afterRequest: function(request, success) {
                Params_M_Warehouse = request.operation.params;
            }
        });

        Warehouse.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Warehouse', storeId: 'DataWarehouse', model: 'MWarehouse', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Warehouse.proxy, groupField: 'tipe'
        });

        Warehouse.Form.create = function(data, edit) {
            var setting = {
                url: Warehouse.URL.createUpdate,
                data: Warehouse.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: edit,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset());
                            Modal.assetSelection.show();
                        }
                        else
                        {
                            console.error('There is existing grid in the popup selection - pemeliharaan');
                        }
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

        Warehouse.Action.add = function() {
//            var _form = Warehouse.Form.create(null, false);
//            Modal.processCreate.setTitle('Create Warehouse');
//            Modal.processCreate.add(_form);
//            Modal.processCreate.show();
        };

        Warehouse.Action.edit = function() {
//            var selected = Warehouse.Grid.grid.getSelectionModel().getSelection();
//            if (selected.length === 1)
//            {
//                var data = selected[0].data;
//                delete data.nama_unker;
//
//                if (Modal.processEdit.items.length === 0)
//                {
//                    Modal.processEdit.setTitle('Edit Warehouse');
//                }
//                var _form = Warehouse.Form.create(data, true);
//                Modal.processEdit.add(_form);
//                Modal.processEdit.show();
//            }
        };

        Warehouse.Action.remove = function() {
//            var selected = Warehouse.Grid.grid.getSelectionModel().getSelection();
//            var arrayDeleted = [];
//            _.each(selected, function(obj) {
//                var data = {
//                    id: obj.data.id
//                };
//                arrayDeleted.push(data);
//            });
//            Modal.deleteAlert(arrayDeleted, Warehouse.URL.remove, Warehouse.Data);
        };

        Warehouse.Action.print = function() {
//            var selected = Warehouse.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = Warehouse.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
//            var gridHeaderList = "";
//            //index starts at 2 to exclude the No. column
//            for (var i = 2; i < gridHeader.length; i++)
//            {
//                if (gridHeader[i].dataIndex == undefined || gridHeader[i].dataIndex == "") //filter the action columns in grid
//                {
//                    //do nothing
//                }
//                else
//                {
//                    gridHeaderList += gridHeader[i].text + "&&" + gridHeader[i].dataIndex + "^^";
//                }
//            }
//
//            var serverSideModelName = "Warehouse_Model";
//            var title = "Warehouse Umum";
//            var primaryKeys = "id";
//
//            my_form = document.createElement('FORM');
//            my_form.name = 'myForm';
//            my_form.method = 'POST';
//            my_form.action = BASE_URL + 'excel_management/exportToExcel/';
//
//            my_tb = document.createElement('INPUT');
//            my_tb.type = 'HIDDEN';
//            my_tb.name = 'serverSideModelName';
//            my_tb.value = serverSideModelName;
//            my_form.appendChild(my_tb);
//
//            my_tb = document.createElement('INPUT');
//            my_tb.type = 'HIDDEN';
//            my_tb.name = 'title';
//            my_tb.value = title;
//            my_form.appendChild(my_tb);
//            document.body.appendChild(my_form);
//
//            my_tb = document.createElement('INPUT');
//            my_tb.type = 'HIDDEN';
//            my_tb.name = 'primaryKeys';
//            my_tb.value = primaryKeys;
//            my_form.appendChild(my_tb);
//            document.body.appendChild(my_form);
//
//            my_tb = document.createElement('INPUT');
//            my_tb.type = 'HIDDEN';
//            my_tb.name = 'gridHeaderList';
//            my_tb.value = gridHeaderList;
//            my_form.appendChild(my_tb);
//            document.body.appendChild(my_form);
//
//            my_tb = document.createElement('INPUT');
//            my_tb.type = 'HIDDEN';
//            my_tb.name = 'selectedData';
//            my_tb.value = selectedData;
//            my_form.appendChild(my_tb);
//            document.body.appendChild(my_form);
//
//            my_form.submit();
        };

        var setting = {
            grid: {
                id: 'grid_Warehouse',
                title: 'WAREHOUSE',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Id', dataIndex: 'id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Lokasi', dataIndex: 'nama_unker', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
             
                ]
            },
            search: {
                id: 'search_Warehouse'
            },
            toolbar: {
                id: 'toolbar_Warehouse',
                add: {
                    id: 'button_add_Warehouse',
                    action: Warehouse.Action.add
                },
                edit: {
                    id: 'button_edit_Warehouse',
                    action: Warehouse.Action.edit
                },
                remove: {
                    id: 'button_remove_Warehouse',
                    action: Warehouse.Action.remove
                },
                print: {
                    id: 'button_print_Warehouse',
                    action: Warehouse.Action.print
                }
            }
        };

        Warehouse.Grid.grid = Grid.processGrid(setting, Warehouse.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_warehouse', title: 'Warehouse', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Warehouse.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>