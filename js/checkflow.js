CRM.$(function ($) {
  'use strict';
  const CHECK_REQUEST = 54;
  var all_statuses = [];
  // Collect the statuses in their default state.
  CRM.$("#status_id option").each(function() {
    console.log($(this).text());
    all_statuses[$(this).val()] = $(this).text();
  });

  // if the activity type changes
  $('#activity_type_id').change(function() {
    CRM.$("#status_id option").remove();
    // Regenerate the standard list of options.
    CRM.$.each(all_statuses, function(key, value) {
      CRM.$('#status_id')
        .append(CRM.$("<option></option")
        .attr("value",key)
        .text(value));
    });
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
  console.log(keep_statuses);
  // remove all the statuses that aren't keep_statuses.
  CRM.$("#status_id option").each(function()
  {
    if (keep_statuses.indexOf(CRM.$(this).val()) == -1) {
      CRM.$(this).remove();
    }
  });
  // Clear the status if it's currently set to an unavailable status.
  if(CRM.$("#s2id_status_id").select2("val") == "1") {
    CRM.$('#s2id_status_id').select2("val", "");
  }
}
