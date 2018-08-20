<?php
namespace App\Service\Sipuni;

class Query
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $tree;

    /**
     * @var string
     */
    private $fromNumber;

    /**
     * @var string
     */
    private $toNumber;

    /**
     * @var string
     */
    private $toAnswer;

    /**
     * @var string
     */
    private $anonymous;

    /**
     * @var string
     */
    private $firstTime;

    /**
     * @var string
     */
    private $secret;

    const DELIMITER = "+";

    /**
     * @param string $user
     * @param string $secret
     */
    public function __construct($user, $secret)
    {
        $this->user = $user;
        $this->secret = $secret;

        $this->from = date('d.m.Y', strtotime("-7 day"));
        $this->to = date('d.m.Y');
        $this->type = '0';
        $this->state = '0';
        $this->tree = '';
        $this->fromNumber = '';
        $this->toNumber = '';
        $this->toAnswer = '';
        $this->anonymous = '1';
        $this->firstTime = '0';
    }

    private function getHash()
    {
        $hashString = join(
            self::DELIMITER,
            [
                $this->anonymous,
                $this->firstTime,
                $this->from,
                $this->fromNumber,
                $this->state,
                $this->to,
                $this->toAnswer,
                $this->toNumber,
                $this->tree,
                $this->type,
                $this->user,
                $this->secret
            ]
        );

        return md5($hashString);
    }

    public function getQuery()
    {
        $params = [
            'anonymous' => $this->anonymous,
            'firstTime' => $this->firstTime,
            'from' => $this->from,
            'fromNumber' => $this->fromNumber,
            'state' => $this->state,
            'to' => $this->to,
            'toAnswer' => $this->toAnswer,
            'toNumber' => $this->toNumber,
            'tree' => $this->tree,
            'type' => $this->type,
            'user' => $this->user,
            'hash' => $this->getHash()
        ];

        return http_build_query($params);
    }
}