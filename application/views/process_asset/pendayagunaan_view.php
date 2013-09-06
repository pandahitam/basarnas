<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_Pendayagunaan = null;

        Ext.namespace('Pendayagunaan', 'Pendayagunaan.reader', 'Pendayagunaan.proxy', 'Pendayagunaan.Data', 'Pendayagunaan.Grid', 'Pendayagunaan.Window', 'Pendayagunaan.Form', 'Pendayagunaan.Action', 'Pendayagunaan.URL');
        Pendayagunaan.URL = {
            read: BASE_URL + 'pendayagunaan/getAllData',
            createUpdate: BASE_URL + 'pendayagunaan/modifyPendayagunaan',
            remove: BASE_URL + 'pendayagunaan/deletePendayagunaan'
        };

        Pendayagunaan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Pendayagunaan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Pendayagunaan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        Pendayagunaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Pendayagunaan',
            url: Pendayagunaan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Pendayagunaan.reader,
            writer: Pendayagunaan.writer,
            afterRequest: function(request, success) {
                Params_M_Pendayagunaan = request.operation.params;
            }
        });

        Pendayagunaan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Pendayagunaan', storeId: 'DataPendayagunaan', model: 'MPendayagunaan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Pendayagunaan.proxy, groupField: 'tipe'
        });

        Pendayagunaan.Form.create = function(data, edit) {
            var setting = {
                url: Pendayagunaan.URL.createUpdate,
                data: Pendayagunaan.Data,
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
                            console.error('There is existing grid in the popup selection - pendayagunaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };
            var form = Form.pendayagunaan(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
//                var task = Ext.TaskManager.start({
//                    run: function () {
//                        form.getForm().setValues(data)
//                    },
//                    interval: 1000,
//                    repeat:2
//                });
            }
            return form;
        };

        Pendayagunaan.Action.add = function() {
            var _form = Pendayagunaan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Pendayagunaan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        Pendayagunaan.Action.edit = function() {
            var selected = Pendayagunaan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;
                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Pendayagunaan');
                }
                var _form = Pendayagunaan.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        Pendayagunaan.Action.remove = function() {
            var selected = Pendayagunaan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, Pendayagunaan.URL.remove, Pendayagunaan.Data);
        };

        Pendayagunaan.Action.print = function() {
            var selected = Pendayagunaan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = Pendayagunaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Pendayagunaan_Model";
            var title = "Pendayagunaan ";
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
                id: 'grid_Pendayagunaan',
                title: 'DAFTAR PENDAYAGUNAAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', flex:0.5, hidden: true, groupable: false, filter: {type: 'number'}},
                    {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset',flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', flex:1, groupable: false, filter: {type: 'string'}},
                    {header: 'Serial Number', dataIndex: 'serial_number', flex:1, groupable: false, filter: {type: 'string'}},
                    {header: 'Mode Pendayagunaan', dataIndex: 'mode_pendayagunaan', flex:1.5, groupable: false, filter: {type: 'string'}},
                    {header: 'Pihak Ke-Tiga', dataIndex: 'pihak_ketiga', flex:1, hidden: false, groupable: false},
                    {header: 'Tanggal Mulai', dataIndex: 'tanggal_start', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Selesai', dataIndex: 'tanggal_end', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Deksiprisi', dataIndex: 'description', flex:1, hidden: false, groupable: false},
                    {header: 'Document', dataIndex: 'document', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Aset', dataIndex: 'nama', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                    
                    
                ]
            },
            search: {
                id: 'search_Pendayagunaan'
            },
            toolbar: {
                id: 'toolbar_Pendayagunaan',
                add: {
                    id: 'button_add_Pendayagunaan',
                    action: Pendayagunaan.Action.add
                },
                edit: {
                    id: 'button_edit_Pendayagunaan',
                    action: Pendayagunaan.Action.edit
                },
                remove: {
                    id: 'button_remove_Pendayagunaan',
                    action: Pendayagunaan.Action.remove
                },
                print: {
                    id: 'button_print_Pendayagunaan',
                    action: Pendayagunaan.Action.print
                }
            }
        };

        Pendayagunaan.Grid.grid = Grid.processGrid(setting, Pendayagunaan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'pendayagunaan_asset', title: 'Pendayagunaan ', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Region.filterPanelPerencanaan(Pendayagunaan.Data), Pendayagunaan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>