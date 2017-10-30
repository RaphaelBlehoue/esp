var FormDropzone = function () {
    var _that = $("#my-dropzone");
    var _actionToDropZone = _that.attr('action');
    var _entity = _that.data('name');

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    function addStatus(media, entity,elt) {
        $.ajax({
            url: Routing.generate('set_media_status', { id: media, name: entity}),
            cache: false,
            dataType: 'Json',
            method: 'GET',
            success: function (data, textStatus) {
                if (data.response_media === media){
                    var _this = $('a#'+data.response_media)
                    // Les autres buttonn
                    $(elt+' a').css('display','none').hide();
                    //Element this
                    _this.removeClass('btn-success').addClass(data.className);
                    _this.html('<b><i class="icon-sun3"></i></b>'+data.text_href+'').css('display', 'block');
                    _this.on('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if ( _this.hasClass('actived')){
                            $(elt+' a').css('display','block').show();
                            _this.removeClass(data.className).addClass('btn-success');
                            _this.empty().html('<b><i class="icon-pushpin"></i></b>Mettre en avant');
                        }
                    });
                }
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzone = {
                url: _actionToDropZone,
                dictDefaultMessage: "",
                maxFilesize: 2, // MB
                maxFiles: 30,
                acceptedFiles : "image/jpeg,image/png,image/gif",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

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
                        var defaultButton = Dropzone.createElement('<div class="default_pic_container"><a id="'+responseText.media+'" class="btn yellow-gold">Mettre en avant</a></div>');
                        file.previewElement.appendChild(defaultButton);
                        console.log(file.previewElement);
                        defaultButton.addEventListener('click', function (evt) {
                            evt.preventDefault();
                            evt.stopPropagation();
                            addStatus(responseText.media, _entity, '.default_pic_container');
                        })
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