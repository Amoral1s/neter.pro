jQuery(document).ready(function ($) {

 
  
//Genre Ajax Filtering
jQuery(function($)
{ 
    $('#genre-filter li:first-child ').find('input').prop('checked', true);
    $('#genre-filter li:first-child ').find('input').trigger("change");
    $('#genre-filter li:first-child').addClass('selected');
    //Load posts on document ready
    genre_get_posts();
 
    //If list item is clicked, trigger input change and add css class
    $('#genre-filter li').on('click', function(){
        $('#genre-filter li input').prop('checked', false);
        $('#genre-filter li').removeClass('selected');
        var input = $(this).find('input');
        
        input.prop('checked', true);
        $(this).addClass('selected');
        
        input.trigger("change");
    });
 
    //If input is changed, load posts
    $('#genre-filter input').on('change', function(){
        genre_get_posts(); //Load Posts
    });
    
    //Find Selected Genres
    function getSelectedGenres()
    {
        var genres = []; //Setup empty array
 
        $("#genre-filter li input:checked").each(function() {
            var val = $(this).val();
            genres.push(val); //Push value onto array
        });     
 
        return genres; //Return all of the selected genres in an array
    }
 
 
    //If pagination is clicked, load correct posts
    $('.genre-filter-navigation a').on('click', function(e){
        e.preventDefault();
 
        var url = $(this).attr('href'); //Grab the URL destination as a string
        var paged = url.split('&paged='); //Split the string at the occurance of &paged=
 
        genre_get_posts(paged[1]); //Load Posts (feed in paged value)
    });
 
    //Main ajax function
    function genre_get_posts(paged)
    {
        var paged_value = paged; //Store the paged value if it's being sent through when the function is called
        var ajax_url = ajax_genre_params.ajax_url; //Get ajax url (added through wp_localize_script)
 
        $.ajax({
            type: 'GET',
            url: ajax_url,
            data: {
                action: 'genre_filter',
                genres: getSelectedGenres, //Get array of values from previous function
                paged: paged_value //If paged value is being sent through with function call, store here
            },
            beforeSend: function ()
            {
                //You could show a loader here
            },
            success: function(data)
            {
                //Hide loader here
                $('#genre-results').html(data);
            },
            error: function()
            {
                                //If an ajax error has occured, do something here...
                $("#genre-results").html('<p>Нету кейсов</p>');
            }
        });
    }
 
});

}); //end
