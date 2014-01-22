<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_SubPart = null;

        Ext.namespace('SubPart', 'SubPart.reader', 'SubPart.proxy', 'SubPart.Data', 'SubPart.Grid', 'SubPart.Window', 'SubPart.Form', 'SubPart.Action', 'SubPart.URL');
        
        Ext.define('MSubPart', {extend: 'Ext.data.Model',
            fields: ['id','id_part','nama','part_number','umur','cycle','is_oc','is_kelompok','part_induk'
            ]
        });
        
        SubPart.URL = {
            read: BASE_URL + 'master_data/sub_part_getAllData',
            update: BASE_URL + 'master_data/sub_part_modifySubPart',
            create: BASE_URL + 'master_data/sub_part_createSubPart',
            remove: BASE_URL + 'master_data/sub_part_deleteSubPart'
        };

        SubPart.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.SubPart', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        SubPart.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        SubPart.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_SubPart',
            url: SubPart.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: SubPart.reader,
            writer: SubPart.writer,
            afterRequest: function(request, success) {
                Params_M_SubPart = request.operation.params;
            }
        });

        SubPart.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_SubPart', storeId: 'DataSubPart', model: 'MSubPart', pageSize: 50, noCache: false, autoLoad: true,
            proxy: SubPart.proxy, groupField: 'tipe'
        });

        SubPart.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: SubPart.URL.update,
                    data: SubPart.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: SubPart.URL.create,
                    data: SubPart.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiSubPart(setting);
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

        SubPart.Action.add = function() {
            var _form = SubPart.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Sub Part');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        SubPart.Action.edit = function() {
            var selected = SubPart.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Sub Part');
                }
                var _form = SubPart.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        SubPart.Action.remove = function() {
            var selected = SubPart.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, SubPart.URL.remove, SubPart.Data);
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
                            url:  SubPart.URL.remove,
                            success: function(data) {
                                 SubPart.Data.load();
                            }
                        });
                    }
                }
            })
        };

        SubPart.Action.print = function() {

        };

        var setting = {
            grid: {
                id: 'grid_SubPart',
                title: 'SUB PART',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Part Induk', dataIndex: 'part_induk', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Umur', dataIndex: 'umur', width: 130, hidden: false, groupable: false, filter: {type: 'string'}}
                ]
            },
            search: {
                id: 'search_SubPart'
            },
            toolbar: {
                id: 'toolbar_SubPart',
                add: {
                    id: 'button_add_SubPart',
                    action: SubPart.Action.add
                },
                edit: {
                    id: 'button_edit_SubPart',
                    action: SubPart.Action.edit
                },
                remove: {
                    id: 'button_remove_SubPart',
                    action: SubPart.Action.remove
                },
                print: {
                    id: 'button_print_SubPart',
                    action: SubPart.Action.print
                }
            }
        };

        SubPart.Grid.grid = Grid.referensiGrid(setting, SubPart.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_sub_part', title: 'SubPart', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [SubPart.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>