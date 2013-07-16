function getDashboard() {
	return {
        border: {
            id:'content-right',
            title: 'SELAMAT DATANG',
            layout: 'border',
            bodyBorder: false,
            defaults: {
                collapsible: true,
                split: true,
                animFloat: false,
                autoHide: false,
                useSplitTips: true,
                bodyStyle: 'padding:15px'
            },
            items: [{
                collapsible: false,
                region: 'center',
                margins: '5 0 0 0',
                html: '<h1>SISTEM KEPEGAWAIAN DAERAH PEMERINTAH KABUPATEN CIREBON TAHUN 2011</h1>'
            }]
        }
		
	}
}
