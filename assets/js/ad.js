$('#add-image').click(function () { // Récupération des futurs numéros de champs créés
    const index = +$('#widgets-counter').val();

    // Récupération du prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);

    // Injection du code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // Gestion du bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();