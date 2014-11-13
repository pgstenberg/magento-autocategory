<?php
class Stonepath_AutoCategory_Block_Adminhtml_Rule_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("autocategory_form", array("legend"=>Mage::helper("autocategory")->__("Item information")));

	$fieldset->addField("description", "text", array(
						"label" => Mage::helper("autocategory")->__("Description"),
						"name" => "description",
						));
								
						 $fieldset->addField('attribute_id', 'select', array(
						'label'     => Mage::helper('autocategory')->__('Attribute'),
						'values'   => Mage::helper("autocategory")->listAttributes(),
						'name' => 'attribute_id',					
						"class" => "required-entry",
						"onchange" => "refreshSelectableOptions()",
						"required" => true,
						));
						
						 $fieldset->addField('attribute_option_value', 'select', array(
						'label'     => Mage::helper('autocategory')->__('Attribute Option'),
						'name' => 'attribute_option_value',			
						"class" => "required-entry",
						"required" => true,
						));	
										
						 $fieldset->addField('category_id', 'select', array(
						'label'     => Mage::helper('autocategory')->__('Category'),
						'values'   => Mage::helper("autocategory")->listCategories(),
						'name' => 'category_id',					
						"class" => "required-entry",
						"required" => true,
						));
						
					

				if (Mage::getSingleton("adminhtml/session")->getRuleData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getRuleData());
					Mage::getSingleton("adminhtml/session")->setRuleData(null);
				} 
				elseif(Mage::registry("rule_data")) {
				    $form->setValues(Mage::registry("rule_data")->getData());
				}
				return parent::_prepareForm();
		}
}
