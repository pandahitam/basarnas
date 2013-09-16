<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

    var spGrid = Ext.create('Ext.grid.Panel', {
		width: '100%', height: '100%', renderTo: Ext.getBody(),
        store: Ext.create('Ext.data.Store', {
			storeId: 'sSpAssets',
			model: Ext.define('mSpAsset', { extend: 'Ext.data.Model', fields: ['nomor', 'image', 'sarana', 'jumlah', 'standar'] } ),
			data: []
		}),
		columns: [
			{ text: 'NO.', dataIndex: 'nomor', align: 'center', width: 32, hidden: true },
			{
				dataIndex: 'image', align: 'center', width: 80, minHeight : 24,
				renderer: function(val) { return '<img src="<?php echo base_url(); ?>' + 'assets/images/sarpras/' + val +'.png' + '" width="60" height="35" />'; }
			},
			{ text: 'SARANA', flex: 5, dataIndex: 'sarana', align: 'center' },
			{ text: 'JUMLAH', flex: 2, dataIndex: 'jumlah', align: 'center' },
			{ text: 'STANDAR PENEMPATAN', flex: 5, dataIndex: 'standar' }
		]
    });

var new_popup = new Ext.create('Ext.Window', {
	id: 'winmappopup', title: 'Kekuatan Sarana Kantor SAR', iconCls: 'icon-information',
	width: 520, height: 520, constrainHeader : true, resizable: false, closable: true, modal : true, items: [spGrid],
	listeners: {
		show: function() {
			var saprasUrl = baseUrl + 'global_map/get_sarpras_data/<?php echo($location) ?>';
			Ext.Ajax.request({
				url: saprasUrl, 
				method: 'POST',
				success: function(response)
				{
					spGrid.getStore().loadData(new Ext.JSON.decode(response.responseText, true));
					spGrid.setTitle(Ext.getCmp('idPropsGrid').title);
				}
			});
		}
	}
});


<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>