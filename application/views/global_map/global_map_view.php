<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL MAP  -------------------------------------------- START

var baseUrl = '<?php echo base_url(); ?>';
var PixelsPerInch = 72; //defaults are for meters
var InchesPerMapUnit = 39.3701;
var	mapDefaultExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);

var mapQueryPoint = new Array(-1, -1);

var mapMode;
var mapExtent;
var mapWidth;
var mapHeight;
var mapCellsize;
var mapMinScale;
var mapMaxScale;
var mapZoomDir;
var mapZoomSize;
var mapPanSize;


var refExtent;
var refWidth;
var refHeight;
var refCellsize;

function Layer(name, longname, group, status) {
  this.name = name;
  this.longname = longname;
  this.group = group;
  this.status = status;
}

var mapLayers =  new Array();
mapLayers[mapLayers.length] = new Layer('Batas_Negara', 'Batas Negara', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Batas_Provinsi', 'Batas Provinsi', 'layers', false);
mapLayers[mapLayers.length] = new Layer('Batas_Kabupaten', 'Batas Kabupaten', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Batas_Kecamatan', 'Batas Kecamatan', 'layers', false);
mapLayers[mapLayers.length] = new Layer('Kantor_SAR', 'Kantor SAR', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Pos_SAR', 'Pos SAR', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Jalan_Lokal', 'Jalan Lokal', 'layers', false);

function buildLayer() {
	var s = '';
	for(var i=0;i<mapLayers.length;i++)
	{
		if(mapLayers[i].status)
		{
			if(s=='') s += mapLayers[i].name;
			else s += '+'+mapLayers[i].name;
		}
	}
	return s;
};

var startMapImg = '/cgi-bin/mapserv?mode=map&map=MAP_FILE&mapext='+mapDefaultExtent.join('+')+'&mapsize=768+480&layers='+buildLayer();
var startRefImg = '/cgi-bin/mapserv?mode=reference&map=MAP_FILE&mapext='+mapDefaultExtent.join('+')+'&mapsize=768+480';

function applyZoom(x,y) {
	var dx, dy, mx, my, x, y, zoom;
	if(mapZoomDir == 1 && mapZoomSize != 0) zoom = mapZoomSize;
	else if(mapZoomDir == -1 && mapZoomSize != 0) zoom = 1/mapZoomSize;
	else zoom = 1;
	// convert *click* to map coordinates
	dx = mapExtent[2] - mapExtent[0];
	dy = mapExtent[3] - mapExtent[1];
	mx = mapExtent[0] + mapCellsize*x; 
	my = mapExtent[3] - mapCellsize*y;
	mapExtent[0] = mx - .5*(dx/zoom);
	mapExtent[1] = my - .5*(dy/zoom);
	mapExtent[2] = mx + .5*(dx/zoom);
	mapExtent[3] = my + .5*(dy/zoom);
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	if(mapMinScale != -1 && getScale() < mapMinScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMinScale);
	}
	if(mapMaxScale != -1 && getScale() > mapMaxScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMaxScale);
	}
};

function applyReference(x,y) {
	var mx, my, dx, dy;
	dx = mapExtent[2] - mapExtent[0];
	dy = mapExtent[3] - mapExtent[1];
	mx = refExtent[0] + refCellsize*x;
	my = refExtent[3] - refCellsize*y;
	mapExtent[0] = mx - .5*dx;
	mapExtent[1] = my - .5*dy;
	mapExtent[2] = mx + .5*dx;
	mapExtent[3] = my + .5*dy;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
};

function getScale() {
	var gd, md;
	md = (mapWidth-1)/(PixelsPerInch*InchesPerMapUnit);
	gd = mapExtent[2] - mapExtent[0];
	return(gd/md);
};

function setExtentFromScale(x, y, scale) {
	if((mapMinScale != -1) && (scale < mapMinScale)) scale = mapMinScale;
	if((mapMaxScale != -1) && (scale > mapMaxScale)) scale = mapMaxScale;
	mapCellsize = (scale/PixelsPerInch)/InchesPerMapUnit;
	mapExtent[0] = x - mapCellsize*mapWidth/2.0;
	mapExtent[1] = y - mapCellsize*mapHeight/2.0;
	mapExtent[2] = x + mapCellsize*mapWidth/2.0;
	mapExtent[3] = y + mapCellsize*mapHeight/2.0;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
};

