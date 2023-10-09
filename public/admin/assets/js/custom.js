$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

/**
 * Limpa o modal
 * */
$('.btnModal').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#subtitulo").val("");
    tinymce.activeEditor.setContent("");
    $('#noticiaForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
});

/***
 *
 * */
$(".resize-image-gallery").on('click',function(e){
    e.preventDefault();
    const image = e.target;
    const imageHtml = `<img src="${image.src}" alt="${image.alt}" width="400">`;
    tinymce.get('tinymce_editor').execCommand('mceInsertContent',false,imageHtml);
});

/****
 * Joga o conteudo no modal de visualização
 * */
$('.ler-mais').on('click', function(e) {
    e.preventDefault();
    let conteudo = $(this).data('conteudo');
    $('#modal-conteudo').html(conteudo);
});

/***
 * Salva a notícia
 * */
$('#noticiaForm').submit(function(e){
    e.preventDefault();

    if($("#titulo").val() === ""){
        Swal.fire({
            title: 'Atenção!',
            text: 'O texto da noticia deve ser informado!',
            icon: 'info',
            confirmButtonText: 'OK'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#titulo").addClass('error-input');
                return false;
            }
        })
    } else {
        // Submit the form
        this.submit();
    }
});

/***
 * Excluir Notícia
 * */
document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', function(e) {
    e.preventDefault();

    const rota = $(this).data('rota');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    Swal.fire({
        title: 'Atenção?',
        text: "Deseja mesmo deleter esta notícia?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(rota, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Sucesso!',
                            html: data.message,
                            icon: 'success',
                            timer: 2000,
                            willClose: () => {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            html: data.message,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: error,
                        showConfirmButton: true
                    })
                );
         }
        });
    });
});



/***
 * Atualiza o status da noticia
 * */
document.querySelectorAll('.statusSwitch').forEach( function(element) {
    element.addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const rota = $(this).data('rota');
        const id = $(this).data('id');
        let status = this.checked ? 1 : 0;

        fetch(rota, {
            method: 'POST',
            body: JSON.stringify({ id: id, status: status }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Sucesso!',
                        html: data.message,
                        icon: 'success',
                        timer: 2000,
                        willClose: () => {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: data.message,
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => Swal.fire({
                title: 'Error!',
                icon: 'error',
                html: error,
                showConfirmButton: true
                })
            );
    });
});

/***
 *
 * */
document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        fetch(rota, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(response => {

                if (response.success) {
                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('subtitulo').value = response.data.subtitulo;
                    tinymce.activeEditor.setContent(response.data.conteudo);

                    let meuFormulario = document.getElementById('noticiaForm');
                    meuFormulario.action = $(this).data('rota-update'); // Substitua com a nova URL de ação

                    let hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                    $('#modalNoticia').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: response.message,
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    html: error,
                    showConfirmButton: true
                })
            );
    });
});
