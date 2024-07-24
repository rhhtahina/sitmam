function view(id, act) {
    $("#div_profil").html("");
    $.ajax({
        type: "post",
        url: urlProject + "Profil/viewProfil",
        data: { id: id, action: act },
        success: function(response) {

        }
    });
}

function del(id) {
    console.log("del_id = " + id);
}