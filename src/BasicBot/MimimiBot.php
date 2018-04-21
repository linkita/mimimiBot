<?php

namespace Linkita\BasicBot;

use Telegram;

class MimimiBot
{
    private const RESPONSE_FREQUENCY = 1000;

    private const PING_MESSAGE = 'mimimimi';

    /** @var Telegram */
    private $telegram;

    private $chatId;

    private $message;

    /**
     * MimimiBot constructor.
     * @param Telegram $telegram
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
        $this->chatId = $telegram->ChatID();
        $this->message = $telegram->Text();

    }

    public function run(): void
    {
        if ($this->isTimeToTalk()) {
            $this->mimimi();
        }
    }

    private function mimimi(): void
    {
        $originalText = $this->message;
        $modifiedText = preg_replace('/[aeou]/', 'i', $originalText);
        $modifiedText = preg_replace('/[AEOU]/', 'I', $modifiedText);
        $modifiedText = preg_replace('/[áéóú]/u', 'í', $modifiedText);
        $modifiedText = preg_replace('/[ÁÉÓÚ]/u', 'Í', $modifiedText);
        $modifiedText = preg_replace('/[àèòù]/u', 'ì', $modifiedText);
        $modifiedText = preg_replace('/[ÀÈÒÙ]/u', 'Ì', $modifiedText);
        $modifiedText = preg_replace('/[äëöü]/u', 'ï', $modifiedText);
        $modifiedText = preg_replace('/[ÄËÖÜ]/u', 'Ï', $modifiedText);

        if ($originalText === $modifiedText) {
            return;
        }

        $content = ['chat_id' => $this->chatId, 'text' => $modifiedText];
        $this->telegram->sendMessage($content);
    }

    private function isTimeToTalk(): bool
    {
        if ($this->message === self::PING_MESSAGE) return true;

        $rand = random_int(0, 1000);

        return $rand > 1000 - self::RESPONSE_FREQUENCY;
    }
}
