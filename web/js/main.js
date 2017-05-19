    
    var dialog;
        
    $( ".btn-subcomment" ).button().on( "click", function() { 
    dialog.dialog( "open" );
        
   parentId = $(this).data("parent")                
    $(".champCache").val( parentId)

                                                         } );
    dialog = $( "#dialog-form" ).dialog({ autoOpen: false, height: 400, width: 350, modal: true, });
      