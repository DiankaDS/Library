function newCheckTip(e, id){

    var input = $(e.currentTarget);

    var array = [];
    if(id=="genres") {array = genres;}
    else if(id=="tags") {array = tags;}
    else if(id=="years") {array = years;}

    var body = $('#' + id + '_list_unchecked');

    var timer;
    clearTimeout(timer);

    timer=setTimeout(function() {

        var search = new RegExp(input.val().toLowerCase());
        var source = $.map(array, function (value) {

            return value.name.toLowerCase().match(search) ? value : null;
        });

        body.empty();
        // console.log(source);

        if (source.length!=0) {

            var checked = [];
            $("#searchbox_"+ id +" input:checked").each(function(){
                checked.unshift($(this).val());
            });

            var max = 0;
            for (var i = 0; i < source.length; i++) {
                if (max >= 5) {
                    break;
                }
                if (checked.indexOf(String(source[i].id)) == -1) {
                    // console.log(source[i].id);
                    var tip = $('<a href="#" class="list-group-item checkbox"><label><input type="checkbox" value="' + source[i].id + '" onclick="clickCheckbox(event, \'' + id + '\');">' + source[i].name + '</label></a>');
                    body.append(tip);
                    max++;
                }
            }
        }
        else {
            var tip = $('<a href="#" class="list-group-item checkbox">No results</a>');
            body.append(tip);
        }
    }, 1000);
}
//======================================================================================================================
// // Show years
// $(document).ready(function(){
//     var list = $("#years_list_unchecked a");
//     var numToShow = 5;
//     var button = $("#nextYears");
//     var prev = $("#prevYears");
//     var numInList = list.length;
//     list.hide();
//     if (numInList > numToShow) {
//         button.show();
//     }
//     list.slice(0, numToShow).show();
//
//     button.click(function(){
//         list = $("#years_list_unchecked a");
//         numInList = list.length;
//         var showing = list.filter(':visible').length;
//         if(showing==0) list.slice(0,5).fadeIn();
//         else list.slice(showing - 1, showing + numToShow).fadeIn();
//         var nowShowing = list.filter(':visible').length;
//         if (nowShowing >= numInList) {
//             button.hide();
//         }
//         prev.show();
//     });
//
//     prev.click(function(){
//         list = $("#years_list_unchecked a");
//         numInList = list.length;
//         var showing = list.filter(':visible').length;
//         if( showing >= 5) {
//             if (showing < numToShow) showing = numToShow;
//             list.slice(showing - numToShow, showing, 0).fadeOut();
//             if (showing - numToShow < 5) prev.hide();
//             button.show();
//         }
//         else {
//             prev.hide();
//         }
//     });
// });
//======================================================================================================================
// Parse url
window.onload = function() {
    // if (window.location.pathname == "/home_search"
    if (window.location.pathname == "/"
        && window.location.search
        && window.location.search.indexOf("?page") == -1) {
        // var query = window.location.search;
        // console.log(query);

        function getParameterByName(variable)
        {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            var result = [];
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    result.push(pair[1]);
                }
            }
            if (result != []) {
                return (result);
            }
            else {
                return (false);
            }
        }

        var input = getParameterByName('name');
        var checked_genres = getParameterByName('genre[]');
        var checked_tags = getParameterByName('tag[]');
        var checked_years = getParameterByName('year[]');
        var checked_rating = getParameterByName('rating');
        var page = getParameterByName('page');

        // console.log(input);
        // console.log(checked_genres);
        // console.log(checked_tags);
        // console.log(checked_years);
        // console.log(checked_rating);
        // console.log(page);

        if (input.length != 0) {
            for (var i = 0; i < input.length; i++) {
                $('#mySearch').val(input[i]);
            }
        }

        if (checked_rating.length != 0) {
            for (var i = 0; i < checked_rating.length; i++) {
                // console.log(arr[i]);
                $('#ratings_' + checked_rating[i]).attr("checked", "checked");
            }
        }

        function checkBoxes(arr, id) {
            if (arr.length != 0) {
                // console.log(id);
                for (var i = 0; i < arr.length; i++) {
                    // console.log(arr[i]);
                    // console.log( $(id + arr[i]).length );
                    if ($('#' + id + '_' + arr[i]).length != 0) {
                        $('#' + id + '_' + arr[i]).attr("checked", "checked");
                        $('#' + id + '_' + arr[i]).parent().parent().appendTo('#' + id + '_' + "list_checked");
                    }
                    else{
                        var list = [];

                        if(id=="genres") {list = genres;}
                        else if(id=="tags") {list = tags;}
                        else if(id=="years") {list = years;}

                        for (var j = 0; j < list.length; j++) {
                            if(list[j]['id'] == arr[i]) {
                                var name = list[j]['name'];
                                break;
                            }
                        }
                        if (name) {
                            var tip = $('<a href="#" class="list-group-item checkbox"><label><input type="checkbox" checked value="' + arr[i] + '" onclick="clickCheckbox(event, \'' + id + '\');">' + name + '</label></a>');
                            $('#' + id + '_' + 'list_checked').append(tip);
                        }
                    }

                }
            }
        }

        checkBoxes(checked_genres, 'genres');
        checkBoxes(checked_tags, 'tags');
        checkBoxes(checked_years, 'years');

        if (page.length != 0) {
            var url = '/home_search_books?page=' + page[0];

            newSearchBook(event, url);
        }
        else {
            newSearchBook(event);
        }
    }
};
//======================================================================================================================
function clickCheckbox(e, id) {
    if ($(e.currentTarget).prop('checked')) {
        $('#' + id + '_list_checked').append($(e.currentTarget).parent().parent());
    }
    else {
        $('#' + id + '_list_unchecked').append($(e.currentTarget).parent().parent());
    }
    newSearchBook(event);
}
//======================================================================================================================
function newSearchBook(e, page){

    var input = $('#mySearch').val();
    var checked_genres = [];
    var checked_tags = [];
    var checked_years = [];
    var checked_rating = $("#searchbox_ratings input:checked").val();

    $("#searchbox_genres input:checked").each(function(){
        checked_genres.unshift($(this).val());
    });

    $("#searchbox_tags input:checked").each(function(){
        checked_tags.unshift($(this).val());
    });

    $("#searchbox_years input:checked").each(function(){
        checked_years.unshift($(this).val());
    });

    var query = '?';

    if (input) {
        query += 'name=' + input;
    }

    if (checked_rating) {
        if (query != '?') {
            query += '&';
        }
        query += 'rating=' + checked_rating;
    }

    if ($("#searchbox_genres input:checked")) {
        $("#searchbox_genres input:checked").each(function(){
            if (query != '?') {
                query += '&';
            }
            query += 'genre[]=' + $(this).val();
        });
    }

    if ($("#searchbox_tags input:checked")) {
        $("#searchbox_tags input:checked").each(function(){
            if (query != '?') {
                query += '&';
            }
            query += 'tag[]=' + $(this).val();
        });
    }

    if ($("#searchbox_years input:checked")) {
        $("#searchbox_years input:checked").each(function(){
            if (query != '?') {
                query += '&';
            }
            query += 'year[]=' + $(this).val();
        });
    }

    var url = 'home_search_books';

    if(page) {
        if (query != '?') {
            query += '&';
        }
        query += page.slice(page.indexOf('page='));

        url =  page;
    }

    window.history.pushState(null, null, query);
    // console.log(window.location.search);

    // console.log( checked_genres );
    // console.log( checked_tags );
    // console.log( checked_years );
    // console.log( input );
    // console.log( checked_rating );

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'type': 'post',
        'url': url,
        'data': {
            'input': input,
            'genres': checked_genres,
            'tags': checked_tags,
            'years': checked_years,
            'rating': checked_rating
        },
        success: function (data) {
            // console.log(data);

            // var source = $.parseJSON(data);
            var source = $.parseJSON(data).data;

            $("#myBooks").empty();

            // $('#pagination').hide();
            $('#pagination').empty();

            // if (source.length != 0) {
            if ($.parseJSON(data).length != 0 && source.length != 0) {

                // console.log($.parseJSON(data));
                // console.log(source);

                for (var i = 0; i < source.length; i++) {
                    var container = $('<div class="col-md-4 col-sm-4 col-xs-6"></div>');
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
                        var rating = $('<p align="center">Rating: <b>' + source[i].rating + '</b></p>');
                    }
                    else {
                        var rating = $('<p align="center">Rating: <b>0</b></p>');
                    }
                    rating.appendTo(caption);
                }

                // $('<button onclick="newSearchBook(event, \''+ $.parseJSON(data)['prev_page_url'] +'\')">Prev</button>').appendTo($("#pagination"));
                // $('<button onclick="newSearchBook(event, \''+ $.parseJSON(data)['next_page_url'] +'\')">Next</button>').appendTo($("#pagination"));
                // $('<p>Page ' + $.parseJSON(data)['current_page'] + '/'+ $.parseJSON(data)['last_page'] + '</p>').appendTo($("#pagination"));

                var ul_pag = $('<ul class="pagination"></ul>');
                ul_pag.appendTo($("#pagination"));

                if ($.parseJSON(data)['prev_page_url']) {
                    $('<li class="page-item"><a class="page-link" href="#" onclick="newSearchBook(event, \'' + $.parseJSON(data)['prev_page_url'] + '\')"><span aria-hidden="true">&laquo;</span></a></li>').appendTo(ul_pag);
                }
                else {
                    $('<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>').appendTo(ul_pag);
                }

                for (var pag = $.parseJSON(data)['current_page'] - 5; pag <=  $.parseJSON(data)['current_page'] + 5; pag++) {
                    if (pag > 0 && pag <= $.parseJSON(data)['last_page']) {
                        if (pag == $.parseJSON(data)['current_page']) {
                            $('<li class="page-item active"><a class="page-link" href="#" onclick="newSearchBook(event, \'/home_search_books?page=' + pag + '\')">' + pag + '</a></li>').appendTo(ul_pag);
                        }
                        else {
                            $('<li class="page-item"><a class="page-link" href="#" onclick="newSearchBook(event, \'/home_search_books?page=' + pag + '\')">' + pag + '</a></li>').appendTo(ul_pag);
                        }
                    }
                }

                if ($.parseJSON(data)['next_page_url']) {
                    $('<li class="page-item"><a class="page-link" href="#" onclick="newSearchBook(event, \'' + $.parseJSON(data)['next_page_url'] + '\')"><span aria-hidden="true">&raquo;</span></a></li>').appendTo(ul_pag);
                }
                else {
                    $('<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>').appendTo(ul_pag);
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

//=============================================================================================================================================
//=============================================================================================================================================

// --- Confirm window ---
function myModal(id, textBody, textTitle) {
    textTitle = "Please, confirm action!";

    $('#myModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){
        $('#'+id).submit();
    });

    $("#myModal .modal-title").text(textTitle);
    $("#myModal .modal-body").text(textBody);
}
//======================================================================================================================
function addTagModal(id, all_tags) {

    $('#myModal').modal('show');
    $('#YesButton').off('click');
    $('#YesButton').on('click', function(){

        var checked = [];
        $("input:checkbox:checked").each(function(){
            checked.unshift($(this).val());
        });

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'type': 'post',
            'url': 'add_tags',
            'data': {
                'checkbox': checked,
                'book_id': id
            },
            success: function (data) {

                var source = $.parseJSON(data);
                // console.log(source.length);

                $('#myModal').modal('hide');

                var tags = '';
                for (var i = 0; i < source.length; i++) {
                    tags += '<span class="label label-primary">' + source[i].name + '</span> ';
                }
                $('#tag_' + id).html(tags)
            },
            error: function (x, e) {
                console.log(x);
                console.log(e);
            }
        });
    });

    $("#myModal .modal-title").text("Select tags:");

    all_tags = $.parseJSON(all_tags);

    var arr = $('#tag_' + id).text().split(' ');
    for (var j = 0; j < arr.length; j++) {
        arr[j] = $.trim(arr[j]);
    }

    var body = $("#myModal .modal-body");
    body.empty();

    for (var i = 0; i < all_tags.length; i++) {
        if (arr.indexOf(all_tags[i]['name']) != -1) {
            var p = '<label><input type="checkbox" name="' + all_tags[i]['name'] + '" value="' + all_tags[i]['id'] + '" checked>' + all_tags[i]['name'] + '</label><br>';
        }
        else {
            var p = '<label><input type="checkbox" name="' + all_tags[i]['name'] + '" value="' + all_tags[i]['id'] + '">' + all_tags[i]['name'] + '</label><br>';
        }
        body.append(p);
    }
}
//======================================================================================================================
// --- Ajax in home (find tags) ---
// setTimeout(function() {
//
//     $(".bootstrap-tagsinput input").keyup(function () {
//
//         // console.log($(".bootstrap-tagsinput input").val());
//
//         timer=setTimeout(function() {
//             clearTips();
//             var timer;
//             clearTimeout(timer);
//
//             var input = $(".bootstrap-tagsinput input");
//
//             if (input.val() != '') {
//
//                 $.ajax({
//                     'headers': {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                     'type': 'post',
//                     'url': 'search_value',
//                     'data': {
//                         'str': input.val(),
//                         'id': 'tags'
//                     },
//                     success: function (data) {
//                         var source = $.parseJSON(data);
//
//                         if (source != '') {
//                             // var tips = $("<ul class='tips dropdown-menu'></ul>");
//                             var tips = $("<div class='tips'></div>");
//                             tips.css('position', 'absolute');
//                             tips.css('background', 'rgba(255,255,255,0.9)');
//                             tips.css('border', 'solid 1px #ccc');
//                             tips.css('width', '100%');
//                             tips.css('cursor', 'pointer');
//                             tips.css('z-index', '1');
//
//                             // console.log(input.val());
//                             // console.log(data);
//                             // console.log(source);
//
//                             for (var i = 0; i < source.length; i++) {
//                                 // var tip = $("<div class='tip'>" + source[i]['name'] + "</div>");
//                                 // var tip = $("<li class='tip'><a href='#'>" + source[i]['name'] + "</a></li>");
//                                 var tip = $("<div class='tip'>" + source[i]['name'] + "</div>");
//                                 tip.click(function (e) {
//                                     var x = $(e.currentTarget).parent().parent().find('span[data-role="remove"]');
//                                     x.eq(x.length-1).trigger('click');
//
//                                     $(e.currentTarget).parent().parent().find('input').val($(e.currentTarget).text());
//                                     $(e.currentTarget).parent().parent().find('input').blur();
//
//                                     clearTips();
//                                 });
//                                 tips.append(tip);
//                             }
//
//                             // var a = $("<a class='dropdown'></a>");
//                             // $(".bootstrap-tagsinput input").appendTo(a);
//                             // $(".bootstrap-tagsinput input").attr("data-toggle", "dropdown");
//
//                             // tips.appendTo($(".bootstrap-tagsinput input"));
//                             tips.appendTo(input.parent());
//                         }
//                     },
//                     error: function (x, e) {
//                         console.log(x);
//                         console.log(e);
//                     }
//                 });
//             }
//         }, 1000);
//
//     });
// }, 1000);
//======================================================================================================================
// --- Ajax in add_book and home (find text in input) ---
function checkTip(e, id){

    clearTips();
    var input = $(e.currentTarget);

    var timer;
    clearTimeout(timer);

    // console.log(input.val());
//     console.log( $(".bootstrap-tagsinput input").val());
// debugger;

    timer=setTimeout(function() {

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
//======================================================================================================================
function clearTips(){
    $('.tips').remove();
}
//======================================================================================================================
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
                                source[i]['description'] = '-';
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
//======================================================================================================================
function googleModal(name, author, genre, year, description, photo) {
    $('#myModal').modal('show');
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

    $('#WishButton').on('click', function(){

        $('#name').val(unescape(name));
        $('#author').val(author);
        $('#genre').val(genre);
        $('#year').val(year);
        $('#description').val(unescape(description));
        $('#google_photo').val(photo);
        $('#wish').val(1);

        $('#create_book_form').submit();
    });

    $("#myModal .modal-title").text("Are you sure to add this book?");

    if($("#myModal .modal-footer #WishButton").val() != "1") {
        $("#myModal .modal-footer").prepend($('<button type="button" class="btn btn-info" id="WishButton" value="1">Wish book</button>'));
    }

    var body = $("#myModal .modal-body");

    body.empty();

    var p = '<img src="' + photo + '" style="width: 125px; height: 150px;"><br><table class=\"table\"><tbody>' +
        '<tr><th>Book name:</th><td>' + unescape(name) + '</td>' +
        '<tr><th>Author:</th><td>' + author + '</td>' +
        '<tr><th>Genre:</th><td>' + genre + '</td>' +
        '<tr><th>Year:</th><td>' + year + '</td>' +
        '<tr><th>Description:</th><td>' + unescape(description) + '</td></tr></tbody></table>' ;

    body.append(p);
}
//======================================================================================================================
// --- Ajax in Home (search books) ---
// function searchBook(){
//     var input_book = $("#mySearchBook");
//     var input_author = $("#mySearchAuthor");
//     var input_year = $("#mySearchYear");
//     var input_genre = $("#mySearchGenre");
//     var input_tags = $("#mySearchTags");
//
//
//     // console.log(input_tags.val());
//
//     $.ajax({
//         'headers': {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         'type': 'post',
//         'url': 'search_books',
//         'data': {
//             'str_book': input_book.val(),
//             'str_author': input_author.val(),
//             'str_year': input_year.val(),
//             'str_genre': input_genre.val(),
//             'arr_tags': input_tags.val()
//         },
//         success: function (data) {
//             var source = $.parseJSON(data);
//             $("#myBooks").empty();
//
//             // console.log(input_tags.val());
//             // console.log(data);
//             // console.log(source);
//
//             if (source.length !== 0) {
//                 for (var i = 0; i < source.length; i++) {
//                     var container = $('<div class="col-md-3"></div>');
//                     container.appendTo($("#myBooks"));
//                     var thumb = $('<div class="thumbnail" style="width: 250px; height: 300px;"></div>');
//                     thumb.appendTo(container);
//
//                     var a = $('<a href="book_' + source[i].id + '" name="' + source[i].id + '">');
//                     a.appendTo(thumb);
//
//                     if (source[i].photo != 0) {
//                         var img = $('<img src="' + source[i].photo + '" style="width: 125px; height: 150px;">');
//                     }
//                     else{
//                         var img = $('<img src="../images/default_book.jpg" style="width: 125px; height: 150px;">');
//                     }
//                     img.appendTo(a);
//
//                     var caption = $('<div class="caption"></div>');
//                     caption.appendTo(thumb);
//
//                     var pa = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><a href="book_' + source[i].id + '" name="' + source[i].id + '">' + source[i].name + '</a></div>');
//                     pa.appendTo(caption);
//
//                     var p = $('<p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">' + source[i].author + ', ' + source[i].year + '</p>');
//                     p.appendTo(caption);
//
//                     if (source[i].rating) {
//                         var rating = $('<p align="center">Rating: <b>' + source[i].rating + '</b></p>');
//                     }
//                     else {
//                         var rating = $('<p align="center">Rating: <b>0</b></p>');
//                     }
//                     rating.appendTo(caption);
//                 }
//             }
//             else{
//                 $('<p align="center">No result found...</p>').appendTo($("#myBooks"));
//             }
//         },
//         error: function (x, e) {
//             console.log(x);
//             console.log(e);
//         }
//     });
// }
//======================================================================================================================
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
//======================================================================================================================
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
//======================================================================================================================
// --- Add book to wished ---
function wishBook(){
    $('#wish').val(1);
    $('#create_book_form').submit();
}
