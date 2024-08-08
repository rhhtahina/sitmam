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

                    }
                });
            }
        });
    }
}

function del(id) {
    console.log("del_id = " + id);
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