$(document).ready(function() {
    // reset profil modal value
    $("#modal_ajout_utilisateur").on("hidden.bs.modal", function() {
        // Initialize the dual listbox
        $(this).find('input[type="text"], input[type="password"], select').val("");
    });

    let data_utilisateur = {};
    let arr_render_utilsiateur = [2, 3];
    tableUtilisateur = initializeDtServerSide(
        "table_utilisateur",
        "User/getAllUser",
        data_utilisateur,
        arr_render_utilsiateur
    );
});

function insert_utilisateur() {
    $("#nom_utilisateur-error").text("");
    $("#prenom_utilisateur-error").text("");
    $("#login_utilisateur-error").text("");
    $("#profil_utilisateur-error").text("");
    $("#mdp_utilisateur-error").text("");
    $("#confirmation_mdp_utilisateur-error").text("");

    var nom = $("#nom_utilisateur").val();
    var prenom = $("#prenom_utilisateur").val();
    var login = $("#login_utilisateur").val();
    var profil = $("#profil_utilisateur").val();
    var mdp = $("#mdp_utilisateur").val();
    var confirmation_mdp = $("#confirmation_mdp_utilisateur").val();

    if (nom == "") {
        $("#nom_utilisateur-error").text("Le champ NOM est obligatoire");
        $("#nom_utilisateur-error").css("display", "");
    }

    if (prenom == "") {
        $("#prenom_utilisateur-error").text("Le champ PRENOM est obligatoire");
        $("#prenom_utilisateur-error").css("display", "");
    }

    if (login == "") {
        $("#login_utilisateur-error").text("Le champ LOGIN est obligatoire");
        $("#login_utilisateur-error").css("display", "");
    }

    if (profil == "") {
        $("#profil_utilisateur-error").text("Le champ PROFIL est obligatoire");
        $("#profil_utilisateur-error").css("display", "");
    }

    if (mdp == "") {
        $("#mdp_utilisateur-error").text("Le champ MOT DE PASSE est obligatoire");
        $("#mdp_utilisateur-error").css("display", "");
    }

    if (confirmation_mdp == "") {
        $("#confirmation_mdp_utilisateur-error").text("Le champ CONFIRMATION MOT DE PASSE est obligatoire");
        $("#confirmation_mdp_utilisateur-error").css("display", "");
    }

    if ($("#nom_utilisateur-error").text() != "" || $("#prenom_utilisateur-error").text() != "" || $("#login_utilisateur-error").text() != "" || $("#profil_utilisateur-error").text() != "" || $("#mdp_utilisateur-error").text() != "" || $("#confirmation_mdp_utilisateur-error").text() != "") {
        return false;
    } else if (mdp != confirmation_mdp) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            html: "Le mot de passe et la confirmation de mot de passe ne sont pas égaux",
        });
        return false;
    } else {
        showSpinner();
        Swal.fire({
            title: "Ajout de l'utilisateur : <strong>" + nom + " " + prenom + "</strong>",
            text: "Voulez-vous vraiment ajouter cet utilisateur?",
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
                    url: urlProject + "User/createUser",
                    data: { nom: nom, prenom: prenom, login: login, profil_id: profil, mdp: mdp },
                    success: function(response) {
                        if (response == "doublon nom") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "L'utilisateur avec ce nom et prénom existe déjà",
                            });
                        } else if (response == "doublon login") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "L'utilisateur avec ce login existe déjà",
                            });
                        } else if (response == "ko") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Merci de réessayer",
                            });
                        } else if (response == "ok") {
                            Swal.fire({
                                icon: "success",
                                title: "Insertion",
                                html: "L'utilisateur <strong>" + nom + " " + prenom + "</strong> a été inséré avec succès",
                            }).then(() => {
                                $("#modal_ajout_utilisateur").modal("hide");
                                window.location.href = "User";
                            });
                        }
                        removeSpinner();
                    },
                });
            } else {
                $("#modal_ajout_utilisateur").modal("hide");
                window.location.href = "User";
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