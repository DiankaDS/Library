// --- Confirm window ---
function myModal(id, paramPamPam) {
    $('#myModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){
        $('#'+id).submit();
    });

    $("#myModal .modal-body").text(paramPamPam);
}

// --- Ajax in add book (find text in input) ---
function checkTip(e){

    clearTips();
    var input = $(e.currentTarget);

    var timer;
    clearTimeout(timer);

    timer=setTimeout(function(){

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

                if(source!='') {

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

                    for (var i = 0; i < source.length; i++) {
                        var tip = $("<div class='tip'>" + source[i]['name'] + "</div>");
                        tip.click(function (e) {
                            $(e.currentTarget).parent().parent().find('input').val($(e.currentTarget).text());
                        });
                        tips.append(tip);
                    }
                    tips.appendTo((input).parent());
                }
            },
            error: function(x, e){
                console.log(x);
                console.log(e);
            }
        });
    }
    }, 1000);
}

function clearTips(){
    $('.tips').remove();
}

// --- Ajax in Home (search books) ---
function searchBook(){
    var input_book = $("#mySearchBook");
    var input_author = $("#mySearchAuthor");
    var input_year = $("#mySearchYear");
    var input_genre = $("#mySearchGenre");

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'type': 'post',
        'url': 'search_books',
        'data': {
            'str_book': input_book.val(),
            'str_author': input_author.val(),
            'str_year': input_year.val(),
            'str_genre': input_genre.val()
        },
        success: function (data) {
            var source = $.parseJSON(data);
            $("#myBooks").empty();
            // console.log(data);
            // console.log(source);

            if(source.length !== 0) {
                for (var i = 0; i < source.length; i++) {
                    var container = $('<div class="col-md-3"></div>');
                    container.appendTo($("#myBooks"));
                    var thumb = $('<div class="thumbnail"></div>');
                    thumb.appendTo(container);

                    var a = $('<a href="book_' + source[i].id + '" name="' + source[i].id + '">');
                    a.appendTo(thumb);
                    var img = $('<img src="../images/books/' + source[i].photo + '" style="width: 125px; height: 150px;">');
                    img.appendTo(a);

                    var caption = $('<div class="caption"></div>');
                    caption.appendTo(thumb);

                    var pa = $('<p align="center"><a href="book_' + source[i].id + '" name="' + source[i].id + '">' + source[i].name + '</a></div>');
                    pa.appendTo(caption);

                    var p = $('<p align="center">' + source[i].author + ', ' + source[i].year + '</p>');
                    p.appendTo(caption);

                    if (source[i].rating) {
                        var rating = $('<p align="center">Rating: ' + source[i].rating + '</p>');
                    }
                    else {
                        var rating = $('<p align="center">Rating: 0</p>');
                    }
                    rating.appendTo(caption);
                }
            }
            else{
                $('<p align="center">No result found...</p>').appendTo($("#myBooks"));
            }
        },
        error: function (x, e) {
            console.log(x);
            console.log(e);
        }
    });
}