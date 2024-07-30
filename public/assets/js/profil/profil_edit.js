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

function del(id) {
    console.log("del_id = " + id);
}