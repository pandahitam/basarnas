<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>


var panelRow1_01= Ext.create('Ext.Panel', {
    height: 65,
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
	    xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rescueboat.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rescue Boat Kl. II/III/IV</div>'
    }]
});

var panelRow1_02= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rigidinflatableboat.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rigid Inflatable Boat</div>'
    }]
});

var panelRow1_03= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rubberboat.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rubber Boat</div>'
    }]
});

var panelRow1_04= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rescuecartype1.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rescue car Tipe 1</div>'
    }]
});

var panelRow1_05= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rescuecartype2.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rescue car Tipe 2</div>'
    }]
});

var panelRow1_06= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_truckpersonil.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Truck Personil</div>'
    }]
});

var panelRow1_07= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_rescuetruck.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Rescue Truck</div>'
    }]
});

var panelRow1_08= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_ambulance.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Ambulance</div>'
    }]
});

var panelRow1_09= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_atv.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">ATV</div>'
    }]
});

var panelRow1_10= Ext.create('Ext.Panel', {
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '<div align="center"><img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/sp_sepedamotor.png' + '" width="60" height="35" /></div>'
    },{
        xtype: 'panel',
        flex: 5,
		html: '<div align="center">Sepeda Motor</div>'
    }]
});

var panelRow2_01= Ext.create('Ext.Panel', {
    height: 65,
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: 'Dermaga kantor SAR dan Pos SAR'
    }]
});

var panelRow2_02= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '- 1 Unit di Kantor SAR <br />- 1 Unit di Pos SAR'
    }]
});

var panelRow2_03= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '4 unit Kantor SAR <br />dan 3 Unit diPos SAR'
    }]
});

var panelRow2_04= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '1 Unit di Kantor SAR <br />dan Tiap Pos SAR'
    }]
});

var panelRow2_05= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '2 Unit tiap Kantor SAR <br />dan Pos SAR'
    }]
});

var panelRow2_06= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '2 Unit Kantor SAR <br />dan 1 Unit di Pos SAR'
    }]
});

var panelRow2_07= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '1 Unit di Kantor SAR'
    }]
});

var panelRow2_08= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '- 1 Unit di Kantor SAR <br />- 1 Unit di Pos SAR'
    }]
});

var panelRow2_09= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: 'Kantor SAR'
    }]
});

var panelRow2_10= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        flex: 3,
		html: '- 5 Unit Kantor SAR <br />- 3 Unit di Pos SAR'
    }]
});

var panelRow3_01= Ext.create('Ext.Panel', {
    height: 65,
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_01" >-</div>'
    }]
});

var panelRow3_02= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_02" >-</div>'
    }]
});

var panelRow3_03= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_03" >-</div>'
    }]
});

var panelRow3_04= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_04" >-</div>'
    }]
});

var panelRow3_05= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_05" >-</div>'
    }]
});

var panelRow3_06= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_06" >-</div>'
    }]
});

var panelRow3_07= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_07" >-</div>'
    }]
});

var panelRow3_08= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_08" >-</div>'
    }]
});

var panelRow3_09= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_09" >-</div>'
    }]
});

var panelRow3_10= Ext.create('Ext.Panel', {
    layout: { type: 'fit' },	
    renderTo: document.body,
    items: [{
        xtype: 'panel',
		html: '<div align="center" id="count_10" >-</div>'
    }]
});

var rowsPanel = Ext.create('Ext.Panel', {
    width: 616,
    height: 407,
	border: false,
    layout: {
        type: 'hbox',
        align: 'stretch'
    },	
	//defaults: {border: false},
    renderTo: document.body,
    items: [{
        xtype: 'panel',
        title: 'SARANA',
        flex: 3,
		defaults: { width: 306, height: 35, border: false },
		items:[panelRow1_01, panelRow1_02, panelRow1_03, panelRow1_04, panelRow1_05, panelRow1_06, panelRow1_07, panelRow1_08, panelRow1_09, panelRow1_10]
    },{
        xtype: 'panel',
        title: 'JUMLAH',
        flex: 1,
		defaults: { width: 102, height: 35, border: false },
		items:[panelRow3_01, panelRow3_02, panelRow3_03, panelRow3_04, panelRow3_05, panelRow3_06, panelRow3_07, panelRow3_08, panelRow3_09, panelRow3_10]
    },{
        xtype: 'panel',
        title: 'STANDAR PENEMPATAN',
        flex: 2,
		defaults: { width: 204, height: 35, border: false },
		items:[panelRow2_01, panelRow2_02, panelRow2_03, panelRow2_04, panelRow2_05, panelRow2_06, panelRow2_07, panelRow2_08, panelRow2_09, panelRow2_10]
    }]
});

var mainPanel = Ext.create('Ext.Panel', {
        id:'main-panel',
        renderTo: Ext.getBody(),
		layout:'fit',
		items: [rowsPanel]
	});		

var new_popup = new Ext.create('Ext.Window', {
	id: 'winmappopup', title: 'Kekuatan Sarana Kantor SAR ' + Ext.getCmp('idPropsGrid').title, iconCls: 'icon-information',
	width: 640, height: 480, bodyStyle: 'padding: 5px;', 	
	constrainHeader : true, closable: true, modal : true,
	items: [mainPanel],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready',
    id: 'sbWinmappopup',
    iconCls: 'x-status-valid'
  })
});

new_popup.on('show', function(win) 
{
	var saprasUrl = baseUrl + 'global_map/get_sarpras_data/<?php echo($location) ?>';
	console.debug(saprasUrl);
	Ext.Ajax.request({
		url: saprasUrl, 
		method: 'POST',
		success: function(response)
		{
			console.log(response.responseText);
			var jsonData = new Ext.JSON.decode(response.responseText, true);
			var len = jsonData.length;
			for(var i=0; i<len; i++)
			{
				if( Ext.getDom(jsonData[i]['ket']) )
				{
					Ext.getDom(jsonData[i]['ket']).innerHTML = jsonData[i]['jumlah'];
				//console.log( jsonData[i]['ket'] + '|' + jsonData[i]['jumlah'] );
				}
			}
		}
	});
});

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>