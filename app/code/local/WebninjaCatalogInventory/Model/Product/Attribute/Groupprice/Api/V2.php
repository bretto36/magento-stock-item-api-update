<?php
class WebninjaCatalogInventory_Model_Product_Attribute_Groupprice_Api_V2 extends Mage_Catalog_Model_Api_Resource
{
    /**
     * Prepare group prices for save
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $groupPrices
     * @return array
     */
    public function prepareGroupPrices($product, $groupPrices = null)
    {
        if (!is_array($groupPrices)) {
            return null;
        }

        if (!is_array($groupPrices)) {
            $this->_fault('data_invalid', Mage::helper('catalog')->__('Invalid Group Prices'));
        }

        $updateValue = array();
        foreach ($groupPrices as $groupPrice) {
            if (!is_array($groupPrice) || !isset($groupPrice['price'])) {
                $this->_fault('data_invalid', Mage::helper('catalog')->__('Invalid Group Prices'));
            }

            if (!isset($groupPrice['website']) || $groupPrice['website'] == 'all') {
                $groupPrice['website'] = 0;
            } else {
                try {
                    $groupPrice['website'] = Mage::app()->getWebsite($groupPrice['website'])->getId();
                }
                catch ( Mage_Core_Exception $e ) {
                    $groupPrice['website'] = 0;
                }
            }

            if (intval($groupPrice['website']) > 0 && !in_array($groupPrice['website'], $product->getWebsiteIds())) {
                $this->_fault('data_invalid', Mage::helper('catalog')->__('Invalid group prices. The product is not associated to the requested website.'));
            }

            if (!isset($groupPrice['customer_group_id'])) {
                $groupPrice['customer_group_id'] = 'all';
            }

            if ($groupPrice['customer_group_id'] == 'all') {
                $groupPrice['customer_group_id'] = Mage_Customer_Model_Group::CUST_GROUP_ALL;
            }
            $updateValue[] = array(
                'website_id' => $groupPrice['website'],
                'cust_group' => $groupPrice['customer_group_id'],
                'price'      => $groupPrice['price']
            );
        }

        return $updateValue;
    }
}