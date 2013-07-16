<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// Add the additional 'advanced' VTypes
Ext.apply(Ext.form.field.VTypes, {
	password: function(val, field) {
  	if (field.initialPassField) {
    	var pwd = field.up('form').down('#' + field.initialPassField);
      return (val == pwd.getValue());
    }
    return true;
  },

  passwordText: 'Konfirmasi Kata Sandi tidak sesuai'
});

var form_changepass = new Ext.create('Ext.form.Panel', {
	id: 'frmchangepass', url: BASE_URL + 'pengguna_login/ext_changepass',
  frame: true, bodyStyle: 'padding: 5px 5px 0 0', width: '100%', height: '100%',
  fieldDefaults: {labelAlign: 'right', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield',
  defaults: {anchor: '100%', allowBlank: false},
  items: [
  	{name: 'iduser', xtype: 'hidden'},
  	{fieldLabel: 'Kata Sandi Baru', name: 'pass', id: 'pass', inputType: 'password'},
  	{fieldLabel: 'Konfirmasi Kata Sandi', name: 'pass-cfrm', inputType: 'password', vtype: 'password', initialPassField: 'pass'}
  ],
  buttons: [
  	{
  	text: 'Simpan',
    handler: function() {
  			// this function before action
    		Ext.getCmp('frmchangepass').on({
    			beforeaction: function() {
      			Ext.getCmp('winchangepass').body.mask();
        		Ext.getCmp('sbWinchangepass').showBusy();
      		}
    		});

        form_changepass.getForm().submit({            			
        	success: function(){      
        		Ext.MessageBox.show({title:'Informasi !', msg:'Perubahan Kata Sandi berhasil !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});    					
          	form_changepass.getForm().reset(); new_popup.close();
          },
          failure: function(form, action){
          	Ext.getCmp('winchangepass').body.unmask();
          	if (action.failureType == 'server') {
          		obj = Ext.decode(action.response.responseText);
          		Ext.getCmp('sbWinchangepass').setStatus({
          			text: obj.errors.reason,
          			iconCls: 'x-status-error'
          		});
          	}else{
          		if (typeof(action.response) == 'undefined') {
          			Ext.getCmp('sbWinchangepass').setStatus({
          				text: 'Silahkan isi dengan benar !',
          				iconCls: 'x-status-error'
          			});
          		}else{
          			Ext.getCmp('sbWinchangepass').setStatus({
          				text: 'Server tidak dapat dihubungi !',
          				iconCls: 'x-status-error'
          			});
          		}
          	}
          }
        });
    	}
    },{
    	text: 'Batal',
      handler: function() {
      	form_changepass.getForm().reset(); 
        new_popup.close();
      }
		}
	]				
});
			
var new_popup = new Ext.create('Ext.Window', {
	id: 'winchangepass', title: 'UBAH KATA SANDI', iconCls: 'icon-key',
	width: 350, height: 180, bodyStyle: 'padding: 5px;', 	
	constrainHeader : true, closable: true, modal : true,
	items: [form_changepass],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready',
    id: 'sbWinchangepass',
    iconCls: 'x-status-valid'
  })
});
		

var id_val = {iduser: '<?php echo $sesi; ?>'};    	
form_changepass.getForm().setValues(id_val);

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>