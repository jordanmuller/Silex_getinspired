(function() {
  
  'use strict';

  $('.input-file').each(function() {
    var $input = $(this),
        $label = $input.parent().find('.js-labelFile'),
        labelVal = $label.html();
    
   $input.on('change', function(element) {
       
      var fileName = '';
      if (element.target.value) fileName = element.target.value.split('\\').pop();
      
      console.log(fileName);
      fileName ? $label.addClass('has-file').find('.js-fileName').html('<span class="glyphicon glyphicon-ok"></span>' + fileName) : $label.removeClass('has-file').html(labelVal);
   });
  });

})();