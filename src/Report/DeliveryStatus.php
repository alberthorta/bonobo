<?php

namespace Alberthorta\Bonobo\Report;

class DeliveryStatus {
    protected $delivery_status_data;

    /**
     * DeliveryStatus constructor.
     * @param $delivery_status_data
     */
    public function __construct($delivery_status_data) {
        $this->delivery_status_data = $delivery_status_data;
    }

    /**
     * @return bool
     */
    public function getEnabled() {
        return $this->delivery_status_data->enabled;
    }
}