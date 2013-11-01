<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_Rak = null;

        Ext.namespace('Rak', 'Rak.reader', 'Rak.proxy', 'Rak.Data', 'Rak.Grid', 'Rak.Window', 'Rak.Form', 'Rak.Action', 'Rak.URL');
        Rak.URL = {
            read: BASE_URL + 'master_data/rak_getAllData',
            create: BASE_URL + 'master_data/rak_createRak',
            update: BASE_URL + 'master_data/rak_modifyRak',
            remove: BASE_URL + 'master_data/rak_deleteRak'
        };

        Rak.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Rak', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Rak.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        Rak.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Rak',
            url: Rak.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Rak.reader,
            writer: Rak.writer,
            afterRequest: function(request, success) {
                Params_M_Rak = request.operation.params;
            }
        });

        Rak.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Rak', storeId: 'DataRak', model: 'MRak', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Rak.proxy, groupField: 'tipe'
        });

        Rak.Form.create = function(data, edit) {
            if(edit == true)
            {
                 var setting = {
                url: Rak.URL.update,
                data: Rak.Data,
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
                            console.error('There is existing grid in the popup selection - pemeliharaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
                };
            }
            else
            {
                var setting = {
                url: Rak.URL.create,
                data: Rak.Data,
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
                            console.error('There is existing grid in the popup selection - pemeliharaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
                };
            }
           

            var form = Form.referensiRak(setting);

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

        Rak.Action.add = function() {
            var _form = Rak.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Rak');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        Rak.Action.edit = function() {
            var selected = Rak.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Rak');
                }
                var _form = Rak.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        Rak.Action.remove = function() {
            var selected = Rak.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, Rak.URL.remove, Rak.Data);
        };

        Rak.Action.print = function() {
//            var selected = Rak.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = Rak.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "Rak_Model";
//            var title = "Rak Umum";
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
                id: 'grid_Rak',
                title: 'RAK',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Id', dataIndex: 'id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Warehouse Ruang', dataIndex: 'warehouseruang_id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Id Warehouse', dataIndex: 'warehouse_id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Warehouse', dataIndex: 'nama_warehouse', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Ruang', dataIndex: 'nama_ruang', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
             
                ]
            },
            search: {
                id: 'search_Rak'
            },
            toolbar: {
                id: 'toolbar_Rak',
                add: {
                    id: 'button_add_Rak',
                    action: Rak.Action.add
                },
                edit: {
                    id: 'button_edit_Rak',
                    action: Rak.Action.edit
                },
                remove: {
                    id: 'button_remove_Rak',
                    action: Rak.Action.remove
                },
                print: {
                    id: 'button_print_Rak',
                    action: Rak.Action.print
                }
            }
        };

        Rak.Grid.grid = Grid.referensiGrid(setting, Rak.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_rak', title: 'Rak', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Rak.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>