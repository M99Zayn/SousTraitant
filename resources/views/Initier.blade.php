@section('before_scripts')
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Initier l'échange</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="commentaire">Commentaire</label>
                            <textarea class="form-control" id="commentaire" placeholder="Entrer un commentaire..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Fichier</label>
                            <input type="file" class="form-control-file" id="file" required>
                        </div>
                        <!-- hidden inputs to exchanging data between php & js -->
                        <input type="text" id="contrat_id" name="contrat_id" value="{{ $widget['contrat_id'] }}" hidden>
                        <input type="text" id="echange_id" name="echange_id" value="{{ $widget['echange_id'] }}" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="initier()">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row col-sm mb-2">
    <a class="btn btn-success  text-white" data-toggle="modal" data-target="#formModal">Initier l'échange</a>
</div>

<script>
    let _token = $('meta[name="csrf-token"]').attr('content');

    function initier() {
        const form = document.getElementById("myForm");
        if (!form.checkValidity()) {
            event.preventDefault();
            alert("Fichier requis");
            return;
        }
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append("commentaire", $("#commentaire").val());
        fd.append("contrat_id", $("#contrat_id").val());
        fd.append("echange_id", $("#echange_id").val());

        $.ajax({
            url: '/initier',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    location.reload();
                } else {
                    alert('Une erreur a été produite');
                }
            },
        });
    }
</script>
