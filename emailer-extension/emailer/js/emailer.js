$(function () {
    "use strict"; 
    
    var emailerQuill;
    
    // Quill toolbar options for email composition
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['link', 'image'],                                 // link and image
        ['clean']                                         // remove formatting button
    ];
    
    // Function to initialize the Quill editor
    function initializeEmailerQuill() {
        const editorElement = document.getElementById('emailerEditor');
        
        // Check if Quill is available
        if (typeof Quill === 'undefined') {
            console.error('Quill is not loaded. Make sure wysiwyg.min.js is loaded before emailer.js');
            return;
        }
        
        if (editorElement && !emailerQuill) {
            try {
                // Create new Quill instance
                emailerQuill = new Quill('#emailerEditor', {
                    theme: 'snow',
                    modules: {
                        toolbar: toolbarOptions
                    },
                    placeholder: 'Compose your email message here...'
                });

                // Update hidden input when content changes
                emailerQuill.on('text-change', function () {
                    const contents = emailerQuill.root.innerHTML;
                    const bodyInput = document.getElementById('emailerBody');
                    if (bodyInput) {
                        bodyInput.value = contents;
                        bodyInput.dispatchEvent(new Event('input'));
                    }
                });

                console.log('Emailer Quill editor initialized successfully');
            } catch (error) {
                console.error('Error initializing Quill editor:', error);
            }
        } else if (!editorElement) {
            console.error('emailerEditor element not found');
        }
    }
    
    // Initialize on page load
    initializeEmailerQuill();
    
    // Also initialize when Livewire triggers the event (for safety)
    livewire.on("initEmailer", function() {
        initializeEmailerQuill();
    });

    // Reset editor after sending email
    livewire.on('resetEmailer', function() {
        if (emailerQuill) {
            emailerQuill.setText('');
            const bodyInput = document.getElementById('emailerBody');
            if (bodyInput) {
                bodyInput.value = '';
            }
        }
    });
    
    // Livewire hook - reinitialize after Livewire updates
    document.addEventListener('livewire:load', function () {
        initializeEmailerQuill();
    });
});
