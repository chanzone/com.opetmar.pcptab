
{* Personal Campaign Pages tab selector *}

<div class="crm-contact-pcps">
  <table class="crm-contact-pcps-selector">
    <thead>
    <tr>
      <th class='crm-contact-pcp-title nosort' style="background:white;">{ts}Page Title{/ts}</th>
      <th class='crm-contact-pcp-status nosort' style="background:white;">{ts}Status{/ts}</th>
      <th class='crm-contact-pcp-contribution_event_page nosort' style="background:white;">{ts}Contribution Page / Event{/ts}</th>
      <th class='crm-contact-pcp-no_of_contributions nosort' style="background:white;">{ts}No of Contributions{/ts}</th>
      <th class='crm-contact-pcp-amount_raised nosort' style="background:white;">{ts}Amount Raised{/ts}</th>
      <th class='crm-contact-pcp-target_amount nosort' style="background:white;">{ts}Target Amount{/ts}</th>
      <th class='crm-contact-pcp-links nosort' style="background:white;">Action</th>
    </tr>
    </thead>
  </table>
</div>

{literal}
<script type="text/javascript">
  var oTable;

  CRM.$(function($) {
    buildContactPCPs();
    function buildContactPCPs() {
      var sourceUrl = {/literal}'{crmURL p="civicrm/ajax/contactpcps" h=0 q="cid=$contactId"}'{literal};
      oTable = $('table.crm-contact-pcps-selector').dataTable({
        "bFilter": false,
        "bAutoWidth": false,
        "aaSorting": [],
        "aoColumns": [
          {sClass: 'crm-contact-pcp-title', bSortable: false},
          {sClass: 'crm-contact-pcp-status', bSortable: false},
          {sClass: 'crm-contact-pcp-contribution_event_page', bSortable: false},
          {sClass: 'crm-contact-pcp-no_of_contributions', bSortable: false},
          {sClass: 'crm-contact-pcp-amount_raised', bSortable: false},
          {sClass: 'crm-contact-pcp-target_amount', bSortable: false},
          {sClass: 'crm-contact-pcp-links' , bSortable: false}
        ],
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"crm-datatable-pager-top"lfp>rt<"crm-datatable-pager-bottom"ip>',
        "bServerSide": true,
        "bJQueryUI": true,
        "sAjaxSource": sourceUrl,
        "iDisplayLength": 10,
        "oLanguage": {
          "sZeroRecords": {/literal}'{ts escape="js"}There are no Personal Campaign Pages  for this contact.{/ts}'{literal},
          "sProcessing": {/literal}"{ts escape='js'}Processing...{/ts}"{literal},
          "sLengthMenu": {/literal}"{ts escape='js'}Show _MENU_ entries{/ts}"{literal},
          "sInfo": {/literal}"{ts escape='js'}Showing _START_ to _END_ of _TOTAL_ entries{/ts}"{literal},
          "sInfoEmpty": {/literal}"{ts escape='js'}Showing 0 to 0 of 0 entries{/ts}"{literal},
          "sInfoFiltered": {/literal}"{ts escape='js'}(filtered from _MAX_ total entries){/ts}"{literal},
          "sSearch": {/literal}"{ts escape='js'}Search:{/ts}"{literal},
          "oPaginate": {
            "sFirst": {/literal}"{ts escape='js'}First{/ts}"{literal},
            "sPrevious": {/literal}"{ts escape='js'}Previous{/ts}"{literal},
            "sNext": {/literal}"{ts escape='js'}Next{/ts}"{literal},
            "sLast": {/literal}"{ts escape='js'}Last{/ts}"{literal}
          }
        },
        "fnDrawCallback": function () {
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        }
      });
    }
  });
</script>
{/literal}
