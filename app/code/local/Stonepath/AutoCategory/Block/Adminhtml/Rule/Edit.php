<?php
	
class Stonepath_AutoCategory_Block_Adminhtml_Rule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "rule_id";
				$this->_blockGroup = "autocategory";
				$this->_controller = "adminhtml_rule";
				
				
				$this->_updateButton("save", "label", Mage::helper("autocategory")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("autocategory")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("autocategory")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);
				$this->_addButton("saveandapply", array(
					"label"     => Mage::helper("autocategory")->__("Save And Apply"),
					"onclick"   => "saveAndApply()",
					"class"     => "save",
				));

				$json_object = json_encode(Mage::helper("autocategory")->listAttributeOptions(),TRUE);

 
				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
							function saveAndApply(){
								editForm.submit($('edit_form').action+'apply/1');
							}
							function refreshSelectableOptions(){	
									
								var e_attribute_id = document.getElementById('attribute_id');
								var e_attribute_option_value = document.getElementById('attribute_option_value');
								
								
								
								var attribute_id = e_attribute_id.options[e_attribute_id.selectedIndex].value;
								
								
    							attribute_options_data = ".json_encode(json_decode($json_object,TRUE)).";
								attribute = attribute_options_data[attribute_id];
								
								//CLEAR SELECT VALUES
    							for(var i=e_attribute_option_value.options.length-1;i>=0;i--)
    							{
        							e_attribute_option_value.remove(i);
    							}
								
								//INSERT NEW VALUES
								var index = 0;
								for (var key in attribute) {
									if (attribute.hasOwnProperty(key)) {
										e_attribute_option_value.options[index]=new Option(attribute[key], key);
										index++;
									}
								}
							}
						";
				
				$this->_formScripts[] = "refreshSelectableOptions();";
				
				if(Mage::registry("rule_data")->getId() != 0){
					$this->_formScripts[] = "
						document.getElementById('attribute_option_value').value = ".Mage::registry("rule_data")->getData('attribute_option_value').";
					";
				}
				
				
		}

		public function getHeaderText()
		{
				if( Mage::registry("rule_data") && Mage::registry("rule_data")->getId() ){

				    return Mage::helper("autocategory")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("rule_data")->getId()));

				} 
				else{

				     return Mage::helper("autocategory")->__("Add Item");

				}
		}
}