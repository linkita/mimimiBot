<?php

namespace Linkita\BasicBot;

use Telegram;

class MimimiBot
{
    private const RESPONSE_FREQUENCY = 100;

    /** @var Telegram */
    private $telegram;

    /**
     * MimimiBot constructor.
     * @param Telegram $telegram
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    public function run(){

       if ($this->isTimeToTalk()) {
           $this->mimimi();
       }
    }

    private function mimimi()
    {
        $chatId = $this->telegram->ChatID();

        $rawMessage = $this->telegram->Text();
        $data = preg_replace('|[aeiou]|', 'i', $rawMessage);
        $data = preg_replace('|[AEIOU]|', 'I', $data);

        $content = array('chat_id' => $chatId, 'text' => $data);
        $this->telegram->sendMessage($content);
    }

    private function isTimeToTalk()
    {
        $rand = rand(0, 100);
        return $rand > 100 - self::RESPONSE_FREQUENCY;
    }
}
