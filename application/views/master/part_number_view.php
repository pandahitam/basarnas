<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_PartNumber = null;

        Ext.namespace('PartNumber', 'PartNumber.reader', 'PartNumber.proxy', 'PartNumber.Data', 'PartNumber.Grid', 'PartNumber.Window', 'PartNumber.Form', 'PartNumber.Action', 'PartNumber.URL');
        PartNumber.URL = {
            read: BASE_URL + 'master_data/partNumber_getAllData',
            createUpdate: BASE_URL + 'master_data/partNumber_modifyPartNumber',
            remove: BASE_URL + 'master_data/partNumber_deletePartNumber'
        };

        PartNumber.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.PartNumber', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        PartNumber.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        PartNumber.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_PartNumber',
            url: PartNumber.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: PartNumber.reader,
            writer: PartNumber.writer,
            afterRequest: function(request, success) {
                Params_M_PartNumber = request.operation.params;
            }
        });

        PartNumber.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_PartNumber', storeId: 'DataPartNumber', model: 'MPartNumber', pageSize: 50, noCache: false, autoLoad: true,
            proxy: PartNumber.proxy, groupField: 'tipe'
        });

        PartNumber.Form.create = function(data, edit) {
            var setting = {
                url: PartNumber.URL.createUpdate,
                data: PartNumber.Data,
                isEditing: edit,
               
            };

            var form = Form.referensiPartNumber(setting);

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

        PartNumber.Action.add = function() {
            var _form = PartNumber.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Part Number');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        PartNumber.Action.edit = function() {
            var selected = PartNumber.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Part Number');
                }
                var _form = PartNumber.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        PartNumber.Action.remove = function() {
            var selected = PartNumber.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, PartNumber.URL.remove, PartNumber.Data);
        };

        PartNumber.Action.print = function() {
//            var selected = PartNumber.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = PartNumber.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "PartNumber_Model";
//            var title = "PartNumber Umum";
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
                id: 'grid_PartNumber',
                title: 'Part Number',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'id', dataIndex: 'id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'vendor_id', dataIndex: 'vendor_id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kelompok Part', dataIndex: 'nama_kelompok', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Jenis Angkutan', dataIndex: 'jenis_asset', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number Substitusi', dataIndex: 'part_number_substitusi', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Merek', dataIndex: 'merek', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Jenis', dataIndex: 'jenis', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Umur Maksimum (Jam/Km)', dataIndex: 'umur_maks', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    
             
                ]
            },
            search: {
                id: 'search_PartNumber'
            },
            toolbar: {
                id: 'toolbar_PartNumber',
                add: {
                    id: 'button_add_PartNumber',
                    action: PartNumber.Action.add
                },
                edit: {
                    id: 'button_edit_PartNumber',
                    action: PartNumber.Action.edit
                },
                remove: {
                    id: 'button_remove_PartNumber',
                    action: PartNumber.Action.remove
                },
                print: {
                    id: 'button_print_PartNumber',
                    action: PartNumber.Action.print
                }
            }
        };

        PartNumber.Grid.grid = Grid.referensiGrid(setting, PartNumber.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_partnumber', title: 'PartNumber', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [PartNumber.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>