<?php

class WebninjaCatalogInventory_Model_Stock_Item_Api_V2 extends WebninjaCatalogInventory_Model_Stock_Item_Api
{
    public function update($productId, $data)
    {
        $product = Mage::getModel('catalog/product');

        if ($newId = $product->getIdBySku($productId)) {
            $productId = $newId;
        }

        $product->setStoreId($this->_getStoreId())->load($productId);

        if (! $product->getId()) {
            $this->_fault('not_exists');
        }

        if (! $stockData = $product->getStockData()) {
            $stockData = array();
        }

        if (isset($data->qty)) {
            $stockData['qty'] = $data->qty;
        }

        if (isset($data->is_in_stock)) {
            $stockData['is_in_stock'] = $data->is_in_stock;
        }

        if (isset($data->manage_stock)) {
            $stockData['manage_stock'] = $data->manage_stock;
        }

        if (isset($data->min_sale_qty)) {
            $stockData['min_sale_qty'] = $data->min_sale_qty;
        }

        if (isset($data->use_config_min_sale_qty)) {
            $stockData['use_config_min_sale_qty'] = $data->use_config_min_sale_qty;
        }

        if (isset($data->max_sale_qty)) {
            $stockData['max_sale_qty'] = $data->max_sale_qty;
        }

        if (isset($data->use_config_max_sale_qty)) {
            $stockData['use_config_max_sale_qty'] = $data->use_config_max_sale_qty;
        }

        if (isset($data->enable_qty_increments)) {
            $stockData['enable_qty_increments'] = $data->enable_qty_increments;
        }

        if (isset($data->use_config_enable_qty_increments)) {
            $stockData['use_config_enable_qty_inc'] = $data->use_config_enable_qty_increments;
        }

        if (isset($data->qty_increments)) {
            $stockData['qty_increments'] = $data->qty_increments;
        }

        if (isset($data->use_config_qty_increments)) {
            $stockData['use_config_qty_increments'] = $data->use_config_qty_increments;
        }

        if (isset($data->use_config_manage_stock)) {
            $stockData['use_config_manage_stock'] = $data->use_config_manage_stock;
        }

        if (isset($data->use_config_backorders)) {
            $stockData['use_config_backorders'] = $data->use_config_backorders;
        }

        if (isset($data->backorders)) {
            $stockData['backorders'] = $data->backorders;
        }

        $product->setStockData($stockData);

        try {
            $product->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('not_updated', $e->getMessage());
        }

        return true;
    }
}
