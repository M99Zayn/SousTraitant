@section("before_scripts")
<div class="modal fade" id="validerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Valider l'échange</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea class="form-control" id="commentaire" placeholder="Entrer un commentaire..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Fichier</label>
                        <input type="file" class="form-control-file" id="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="valider()">Valider</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rejeterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rejeter l'échange</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea class="form-control" id="commentaire" placeholder="Entrer un commentaire..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="rejeter()">Rejeter</button>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="row col-sm mb-2">
    <a class="btn btn-success  text-white mr-1" data-toggle="modal" data-target="#validerModal">Valider l'échange</a>
    <a class="btn btn-danger  text-white" data-toggle="modal" data-target="#rejeterModal">Rejeter l'échange</a>

    <!-- hidden inputs to exchanging data between php & js -->
    <input type="text" id="echange_id" name="echange_id" value="{{ $widget['id'] }}"  hidden>
</div>
<script>
    let _token   = $('meta[name="csrf-token"]').attr('content');
    function valider(){
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append("commentaire", $("#commentaire").val());
        fd.append("echange_id", $("#echange_id").val());

        $.ajax({
            url: '/e2_valider',
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    location.reload();
                }
                else{
                    alert('Une erreur a été produite');
                }
            },
        });
    }
    function rejeter(){
        var fd = new FormData();
        fd.append("commentaire", $("#commentaire").val());
        fd.append("echange_id", $("#echange_id").val());
        $.ajax({
            url: '/e2_rejeter',
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    location.reload();
                }
                else{
                    alert('Une erreur a été produite');
                }
            },
        });
    }
</script>
