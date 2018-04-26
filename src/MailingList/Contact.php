<?php

namespace Alberthorta\Bonobo\MailingList;

class Contact {
    protected $data;

    /**
     * Contact constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCompany() {
        return $this->data->company;
    }

    /**
     * @return string
     */
    public function getAddress1() {
        return $this->data->addr1;
    }

    /**
     * @return string
     */
    public function getAddress2() {
        return $this->data->addr2;
    }

    /**
     * @return string
     */
    public function getCity() {
        return $this->data->city;
    }

    /**
     * @return string
     */
    public function getState() {
        return $this->data->state;
    }

    /**
     * @return string
     */
    public function getZip() {
        return $this->data->zip;
    }

    /**
     * @return string
     */
    public function getCountry() {
        return $this->data->country;
    }
}