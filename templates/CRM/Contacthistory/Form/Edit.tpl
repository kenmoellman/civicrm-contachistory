<div class="crm-block crm-form-block">
  <div class="crm-section">
    <div class="content">
      {* Form elements will be rendered here based on the type *}
      {foreach from=$form item=element}
        {if $element.html}
          <div class="crm-section">
            <div class="label">{$element.label}</div>
            <div class="content">{$element.html}</div>
          </div>
        {/if}
      {/foreach}
    </div>
  </div>
  
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>

