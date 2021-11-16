$(document).ready(function () {
  /**
   * delete element
   */
  $(".fa-trash").click(function () {
    let res = confirm("Are you sure?");
    if (res === true) {
      $.post($(this).data("href"), { id: $(this).data("val") }, function () {
        location.reload();
      }).fail(function (result) {
        alert("Got error");
      });
    }
    return false;
  });
});
