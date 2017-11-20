
// --- Confirm window ---
function myModal(id, paramPamPam) {
    $('#myModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){
        $('#'+id).submit();
    });

    $("#myModal .modal-body").text(paramPamPam);
}

// --- Quick search in home ---
$(document).ready(function(){
    $("#mySearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

// --- Filters in table (home) ---
$(document).ready(function(){
    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});

// --- Ajax in add book (find text in input) ---
function checkTip(e){

    clearTips();
    var input = $(e.currentTarget);

    if(input.val()!=''){
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'type': 'post',
            'url': 'search_value',
            'data': {
                'str': input.val(),
                'id': input.attr('id')
            },
            success: function(data){

                var source = $.parseJSON(data);

                var tips = $("<div class='tips'></div>");
                tips.css('position', 'absolute');
                tips.css('background', 'rgba(255,255,255,0.9)');
                tips.css('border', 'solid 1px #ccc');
                tips.css('width', '100%');
                tips.css('cursor', 'pointer');
                tips.css('z-index', '1');

                // console.log(input.val());
                // console.log(data);
                // console.log(source);

                for(var i=0; i<source.length; i++){
                    var tip = $("<div class='tip'>"+source[i]['name']+"</div>");
                    tip.click(function(e){ $(e.currentTarget).parent().parent().find('input').val($(e.currentTarget).text()); });
                    tips.append(tip);
                }

                tips.appendTo((input).parent());
            },
            error: function(x, e){
                console.log(x);
                console.log(e);
            }
        });
    }
}

function clearTips(){
    $('.tips').remove();
}