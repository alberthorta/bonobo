<?php

namespace Alberthorta\Bonobo;

class Bonobo {

    const VALID_KEY_PATTERN = "/^[0-9a-f]{32}-(.+)$/";

    protected $api_key;
    protected $data_center;
    protected $guzzleClient;

    protected $auth_data;

    /**
     * @param $mailchimp_api_key
     * @return boo1|string
     */
    public static function isValidKey($mailchimp_api_key) {
        preg_match(static::VALID_KEY_PATTERN, $mailchimp_api_key,$matches);
        if(count($matches)==2) return $matches[1];
        return false;
    }

    /**
     * Bonobo constructor.
     * @param string $mailchimp_api_key
     * @throws Exceptions\NoValidKeyException
     */
    public function __construct($mailchimp_api_key) {
        if(!$this->data_center = static::isValidKey($mailchimp_api_key)) throw new Exceptions\NoValidKeyException();
        $this->guzzleClient = new \GuzzleHttp\Client();
        $this->api_key = $mailchimp_api_key;
        $this->auth();
    }

    /**
     * @param $method
     * @param $url
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws Exceptions\NoValidKeyException
     */
    protected function HttpRequest($method, $url="") {
        $url = $this->getBaseUrl().ltrim($url, "/");
        try {
            return json_decode($this->guzzleClient->request($method, $url, [
                'auth' => ['anystring', $this->getApiKey()],
                'headers' => ['content_type' => 'application/json']
            ])->getBody());
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            throw new Exceptions\NoValidKeyException();
        }
    }

    /**
     * @return string
     */
    protected function getBaseUrl() {
        return "https://{$this->data_center}.api.mailchimp.com/3.0/";
    }

    /**
     * @throws Exceptions\NoValidKeyException
     */
    protected function auth() {
        $this->auth_data = $this->HttpRequest('GET');
    }

    /**
     * Returns the ID associated with this account. Used for things like subscribe forms.
     *
     * @return string
     */
    public function getAccountId() {
        return $this->auth_data->account_id;
    }

    /**
     * Returns the ID associated with the user who owns this API key. If you can login to multiple accounts, this ID
     * will be the same for each account.
     *
     * @return string
     */
    public function getLoginId() {
        return $this->auth_data->login_id;
    }

    /**
     * Returns the name of the account.
     *
     * @return string
     */
    public function getAccountName() {
        return $this->auth_data->account_name;
    }

    /**
     * Returns the email address tied to the account.
     *
     * @return string
     */
    public function getEmail() {
        return $this->auth_data->email;
    }

    /**
     * Returns th first name tied to the account.
     *
     * @return string
     */
    public function getFirstName() {
        return $this->auth_data->first_name;
    }

    /**
     * Returns the last name tied to the account.
     *
     * @return string
     */
    public function getLastName() {
        return $this->auth_data->last_name;
    }

    /**
     * Returns the username tied to the account.
     *
     * @return string
     */
    public function getUsername() {
        return $this->auth_data->username;
    }

    /**
     * Returns the avatar URL.
     *
     * @return string
     */
    public function getAvatarUrl() {
        return $this->auth_data->avatar_url;
    }

    /**
     * Returns the role assigned to the account.
     *
     * @return string
     */
    public function getRole() {
        return $this->auth_data->role;
    }

    /**
     * Returns since when the account is member.
     *
     * @return \DateTime
     */
    public function getMemberSince() {
        return new \DateTime($this->auth_data->member_since);
    }

    /**
     * Returns the current pricing plan type of the account.
     *
     * @return string
     */
    public function getPricingPlanType() {
        return $this->auth_data->pricing_plan_type;
    }

    /**
     * Returns when the account payed for the first time.
     *
     * @return \DateTime
     */
    public function getFirstPayment() {
        return new \DateTime($this->auth_data->first_payment);
    }

    /**
     * Returns the account timezone.
     *
     * @return \DateTimeZone
     */
    public function getAccountTimezone() {
        return new \DateTimeZone($this->auth_data->account_timezone);
    }

    /**
     * Returns the account contact.
     *
     * @return MailingList\Contact
     */
    public function getContact() {
        return new MailingList\Contact($this->auth_data->contact);
    }

    /**
     * Returns if the pro is enabled for the account.
     *
     * @return bool
     */
    public function getProEnabled() {
       return $this->auth_data->pro_enabled;
    }

    /**
     * Returns last account login.
     *
     * @return \DateTime
     */
    public function getLastLogin() {
        return new \DateTime($this->auth_data->last_login);
    }

    /**
     * Returns the total amount of subscribers of the account.
     *
     * @return int
     */
    public function getTotalSubscribers() {
        return $this->auth_data->total_subscribers;
    }

    /**
     * Returns the lists of the account.
     *
     * @return MailingList\MailingList[]
     * @throws Exceptions\NoValidKeyException
     */
    public function getLists() {
        /**
         * @var $lists MailingList\MailingList[]
         */
        $lists = [];
        $lists_response = $this->HttpRequest('GET', 'lists');
        foreach($lists_response->lists as $list) {
            $lists[] = new MailingList\MailingList($list);
        }
        return $lists;
    }

    /**
     * Returns the list of the account filtered by name.
     *
     * @param $name
     * @return MailingList\MailingList[]
     * @throws Exceptions\NoMailingListFound
     * @throws Exceptions\NoValidKeyException
     */
    public function getListsByName($name) {
        $response = array_values(array_map(function($element) {
            return new MailingList\MailingList($element);
        }, array_filter($this->HttpRequest('GET', 'lists')->lists, function($element) use ($name) {
                /* @var $element MailingList\MailingList */
                return $element->name === $name;
            })
        ));

        if(count($response)===0) {
            throw new Exceptions\NoMailingListFound();
        }
        return $response;
    }

    /**
     * @return Report\Report[]
     * @throws Exceptions\NoValidKeyException
     */
    public function getReports() {
        $reports = [];
        $reports_response = $this->HttpRequest('GET', 'reports');
        foreach($reports_response->reports as $report) {
            $reports[] = new Report\Report($report);
        }
        return $reports;
    }

    /**
     * Returns the ApiKey.
     *
     * @return string
     */
    public function getApiKey() {
        return $this->api_key;
    }
}
