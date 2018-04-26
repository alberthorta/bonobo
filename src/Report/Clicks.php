<?php

namespace Alberthorta\Bonobo\Report;

class Clicks {
    protected $clicks_data;

    /**
     * Clicks constructor.
     * @param $clicks_data
     */
    public function __construct($clicks_data) {
        $this->clicks_data = $clicks_data;
    }

    /**
     * @return int
     */
    public function getClicksTotal() {
        return $this->clicks_data->clicks_total;
    }

    /**
     * @return int
     */
    public function getUniqueClicks() {
        return $this->clicks_data->unique_clicks;
    }

    /**
     * @return int
     */
    public function getUniqueSubscriberClicks() {
        return $this->clicks_data->unique_subscriber_clicks;
    }

    /**
     * @return float
     */
    public function getClickRate() {
        return $this->clicks_data->click_rate;
    }

    /**
     * @return \DateTime
     */
    public function getLastClick() {
        return new \DateTime($this->clicks_data->last_click);
    }
}