<?php


namespace Base\Util;


class MessageBbCode
{
    public static function parser($message, $edit = false)
    {
        $parser = new Parser(htmlentities($message), $edit);
        return $parser->parser();
    }
    public static function testLengthMessage($message)
    {
        return strlen(preg_replace('/\s/', '', $message));
    }
    public static function renderHtmlToBbCode($message)
    {
        $render = new BBCode\Render($message);
        return $render->renderBbCode();
    }
    public static function parserResume($message, $trimmed = 500)
    {
        $parser = new parserTrimmed($message);
        return $parser->parserTrimmed($trimmed);
    }
}