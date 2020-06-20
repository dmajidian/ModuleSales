<?php
namespace Majidian\ModuleSales\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderGridCollection;
//use Majidian\ModuleSales\Helper\Data as Helper;

class Collection extends OrderGridCollection
{
    protected function _renderFiltersBefore()
    {
       $select = $this->getSelect()->__toString();

        parent::_renderFiltersBefore();
    }
}
