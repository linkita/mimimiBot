<?php

namespace Linkita\BasicBot;

use Telegram;

class MimimiBot
{
    private const RESPONSE_FREQUENCY = 1000;

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

        $data = $this->telegram->Text();
        $data = preg_replace('|[aeou]|', 'i', $data);
        $data = preg_replace('|[AEOU]|', 'I', $data);
        $data = preg_replace('|[áéóúÁÉÓÚÍ]+|', 'í', $data);

        $content = array('chat_id' => $chatId, 'text' => $data);
        $this->telegram->sendMessage($content);
    }

    private function isTimeToTalk()
    {
        $rand = rand(0, 1000);
        return $rand > 1000 - self::RESPONSE_FREQUENCY;
    }
}
