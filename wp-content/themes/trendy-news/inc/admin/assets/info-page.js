/**
 * Theme Info
 * 
 * @package Trendy News
 * @since 1.0.0
 */

/**
 * Plugin install and activate
 * 
 */
jQuery(document).ready(function($) {
    var ajaxUrl = trendyNewsThemeInfoObject.ajaxUrl, _wpnonce = trendyNewsThemeInfoObject._wpnonce
    /**
     * On click
     * 
     */
    $(document).on( "click", ".trendy-news-importer-action-trigger", function() {
        var _this = $(this), param;
        plugin_action = _this.data( "action" );
        plugin_process_message = _this.data( "process" );
        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                "action": "trendy_news_importer_plugin_action",
                "_wpnonce": _wpnonce,
                "plugin_action": plugin_action
            },
            beforeSend: function () {
                if ( plugin_process_message ) {
                    _this.hide().html('').fadeIn().html(plugin_process_message);
                }
            },
            success: function(res) {
                var info = JSON.parse(res);
                if( info.message ) {
                    _this.hide().html('').fadeIn().html(info.message);   
                }
            },
            complete: function() {
                location.reload();
            }
        })
    })
})