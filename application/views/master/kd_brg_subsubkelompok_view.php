<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KdBrgSubSubKelompok = null;

        Ext.namespace('KdBrgSubSubKelompok', 'KdBrgSubSubKelompok.reader', 'KdBrgSubSubKelompok.proxy', 'KdBrgSubSubKelompok.Data', 'KdBrgSubSubKelompok.Grid', 'KdBrgSubSubKelompok.Window', 'KdBrgSubSubKelompok.Form', 'KdBrgSubSubKelompok.Action', 'KdBrgSubSubKelompok.URL');
        KdBrgSubSubKelompok.URL = {
            read: BASE_URL + 'master_data/kd_brg_subsubkelompok_getAllData',
            update: BASE_URL + 'master_data/kd_brg_subsubkelompok_modifyKdBrgSubSubKelompok',
            create: BASE_URL + 'master_data/kd_brg_subsubkelompok_createKdBrgSubSubKelompok',
            remove: BASE_URL + 'master_data/kd_brg_subsubkelompok_deleteKdBrgSubSubKelompok'
        };

        KdBrgSubSubKelompok.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KdBrgSubSubKelompok', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KdBrgSubSubKelompok.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KdBrgSubSubKelompok.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KdBrgSubSubKelompok',
            url: KdBrgSubSubKelompok.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KdBrgSubSubKelompok.reader,
            writer: KdBrgSubSubKelompok.writer,
            afterRequest: function(request, success) {
                Params_M_KdBrgSubSubKelompok = request.operation.params;
            }
        });

        KdBrgSubSubKelompok.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KdBrgSubSubKelompok', storeId: 'DataKdBrgSubSubKelompok', model: 'MKdBrgSubSubKelompok', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KdBrgSubSubKelompok.proxy, groupField: 'tipe'
        });

        KdBrgSubSubKelompok.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KdBrgSubSubKelompok.URL.update,
                    data: KdBrgSubSubKelompok.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KdBrgSubSubKelompok.URL.create,
                    data: KdBrgSubSubKelompok.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKdBrgSubSubKelompok(setting);
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
//                       url:BASE_URL + 'master_data/kd_brg_subsubkelompok_getLastKdBrgSubSubKelompok',
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

        KdBrgSubSubKelompok.Action.add = function() {
            var _form = KdBrgSubSubKelompok.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kode Barang Sub Sub Kelompok');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KdBrgSubSubKelompok.Action.edit = function() {
            var selected = KdBrgSubSubKelompok.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kode Barang Sub Sub Kelompok');
                }
                var _form = KdBrgSubSubKelompok.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KdBrgSubSubKelompok.Action.remove = function() {
            var selected = KdBrgSubSubKelompok.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_gol: obj.data.kd_gol,
                    kd_bid: obj.data.kd_bid,
                    kd_kel: obj.data.kd_kel,
                    kd_skel: obj.data.kd_skel,
                    kd_sskel: obj.data.kd_sskel
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KdBrgSubSubKelompok.URL.remove, KdBrgSubSubKelompok.Data);
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
                            url:  KdBrgSubSubKelompok.URL.remove,
                            success: function(data) {
                                 KdBrgSubSubKelompok.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KdBrgSubSubKelompok.Action.print = function() {
//            var selected = KdBrgSubSubKelompok.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KdBrgSubSubKelompok.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KdBrgSubSubKelompok_Model";
//            var title = "KdBrgSubSubKelompok Umum";
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
                id: 'grid_KdBrgSubSubKelompok',
                title: 'SUB SUB KELOMPOK',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Golongan', dataIndex: 'ur_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Bidang', dataIndex: 'ur_bid', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kelompok', dataIndex: 'ur_kel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Sub Kelompok', dataIndex: 'ur_skel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Sub Sub Kelompok', dataIndex: 'kd_sskel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Sub Sub Kelompok', dataIndex: 'ur_sskel', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KdBrgSubSubKelompok'
            },
            toolbar: {
                id: 'toolbar_KdBrgSubSubKelompok',
                add: {
                    id: 'button_add_KdBrgSubSubKelompok',
                    action: KdBrgSubSubKelompok.Action.add
                },
                edit: {
                    id: 'button_edit_KdBrgSubSubKelompok',
                    action: KdBrgSubSubKelompok.Action.edit
                },
                remove: {
                    id: 'button_remove_KdBrgSubSubKelompok',
                    action: KdBrgSubSubKelompok.Action.remove
                },
                print: {
                    id: 'button_print_KdBrgSubSubKelompok',
                    action: KdBrgSubSubKelompok.Action.print
                }
            }
        };

        KdBrgSubSubKelompok.Grid.grid = Grid.referensiGrid(setting, KdBrgSubSubKelompok.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kd_brg_subsubkelompok', title: 'Sub Sub Kelompok', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KdBrgSubSubKelompok.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>