var tableProfil;
$(document).ready(function() {
    $("#toggleButton").click(function() {
        $("#cardBody").toggle();
        $("#toggleButton .arrow").toggleClass("up down");
    });

    setDualList();

    // reset profil modal value
    $("#modal_ajout_profil").on("hidden.bs.modal", function() {
        // Initialize the dual listbox
        $(this).find('input[type="text"], select').val("");

        // Reset the dual listbox
        $("#page").find("option").prop("selected", false);
        $("#page").bootstrapDualListbox("refresh", true);
    });

    let data_profil = {};
    let arr_render_profil = [1, 2, 3];
    tableProfil = initializeDtServerSide(
        "table_profil",
        "Profil/getAllProfil",
        data_profil,
        arr_render_profil
    );
});

function setDualList() {
    $(".listbox").bootstrapDualListbox({
        nonSelectedListLabel: "Pages disponibles",
        selectedListLabel: "Pages sélectionnées",
        showFilterInputs: false,
        filterTextClear: "",
        infoText: "",
        infoTextFiltered: "",
        infoTextEmpty: "",
    });
}

function insert_profil() {
    $("#profil_name-error").text("");
    $("#page-error").text("");

    var profil = $("#profil_name").val();
    var pageSelected = $("#page").val();

    if (profil == "" && pageSelected.length == 0) {
        $("#profil_name-error").text("Le champ PROFIL est obligatoire");
        $("#profil_name-error").css("display", "");

        $("#page-error").text(
            "Vous devez au moins sélectionner une page à assosier à ce profil"
        );
        $("#page-error").css("display", "");
    } else if (pageSelected.length == 0) {
        $("#page-error").text(
            "Vous devez au moins sélectionner une page à assosier à ce profil"
        );
        $("#page-error").css("display", "");
    } else if (profil == "") {
        $("#profil_name-error").text("Le champ PROFIL est obligatoire");
        $("#profil_name-error").css("display", "");
    } else {
        showSpinner();
        Swal.fire({
            title: "Ajout du profil : <strong>" + profil + "</strong>",
            text: "Voulez-vous vraiment ajouter ce profil?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Non",
            confirmButtonText: "Oui",
            reverseButtons: true,
            didOpen: () => {
                // Remove focus from both buttons
                document.querySelector(".swal2-confirm").blur();
            },
            customClass: {
                confirmButton: "swal2-confirm",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: urlProject + "Profil/createProfil",
                    data: { profil_name: profil, page: pageSelected },
                    success: function(response) {
                        var rep = response.split("||");
                        var res = rep[0];
                        if (res == "doublon profil") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Le profil <strong>" + profil + "</strong> existe déjà",
                            });
                        } else if (res == "doublon page") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Les pages sélectionnées sont déjà associées au profil <strong>" +
                                    rep[1] +
                                    "</strong>",
                            });
                        } else if (res == "1") {
                            Swal.fire({
                                icon: "success",
                                title: "Insertion",
                                html: "Le profil <strong>" +
                                    profil +
                                    "</strong> a été inséré avec succès",
                            }).then(() => {
                                $("#modal_ajout_profil").modal("hide");
                                window.location.href = "Profil";
                            });
                            removeSpinner();
                        } else if (res == "0") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Merci de réessayer",
                            });
                        }
                    },
                });
                removeSpinner();
            } else {
                $("#modal_ajout_profil").modal("hide");
                window.location.href = "Profil";
                removeSpinner();
            }
        });
    }
}

function showSpinner() {
    $(".loading-icon").removeClass("hide");
    $(".check_validation").addClass("hide");
    $(".button").attr("disabled", true);
}

function removeSpinner() {
    $(".loading-icon").addClass("hide");
    $(".check_validation").removeClass("hide");
    $(".button").attr("disabled", false);
}