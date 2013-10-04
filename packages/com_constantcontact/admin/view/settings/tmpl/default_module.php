<?php
echo JHtml::_('sliders.start', 'panel-sliders', array('useCookie'=>'1'));
foreach ($this->forms['mod_constantcontact'] as $module) {
    echo JHtml::_('sliders.panel', JText::sprintf('COM_CONSTANTCONTACT_VIEW_SETTINGS_SLIDER_MODULE_TITLE',$module->title, $module->position), 'module-slider-'.$module->id);
    foreach ($module->form->getFieldset('basic') as $field) {
        echo $field->label;
        echo $field->input;
    }
}
echo JHtml::_('sliders.end');
?>
<div class="clr"></div>