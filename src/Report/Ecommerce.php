<?php

namespace Alberthorta\Bonobo\Report;

class Ecommerce {
    protected $ecommerce_data;

    /**
     * Ecommerce constructor.
     * @param $ecommerce_data
     */
    public function __construct($ecommerce_data) {
        $this->ecommerce_data = $ecommerce_data;
    }

    /**
     * @return int
     */
    public function getTotalOrders() {
        return $this->ecommerce_data->total_orders;
    }

    /**
     * @return float
     */
    public function getTotalSpent() {
        return $this->ecommerce_data->total_spent;
    }

    /**
     * @return float
     */
    public function getTotalRevenue() {
        return $this->ecommerce_data->total_revenue;
    }
}