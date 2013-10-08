<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_KlasifikasiAsetLvl3 = null;

        Ext.namespace('KlasifikasiAsetLvl3', 'KlasifikasiAsetLvl3.reader', 'KlasifikasiAsetLvl3.proxy', 'KlasifikasiAsetLvl3.Data', 'KlasifikasiAsetLvl3.Grid', 'KlasifikasiAsetLvl3.Window', 'KlasifikasiAsetLvl3.Form', 'KlasifikasiAsetLvl3.Action', 'KlasifikasiAsetLvl3.URL');
        KlasifikasiAsetLvl3.URL = {
            read: BASE_URL + 'master_data/klasifikasi_aset_lvl3_getAllData',
            createUpdate: BASE_URL + 'master_data/klasifikasi_aset_lvl3_modifyKlasifikasiAsetLvl3',
            remove: BASE_URL + 'master_data/klasifikasi_aset_lvl3_deleteKlasifikasiAsetLvl3'
        };

        KlasifikasiAsetLvl3.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KlasifikasiAsetLvl3', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KlasifikasiAsetLvl3.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KlasifikasiAsetLvl3.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KlasifikasiAsetLvl3',
            url: KlasifikasiAsetLvl3.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KlasifikasiAsetLvl3.reader,
            writer: KlasifikasiAsetLvl3.writer,
            afterRequest: function(request, success) {
                Params_M_KlasifikasiAsetLvl3 = request.operation.params;
            }
        });

        KlasifikasiAsetLvl3.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KlasifikasiAsetLvl3', storeId: 'DataKlasifikasiAsetLvl3', model: 'MKlasifikasiAsetLvl3', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KlasifikasiAsetLvl3.proxy, groupField: 'tipe'
        });

        KlasifikasiAsetLvl3.Form.create = function(data, edit) {
            var setting = {
                url: KlasifikasiAsetLvl3.URL.createUpdate,
                data: KlasifikasiAsetLvl3.Data,
                isEditing: edit,
            };

            var form = Form.referensiKlasifikasiAsetLvl3(setting);

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

        KlasifikasiAsetLvl3.Action.add = function() {
            var _form = KlasifikasiAsetLvl3.Form.create(null, false);
            Modal.smallWindow.setTitle('Create KlasifikasiAsetLvl3');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KlasifikasiAsetLvl3.Action.edit = function() {
            var selected = KlasifikasiAsetLvl3.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit KlasifikasiAsetLvl3');
                }
                var _form = KlasifikasiAsetLvl3.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KlasifikasiAsetLvl3.Action.remove = function() {
            var selected = KlasifikasiAsetLvl3.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.kd_klasifikasi_aset
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, KlasifikasiAsetLvl3.URL.remove, KlasifikasiAsetLvl3.Data);
        };

        KlasifikasiAsetLvl3.Action.print = function() {
//            var selected = KlasifikasiAsetLvl3.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KlasifikasiAsetLvl3.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KlasifikasiAsetLvl3_Model";
//            var title = "KlasifikasiAsetLvl3 Umum";
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
                id: 'grid_KlasifikasiAsetLvl3',
                title: 'KLASIFIKASI ASET LEVEL 3',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Lvl1', dataIndex: 'kd_lvl1', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lvl2', dataIndex: 'kd_lvl2', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Lvl2', dataIndex: 'nama_lvl2', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lvl3', dataIndex: 'kd_lvl3', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', width: 90, hidden: true, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KlasifikasiAsetLvl3'
            },
            toolbar: {
                id: 'toolbar_KlasifikasiAsetLvl3',
                add: {
                    id: 'button_add_KlasifikasiAsetLvl3',
                    action: KlasifikasiAsetLvl3.Action.add
                },
                edit: {
                    id: 'button_edit_KlasifikasiAsetLvl3',
                    action: KlasifikasiAsetLvl3.Action.edit
                },
                remove: {
                    id: 'button_remove_KlasifikasiAsetLvl3',
                    action: KlasifikasiAsetLvl3.Action.remove
                },
                print: {
                    id: 'button_print_KlasifikasiAsetLvl3',
                    action: KlasifikasiAsetLvl3.Action.print
                }
            }
        };

        KlasifikasiAsetLvl3.Grid.grid = Grid.processGrid(setting, KlasifikasiAsetLvl3.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_klasifikasi_asset', title: 'Klasifikasi Aset Lvl3', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KlasifikasiAsetLvl3.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>