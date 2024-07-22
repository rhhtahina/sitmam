function initializeDtServerSide(id, url, data, arr_render) {
  table = $("#" + id).DataTable({
    destroy: true,
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    order: [
      [0, false],
      [1, "asc"],
    ],
    columnDefs: [
      {
        orderable: false,
        searchable: false,
        targets: [0],
        mRender: function (data, type, row) {
          let acces_btn = row[row.length - 1];
          let styl = "";
          if (acces_btn == "write" || acces_btn == "") {
            styl = "";
          } else {
            styl = 'style = "display:none;"';
          }
          let res = '<div class="text-center cursor-pointer">';
          for (let i = 0; i < arr_render.length; i++) {
            if (arr_render[i] == 0) {
              /* Case à cocher */
              res +=
                '<div class="checkbox" style="margin-right:10.3em;margin-top:-11px !important;"><input type="checkbox" class="styled" name="ck" ' +
                styl +
                ' id="ck_' +
                row[0] +
                '"></div>';
            }
            if (arr_render[i] == 1) {
              /* Visualisation */
              res +=
                '<button style="margin-right:0.3em;" class="btn bg-slate-400 btn-icon btn-rounded btn-xs" data-toggle="modal" data-popup="tooltip" title="Visualiser" data-placement="bottom" onclick="view(' +
                row[0] +
                ',\'voir\')"><i class="icon-eye"></i></button>';
            }
            if (arr_render[i] == 2) {
              /* Modification */
              res +=
                '<a href="#" ' +
                styl +
                '><button style="margin-right:0.3em;" class="btn btn-success btn-icon btn-rounded btn-xs" data-toggle="modal" data-popup="tooltip" title="Mettre à jour" data-placement="bottom" onclick="view(' +
                row[0] +
                ',\'upd\')"><i class="icon-pencil4"></i></button></a>';
            }
            if (arr_render[i] == 3) {
              /* Suppression */
              res +=
                '<button class="btn btn-danger btn-icon btn-rounded btn-xs" data-popup="tooltip" title="Supprimer" data-placement="bottom" onclick="del(' +
                row[0] +
                ')" ' +
                styl +
                '><i class="icon-x"></i></button>';
            }
          }
          res += "</div>";
          return res;
        },
      },
    ],
    ajax: {
      url: url,
      data: data,
      type: "POST",
      beforeSend: function () {
        loader();
      },
      error: function (xhr, status, error) {
        stopLoader();
      },
    },
    drawCallback: function () {
      stopLoader();
      $('[data-popup="tooltip"]').tooltip();
      $(".styled").uniform({
        radioClass: "choice",
      });
    },
    sRowSelect: "single",
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    lengthMenu: [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "All"],
    ],
    pageLength: 5,
    language: {
      emptyTable: "Aucune donnée disponible dans le tableau",
      search: "<span>Recherche:</span> _INPUT_",
      lengthMenu: "<span>Afficher:</span> _MENU_",
      paginate: {
        first: "First",
        last: "Last",
        next: "&rarr;",
        previous: "&larr;",
      },
      info: "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      infoEmpty:
        "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      infoPostFix: "",
      loadingRecords: "Chargement en cours...",
      zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
    },
  });

  $(".dataTables_filter input[type=search]").attr(
    "placeholder",
    "Tapez un texte..."
  );
  $(".dataTables_filter input[type=search]").addClass("input-xs");
  $(".dataTables_length label span").css("padding-top", "6px");
  // $(".dataTables_length select").select2({
  //   minimumResultsForSearch: "-1",
  //   width: "70px",
  // });
  return table;
}

function loader() {
  $("body").block({
    message: '<i class="icon-spinner2 spinner fa-10x"></i>',
    overlayCSS: {
      backgroundColor: "#1B2024",
      opacity: 0.25,
      cursor: "wait",
    },
    css: {
      border: 0,
      padding: 0,
      backgroundColor: "none",
      color: "#D3D3D3",
    },
  });
}

function stopLoader() {
  $("body").unblock();
}
