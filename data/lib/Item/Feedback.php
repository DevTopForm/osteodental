<?php

namespace App\Item;

use App\File;
use App\Message;
use App\Model;
use App\Node;
use App\Query;
use App\Registry;
use App\Site\Service\Message\Telegram;
use App\Ym;
use PHPMailer\PHPMailer\PHPMailer;

class Feedback extends Model
{

    protected $table = 'result_feedback';
    protected $defaultSorter = 'date';
    protected $defaultOrder = 'DESC';

    protected $fields = [];

    protected function prepareData()
    {
        $this->node = new Node($this->node);
        $this->data = unserialize($this->data);
        $this->html = '';
        foreach ($this->data as $data) {
            if ($data['title'] === "Фото") {
                $fileIds = explode(",", $data['value']);
                $data['value'] = "";
                foreach ($fileIds as $id) {
                    $file = new File($id);
                    $data['value'] .= "<a href='{$file->getLink()}' target='_blank'>$file->src_name</a>  ";
                }
            }

            if (!in_array($data['title'], ["Согласие"])) {
                if ($data['title'] === "Фото") {
                    $this->html .= sprintf('<span>%s: %s</span><br/>', $data['title'], $data['value']);
                    continue;
                }

                if ($data['title'] === "Товар") {
                    if ($data['value']) {
                        $this->html .= sprintf(
                            '<a href="%s" target="_blank">%s</a><br/>',
                            $data['value'],
                            $data['title']
                        );
                    }
                    continue;
                }

                $this->html .= sprintf('%s: %s<br/>', $data['title'], $data['value']);
            }
        }
    }

    protected function getData()
    {
        if(!empty(Query::$request['clientID'])){
            $this->data[] = [
                'title' => 'clientID',
                'value' => Query::$request['clientID'],
            ];

            $this->ym_client_id = Query::$request['clientID'];
        }

        $data = [
            'node' => $this->node->id,
            'date' => empty($this->date) ? time() : $this->date,
            'data' => serialize($this->data),
            'ip' => $this->ip,
            'public' => empty($this->public) ? 0 : 1,
            'spam' => empty($this->spam) ? 0 : 1,
            'ym_client_id' => $this->ym_client_id ?? null,
            'ym_data' => $this->ym_data ?? null,
        ];
        return $data;
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate()
    {
        $valid = true;
        $this->errors = [];
        $this->data = [];
        foreach ($this->fields as $key => $item) {
            $messages = $item->field->validate();
            if (!empty($messages)) {
                $valid = false;
                $this->errors = array_merge($this->errors, $messages);
            }

            if ($item->field->title == 'Адрес' || $item->field->title == "Комментарий" || $item->field->title == "Имя") {
                preg_match('/[a-zA-Z]/', $item->field->getValue(), $matches);

                if (!empty($matches)) {
                    $this->errors = array_merge($this->errors, [new Message('Латиница запрещена')]);
                    $valid = false;
                }
            }

            $linkRegexp = '/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/';
            if (preg_match($linkRegexp, $item->field->getValue())) {
                $this->errors = array_merge($this->errors, [new Message('Ссылки запрещены')]);
                $valid = false;
            }

            if ($item->field->title == 'Телефон') {
                if (!preg_match('/^\+7 \(\d\d\d\) \d\d\d-\d\d-\d\d$/', $item->field->getValue())) {
                    $this->errors = array_merge(
                        $this->errors,
                        [new Message('Заполните телефон по примеру: +7 (111) 111-11-11')]
                    );
                    $valid = false;
                }
            }

            $this->fields[$key]->field = $item->field;
            $this->data[] = [
                'title' => $item->title,
                'value' => strip_tags($item->field->getValue()),
            ];
        }
        return $valid;
    }

    public function notify()
    {
        $this->notifyTelegram();

        $params = $this->node->getParams();
        $settings = Registry::get('settings');
        if (empty($params['email'])) {
            $email = $settings->getSiteParams('email');
        } else {
            $email = $params['email'];
        }
        if (empty($email)) {
            return;
        }


        $site = $settings->getSiteParams('sitename');

        $subject = sprintf('На сайте %s отправлено сообщение с формы обратной связи "%s"', $site, $this->node->title);

        $mail = new PHPMailer();

        $from = $settings->getSiteParams('from_email');
        //$from = 'metalobaza@vh32.timeweb.ru';
        $mail->From = empty($from) ? ("noreply@" . $_SERVER['SERVER_NAME']) : $from;
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', $subject);
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->ContentType = 'text/html';
        $mail->AddAddress($email, $email);

        $template = '
			<html>
				<head><title>%s</title></head>
				<body>
					<h3>%s</h3>
					%s
				</body>
			</html>
		';
        $message = '';
        foreach ($this->fields as $item) {
            if (!empty($item->send)) {
                $message .= sprintf('<p><strong>%s:</strong> %s</p>', $item->title, $item->field->getSpecValue());
            }
        }

        // Распарсим товар
        if (isset($this->catalog_id) && !empty($this->catalog_id)) {
            $message .= '<p><strong>Товар:</strong> ' . $this->catalog_id . '</p>';
        }
        // Распарсим товар

        $content = sprintf($template, $subject, $subject, $message);
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $content));
        $mail->Send();
    }

    public function notifyTelegram()
    {
        $settings = Registry::get('settings');
        $service = new Telegram();
        $arIds = $settings->getSiteParams('chat_id');
        $arIds = explode(',', $arIds);

        $site = $settings->getSiteParams('sitename');
        $subject = sprintf('На сайте %s отправлено сообщение с формы обратной связи "%s"', $site, $this->node->title);
        $message = $subject;
        $message .= '<code>' . PHP_EOL . '</code>';
        foreach ($this->fields as $item) {
            if (!empty($item->send)) {
                $title = $item->title;
                $value = $item->field->getSpecValue();

                if (!$title || !$value) {
                    continue;
                }

                if ($title == 'Телефон') {
                    $value = preg_replace('/[^0-9|+]/', '', $value);
                } elseif ($title == "Товар") {
                    $value = '<a href="https://' . $_SERVER['HTTP_HOST'] . $value . '" target="_blank">Ссылка</a>';
                }

                $msg = sprintf('<b>%s:</b> %s', $title, $value);
                $message .= $msg;
                $message .= '<code>' . PHP_EOL . '</code>';
            }
        }

        if (!empty($this->catalog_id)) {
            $message .= '<b>Товар:</b> <a href="' . $this->catalog_id . '" target="_blank">Ссылка</a>';
            $message .= '<code>' . PHP_EOL . '</code>';
        }
        $message = urlencode($message);

        if (!empty($arIds)) {
            foreach ($arIds as $chat_id) {
                if (!empty($chat_id)) {
                    $service->sendMessage($message, trim($chat_id));
                }
            }
        }
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function initFields()
    {
    }

    public function addYmData(): void
    {
        $data = Ym::getInstance()->getFeedbackSources($this);
        static::simpleSave($this->id, 'ym_data', $data);
    }

    public function getYmData()
    {
        $result = [];
        $data = json_decode($this->ym_data, true);
        if(!empty($data['device'])){
            $result[] = sprintf('<div><b>Устройство</b>: %s</div>', $data['device']);
        }

        if(!empty($data['source'])){
            $result[] = sprintf('<div><b>Источник</b>: %s</div>', $data['source']);
        }

        return implode('<br>', $result);
    }

    protected function insertAction()
    {
        $this->addYmData();
    }
}