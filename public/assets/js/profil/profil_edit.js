$(document).ready(function() {
    $(".swal2-cancel").click(function() {
        e.preventDefault();

        console.log("click cancel");
        removeSpinner();
    });
});

function view(id, act) {
    $("#div_profil").html("");
    $.ajax({
        type: "post",
        url: urlProject + "Profil/viewProfil",
        data: { id: id, action: act },
        success: function(response) {
            $("#div_profil").html(response);
            $("#modal_view_profil").modal("show");
            if (act == "voir") {
                $("#div_profil_footer").css("display", "none");
                $("#title").text("Visualisation de profil");
            } else if (act == "upd") {
                $("#div_profil_footer").css("display", "block");
                $("#title").text("Modification de profil");
            }
        }
    });
}

function maj(id) {
    $("#profil_upd-error").text("");
    $("#page_upd-error").text("");

    var profil = $("#profil_upd").val();
    var page = $("#page_upd").val();

    if (profil == "" && page.length == 0) {
        $("#profil_upd-error").text("Le champ PROFIL est obligatoire");
        $("#page_upd-error").text("Vous devez au moins sélectionner une page à associer à ce profil");
        $("#profil_upd-error").css("display", "");
        $("#page_upd-error").css("display", "");
    } else if (page.length == 0) {
        $("#page_upd-error").text("Vous devez au moins sélectionner une page à associer à ce profil");
        $("#page_upd-error").css("display", "");
    } else if (profil == "") {
        $("#profil_upd-error").text("Le champ PROFIL est obligatoire");
        $("#profil_upd-error").css("display", "");
    } else {
        showSpinner();
        Swal.fire({
            title: "Confirmation",
            text: "Voulez-vous vraiment modifier ce profil?",
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
                    type: "post",
                    url: urlProject + "Profil/updateProfil",
                    data: {
                        id: id,
                        profil: profil,
                        page: page,
                    },
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
                        } else if (res == "ko") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Merci de réessayer",
                            });
                        } else if (res == "ras") {
                            Swal.fire({
                                icon: "warning",
                                title: "Oops...",
                                html: "Aucune modification n'a été faite",
                            });
                        } else if (res == "ok") {
                            Swal.fire({
                                icon: "success",
                                title: "Modification",
                                html: "Modification réussie pour le profil <strong>" +
                                    profil +
                                    "</strong>",
                            }).then(() => {
                                $("#modal_view_profil").modal("hide");
                                window.location.href = "Profil";
                            });
                        }
                        removeSpinner();
                    }
                });
            } else {
                $("#modal_view_profil").modal("hide");
                window.location.href = "Profil";
            }
        });
    }
}

function del(id) {
    Swal.fire({
        title: "Confirmation",
        text: "Si le profil est supprimé, les comptes qui ont ce profil n'auront plus accès à l'application. Voulez-vous vraiment le supprimer?",
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
                type: "post",
                url: urlProject + "Profil/deleteProfil",
                data: { id: id },
                success: function(response) {
                    if (response == "ok") {
                        Swal.fire({
                            icon: "success",
                            title: "Suppression",
                            html: "Le profil a bien été supprimé",
                        }).then(() => {
                            window.location.href = "Profil";
                        });
                    } else if (response == "ko") {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "Merci de réessayer",
                        }).then(() => {
                            window.location.href = "Profil";
                        });
                    }
                }
            });
        }
    });
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