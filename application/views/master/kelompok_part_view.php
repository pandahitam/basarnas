<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_KelompokPart = null;

        Ext.namespace('KelompokPart', 'KelompokPart.reader', 'KelompokPart.proxy', 'KelompokPart.Data', 'KelompokPart.Grid', 'KelompokPart.Window', 'KelompokPart.Form', 'KelompokPart.Action', 'KelompokPart.URL');
        KelompokPart.URL = {
            read: BASE_URL + 'master_data/kelompok_part_getAllData',
            update: BASE_URL + 'master_data/kelompok_part_modifyKelompokPart',
            create: BASE_URL + 'master_data/kelompok_part_createKelompokPart',
            remove: BASE_URL + 'master_data/kelompok_part_deleteKelompokPart'
        };

        KelompokPart.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.KelompokPart', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        KelompokPart.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        KelompokPart.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_KelompokPart',
            url: KelompokPart.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: KelompokPart.reader,
            writer: KelompokPart.writer,
            afterRequest: function(request, success) {
                Params_M_KelompokPart = request.operation.params;
            }
        });

        KelompokPart.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_KelompokPart', storeId: 'DataKelompokPart', model: 'MKelompokPart', pageSize: 50, noCache: false, autoLoad: true,
            proxy: KelompokPart.proxy, groupField: 'tipe'
        });

        KelompokPart.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: KelompokPart.URL.update,
                    data: KelompokPart.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: KelompokPart.URL.create,
                    data: KelompokPart.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiKelompokPart(setting);
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
//                       url:BASE_URL + 'master_data/kd_brg_subkelompok_getLastKelompokPart',
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

        KelompokPart.Action.add = function() {
            var _form = KelompokPart.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Kelompok Part');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        KelompokPart.Action.edit = function() {
            var selected = KelompokPart.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Kelompok Part');
                }
                var _form = KelompokPart.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        KelompokPart.Action.remove = function() {
            var selected = KelompokPart.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, KelompokPart.URL.remove, KelompokPart.Data);
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
                            url:  KelompokPart.URL.remove,
                            success: function(data) {
                                 KelompokPart.Data.load();
                            }
                        });
                    }
                }
            })
        };

        KelompokPart.Action.print = function() {
//            var selected = KelompokPart.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = KelompokPart.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "KelompokPart_Model";
//            var title = "KelompokPart Umum";
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
                id: 'grid_KelompokPart',
                title: 'KELOMPOK PART',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Id', dataIndex: 'id', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama_kelompok', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Jenis Angkutan', dataIndex: 'jenis_asset', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_KelompokPart'
            },
            toolbar: {
                id: 'toolbar_KelompokPart',
                add: {
                    id: 'button_add_KelompokPart',
                    action: KelompokPart.Action.add
                },
                edit: {
                    id: 'button_edit_KelompokPart',
                    action: KelompokPart.Action.edit
                },
                remove: {
                    id: 'button_remove_KelompokPart',
                    action: KelompokPart.Action.remove
                },
                print: {
                    id: 'button_print_KelompokPart',
                    action: KelompokPart.Action.print
                }
            }
        };

        KelompokPart.Grid.grid = Grid.referensiGrid(setting, KelompokPart.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_kelompok_part', title: 'Kelompok Part', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [KelompokPart.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>