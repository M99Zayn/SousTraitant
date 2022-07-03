<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="row col-md-8 mb-2">
    <div class="col-md-6">
        <a class="btn btn-success btn-lg btn-block text-white" type="button" onclick="valider()">Valider</a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-danger btn-lg btn-block text-white" type="button" onclick="rejeter()">Rejeter</a>
    </div>

    <!-- hidden inputs to exchanging data between php & js -->
    <input type="text" name="echange_id" value="{{ $widget['id'] }}"  hidden>
</div>

<script>
    let id = $("input[name=echange_id]").val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    function valider(){
        swal({
            icon: "info",
            title: "Commentaire",
            content: {
                element: "input",
                attributes: {
                    placeholder: "Écrire le commentaire ici...",
                    required : "required",
                },
            },
            buttons: ["Annuler", "Valider"],
            dangerMode: true,
        })
        .then((value) => {
            if (value) {
                $.ajax({
                    url: '/e2_valider',
                    type: "POST",
                    data:{
                        echange_id:id,
                        commentaire:value,
                        _token: _token
                    },
                    success: function(response) {
                        if(response) {
                            location.reload();
                        }
                    },
                    error: function(response){
                        swal({
                            icon: "error",
                            text: "Une erreur s'est produite",
                            dangerMode: true,
                        });
                    }
                });
            } else {
                if (value == '') {
                    swal("Veuillez remplir le champ");
                }
            }
        });
    }
    function rejeter(){
        swal({
            icon: "info",
            title: "Commentaire",
            content: {
                element: "input",
                attributes: {
                    placeholder: "Écrire le commentaire ici...",
                    required : "required",
                },
            },
            buttons: ["Annuler", "Rejeter"],
            dangerMode: true,
        })
        .then((value) => {
            if (value) {
                $.ajax({
                    url: '/e2_rejeter',
                    type: "POST",
                    data:{
                        echange_id:id,
                        commentaire:value,
                        _token: _token
                    },
                    success: function(response) {
                        if(response) {
                            location.reload();
                        }
                    },
                    error: function(response){
                        swal({
                            icon: "error",
                            text: "Une erreur s'est produite",
                            dangerMode: true,
                        });
                    }
                });
            } else {
                if (value == '') {
                    swal("Veuillez remplir le champ");
                }
            }
        });
    }
</script>
