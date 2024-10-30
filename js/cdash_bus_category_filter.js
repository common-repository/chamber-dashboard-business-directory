jQuery(document).ready(function($){
    jQuery("#cdash_select_bus_category").change(function() {
        var category_value = $(this).val();
        //var base_url = window.location.href.split('?')[0];
        var base_url = $("#cdash_bus_list_page").text();
        //alert(base_url);
        var category_url = base_url + '/?bus_category=' + category_value;
        window.location.href = category_url;
    });
});
