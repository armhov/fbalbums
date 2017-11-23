jQuery(document).ready(function ($) {

    $('#albums_list').change(function() {
        var val = $("#albums_list option:selected").val();
        var name = $("#albums_list option:selected").text();

        if(val){
            var html = '';
            $.ajax({
                method: "POST",
                url: "albums-actions.php",
                data: { album_id: val, name: name },
                success:function(data){
                        if(data){
                            var photos =  JSON.parse(data);
                        }
                        console.log(photos);

                    photos.forEach(function(photo){
                        html += "<div class='col-md-4 col-sm-3 col-xs-12 fb-images'><img class='img-responsive' src='"+ photo.images[1].source +"' ></div>";
                    });

                    $('#pics').empty().append(html);


                },
                error:function (error) {
                    console.log(error);

                }
            })

        }

    });
})