function setExtent(minx, miny, maxx, maxy) {
	mapExtent[0] = minx;
	mapExtent[1] = miny;
	mapExtent[2] = maxx;
	mapExtent[3] = maxy;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	if(mapMinScale != -1 && getScale() < mapMinScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMinScale);    
	}
	if(mapMaxScale != -1 && getScale() > mapMaxScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMaxScale);
	}
};

function adjustExtent(extent, width, height) {
	var cellsize = Math.max((extent[2] - extent[0])/(width-1), (extent[3] - extent[1])/(height-1));
	if(cellsize > 0) {
		var ox = Math.max(((width-1) - (extent[2] - extent[0])/cellsize)/2,0);
		var oy = Math.max(((height-1) - (extent[3] - extent[1])/cellsize)/2,0);
		extent[0] = extent[0] - ox*cellsize;
		extent[1] = extent[1] - oy*cellsize;
		extent[2] = extent[2] + ox*cellsize;
		extent[3] = extent[3] + oy*cellsize;
	}	
	return(cellsize);
};

function mapInit() {
	mapMode = 'map';
	mapExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	mapWidth = 768;
	mapHeight = 480;
	mapZoomDir = 0;
	mapZoomSize = 1.5;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	mapMinScale = -1;
	mapMaxScale = -1;
	mapPanSize = .8;
	refExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	refWidth = 192;
	refHeight = 120;
	refCellsize = adjustExtent(refExtent, refWidth, refHeight);
};

function applyQuery() {
	var queryUrl = '/cgi-bin/mapserv?mode=query&map=MAP_FILE&imgext='+mapExtent.join('+')+'&imgxy='+mapQueryPoint.join('+')+'&imgsize='+mapWidth+'+'+mapHeight+'&layers='+buildLayer()+'&qlayer=Batas_Kabupaten';
	Ext.Ajax.timeout = Time_Out;
	Ext.Ajax.request({
		url: queryUrl, 
		method: 'GET',
		success: function(response){
			var rslt = new Ext.JSON.decode(response.responseText, true);
			var imageName = baseUrl+'assets/map/tmp/';
			imageName += 'basarnas'+rslt.batasWilayah[0].imageId+'.png';
			document.mainImage.src = imageName;
			var data = rslt.batasWilayah[0];
			propsGrid.setSource({
				'1. Kode PSE': data.kodePse,
				'2. Kode Provinsi': data.kodeProv,
				'3. Nama Provinsi': data.namaProv,
				'4. Kode Kabupaten': data.kodeKab,
				'5. Nama Kabupaten': data.namaKab,
				'6. Pemekaran': data.pemekaran,
				'7. Sumber Data': data.sumberData
			});
			Ext.getCmp('kode_pse').setValue(data.kodePse);
		}
	});
};

function mapDraw() {
	propsGrid.setSource({});
	if(mapMode=='map')
	{
		document.mainImage.src = "/cgi-bin/mapserv?mode=map&map=MAP_FILE&mapext="+mapExtent.join("+")+"&mapsize="+mapWidth+"+"+mapHeight+"&layers="+buildLayer();
	} else if(mapMode=='query') applyQuery();
	document.referenceImage.src = "/cgi-bin/mapserv?mode=reference&map=MAP_FILE&mapext="+mapExtent.join("+")+"&mapsize="+mapWidth+"+"+mapHeight;
};

function imgClick(event) {
	pos_x = event.offsetX;
	pos_y = event.offsetY;
	if(mapMode=='map')
	{
		applyZoom(pos_x, pos_y);
	} else if(mapMode=='query')
	{
		mapQueryPoint[0] = pos_x;
		mapQueryPoint[1] = pos_y;
	}
	mapDraw();
};

function refClick(event) {
	var oldMode = mapMode;
	mapMode = 'map';
	pos_x = event.offsetX;
	pos_y = event.offsetY;
	applyReference(pos_x, pos_y);
	mapDraw();
	mapMode = oldMode;
	propsGrid.setSource({});
};

