$(function () {
    "use strict"; 
    //
    var easyMDE;
    var timeoutId = 0;
    //
    livewire.on("initEmailer", data => {

        easyMDE = new EasyMDE({
            element: document.getElementById('emailerTextArea')
        });

        //
        easyMDE.codemirror.on("change", () => {
            const emailBody = easyMDE.markdown(easyMDE.value());
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                livewire.emit('emailBodyUpdate', emailBody);
            }, 500);
        });
    });


    livewire.on('resetEmailer', data => {
        easyMDE.value("");
    })


});
