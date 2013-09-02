<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_KlasifikasiAsetLvl2 = null;

        Ext.namespace('KlasifikasiAsetLvl2', 'KlasifikasiAsetLvl2.reader', 'KlasifikasiAsetLvl2.proxy', 'KlasifikasiAsetLvl2.Data', 'KlasifikasiAsetLvl2.Grid', 'KlasifikasiAsetLvl2.Window', 'KlasifikasiAsetLvl2.Form', 'KlasifikasiAsetLvl2.Action', 'KlasifikasiAsetLvl2.URL');
        KlasifikasiAsetLvl2.URL = {
            read: BASE_URL + 'master_data/klasifikasi_aset_lvl2_getAllData',
            createUpdate: BASE_URL + 'master_data/klasifikasi_aset_lvl2_modifyKlasifikasiAsetLvl2',
            remove: BASE_URL + 'master_data/klasifikasi_aset_lvl2_deleteKlasifikasiAsetLvl2'
        };

        KlasifikasiAsetLvl2.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KlasifikasiAsetLvl2', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KlasifikasiAsetLvl2.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KlasifikasiAsetLvl2.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KlasifikasiAsetLvl2',
            url: KlasifikasiAsetLvl2.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KlasifikasiAsetLvl2.reader,
            writer: KlasifikasiAsetLvl2.writer,
            afterRequest: function(request, success) {
                Params_M_KlasifikasiAsetLvl2 = request.operation.params;
            }
        });

        KlasifikasiAsetLvl2.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KlasifikasiAsetLvl2', storeId: 'DataKlasifikasiAsetLvl2', model: 'MKlasifikasiAsetLvl2', pageSize: 20, noCache: false, autoLoad: true,
            proxy: KlasifikasiAsetLvl2.proxy, groupField: 'tipe'
        });

        KlasifikasiAsetLvl2.Form.create = function(data, edit) {
            var setting = {
                url: KlasifikasiAsetLvl2.URL.createUpdate,
                data: KlasifikasiAsetLvl2.Data,
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

        KlasifikasiAsetLvl2.Action.add = function() {
            var _form = KlasifikasiAsetLvl2.Form.create(null, false);
            Modal.processCreate.setTitle('Create KlasifikasiAsetLvl2');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        KlasifikasiAsetLvl2.Action.edit = function() {
            var selected = KlasifikasiAsetLvl2.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit KlasifikasiAsetLvl2');
                }
                var _form = KlasifikasiAsetLvl2.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        KlasifikasiAsetLvl2.Action.remove = function() {
            var selected = KlasifikasiAsetLvl2.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, KlasifikasiAsetLvl2.URL.remove, KlasifikasiAsetLvl2.Data);
        };

        KlasifikasiAsetLvl2.Action.print = function() {
            var selected = KlasifikasiAsetLvl2.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = KlasifikasiAsetLvl2.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "KlasifikasiAsetLvl2_Model";
            var title = "KlasifikasiAsetLvl2 Umum";
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
                id: 'grid_KlasifikasiAsetLvl2',
                title: 'KLASIFIKASI ASET LEVEL 2',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Lvl1', dataIndex: 'kd_lvl1', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lvl2', dataIndex: 'kd_lvl2', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KlasifikasiAsetLvl2'
            },
            toolbar: {
                id: 'toolbar_KlasifikasiAsetLvl2',
                add: {
                    id: 'button_add_KlasifikasiAsetLvl2',
                    action: KlasifikasiAsetLvl2.Action.add
                },
                edit: {
                    id: 'button_edit_KlasifikasiAsetLvl2',
                    action: KlasifikasiAsetLvl2.Action.edit
                },
                remove: {
                    id: 'button_remove_KlasifikasiAsetLvl2',
                    action: KlasifikasiAsetLvl2.Action.remove
                },
                print: {
                    id: 'button_print_KlasifikasiAsetLvl2',
                    action: KlasifikasiAsetLvl2.Action.print
                }
            }
        };

        KlasifikasiAsetLvl2.Grid.grid = Grid.processGrid(setting, KlasifikasiAsetLvl2.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_klasifikasi_asset_lvl2', title: 'Klasifikasi Aset Lvl2', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KlasifikasiAsetLvl2.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>