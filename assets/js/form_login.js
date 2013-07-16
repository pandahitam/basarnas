Ext.onReady(function() {
	// 02. Form Login
  var formLogin = new Ext.FormPanel({
		frame: false, border: false, buttonAlign: 'center',
		url: BASE_URL + 'user/ext_login', method: 'POST', id: 'frmLogin',
		bodyStyle: 'padding:10px 10px 15px 15px;background:#dfe8f6;',
		width: 300, labelWidth: 150,
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Nama Pengguna',
			name: 'username',
			id: 'logUsername',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Kata Sandi',
			name: 'password',
    	id: 'logPassword',
			allowBlank: false,
			inputType: 'password'
		}
		],
		buttons: [
		{ text: 'Login', handler: fnLogin },
		{ text: 'Reset', handler: function() {
			formLogin.getForm().reset();
		}
		}
		]
	});

	function fnLogin() {
  	Ext.getCmp('frmLogin').on({
    	beforeaction: function() {
      	if (formLogin.getForm().isValid()) {
          Ext.getCmp('winLogin').body.mask();
          Ext.getCmp('sbWinLogin').showBusy();
        }
      }
    });
    formLogin.getForm().submit({
    	success: function() {window.location = BASE_URL + 'user/index';},
      failure: function(form, action) {
        Ext.getCmp('winLogin').body.unmask();
        if (action.failureType == 'server') {
        	obj = Ext.util.JSON.decode(action.response.responseText);
          Ext.getCmp('sbWinLogin').setStatus({
          	text: obj.errors.reason,
          	iconCls: 'x-status-error'
          });
        }else{
        	if (formLogin.getForm().isValid()) {
          	Ext.getCmp('sbWinLogin').setStatus({
            	text: 'Authentication server is unreachable',
            	iconCls: 'x-status-error'
          	});
        	} else {
        		Ext.getCmp('sbWinLogin').setStatus({
          		text: 'Something error in form !',
          		iconCls: 'x-status-error'
        		});
        	}
      	}
    	}
  	});
    }

  // 02. Window Login
	var winLogin = new Ext.Window({
		title: 'SIMPEG 2011 &mdash; Pengguna Login',
    id: 'winLogin',
		layout: 'fit',
		width: 350,
		height: 160,
		y: 250,
		resizable: false,
		closable: false,
		items: [formLogin],
        bbar: new Ext.ux.StatusBar({
            text: 'Ready',
            id: 'sbWinLogin'
        })
	});

	winLogin.show();
});