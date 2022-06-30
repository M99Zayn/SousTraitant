<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="row col-sm mb-2">
    <a class="btn btn-success  text-white" type="button" onclick="initier()">Initier l'échange</a>

    <!-- hidden inputs to exchanging data between php & js -->
    <input type="text" name="contrat_id" value="{{ $widget['id'] }}"  hidden>
</div>

<script>
    let id = $("input[name=contrat_id]").val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    function initier(){
        swal({
            icon: "info",
            title: "Commentaire",
            // text: "Once deleted, you will not be able to recover this imaginary file!",
            content: {
                element: "input",
                attributes: {
                    placeholder: "Écrire le commentaire ici...",
                    required : "required",
                },
            },
            buttons: ["Annuler", "Envoyer"],
            dangerMode: true,
        })
        .then((value) => {
            if (value) {
                $.ajax({
                    url: '/initier',
                    type: "POST",
                    data:{
                        contrat_id:id,
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
