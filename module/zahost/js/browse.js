$('#hostList tr[data-status="wait"]').hover(function(){
  $(this).find('.init').tooltip('toggle');
},function(){
  $(this).find('.init').tooltip('hide');
});

if(showFeature)
{
    /* Show features dialog. */
    new $.zui.ModalTrigger({url: $.createLink('zahost', 'introduction'), type: 'iframe', width: 900, className: 'showFeatures', showHeader: false, backdrop: 'static'}).show();
}
