<span class="activity-log">
<h3>Check Request History</h3>
<table class="activity-table">
<tr><th>Date</th><th>Edited by</th><th>Status</th><th>Routed to</th></tr>
{foreach from=$activityLog item=row}
<tr>
<td>{$row.log_date|crmDate}</td><td>{$row.editor}</td><td>{$row.status}</td><td>{$row.routed_to}</td>
</tr>
{/foreach}
</table>
</span>
