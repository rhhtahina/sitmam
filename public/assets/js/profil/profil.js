$(document).ready(function() {
    $("#toggleButton").click(function() {
        $("#cardBody").toggle();
        $("#toggleButton .arrow").toggleClass("up down");
    });

    setDualList();
});

function setDualList() {
    $(".listbox").bootstrapDualListbox({
        nonSelectedListLabel: "Pages disponibles",
        selectedListLabel: "Pages sélectionnées",
        showFilterInputs: false,
        filterTextClear: '',
        infoText: '',
        infoTextFiltered: '',
        infoTextEmpty: '',
    });
}

function insert_profil() {
    $("#profil_name-error").text("");
    $("#page-error").text("");

    var profil = $("#profil_name").val();

    console.log("profil = " + profil);
    console.log("page = " + $("#page").val());

    if (profil == "" && $("#page").val() == "") {
        console.log("tafiditra ato anaty if");
        $("#profil_name-error").text("Le champ PROFIL est obligatoire");
        $("#profil_name-error").css("display", "");

        $("#page-error").text("Vous devez au moins sélectionner une page à assosier à ce profil");
        $("#page-error").css("display", "");
    } else {
        console.log("tsy tafiditra ato anaty if");
    }
}