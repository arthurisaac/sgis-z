require('./bootstrap');

$(document).ready(function () {
    $("#numeroDocumentEmetteur").on("change", function () {
        const transfert = transferts.find(t => t.numeroDocumentEmetteur === this.value);
        if (transfert) {
            $("#nomEmetteur").val(transfert.nomEmetteur);
            $("#typeDocumentEmetteur").val(transfert.typeDocumentEmetteur);
            $("#documentEmetteurDelivreLe").val(transfert.documentEmetteurDelivreLe);
            $("#telephoneEmetteur").val(transfert.telephoneEmetteur);
        }
    });

    $("#numeroDocumentBeneficiaireEdit").on("change", function () {
        const transfert = transferts.find(t => t.numeroDocumentEmetteur === this.value);
        if (transfert) {
            $("#documentBeneficiaireDelivreLe").val(transfert.documentBeneficiaireDelivreLe);
        } else {
            $("#documentBeneficiaireDelivreLe").val("");
        }
    });

    $("#newTransfertForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);

        const code = $("#codeTransfert").val();
        const montant = $("#montantTransfert").val();
        const frais = $("#fraisTransfert").val();
        const emetteur = $("#nomEmetteur").val();
        const beneficiaire = $("#nomBeneficiaire").val();
        const telEmetteur = $("#telephoneEmetteur").val();
        const telBeneficiaire = $("#telephoneBeneficiaire").val();

        $("#invoice").removeClass("hide-invoice");
        $("#invoice-thermical").removeClass("hide-invoice");

        $("#invoice-code").html(code);
        $("#invoice-montant").html(montant.toLocaleString());
        $("#invoice-frais").html(frais.toLocaleString());
        $("#invoice-emetteur").html(emetteur);
        $("#invoice-beneficiaire").html(beneficiaire);
        $("#invoice-tel-emetteur").html(telEmetteur);
        $("#invoice-tel-beneficiaire").html(telBeneficiaire);

        $("#t-invoice-code").html(code);
        $("#t-invoice-montant").html(montant.toLocaleString());
        $("#t-invoice-frais").html(frais.toLocaleString());
        $("#t-invoice-emetteur").html(emetteur);
        $("#t-invoice-beneficiaire").html(beneficiaire);
        $("#t-invoice-tel-emetteur").html(telEmetteur);
        $("#t-invoice-tel-beneficiaire").html(telBeneficiaire);

        $.ajax({
            url: '/api/transfert',
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                if (response.success === 'success') {
                    $("#transfertModal").modal('hide');
                    $("#printModal").modal('show');
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
                    const telEmetteur = transfert.telephoneEmetteur;
                    const telBeneficiaire = transfert.telephoneBeneficiaire;
                    $("#invoice-confirmation").removeClass("hide-invoice");
                    $("#invoice-confirmation-thermical").removeClass("hide-invoice");

                    $("#invoice-montant-confirmation").html(montant.toLocaleString());
                    $("#invoice-beneficiaire-confirmation").html(nom);
                    $("#invoice-code-confirmation").html(code);
                    $("#invoice-tel-emetteur-confirmation").html(telEmetteur);
                    $("#invoice-tel-beneficiaire-confirmation").html(telBeneficiaire);


                    $("#t-invoice-montant-confirmation").html(montant.toLocaleString());
                    $("#t-invoice-beneficiaire-confirmation").html(nom);
                    $("#t-invoice-code-confirmation").html(code);
                    $("#t-invoice-tel-emetteur-confirmation").html(telEmetteur);
                    $("#t-invoice-tel-beneficiaire-confirmation").html(telBeneficiaire);

                    $("#transfertModal").modal('hide');
                    $("#printConfirmModal").modal('show');
                } else {
                    alert("Une erreur s'est produite");
                }
            },
            error: function () {
                alert('server error occured')
            }
        });
    });

    $("#updateTransfertForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);

        const id = $("#transfertID").val();
        const code = $("#codeTransfert").val();
        const montant = $("#montantTransfert").val();
        const frais = $("#fraisTransfert").val();
        const emetteur = $("#nomEmetteur").val();
        const beneficiaire = $("#nomBeneficiaire").val();
        const telEmetteur = $("#telephoneEmetteur").val();
        const telBeneficiaire = $("#telephoneBeneficiaire").val();

        $("#invoice").removeClass("hide-invoice");
        $("#invoice-thermical").removeClass("hide-invoice");

        $("#invoice-code").html(code);
        $("#invoice-montant").html(montant.toLocaleString('fr-FR'));
        $("#invoice-frais").html(frais.toLocaleString('fr-FR'));
        $("#invoice-emetteur").html(emetteur);
        $("#invoice-beneficiaire").html(beneficiaire);
        $("#invoice-tel-emetteur").html(telEmetteur);
        $("#invoice-tel-beneficiaire").html(telBeneficiaire);

        $("#t-invoice-code").html(code);
        $("#t-invoice-montant").html(montant.toLocaleString('fr-FR'));
        $("#t-invoice-frais").html(frais.toLocaleString('fr-FR'));
        $("#t-invoice-emetteur").html(emetteur);
        $("#t-invoice-beneficiaire").html(beneficiaire);
        $("#t-invoice-tel-emetteur").html(telEmetteur);
        $("#t-invoice-tel-beneficiaire").html(telBeneficiaire);

        $.ajax({
            url: '/transfert/' + id,
            type: "PATCH",
            data: form.serialize(),
            success: function (response) {
                if (response.success === 'success') {
                    $("#transfertModal").modal('hide');
                    $("#printConfirmModal").modal('show');
                } else {
                    alert("Veuillez remplir tous les champs");
                }
            },
            error: function () {
                alert('server error occured')
            }
        });
    });

    $("#printSimpleBtn").on("click", function () {
        $('#invoice').printThis({
            printDelay: 500,
            importCSS: true,
            importStyle: true,
            removeInline: false,
            loadCSS: "/css/app.css",
            afterPrint: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Impression en cours',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        });
    });

    $("#printThermicalBtn").on("click", function () {
        $('#invoice-confirmation').printThis({
            printDelay: 500,
            importCSS: true,
            importStyle: true,
            removeInline: false,
            loadCSS: "/css/app.css",
            afterPrint: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Impression en cours',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        });
    });

    $("#printConfirmThermicalBtn").on("click", function () {
        $('#invoice-confirmation-thermical').printThis({
            printDelay: 500,
            importCSS: true,
            importStyle: true,
            removeInline: false,
            loadCSS: "/css/app.css",
            afterPrint: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Impression en cours',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        });
    });

    $("#printConfirmBtn").on("click", function () {
        $('#invoice-confirmation').printThis({
            printDelay: 500,
            importCSS: true,
            importStyle: true,
            removeInline: false,
            loadCSS: "/css/app.css",
            afterPrint: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Impression en cours',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        });
    });
});
