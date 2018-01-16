<?php

namespace Linkita\Tests\BasicBot;

use Linkita\BasicBot\MimimiBot;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophet;
use Telegram;

class MimimiBotTest extends TestCase
{
    private const DEFAULT_CHAT_ID = 1;

    /**
     * @test
     * @dataProvider getValidTexts
     * @param string $inputText
     * @param string $changedText
     */
    public function validTextsShouldChangeVowelsByI(
        string $inputText,
        string $changedText
    ) {
        /**
         * @var Prophet|Telegram $telegramProphet
         */
        $telegramProphet = $this->prophesize(Telegram::class);
        $telegramProphet->Text()->willReturn($inputText);
        $telegramProphet->ChatID()->willReturn(self::DEFAULT_CHAT_ID);
        $telegramProphet->sendMessage([
            'chat_id' => self::DEFAULT_CHAT_ID,
            'text'    => $changedText,
        ])
            ->shouldBeCalled();

        $telegram = $telegramProphet->reveal();

        $bot = new MimimiBot($telegram);

        $bot->run();
    }

    /**
     * @test
     */
    public function inputTextEqualsChangedTextShouldNotSendMessage()
    {
        $inputText = 'Mississippi';

        /**
         * @var Prophet|Telegram $telegramProphet
         */
        $telegramProphet = $this->prophesize(Telegram::class);
        $telegramProphet->Text()->willReturn($inputText);
        $telegramProphet->ChatID()->willReturn(self::DEFAULT_CHAT_ID);
        $telegramProphet->sendMessage(Argument::type('array'))
            ->shouldNotBeCalled();

        $telegram = $telegramProphet->reveal();

        $bot = new MimimiBot($telegram);

        $bot->run();
    }

    public function getValidTexts()
    {
        return [
            ['aeiou', 'iiiii'],
            ['AEIOU', 'IIIII'],
            ['áéíóú', 'ííííí'],
            ['ÁÉÍÓÚ', 'ÍÍÍÍÍ'],
            ['àèìòù', 'ììììì'],
            ['ÀÈÌÒÙ', 'ÌÌÌÌÌ'],
            ['äëïöü', 'ïïïïï'],
            ['ÄËÏÖÜ', 'ÏÏÏÏÏ'],
            ['Lorem ipsum dolor sit amet', 'Lirim ipsim dilir sit imit'],
            ['Emojis are for losers 💩', 'Imijis iri fir lisirs 💩',],
        ];
    }
}
