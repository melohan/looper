$(document).ready(function () {
  /**
   * delete exercise element
   */
  document.querySelectorAll('a[data-method="delete"]').forEach(item => {
    item.addEventListener("click", function () { 
      if (!confirm(item.dataset.confirm)) return false;

      $.post($(this).data("href"), { id: $(this).data("val") }, function () {
        location.reload();
      }).fail(function (result) {

        alert("Got error");
      });
    })
  });
  
  /**
   * change exercise status
   */
  document.querySelectorAll('a[data-method="put"]').forEach(item => {
    item.addEventListener("click", function () { 
      $.post($(this).data("href"), { id: $(this).data("val"),status: $(this).data("status") }, function () {
       (window.location.href.includes("question")) && (item.dataset.method ="put") ? window.location.href = '/' : location.reload();
      }).fail(function (result) {

        alert("Got error");
      });
    })
  });
  
  
  /**
  * change new exercise status
  */

  var changeStatus = document.querySelector('a[data-method="changeStatus"]');
  changeStatus.addEventListener("click", function () { 
    if (!confirm(changeStatus.dataset.confirm)) return false;
      $.post($(this).data("href"), { id: ($('tr').length > 1) ? $(this).data("val") : 1,status: $(this).data("status") }, function () {
       (window.location.href.includes("question")) && (changeStatus.dataset.method =="changeStatus") && ($('tr').length > 1) ? window.location.href = '/exercise/manage' : location.reload();
      }).fail(function (result) {

        alert("Got error");
      });
    });
});
