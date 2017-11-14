var FormDropzone = function () {
    var _that = $("#my-dropzone-zone");
    var _actionToDropZone = _that.attr('action');
    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzone = {
                url: _actionToDropZone,
                maxFilesize: 3, // MB
                maxFiles: 30,
                acceptedFiles : "application/pdf, application/x-pdf",
                createImageThumbnails: true,
                init: function() {

                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
                        console.log(file.previewElement.querySelector("img"));
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                    this.on('success', function(file, responseText, e){
                        console.log(file.previewElement.querySelector("img"));
                    });
                    this.on('maxfilesexceeded', function(){
                        alert("Limite de fichier uploader simultanement attient");
                    });
                }
            }
        }
    };
}();

jQuery(document).ready(function() {
    FormDropzone.init();
});