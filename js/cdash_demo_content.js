jQuery(document).ready(function($){
  $("#demo_content_buttons").dialog({
    dialogClass: 'wp-dialog',
    modal: true,
    dialogClass: "cdash_demo_content_modal",
    buttons: [
    {
      text: "Ok",
      click: function() {
        $( this ).dialog( "close" );
      }

      // Uncommenting the following line would hide the text,
      // resulting in the label being used as a tooltip
      //showText: false
    }
  ]
  });

  $("#loader").css("display", "none");
  $(".dashboard_page_cdash-about .ui-dialog-buttonpane").hide();

  $(".demo_content.button").click(function(event){
    event.preventDefault();
    $.ajax({
      url: ajaxurl,
      type:'post',
      data: {
        'action': 'cdash_add_demo_data',
      },
      beforeSend: function() {
        $('#loader').show();
        $(".demo_content_decline").hide();
      },
      complete: function(){
         $('#loader').hide();
         $(".dashboard_page_cdash-about .ui-dialog-buttonpane").show();
      },
      success: function(response){
        $(".cdash_demo_success_message").html(response);
      },
    });
  });

  $(".demo_content_decline").click(function(event){
    //$(".dashboard_page_cdash-about .ui-dialog").hide();
    $(".chamber-dashboard_page_cd-welcome .ui-dialog.cdash_demo_content_modal").hide();
    //$(".ui-dialog.cdash_demo_content_modal ").hide();
    //$(".dashboard_page_cdash-about .ui-widget-overlay").hide();
    $(".chamber-dashboard_page_cd-welcome .ui-widget-overlay").hide();
  });
});
