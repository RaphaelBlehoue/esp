var DivDropzone = function () {
    var _that = $("#my-awesome-dropzone");
    var _actionToDropZone = _that.attr('action');
    return {
        init: function () {
            Dropzone.options.myAwesomeDropzone = {
                url: _actionToDropZone,
                dictDefaultMessage: "",
                maxFilesize: 2, // MB
                maxFiles: 30,
                acceptedFiles : "application/pdf, application/x-pdf",
                init: function () {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Supprimer</a>");
                        console.log(file.previewElement.querySelector("img"));
                        // Listen to the click event
                        var _this = this;

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
                        console.log(file.previewElement.querySelector('img').src = "/adminLayout/assets/pages/scripts/images/pdf.png");
                    });
                }
            }
        }
    }

}();

jQuery(document).ready(function() {
    DivDropzone.init();
});
