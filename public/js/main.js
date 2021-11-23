$(document).ready(function () {
  /**
   * delete element
   */
  document.querySelectorAll('a[data-method="delete"]').forEach(item => {
    item.addEventListener("click", function () { 
      if (!confirm(item.dataset.confirm)) return false;

      $.post($(this).data("href"), { id: $(this).data("val") }, function () {
        //location.reload();
      }).fail(function (result) {

        alert("Got error");
      });
    })
  });
  
  /**
   * change status
   */
  document.querySelectorAll('a[data-method="put"]').forEach(item => {
    item.addEventListener("click", function () { 
      if (!confirm(item.dataset.confirm)) return false;

      $.post($(this).data("href"), { id: $(this).data("val"),status: $(this).data("status") }, function () {
       (window.location.href.includes("question")) && (item.dataset.method ="put") ? window.location.href = '/' : location.reload();
      }).fail(function (result) {

        alert("Got error");
      });
    })
  });
});
