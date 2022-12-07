$('#submit').click(function()
{
    var dateFormat    = new RegExp(/^\d{4}\-\d{2}\-\d{2}$/);
    var name          = $('#name').val();
    var date          = $('#date').val();
    var build         = $('#build').val();
    var notEmptyBuild = false;

    $.each(build, function(index, value)
    {
        if(typeof(notEmptyBuilds[value]) != 'undefined')
        {
            notEmptyBuild = true;
            return false;
        }
    })

    if(name && build && notEmptyBuild && dateFormat.test(date))
    {
        var result = confirm(confirmLink) ? true : false;
        $('#sync').val(result);
    }
});

/**
 * Ajax load unlinked builds with project and product.
 *
 * @access public
 * @return void
 */
function loadBuilds()
{
    var productID = $('#product').val();
    var branch    = $('#branch').length == 0 ? 0 : $('#branch').val();
    $('#buildBox').load(createLink('projectrelease', 'ajaxLoadBuilds', "projectID=" + projectID + "&productID=" + productID + "&branch=" + branch), function()
    {
        $('#build').attr('data-placeholder', multipleSelect).chosen();
        $.each($('#build').attr('data-notemptybuilds').split(','), function(index, value)
        {
            notEmptyBuilds[value] = value;
        });
    });
}

/**
 * Flush the branch when switching products.
 *
 * @param  int    $productID
 * @access public
 * @return void
 */
function loadBranches(productID)
{
    $('#branch').remove();
    $('#branch_chosen').remove();
    $.get(createLink('branch', 'ajaxGetBranches', "productID=" + productID + '&oldBranch=0&params=active&projectID=' + projectID), function(data)
    {
        var $product = $('#product');
        var $inputGroup = $product.closest('.input-group');
        $inputGroup.find('.input-group-addon').toggleClass('hidden', !data);
        if(data)
        {
            $inputGroup.append(data);
            $inputGroup.find('#branch').attr('onchange', 'loadBuilds()');
            $('#branch').css('width', '120px').chosen();
        }
        loadBuilds();
        $inputGroup.fixInputGroup();
    })
}
