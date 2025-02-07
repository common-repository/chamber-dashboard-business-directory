/**
 * All Tax meta class
 *
 * JS used for the custom fields and other form items.
 *
 * Copyright 2012 Ohad Raz (admin@bainternet.info)
 * @since 1.0
 * 
 * @package Tax Meta Class
 * 
 */

var $ =jQuery.noConflict();
function update_repeater_fields(){
    
    /**
     * WysiWyg editor
     *
     * @since 1.9.6
     */
    $(".theEditor").each(function(){
      if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
      tinyMCE.execCommand("mceAddControl", false, $(this).attr('id'));
      }
    });
    
    /**
     * Datepicker Field.
     *
     * @since 1.0
     */
    $('.at-date').each( function() {
      
      var $this  = $(this),
          format = $this.attr('rel');
  
      $this.datepicker( { showButtonPanel: true, dateFormat: format } );
      
    });
  
    /**
     * Timepicker Field.
     *
     * @since 1.0
     */
    $('.at-time').each( function() {
      
      var $this   = $(this),
          format   = $this.attr('rel');
  
      $this.timepicker( { showSecond: true, timeFormat: format } );
      
    });
  
    /**
     * Colorpicker Field.
     *
     * @since 1.0
     */
    /*
    
    
    
    /**
     * Select Color Field.
     *
     * @since 1.0
     */
    $('.at-color-select').click( function(){
      var $this = $(this);
      var id = $this.attr('rel');
      $(this).siblings('.at-color-picker').farbtastic("#" + id).toggle();
      return false;
    });
  
    /**
     * Delete File.
     *
     * @since 1.0
     */
    $('.at-upload').delegate( '.at-delete-file', 'click' , function() {
      
      var $this   = $(this),
        $parent = $this.parent(),
        data = $this.attr('rel');
          
      $.post( ajaxurl, { action: 'at_delete_file', data: data }, function(response) {
        response == '0' ? ( alert( 'File has been successfully deleted.' ), $parent.remove() ) : alert( 'You do NOT have permission to delete this file.' );
      });
      
      return false;
    
    });
  
    /**
     * Reorder Images.
     *
     * @since 1.0
     */
    $('.at-images').each( function() {
      
      var $this = $(this), order, data;
      
      $this.sortable( {
        placeholder: 'ui-state-highlight',
        update: function (){
          order = $this.sortable('serialize');
          data   = order + '|' + $this.siblings('.at-images-data').val();
  
          $.post(ajaxurl, {action: 'at_reorder_images', data: data}, function(response){
            response == '0' ? alert( 'Order saved!' ) : alert( "You don't have permission to reorder images." );
          });
        }
      });
      
    });
    
  }
