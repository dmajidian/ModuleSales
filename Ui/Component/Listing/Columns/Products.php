<?php
namespace Majidian\ModuleSales\Ui\Component\Listing\Columns;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;

class Products extends Column
{
    /** @var OrderRepositoryInterface  */
    private $_orderRepository;
    /** @var SearchCriteriaBuilder  */
    private $_searchCriteria;

    /**
     * Products constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $criteria
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $products = [];
                $order = $this->_orderRepository->get($items["entity_id"]);
                foreach ($order->getAllVisibleItems() as $item) {
                    $products[] = $item->getSku() . '/' . $item->getName();
                }
                $items['products'] = implode(', ', array_unique($products, SORT_STRING));
            }
            unset($products);
        }

        return $dataSource;
    }
}
