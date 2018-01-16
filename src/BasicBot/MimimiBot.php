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

    public function run(): void
    {
        if ($this->isTimeToTalk()) {
            $this->mimimi();
        }
    }

    private function mimimi(): void
    {
        $chatId = $this->telegram->ChatID();

        $originalText = $this->telegram->Text();
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

        $content = ['chat_id' => $chatId, 'text' => $modifiedText];
        $this->telegram->sendMessage($content);
    }

    private function isTimeToTalk(): bool
    {
        $rand = random_int(0, 1000);

        return $rand > 1000 - self::RESPONSE_FREQUENCY;
    }
}
