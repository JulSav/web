<?php
/**
 * User Controller
 *
 * @author Julia Savitskaya
 * @global object $CORE->model
 * @package Model\Main
 */
namespace Model;

class Main
{
    use \Library\Shared;

    public function formsubmitAmbassador(array $data):?array
    {
        $key = 0;
        if ($key == null) {
            throw new \Exception("RESOURCE_LOST");
        }
        $result = null;
        $chat = 833762046;
        $text = "Нова заявка в *Цифрові Амбасадори*:\n" . $data['firstname'] . ' '. $data['secondname']. ', '. $data['position'] . "\n*Зв'язок*: " . $data['phone'] . "\n*Почта*: " . $data['mail'];
        $text = urlencode($text);
        $answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chat&text=$text");
        $answer = json_decode($answer, true);
        $result = ['message' => $answer['result']];
        return $result;
    }

    public function __construct()
    {
    }
}
