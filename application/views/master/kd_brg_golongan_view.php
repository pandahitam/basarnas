<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KdBrgGolongan = null;

        Ext.namespace('KdBrgGolongan', 'KdBrgGolongan.reader', 'KdBrgGolongan.proxy', 'KdBrgGolongan.Data', 'KdBrgGolongan.Grid', 'KdBrgGolongan.Window', 'KdBrgGolongan.Form', 'KdBrgGolongan.Action', 'KdBrgGolongan.URL');
        KdBrgGolongan.URL = {
            read: BASE_URL + 'master_data/kd_brg_golongan_getAllData',
            update: BASE_URL + 'master_data/kd_brg_golongan_modifyKdBrgGolongan',
            create: BASE_URL + 'master_data/kd_brg_golongan_createKdBrgGolongan',
            remove: BASE_URL + 'master_data/kd_brg_golongan_deleteKdBrgGolongan'
        };

        KdBrgGolongan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KdBrgGolongan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KdBrgGolongan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KdBrgGolongan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KdBrgGolongan',
            url: KdBrgGolongan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KdBrgGolongan.reader,
            writer: KdBrgGolongan.writer,
            afterRequest: function(request, success) {
                Params_M_KdBrgGolongan = request.operation.params;
            }
        });

        KdBrgGolongan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KdBrgGolongan', storeId: 'DataKdBrgGolongan', model: 'MKdBrgGolongan', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KdBrgGolongan.proxy, groupField: 'tipe'
        });

        KdBrgGolongan.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KdBrgGolongan.URL.update,
                    data: KdBrgGolongan.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KdBrgGolongan.URL.create,
                    data: KdBrgGolongan.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKdBrgGolongan(setting);
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
//                var kode = '';
//                $.ajax({
//                       url:BASE_URL + 'master_data/kd_brg_golongan_getLastKdBrgGolongan',
//                       type: "POST",
//                       dataType:'json',
//                       async:false,
//                       success:function(response, status){
//                          kode = response;
//                       }
//                    });
//                var data_kode = {
//                    kd_gol: kode
//                };
//                form.getForm().setValues(data_kode)
            }
            
            return form;
        };

        KdBrgGolongan.Action.add = function() {
            var _form = KdBrgGolongan.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kode Barang Golongan');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KdBrgGolongan.Action.edit = function() {
            var selected = KdBrgGolongan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kode Barang Golongan');
                }
                var _form = KdBrgGolongan.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KdBrgGolongan.Action.remove = function() {
            var selected = KdBrgGolongan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.kd_gol,
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KdBrgGolongan.URL.remove, KdBrgGolongan.Data);
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
                            url:  KdBrgGolongan.URL.remove,
                            success: function(data) {
                                 KdBrgGolongan.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KdBrgGolongan.Action.print = function() {
//            var selected = KdBrgGolongan.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KdBrgGolongan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KdBrgGolongan_Model";
//            var title = "KdBrgGolongan Umum";
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
                id: 'grid_KdBrgGolongan',
                title: 'GOLONGAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Golongan', dataIndex: 'kd_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Golongan', dataIndex: 'ur_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KdBrgGolongan'
            },
            toolbar: {
                id: 'toolbar_KdBrgGolongan',
                add: {
                    id: 'button_add_KdBrgGolongan',
                    action: KdBrgGolongan.Action.add
                },
                edit: {
                    id: 'button_edit_KdBrgGolongan',
                    action: KdBrgGolongan.Action.edit
                },
                remove: {
                    id: 'button_remove_KdBrgGolongan',
                    action: KdBrgGolongan.Action.remove
                },
                print: {
                    id: 'button_print_KdBrgGolongan',
                    action: KdBrgGolongan.Action.print
                }
            }
        };

        KdBrgGolongan.Grid.grid = Grid.referensiGrid(setting, KdBrgGolongan.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kd_brg_golongan', title: 'Golongan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KdBrgGolongan.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>