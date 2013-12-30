<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_ReferensiRuang = null;

        Ext.namespace('ReferensiRuang', 'ReferensiRuang.reader', 'ReferensiRuang.proxy', 'ReferensiRuang.Data', 'ReferensiRuang.Grid', 'ReferensiRuang.Window', 'ReferensiRuang.Form', 'ReferensiRuang.Action', 'ReferensiRuang.URL');
        ReferensiRuang.URL = {
            read: BASE_URL + 'master_data/referensi_ruang_getAllData',
            create: BASE_URL + 'master_data/referensi_ruang_createReferensiRuang',
            update: BASE_URL + 'master_data/referensi_ruang_modifyReferensiRuang',
            remove: BASE_URL + 'master_data/referensi_ruang_deleteReferensiRuang'
        };

        ReferensiRuang.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.ReferensiRuang', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        ReferensiRuang.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        ReferensiRuang.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_ReferensiRuang',
            url: ReferensiRuang.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: ReferensiRuang.reader,
            writer: ReferensiRuang.writer,
            afterRequest: function(request, success) {
                Params_M_ReferensiRuang = request.operation.params;
            }
        });

        ReferensiRuang.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_ReferensiRuang', storeId: 'DataReferensiRuang', model: 'MReferensiRuang', pageSize: 50, noCache: false, autoLoad: true,
            proxy: ReferensiRuang.proxy, groupField: 'tipe'
        });

        ReferensiRuang.Form.create = function(data, edit) {
            if(edit == true)
            {
                 var setting = {
                url: ReferensiRuang.URL.update,
                data: ReferensiRuang.Data,
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
                url: ReferensiRuang.URL.create,
                data: ReferensiRuang.Data,
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
           

            var form = Form.referensiReferensiRuang(setting);

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

        ReferensiRuang.Action.add = function() {
            var _form = ReferensiRuang.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Referensi Ruang');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        ReferensiRuang.Action.edit = function() {
            var selected = ReferensiRuang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Referensi Ruang');
                }
                var _form = ReferensiRuang.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        ReferensiRuang.Action.remove = function() {
            var selected = ReferensiRuang.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_lokasi:obj.data.kd_lokasi,
                    kd_ruang: obj.data.kd_ruang
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, ReferensiRuang.URL.remove, ReferensiRuang.Data);
        };

        ReferensiRuang.Action.print = function() {
//            var selected = ReferensiRuang.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = ReferensiRuang.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "ReferensiRuang_Model";
//            var title = "ReferensiRuang Umum";
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
                id: 'grid_ReferensiRuang',
                title: 'REFERENSI RUANG',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Ruang', dataIndex: 'kd_ruang', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Ruang', dataIndex: 'ur_ruang', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Unor', dataIndex: 'kd_unor', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_ReferensiRuang'
            },
            toolbar: {
                id: 'toolbar_ReferensiRuang',
                add: {
                    id: 'button_add_ReferensiRuang',
                    action: ReferensiRuang.Action.add
                },
                edit: {
                    id: 'button_edit_ReferensiRuang',
                    action: ReferensiRuang.Action.edit
                },
                remove: {
                    id: 'button_remove_ReferensiRuang',
                    action: ReferensiRuang.Action.remove
                },
                print: {
                    id: 'button_print_ReferensiRuang',
                    action: ReferensiRuang.Action.print
                }
            }
        };

        ReferensiRuang.Grid.grid = Grid.referensiGrid(setting, ReferensiRuang.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_referensi_ruang', title: 'Referensi Ruang', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [ReferensiRuang.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>