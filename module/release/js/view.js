function showLink(releaseID, type, param)
{
    var method = type == 'story' ? 'linkStory' : 'linkBug';
    if(typeof(param) == 'undefined') param = '&browseType=' + type + '&param=0';
    if(type == 'leftBug') param += '&type=leftBug';
    loadURL(createLink('release', method, 'releaseID=' + releaseID + param), type);

    $('.actions').find("a[href*='" + type + "']").addClass('hidden');
}

/**
 * Load URL.
 *
 * @param  string $url
 * @param  string$type
 * @access public
 * @return void
 */
function loadURL(url, type)
{
    $.get(url, function(data)
    {
        var $pane = $(type == 'story' ? '#stories' : (type == 'leftBug' ? '#leftBugs' : '#bugs'));
        $pane.find('.main-table').hide();
        var $linkBox = $pane.find('.linkBox');
        $linkBox.html(data).removeClass('hidden');
        $linkBox.find('[data-ride="table"]').table();
        $linkBox.find('[data-ride="pager"]').pager();
        $linkBox.find('[data-ride="pager"] li a.pager-item').click(function()
        {
            loadURL($(this).attr('href'), type);
            return false;
        });
        $linkBox.find('[data-ride="pager"] .pager-size-menu a[data-size]').off('click');
        $linkBox.find('[data-ride="pager"] .pager-size-menu a[data-size]').click(function()
        {
            line = $linkBox.find('[data-ride="pager"]').attr('data-link-creator');
            line = line.replace('{recPerPage}', $(this).attr('data-size')).replace('{page}', $linkBox.find('[data-ride="pager"]').attr('data-page'));
            $.cookie($linkBox.find('[data-ride="pager"]').attr('data-page-cookie'), $(this).attr('data-size'), {expires:config.cookieLife, path:config.webRoot});
            loadURL(line, type);
            return false;
        });
        $.toggleQueryBox(true, $linkBox.find('#queryBox'));
    });
}

$(function()
{
    if(link == 'true') showLink(releaseID, type, param);
    var infoShowed = false;
    $('.nav.nav-tabs a[data-toggle="tab"]').on('shown.zui.tab', function(e)
    {
        var href = $(e.target).attr('href');
        var tabPane = $(href + '.tab-pane');
        if(tabPane.size() == 0) return;
        var formID = tabPane.find('.linkBox').find('form:last');
        if(formID.size() == 0) formID = tabPane.find('form:last');

        if(href == '#releaseInfo' && !infoShowed)
        {
            var $tr = $('#releaseInfo .detail-content .table-data tbody tr:first');
            width   = $tr.width() - $tr.find('th').width();
            $('#releaseInfo img').each(function()
            {
                if($(this).parent().prop('tagName').toLowerCase() == 'a') $(this).unwrap();
                setImageSize($(this), width, 0);
            });

            infoShowed = true;
        }
    });

    $('.table-story').table(
    {
        statisticCreator: function(table)
        {
            var $checkedRows = table.getTable().find(table.isDataTable ? '.datatable-row-left.checked' : 'tbody>tr.checked');
            var $originTable = table.isDataTable ? table.$.find('.datatable-origin') : null;
            var checkedTotal = $checkedRows.length;
            if(!checkedTotal) return;

            var checkedEstimate = 0;
            var checkedCase     = 0;
            var rateCount       = checkedTotal;
            $checkedRows.each(function()
            {
                var $row = $(this);
                if($originTable)
                {
                    $row = $originTable.find('tbody>tr[data-id="' + $row.data('id') + '"]');
                }
                var data = $row.data();
                checkedEstimate += data.estimate;

                if(data.cases > 0)
                {
                    checkedCase += 1;
                }
                else if(data.children != undefined && data.children > 0)
                {
                    rateCount -= 1;
                }
            });

            var rate = '0%';
            if(rateCount) rate = Math.round(checkedCase / rateCount * 100) + '%';

            if(checkedTotal == 0) return storySummary;
            return checkedSummary.replace('%total%', checkedTotal)
                  .replace('%estimate%', checkedEstimate.toFixed(1))
                  .replace('%rate%', rate);
        }
    });
})
