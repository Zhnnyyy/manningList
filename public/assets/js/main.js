$(() => {
  // new DataTable("#datatable", {
  //   scrollX: true,
  // });
  controlSidebarPanel();

  $("#dashboardBtn").click((e) => {
    e.preventDefault();
    alert("EGE");
  });
});

const controlSidebarPanel = () => {
  $("#sidebarBtn").click((e) => {
    $("#main_header").toggleClass("wided");
    $("#main-sidebar").toggleClass("sidebar_close");
    $("#main-container").toggleClass("main-wided");
  });
};
  