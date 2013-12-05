jQuery(document).ready(function($) {  
    
    
    $('#upload_watermark').click(function() {  
        tb_show('Upload a watermark', 'media-upload.php?referer=smart_watermark_referer&type=image&TB_iframe=true&post_id=0', false);  
        return false;  
    });  
    
    window.send_to_editor = function(html) {  
    var image_url = $('img',html).attr('src');  
    $('#watermark').val(image_url);  
    $('#watermark_preview img').attr('src',image_url);  
    tb_remove();  
}  
    
}); 

