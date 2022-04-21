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
        const envoyeur = $("#nomEmetteur").val();

        $("#invoice").removeClass("hide-invoice");

        $("#invoice-code").html(code);
        $("#invoice-montant").html(montant.toLocaleString('fr-FR'));
        $("#invoice-frais").html(frais.toLocaleString('fr-FR'));
        $("#invoice-emetteur").html(envoyeur);

        $.ajax({
            url: '/api/transfert',
            type: "POST",
            data: form.serialize(),
            success: function (response) {
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
                    alert("Veuillez remplir tous les champs");
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
                    const transfert = response.transfert;

                    const code = transfert.codeTransfert;
                    const montant = transfert.montantTransfert;
                    const nom = transfert.nomBeneficiaire;
                    $("#invoice-confirmation").removeClass("hide-invoice");
                    $("#invoice-montant-confirmation").html(montant.toLocaleString());
                    $("#invoice-code-confirmation").html(code);
                    $("#invoice-beneficiaire-confirmation").html(nom);
                    $("#invoice-receveur").html(nom);

                    $('#invoice-confirmation').printThis({
                        afterPrint: () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transfert confirmé',
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
});
