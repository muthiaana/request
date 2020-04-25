


// convert time
    function timeConvert_DD_M_YYYY(UNIX_timestamp){
        var a = new Date(UNIX_timestamp * 1000);
        var year = a.getFullYear();
        var month = a.getMonth()
        var date = a.getDate();
        var time = date + '-' + month + '-' + year ;
        return time;
    }

    function timeConvert_DD_MM_YYYY_HMS(UNIX_timestamp){
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
        return time;
    }

    function timeConvert_DD_MMM_YYYY(UNIX_timestamp){
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['January','February','Maret','April','May','June','July','August','September','October','November','December'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date + ' ' + month + ' ' + year;
        return time;
    }