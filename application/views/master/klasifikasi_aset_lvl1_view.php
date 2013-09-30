<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_KlasifikasiAsetLvl1 = null;

        Ext.namespace('KlasifikasiAsetLvl1', 'KlasifikasiAsetLvl1.reader', 'KlasifikasiAsetLvl1.proxy', 'KlasifikasiAsetLvl1.Data', 'KlasifikasiAsetLvl1.Grid', 'KlasifikasiAsetLvl1.Window', 'KlasifikasiAsetLvl1.Form', 'KlasifikasiAsetLvl1.Action', 'KlasifikasiAsetLvl1.URL');
        KlasifikasiAsetLvl1.URL = {
            read: BASE_URL + 'master_data/klasifikasi_aset_lvl1_getAllData',
            createUpdate: BASE_URL + 'master_data/klasifikasi_aset_lvl1_modifyKlasifikasiAsetLvl1',
            remove: BASE_URL + 'master_data/klasifikasi_aset_lvl1_deleteKlasifikasiAsetLvl1'
        };

        KlasifikasiAsetLvl1.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KlasifikasiAsetLvl1', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KlasifikasiAsetLvl1.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KlasifikasiAsetLvl1.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KlasifikasiAsetLvl1',
            url: KlasifikasiAsetLvl1.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KlasifikasiAsetLvl1.reader,
            writer: KlasifikasiAsetLvl1.writer,
            afterRequest: function(request, success) {
                Params_M_KlasifikasiAsetLvl1 = request.operation.params;
            }
        });

        KlasifikasiAsetLvl1.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KlasifikasiAsetLvl1', storeId: 'DataKlasifikasiAsetLvl1', model: 'MKlasifikasiAsetLvl1', pageSize: 20, noCache: false, autoLoad: true,
            proxy: KlasifikasiAsetLvl1.proxy, groupField: 'tipe'
        });

        KlasifikasiAsetLvl1.Form.create = function(data, edit) {
            var setting = {
                url: KlasifikasiAsetLvl1.URL.createUpdate,
                data: KlasifikasiAsetLvl1.Data,
                isEditing: edit,
            };

            var form = Form.referensiKlasifikasiAsetLvl1(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
            }
            return form;
        };

        KlasifikasiAsetLvl1.Action.add = function() {
            var _form = KlasifikasiAsetLvl1.Form.create(null, false);
            Modal.smallWindow.setTitle('Create KlasifikasiAsetLvl1');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KlasifikasiAsetLvl1.Action.edit = function() {
            var selected = KlasifikasiAsetLvl1.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit KlasifikasiAsetLvl1');
                }
                var _form = KlasifikasiAsetLvl1.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KlasifikasiAsetLvl1.Action.remove = function() {
            var selected = KlasifikasiAsetLvl1.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.kd_lvl1
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, KlasifikasiAsetLvl1.URL.remove, KlasifikasiAsetLvl1.Data);
        };

        KlasifikasiAsetLvl1.Action.print = function() {
//            var selected = KlasifikasiAsetLvl1.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KlasifikasiAsetLvl1.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KlasifikasiAsetLvl1_Model";
//            var title = "KlasifikasiAsetLvl1 Umum";
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
                id: 'grid_KlasifikasiAsetLvl1',
                title: 'KLASIFIKASI ASET LEVEL 1',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Lvl1', dataIndex: 'kd_lvl1', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KlasifikasiAsetLvl1'
            },
            toolbar: {
                id: 'toolbar_KlasifikasiAsetLvl1',
                add: {
                    id: 'button_add_KlasifikasiAsetLvl1',
                    action: KlasifikasiAsetLvl1.Action.add
                },
                edit: {
                    id: 'button_edit_KlasifikasiAsetLvl1',
                    action: KlasifikasiAsetLvl1.Action.edit
                },
                remove: {
                    id: 'button_remove_KlasifikasiAsetLvl1',
                    action: KlasifikasiAsetLvl1.Action.remove
                },
                print: {
                    id: 'button_print_KlasifikasiAsetLvl1',
                    action: KlasifikasiAsetLvl1.Action.print
                }
            }
        };

        KlasifikasiAsetLvl1.Grid.grid = Grid.processGrid(setting, KlasifikasiAsetLvl1.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_klasifikasi_asset_lvl1', title: 'Klasifikasi Aset Lvl1', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KlasifikasiAsetLvl1.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>