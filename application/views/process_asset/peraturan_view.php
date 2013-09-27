<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
        ////PANEL UTAMA PENGELOLAAN DATA  -------------------------------------------- START
        var Params_M_Peraturan = null;

        Ext.namespace('Peraturan', 'Peraturan.reader', 'Peraturan.proxy', 'Peraturan.Data', 'Peraturan.Grid', 'Peraturan.Window', 'Peraturan.Form', 'Peraturan.Action', 'Peraturan.URL');

        Peraturan.URL = {
            read: BASE_URL + 'Peraturan/getAllData',
            createUpdate: BASE_URL + 'Peraturan/modifyPeraturan',
            remove: BASE_URL + 'Peraturan/deletePeraturan',
        }

        Peraturan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Peraturan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Peraturan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Peraturan',
            url: Peraturan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Peraturan.reader,
            afterRequest: function(request, success) {
                Params_M_Peraturan = request.operation.params;
            }
        });

        Peraturan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Peraturan', storeId: 'DataPeraturan', model: 'MPeraturan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: Peraturan.proxy, groupField: 'tipe'
        });

        Peraturan.Form.create = function(data, edit) {
            var setting = {
                url: Peraturan.URL.createUpdate,
                data: Peraturan.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: true,
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
                    noAsetHidden: true
                }
            };
//            debugger;
            var form = Form.peraturan(setting);

            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
        };


        Peraturan.Action.add = function() {
            var _form = Peraturan.Form.create(null, false)
            Modal.processCreate.setTitle('Create Peraturan');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        Peraturan.Action.edit = function() {
            var selected = Peraturan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Peraturan');
                }
                var _form = Peraturan.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
        };

        Peraturan.Action.remove = function() {
            var selected = Peraturan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, Peraturan.URL.remove, Peraturan.Data);
        };

        Peraturan.Action.print = function() {

            var selected = Peraturan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = Peraturan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
            var serverSideModelName = "Peraturan_Model";
            var title = "Peraturan";
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
                id: 'grid_Peraturan',
                title: 'DAFTAR PERATURAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', flex:0.5, groupable: false, hidden:true, filter: {type: 'number'}},
                    {header: 'Nama', dataIndex: 'nama', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'No Dokumen', dataIndex: 'no_dokumen', flex: 1, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Dokumen', dataIndex: 'tanggal_dokumen', flex: 1, groupable: false, filter: {type: 'string'}},
                    {header: 'Initiator', dataIndex: 'initiator', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Perihal', dataIndex: 'perihal', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Date Upload', dataIndex: 'date_upload', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Document', dataIndex: 'document', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},


                ]
            },
            search: {
                id: 'search_Peraturan'
            },
            toolbar: {
                id: 'toolbar_Peraturan',
                add: {
                    id: 'button_add_Peraturan',
                    action: Peraturan.Action.add
                },
                edit: {
                    id: 'button_edit_Peraturan',
                    action: Peraturan.Action.edit
                },
                remove: {
                    id: 'button_remove_Peraturan',
                    action: Peraturan.Action.remove
                },
                print: {
                    id: 'button_pring_Peraturan',
                    action: Peraturan.Action.print
                }
            }
        };

        Peraturan.Grid.grid = Grid.processGrid(setting, Peraturan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'peraturan', title: 'Peraturan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Peraturan.Grid.grid]
        };

        <?php

    } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    }
    ?>