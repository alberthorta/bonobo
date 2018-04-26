<?php

namespace Alberthorta\Bonobo\MailingList;

class MailingList {
    protected $list_data;

    public function __construct($list_data) {
        $this->list_data = $list_data;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->list_data->id;
    }

    /**
     * @return integer
     */
    public function getWebId() {
        return $this->list_data->web_id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->list_data->name;
    }

    /**
     * @return Contact
     */
    public function getContact() {
        return new Contact($this->list_data->contact);
    }

    /**
     * @return string
     */
    public function getPermissionReminder() {
        return $this->list_data->permission_reminder;
    }

    /**
     * @return bool
     */
    public function getUseArchiveBar() {
        return $this->list_data->use_archive_bar;
    }

    /**
     * @return CampaignDefaults
     */
    public function getCampaignDefaults() {
        return new CampaignDefaults($this->list_data->campaign_defaults);
    }

    /**
     * @return string
     */
    public function getNotifyOnSubscribe() {
        return $this->list_data->notify_on_subscribe;
    }

    /**
     * @return string
     */
    public function getNotifyOnUnsubscribe() {
        return $this->list_data->notify_on_unsubscribe;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated() {
        return new \DateTime($this->list_data->date_created);
    }

    /**
     * @return int
     */
    public function getListRating() {
        return $this->list_data->list_rating;
    }

    /**
     * @return bool
     */
    public function getEmailTypeOption() {
        return $this->list_data->email_type_option;
    }

    /**
     * @return string
     */
    public function getSubscribeUrlShort() {
        return $this->list_data->subscribe_url_short;
    }

    /**
     * @return string
     */
    public function getSubscribeUrlLong() {
        return $this->list_data->subscribe_url_long;
    }

    /**
     * @return string
     */
    public function getBeamerAddress() {
        return $this->list_data->beamer_address;
    }

    /**
     * @return string
     */
    public function getVisibility() {
        return $this->list_data->visibility;
    }

    /**
     * @return bool
     */
    public function getDoubleOptin() {
        return $this->list_data->double_optin;
    }

    /**
     * @return array
     */
    public function getModules() {
        return $this->list_data->modules;
    }

    /**
     * @return MailingListStats
     */
    public function getStats() {
        return new MailingListStats($this->list_data->stats);
    }
}