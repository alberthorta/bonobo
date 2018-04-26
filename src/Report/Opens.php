<?php

namespace Alberthorta\Bonobo\Report;

class Opens {
    protected $opens_data;

    /**
     * Opens constructor.
     * @param $opens_data
     */
    public function __construct($opens_data) {
        $this->opens_data = $opens_data;
    }

    /**
     * @return int
     */
    public function getOpensTotal() {
        return $this->opens_data->opens_total;
    }

    /**
     * @return int
     */
    public function getUniqueOpens() {
        return $this->opens_data->unique_opens;
    }

    /**
     * @return float
     */
    public function getOpenRate() {
        return $this->opens_data->open_rate;
    }

    /**
     * @return \DateTime
     */
    public function getLastOpen() {
        return new \DateTime($this->opens_data->last_open);
    }
}