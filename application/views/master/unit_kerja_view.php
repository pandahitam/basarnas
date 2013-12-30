<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_UnitKerja = null;

        Ext.namespace('UnitKerja', 'UnitKerja.reader', 'UnitKerja.proxy', 'UnitKerja.Data', 'UnitKerja.Grid', 'UnitKerja.Window', 'UnitKerja.Form', 'UnitKerja.Action', 'UnitKerja.URL');
        UnitKerja.URL = {
            read: BASE_URL + 'master_data/unitkerja_getAllData',
            create: BASE_URL + 'master_data/unitkerja_createUnitKerja',
            update: BASE_URL + 'master_data/unitkerja_modifyUnitKerja',
            remove: BASE_URL + 'master_data/unitkerja_deleteUnitKerja'
        };

        UnitKerja.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.UnitKerja', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        UnitKerja.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        UnitKerja.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_UnitKerja',
            url: UnitKerja.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: UnitKerja.reader,
            writer: UnitKerja.writer,
            afterRequest: function(request, success) {
                Params_M_UnitKerja = request.operation.params;
            }
        });

        UnitKerja.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_UnitKerja', storeId: 'DataUnitKerja', model: 'MUnitKerja', pageSize: 50, noCache: false, autoLoad: true,
            proxy: UnitKerja.proxy, groupField: 'tipe'
        });

        UnitKerja.Form.create = function(data, edit) {
            if(edit == true)
            {
                var setting = {
                url: UnitKerja.URL.update,
                data: UnitKerja.Data,
                isEditing: edit,
               
                };
            }
            else if(edit == false)
            {
                var setting = {
                url: UnitKerja.URL.create,
                data: UnitKerja.Data,
                isEditing: edit,
               
                };
            }
            

            var form = Form.referensiUnitKerja(setting);

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

        UnitKerja.Action.add = function() {
            var _form = UnitKerja.Form.create(null, false);
            Modal.smallWindow.setTitle('Create UnitKerja');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        UnitKerja.Action.edit = function() {
            var selected = UnitKerja.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit UnitKerja');
                }
                var _form = UnitKerja.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        UnitKerja.Action.remove = function() {
            var selected = UnitKerja.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.kdlok
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, UnitKerja.URL.remove, UnitKerja.Data);
        };

        UnitKerja.Action.print = function() {
//            var selected = UnitKerja.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = UnitKerja.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "UnitKerja_Model";
//            var title = "UnitKerja Umum";
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
                id: 'grid_UnitKerja',
                title: 'Unit Kerja',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'kd_pebin', dataIndex: 'kd_pebin', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'kd_pbi', dataIndex: 'kd_pbi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'kd_ppbi', dataIndex: 'kd_ppbi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'kd_upb', dataIndex: 'kd_upb', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'kd_subupb', dataIndex: 'kd_subupb', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'kd_jk', dataIndex: 'kd_jk', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kdlok', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'ur_upb', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
             
                ]
            },
            search: {
                id: 'search_UnitKerja'
            },
            toolbar: {
                id: 'toolbar_UnitKerja',
                add: {
                    id: 'button_add_UnitKerja',
                    action: UnitKerja.Action.add
                },
                edit: {
                    id: 'button_edit_UnitKerja',
                    action: UnitKerja.Action.edit
                },
                remove: {
                    id: 'button_remove_UnitKerja',
                    action: UnitKerja.Action.remove
                },
                print: {
                    id: 'button_print_UnitKerja',
                    action: UnitKerja.Action.print
                }
            }
        };

        UnitKerja.Grid.grid = Grid.referensiGrid(setting, UnitKerja.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_unit_kerja', title: 'UnitKerja', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [UnitKerja.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>