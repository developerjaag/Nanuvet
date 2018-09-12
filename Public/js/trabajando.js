    $(document).ready(function () {
        
        $('#countdown').timeTo({
            timeTo: new Date(new Date('Sat Dec 31 2016 12:38:38 GMT-0500 (COT)')),
            displayDays: 3,
            lang: 'sp',
            theme: "black",
            displayCaptions: true,
            fontSize: 48,
            captionSize: 14
        });
        
    });