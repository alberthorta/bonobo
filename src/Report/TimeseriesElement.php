<?php

namespace Alberthorta\Bonobo\Report;

class TimeseriesElement {
    protected $timeseries_element_data;

    /**
     * TimeseriesElement constructor.
     * @param $timeseries_element_data
     */
    public function __construct($timeseries_element_data) {
        $this->timeseries_element_data = $timeseries_element_data;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp() {
        return new \DateTime($this->timeseries_element_data->timestamp);
    }

    /**
     * @return int
     */
    public function getEmailsSent() {
        return $this->timeseries_element_data->emails_sent;
    }

    /**
     * @return int
     */
    public function getUniqueOpens() {
        return $this->timeseries_element_data->unique_opens;
    }

    /**
     * @return int
     */
    public function getRecipientsClicks() {
        return $this->timeseries_element_data->recipients_clicks;
    }
}