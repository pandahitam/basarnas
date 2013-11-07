<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KdBrgBidang = null;

        Ext.namespace('KdBrgBidang', 'KdBrgBidang.reader', 'KdBrgBidang.proxy', 'KdBrgBidang.Data', 'KdBrgBidang.Grid', 'KdBrgBidang.Window', 'KdBrgBidang.Form', 'KdBrgBidang.Action', 'KdBrgBidang.URL');
        KdBrgBidang.URL = {
            read: BASE_URL + 'master_data/kd_brg_bidang_getAllData',
            update: BASE_URL + 'master_data/kd_brg_bidang_modifyKdBrgBidang',
            create: BASE_URL + 'master_data/kd_brg_bidang_createKdBrgBidang',
            remove: BASE_URL + 'master_data/kd_brg_bidang_deleteKdBrgBidang'
        };

        KdBrgBidang.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KdBrgBidang', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KdBrgBidang.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KdBrgBidang.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KdBrgBidang',
            url: KdBrgBidang.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KdBrgBidang.reader,
            writer: KdBrgBidang.writer,
            afterRequest: function(request, success) {
                Params_M_KdBrgBidang = request.operation.params;
            }
        });

        KdBrgBidang.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KdBrgBidang', storeId: 'DataKdBrgBidang', model: 'MKdBrgBidang', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KdBrgBidang.proxy, groupField: 'tipe'
        });

        KdBrgBidang.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KdBrgBidang.URL.update,
                    data: KdBrgBidang.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KdBrgBidang.URL.create,
                    data: KdBrgBidang.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKdBrgBidang(setting);
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
//                       url:BASE_URL + 'master_data/kd_brg_bidang_getLastKdBrgBidang',
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

        KdBrgBidang.Action.add = function() {
            var _form = KdBrgBidang.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kode Barang Bidang');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KdBrgBidang.Action.edit = function() {
            var selected = KdBrgBidang.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kode Barang Bidang');
                }
                var _form = KdBrgBidang.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KdBrgBidang.Action.remove = function() {
            var selected = KdBrgBidang.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    kd_gol: obj.data.kd_gol,
                    kd_bid: obj.data.kd_bid
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KdBrgBidang.URL.remove, KdBrgBidang.Data);
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
                            url:  KdBrgBidang.URL.remove,
                            success: function(data) {
                                 KdBrgBidang.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KdBrgBidang.Action.print = function() {
//            var selected = KdBrgBidang.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KdBrgBidang.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KdBrgBidang_Model";
//            var title = "KdBrgBidang Umum";
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
                id: 'grid_KdBrgBidang',
                title: 'BIDANG',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Golongan', dataIndex: 'ur_gol', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Bidang', dataIndex: 'kd_bid', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Bidang', dataIndex: 'ur_bid', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KdBrgBidang'
            },
            toolbar: {
                id: 'toolbar_KdBrgBidang',
                add: {
                    id: 'button_add_KdBrgBidang',
                    action: KdBrgBidang.Action.add
                },
                edit: {
                    id: 'button_edit_KdBrgBidang',
                    action: KdBrgBidang.Action.edit
                },
                remove: {
                    id: 'button_remove_KdBrgBidang',
                    action: KdBrgBidang.Action.remove
                },
                print: {
                    id: 'button_print_KdBrgBidang',
                    action: KdBrgBidang.Action.print
                }
            }
        };

        KdBrgBidang.Grid.grid = Grid.referensiGrid(setting, KdBrgBidang.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kd_brg_bidang', title: 'Bidang', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KdBrgBidang.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>