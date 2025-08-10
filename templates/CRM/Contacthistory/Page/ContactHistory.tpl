{* Contact History tab template *}
<div class="crm-contact-history">
  <div class="crm-summary-block">
    {if $addressHistory}
      <div class="crm-history-section">
        <h3>{ts}Address History{/ts}</h3>
        <table class="crm-history-table">
          <thead>
            <tr>
              <th>{ts}Location{/ts}</th>
              <th>{ts}Address{/ts}</th>
              <th>{ts}City{/ts}</th>
              <th>{ts}State/Province{/ts}</th>
              <th>{ts}Postal Code{/ts}</th>
              <th>{ts}Country{/ts}</th>
              <th>{ts}Start Date{/ts}</th>
              <th>{ts}End Date{/ts}</th>
              {if $canManage}<th>{ts}Actions{/ts}</th>{/if}
            </tr>
          </thead>
          <tbody>
            {foreach from=$addressHistory item=address}
              <tr class="{if $address.end_date}crm-history-ended{else}crm-history-current{/if}">
                <td>{$address.location_type}</td>
                <td>{$address.street_address}</td>
                <td>{$address.city}</td>
                <td>{$address.state_province}</td>
                <td>{$address.postal_code}</td>
                <td>{$address.country}</td>
                <td>{$address.start_date|crmDate}</td>
                <td>{if $address.end_date}{$address.end_date|crmDate}{else}{ts}Current{/ts}{/if}</td>
                {if $canManage}
                  <td>
                    <a href="{crmURL p='civicrm/contacthistory/edit' q="type=address&id=`$address.id`&cid=`$contactId`&reset=1"}" class="action-item">{ts}Edit{/ts}</a>
                    <a href="{crmURL p='civicrm/contacthistory/delete' q="type=address&id=`$address.id`&cid=`$contactId`&reset=1"}" class="action-item delete-link">{ts}Delete{/ts}</a>
                  </td>
                {/if}
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    {/if}

    {if $emailHistory}
      <div class="crm-history-section">
        <h3>{ts}Email History{/ts}</h3>
        <table class="crm-history-table">
          <thead>
            <tr>
              <th>{ts}Location{/ts}</th>
              <th>{ts}Email{/ts}</th>
              <th>{ts}Primary{/ts}</th>
              <th>{ts}Billing{/ts}</th>
              <th>{ts}On Hold{/ts}</th>
              <th>{ts}Start Date{/ts}</th>
              <th>{ts}End Date{/ts}</th>
              {if $canManage}<th>{ts}Actions{/ts}</th>{/if}
            </tr>
          </thead>
          <tbody>
            {foreach from=$emailHistory item=email}
              <tr class="{if $email.end_date}crm-history-ended{else}crm-history-current{/if}">
                <td>{$email.location_type}</td>
                <td>{$email.email}</td>
                <td>{if $email.is_primary}{ts}Yes{/ts}{/if}</td>
                <td>{if $email.is_billing}{ts}Yes{/ts}{/if}</td>
                <td>{if $email.on_hold}{ts}Yes{/ts}{/if}</td>
                <td>{$email.start_date|crmDate}</td>
                <td>{if $email.end_date}{$email.end_date|crmDate}{else}{ts}Current{/ts}{/if}</td>
                {if $canManage}
                  <td>
                    <a href="{crmURL p='civicrm/contacthistory/edit' q="type=email&id=`$email.id`&cid=`$contactId`&reset=1"}" class="action-item">{ts}Edit{/ts}</a>
                    <a href="{crmURL p='civicrm/contacthistory/delete' q="type=email&id=`$email.id`&cid=`$contactId`&reset=1"}" class="action-item delete-link">{ts}Delete{/ts}</a>
                  </td>
                {/if}
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    {/if}

    {if $phoneHistory}
      <div class="crm-history-section">
        <h3>{ts}Phone History{/ts}</h3>
        <table class="crm-history-table">
          <thead>
            <tr>
              <th>{ts}Location{/ts}</th>
              <th>{ts}Phone{/ts}</th>
              <th>{ts}Extension{/ts}</th>
              <th>{ts}Type{/ts}</th>
              <th>{ts}Primary{/ts}</th>
              <th>{ts}Start Date{/ts}</th>
              <th>{ts}End Date{/ts}</th>
              {if $canManage}<th>{ts}Actions{/ts}</th>{/if}
            </tr>
          </thead>
          <tbody>
            {foreach from=$phoneHistory item=phone}
              <tr class="{if $phone.end_date}crm-history-ended{else}crm-history-current{/if}">
                <td>{$phone.location_type}</td>
                <td>{$phone.phone}</td>
                <td>{$phone.phone_ext}</td>
                <td>{$phone.phone_type}</td>
                <td>{if $phone.is_primary}{ts}Yes{/ts}{/if}</td>
                <td>{$phone.start_date|crmDate}</td>
                <td>{if $phone.end_date}{$phone.end_date|crmDate}{else}{ts}Current{/ts}{/if}</td>
                {if $canManage}
                  <td>
                    <a href="{crmURL p='civicrm/contacthistory/edit' q="type=phone&id=`$phone.id`&cid=`$contactId`&reset=1"}" class="action-item">{ts}Edit{/ts}</a>
                    <a href="{crmURL p='civicrm/contacthistory/delete' q="type=phone&id=`$phone.id`&cid=`$contactId`&reset=1"}" class="action-item delete-link">{ts}Delete{/ts}</a>
                  </td>
                {/if}
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    {/if}

    {if !$addressHistory && !$emailHistory && !$phoneHistory}
      <div class="messages help">
        {ts}No contact history found.{/ts}
      </div>
    {/if}
  </div>
</div>

<style>
{literal}
.crm-contact-history .crm-history-section {
  margin-bottom: 2em;
}

.crm-contact-history .crm-history-table {
  width: 100%;
  border-collapse: collapse;
}

.crm-contact-history .crm-history-table th,
.crm-contact-history .crm-history-table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.crm-contact-history .crm-history-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}

.crm-contact-history .crm-history-ended {
  background-color: #f9f9f9;
  color: #666;
}

.crm-contact-history .crm-history-current {
  background-color: #fff;
}

.crm-contact-history .action-item {
  margin-right: 10px;
}

.crm-contact-history .delete-link {
  color: #d9534f;
}
{/literal}
</style>

{literal}
<script>
CRM.$(function($) {
  $('.delete-link').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    CRM.confirm({
      title: '{/literal}{ts escape='js'}Delete History Record{/ts}{literal}',
      message: '{/literal}{ts escape='js'}Are you sure you want to delete this history record? This action cannot be undone.{/ts}{literal}'
    }).on('crmConfirm:yes', function() {
      window.location.href = url;
    });
  });
});
</script>
{/literal}

