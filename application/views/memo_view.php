<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<!--<script>-->
    Ext.namespace('Memo','Memo.Component');
    
    
    Memo.FormPanel = function(url, data, addBtn)
    {
        var _form = Ext.create('Ext.form.Panel', {
                id : 'form-process',
                frame: true,
                url: url,
                bodyStyle: 'padding:5px',
                width: '100%',
                height: '100%',
                autoScroll:true,
                trackResetOnLoad:true,
                fieldDefaults: {
                    msgTarget: 'side'
                },
                buttons: [{
                        text: 'Simpan', id: 'save_process', iconCls: 'icon-save', formBind: true,
                        handler: function() {
                            var form = _form.getForm();
                            if (form.isValid())
                            {
                                form.submit({
                                    success: function(form) {
                                        Ext.MessageBox.alert('Success', 'Memo Berhasil Dikirim');
                                        if (data !== null)
                                        {
                                            data.load();
                                        }
                                        Ext.getCmp('memo').close();



                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Fail', 'Memo Gagal Dikirim');
                                    }
                                });
                            }
                            
                        }
                    }, {
                        text: addBtn.text, iconCls: 'icon-add', hidden: addBtn.isHidden,
                        handler: addBtn.fn
                    }]
            });


            return _form;
    }
    
    Memo.Component.AssetData = function(cmpSetting,isReadOnly)
    {
        var assetData = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'ASSET',
                border: false,
                defaultType: 'container',
                frame: true,
                items: [{
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textfield',
                        items: [{
                                fieldLabel: 'Kode Barang*',
                                name: 'kd_brg',
                                readOnly:true,
                            },
                            {
                                fieldLabel: 'Nama',
                                name: 'nama',
                                editable: false,
                                readOnly:true,
                            },
                            {
                                fieldLabel: 'No Asset*',
                                name: 'no_aset',
                                hidden: cmpSetting.noAsetHidden,
                                disabled: cmpSetting.noAsetHidden,
                                editable: false,
                                readOnly:true,
                            }]
                    },]
            };
            
            return assetData;
    }
    
    Memo.Component.Content = function()
    {
        var content = {
                xtype: 'fieldset',
                layout: 'column',
                anchor: '100%',
                title: 'ISI',
                border: false,
                defaultType: 'container',
                frame: true,
                items: [{
                        columnWidth: .99,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%',
                            labelWidth: 80
                        },
                        defaultType: 'textarea',
                        items: [{
                                    name: 'isi',
                                    height:100,
                                    allowBlank:false,
                                },
                               ]
                    }]
            };
            
            return content;
    }
    
    Memo.Add = function(){
        var setting = {
                url: BASE_URL + 'memo/add',
                data: null,
                isEditing: false,
                addBtn: {
                    isHidden: false,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset());
                            Modal.assetSelection.show();
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };
            
            

      var form = Memo.FormPanel(setting.url,setting.data,setting.addBtn);
      form.insert(0,Form.Component.unitSmallFormSize(form,true,true));
      form.insert(1,Memo.Component.AssetData(setting.selectionAsset,true));
      form.insert(2,Memo.Component.Content());
      return form;
    };
    
var new_popup = new Ext.create('Ext.Window', {
	id: 'memo', title: 'MEMO', iconCls: 'icon-add',
	width: 720, height: 400, bodyStyle: 'padding: 5px;', 	
	constrainHeader : true, closable: true, modal : true,
	items: [Memo.Add()],
        listeners: {
                'beforeclose': function() {
                    this.removeAll(true);
                }
            }
});
		
<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>