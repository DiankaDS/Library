// --- Confirm window ---
function myModal(id, paramPamPam) {
    $('#myModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){
        $('#'+id).submit();
    });

    $("#myModal .modal-body").text(paramPamPam);
}

// --- Ajax in add_book and home (find text in input) ---
function checkTip(e, id){

    clearTips();
    var input = $(e.currentTarget);

    var timer;
    clearTimeout(timer);

    timer=setTimeout(function(){

    if (input.val()!='') {

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'type': 'post',
            'url': 'search_value',
            'data': {
                'str': input.val(),
                'id': id
            },
            success: function(data){
                var source = $.parseJSON(data);

                if (source!='') {
                    var tips = $("<ul class='tips dropdown-menu'></ul>");

                    // console.log(input.val());
                    // console.log(data);
                    // console.log(source);

                    for (var i = 0; i < source.length; i++) {
                        // var tip = $("<div class='tip'>" + source[i]['name'] + "</div>");
                        var tip = $("<li class='tip'><a href='#'>" + source[i]['name'] + "</a></li>");
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

// --- Google search in add_book (find text in input) ---
function googleSearch(e){

    clearTips();
    var input = $(e.currentTarget);

    var timer;
    clearTimeout(timer);

    timer=setTimeout(function(){

        if (input.val()!='') {

            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'type': 'post',
                'url': 'google_search',
                'data': {
                    'str': input.val()
                },
                success: function(data){
                    var source = $.parseJSON(data);
                    $("#myBooks").empty();

                    if (source.length !== 0) {

                        // console.log(input.val());
                        // console.log(data);
                        // console.log(source);

                        for (var i = 0; i < source.length; i++) {
                            var container = $('<div class="col-md-3"></div>');
                            container.appendTo($("#myBooks"));

                            if (source[i]['description'] == null) {
                                source[i]['description'] = ' ';
                            }

                            var thumb = $('<div class="thumbnail" style="width: 250px; height: 300px;" onclick="googleModal(' +
                                '\'' + escape(source[i]['name']) + '\', \'' +
                                source[i]['author'] + '\', \'' +
                                source[i]['genre'] + '\', \'' +
                                source[i]['year'] + '\', \'' +
                                escape(source[i]['description']) + '\', \'' +
                                source[i]['photo'] + '\'' +
                                ')"></div>');
                            thumb.appendTo(container);

                            var a = $('<a href="#" name="' + source[i].name + '">');
                            a.appendTo(thumb);

                            if (source[i].photo != null) {
                                var img = $('<img src="' + source[i].photo + '" style="width: 125px; height: 150px;">');
                            }
                            else {
                                var img = $('<img src="../images/default_book.jpg" style="width: 125px; height: 150px;">');
                            }
                            img.appendTo(a);

                            var caption = $('<div class="caption"></div>');
                            caption.appendTo(thumb);

                            var pa = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><a href="#" name="' + source[i].id + '">' + source[i].name + '</a></div>');
                            pa.appendTo(caption);

                            var p = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">' + source[i].author + ', ' + source[i].year + '</p>');
                            p.appendTo(caption);
                        }
                    }
                    else{
                        $('<p align="center">No result found...</p>').appendTo($("#myBooks"));
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

function googleModal(name, author, genre, year, description, photo) {
    $('#googleModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){

        $('#name').val(unescape(name));
        $('#author').val(author);
        $('#genre').val(genre);
        $('#year').val(year);
        $('#description').val(unescape(description));
        $('#google_photo').val(photo);

        $('#create_book_form').submit();
    });

    // console.log(name);

    var body = $("#googleModal .modal-body");

    body.empty();

    var p = '<img src="' + photo + '" style="width: 125px; height: 150px;"><br><table class=\"table\"><tbody>' +
        '<tr><th>Book name:</th><td>' + unescape(name) + '</td>' +
        '<tr><th>Author:</th><td>' + author + '</td>' +
        '<tr><th>Genre:</th><td>' + genre + '</td>' +
        '<tr><th>Year:</th><td>' + year + '</td>' +
        '<tr><th>Description:</th><td>' + unescape(description) + '</td></tr></tbody></table>' ;

    body.append(p);
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

            if (source.length !== 0) {
                for (var i = 0; i < source.length; i++) {
                    var container = $('<div class="col-md-3"></div>');
                    container.appendTo($("#myBooks"));
                    var thumb = $('<div class="thumbnail" style="width: 250px; height: 300px;"></div>');
                    thumb.appendTo(container);

                    var a = $('<a href="book_' + source[i].id + '" name="' + source[i].id + '">');
                    a.appendTo(thumb);

                    if (source[i].photo != 0) {
                        var img = $('<img src="' + source[i].photo + '" style="width: 125px; height: 150px;">');
                    }
                    else{
                        var img = $('<img src="../images/default_book.jpg" style="width: 125px; height: 150px;">');
                    }
                    img.appendTo(a);

                    var caption = $('<div class="caption"></div>');
                    caption.appendTo(thumb);

                    var pa = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><a href="book_' + source[i].id + '" name="' + source[i].id + '">' + source[i].name + '</a></div>');
                    pa.appendTo(caption);

                    var p = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">' + source[i].author + ', ' + source[i].year + '</p>');
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

// --- Edit review in book_details ---
function editReview(id, text) {
    var form = '<form id="edit_review_form" method="post" action="add_review">' +
        '<input name="_token" type="hidden" value="'+$('meta[name="csrf-token"]').attr('content')+'">' +
        '<input name="edit_review_id" type="hidden" value="'+id+'">' +
        '<textarea rows="4" cols="50" name="review" id="review" placeholder="Enter review here...">'+text+'</textarea>' +
        '<br>' +
        '<button type="submit" class="btn btn-info">Save</button>' +
        '</form>';

    document.getElementById("review_"+id).innerHTML = form;
    $("textarea").focus();
}

// --- Sort tables ---
function sortTable(id, n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(id);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch= true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch= true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        }
        else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

// --- Datepicker ---
$(document).ready(function(){
    var date_input=$('input[id="datepicker"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true
    })
});
