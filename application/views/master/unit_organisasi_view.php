<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_UnitOrganisasi = null;

        Ext.namespace('UnitOrganisasi', 'UnitOrganisasi.reader', 'UnitOrganisasi.proxy', 'UnitOrganisasi.Data', 'UnitOrganisasi.Grid', 'UnitOrganisasi.Window', 'UnitOrganisasi.Form', 'UnitOrganisasi.Action', 'UnitOrganisasi.URL');
        UnitOrganisasi.URL = {
            read: BASE_URL + 'master_data/unitorganisasi_getAllData',
            createUpdate: BASE_URL + 'master_data/unitorganisasi_modifyUnitOrganisasi',
            remove: BASE_URL + 'master_data/unitorganisasi_deleteUnitOrganisasi'
        };

        UnitOrganisasi.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.UnitOrganisasi', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        UnitOrganisasi.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        UnitOrganisasi.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_UnitOrganisasi',
            url: UnitOrganisasi.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: UnitOrganisasi.reader,
            writer: UnitOrganisasi.writer,
            afterRequest: function(request, success) {
                Params_M_UnitOrganisasi = request.operation.params;
            }
        });

        UnitOrganisasi.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_UnitOrganisasi', storeId: 'DataUnitOrganisasi', model: 'MUnitOrganisasi', pageSize: 50, noCache: false, autoLoad: true,
            proxy: UnitOrganisasi.proxy, groupField: 'tipe'
        });

        UnitOrganisasi.Form.create = function(data, edit) {
            var setting = {
                url: UnitOrganisasi.URL.createUpdate,
                data: UnitOrganisasi.Data,
                isEditing: edit,
               
            };

            var form = Form.referensiUnitOrganisasi(setting);

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
            
            if(edit == false)
            {
                var kode_unor = '';
                $.ajax({
                       url:BASE_URL + 'master_data/unitorganisasi_getLastKodeUnor',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       success:function(response, status){
                          kode_unor = response;
                       }
                    });
                var data_kode_unor = {
                    kode_unor: kode_unor
                };
                form.getForm().setValues(data_kode_unor)
            }
            return form;
        };

        UnitOrganisasi.Action.add = function() {
            var _form = UnitOrganisasi.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Unit Organisasi');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        UnitOrganisasi.Action.edit = function() {
            var selected = UnitOrganisasi.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Unit Organisasi');
                }
                var _form = UnitOrganisasi.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        UnitOrganisasi.Action.remove = function() {
            var selected = UnitOrganisasi.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.ID_Unor
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, UnitOrganisasi.URL.remove, UnitOrganisasi.Data);
        };

        UnitOrganisasi.Action.print = function() {
//            var selected = UnitOrganisasi.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = UnitOrganisasi.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "UnitOrganisasi_Model";
//            var title = "UnitOrganisasi Umum";
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
                id: 'grid_UnitOrganisasi',
                title: 'Unit Organisasi',
                column: [
                {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                {header: "Kode Unor", dataIndex: 'kode_unor', groupable: false, width: 150},
                {header: "Nama Unor", dataIndex: 'nama_unor', width: 300},
//                {header: "Nama Jabatan", dataIndex: 'jabatan_unor', width: 300},
                {header: "Nama Unit Kerja", dataIndex: 'nama_unker', width: 300},
             
                ]
            },
            search: {
                id: 'search_UnitOrganisasi'
            },
            toolbar: {
                id: 'toolbar_UnitOrganisasi',
                add: {
                    id: 'button_add_UnitOrganisasi',
                    action: UnitOrganisasi.Action.add
                },
                edit: {
                    id: 'button_edit_UnitOrganisasi',
                    action: UnitOrganisasi.Action.edit
                },
                remove: {
                    id: 'button_remove_UnitOrganisasi',
                    action: UnitOrganisasi.Action.remove
                },
                print: {
                    id: 'button_print_UnitOrganisasi',
                    action: UnitOrganisasi.Action.print
                }
            }
        };

        UnitOrganisasi.Grid.grid = Grid.processGrid(setting, UnitOrganisasi.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_unit_organisasi', title: 'UnitOrganisasi', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [UnitOrganisasi.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>