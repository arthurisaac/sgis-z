/*
 * FUNCTIONS
 */

function showOnTransfertModal(transfert) {
    $(this).trigger("reset");
    const MontantInletter = writtenNumber(transfert.montantTransfert, {lang: 'fr'});
    $("#numeroTransfertShow").html(transfert.numeroTransfert);
    $("#nomEmetteurShow").html(transfert.nomEmetteur);
    $("#nomBeneficiaireShow").html(transfert.nomBeneficiaire);
    $("#typeDocumentEmetteurShow").html(transfert.typeDocumentEmetteur);
    $("#numeroDocumentEmetteurShow").html(transfert.numeroDocumentEmetteur);
    $("#codeTransfertShow").html(transfert.codeTransfert);
    $("#typeTransfertShow").html(transfert.typeTransfert);
    $("#montantTransfertShow").html(transfert.montantTransfert.toLocaleString());
    $("#montantTransfertLetterShow").html(MontantInletter);
    $("#fraisTransfertShow").html(transfert.fraisTransfert);
    $("#typeDocumentBeneficiaireShow").html(transfert.typeDocumentBeneficiaire);
    $("#numeroDocumentBeneficiaireShow").html(transfert.numeroDocumentBeneficiaire);
    $("#telephoneEmetteurShow").html(transfert.telephoneEmetteur);
    $("#telephoneBeneficiaireShow").html(transfert.telephoneBeneficiaire);
    $("#transfertID").val(transfert.id);


    if (white_me === transfert.transfertPar) {
        $("#confirmation-form").hide();
    }
    $('#transfertModal').modal('show');
}

function dismissOneTransfertModal() {
    $('#transfertModal').modal('hide');
}

function linearStatsReport(categories, data, dom) {
    const e = document.querySelectorAll(dom);
    [].slice.call(e).map((function (e) {
        const t = parseInt(KTUtil.css(e, "height"));
        if (e) {
            const a = e.getAttribute("data-kt-chart-color"), o = KTUtil.getCssVariableValue("--bs-gray-800"),
                s = KTUtil.getCssVariableValue("--bs-gray-300"), r = KTUtil.getCssVariableValue("--bs-" + a),
                i = KTUtil.getCssVariableValue("--bs-light-" + a);
            new ApexCharts(e, {
                series: [{name: "Entrées", data}], //[15, 25, 15, 40, 20, 50, 25, 15, 40, 20, 50]
                chart: {
                    fontFamily: "inherit",
                    type: "area",
                    height: t,
                    toolbar: {show: !1},
                    zoom: {enabled: !1},
                    sparkline: {enabled: !0}
                },
                plotOptions: {},
                legend: {show: !1},
                dataLabels: {enabled: !1},
                fill: {type: "solid", opacity: 1},
                stroke: {curve: "smooth", show: !0, width: 3, colors: [r]},
                xaxis: {
                    //categories: ["7h", "8h", "9h", "10h", "11h", "12h", "13h", "14h", "15h", "16h", "17h"],
                    categories: categories,
                    axisBorder: {show: !1},
                    axisTicks: {show: !1},
                    labels: {show: !1, style: {colors: o, fontSize: "12px"}},
                    crosshairs: {show: !1, position: "front", stroke: {color: s, width: 1, dashArray: 3}},
                    tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
                },
                yaxis: {min: 0, labels: {show: !1, style: {colors: o, fontSize: "12px"}}},
                states: {
                    normal: {filter: {type: "none", value: 0}},
                    hover: {filter: {type: "none", value: 0}},
                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                },
                tooltip: {
                    style: {fontSize: "12px"}, y: {
                        formatter: function (e) {
                            return e + " F CFA"
                        }
                    }
                },
                colors: [i],
                markers: {colors: [i], strokeColor: [r], strokeWidth: 3}
            }).render()
        }
    }))
}

function linearMonthStatsReport(categories, data, dom) {
    let e, t, a, o = document.querySelectorAll(dom),
        s = KTUtil.getCssVariableValue("--bs-gray-500"), r = KTUtil.getCssVariableValue("--bs-gray-200");
    [].slice.call(o).map((function (o) {
        a = parseInt(KTUtil.css(o, "height")), e = KTUtil.getCssVariableValue("--bs-" + o.getAttribute("data-kt-color")), t = KTUtil.colorDarken(e, 15), new ApexCharts(o, {
            series: [{name: "Total transfert", data}],
            chart: {
                fontFamily: "inherit",
                type: "area",
                height: a,
                toolbar: {show: !1},
                zoom: {enabled: !1},
                sparkline: {enabled: !0},
                dropShadow: {
                    enabled: !0,
                    enabledOnSeries: void 0,
                    top: 5,
                    left: 0,
                    blur: 3,
                    color: t,
                    opacity: .5
                }
            },
            plotOptions: {},
            legend: {show: !1},
            dataLabels: {enabled: !1},
            fill: {type: "solid", opacity: 0},
            stroke: {curve: "smooth", show: !0, width: 3, colors: [t]},
            xaxis: {
                categories,
                axisBorder: {show: !1},
                axisTicks: {show: !1},
                labels: {show: !1, style: {colors: s, fontSize: "12px"}},
                crosshairs: {show: !1, position: "front", stroke: {color: r, width: 1, dashArray: 3}}
            },
            yaxis: {min: 0, labels: {show: !1, style: {colors: s, fontSize: "12px"}}},
            states: {
                normal: {filter: {type: "none", value: 0}},
                hover: {filter: {type: "none", value: 0}},
                active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
            },
            tooltip: {
                style: {fontSize: "12px"}, y: {
                    formatter: function (e) {
                        return e + " F CFA"
                    }
                }, marker: {show: !1}
            },
            colors: ["transparent"],
            markers: {colors: [e], strokeColor: [t], strokeWidth: 3}
        }).render()
    }));
}

function deleteOneTransfert(id) {
    if (confirm('Confirmer suppression')) {
        dismissOneTransfertModal();
        $.ajax({
            url: `/api/transfert/${id}`,
            type: "DELETE",
            data: {},
            success: function (response) {
                console.log(response);
                if (response.success === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé',
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
                //alert('server error occured')
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur serveur! Reessayé plus tard',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

}

/*$(document).on('DOMNodeInserted', function () {
    $("#numeroDocumentEmetteur").on("change", function () {
        const transfert = transferts.find(t => t.numeroDocumentEmetteur === this.value);
        if (transfert) {
            $("#nomEmetteur").val(transfert.nomEmetteur);
            $("#typeDocumentEmetteur").val(transfert.typeDocumentEmetteur);
        }
    });
});*/
