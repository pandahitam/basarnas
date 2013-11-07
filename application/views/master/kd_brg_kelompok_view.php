<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KdBrgKelompok = null;

        Ext.namespace('KdBrgKelompok', 'KdBrgKelompok.reader', 'KdBrgKelompok.proxy', 'KdBrgKelompok.Data', 'KdBrgKelompok.Grid', 'KdBrgKelompok.Window', 'KdBrgKelompok.Form', 'KdBrgKelompok.Action', 'KdBrgKelompok.URL');
        KdBrgKelompok.URL = {
            read: BASE_URL + 'master_data/kd_brg_kelompok_getAllData',
            update: BASE_URL + 'master_data/kd_brg_kelompok_modifyKdBrgKelompok',
            create: BASE_URL + 'master_data/kd_brg_kelompok_createKdBrgKelompok',
            remove: BASE_URL + 'master_data/kd_brg_kelompok_deleteKdBrgKelompok'
        };

        KdBrgKelompok.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KdBrgKelompok', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KdBrgKelompok.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KdBrgKelompok.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KdBrgKelompok',
            url: KdBrgKelompok.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KdBrgKelompok.reader,
            writer: KdBrgKelompok.writer,
            afterRequest: function(request, success) {
                Params_M_KdBrgKelompok = request.operation.params;
            }
        });

        KdBrgKelompok.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KdBrgKelompok', storeId: 'DataKdBrgKelompok', model: 'MKdBrgKelompok', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KdBrgKelompok.proxy, groupField: 'tipe'
        });

        KdBrgKelompok.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KdBrgKelompok.URL.update,
                    data: KdBrgKelompok.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KdBrgKelompok.URL.create,
                    data: KdBrgKelompok.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKdBrgKelompok(setting);
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
//                       url:BASE_URL + 'master_data/kd_brg_kelompok_getLastKdBrgKelompok',
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

        KdBrgKelompok.Action.add = function() {
            var _form = KdBrgKelompok.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kode Barang Kelompok');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KdBrgKelompok.Action.edit = function() {
            var selected = KdBrgKelompok.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kode Barang Kelompok');
                }
                var _form = KdBrgKelompok.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KdBrgKelompok.Action.remove = function() {
            var selected = KdBrgKelompok.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_gol: obj.data.kd_gol,
                    kd_bid: obj.data.kd_bid,
                    kd_kel: obj.data.kd_kel
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KdBrgKelompok.URL.remove, KdBrgKelompok.Data);
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
                            url:  KdBrgKelompok.URL.remove,
                            success: function(data) {
                                 KdBrgKelompok.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KdBrgKelompok.Action.print = function() {
//            var selected = KdBrgKelompok.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KdBrgKelompok.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KdBrgKelompok_Model";
//            var title = "KdBrgKelompok Umum";
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
                id: 'grid_KdBrgKelompok',
                title: 'KELOMPOK',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Golongan', dataIndex: 'ur_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Bidang', dataIndex: 'ur_bid', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Kelompok', dataIndex: 'kd_kel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Kelompok', dataIndex: 'ur_kel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KdBrgKelompok'
            },
            toolbar: {
                id: 'toolbar_KdBrgKelompok',
                add: {
                    id: 'button_add_KdBrgKelompok',
                    action: KdBrgKelompok.Action.add
                },
                edit: {
                    id: 'button_edit_KdBrgKelompok',
                    action: KdBrgKelompok.Action.edit
                },
                remove: {
                    id: 'button_remove_KdBrgKelompok',
                    action: KdBrgKelompok.Action.remove
                },
                print: {
                    id: 'button_print_KdBrgKelompok',
                    action: KdBrgKelompok.Action.print
                }
            }
        };

        KdBrgKelompok.Grid.grid = Grid.referensiGrid(setting, KdBrgKelompok.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kd_brg_kelompok', title: 'Kelompok', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KdBrgKelompok.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>