$(function () {
    "use strict"; 
    
    var emailerQuill;
    var isUpdating = false; // Flag to prevent circular updates
    
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

                // Update hidden input when content changes (don't sync with Livewire yet)
                emailerQuill.on('text-change', function (delta, oldDelta, source) {
                    if (isUpdating) return; // Prevent circular updates
                    
                    const contents = emailerQuill.root.innerHTML;
                    
                    // Only update the hidden input - we'll sync with Livewire on form submit
                    const bodyInput = document.getElementById('emailerBody');
                    if (bodyInput) {
                        bodyInput.value = contents;
                    }
                });

                console.log('Emailer Quill editor initialized successfully');
            } catch (error) {
                console.error('Error initializing Quill editor:', error);
            }
        } else if (!editorElement) {
            console.error('emailerEditor element not found');
        } else if (emailerQuill) {
            // Editor already exists, just ensure content is preserved
            console.log('Emailer Quill editor already initialized');
        }
    }
    
    // Initialize on page load
    initializeEmailerQuill();
    
    // Function to sync body content with Livewire component
    function syncBodyWithLivewire() {
        if (!emailerQuill) return;
        
        const contents = emailerQuill.root.innerHTML;
        
        // Update hidden input
        const bodyInput = document.getElementById('emailerBody');
        if (bodyInput) {
            bodyInput.value = contents;
        }
        
        // Find and update the Livewire component
        try {
            const editorElement = document.getElementById('emailerEditor');
            if (editorElement) {
                const livewireElement = editorElement.closest('[wire\\:id]');
                if (livewireElement) {
                    const componentId = livewireElement.getAttribute('wire:id');
                    const component = window.Livewire.find(componentId);
                    
                    if (component && component.set) {
                        component.set('body', contents);
                        console.log('Body synced with Livewire component');
                    }
                }
            }
        } catch (e) {
            console.error('Error syncing body:', e);
        }
    }
    
    // Intercept form submit at the form level to sync body BEFORE Livewire processes it
    setTimeout(function() {
        const formElement = document.querySelector('form[wire\\:submit\\.prevent]');
        if (formElement) {
            formElement.addEventListener('submit', function(e) {
                syncBodyWithLivewire();
            }, true); // Use capture phase to run before Livewire
        }
    }, 500);
    
    // Also initialize when Livewire triggers the event (for safety)
    if (typeof livewire !== 'undefined') {
        livewire.on("initEmailer", function() {
            setTimeout(function() {
                initializeEmailerQuill();
            }, 100);
        });

        // Reset editor after sending email
        livewire.on('resetEmailer', function() {
            if (emailerQuill) {
                isUpdating = true;
                emailerQuill.setText('');
                const bodyInput = document.getElementById('emailerBody');
                if (bodyInput) {
                    bodyInput.value = '';
                }
                setTimeout(function() {
                    isUpdating = false;
                }, 100);
            }
        });
    }
    
    // Livewire hooks - preserve editor content during updates
    document.addEventListener('livewire:load', function () {
        initializeEmailerQuill();
    });
    
    // Prevent Livewire from destroying the editor during updates
    document.addEventListener('livewire:update', function () {
        if (emailerQuill) {
            const currentContent = emailerQuill.root.innerHTML;
            // Re-initialize if needed and restore content
            setTimeout(function() {
                const editorElement = document.getElementById('emailerEditor');
                if (editorElement && !editorElement.querySelector('.ql-editor')) {
                    emailerQuill = null;
                    initializeEmailerQuill();
                    if (emailerQuill && currentContent && currentContent !== '<p><br></p>') {
                        isUpdating = true;
                        emailerQuill.root.innerHTML = currentContent;
                        setTimeout(function() {
                            isUpdating = false;
                        }, 100);
                    }
                }
            }, 50);
        }
    });
});

