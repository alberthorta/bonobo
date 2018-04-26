<?php

namespace Alberthorta\Bonobo\MailingList;

class CampaignDefaults {
    protected $campaign_defaults;

    /**
     * CampaignDefaults constructor.
     * @param $campaign_defaults
     */
    public function __construct($campaign_defaults) {
        $this->campaign_defaults = $campaign_defaults;
    }

    /**
     * @return string
     */
    public function getFromName() {
        return $this->campaign_defaults->from_name;
    }

    /**
     * @return string
     */
    public function getFromEmail() {
        return $this->campaign_defaults->from_email;
    }

    /**
     * @return string
     */
    public function getSubject() {
        return $this->campaign_defaults->subject;
    }

    /**
     * @return string
     */
    public function getLanguage() {
        return $this->campaign_defaults->language;
    }
}