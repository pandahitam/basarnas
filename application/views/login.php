<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if (isset($title)) {
    echo $title;
} else {
    echo "SIMPEG";
} ?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" /> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/icon_css.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/resources/css/ext-all.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/css/statusbar.css"/>

        <style>body {background: #7F99BE url(<?php echo base_url(); ?>assets/images/extjs/desk.jpg) no-repeat;}</style>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/StatusBar.js"></script>

        <script type="text/javascript">
            var BASE_URL = '<?php echo base_url(); ?>';
            var BASE_ICONS = BASE_URL + 'assets/images/icons/';
            var Time_Out = 60000;
            Ext.BLANK_IMAGE_URL = BASE_URL + 'assets/js/ext/resources/themes/images/access/tree/s.gif';
            Ext.Loader.setConfig({enabled: true});
            Ext.Loader.setPath('Ext.ux', BASE_URL + 'assets/js/ext/ux');
            Ext.require(['*']);

            Ext.namespace('Login');
            Ext.onReady(function() {
                Ext.QuickTips.init();
                Ext.form.Field.prototype.msgTarget = 'side';
                var formLogin = new Ext.FormPanel({
                    frame: false, border: false, buttonAlign: 'center',
                    url: BASE_URL + 'user/ext_login', method: 'POST', id: 'formLogin',
                    bodyStyle: 'padding:10px 10px 15px 15px;background:#dfe8f6;', labelWidth: 150, width: 300,
                    defaults: {
                        allowBlank: false,
                        listeners: {specialkey: function(f, e) {
                                if (e.getKey() == e.ENTER) {
                                    fnLogin();
                                }
                            }}
                    },
                    items: [
                        {xtype: 'textfield', fieldLabel: 'Pengguna', name: 'username', id: 'username'},
                        {xtype: 'textfield', fieldLabel: 'Kata Sandi', name: 'password', id: 'password', inputType: 'password'}
                    ],
                    keys: [
                        {key: [Ext.EventObject.ENTER], fn: fnLogin}
                    ],
                    buttons: [
                        {text: 'Login', handler: fnLogin},
                        {text: 'Reset', handler: function() {
                                formLogin.getForm().reset();
                            }}
                    ]
                });

                function fnLogin() {
                    // this function before action
                    Ext.getCmp('formLogin').on({
                        beforeaction: function() {
                            Ext.getCmp('winMask').body.mask();
                            Ext.getCmp('sbWin').showBusy();
                        }
                    });

                    formLogin.getForm().submit({
                        success: function() {
                            window.location = BASE_URL + 'dashboard';
                        },
                        failure: function(form, action) {
                            Ext.getCmp('winMask').body.unmask();
                            if (action.failureType == 'server') {
                                obj = Ext.decode(action.response.responseText);
                                Ext.getCmp('sbWin').setStatus({
                                    text: obj.errors.reason,
                                    iconCls: 'x-status-error'
                                });
                            } else {
                                if (typeof(action.response) == 'undefined') {
                                    Ext.getCmp('sbWin').setStatus({
                                        text: 'Pengguna dan Kata Sandi tidak boleh kosong !',
                                        iconCls: 'x-status-error'
                                    });
                                } else {
                                    Ext.Msg.alert('Warning!', 'Server is unreachable : ' + action.response.responseText);
                                }
                            }
                        }
                    });
                }

                var winMasking = new Ext.Window({
                    title: 'SIMASS BASARNAS &mdash; LOGIN', layout: 'fit',
                    width: 350, height: 160, resizable: false, closable: false,
                    items: [formLogin], id: 'winMask',
                    bbar: new Ext.ux.StatusBar({text: 'Ready', id: 'sbWin', iconCls: 'x-status-valid'})
                }).show();

                Ext.getCmp('username').focus(false, 200);
            });
        </script>

    </head>
    <body>
        <div id="script_area"></div>
        <div id="body_div"></div>
    </body>
</html>