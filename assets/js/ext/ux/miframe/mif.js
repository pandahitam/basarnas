
Ext.require([ '*' ]);


Ext.onReady(function() {

    Ext.QuickTips.init();

    var configs = [{
        title       : 'MIF',
        collapsible : true,
        id          : 'mifhost',
        closable    : true,
        floating    : true,
        constrain   : true,
        frame       : true,
        resizable   : true,
        width       : 800,
        height      : 400,
        autoScroll  : false,  //disable so as not to also overflow the child component
        bodyPadding : false,
        layout      : 'fit',
        tbar        : [
            {
               text : 'Disable',
               handler : function(button){
                  var MIF = Ext.ComponentQuery.query('#mifhost > miframe')[0];

                  if(MIF){
                    MIF[ MIF.disabled ? 'enable' : 'disable']();
                    button.setText(MIF.disabled ? 'Enable' : 'Disable');
                  }

               }
            },
            {
                text      : 'Other actions',
                arrowAlign: 'right',
                tooltip   : 'Clicking on the current frame document (shimmed) will also dismiss the attached menu.',
                menu      : [
                    {text: 'Item 1'},
                    {text: 'Item 2'},
                    {text: 'Item 3'},
                    {text: 'Item 4'}
                ]
            }
        ],
        items : {
            xtype : 'miframe',
            src : 'http://www.github.com'
        },
        listeners : {
            load : function(e, listenersConfig){    //bubbled
                window.console && console.info(arguments);
            }
        }
    }];

    var container = Ext.getBody();
    Ext.each(configs, function(config) {

        Ext.createWidget('panel', Ext.applyIf(config, {
            renderTo: container,
            bodyPadding: 4
        }));
    });

    var shimFrames = function(shimmed){
        Ext.invoke(Ext.ComponentQuery.query('miframe'), 'toggleShim', !!shimmed);
    };

    //Dismiss menus -- even when ANY ManagedIframe document is clicked
    Ext.util.Observable.observe(Ext.menu.Menu, {
        'beforeshow': function() { shimFrames( true); },
        'hide'      : function() { shimFrames(false); }
    });

    //Keep the mouse moving smoothly across ManagedIframes through resizing actions
    Ext.util.Observable.observe(Ext.resizer.Resizer, {
        'beforeresize': function() { shimFrames( true); },
        'resize'      : function() { shimFrames(false); }
    });

});


