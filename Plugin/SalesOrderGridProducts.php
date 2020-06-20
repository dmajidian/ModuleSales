<?php
namespace Majidian\ModuleSales\Plugin;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;

class SalesOrderGridProducts
{
    private $messageManager;
    private $collection;

    public function __construct(
        MessageManager $messageManager,
        SalesOrderGridCollection $collection
    ) {

        $this->messageManager = $messageManager;
        $this->collection = $collection;
    }

    public function aroundGetReport(
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    ) {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof $this->collection
            ) {
                $select = $this->collection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $this->collection->getTable("sales_order_item")],
                    'main_table.increment_id = secondTable.order_id',
                    ['products']
                );
                return $this->collection;
            }
        }
        return $result;
    }
}
