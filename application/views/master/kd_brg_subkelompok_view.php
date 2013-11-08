<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KdBrgSubKelompok = null;

        Ext.namespace('KdBrgSubKelompok', 'KdBrgSubKelompok.reader', 'KdBrgSubKelompok.proxy', 'KdBrgSubKelompok.Data', 'KdBrgSubKelompok.Grid', 'KdBrgSubKelompok.Window', 'KdBrgSubKelompok.Form', 'KdBrgSubKelompok.Action', 'KdBrgSubKelompok.URL');
        KdBrgSubKelompok.URL = {
            read: BASE_URL + 'master_data/kd_brg_subkelompok_getAllData',
            update: BASE_URL + 'master_data/kd_brg_subkelompok_modifyKdBrgSubKelompok',
            create: BASE_URL + 'master_data/kd_brg_subkelompok_createKdBrgSubKelompok',
            remove: BASE_URL + 'master_data/kd_brg_subkelompok_deleteKdBrgSubKelompok'
        };

        KdBrgSubKelompok.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KdBrgSubKelompok', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KdBrgSubKelompok.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KdBrgSubKelompok.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KdBrgSubKelompok',
            url: KdBrgSubKelompok.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KdBrgSubKelompok.reader,
            writer: KdBrgSubKelompok.writer,
            afterRequest: function(request, success) {
                Params_M_KdBrgSubKelompok = request.operation.params;
            }
        });

        KdBrgSubKelompok.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KdBrgSubKelompok', storeId: 'DataKdBrgSubKelompok', model: 'MKdBrgSubKelompok', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KdBrgSubKelompok.proxy, groupField: 'tipe'
        });

        KdBrgSubKelompok.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KdBrgSubKelompok.URL.update,
                    data: KdBrgSubKelompok.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KdBrgSubKelompok.URL.create,
                    data: KdBrgSubKelompok.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKdBrgSubKelompok(setting);
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
//                       url:BASE_URL + 'master_data/kd_brg_subkelompok_getLastKdBrgSubKelompok',
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

        KdBrgSubKelompok.Action.add = function() {
            var _form = KdBrgSubKelompok.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kode Barang Sub Kelompok');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KdBrgSubKelompok.Action.edit = function() {
            var selected = KdBrgSubKelompok.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kode Barang Sub Kelompok');
                }
                var _form = KdBrgSubKelompok.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KdBrgSubKelompok.Action.remove = function() {
            var selected = KdBrgSubKelompok.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_gol: obj.data.kd_gol,
                    kd_bid: obj.data.kd_bid,
                    kd_kel: obj.data.kd_kel,
                    kd_skel: obj.data.kd_skel
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KdBrgSubKelompok.URL.remove, KdBrgSubKelompok.Data);
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
                            url:  KdBrgSubKelompok.URL.remove,
                            success: function(data) {
                                 KdBrgSubKelompok.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KdBrgSubKelompok.Action.print = function() {
//            var selected = KdBrgSubKelompok.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KdBrgSubKelompok.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KdBrgSubKelompok_Model";
//            var title = "KdBrgSubKelompok Umum";
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
                id: 'grid_KdBrgSubKelompok',
                title: 'SUB KELOMPOK',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Golongan', dataIndex: 'ur_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Bidang', dataIndex: 'ur_bid', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kelompok', dataIndex: 'ur_kel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Sub Kelompok', dataIndex: 'kd_skel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Sub Kelompok', dataIndex: 'ur_skel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KdBrgSubKelompok'
            },
            toolbar: {
                id: 'toolbar_KdBrgSubKelompok',
                add: {
                    id: 'button_add_KdBrgSubKelompok',
                    action: KdBrgSubKelompok.Action.add
                },
                edit: {
                    id: 'button_edit_KdBrgSubKelompok',
                    action: KdBrgSubKelompok.Action.edit
                },
                remove: {
                    id: 'button_remove_KdBrgSubKelompok',
                    action: KdBrgSubKelompok.Action.remove
                },
                print: {
                    id: 'button_print_KdBrgSubKelompok',
                    action: KdBrgSubKelompok.Action.print
                }
            }
        };

        KdBrgSubKelompok.Grid.grid = Grid.referensiGrid(setting, KdBrgSubKelompok.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kd_brg_subkelompok', title: 'Sub Kelompok', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KdBrgSubKelompok.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>