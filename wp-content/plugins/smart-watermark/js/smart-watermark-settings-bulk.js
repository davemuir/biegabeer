var smart_watermark_stat = 0;
var smart_watermark_current_offset = 0;
var smart_watermark_bulk_limit = 10;

jQuery(document).ready(function($) {  
    
  $('#watermark_run_bulk').click(function() {
    smart_watermark_stat = 0;
    smart_watermark_current_offset = 0;
    $('#watermark_bulk_progressbar_stat').html(0+'%');
    $('#watermark_bulk_progressbar').css('width', 1+'%');
    $.post(ajax_object.ajaxurl, {action: 'smart_watermark_stat'}, 
        function(response) {
            smart_watermark_stat = response;
            smart_watermark_bulk_procced();
        }); 
     });
     
     function smart_watermark_bulk_procced() {
        $.post(
        ajax_object.ajaxurl, 
        {action: 'smart_watermark_proceed', offset:smart_watermark_current_offset, limit:smart_watermark_bulk_limit}, 
        function(response) {
            smart_watermark_current_offset += smart_watermark_bulk_limit;
            var progressbar_stat = parseInt((smart_watermark_current_offset/smart_watermark_stat)*100);
            if (progressbar_stat>100) progressbar_stat = 100;
            if (smart_watermark_current_offset<=smart_watermark_stat) {
                smart_watermark_bulk_procced()
            }  
            $('#watermark_bulk_progressbar_stat').html(progressbar_stat+'%');
            $('#watermark_bulk_progressbar').css('width', progressbar_stat+'%');            
        }); 
     }         
    
}); 

