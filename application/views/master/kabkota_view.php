<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_Kabkota = null;

        Ext.namespace('Kabkota', 'Kabkota.reader', 'Kabkota.proxy', 'Kabkota.Data', 'Kabkota.Grid', 'Kabkota.Window', 'Kabkota.Form', 'Kabkota.Action', 'Kabkota.URL');
        Kabkota.URL = {
            read: BASE_URL + 'master_data/kabkota_getAllData',
            update: BASE_URL + 'master_data/kabkota_modifyKabkota',
            create: BASE_URL + 'master_data/kabkota_createKabkota',
            remove: BASE_URL + 'master_data/kabkota_deleteKabkota'
        };

        Kabkota.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Kabkota', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Kabkota.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        Kabkota.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Kabkota',
            url: Kabkota.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Kabkota.reader,
            writer: Kabkota.writer,
            afterRequest: function(request, success) {
                Params_M_Kabkota = request.operation.params;
            }
        });

        Kabkota.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Kabkota', storeId: 'DataKabkota', model: 'MKabkota', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Kabkota.proxy, groupField: 'tipe'
        });

        Kabkota.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: Kabkota.URL.update,
                    data: Kabkota.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: Kabkota.URL.create,
                    data: Kabkota.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKabkota(setting);
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
//                var kode_kabkota = '';
//                $.ajax({
//                       url:BASE_URL + 'master_data/kabkota_getLastKodeKabkota',
//                       type: "POST",
//                       dataType:'json',
//                       async:false,
//                       success:function(response, status){
//                          kode_kabkota = response;
//                       }
//                    });
//                var data_kode = {
//                    kode_kabkota: kode_kabkota
//                };
//                form.getForm().setValues(data_kode)
            }
            return form;
        };

        Kabkota.Action.add = function() {
            var _form = Kabkota.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kabkota');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        Kabkota.Action.edit = function() {
            var selected = Kabkota.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kabkota');
                }
                var _form = Kabkota.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        Kabkota.Action.remove = function() {
            var selected = Kabkota.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.ID_KK,
                    kode_kabkota: obj.data.kode_kabkota
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, Kabkota.URL.remove, Kabkota.Data);
            Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO, 
                icon: Ext.Msg.Question,
                fn: function(btn) {
                    if (btn === 'yes')
                    {
                        /*debugger;*/
                        var dataSend = {
                            data: arrayDeleted
                        };

                        $.ajax({
                            type: 'POST',
                            data: dataSend,
                            dataType: 'json',
                            url:  Kabkota.URL.remove,
                            success: function(data) {
                                 Kabkota.Data.load();
                            }
                        });
                    }
                }
            })
        };

        Kabkota.Action.print = function() {
//            var selected = Kabkota.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = Kabkota.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "Kabkota_Model";
//            var title = "Kabkota Umum";
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
                id: 'grid_Kabkota',
                title: 'KOTA/KABUPATEN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Nama Provinsi', dataIndex: 'nama_prov', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Kota/Kabupaten', dataIndex: 'kode_kabkota', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Kota/Kabupaten', dataIndex: 'nama_kabkota', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_Kabkota'
            },
            toolbar: {
                id: 'toolbar_Kabkota',
                add: {
                    id: 'button_add_Kabkota',
                    action: Kabkota.Action.add
                },
                edit: {
                    id: 'button_edit_Kabkota',
                    action: Kabkota.Action.edit
                },
                remove: {
                    id: 'button_remove_Kabkota',
                    action: Kabkota.Action.remove
                },
                print: {
                    id: 'button_print_Kabkota',
                    action: Kabkota.Action.print
                }
            }
        };

        Kabkota.Grid.grid = Grid.referensiGrid(setting, Kabkota.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kabkota', title: 'Kota/Kabupaten', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Kabkota.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>