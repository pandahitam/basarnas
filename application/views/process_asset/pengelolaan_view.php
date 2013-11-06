<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
        ////PANEL UTAMA PENGELOLAAN DATA  -------------------------------------------- START
        var Params_M_Pengelolaan = null;

        Ext.namespace('Pengelolaan', 'Pengelolaan.reader', 'Pengelolaan.proxy', 'Pengelolaan.Data', 'Pengelolaan.Grid', 'Pengelolaan.Window', 'Pengelolaan.Form', 'Pengelolaan.Action', 'Pengelolaan.URL');

        Pengelolaan.URL = {
            read: BASE_URL + 'Pengelolaan/getAllData',
            createUpdate: BASE_URL + 'Pengelolaan/modifyPengelolaan',
            remove: BASE_URL + 'Pengelolaan/deletePengelolaan',
        }

        Pengelolaan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Pengelolaan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Pengelolaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Pengelolaan',
            url: Pengelolaan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Pengelolaan.reader,
            afterRequest: function(request, success) {
                Params_M_Pengelolaan = request.operation.params;
            }
        });

        Pengelolaan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Pengelolaan', storeId: 'DataPengelolaan', model: 'MPengelolaan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Pengelolaan.proxy, groupField: 'tipe'
        });

        Pengelolaan.Form.create = function(data, edit) {
            var setting = {
                url: Pengelolaan.URL.createUpdate,
                data: Pengelolaan.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: edit,
                    text: 'Add Reference',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset());
                            Modal.assetSelection.show();
                        }
                        else
                        {
                            console.error('There is existing grid in the popup');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };
//            debugger;
            var form = Form.pengelolaan(setting);

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


        Pengelolaan.Action.add = function() {
            var _form = Pengelolaan.Form.create(null, false)
            Modal.processCreate.setTitle('Create Pengelolaan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        Pengelolaan.Action.edit = function() {
            var selected = Pengelolaan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Pengelolaan');
                }
                var _form = Pengelolaan.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        Pengelolaan.Action.remove = function() {
            var selected = Pengelolaan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, Pengelolaan.URL.remove, Pengelolaan.Data);
        };

        Pengelolaan.Action.print = function() {

            var selected = Pengelolaan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = Pengelolaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Pengelolaan_Model";
            var title = "Pengelolaan";
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
                id: 'grid_Pengelolaan',
                title: 'DAFTAR PENGELOLAAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', flex:0.5, groupable: false, hidden:true, filter: {type: 'number'}},
                    {header: 'Nama Operasi SAR', dataIndex: 'nama_operasi', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'PIC', dataIndex: 'pic', flex: 1, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Mulai', dataIndex: 'tanggal_mulai', flex: 1, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Selesai', dataIndex: 'tanggal_selesai', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Deskripsi', dataIndex: 'deskripsi', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Barang', dataIndex: 'nama', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Image Url', dataIndex: 'image_url', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Document Url', dataIndex: 'document_url', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},


                ]
            },
            search: {
                id: 'search_Pengelolaan'
            },
            toolbar: {
                id: 'toolbar_Pengelolaan',
                add: {
                    id: 'button_add_Pengelolaan',
                    action: Pengelolaan.Action.add,
                    disabled:pengelolaan_insert,
                },
                edit: {
                    id: 'button_edit_Pengelolaan',
                    action: Pengelolaan.Action.edit,
                    disabled:pengelolaan_update,
                },
                remove: {
                    id: 'button_remove_Pengelolaan',
                    action: Pengelolaan.Action.remove,
                    disabled:pengelolaan_delete,
                },
                print: {
                    id: 'button_pring_Pengelolaan',
                    action: Pengelolaan.Action.print,
                    disabled:pengelolaan_print,
                }
            }
        };

        Pengelolaan.Grid.grid = Grid.processGrid(setting, Pengelolaan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'pengelolaan', title: 'Pengelolaan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Pengelolaan.Grid.grid]
        };

        <?php

    } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    }
    ?>