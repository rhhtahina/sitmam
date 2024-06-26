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