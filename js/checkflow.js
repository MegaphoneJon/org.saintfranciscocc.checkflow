CRM.$(function ($) {
  'use strict';
  const CHECK_REQUEST = 54;

  // Grab a snapshot of the activity_status_id options.
  var all_statuses = $("#status_id").html();
  $('#activity_type_id').change(function() {
    $("#status_id").html(all_statuses);
    toggleStatuses($('#activity_type_id').val(), CHECK_REQUEST);
  });

  // Set the initial state for the status IDs.
  toggleStatuses($('#activity_type_id').val(), CHECK_REQUEST);
});

// Set the status for check requests.
function toggleStatuses(activity_id, CHECK_REQUEST) {
  var i;
  var keep_statuses = []; // The statuses to keep when running this function.
  // A list of valid check statuses.
  var check_statuses= ["2", "3", "11", "12", "13", "14"];
  var normal_statuses= ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
  if (activity_id == CHECK_REQUEST) {
    keep_statuses = check_statuses;
  } else {
    keep_statuses = normal_statuses;
  }
  // remove all the statuses that aren't keep_statuses.
  CRM.$("#status_id option").each(function()
  {
    if (keep_statuses.indexOf(CRM.$(this).val()) == -1 && CRM.$(this).text() !== '- any -') {
      CRM.$(this).remove();
    }
  });
  // Clear the status if it's currently set to an unavailable status.
  if(CRM.$("#s2id_status_id").select2("val") == "1") {
    CRM.$('#s2id_status_id').select2("val", "");
  }
}
