<textarea name="gdpr_header" rows="5" cols="40">
<?php if($content!=""){?>
<?= esc_html_x($content, 'gdpr-framework');?>
<?php }?>
</textarea>
<p class="description">
<?= esc_html_x("Leave blank if you don't want a header to get displayed.", '(Admin)', 'gdpr-framework');?>
</p>