function applyItemQuery(kodeWilayah) {
	
	if(kodeWilayah!=null)
	{
		kodeWilayah +='';
		if(kodeWilayah.length==4)
		{
			var kode = '';
			var queryUrl = '';
			kode = kodeWilayah.substr(2,2);
			if(kode=='00'){
				queryUrl = '/cgi-bin/mapserv?mode=itemquery&map=MAP_FILE&qstring='+kodeWilayah+'&qitem=KODEPSE&qlayer=Batas_Provinsi';
			} else {
				queryUrl = '/cgi-bin/mapserv?mode=itemquery&map=MAP_FILE&qstring='+kodeWilayah+'&qitem=KODEPSE&qlayer=Batas_Kabupaten';
			}
			Ext.Ajax.timeout = Time_Out;
			Ext.Ajax.request({
				url: queryUrl, 
				method: 'GET',
				success: function(response){
					var rslt = new Ext.JSON.decode(response.responseText, true);
					var extTmp = rslt.batasWilayah[0].extent.split(' ');
					if(extTmp.length==4)
					{
						setExtent(parseFloat(extTmp[0]), parseFloat(extTmp[1]), parseFloat(extTmp[2]), parseFloat(extTmp[3]));
						var oldMode = mapMode;
						mapMode = 'map';
						mapDraw();
						mapMode = oldMode;
					}
					var data = rslt.batasWilayah[0];
					propsGrid.setSource({
						'1. Kode PSE': data.kodePse,
						'2. Kode Provinsi': data.kodeProv,
						'3. Nama Provinsi': data.namaProv,
						'4. Kode Kabupaten': data.kodeKab,
						'5. Nama Kabupaten': data.namaKab,
						'6. Pemekaran': data.pemekaran,
						'7. Sumber Data': data.sumberData
					});			
				}
			});
		}
	}
};

function applyZoomIn() {
	applyZoom(parseInt(mapWidth/2),parseInt(mapHeight/2));  
	mapDraw();
};

function applyZoomOut() {
	applyZoom(parseInt(mapWidth/2),parseInt(mapHeight/2));  
	mapDraw();
};

function applyZoomAll() {
	mapExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	refExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	refCellsize = adjustExtent(refExtent, refWidth, refHeight);
	mapDraw();
};


//-------------------------------------------------------------------------------------------------------------------------------
var propsGrid = Ext.create('Ext.grid.property.Grid', {
	width: '100%',
	bodyPadding: 5,
	padding: '5 0 0 0',
	renderTo: Ext.getBody(),
	source: {}
});

var scale_slider = new Ext.create('Ext.slider.Single', {
	width: 130,
	value: 1.5,
	increment: 0.25,
	minValue: 1,
	maxValue: 4,
	decimalPrecision: 2,
	renderTo: Ext.getBody(),
	listeners: {
		change : function(ctl, newValue, oldValue, options) {
			mapZoomSize = parseFloat(newValue);
		}
	}			

});

var map_option_control = new Ext.create('Ext.form.Panel', {
    title: 'Control',
    bodyPadding: 10,
	padding: '5 0 0 0',
    width: '100%',
    height: 210,
    renderTo: Ext.getBody(),
    items:[
		{
			xtype: 'radiogroup',
			columns: 1,
			vertical: true,
			items: [
				{
					boxLabel: ' Query feature', 
					name: 'mapOption',
					handler: function(ctl, val) {
					  if(val) mapMode = 'query';
					}			
				},
				{
					boxLabel: ' Pan', 
					name: 'mapOption',
					checked: true,
					handler: function(ctl, val) {
						if(val) 
						{
							mapZoomDir = 0;
							mapMode = 'map';
						}
					}			
				}
			]
		},
		{
			xtype: 'label',
			text: 'Zoom Size'
		}, scale_slider,
		{
			xtype: 'button', 
			text: 'Zoom In',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapZoomDir = 1;
					applyZoomIn();
					mapZoomDir = 0;
					mapMode = oldMode;
				}
			}
		},
		{
			xtype: 'button', 
			text: 'Zoom Out',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapZoomDir = -1;
					applyZoomOut();
					mapZoomDir = 0;
					mapMode = oldMode;
				}
			}
		},
		{
			xtype: 'button', 
			text: 'Zoom All',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					applyZoomAll();
					mapMode = oldMode;
				}
			}
		}
	]
});

