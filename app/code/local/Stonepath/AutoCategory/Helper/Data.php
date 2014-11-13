<?php
class Stonepath_AutoCategory_Helper_Data extends Mage_Core_Helper_Abstract
{


	public static function listAttributeOptions(){
		
		$array_attributes = Stonepath_AutoCategory_Helper_Data::listAttributes();

		foreach($array_attributes as $attribute_id => $attribute_label){
			$array_attribute_options[$attribute_id] = Stonepath_AutoCategory_Helper_Data::listOptions($attribute_id);
		}
		
		return $array_attribute_options;
	
	}
	
	public static function listOptions($attribute_id){
		$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_id);
		
		$array_options = array();
		
		
      	foreach ($attribute->getSource()->getAllOptions(true, true) as $instance) {
      		
      		if(($instance['value'] != "") && ($instance['label'] != ""))
            	$array_options[$instance['value']] = $instance['label'];
        }
        
		
		return $array_options;
	}
	
	
	public static function listAttributes(){
		$attributes = Mage::getResourceModel('catalog/product_attribute_collection')->getItems();

		$array_attributes = array();
				
		foreach($attributes as $attribute){
			$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attribute->getName());						
			if ($attribute->usesSource() && $attribute->getData('is_user_defined')) {
				$array_attributes[$attribute->getId()] = $attribute->getFrontend()->getLabel();
			}
		}
	
		return $array_attributes;
	}
	
		
	
	public static function listCategories(){
		$categories = Mage::getModel('catalog/category')
                    	->getCollection()
                    	->addAttributeToSelect('name')
                    	->addAttributeToSelect('id')
                    	->addIsActiveFilter();
		
		foreach($categories as $category){
			$array_categories[$category->getId()] = $category->getData('name');
		}
	
		
		return $array_categories;
	}
	
	
	public static function applyRule($rule_id = null, $product_id = null, $connection_write = null){
	
		/*CREATE CONNECTION IF NO CONNECTION IS PASSED*/
		if(!isset($connection_write))
			$connection_write = Mage::getSingleton('core/resource')->getConnection('core_write');
			
			
		
	
		/*IF PRODUCT IS SPECIFIED BUT NO RULE*/
		if(isset($product_id) && !isset($rule_id)){
		$query ="INSERT IGNORE INTO catalog_category_product (category_id,product_id,position) 
					SELECT stonepath_autocategory_rules.category_id,'".$product_id."','1' FROM stonepath_autocategory_rules, catalog_product_entity_int
					WHERE stonepath_autocategory_rules.attribute_id = catalog_product_entity_int.attribute_id
					AND stonepath_autocategory_rules.attribute_option_value = catalog_product_entity_int.value 
					AND catalog_product_entity_int.entity_id='".$product_id."'";
					
		$delete_query = "DELETE FROM catalog_category_product
							WHERE (catalog_category_product.category_id) 
							IN ((SELECT stonepath_autocategory_rules.category_id FROM stonepath_autocategory_rules)) 
							AND catalog_category_product.product_id = '".$product_id."'";
		
		
		/*IF NEITHER RULE OR PRODUCT IS SPECIFIED*/
		}elseif( !isset($product_id) && !isset($rule_id) ){
			$query ="INSERT IGNORE INTO catalog_category_product (category_id,product_id,position) 
						SELECT stonepath_autocategory_rules.category_id,catalog_product_entity_int.entity_id,'1' 
						FROM stonepath_autocategory_rules, catalog_product_entity_int
						WHERE 
						stonepath_autocategory_rules.attribute_id = catalog_product_entity_int.attribute_id 
						AND stonepath_autocategory_rules.attribute_option_value = catalog_product_entity_int.value";
						
		$delete_query = "DELETE FROM catalog_category_product
							WHERE catalog_category_product.category_id 
							IN (SELECT stonepath_autocategory_rules.category_id FROM stonepath_autocategory_rules)";
					
		/*IF PRODUCT IS NOT SPECIFIED BUT A RULE IS*/			
		}elseif( !isset($product_id) && isset($rule_id) ){
			$query ="INSERT IGNORE INTO catalog_category_product (category_id,product_id,position) 
					SELECT stonepath_autocategory_rules.category_id,catalog_product_entity_int.entity_id,'1' FROM stonepath_autocategory_rules, catalog_product_entity_int
					WHERE stonepath_autocategory_rules.attribute_id = catalog_product_entity_int.attribute_id
					AND stonepath_autocategory_rules.attribute_option_value = catalog_product_entity_int.value
					AND stonepath_autocategory_rules.rule_id='".$rule_id."'";
					
					
			$delete_query = "DELETE FROM catalog_category_product
							WHERE catalog_category_product.category_id 
							IN (SELECT stonepath_autocategory_rules.category_id FROM stonepath_autocategory_rules WHERE stonepath_autocategory_rules.rule_id='".$rule_id."')";
		}
	
	
		/*EXECUTE QUIERY*/
		
		if(Mage::getStoreConfig('autocategory/settings/auto_reverse'))
			$connection_write->query($delete_query);
		
		$connection_write->query($query);
		
	}
	


}
	 