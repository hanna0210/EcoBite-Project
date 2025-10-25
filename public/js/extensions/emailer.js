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

        // Add name attribute to CodeMirror's internal textarea to fix browser warning
        const cmTextarea = easyMDE.codemirror.getInputField();
        if (cmTextarea) {
            cmTextarea.setAttribute('name', 'emailBodyContent');
            cmTextarea.setAttribute('id', 'emailBodyContent');
        }

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