var map_option_layer = new Ext.create('Ext.form.Panel', {
    title: 'Layers',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
    height: '100%',
    renderTo: Ext.getBody(),
    items: [
        {
            xtype: 'fieldcontainer',
            defaultType: 'checkboxfield',
            items: [
                {
                    boxLabel  : mapLayers[0].longname,
                    name      : mapLayers[0].group,
                    checked   : mapLayers[0].status,
					handler: function(ctl, val) {
						mapLayers[0].status = val;
					}
                }, {
                    boxLabel  : mapLayers[1].longname,
                    name      : mapLayers[1].group,
                    checked   : mapLayers[1].status,
					handler: function(ctl, val) {
						mapLayers[1].status = val;
					}
                }, {
                    boxLabel  : mapLayers[2].longname,
                    name      : mapLayers[2].group,
                    checked   : mapLayers[2].status,
					handler: function(ctl, val) {
						mapLayers[2].status = val;
					}
                },
                {
                    boxLabel  : mapLayers[3].longname,
                    name      : mapLayers[3].group,
                    checked   : mapLayers[3].status,
					handler: function(ctl, val) {
						mapLayers[3].status = val;
					}
                }, {
                    boxLabel  : mapLayers[4].longname,
                    name      : mapLayers[4].group,
                    checked   : mapLayers[4].status,
					handler: function(ctl, val) {
						mapLayers[4].status = val;
					}
                }, {
                    boxLabel  : mapLayers[5].longname,
                    name      : mapLayers[5].group,
                    checked   : mapLayers[5].status,
					handler: function(ctl, val) {
						mapLayers[5].status = val;
					}
                }, {
                    boxLabel  : mapLayers[6].longname,
                    name      : mapLayers[6].group,
                    checked   : mapLayers[6].status,
					handler: function(ctl, val) {
						mapLayers[6].status = val;
					}
				}
            ]			
        },
		{
			xtype: 'button', 
			name: 'map_layer_btn', 
			id: 'map_layer_btn', 
			text: 'Apply Layer(s)',
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapDraw();
					mapMode = oldMode;
				}
			}
		}
    ]
});

var map_reference = new Ext.create('Ext.form.Panel', {
    title: 'Reference',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
    renderTo: Ext.getBody(),
    items: [
		{ html: '<img onClick="refClick(event)" name="referenceImage" width="192" height="120" src="'+startRefImg+'" />' }
	]
});

var map_item_query = new Ext.create('Ext.form.Panel', {
    title: 'Item Query',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
	height: '100%',
    renderTo: Ext.getBody(),
    items: [
		{
			xtype: 'textfield',
			id: 'kode_pse',
			fieldLabel: 'Kode PSE'
		},
		{
			xtype: 'button', 
			name: 'map_query_btn', 
			id: 'map_query_btn', 
			text: 'Locate Map',
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'itemquery';
					applyItemQuery(Ext.getCmp('kode_pse').value);
					mapMode = oldMode;
				}
			}
		},
		propsGrid
    ]
});

var map_navigator_layout = new Ext.create('Ext.panel.Panel', {
   id: 'map_navigator_layout', layout: 'border', width: '100%', height: '100%', bodyStyle: 'padding: 0px;', border: false,
   items: [
		{id: 'West_map_navigator', title:'Option', region: 'west', width: 200, minWidth: 200, split: true, collapsible: true, collapseMode: 'mini', bodyStyle: 'padding: 5px',
		 items: [map_option_control, map_option_layer]
		},
		{id: 'center_map_navigator', region: 'center', split: true, bodyStyle: 'padding: 6px; background : #35537e;', width: '100%', height: '100%',
		 html: '<img onClick="imgClick(event)" name="mainImage" width="768" height="480" src="'+startMapImg+'"/>'
		},
		{id: 'East_map_navigator', title: 'Reference and Query', region: 'east', width: 360, minWidth: 360, split: true, collapsible: true, collapseMode: 'mini', bodyStyle: 'padding: 5px',
		 items: [map_reference, map_item_query]
		}
   ],
	listeners: {
			render: function(){
			mapInit();
		}
	}
   });

var map_navigator = new Ext.create('Ext.panel.Panel', {
   id: 'boxborder_map_navigator', title: 'Navigator', layout: 'border',
   width: '100%', height: '100%', bodyStyle: 'padding: 0px;',
   items: [
		{region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: false,
	   items: [map_navigator_layout]
		}
   ]
});

var new_tabpanel = {
	id: 'map_asset', title: 'Global MAP', iconCls: 'icon-star',  border: true, closable: true,  
	layout: 'fit', items: [map_navigator]
}

<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>