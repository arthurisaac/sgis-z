require('./bootstrap');

$(document).ready(function () {
    $("#numeroDocumentEmetteur").on("change", function () {
        const transfert = transferts.find(t => t.numeroDocumentEmetteur === this.value);
        if (transfert) {
            $("#nomEmetteur").val(transfert.nomEmetteur);
            $("#typeDocumentEmetteur").val(transfert.typeDocumentEmetteur);
        }
    });

    $("#newTransfertForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);

        const code = $("#codeTransfert").val();
        const montant = $("#montantTransfert").val();
        const frais = $("#fraisTransfert").val();

        $("#invoice").removeClass("hide-invoice");

        $("#invoice-code").html(code);
        $("#invoice-montant").html(montant.toLocaleString('fr-FR'));
        $("#invoice-frais").html(frais.toLocaleString('fr-FR'));

        $.ajax({
            url: '/api/transfert',
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                console.log(response);
                if (response.success === 'success') {
                    $('#invoice').printThis({
                        afterPrint: () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transfert réussi',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    });

                } else {
                    alert("Une erreur s'est produite");
                }
            },
            error: function () {
                alert('server error occured')
            }
        });

    });

    $("#editTransfertForm").submit(function (e) {
        e.preventDefault();
        const transfertID = $("#transfertID").val();
        $.ajax({
            url: `/api/transfert/${transfertID}`,
            method: 'PATCH',
            dataType: 'json',
            data: $('#editTransfertForm').serialize(),
            success: function (response) {
                if (response.success === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transfert confirmé',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert("Une erreur s'est produite");
                }
            },
            error: function () {
                alert('server error occured')
            }
        });
    });
});
