jQuery(document).ready(function($){
  $(".cdash_email_subscribe_div .email_signup").click(function(e) {
    $(".cdash_email_popup").slideDown("slow");
  });

  $(".cdash_email_popup .close_button").click(function(e){
    $(".cdash_email_popup").slideUp("slow");
  });

  var cdash_image_uploader;
  $('#cdash_default_thumb_button').click(function(e) {
    e.preventDefault();
    //If the uploader object has already been created, reopen the dialog
   if (cdash_image_uploader) {
     cdash_image_uploader.open();
     return;
   }

  //Extend the wp.media object
  cdash_image_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
   text: 'Choose Image'
   },
   multiple: false
  });

  //When a file is selected, grab the URL and set it as the text field's value
  cdash_image_uploader.on('select', function() {
   attachment = cdash_image_uploader.state().get('selection').first().toJSON();
   var url = '';
   url = attachment['url'];
   jQuery('#cdash_default_thumb').val(url);
  });

  //Open the uploader dialog
  cdash_image_uploader.open();
  });

  //$("#bus_directory_settings").accordion();
  //$( ".settings_sections h2, .settings_sections table" ).wrap( "<div class='new'></div>" );
  //$( ".inner" ).wrapAll( "<div class='new' />");
  /*$('.settings_sections h2').each(function(){
    $(this).next('table').andSelf().wrapAll('<div class="section_wrap"/>');
});*/

  /*$(".settings_sections .section_wrap").accordion({
      header: "h2"
  });*/

  /*$(".settings_sections").accordion({
      heightStyle: "content",
      icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
  });*/

  //var allPanels = $('.settings_sections > table').hide();
  $('.settings_sections table.form-table, .settings_sections div.content').first().addClass('show');
  $('.settings_sections table.form-table, .settings_sections div.content').first().show();
  $('.settings_sections > h2').first().addClass('active');

  $('.settings_sections > h2').append('<span class="toggle"></span>');

  $('.settings_sections > h2').click(function(e) {
      event.preventDefault();
      var $this = $(this);
      if($this.hasClass('active')){
          $this.removeClass('active');
      }else{
          $this.parent().find('h2').removeClass('active');
          $this.toggleClass('active');
      }

      if($this.next().next('table.form-table').hasClass('show')){
          $this.next().next('table.form-table').removeClass('show');
          $this.next().next('table.form-table').slideUp(100);
      }else{
          $this.parent().find('table.form-table').removeClass('show');
          $this.parent().find('table.form-table').slideUp(100);
          $this.next().next('table.form-table').toggleClass('show');
          $this.next().next('table.form-table').slideToggle(100);
      }

      if($this.next().next('div.content').hasClass('show')){
          $this.next().next('div.content').removeClass('show');
          $this.next().next('div.content').slideUp(100);
      }else{
          $this.parent().find('div.content').removeClass('show');
          $this.parent().find('div.content').slideUp(100);
          $this.next().next('div.content').toggleClass('show');
          $this.next().next('div.content').slideToggle(100);
      }
  });
});
