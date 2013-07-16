<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// START - FORM RUN SQL
var Form_DB_Tools = new Ext.create('Ext.form.Panel', {
 	id: 'Form_DB_Tools', url: BASE_URL + 'utility_simpeg/restore_db_simpeg', fileUpload: true, 
  frame: true, bodyStyle: 'padding: 5px 5px 0 0;', height: '100%',
  fieldDefaults: {labelAlign: 'left', msgTarget: 'side', labelWidth: 120},
  defaultType: 'textfield', defaults: {allowBlank: true}, autoScroll:true,
  items: [
    {xtype: 'fieldset', title: 'RUN SQL Commands', defaultType: 'textfield', margins: '0 0 0 0', style: 'padding: 10px 5px 10px 15px; border-width: 1px;', width: 500,
     items: [
     	{xtype: 'textareafield', name: 'txt_sql', height: 83, width: 465},
	    {xtype: 'toolbar', height: 30, width: 465,
	     items: [
		    '->',
		    {xtype: 'button', name: 'sql_cmd_btn', id: 'sql_cmd_btn', text: 'START RUN SQL', align: 'right',
		     handler: function(){Run_SQL();}
		    }
		   ]
		  }
     ]
    },
    {xtype: 'fieldset', title: 'BACKUP DATABASE (TABLE)', defaultType: 'textfield', margins: '0 0 0 0', style: 'padding: 10px 5px 10px 15px; border-width: 1px;', width: 500,
     items: [
	    {xtype: 'toolbar', height: 30, width: 465,
	     items: [
		    '->',
		    {xtype: 'button', name: 'sql_backup_btn', id: 'sql_backup_btn', text: 'START BACKUP DATABASE',
		     handler: function(){}
		    }
		   ]
		  }
     ]
    },
    {xtype: 'fieldset', title: 'RESTORE DATABASE', defaultType: 'textfield', defaults: {labelAlign: 'top', allowBlank: true}, margins: '0 0 0 0', style: 'padding: 10px 5px 10px 15px; border-width: 1px;', width: 500,
     items: [
	    {xtype: 'hidden', name: 'id_open', value: 1},
	    {xtype: 'toolbar', height: 30, width: 465, align: 'center',
	     items: [
				{xtype: 'fileuploadfield', name: 'filedb', id:'filedb', buttonOnly: true, buttonText: 'RESTORE DATABASE', hideLabel: true,
				 listeners: {
				 	'change': function(){
				 		if(Form_DB_Tools.getForm().isValid()){
				 			Form_DB_Tools.getForm().submit({
				 				waitMsg: 'Sedang meng-upload photo...',
				 				success: function(form, action) {
				 					obj = Ext.decode(action.response.responseText);
				 					if(obj.reason == 'SUKSES'){
				 						alert('SUKSES');
				 					}
				 				},
		    				failure: function(form, action){
		      				obj = Ext.decode(action.response.responseText);
		      				Ext.MessageBox.show({title:'Gagal Upload File Backup !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		    				}, scope: this
				 			});
				 		}
				 	}
				 }
				}
			 ]
			}     
     ]
    }
  ]
});
// END - FORM RUN SQL

// PANEL DATABASE TOOLS  -------------------------------------------- START
var Box_DB_Tools = new Ext.create('Ext.panel.Panel', {
   id: 'Box_DB_Tools', layout: 'border', width: '100%', height: '100%', bodyStyle: 'padding: 0px;', border: false,
   items: [
   	{id: 'East_DB_Tools', title:'Query Logs', region: 'east', width: 405, minWidth: 405, split: true, collapsible: true, collapseMode: 'mini', bodyStyle: 'padding: 5px',
   	 html: 'Test'
	  },
	  {id: 'Center_DB_Tools', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '80%', border: false, bodyStyle: 'background-color:#DFE8F6',
	   items: [Form_DB_Tools]
	  }
   ]
});

var boxborder_DB_Tools = new Ext.create('Ext.panel.Panel', {
   id: 'boxborder_DB_Tools', title: 'DATABASE TOOLS', layout: 'border',
   width: '100%', height: '100%', bodyStyle: 'padding: 0px;',
   items: [
		{region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: false,
	   items: [Box_DB_Tools]
		}
   ]
});

var new_tabpanel = {
	id: 'db_tools', title: 'DB Tools', iconCls: 'icon-menu_db_tools',  border: false, closable: true,  
	layout: 'fit', items: [boxborder_DB_Tools]
}
// PANEL DATABASE TOOLS  -------------------------------------------- END

// START - FUNCTION DATABASE TOOLS
function Run_SQL(){
	var vstr_sql = Form_DB_Tools.getForm().findField('txt_sql').getValue();
	if(vstr_sql){
		Ext.Ajax.request({
	  	url: BASE_URL + 'utility_simpeg/run_sql',
	    method: 'POST', params: {id_open: 1, str_sql:vstr_sql}, renderer: 'data',
	    success: function(response){
	    	Ext.getCmp('East_DB_Tools').update(response.responseText);
			},
	    failure: function(response){ Ext.getCmp('East_DB_Tools').update(response.responseText); }, 
	    scope : this
		});
	}
}
// END - FUNCTION DATABASE TOOLS

<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>