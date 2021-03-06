<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_Provinsi = null;

        Ext.namespace('Provinsi', 'Provinsi.reader', 'Provinsi.proxy', 'Provinsi.Data', 'Provinsi.Grid', 'Provinsi.Window', 'Provinsi.Form', 'Provinsi.Action', 'Provinsi.URL');
        Provinsi.URL = {
            read: BASE_URL + 'master_data/provinsi_getAllData',
            update: BASE_URL + 'master_data/provinsi_modifyProvinsi',
            create: BASE_URL + 'master_data/provinsi_createProvinsi',
            remove: BASE_URL + 'master_data/provinsi_deleteProvinsi'
        };

        Provinsi.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.Provinsi', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        Provinsi.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        Provinsi.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_Provinsi',
            url: Provinsi.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: Provinsi.reader,
            writer: Provinsi.writer,
            afterRequest: function(request, success) {
                Params_M_Provinsi = request.operation.params;
            }
        });

        Provinsi.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_Provinsi', storeId: 'DataProvinsi', model: 'MProvinsi', pageSize: 50, noCache: false, autoLoad: true,
            proxy: Provinsi.proxy, groupField: 'tipe'
        });

        Provinsi.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: Provinsi.URL.update,
                    data: Provinsi.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: Provinsi.URL.create,
                    data: Provinsi.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiProvinsi(setting);
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
                var kode_prov = '';
                $.ajax({
                       url:BASE_URL + 'master_data/provinsi_getLastKodeProv',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       success:function(response, status){
                          kode_prov = response;
                       }
                    });
                var data_kode = {
                    kode_prov: kode_prov
                };
                form.getForm().setValues(data_kode)
            }
            
            return form;
        };

        Provinsi.Action.add = function() {
            var _form = Provinsi.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Provinsi');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        Provinsi.Action.edit = function() {
            var selected = Provinsi.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Provinsi');
                }
                var _form = Provinsi.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        Provinsi.Action.remove = function() {
            var selected = Provinsi.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.ID_Prov,
                    kode_prov: obj.data.kode_prov
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, Provinsi.URL.remove, Provinsi.Data);
            Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ? Kota/Kabupaten yang berhubungan akan juga terhapus.',
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
                            url:  Provinsi.URL.remove,
                            success: function(data) {
                                 Provinsi.Data.load();
                            }
                        });
                    }
                }
            })
        };

        Provinsi.Action.print = function() {
//            var selected = Provinsi.Grid.grid.getSelectionModel().getSelection();
//            var selectedData = "";
//            if (selected.length > 0)
//            {
//                for (var i = 0; i < selected.length; i++)
//                {
//                    selectedData += selected[i].data.id + ",";
//                }
//            }
//            var gridHeader = Provinsi.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
//            var serverSideModelName = "Provinsi_Model";
//            var title = "Provinsi Umum";
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
                id: 'grid_Provinsi',
                title: 'PROVINSI',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Kode Provinsi', dataIndex: 'kode_prov', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama Provinsi', dataIndex: 'nama_prov', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_Provinsi'
            },
            toolbar: {
                id: 'toolbar_Provinsi',
                add: {
                    id: 'button_add_Provinsi',
                    action: Provinsi.Action.add
                },
                edit: {
                    id: 'button_edit_Provinsi',
                    action: Provinsi.Action.edit
                },
                remove: {
                    id: 'button_remove_Provinsi',
                    action: Provinsi.Action.remove
                },
                print: {
                    id: 'button_print_Provinsi',
                    action: Provinsi.Action.print
                }
            }
        };

        Provinsi.Grid.grid = Grid.referensiGrid(setting, Provinsi.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_provinsi', title: 'Provinsi', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Provinsi.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>