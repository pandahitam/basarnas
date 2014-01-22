<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
    /////////
        var Params_M_SubSubPart = null;

        Ext.namespace('SubSubPart', 'SubSubPart.reader', 'SubSubPart.proxy', 'SubSubPart.Data', 'SubSubPart.Grid', 'SubSubPart.Window', 'SubSubPart.Form', 'SubSubPart.Action', 'SubSubPart.URL');
        
        Ext.define('MSubSubPart', {extend: 'Ext.data.Model',
            fields: ['id','id_sub_part','nama','part_number','umur','cycle','is_oc','is_kelompok','part_induk','sub_part_induk','id_part_induk'
            ]
        });
        
        SubSubPart.URL = {
            read: BASE_URL + 'master_data/sub_sub_part_getAllData',
            update: BASE_URL + 'master_data/sub_sub_part_modifySubSubPart',
            create: BASE_URL + 'master_data/sub_sub_part_createSubSubPart',
            remove: BASE_URL + 'master_data/sub_sub_part_deleteSubSubPart'
        };

        SubSubPart.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.SubSubPart', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        SubSubPart.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        SubSubPart.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_SubSubPart',
            url: SubSubPart.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: SubSubPart.reader,
            writer: SubSubPart.writer,
            afterRequest: function(request, success) {
                Params_M_SubSubPart = request.operation.params;
            }
        });

        SubSubPart.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_SubSubPart', storeId: 'DataSubSubPart', model: 'MSubSubPart', pageSize: 50, noCache: false, autoLoad: true,
            proxy: SubSubPart.proxy, groupField: 'tipe'
        });

        SubSubPart.Form.create = function(data, edit) {
            
            if(edit == true)
            {
                var setting = {
                    url: SubSubPart.URL.update,
                    data: SubSubPart.Data,
                    isEditing: edit,
                };
            }
            else
            {
                var setting = {
                    url: SubSubPart.URL.create,
                    data: SubSubPart.Data,
                    isEditing: edit,
                };
            }
            

            var form = Form.referensiSubSubPart(setting);
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

        SubSubPart.Action.add = function() {
            var _form = SubSubPart.Form.create(null, false);
            Modal.smallWindow.setTitle('Create Sub Part');
            Modal.smallWindow.add(_form);
            Modal.smallWindow.show();
        };

        SubSubPart.Action.edit = function() {
            var selected = SubSubPart.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.smallWindow.items.length === 0)
                {
                    Modal.smallWindow.setTitle('Edit Sub Part');
                }
                var _form = SubSubPart.Form.create(data, true);
                Modal.smallWindow.add(_form);
                Modal.smallWindow.show();
            }
        };

        SubSubPart.Action.remove = function() {
            var selected = SubSubPart.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                };
                arrayDeleted.push(data);
            });
            //Modal.deleteAlert(arrayDeleted, SubSubPart.URL.remove, SubSubPart.Data);
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
                            url:  SubSubPart.URL.remove,
                            success: function(data) {
                                 SubSubPart.Data.load();
                            }
                        });
                    }
                }
            })
        };

        SubSubPart.Action.print = function() {

        };

        var setting = {
            grid: {
                id: 'grid_SubSubPart',
                title: 'SUB SUB PART',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'Part Induk', dataIndex: 'part_induk', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Sub Part Induk', dataIndex: 'sub_part_induk', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Part Number', dataIndex: 'part_number', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Umur', dataIndex: 'umur', width: 130, hidden: false, groupable: false, filter: {type: 'string'}}
                ]
            },
            search: {
                id: 'search_SubSubPart'
            },
            toolbar: {
                id: 'toolbar_SubSubPart',
                add: {
                    id: 'button_add_SubSubPart',
                    action: SubSubPart.Action.add
                },
                edit: {
                    id: 'button_edit_SubSubPart',
                    action: SubSubPart.Action.edit
                },
                remove: {
                    id: 'button_remove_SubSubPart',
                    action: SubSubPart.Action.remove
                },
                print: {
                    id: 'button_print_SubSubPart',
                    action: SubSubPart.Action.print
                }
            }
        };

        SubSubPart.Grid.grid = Grid.referensiGrid(setting, SubSubPart.Data);

        var new_tabpanel_MD = {
            xtype: 'panel',
            id: 'master_sub_sub_part', title: 'SubSubPart', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [SubSubPart.Grid.grid]
        };


<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>