jQuery(document).ready(function($) {

  /**
   * repater Field
   * @since 1.1
   */
  /*$( ".at-repeater-item" ).live('click', function() {
    var $this  = $(this);
    $this.siblings().toggle();
  });
  jQuery(".at-repater-block").click(function(){
    jQuery(this).find('table').toggle();
  });
  
  */
  //edit
  //$(".at-re-toggle").live('click', function() {
    $('body').on('click', '.at-re-toggle', function(e){
    $(this).prev().toggle('slow');
  });
  
  
  /**
   * Datepicker Field.
   *
   * @since 1.0
   */
  $('.at-date').each( function() {
    
    var $this  = $(this),
        format = $this.attr('rel');

    $this.datepicker( { showButtonPanel: true, dateFormat: format } );
    
  });

  /**
   * Timepicker Field.
   *
   * @since 1.0
   */
  $('.at-time').each( function() {
    
    var $this   = $(this),
        format   = $this.attr('rel');

    $this.timepicker( { showSecond: true, timeFormat: format } );
    
  });

  /**
   * Colorpicker Field.
   *
   * @since 1.0
   * better handler for color picker with repeater fields support
   * which now works both when button is clicked and when field gains focus.
   */
  //$('.at-color').live('focus', function() {
  $('body').on('focus', '.at-color', function(){
    var $this = $(this);
    $(this).siblings('.at-color-picker').farbtastic($this).toggle();
  });

  //$('.at-color').live('focusout', function() {
    $('body').on('focusout', '.at-color', function(){
    var $this = $(this);
    $(this).siblings('.at-color-picker').farbtastic($this).toggle();
  });
  
  /**
   * Add Files.
   *
   * @since 1.0
   */
  $('.at-add-file').click( function() {
    var $first = $(this).parent().find('.file-input:first');
    $first.clone().insertAfter($first).show();
    return false;
  });

  /**
   * Delete File.
   *
   * @since 1.0
   */
  $('.at-upload').delegate( '.at-delete-file', 'click' , function() {
    
    var $this   = $(this),
        $parent = $this.parent(),
        data = $this.attr('rel');
    
    var ind = $(this).index()
    $.post( ajaxurl, { action: 'at_delete_file', data: data, tag_id: get_query_var('tag_ID') }, function(response) {
      response == '0' ? ( alert( 'File has been successfully deleted.' ), $parent.remove() ) : alert( 'You do NOT have permission to delete this file.' );
    });
    
    return false;
  
  });

    
  /**
   * Helper Function
   *
   * Get Query string value by name.
   *
   * @since 1.0
   */
  function get_query_var( name ) {

    var match = RegExp('[?&]' + name + '=([^&#]*)').exec(location.href);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
      
  }

   //clear form after submit
   $( document ).ajaxComplete(function( event, xhr, settings ) {
    try{
      $respo = $.parseXML(xhr.responseText);
    
      //exit on error
      if ($($respo).find('wp_error').length) return;
      
      $($respo).find('response').each(function(i,e){
        if ($(e).attr('action').indexOf("add-tag") > -1){
          var tid = $(e).find('term_id');
          if (tid){
            clear_form($( "form[action='edit-tags.php']" ));
          }
        }
      });
    }catch(err) {}
  });

  function version_compare(a,b){
    var c=a.split('.');
    var d=b.split('.');
    for(var i=0;i<c.length;++i){
      if(d.length==i){
        return"gt";
      }
      if(c[i]==d[i]){
        continue;
      }else if(c[i]>d[i]){
        return"gt";
      }else{
        return"lt";
      }
    }
    if(c.length!=d.length){
      return"lt";
    }
    return"eq";
  }
  function clear_form(form){
    $('input[type="text"]:visible, textarea:visible', form).val('');
    //color field
    $('.at-color', form).attr('style','');
    //image upload
    $('.simplePanelImagePreview img').remove();
    $('simplePanelimageUploadclear').each(function(){
      var $field = $(this);
      //clear urls
      $field.prev().val('');
      //clear ids
      $field.prev().prev().val('');
      simplePanelupload.getInstance().replaceImageUploadClass($field);
    });
    //file upload
    $('.simplePanelfilePreview ul li').remove();
    $('simplePanelfileUploadclear').each(function(){
      var $field = $(this);
      //clear urls
      $field.prev().val('');
      //clear ids
      $field.prev().prev().val('');
      simplePanelupload.getInstance().replaceImageUploadClass($field);
    });
    //repeater
    $(".at-repater-block").remove();
    //select
    $('select',form).val('');
    //checkboxes
    $( "input[type='checkbox']",form ).prop('checked',false);
    //radio
    $( "input[type='radio']",form ).prop('checked',false);
  }
   /** pre bind jquery function **/
   $.fn.preBind = function (type, data, fn) {
    this.each(function () {
        var $this = $(this);

        $this.bind(type, data, fn);
        if (version_compare($.fn.jquery,'1.8') == 'lt'){
          //var currentBindings = $this.data('events')[type];
          //Changed this because of an error in the console - CG
          var currentBindings = $._data(this, "events")[type];
        }else{
          var currentBindings = $._data(this, "events")[type];
        }
        if ($.isArray(currentBindings)) {
            currentBindings.unshift(currentBindings.pop());
        }
    });
    return this;
  };
  /** fix tinymce not saving on add screen*/
  $('#submit').preBind('click', function() {
    //$('input[type="submit"]').preBind('click', function() {
    if(typeof tinymce !== "undefined" && $('input[name=action]').val() == 'add-tag'){
    //if(typeof tinymce !== "undefined"){
      $.each(tinymce.editors,function(i,editor){
        var tx = editor.targetElm;
        $(tx).html(editor.getContent());
        $(tx).triggerSave();
      });
    }
  });
  
  //new image upload field
  function load_images_muploader(){
    jQuery(".mupload_img_holder").each(function(i,v){
      if (jQuery(this).next().next().val() != ''){
        if (!jQuery(this).children().size() > 0){
          jQuery(this).append('<img src="' + jQuery(this).next().next().val() + '" style="height: 150px;width: 150px;" />');
          jQuery(this).next().next().next().val("Delete");
          jQuery(this).next().next().next().removeClass('at-upload_image_button').addClass('at-delete_image_button');
        }
      }
    });
  }
  
  load_images_muploader();
  //delete img button
  //jQuery('.at-delete_image_button').live('click', function(e){
    jQuery('body').on('click', '.at-delete_image_button', function(e){
    var field_id = jQuery(this).attr("rel");
    var at_id = jQuery(this).prev().prev();
    var at_src = jQuery(this).prev();
    var t_button = jQuery(this);
    data = {
        action: 'at_delete_mupload',
        _wpnonce: $('#nonce-delete-mupload_' + field_id).val(),
        post_id: get_query_var('tag_ID'),
        field_id: field_id,
        attachment_id: jQuery(at_id).val()
    };
  
    $.getJSON(ajaxurl, data, function(response) {
      if ('success' == response.status){
        jQuery(t_button).val("Upload Image");
        jQuery(t_button).removeClass('at-delete_image_button').addClass('at-upload_image_button');
        //clear html values
        jQuery(at_id).val('');
        jQuery(at_src).val('');
        jQuery(at_id).prev().html('');
        load_images_muploader();
      }else{
        alert(response.message);
      }
    });
  
    return false;
  });
  

  //upload button
  var formfield1;
  var formfield2;
  //jQuery('.at-upload_image_button').live('click',function(e){
  jQuery('body').on('click', '.at-upload_image_button', function(e){
    formfield1 = jQuery(this).prev();
    formfield2 = jQuery(this).prev().prev();      
    tb_show('', 'media-upload.php?post_id=0&type=image&amp;TB_iframe=true&tax_meta_c=instopo');

    //cleanup the meadi uploader
    tbframe_interval = setInterval(function() {

       //remove url, alignment and size fields- auto set to null, none and full respectively                        
       $('#TB_iframeContent').contents().find('.url').hide();
       $('#TB_iframeContent').contents().find('.align').hide();
       $('#TB_iframeContent').contents().find('.image_alt').hide();
       $('#TB_iframeContent').contents().find('.post_excerpt').hide();
       $('#TB_iframeContent').contents().find('.post_content').hide();
       $('#TB_iframeContent').contents().find('.image-size').hide();
       $('#TB_iframeContent').contents().find('[value="Insert into Post"]').val('Use this image');

    }, 2000);

    //store old send to editor function
    window.restore_send_to_editor = window.send_to_editor;
    //overwrite send to editor function
    window.send_to_editor = function(html) {
      d = jQuery('<div>').html(html);
      imgurl = d.find('img').attr('src');
      img_calsses = d.find('img').attr('class').split(" ");
      att_id = '';
      jQuery.each(img_calsses,function(i,val){
        if (val.indexOf("wp-image") != -1){
          att_id = val.replace('wp-image-', "");
          return true;
        }
      });

      jQuery(formfield2).val(att_id);
      jQuery(formfield1).val(imgurl);
      load_images_muploader();
      tb_remove();
      //restore old send to editor function
      window.send_to_editor = window.restore_send_to_editor;
    }
    return false;
  });

});