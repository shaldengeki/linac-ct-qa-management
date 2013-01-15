function displayImagePreview(files) {
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /image.*/;
    
    if (!file.type.match(imageType)) {
      continue;
    }
    var img = document.createElement("img");
    img.classList.add("obj");
    img.file = file;
    
    $('#image_preview').empty().append($('<div class="span6"></div>')).append($('<div class="span6"></div>'));
    $('#image_preview').children(':first-child').each(function() {
      $(this).append(img);
      $(this).children().each(function() {
        $(this).addClass('image-preview');
      });
    });
    $('#image_preview').children(':nth-child(2)').each(function() {
      $(this).append($('<h4>Preview</h4>'));
    });
    
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}

$(document).ready(function() {
  $('#form_entry_created_at').datetimepicker();
  $('#ct-monthly').autosave({
      callbacks: {
        save: {
          method: 'ajax',
          options: {
            url: $(location).attr('href') + '&autosave',
            type: 'POST'
          }
        }
      }
  });
});